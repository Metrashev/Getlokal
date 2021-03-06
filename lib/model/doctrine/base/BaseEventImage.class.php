<?php

/**
 * BaseEventImage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $event_id
 * @property integer $image_id
 * @property Event $Event
 * @property Image $Image
 * 
 * @method integer    getEventId()  Returns the current record's "event_id" value
 * @method integer    getImageId()  Returns the current record's "image_id" value
 * @method Event      getEvent()    Returns the current record's "Event" value
 * @method Image      getImage()    Returns the current record's "Image" value
 * @method EventImage setEventId()  Sets the current record's "event_id" value
 * @method EventImage setImageId()  Sets the current record's "image_id" value
 * @method EventImage setEvent()    Sets the current record's "Event" value
 * @method EventImage setImage()    Sets the current record's "Image" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEventImage extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('event_image');
        $this->hasColumn('event_id', 'integer', null, array(
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
        $this->hasOne('Event', array(
             'local' => 'event_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Image', array(
             'local' => 'image_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}