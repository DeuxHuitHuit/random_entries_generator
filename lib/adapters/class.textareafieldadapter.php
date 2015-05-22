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
    class TextareaFieldAdapter extends FieldAdapter
    {
        public function type()
        {
            return 'textarea';
        }

        public function data($section, $field)
        {
            $size = General::intval($field->get('size'));
            $value = TextGenerator::generate(array(
                'paragraphs' => $size > 0 ? (int)($size / 5) : 1
            ));
            return array(
                'value' => $value,
                'value_formatted' => static::format($field, $value)
            );
        }
    }