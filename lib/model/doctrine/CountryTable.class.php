<?php

/**
 * CountryTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CountryTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object CountryTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Country');
    }

    public static function getCountriesForUserForm()
    {
        return Doctrine_Query::create()
                ->select('*')
                ->from('Country')
                ->addOrderBy('name_en asc')
                ->execute();
    }

    public static function findOrCreate($country) {
        $countryTerm = "{$country}";
        $query = self::getInstance()->createQuery('c')
            ->where('c.name LIKE ? OR c.name_en LIKE ?', array($countryTerm, $countryTerm));

        if ($query->count() > 0) {
            $c = $query->fetchOne();
        } else {
            $c = new Country();

            $partnerClass = getlokalPartner::getLanguageClass();

            $c->setName($country);
            $c->setNameEn(call_user_func(array('Transliterate' . $partnerClass, 'toLatin'), $country));

            $c->save();
        }

        return $c;
    }
    public static function getByAddress($address, $country_id = null)
    {
    
        $tmp = explode(',', $address);
        if(count($tmp) == 1 && count($tmp)>0){
            $search_country = trim(array_shift($tmp));
        }
        elseif(count($tmp)>0){
            $search_country = trim(array_pop($tmp));
        }

        $query = Doctrine::getTable('Country')
                ->createQuery('c')
                ->where('c.name_en = ?', $search_country);

        return $query->fetchOne();
    }

}
