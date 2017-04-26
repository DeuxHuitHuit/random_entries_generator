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
