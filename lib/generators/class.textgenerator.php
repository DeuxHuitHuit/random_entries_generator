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
    class TextGenerator
    {
        protected static $defaultOptions = array(
            'max-length' => 0,
            'paragraphs' => 1
        );
        public static function generate($options)
        {
            $options = array_merge($options, self::$defaultOptions, $options);
            $plimit = max(1, General::intval($options['paragraphs']));
            $faker = \Faker\Factory::create();
            $value = $faker->paragraphs($plimit);
            $value = implode(PHP_EOL . PHP_EOL, $value);
            $maxLength = General::intval($options['max-length']);
            if ($maxLength > 0 && General::strlen($value) > $maxLength) {
                $value = General::substr($value, 0, $maxLength);
            }
            return $value;
        }
    }