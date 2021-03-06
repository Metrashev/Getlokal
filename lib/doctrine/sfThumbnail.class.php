<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @package    symfony.runtime.addon
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfThumbnail.class.php 2424 2006-10-17 15:07:29Z pookey $
 */

/**
 *
 * This is taken from Harry Fueck's Thumbnail class and 
 * converted for PHP5 strict compliance for use with symfony.
 *
 * @package    symfony.runtime.addon
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfThumbnail.class.php 2424 2006-10-17 15:07:29Z pookey $
 */
class sfThumbnail
{
  /**
  * Maximum width of the thumbnail in pixels
  * @access private
  * @var int
  */
  private $maxWidth;

  /**
  * Maximum height of the thumbnail in pixels
  * @access private
  * @var int
  */
  private $maxHeight;

  /**
  * Whether to scale image to fit thumbnail (true) or
  * strech to fit (false)
  * @access private
  * @var boolean
  */
  private $scale;

  /**
  * Whether to inflate images smaller the the thumbnail
  * @access private
  * @var boolean
  */
  private $inflate;

  /**
  * List of accepted image types based on MIME description
  * @access private
  * @var array
  */
  private $imgTypes;

  /**
  * Stores function names for each image type e.g. imagecreatefromjpeg
  * @access private
  * @var array
  */
  private $imgLoaders;

  /**
  * Stores function names for each image type e.g. imagejpeg
  * @access private
  * @var array
  */
  private $imgCreators;

  /**
  * The source image
  * @access private
  * @var resource
  */
  private $source;

  /**
  * Width of source image in pixels
  * @access private
  * @var int
  */
  private $sourceWidth;

  /**
  * Height of source image in pixels
  * @access private
  * @var int
  */
  private $sourceHeight;

  /**
  * MIME type of source image
  * @access private
  * @var string
  */
  private $sourceMime;

  /**
  * The thumbnail
  * @access private
  * @var resource
  */
  private $thumb;

  /**
  * Width of thumbnail in pixels
  * @access private
  * @var int
  */
  private $thumbWidth;

  /**
  * Height of thumbnail in pixels
  * @access private
  * @var int
  */
  private $thumbHeight;

  /**
  * Image data from call to GetImageSize needed for saveThumb
  * @access private
  * @var resource
  */
  private $imgData;

  /**
   * JPEG output quality
   * @access private
   * @var int
   */
  private $quality;
  
  private $crop;
  
  private $temp;
  
  
  const ccTOPLEFT     = 0;
  const ccTOP         = 1;
  const ccTOPRIGHT    = 2;
  const ccLEFT        = 3;
  const ccCENTRE      = 4;
  const ccCENTER      = 4;
  const ccRIGHT       = 5;
  const ccBOTTOMLEFT  = 6;
  const ccBOTTOM      = 7;
  const ccBOTTOMRIGHT = 8;

  /**
  * Thumbnail constructor
  * @param int (optional) max width of thumbnail
  * @param int (optional) max height of thumbnail
  * @param boolean (optional) if true image scales
  * @param boolean (optional) if true inflate small images
  * @access public
  */
  public function __construct($maxWidth = null, $maxHeight = null, $crop = false, $scale = true, $inflate = true, $quality = 90)
  {
    $this->maxWidth  = $maxWidth;
    $this->maxHeight = $maxHeight;
    $this->scale     = $scale;
    $this->inflate   = $inflate;
    $this->quality   = $quality;
    $this->crop      = $crop;
    
    $this->imgTypes = array('image/jpeg', 'image/png', 'image/gif');
    $this->imgLoaders = array(
      'image/jpeg' => 'imagecreatefromjpeg',
      'image/png'  => 'imagecreatefrompng',
      'image/gif'  => 'imagecreatefromgif',
    );

    $this->imgCreators = array(
      'image/jpeg' => 'imagejpeg',
      'image/png'  => 'imagepng',
      'image/gif'  => 'imagegif',
    );
  }

  /**
  * Loads an image from a file
  * @param string filename (with path) of image
  * @return boolean
  * @access public
  * @throws Exception
  */
  public function loadFile($image)
  {
    $imgData = @GetImageSize($image);

    if (!$imgData)
    {
      throw new Exception("Could not load image $image");
    }

    if (in_array($imgData['mime'], $this->imgTypes))
    {
      $loader = $this->imgLoaders[$imgData['mime']];
	    ini_set("memory_limit","500M");
      $this->source = $loader($image);
      $this->sourceWidth = $imgData[0];
      $this->sourceHeight = $imgData[1];
      $this->sourceMime = $imgData['mime'];
      $this->imgData = $imgData;
      $this->initThumb();

      return true;
    }
    else
    {
      echo 'Image MIME type '.$imgData['mime'].' not supported';
      return false;
      //throw new Exception('Image MIME type '.$imgData['mime'].' not supported');
    }
  }

  /**
  * Loads an image from a string (e.g. database)
  * @param string the image
  * @param mime mime type of the image
  * @return boolean
  * @access public
  * @throws Exception
  */
  function loadData ($image, $mime)
  {
    if (in_array($mime,$this->imgTypes))
    {
      $this->source=imagecreatefromstring($image);
      $this->sourceWidth=imagesx($this->source);
      $this->sourceHeight=imagesy($this->source);
      $this->sourceMime=$mime;

      $this->initThumb();

      return true;
    }
    else
    {
      throw new Exception('Image MIME type '.$mime.' not supported');
    }
  }

  /**
  * Returns the mime type for the thumbnail
  * @return string
  * @access public
  */
  function getMime()
  {
    return $this->sourceMime;
  }

  /**
  * Returns the width of the thumbnail
  * @return int
  * @access public
  */
  function getThumbWidth()
  {
    return $this->thumbWidth;
  }

  /**
  * Returns the height of the thumbnail
  * @return int
  * @access public
  */
  function getThumbHeight()
  {
    return $this->thumbHeight;
  }

  /**
  * Creates the thumbnail
  * @return void
  * @access private
  */
  private function initThumb()
  {
    if ($this->maxWidth > 0)
    {
      $ratioWidth = $this->maxWidth / $this->sourceWidth;
    }
    if ($this->maxHeight > 0)
    {
      $ratioHeight = $this->maxHeight / $this->sourceHeight;
    }

    if ($this->scale)
    {
      if ($this->maxWidth && $this->maxHeight)
      {
        if($this->crop)
          $ratio = ($ratioHeight < $ratioWidth) ? $ratioWidth : $ratioHeight;
        else 
          $ratio = ($ratioHeight > $ratioWidth) ? $ratioWidth : $ratioHeight;
      }
      if ($this->maxWidth xor $this->maxHeight)
      {
        $ratio = (isset($ratioWidth)) ? $ratioWidth : $ratioHeight;
      }
      if ((!$this->maxWidth && !$this->maxHeight) || (!$this->inflate && $ratio > 1))
      {
        $ratio = 1;
      }

      $this->thumbWidth = floor($ratio * $this->sourceWidth);
      $this->thumbHeight = floor($ratio * $this->sourceHeight);
    }
    else
    {
      if (!$ratioWidth || (!$this->inflate && $ratioWidth > 1))
      {
        $ratioHeight = 1;
      }
      if (!$ratioHeight || (!$this->inflate && $ratioHeight > 1))
      {
        $ratioWidth = 1;
      }
      $this->thumbWidth = floor($ratioWidth * $this->sourceWidth);
      $this->thumbHeight = floor($ratioHeight * $this->sourceHeight);
    }

    $this->thumb = imagecreatetruecolor($this->thumbWidth, $this->thumbHeight);

    if ($this->sourceWidth == $this->maxWidth && $this->sourceHeight == $this->maxHeight)
    {
      $this->thumb= $this->source;
    }
    else
    {   
      imagecopyresampled( $this->thumb, $this->source, 0, 0, 0, 0, $this->thumbWidth, $this->thumbHeight, $this->sourceWidth, $this->sourceHeight);
      
      if($this->crop) 
      {
        list($ox, $oy) = $this->_getCopyPosition($this->maxWidth, $this->maxHeight, self::ccTOP );
        $this->temp = imagecreatetruecolor( $this->maxWidth, $this->maxHeight);
        
        imagecopyresampled( $this->temp, $this->thumb, 0, 0, $ox, $oy, $this->maxWidth, $this->maxHeight, $this->maxWidth, $this->maxHeight);
        $this->thumb = $this->temp;
        $this->thumbHeight = $this->maxHeight;
        $this->thumbWidth = $this->maxWidth;
      }
    }
  }

   public function _getCopyPosition($nx, $ny, $position)
    {
        $ox = $this->thumbWidth;
        $oy = $this->thumbHeight;
        
        switch($position) {
            case self::ccTOPLEFT:
                return array(0, 0);
            case self::ccTOP:
                return array(ceil(($ox - $nx) / 2), 0);
            case self::ccTOPRIGHT:
                return array(($ox - $nx), 0);
            case self::ccLEFT:
                return array(0, ceil(($oy - $ny) / 2));
            case self::ccCENTRE:
                return array(ceil(($ox - $nx) / 2), ceil(($oy - $ny) / 4));
            case self::ccRIGHT:
                return array(($ox - $nx), ceil(($oy - $ny) / 2));
            case self::ccBOTTOMLEFT:
                return array(0, ($oy - $ny));
            case self::ccBOTTOM:
                return array(ceil(($ox - $nx) / 2), ($oy - $ny));
            case self::ccBOTTOMRIGHT:
                return array(($ox - $nx), ($oy - $ny));
        }
        
        return array();
    }

  /**
  * Saves the thumbnail to the filesystem
  * @access public 
  * @return void
  */
  public function save($thumbDest, $creatorName = null)
  {
    $creator = $creatorName !== null ? $this->imgCreators[$creatorName] : $this->imgCreators[$this->imgData['mime']];
    if ($creator == 'imagejpeg')
    {
      imagejpeg($this->thumb, $thumbDest, $this->quality);
    }
    else
    {
      $creator($this->thumb, $thumbDest);
    }
  }

  public function freeSource()
  {
    if (is_resource($this->source))
    {
      imagedestroy($this->source);
    }
  }

  public function freeThumb()
  {
    if (is_resource($this->thumb))
    {
      imagedestroy($this->thumb);
    }
  }

  public function freeAll()
  {
    $this->freeSource();
    $this->freeThumb();
  }

  public function __destruct()
  {
    $this->freeAll();
  }
}
