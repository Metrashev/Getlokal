<?php

/**
 * CompanyLocationTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CompanyLocationTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object CompanyLocationTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('CompanyLocation');
    }

    /**
     * Creates a company location based on address or lat and lng
     * Tries to find the city in db if not specified
     */
    public static function geocode($address = null, $lat = null, $lng = null, Doctrine_Record $city = null)
    {
        if ($city && !empty($address)) {
            $address .= ', ' . $city->getName() . ', ' . $city->getCountry();
        }
        $url = CityTable::geocodeUrl($address, $lat, $lng);
        
        if (is_null($url) && is_null($city)) {
            return null;
        }

        $data = self::getGeocodeData($url);
        
        if (isset($data)) {
            $company_location = new CompanyLocation();
            $company_location->setIsActive(1);
            $notFields = array(
                    'city', 'county', 'country', 'language',
                    'city_en', 'county_en', 'country_en'
            );
            
            foreach ($data as $field => $value) {
                if (in_array($field, $notFields)) {
                    continue;
                }
                $company_location->set($field, $value);
            }
        

        // if city and country are found and current city not set than find the city and country in db or add them
            if (is_null($city)) {
                $city = CityTable::createFromGeocode($data);
            }
            return $company_location;
        }
        return null;
    }

    /**
     * Returns data to go in a CompanyLocation for given url to Google Geocode
     */
    public static function getGeocodeData($query, $lang = true, $dumper = false) {
        $key = 'AIzaSyDE0asQq6qj6DN8UkUXc9uSNabsoBcT_dk';
        $url = "https://maps.googleapis.com/maps/api/geocode/json?{$query}&sensor=false&key={$key}";
        if ($lang === true) {
            $language = 'en';
        } else {
            $language = $lang;
        }
        $url .= "&language={$language}";

        $geocode = json_decode(file_get_contents($url), true);
        
        if ($geocode['status'] != 'OK') {
            sfContext::getInstance()->getLogger()->emerg('Geocoding error: ' . $geocode['status']);
            return null;
        }
        
        sfContext::getInstance()->getLogger()->emerg('GEOCODE: 21');

        // google types mapped to db fields
        $_types = array(
            'street_number' => array('street_number'),
            'street' => array('street_address', 'route'),
            'neighbourhood' => array('neighborhood'),
            // 'building_no' => ,
            // 'floor' => ,
            'appartment' => array('room'),
            'postcode' => array('postal_code'),
            'sublocation' => array(
                'intersection', 'sublocality', 'sublocality_level_1', 'sublocality_level_2',
                'sublocality_level_3', 'sublocality_level_4', 'sublocality_level_5'
            ),
            'city' => array('locality'),
            'county' => array(
                'administrative_area_level_1',
                'administrative_area_level_2',
                'administrative_area_level_3'
            ),
            'country' => array('country')
        );

        $results = $geocode['results'][0];
        $components = $results['address_components'];

        //only for geocoding tests and request param google_results set to true
        if($dumper) {
            return $results;
        }
        //
            
        $data = array(
            'street_type_id' => 6,
            'latitude' => $results['geometry']['location']['lat'],
            'longitude' => $results['geometry']['location']['lng'],
            'full_address' => $results['formatted_address'],
            'accuracy' => 0
        );

        // add exceptions here
        $languageMap = array(
            'gr' => 'el'
        );

        foreach ($components as $c) {
            foreach ($_types as $field => $types) {
                if (array_intersect($types, $c['types'])) {
                    $data['accuracy']++;
                    $data[$field] = $c['long_name'];
                }
                if (in_array('country', $c['types'])) {
                    $data['language'] = strtolower($c['short_name']);
                    if (in_array($data['language'], $languageMap)) {
                        $data['language'] = $languageMap[$data['language']];
                    }
                }
            }
        }
        if (!isset($data['city']) && isset($data['county'])) {
            $data['city'] = $data['county'];
        }

        if ($lang === true && $language != $data['language']) {
            $data_native = self::getGeocodeData($query, $data['language']);
            if (!empty($data_native)) {
                $data = array_merge($data_native, array(
                    'city_en' => $data['city'],
                    'county_en' => (isset($data['county']) ? $data['county'] : null),
                    'country_en' => $data['country'],
                ));
            }
        }
      
        return $data;
    }

}