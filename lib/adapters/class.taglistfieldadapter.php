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
    class TaglistFieldAdapter extends FieldAdapter
    {
        public function type()
        {
            return 'taglist';
        }

        public function data($section, $field)
        {
            $source = current($field->get('pre_populate_source'));
            $value = null;
            if ($source == 'none') {
                $value = null;
            }
            else {
                $fieldId = $source;
                if ($source == 'existing') {
                    $fieldId = $field->get('id');
                }
                else if (is_array($fieldId)) {
                    $fieldId = current($fieldId);
                }
                $result = Symphony::Database()->fetchCol('value', sprintf(
                    "SELECT DISTINCT `value` FROM tbl_entries_data_%d
                        WHERE `value` IS NOT NULL AND LENGTH(`value`) > 0
                        ORDER BY `value` ASC",
                    $fieldId
                ));
                if (is_array($result)) {
                    $value = current($result);
                }
            }
            return array(
                'value' => $value,
                'handle' => Lang::createHandle($value)
            );
        }
    }