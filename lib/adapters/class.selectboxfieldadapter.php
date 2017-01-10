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
    class SelectboxFieldAdapter extends FieldAdapter
    {
        public function type()
        {
            return 'select';
        }

        public function data($section, $field)
        {
            $static = $field->get('static_options') != null;
            $value = null;
            if ($static) {
                $value = self::random(explode(',', $field->get('static_options')));
            }
            else {
                $fieldId = explode(',', $field->get('dynamic_options'));
                $tblName = static::randomTable($fieldId);
                if (!$tblName) {
                    return null;
                }
                $result = Symphony::Database()->fetch("
                    SELECT *
                        FROM `$tblName`
                        WHERE `entry_id` IS NOT NULL
                        ORDER BY RAND()
                        LIMIT 1
                ");
                if (empty($result)) {
                    return null;
                }
                $result = current($result);
                if (!$result) {
                    return null;
                }
                if (isset($result['value'])) {
                    $value = $result['value'];
                }
                else if (isset($result['file'])) {
                    $value = $result['file'];
                }
                else {
                    $value = current($result);
                }
            }
            
            return array(
                'value' => $value,
                'handle' => Lang::createHandle($value)
            );
        }
    }