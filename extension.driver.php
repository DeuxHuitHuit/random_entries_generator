<?php
    /*
    Copyrights: Deux Huit Huit 2015
    LICENCE: MIT, http://deuxhuithuit.mit-license.org/
    */

    if(!defined("__IN_SYMPHONY__")) die("<h2>Error</h2><p>You cannot directly access this file</p>");
    require_once(EXTENSIONS . '/random_entries_generator/lib/class.fieldadaptermanager.php');
    require_once(EXTENSIONS . '/random_entries_generator/vendor/autoload.php');
    require_once(EXTENSIONS . '/random_entries_generator/lib/generators/class.textgenerator.php');
    require_once(EXTENSIONS . '/random_entries_generator/lib/generators/class.imagegenerator.php');
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

        public function appendElement(array $context)
        {
            $c = Administration::instance()->getPageCallback();
            if (is_array($c['context']) && $this->mustIncludeButton()) {
                $page = $context['oPage'];
                $section = General::sanitize(isset($c['context']['section_handle']) ? $c['context']['section_handle'] : $c['context'][1]);
                Widget::registerSVGIcon(
                    'random',
                    '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="23.3px" height="23.3px" viewBox="0 0 23.3 23.3"><path fill="currentColor" d="M20.3,23.3H10.1c-1.7,0-3-1.3-3-3V10.1c0-1.7,1.3-3,3-3h10.2c1.7,0,3,1.3,3,3v10.2C23.3,22,22,23.3,20.3,23.3zM10.1,9.1c-0.6,0-1,0.4-1,1v10.2c0,0.6,0.4,1,1,1h10.2c0.6,0,1-0.4,1-1V10.1c0-0.6-0.4-1-1-1H10.1z"/><circle fill="currentColor" cx="11.5" cy="11.8" r="1.2"/><path fill="currentColor" d="M11.5,13.2c-0.8,0-1.4-0.6-1.4-1.4s0.6-1.4,1.4-1.4s1.4,0.6,1.4,1.4S12.2,13.2,11.5,13.2z M11.5,10.9c-0.5,0-0.9,0.4-0.9,0.9s0.4,0.9,0.9,0.9s0.9-0.4,0.9-0.9S12,10.9,11.5,10.9z"/><circle fill="currentColor" cx="18.6" cy="18.9" r="1.2"/><path fill="currentColor" d="M18.6,20.3c-0.8,0-1.4-0.6-1.4-1.4c0-0.8,0.6-1.4,1.4-1.4s1.4,0.6,1.4,1.4C20,19.7,19.3,20.3,18.6,20.3zM18.6,18c-0.5,0-0.9,0.4-0.9,0.9c0,0.5,0.4,0.9,0.9,0.9s0.9-0.4,0.9-0.9C19.5,18.4,19.1,18,18.6,18z"/><circle fill="currentColor" cx="11.5" cy="18.9" r="1.2"/><path fill="currentColor" d="M11.5,20.3c-0.8,0-1.4-0.6-1.4-1.4c0-0.8,0.6-1.4,1.4-1.4s1.4,0.6,1.4,1.4C12.9,19.7,12.2,20.3,11.5,20.3zM11.5,18c-0.5,0-0.9,0.4-0.9,0.9c0,0.5,0.4,0.9,0.9,0.9s0.9-0.4,0.9-0.9C12.4,18.4,12,18,11.5,18z"/><circle fill="currentColor" cx="15" cy="15.3" r="1.2"/><path fill="currentColor" d="M15,16.7c-0.8,0-1.4-0.6-1.4-1.4s0.6-1.4,1.4-1.4s1.4,0.6,1.4,1.4S15.8,16.7,15,16.7z M15,14.4c-0.5,0-0.9,0.4-0.9,0.9s0.4,0.9,0.9,0.9s0.9-0.4,0.9-0.9S15.5,14.4,15,14.4z"/><circle fill="currentColor" cx="18.6" cy="11.8" r="1.2"/><path fill="currentColor" d="M18.6,13.2c-0.8,0-1.4-0.6-1.4-1.4s0.6-1.4,1.4-1.4S20,11,20,11.8S19.3,13.2,18.6,13.2z M18.6,10.9c-0.5,0-0.9,0.4-0.9,0.9s0.4,0.9,0.9,0.9s0.9-0.4,0.9-0.9S19.1,10.9,18.6,10.9z"/><path fill="currentColor" d="M4.3,16.2H2.8C1.2,16.2,0,15,0,13.4V2.8C0,1.2,1.2,0,2.8,0h10.7c1.5,0,2.8,1.2,2.8,2.8v2.7c0,0.6-0.4,1-1,1s-1-0.4-1-1V2.8c0-0.4-0.3-0.8-0.8-0.8H2.8C2.3,2,2,2.3,2,2.8v10.7c0,0.4,0.3,0.8,0.8,0.8h1.6c0.6,0,1,0.4,1,1S4.9,16.2,4.3,16.2z"/><circle fill="currentColor" cx="4.3" cy="4.7" r="1.2"/><path fill="currentColor" d="M4.3,6.1c-0.8,0-1.4-0.6-1.4-1.4c0-0.8,0.6-1.4,1.4-1.4c0.8,0,1.4,0.6,1.4,1.4C5.8,5.4,5.1,6.1,4.3,6.1zM4.3,3.7c-0.5,0-0.9,0.4-0.9,0.9c0,0.5,0.4,0.9,0.9,0.9c0.5,0,0.9-0.4,0.9-0.9C5.3,4.2,4.8,3.7,4.3,3.7z"/><circle fill="currentColor" cx="11.3" cy="4.7" r="1.2"/><path fill="currentColor" d="M11.3,6.1c-0.8,0-1.4-0.6-1.4-1.4c0-0.8,0.6-1.4,1.4-1.4c0.8,0,1.4,0.6,1.4,1.4C12.8,5.4,12.1,6.1,11.3,6.1zM11.3,3.7c-0.5,0-0.9,0.4-0.9,0.9c0,0.5,0.4,0.9,0.9,0.9c0.5,0,0.9-0.4,0.9-0.9C12.3,4.2,11.8,3.7,11.3,3.7z"/><circle fill="currentColor" cx="4.3" cy="11.7" r="1.2"/><path fill="currentColor" d="M4.3,13.1c-0.8,0-1.4-0.6-1.4-1.4c0-0.8,0.6-1.4,1.4-1.4c0.8,0,1.4,0.6,1.4,1.4C5.8,12.4,5.1,13.1,4.3,13.1zM4.3,10.7c-0.5,0-0.9,0.4-0.9,0.9c0,0.5,0.4,0.9,0.9,0.9c0.5,0,0.9-0.4,0.9-0.9C5.3,11.2,4.8,10.7,4.3,10.7z"/></svg>'
                );
                $button = new XMLElement(
                    'a',
                    Widget::SVGIcon('random') . '<span><span>' . __('Create random entry') . '</span></span>',
                    array(
                        'href' => APPLICATION_URL . '/extension/random_entries_generator/create/?s=' . $section,
                        'class' => 'button'
                    )
                );
                $page->insertAction($button, true);
            }
        }

        /* ********* UTILS ******* */

        protected function mustIncludeButton() {
            $c = Administration::instance()->getPageCallback();
            $driver = $c['driver'];
            $page = $c['context']['page'];
            $canInclude = Symphony::Engine()->isLoggedIn() && (
                ($driver == 'publish') ||
                ($driver == 'blueprintssections' && $c['context'][0] == 'edit')
            );
            // Check Limit Section Entries, if it exists
            if ($canInclude && class_exists('LSE', false)) {
                $section = LSE::getSection($c['context']['section_handle']);
                if ($section) {
                    $max = LSE::getMaxEntries($section);
                    $canInclude = $max == 0 || LSE::getTotalEntries($section) < $max;
                }
            }
            return $canInclude;
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
