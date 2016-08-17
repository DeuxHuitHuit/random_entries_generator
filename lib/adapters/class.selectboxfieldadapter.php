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
    class SelectboxFieldAdapter extends FieldAdapter
    {
        public function type()
        {
            return 'select';
        }

        public function data($section, $field)
        {
            $static = $field->get('static_options') != null;
            $options = array();
            if ($static) {
                $options = explode(',', $field->get('static_options'));
            }
            else {
                $fieldId = explode(',', $field->get('dynamic_options'));
                $fieldId = static::random($fieldId);
                if (!Symphony::Database()->tableExists("tbl_entries_data_$fieldId")) {
                    return null;
                }
                $result = Symphony::Database()->fetch("
                    SELECT * 
                        FROM tbl_entries_data_$fieldId
                ");
                if (empty($result)) {
                    return null;
                }
                $maxResult = count($result);
                $randomResult = rand(0,$maxResult);
                if (isset($result[$randomResult]['value'])) {
                    $options[0] = $result[$randomResult]['value'];
                }
                else if (isset($result[$randomResult]['file'])) {
                    $options[0] = $result[$randomResult]['file'];
                }
            }
            
            return array(
                'value' => $options[0],
                'handle' => Lang::createHandle($options[0])
            );
        }
    }