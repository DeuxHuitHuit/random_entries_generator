<?php
    /*
    Copyrights: Deux Huit Huit 2015
    LICENCE: MIT http://deuxhuithuit.mit-license.org;
    */
    
    if(!defined("__IN_SYMPHONY__")) die("<h2>Error</h2><p>You cannot directly access this file</p>");
    
    /**
     *
     * @author Deux Huit Huit
     * https://deuxhuithuit.com/
     *
     */
    class UploadFieldAdapter extends FieldAdapter
    {
        private static $seed = null;

        public function type()
        {
            return 'upload';
        }

        public function data($section, $field)
        {
            if (self::$seed == null) {
                self::$seed = time();
            }
            include(TOOLKIT.'/util.validators.php');
            $validator = $field->get('validator');
            $filename = 'file-%s.bin';
            if ($validator == $upload['image']) {
                $filename = 'image-%s.jpg';
            }
            else if ($validator == $upload['document']) {
                $filename = 'document-%s.doc';
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