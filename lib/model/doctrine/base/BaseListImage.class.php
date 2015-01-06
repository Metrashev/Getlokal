<?php

/**
 * BaseListImage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $list_id
 * @property integer $image_id
 * @property Lists $Lists
 * @property Image $Image
 * 
 * @method integer   getListId()   Returns the current record's "list_id" value
 * @method integer   getImageId()  Returns the current record's "image_id" value
 * @method Lists     getLists()    Returns the current record's "Lists" value
 * @method Image     getImage()    Returns the current record's "Image" value
 * @method ListImage setListId()   Sets the current record's "list_id" value
 * @method ListImage setImageId()  Sets the current record's "image_id" value
 * @method ListImage setLists()    Sets the current record's "Lists" value
 * @method ListImage setImage()    Sets the current record's "Image" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseListImage extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('list_image');
        $this->hasColumn('list_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('image_id', 'integer', null, array(
             'type' => 'integer',
             ));

        $this->option('symfony', array(
             'form' => false,
             'filter' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Lists', array(
             'local' => 'list_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Image', array(
             'local' => 'image_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}