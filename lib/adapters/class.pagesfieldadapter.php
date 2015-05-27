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
    class PagesFieldAdapter extends FieldAdapter
    {
        public function type()
        {
            return 'pages';
        }

        public function data($section, $field)
        {
            $fieldPageType = $field->get('page_types');
            $negate = fieldPages::isFilterNegation($fieldPageType);
            $types = ($negate ? preg_replace('/^not:\s*/i', null, $fieldPageType) : $fieldPageType);
            $andOperation = fieldPages::isAndOperation($types);
            $types = explode(($andOperation ? '+' : ','), $types);
            $types = array_map('trim', $types);
            $types = array_filter($types);
            $page_id = 0;
            $pages = fieldPages::fetchPageByTypes($types, $andOperation, $negate);
            $page = null;
            if (empty($pages)) {
                return null;
            }
            // PageManager returns the page directly
            // if only one is found. This check
            // make sure we are dealing with a indexed array
            // before we call random
            if ($pages !== array_values($pages)) {
                $page = $pages;
            }
            else {
                $page = static::random($pages);
            }
            if (empty($page)) {
                return null;
            }
            // if page is not an array, it's the page ID
            if (!is_array($page)) {
                $page_id = $page;
                $page = PageManager::fetchPageByID($page_id, array('handle', 'title'));
            }
            else {
                $page_id = $page['id'];
            }
            $result = array(
                'title' => array($page['title']),
                'handle' => array($page['handle']),
                'page_id' => array($page_id),
            );
            return $result;
        }
    }