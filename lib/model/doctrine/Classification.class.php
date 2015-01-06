<?php

/**
* Classification
*
* This class has been auto-generated by the Doctrine ORM Framework
*
* @package    getLokal
* @subpackage model
* @author     Get Lokal
* @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
*/
class Classification extends BaseClassification
{

    private $old_values = array();

    public function __construct($table = null, $isNewEntry = false)
    {
        parent::__construct($table, $isNewEntry);
    }

    public function findAll($culture = null)
    {
        if (!$culture) {
            $culture = sfContext::getInstance()->getUser()->getCulture();
        }
        return Doctrine_Query::create()
            ->select('id, t.title')
            ->from('Classification c')
            ->leftJoin('c.Translation t')
            ->where('t.lang = ?', $culture)->execute();
    }

    public function getUrla($city)
    {
        return sprintf('@classification?slug=%s&city=%s&sector=%s',
            $this->getSlug(),
            $city,
            $this->getPrimarySector()->getSlug());
    }

    protected function getClassifiers($sector_id = null)
    {
        $choices = array();
        if ($sector_id) {
            $dql = Doctrine_Query::create()
                ->select('id, t.title')
                ->from('Classification c')
                ->innerJoin('c.Translation t')
                ->leftJoin('c.ClassificationSector cs')
                ->where('cs.sector_id = ?', array($sector_id));
        } else {
            $dql = Doctrine_Query::create()
                ->select('id, t.title')
                ->from('Classification c')
                ->innerJoin('c.Translation t')
                ->where('c.status = ?', 1);
        }
        $this->rows = $dql->execute();

        if ($this->rows) {
            foreach($this->rows as $row) {
            $choices[$row['id']] = $row['title'];
            }
        }

        return $choices;
    }

    public function preSave($event)
    {
        if(!$this->isNew()){
            foreach ($this->getTranslation() as $translation) {
                ClassificationSlugLogTable::createForTranslation($translation);
            }
        }

        parent::preSave($event);
    }

}