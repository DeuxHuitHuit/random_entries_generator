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

        public function data($section, $field)
        {
            if (self::$seed == null) {
                self::$seed = time();
            }
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
            $filename = sprintf($filename, self::$seed++);
            $filepath = $field->getFilePath($filename);
            touch($filepath);
            $type = General::getMimeType($filepath);
            return array(
                'file' => $filename,
                'mimetype' => $type,
                'size' => filesize($filepath),
                'meta' => serialize($field->getMetaInfo($filepath, $type))
            );
        }
    }