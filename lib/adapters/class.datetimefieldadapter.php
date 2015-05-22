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
    class DatetimeFieldAdapter extends FieldAdapter
    {
        public function type()
        {
            return 'datetime';
        }

        public function data($section, $field)
        {
            $time = $field->get('time') == 1;
            $range = $field->get('range') == 1;
            $format = $time ? __SYM_DATETIME_FORMAT__ : __SYM_DATE_FORMAT__;
            $now = array(DateTimeObj::get($format));
            $tomorrow = array(DateTimeObj::get($format, 'tomorrow'));
            $data = array(
                'start' => $now,
                'end' => $range ? $tomorrow : $now,
            );
            return $this->processRawFieldData($field, $data);
        }
    }