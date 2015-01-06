<?php

/**
 * ClassificationSlugLogTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ClassificationSlugLogTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object ClassificationSlugLogTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ClassificationSlugLog');
    }

    /**
     * Create a slug log for classification if doesn't exists already and
     * if the slug has been modified
     * @return mixed The new record if created, otherwise false
     */
    public static function createForTranslation($translation)
    {
        $fields = $translation->getModified();
        $oldValues = $translation->getModified(true);

        if (!isset($fields['slug'])) {
            return false;
        }

        $query = self::getInstance()->createQuery('csl')
            ->where('csl.old_slug = ? AND csl.lang = ? AND csl.classification_id = ?', array(
                $fields['slug'], 
                $translation->lang, 
                $translation->id,
            ));
        if ($query->count() == 0) {
            // create the log
            $csl = new ClassificationSlugLog();
            $csl->setClassificationId($translation->id);
            $csl->setLang($translation->lang);
            $csl->setOldSlug($oldValues['slug']);
            $csl->save();

            return $csl;
        }

        return false;
    }

}
