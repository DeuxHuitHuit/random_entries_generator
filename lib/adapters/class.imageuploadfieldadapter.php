<?php
    /*
    Copyrights: Deux Huit Huit 2015
    LICENCE: MIT, http://deuxhuithuit.mit-license.org/
    */
    
    if(!defined("__IN_SYMPHONY__")) die("<h2>Error</h2><p>You cannot directly access this file</p>");
    
    /**
     *
     * @author Deux Huit Huit
     * https://deuxhuithuit.com/
     *
     */
    class ImageUploadFieldAdapter extends FieldAdapter
    {
        private static $seed = null;

        public function type()
        {
            return 'image_upload';
        }

        protected function getFilename($field) {
            $validator = $field->get('validator');
            $filename = 'image-%s';
            if (preg_match('/jpe?\??g/i', $validator) == 1) {
                $filename .= '.jpg';
            }
            else if (preg_match('/png/i', $validator) == 1) {
                $filename .= '.png';
            }
            else if (preg_match('/gif/i', $validator) == 1) {
                $filename .= '.gif';
            }
            else if (preg_match('/svg/i', $validator) == 1) {
                $filename .= '.svg';
            }
            else {
                $filename .= '.bmp';
            }
            return sprintf($filename, self::$seed++);
        }

        protected function findValue($field, $value, $default) {
            $min = General::intval($field->get('min_' . $value));
            $max = General::intval($field->get('max_' . $value));
            if ($max > 0) {
                return $max;
            }
            if ($min > 0) {
                return $min;
            }
            return $default;
        }

        public function data($section, $field)
        {
            if (self::$seed == null) {
                self::$seed = time();
            }
            $filename = $this->getFilename($field);
            $filepath = $field->getFilePath($filename);
            touch($filepath);
            $type = General::getMimeType($filepath);
            $width = $this->findValue($field, 'width', 1920);
            $height = $this->findValue($field, 'height', 1080);
            $image = ImageGenerator::generate(array(
                'width' => $width,
                'height' => $height,
                'filepath' => $filepath,
                'type' => $type,
            ));
            if (!$image) {
                throw new Exception("Failed to download random image");
            }
            return array(
                'file' => $filename,
                'mimetype' => $type,
                'size' => filesize($filepath),
                'meta' => serialize($field->getMetaInfo($filepath, $type))
            );
        }
    }