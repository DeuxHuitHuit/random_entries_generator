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
    abstract class FieldAdapter
    {
        abstract function type();
        abstract function data($section, $field);

        protected static final function format($field, $value) {
            if ($field->get('formatter')) {
                $formatter = TextformatterManager::create($field->get('formatter'));
                return $formatter->run($value);
            }
            return $value;
        }
    }