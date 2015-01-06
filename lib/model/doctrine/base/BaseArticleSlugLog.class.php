<?php

/**
 * BaseArticleSlugLog
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $article_id
 * @property char $lang
 * @property varchar $old_slug
 * @property Article $Article
 * 
 * @method integer        getArticleId()  Returns the current record's "article_id" value
 * @method char           getLang()       Returns the current record's "lang" value
 * @method varchar        getOldSlug()    Returns the current record's "old_slug" value
 * @method Article        getArticle()    Returns the current record's "Article" value
 * @method ArticleSlugLog setArticleId()  Sets the current record's "article_id" value
 * @method ArticleSlugLog setLang()       Sets the current record's "lang" value
 * @method ArticleSlugLog setOldSlug()    Sets the current record's "old_slug" value
 * @method ArticleSlugLog setArticle()    Sets the current record's "Article" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseArticleSlugLog extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('article_slug_log');
        $this->hasColumn('article_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('lang', 'char', 2, array(
             'type' => 'char',
             'length' => 2,
             ));
        $this->hasColumn('old_slug', 'varchar', 255, array(
             'type' => 'varchar',
             'length' => 255,
             ));

        $this->option('symfony', array(
             'form' => false,
             'filter' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Article', array(
             'local' => 'article_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}