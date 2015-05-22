<?php
    /*
    Copyrights: Deux Huit Huit 2015
    LICENCE: MIT, http://deuxhuithuit.mit-license.org/
    */
    
    if(!defined("__IN_SYMPHONY__")) die("<h2>Error</h2><p>You cannot directly access this file</p>");
    require_once(REG_ADAPTERS_DIR . '/class.oembedfieldadapter.php');
    /**
     *
     * @author Deux Huit Huit
     * https://deuxhuithuit.com/
     *
     */
    class MultilingualOembedFieldAdapter extends oembedFieldAdapter
    {
        public function type()
        {
            return 'multilingual_oembed';
        }

        public function data($section, $field)
        {
            $drivers = explode(',', $field->get('driver'));
            $multingual_values = array();
            foreach (FLang::getLangs() as $lc) {
                $url = static::getUrl($drivers);
                if ($url == null) {
                    continue;
                }
                $multingual_values[$lc] = $url;
            }
            return $this->processRawFieldData($field, $multingual_values);
        }
    }