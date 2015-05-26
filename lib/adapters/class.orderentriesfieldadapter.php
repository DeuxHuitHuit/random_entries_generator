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
    class OrderEntriesFieldAdapter extends FieldAdapter
    {
        public function type()
        {
            return 'order_entries';
        }

        public function data($section, $field)
        {
            $value = Symphony::Database()->fetchVar("m", 0, "
                SELECT MAX(value) as `m`
                FROM tbl_entries_data_{$field->get('id')}
            ");
            return array(
                'value' => max(0, General::intval($value)) + 1,
            );
        }
    }