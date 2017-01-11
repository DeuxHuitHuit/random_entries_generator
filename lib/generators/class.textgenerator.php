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
            'paragraphs' => 1,
            'locale' => null,
            'formatter' => null,
            'validator' => null,
        );
        public static function generate($options)
        {
            include TOOLKIT . '/util.validators.php';
            $options = array_merge(self::$defaultOptions, $options);
            $plimit = max(1, General::intval($options['paragraphs']));
            $maxLength = General::intval($options['max-length']);
            $formatter = $options['formatter'];
            $validator = $options['validator'];
            $maxLength = $maxLength < 1 ? mt_rand(256, 1024) * $plimit : $maxLength;
            $faker = FieldAdapter::faker($options['locale']);
            $paragraphs = array();
            $value = null;
            
            // Try to reverse search the validation rule find valid data
            if ($validator) {
                $rule = array_search($validator, $validators);
                if ($rule == 'email') {
                    $value = $faker->email();
                } else if ($rule == 'number') {
                    $value = $faker->randomNumber();
                } else if ($rule == 'URI') {
                    $value = $faker->url();
                }
            }
            
            // If not value found at this point, create paragraphs
            if (!$value) {
                for ($p = 0; $p < $plimit; $p++) {
                    $paragraphs[] = $faker->realText(max(10, ($maxLength / $plimit) + mt_rand(-20, 20)));
                }
                if ($formatter && preg_match('/markdown/i', $formatter)) {
                    $markdown = array(
                        'bold' => array('prefix' => '**', 'suffix' => '**'),
                        'italic' => array('prefix' => '*', 'suffix' => '*'),
                        'link' => array('prefix' => '[', 'suffix' => '](' . $faker->url() . ')'),
                    );
                    $makrdownKeys = array_keys($markdown);
                    foreach ($paragraphs as $i => &$p) {
                        $words = explode(' ', $p);
                        $word = mt_rand(0, count($words) - 1);
                        $m = mt_rand(0, count($makrdownKeys) - 1);
                        $m = $makrdownKeys[$m];
                        $words[$word] = $markdown[$m]['prefix'] . $words[$word] . $markdown[$m]['suffix'];
                        $p = implode(' ', $words);
                    }
                }
                $value = implode(PHP_EOL . PHP_EOL, $paragraphs);
                if ($maxLength > 0 && General::strlen($value) > $maxLength) {
                    $value = General::substr($value, 0, $maxLength);
                }
            }
            return $value;
        }
    }