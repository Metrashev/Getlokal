<?php
class CloudStorage {
  
  protected
    $fileName,
    $extension,
    $file_size,
    $path,
    $modified = false,
    $is_new = true,
    $options;
  
  public function __construct(array $options)
  {
    $this->options = $options;
  }
  
  public function __toString()
  {
    return (string) $this->getUrl();
  }
   
  public function setFilename($file, $file_size = null)
  {
    if(!$file) return;
    
    if($file instanceof sfValidatedFile)
    {
      $this->fileName  = $file->getOriginalName();
      $this->path      = $file->getTempName();
      $this->file_size = $file->getSize();
    }
    else
    {
      $this->fileName  = basename($file);
      $this->file_size = $file_size;
    }
    
    $pathInfo       = pathinfo($this->fileName);
    
    $this->fileName = substr($this->cleanUrl($pathInfo['filename']), 0, 200);
    
    if(isset($pathInfo['extension'])) $this->extension = $pathInfo['extension'];
    
    if(isset($this->options['detect_image']) && $this->options['detect_image'])
    {
      if(in_array(strtolower($this->extension), array('jpg', 'gif', 'png', 'bmp')))
      {
        $this->options['is_image'] = true;
      }
    }
  }
  
  public function load($path, $filename)
  {
    $this->fileName  = $path?$filename: basename($filename);
    $this->path      = $path;
    $this->file_size = filesize($path);
    
    $pathInfo       = pathinfo($this->fileName);
    $this->fileName = substr($this->cleanUrl($pathInfo['filename']), 0, 200);
    
    if(isset($pathInfo['extension'])) $this->extension = $pathInfo['extension'];
  }
  
  public function setModified($v)
  {
    $this->modified = ($v? true: false);
  }
  
  public function isModified()
  {
    return $this->modified;
  }
  
  public function isImage()
  {
    return $this->options['is_image'];
  }
  
  public function setOptions(array $options)
  {
    $this->options = $options;
  }
  
  public function setOption($option, $value)
  {
    $this->options[$option] = $value;
  }
  
  public function getOption($option)
  {
    return isset($this->options[$option])? $this->options[$option]: null;
  }
  
  public function getThumb($size = 0)
  {
    if(!$this->isImage()) return null;
    
    return $this->getUrl($size);
  }
  
  public function getUrl($size = null, $absolute = false)
  {
    if(!$this->fileName) return;
    $folder = null;
    if($size !== null)
    {
      $folder = isset($this->options['sizes'][$size])? $this->options['sizes'][$size]: $size;
    }
    
    $path = 'uploads/'. $this->getPath(false). $folder;
    
    return myTools::compute_public_path($this->getDiskname(), $path, $this->extension, $absolute);
  }
  
  public function getFullPath($size = null)
  {
    if(!$this->fileName) return;
    
    $path = $this->getPath(true). ($size !== null? $this->options['sizes'][$size]: '');
    
    return $path.'/'. $this->getDiskname();
  }
  
  public function getDiskname()
  {
    if(!$this->fileName) return;
    
    return $this->fileName. ($this->extension? '.'.$this->extension: '');
  }
  
  public function getFilename()
  {
    if(!$this->fileName) return;
    
    return $this->fileName. ($this->extension? '.'.$this->extension: '');
  }
  
  public function save()
  {
    $this->makeUnique();
    
    if (!is_readable($this->getPath()))
    {
      mkdir($this->getPath(), 0777, true);
      chmod($this->getPath(), 0777);
    }
    
    if($this->options['is_image']) return $this->savePhoto();
    
    copy($this->path, $this->getPath(). $this->getDiskname());

    return $this->getDiskname();
  }
  
  public function savePhoto()
  {
    $this->extension = 'jpg';
    
    $this->makeUnique();
    if (!is_readable($this->getPath()))
    {
      mkdir($this->getPath(), 0777, true);
      chmod($this->getPath(), 0777);
    }
    copy($this->path, $this->getPath(). $this->getDiskname());
    
    foreach ($this->options['sizes'] as $size)
    {
      $directory = $this->getPath(). $size. '/';
      if (!is_readable($directory))
      {
        mkdir($directory, 0777, true);
        chmod($directory, 0777);
      }

      @list($w, $h, $crop) = explode("x", $size);
      
      if(!$h)
      {
        $file_info = getimagesize($this->path);
        $h = $w * ($file_info[1] / $file_info[0]);
        $thumbnail = new sfThumbnail($w, $h, false, true, false);
      }
      elseif(!$w)
      {
        $file_info = getimagesize($this->path);
        $w = $h * ($file_info[0] / $file_info[1]);
        $thumbnail = new sfThumbnail($w, $h, false, true, false);
      }
      else
      {
        if(!isset($crop)) $crop = true;
        
        $thumbnail = new sfThumbnail($w, $h, $crop, true, false);
      }
        
      
      //try{
      if($thumbnail->loadFile($this->path))
        $thumbnail->save($directory. $this->getDiskname(), 'image/jpeg');
        
      $thumbnail->freeAll();
      
      /*} catch(Exception $e)
      {
        
        return;
      }*/
      
    }
    
    return $this->getDiskname();
  }
  
  // Not implemented
  public function delete()
  {
    return 0;
  }
  
  public function getSize()
  {
    return (int) $this->file_size;
  }
  
  public function getSizeKb()
  {
    $size  = $this->getSize();
    $sizes = array("Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
    
    if($size == 0) return 0;

    return (floor($size/pow(1024, ($i = floor(log($size, 1024))))) . $sizes[$i]);
  }
  
  public function getExtension()
  {
    return $this->extension;
  }
  
  private function makeUnique()
  {
    $i = 0;
    $fileName = $this->fileName;
    
    while(is_readable($this->getPath(). $this->getDiskname()))
    {
      $this->fileName = $i. '_'. $fileName;
      $i++;
    }
  }
  
  private function getDate()
  {
    if(!$this->date) $this->date=date('dmy');
    
    return $this->date;
  }
  
  public function getPath($realPath = true)
  {
    $directory = $this->getPrefix($realPath);
    
    foreach($this->options['primes'] as $prime) 
      $directory .= $this->md5Hash($prime). '/';
    
    return $directory;
  }
  
  private function getPrefix($realPath = true)
  {
    $return  = $realPath? sfConfig::get('sf_upload_dir').'/': '';
    $return .= $this->options['prefix']? $this->options['prefix'].'/': '';
    
    return $return;
  }
  
  public function getDiskPath()
  { 
    return $this->path? $this->path: $this->getPath(). $this->getDiskname();
  }
  
  public function getIcon()
  {
    if(!in_array(strtolower($this->getExtension()), array('avi', 'bmp', 'doc', 'docx', 'exe', 'gif', 'htm', 'html', 'jpg', 'mp3', 'pdf', 'pps', 'ppsx', 'ppt', 'pptx', 'rar', 'rtf', 'shs', 'swf', 'txt', 'xls', 'xlsx', 'zip', 'ace')))
    {
      return 'default.gif';
    }
    
    return strtolower($this->getExtension()). '.gif';
  }
  
  private function md5Hash($count = 131)
  {
    return base_convert(substr(md5($this->fileName), 0, 8), 16, 10) % $count;
  }
  
  private function cleanUrl($v)
  {
    $v = trim($v);
    $v = myTools::replaceDiacritics($v);
    $v = myTools::cleanSpecialChars($v);
    $v = preg_replace('/([^[a-zA-Z0-9\s_.]]*)+/', '', $v);
    $v = preg_replace("/^_+/", "", $v);
    $v = preg_replace("/_+$/", "", $v);
    $v = preg_replace("/\s+/", "_", $v);
    $v = trim($v);

    return $v;
  }
}
