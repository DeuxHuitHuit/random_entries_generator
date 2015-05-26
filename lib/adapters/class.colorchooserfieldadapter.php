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
    class ColorChooserFieldAdapter extends FieldAdapter
    {
        public function type()
        {
            return 'colorchooser';
        }

        public function data($section, $field)
        {
            $faker = \Faker\Factory::create();
            return array(
                'value' => $faker->hexcolor,
            );
        }
    }