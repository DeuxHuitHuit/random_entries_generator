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
    class MultilingualImageUploadFieldAdapter extends ImageUploadFieldAdapter
    {
        private static $seed = null;

        public function type()
        {
            return 'multilingual_image_upload';
        }

        public function data($section, $field)
        {
            $multingual_values = array();
            foreach (FLang::getLangs() as $lc) {
                $multingual_values[$lc] = parent::data($section, $field);
            }
            $man_lang = FLang::getMainLang();
            $values = array(
                'file' => $multingual_values[$man_lang]['file'],
                'mimetype' => $multingual_values[$man_lang]['mimetype'],
                'size' => $multingual_values[$man_lang]['size'],
                'meta' => $multingual_values[$man_lang]['meta']
            );
            foreach ($multingual_values as $lc => $mv) {
                if (!$values) {
                    continue;
                }
                $values['file-' . $lc] = $mv['file'];
                $values['mimetype-' . $lc] = $mv['mimetype'];
                $values['size-' . $lc] = $mv['size'];
                $values['meta-' . $lc] = $mv['meta'];
            }
            return $values;
        }
    }