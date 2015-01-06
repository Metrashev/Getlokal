<?php

  /**
  * ClassificationTable
  *
  * This class has been auto-generated by the Doctrine ORM Framework
  */
class ClassificationTable extends Doctrine_Table
{
    /**
    * Returns an instance of this class.
    *
    * @return object ClassificationTable
    */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Classification');
    }

    public function getTranslatedSlug($slug, $culture = 'en')
    {
        $original = $this->createQuery('s')
            ->innerJoin('s.Translation t')
            ->where('t.slug = ?', $slug)
            ->fetchOne();
        if ($original) {
            return $this->createQuery('s')
                ->innerJoin('s.Translation')
                ->where('s.id = ?', $original->getId())
                ->fetchOne()->Translation[$culture]->slug;
        }

        return false;
    }

    public function doSelectForSlug($slug, $culture= null, $new_culture)
    {
        $obj= $this->findOneBySlugAndCulture($slug, $culture);

        return $this->findOneByIdAndCulture($obj->getId(), $new_culture);
    }

    public function findOneBySlugAndCulture($slug, $culture = null)
    {
        if (!$culture) {
            $culture = sfContext::getInstance()->getUser()->getCulture();
        }
            $q = $this->createQuery('a')
                ->leftJoin('a.Translation t')
                ->andWhere('t.lang = ?', $culture)
                ->andWhere('t.slug = ?', $slug);
        return $q->fetchOne();
    }

    public function findOneByIdAndCulture($id, $culture = null)
    {
        if (!$culture) {
            $culture = sfContext::getInstance()->getUser()->getCulture();
        }
        $q = $this->createQuery('a')
            ->leftJoin('a.Translation t')
            ->andWhere('t.lang = '. '"'.$culture.'"')
            ->andWhere('id = '. $id);

        $obj_array =  $q->fetchArray();

        return $obj_array[0]['Translation'][$culture]['slug'];
    }

    public function findOneBySlug($slug, $culture = null)
    {
        return $this->findOneBySlugAndCulture($slug, $culture);
    }

    static public function applyTitleFilter($query, $value)
    {
        $rootAlias = $query->getRootAlias();
        $query->innerJoin($rootAlias.'.Translation t')
            ->addWhere('t.title LIKE ?', '%'.$value['text'].'%');

        return $query;
    }

    public static function applyKeywordFilter($query, $value)
    {
        $rootAlias = $query->getRootAlias();
        $query->innerJoin($rootAlias . '.Translation t1')
            ->addWhere('t1.keywords like ?', '%' . $value['text'] . '%');
        return $query;
    }

    public static function getAllBySectorId($sector_id, $culture = null)
    {
        if (!$culture) {
            $culture = sfContext::getInstance()->getUser()->getCulture();
        }
        $classifications = self::getInstance()->createQuery('a')
            ->innerJoin('a.ClassificationSector cs')
            ->leftJoin('a.Translation t')
            ->andWhere('t.lang = ?', $culture)
            ->andWhere('cs.sector_id = ?', $sector_id)
            ->execute();
        return $classifications;
    }

    /**
     * Try and find a classification by slug, old_slug or in the slug_log in
     * this exact order
     * @return mixed - `object` If the classification is found, will be returned
     *               - `string` The correct slug to redirect too
     *               - false If not found
     */
    public static function findOneBySlugLog($slug)
    {
        $culture = sfContext::getInstance()->getUser()->getCulture();

        $query = self::getInstance()->createQuery('c')
            ->innerJoin('c.Translation t');

        $c = $query->copy()
            ->where('t.slug = ?', $slug)
            ->andWhere('t.lang = ?', $culture)
            ->andWhere('t.is_active = 0 AND c.status = 1')
            ->fetchOne();
        if ($c) {
            return $c;
        }

        $c = $query->copy()
            ->where('t.old_slug = ?', $slug)
            ->andWhere('t.lang = ?', $culture)
            ->fetchOne();
        if (!$c) {
            // try finding in slug log
            $c = $query->copy()
                ->innerJoin('c.ClassificationSlugLog csl')
                ->where('csl.old_slug = ? AND csl.lang = ?', array($slug, $culture))
                ->fetchOne();
        }

        // return the correct slug to redirect to
        if (!$c) {
            return false;
        }

        return $c->getSlug();
    }

}
