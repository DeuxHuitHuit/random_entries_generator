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
            $value = $this->generateValue($field);
            return $this->processRawFieldData($field, $value);
        }

        public function generateValue($field, $length = null, $locale = null)
        {
            $size = $field->get('text_size');
            $formatter = $field->get('text_formatter');
            $validator = $field->get('text_validator');
            if ($length == null) {
                $length = General::intval($field->get('text_length'));
            }
            return TextGenerator::generate(array(
                'max-length' => $size == 'single' ? min(mt_rand(20, 60), $length) : $length,
                'paragraphs' => self::$sizes[$size],
                'locale' => $locale,
                'formatter' => $formatter,
                'validator' => $validator,
            ));
        }
    }