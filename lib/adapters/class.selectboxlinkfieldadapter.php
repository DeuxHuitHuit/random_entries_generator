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
            $options = array();
            $fieldId = $field->get('related_field_id');
            if (is_array($fieldId)) {
                $fieldId = static::random($fieldId);
            }
            if (!Symphony::Database()->tableExists("tbl_entries_data_$fieldId")) {
                return null;
            }
            $result = Symphony::Database()->fetch("
                SELECT `entry_id`
                    FROM tbl_entries_data_$fieldId
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