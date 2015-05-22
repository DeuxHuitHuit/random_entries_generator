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
            $status;
            // fix length since we add chars...
            $length = General::intval($field->get('text_length')) - 3;
            $value = $this->generateValue($field, $length);
            $multingual_values = array();
            foreach (FLang::getLangs() as $lc) {
                $multingual_values[$lc] = strtoupper($lc) . ' ' . $value;
            }
            $data = $field->processRawFieldData($multingual_values, $status);
            if ($status != Field::__OK__) {
                return null;
            }
            return $data;
        }
    }