<?php

/**
 * BasePilotVideo
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property string $youtube_key
 * @property Doctrine_Collection $PilotVote
 * 
 * @method string              getName()        Returns the current record's "name" value
 * @method string              getYoutubeKey()  Returns the current record's "youtube_key" value
 * @method Doctrine_Collection getPilotVote()   Returns the current record's "PilotVote" collection
 * @method PilotVideo          setName()        Sets the current record's "name" value
 * @method PilotVideo          setYoutubeKey()  Sets the current record's "youtube_key" value
 * @method PilotVideo          setPilotVote()   Sets the current record's "PilotVote" collection
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePilotVideo extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('pilot_video');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('youtube_key', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('PilotVote', array(
             'local' => 'id',
             'foreign' => 'video_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}