<?php
    /*
    Copyrights: Deux Huit Huit 2015
    LICENCE: MIT, http://deuxhuithuit.mit-license.org/
    */
    
    if(!defined("__IN_SYMPHONY__")) die("<h2>Error</h2><p>You cannot directly access this file</p>");
    require_once(REG_ADAPTERS_DIR . '/class.textboxfieldadapter.php');
    /**
     *
     * @author Deux Huit Huit
     * https://deuxhuithuit.com/
     *
     */
    class MultilingualFieldAdapter extends TextboxFieldAdapter
    {
        public function type()
        {
            return 'multilingual_textbox';
        }

        public function data($section, $field)
        {
            $multingual_values = array();
            foreach (FLang::getLangs() as $lc) {
                // fix length since we add chars...
                $length = General::intval($field->get('text_length')) - strlen($lc) - 1;
                $value = $this->generateValue($field, $length, $lc);
                $multingual_values[$lc] = strtoupper($lc) . ' ' . $value;
            }
            return $this->processRawFieldData($field, $multingual_values);
        }
    }