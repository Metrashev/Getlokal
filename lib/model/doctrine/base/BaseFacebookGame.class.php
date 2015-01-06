<?php

/**
 * BaseFacebookGame
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property varchar $question
 * @property varchar $answer
 * @property varchar $game
 * @property varchar $uid
 * @property integer $party_name_id
 * @property boolean $shared
 * @property UserProfile $UserProfile
 * @property PartyName $PartyName
 * 
 * @method integer      getUserId()        Returns the current record's "user_id" value
 * @method varchar      getQuestion()      Returns the current record's "question" value
 * @method varchar      getAnswer()        Returns the current record's "answer" value
 * @method varchar      getGame()          Returns the current record's "game" value
 * @method varchar      getUid()           Returns the current record's "uid" value
 * @method integer      getPartyNameId()   Returns the current record's "party_name_id" value
 * @method boolean      getShared()        Returns the current record's "shared" value
 * @method UserProfile  getUserProfile()   Returns the current record's "UserProfile" value
 * @method PartyName    getPartyName()     Returns the current record's "PartyName" value
 * @method FacebookGame setUserId()        Sets the current record's "user_id" value
 * @method FacebookGame setQuestion()      Sets the current record's "question" value
 * @method FacebookGame setAnswer()        Sets the current record's "answer" value
 * @method FacebookGame setGame()          Sets the current record's "game" value
 * @method FacebookGame setUid()           Sets the current record's "uid" value
 * @method FacebookGame setPartyNameId()   Sets the current record's "party_name_id" value
 * @method FacebookGame setShared()        Sets the current record's "shared" value
 * @method FacebookGame setUserProfile()   Sets the current record's "UserProfile" value
 * @method FacebookGame setPartyName()     Sets the current record's "PartyName" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseFacebookGame extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('facebook_game');
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('question', 'varchar', 255, array(
             'type' => 'varchar',
             'length' => 255,
             ));
        $this->hasColumn('answer', 'varchar', 255, array(
             'type' => 'varchar',
             'length' => 255,
             ));
        $this->hasColumn('game', 'varchar', 255, array(
             'type' => 'varchar',
             'length' => 255,
             ));
        $this->hasColumn('uid', 'varchar', 255, array(
             'type' => 'varchar',
             'length' => 255,
             ));
        $this->hasColumn('party_name_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('shared', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));

        $this->option('symfony', array(
             'form' => false,
             'filter' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('UserProfile', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('PartyName', array(
             'local' => 'party_name_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}