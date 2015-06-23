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
            'filepath' => '/tmp/image.jpg',
            'type' => 'jpg',
            'url-format' => 'http://placehold.it/%sx%s/%s/%s.%s'
        );

        public static function fixColor($hexColor)
        {
            return str_replace('#', '', $hexColor);
        }

        public static function request($url, $filepath)
        {
            $ch = curl_init($url);
            $fp = fopen($filepath, "w");
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
            curl_setopt( $ch, CURLOPT_HEADER, false );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            curl_setopt( $ch, CURLOPT_USERAGENT, Symphony::Configuration()->get('useragent', 'general'));
            $content = curl_exec( $ch );
            $status = curl_getinfo( $ch );
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $success = $httpCode == 200;
            if ($success) {
                fwrite($fp, $content);
            }
            curl_close( $ch );
            fclose($fp);
            return $success;
        }

        public static function generate($options)
        {
            $value = array();
            $options = array_merge($options, self::$defaultOptions, $options);
            $faker = FieldAdapter::faker();
            $foregroundcolor = static::fixColor($faker->hexcolor);
            $backgroundcolor = static::fixColor($faker->hexcolor);
            $url = sprintf($options['url-format'],
                $options['width'], $options['height'],
                $backgroundcolor, $foregroundcolor,
                $type
            );
            return static::request($url, $options['filepath']);
        }
    }