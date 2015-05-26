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
    class ImageGenerator
    {
        protected static $defaultOptions = array(
            'width' => 1920,
            'height' => 1080,
            'filename' => 'image.jpg',
        );
        public static function generate($options)
        {
            $value = array();
            $options = array_merge($options, self::$defaultOptions, $options);
            
        }
    }