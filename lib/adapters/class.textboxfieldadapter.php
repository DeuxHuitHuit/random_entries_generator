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
    class TextboxFieldAdapter extends FieldAdapter
    {
        protected static $sizes = array(
            'single' => 1,
            'small' => 1,
            'medium' => 2,
            'large' => 4,
            'huge' => 6
        );

        public function type()
        {
            return 'textbox';
        }

        public function data($section, $field)
        {
            $status;
            $size = $field->get('text_size');
            $length = General::intval($field->get('text_length'));
            $value = TextGenerator::generate(array(
                'max-length' => $size == 'single' ? min(80, $length) : $length,
                'paragraphs' => self::$sizes[$size]
            ));
            $data = $field->processRawFieldData($value, $status);
            if ($status != Field::__OK__) {
                return null;
            }
            return $data;
        }
    }