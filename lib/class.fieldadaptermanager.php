<?php
    /*
    Copyight: Deux Huit Huit 2015
    LICENCE: MIT http://deuxhuithuit.mit-license.org;
    */
    
    if(!defined("__IN_SYMPHONY__")) die("<h2>Error</h2><p>You cannot directly access this file</p>");
    define('REG_ADAPTERS_DIR', EXTENSIONS . '/random_entries_generator/lib/adapters/');
    require_once(EXTENSIONS . '/random_entries_generator/lib/class.fieldadapter.php');
    /**
     *
     * @author Deux Huit Huit
     * https://deuxhuithuit.com/
     *
     */
    class FieldAdapterManager
    {
        static $managers = array();
        public static function get($type)
        {
            if (empty(self::$managers)) {
                static::load();
            }
            if (!isset(self::$managers[$type])) {
                return null;
            }
            return self::$managers[$type];
        }
        
        public static function load()
        {
            $adapters = General::listStructure(REG_ADAPTERS_DIR, '/class.[a-zA-Z0-9]+adapter.php/', false, 'asc');
            foreach ($adapters['filelist'] as $key => $adapter) {
                $class = basename($adapter);
                try {
                    require_once($adapter);
                    // get class name
                    $class = str_replace(array('class.', '.php'), '', $class);
                    $instance = new $class();
                    self::$managers[$instance->type()] = $instance;
                } catch (Exception $ex) {
                    throw new SymphonyErrorPage($ex->getMessage());
                }
            }
        }
    }