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
    class EntryRelationshipFieldAdapter extends FieldAdapter
    {
        private static $entries = array();

        public function type()
        {
            return 'entry_relationship';
        }

        public function data($section, $field)
        {
            $sections = explode(',', $field->get('sections'));
            if (empty($sections)) {
                return null;
            }
            $count = max(1, General::intval($field->get('min_entries')));
            $entriesIds = array();
            for ($x = 0; $x < $count; $x++) {
                $section = General::intval(static::random($sections));
                $entries = null;
                if (isset(self::$entries[$section])) {
                    $entries = self::$entries[$section];
                }
                else {
                    $entries = EntryManager::fetch(null, $section, null, null, null, null, false, false, null, false);
                    self::$entries[$section] = $entries;
                }
                if (empty($entries)) {
                    continue;
                }
                $entry = self::random($entries);
                $entriesIds[] = $entry['id'];
            }
            return array(
                'entries' => implode(',', $entriesIds),
            );
        }
    }