<?php
    /*
    Copyight: Deux Huit Huit 2015
    LICENCE: MIT http://deuxhuithuit.mit-license.org;
    */
    
    if(!defined("__IN_SYMPHONY__")) die("<h2>Error</h2><p>You cannot directly access this file</p>");
    
    /**
     *
     * @author Deux Huit Huit
     * https://deuxhuithuit.com/
     *
     */
    class extension_random_entries_generator extends Extension
    {

        /**
         * Name of the extension
         * @var string
         */
        const EXT_NAME = 'Random Entries Generator';

        public function getSubscribedDelegates()
        {
            return array(
                array(
                    'page' => '/backend/',
                    'delegate' => 'AdminPagePreGenerate',
                    'callback' => 'appendElement'
                )
            );
        }

        /* ********* DELEGATES ******* */

        public function appendElement($context)
        {
            if ($this->mustIncludeButton()) {
                $page = $context['oPage'];
                $button = new XMLElement('button', __('Create random entry'));
                $page->insertAction($button, true);
            }
        }

        /* ********* UTILS ******* */

        protected function mustIncludeButton() {
            $c = Administration::instance()->getPageCallback();
            $driver = $c['driver'];
            $page = $c['context']['page'];
            return Symphony::Engine()->isLoggedIn() && (
                ($driver == 'publish' && $page == 'index') ||
                ($driver == 'blueprintssections' && $c['context'][0] == 'edit')
            );
        }

        /* ********* INSTALL/UPDATE/UNINSTALL ******* */

        /**
         * Creates the table needed for the settings of the field
         */
        public function install()
        {
            return true;
        }

        /**
         * This method will update the extension according to the
         * previous and current version parameters.
         * @param string $previousVersion
         */
        public function update($previousVersion = false)
        {
            $ret = true;
            return $ret;
        }

        public function uninstall()
        {
            return true;
        }

    }