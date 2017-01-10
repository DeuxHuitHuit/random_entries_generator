<?php
    /*
    Copyrights: Deux Huit Huit 2015-2016
    LICENCE: MIT, http://deuxhuithuit.mit-license.org/
    */
    
    if(!defined("__IN_SYMPHONY__")) die("<h2>Error</h2><p>You cannot directly access this file</p>");
    
    /**
     *
     * @author Deux Huit Huit
     * https://deuxhuithuit.com/
     *
     */
    class SelectboxLinkFieldAdapter extends FieldAdapter
    {
        public function type()
        {
            return 'selectbox_link';
        }

        public function data($section, $field)
        {
            $fieldId = $field->get('related_field_id');
            if (!is_array($fieldId)) {
                return null;
            }
            $tblName = static::randomTable($fieldId);
            if (!$tblName) {
                return null;
            }
            $result = Symphony::Database()->fetch("
                SELECT `entry_id`
                    FROM `$tblName`
                    WHERE `entry_id` IS NOT NULL
                    ORDER BY RAND()
                    LIMIT 1
            ");
            if (empty($result) || !is_array($result) || !is_array($result[0])) {
                return null;
            }
            return array(
                'relation_id' => $result[0]['entry_id'],
            );
        }
    }