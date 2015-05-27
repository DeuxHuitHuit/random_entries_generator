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
    class LanguagesFieldAdapter extends FieldAdapter
    {
        public function type()
        {
            return 'languages';
        }

        public function data($section, $field)
        {
            $options = Extension_Languages::findOptions();
            $available_codes = $field->get('available_codes');
            foreach ($options as $idx => $option) {
                if (!in_array($option[0], $available_codes)) {
                    unset($options[$idx]);
                }
            }
            if (empty($options)) {
                return null;
            }
            $value = static::random($options);
            return array(
                'value' => $value[0],
            );
        }
    }