<?php

class ZestCMSImages
{
        /**
         * Checks if the Picture Configuration for the given app is ok
         *
         * @param string $app
         */
        public static function checkImageConfig($app) {
                $imageSizes = sfConfig::get('app_'.$app.'_images');

                if (!array_key_exists('original', $imageSizes))
                        throw new Exception('Configuration for images is not ok!');

                foreach ($imageSizes as $imageSizeId => $imageSizeArray) {
                        if (!array_key_exists('path', $imageSizeArray))
                                throw new Exception('ImageConfigurationError: path is missing for image size "'.$imageSizeId.'"');

                        if ($imageSizeId != 'original') {
                                if (!array_key_exists('height', $imageSizeArray) || !is_int($imageSizeArray['height']))
                                        throw new Exception('ImageConfigurationError: height is missing for image size "'.$imageSizeId.'"');
                                if (!array_key_exists('width', $imageSizeArray) || !is_int($imageSizeArray['width']))
                                        throw new Exception('ImageConfigurationError: width is missing for image size "'.$imageSizeId.'"');
                        }

                        if (!file_exists(self::getImagePath($app, $imageSizeId))) {
                                if (!mkdir(self::getImagePath($app, $imageSizeId), 0777, true))
                                        throw new Exception('ImageConfigurationProblem: path for image size could not be created -'. self::getImagePath($app, $imageSizeId));
                        }
                }

                // ako ne sushtestwuwa papkata togawa da se suzdade, ako ne mozhe da se furli exception!
                return true;
        }

        /**
         * Generates thumbnails for the given app and file according to the app's picture settings
         *
         * @param string $app
         * @param string $fileName
         * @param boolean $exact
         */
        public static function createImageThumbnails($app, $fileName, $exact = true) {
                self::checkImageConfig($app);
                
                $pictureSizes = sfConfig::get('app_'.$app.'_images');
                $originalDir = self::getImagePath($app, 'original');
                

                foreach ($pictureSizes as $pictureSizeId => $pictureSizeArray) {
                        if ($pictureSizeId == 'original')
                                continue;

                        $targetDir = self::getImagePath($app, $pictureSizeId);
                        $height = $pictureSizeArray['height'];
                        $width = $pictureSizeArray['width'];
                        $scale = isset($pictureSizeArray['scale']) ? $pictureSizeArray['scale'] : !$exact;
                        $inflate = isset($pictureSizeArray['inflate']) ? $pictureSizeArray['inflate'] : true;
                        $shave = isset($pictureSizeArray['shave']) ? $pictureSizeArray['shave'] : false;
                        $quality = isset($pictureSizeArray['quality']) ? $pictureSizeArray['quality'] : 100;

                        //$thumbnail = new sfThumbnail($width, $height, $scale, $inflate, $quality, 'sfGDAdapter', array());
                        // http://www.symfony-project.org/plugins/sfThumbnailPlugin
                        //$maxWidth = null, $maxHeight = null, $crop = false, $scale = true, $inflate = true, $quality = 90
                        
                        if ($shave) 
                            $thumbnail = new sfMyThumbnail($width, $height, false, $inflate, $quality, 'sfImageMagickAdapter', array('method' => 'shave_all'));
                        else 
                            $thumbnail = new sfMyThumbnail($width, $height, $scale, $inflate, $quality, 'sfGDAdapter', array());
                        //$thumbnail = new sfThumbnail($width, $height,false , false, false, $quality);
                        
                        $thumbnail->loadFile($originalDir.$fileName);
                        $thumbnail->save($targetDir.$fileName);
						//exit();
                        //print_r($targetDir.$fileName);
                }
                        
        }

        /**
         * Deletes the thumbnails for the given app and file according to the app's image settings
         *
         * @param string $app
         * @param string $fileName
         */
        public static function deleteImageThumbnails($app, $fileName) {
                self::checkImageConfig($app);

                $pictureSizes = sfConfig::get('app_'.$app.'_images');

                foreach ($pictureSizes as $pictureSizeId => $pictureSizeArray) {
                        if ($pictureSizeId == 'original')
                                continue;

                        $targetDir = self::getImagePath($app, $pictureSizeId);
                        @unlink($targetDir.$fileName);
                }
        }

        /**
         * Returns the Base-URL to the image
         *
         * @param string $format Format of the image to return path to
         */
        public static function getImageURL( $app, $format = 'original' )
        {
                $res = sfConfig::get('app_'.$app.'_images');
                if (!array_key_exists($format, $res)) {
                        return false;
                }
                return '/uploads/'.$res[$format]['path'].'/';
        }

        /**
         * Returns the file system path to the image
         *
         * @param string $format Format of the image to return path to
         */
        public static function getImagePath( $app, $format = 'original' )
        {
                $res = sfConfig::get('app_'.$app.'_images');
                if (!array_key_exists($format, $res)) {
                        return false;
                }
                return sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.$res[$format]['path'].DIRECTORY_SEPARATOR;
        }

}
