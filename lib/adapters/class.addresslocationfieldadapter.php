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
    class AddressLocationFieldAdapter extends FieldAdapter
    {
        public function type()
        {
            return 'addresslocation';
        }

        public function data($section, $field)
        {
            $lat = static::faker()->latitude;
            $lng = static::faker()->longitude;
            $data = array(
                'street' => static::faker()->streetAddress,
                'city' => static::faker()->city,
                'region' => static::faker()->stateAbbr,
                'postal_code' => static::faker()->postcode,
                'country' => static::faker()->country,
                'neighborhood' => null
            );
            return array(
                'latitude' => $lat,
                'longitude' => $lng,
                'street' => General::sanitize($data['street']),
                'street_handle' => Lang::createHandle($data['street']),
                'city' => General::sanitize($data['city']),
                'city_handle' => Lang::createHandle($data['city']),
                'region' => General::sanitize($data['region']),
                'region_handle' => Lang::createHandle($data['region']),
                'postal_code' => General::sanitize($data['postal_code']),
                'postal_code_handle' => Lang::createHandle($data['postal_code']),
                'country' => General::sanitize($data['country']),
                'country_handle' => Lang::createHandle($data['country']),
                'neighborhood' => $neighborhood,
                'neighborhood_handle' => Lang::createHandle($neighborhood),
                'result_data' => json_encode(array('geometry' => array('lat' => $lat, 'lng' => $lng))),
            );
        }
    }