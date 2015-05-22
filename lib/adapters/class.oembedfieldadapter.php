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
    class oembedFieldAdapter extends FieldAdapter
    {
        private static $randomness = array(
            'YouTube' => array(
                'https://www.youtube.com/watch?v=HPPj6viIBmU',
                'https://www.youtube.com/watch?v=H-qmZ_J7WGc',
                'https://www.youtube.com/watch?v=2QqE4iRTqo0',
            ),
            'Vimeo' => array(
                'https://vimeo.com/128395258',
                'https://vimeo.com/123757684',
                'https://vimeo.com/3631454',
            )
        );
        public function type()
        {
            return 'oembed';
        }
        public static function getUrl($drivers) {
            shuffle(self::$randomness);
            foreach (self::$randomness as $driver => $values) {
                if (in_array($driver, $drivers)) {
                    return $values[array_rand($values, 1)];
                }
            }
            return null;
        }
        public function data($section, $field)
        {
            $url = static::getUrl(explode(',', $field->get('driver')));
            if ($url == null) {
                return null;
            }
            return $this->processRawFieldData($field, $url);
        }
    }