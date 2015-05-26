<?php
    /*
    Copyrights: Deux Huit Huit 2015
    LICENCE: MIT, http://deuxhuithuit.mit-license.org/
    */
    
    if(!defined("__IN_SYMPHONY__")) die("<h2>Error</h2><p>You cannot directly access this file</p>");
    
    /**
     * Abstract FieldAdapter.
     * A FieldAdapter is responsible for creating random data for
     * a specified Field.
     *
     * @author Deux Huit Huit
     * https://deuxhuithuit.com/
     *
     */
    abstract class FieldAdapter
    {
        /**
         * This method should return the type of the field
         * this class adapts for.
         *
         * @return string
         */
        abstract function type();
        /**
         * This method should returns an array of field's data.
         * The array will then be pass to the entry using the `setData`
         * method of the `Entry` instance.
         * The key for this array must match the name of the columns in the
         * database.
         * If you want (and can) reuse the field's logic for data parsing and
         * formatting, @see FieldAdapter::format() and
         * @see FieldAdapter::processRawFieldData()
         *
         * @param Section $section - The section object of this field
         * @param Field $field - The field object for which to create data
         *
         * @return array
         */
        abstract function data($section, $field);

        /**
         *
         */
        public final function generateData($section, $field)
        {
            /**
             * Just prior to generating random data for the $field
             *
             * @delegate EntriesPreCreateRandomData
             * @param string $context
             * '/publish/'
             * @param FieldAdapter $adapter
             * @param Field $field
             * @param Section $section
             */
            Symphony::ExtensionManager()->notifyMembers(
                'EntriesPreCreateRandomData',
                '/publish/',
                array(
                    'adapter' => $this,
                    'field' => &$field,
                    'section' => &$section,
                )
            );
            $result = $this->data($section, $field);
            /**
             * Just after generating random data for the $field
             *
             * @delegate EntriesPostCreateRandomData
             * @param string $context
             * '/publish/'
             * @param FieldAdapter $adapter
             * @param Field $field
             * @param Section $section
             * @param array $result
             */
            Symphony::ExtensionManager()->notifyMembers(
                'EntriesPostCreateRandomData',
                '/publish/',
                array(
                    'adapter' => $this,
                    'field' => &$field,
                    'section' => &$section,
                    'result' => &$result,
                )
            );
            return $result;
        }

        /**
         * If the field has a 'formatter' settings, than we create that formatter
         * and format the $value parameter.
         *
         * @param Field $field - The field object for which to format data
         * @param string $value - The value to format
         *
         * @return string - the formatted value
         */
        protected static final function format($field, $value) {
            if ($field->get('formatter')) {
                $formatter = TextformatterManager::create($field->get('formatter'));
                return $formatter->run($value);
            }
            return $value;
        }

        /**
         * Forwards a call to Field::processRawFieldData using the $value
         * parameter as fake "raw" data. Also checks that the output status
         * is Field::__OK__. Returns null otherwise.
         *
         * @param Field $field - The field object for which to forward the call
         * @param mixed $value - The fake raw data
         *
         */
        protected function processRawFieldData($field, $data)
        {
            $status;
            $data = $field->processRawFieldData($data, $status);
            if ($status != Field::__OK__) {
                return null;
            }
            return $data;
        }
    }