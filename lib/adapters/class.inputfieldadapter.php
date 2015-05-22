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
    class InputFieldAdapter extends FieldAdapter
    {
        public function type()
        {
            return 'input';
        }

        public function data($section, $field)
        {
            return array(
                'value' => 'Lorem hipster',
                'handle' => 'lorem-hipster'
            );
        }
    }