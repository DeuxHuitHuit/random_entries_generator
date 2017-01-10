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
        private static $fakers = array();

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
         * Returns a random value from the $array.
         * If the array is empty, it returns null
         *
         * @param array $array - The array to pick from
         *
         * @return mixed - a value from the array or null
         */
        protected static final function random(array $array)
        {
            if (empty($array)) {
                return null;
            }
            return $array[array_rand($array, 1)];
        }

        /**
         * Returns a not empty random table from the list of fields.
         * If the array is empty, it returns null
         *
         * @param array $fields - The fields to pick from
         *
         * @return string - a table name from the $fields array or null
         */
        protected static final function randomTable(array $fields)
        {
            $tables = array();
            while (!empty($fields)) {
                $fieldId = array_shift($fields);
                $tblName = "tbl_entries_data_$fieldId";
                if (!Symphony::Database()->tableExists($tblName)) {
                    continue;
                }
                $count = (int)Symphony::Database()->fetchVar('c', 0, "SELECT count(*) as `c` FROM `$tblName`");
                if ($count < 1) {
                    continue;
                }
                $tables[$tblName] = $count;
            }
            if (empty($tables)) {
                return null;
            }
            if (max($tables) > 1) {
                $r = rand(1, 100);
                if ($r > 66) {
                    $tables = array_filter($tables, function ($value) {
                        return $value > 1;
                    });
                }
            }
            return static::random(array_keys($tables));
        }

        /**
         * Forwards a call to Field::processRawFieldData using the $value
         * parameter as fake "raw" data. Also checks that the output status
         * is Field::__OK__. Returns null otherwise.
         *
         * @param Field $field - The field object for which to forward the call
         * @param mixed $value - The fake raw data
         *
         * @return array - The processed fake data array
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

        /**
         * Get a Faker from the localized Faker pool.
         * If a Faker does not exist for the desired locale, it will
         * be created. If no $locale value is passed, the current Author
         * locale is used.
         *
         * @param string $locale - The locale for which to find a Faker
         *
         * @return \Faker\Faker - The localized Faker instance
         */
        public static function faker($locale = null)
        {
            if (!$locale) {
                $locale = Symphony::Author()->get('language');
            }
            if (isset(self::$fakers[$locale])) {
                return self::$fakers[$locale];
            }
            $faker = \Faker\Factory::create($locale);
            $faker->seed(mt_rand());
            self::$fakers[$locale] = $faker;
            return $faker;
        }
    }