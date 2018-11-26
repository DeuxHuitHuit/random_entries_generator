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
    class contentExtensionRandom_entries_generatorCreate extends AdministrationPage
    {
        private $result = 'Nothing to do...';
        private $hasErrors = false;
        /**
         * Builds the content view
         */
        public function __viewIndex() {
            $this->createRandomEntries();
            $title = __(extension_random_entries_generator::EXT_NAME);
            $this->setTitle(__('%1$s &ndash; %2$s', array(__('Symphony'), $title)));
            $this->appendSubheading(__($title));
            $wrapper = new XMLELement('fieldset', null, array('class' => 'settings'));
            $wrapper->appendChild(new XMLElement('legend', __('Result')));
            $content = new XMLElement('p', __($this->result));
            if ($this->hasErrors) {
                $content = Widget::Error($content, 'Please try again!');
            }
            $wrapper->appendChild($content);
            $this->Form->appendChild($wrapper);
        }

        protected function createRandomEntries()
        {
            if (isset($_GET['s']) && !empty($_GET['s'])) {
                $s = General::sanitize($_GET['s']);
                $sectionId = 0;
                $authorId = Symphony::Author()->get('id');
                $section = null;
                if (ctype_digit($s)) {
                    $sectionId = General::intval($s);
                }
                else {
                    $sectionId = SectionManager::fetchIDFromHandle($s);
                }
                if (!!$sectionId) {
                    $section = (new SectionManager)
                        ->select()
                        ->section($sectionId)
                        ->execute()
                        ->next();
                }
                if (!$section || empty($section)) {
                    $this->result = sprintf('Section `<code>%s</code>` not found.', $s);
                    $this->hasErrors = true;
                    return;
                }
                $fields = $section->fetchFields();
                $entry = EntryManager::create();
                $entry->set('author_id', $authorId);
                $entry->set('section_id', $sectionId);
                foreach ($fields as $field) {
                    $adapter = FieldAdapterManager::get($field->get('type'));
                    if (!$adapter) {
                        continue;
                    }
                    $entry->setData($field->get('id'), $adapter->generateData($section, $field));
                }
                if (!$entry->commit()) {
                    throw new Exception('Could not commit entry!');
                }
                redirect(sprintf('%s/publish/%s/edit/%s/created/', APPLICATION_URL, $section->get('handle'), $entry->get('id')));
                die;
            }
        }
    }
