<?php

/**
 * BaseFacebookReviewGameUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property integer $facebook_review_game_id
 * @property varchar $referer
 * @property integer $points
 * @property varchar $hash
 * @property UserProfile $UserProfile
 * @property FacebookReviewGame $FacebookReviewGame
 * 
 * @method integer                getUserId()                  Returns the current record's "user_id" value
 * @method integer                getFacebookReviewGameId()    Returns the current record's "facebook_review_game_id" value
 * @method varchar                getReferer()                 Returns the current record's "referer" value
 * @method integer                getPoints()                  Returns the current record's "points" value
 * @method varchar                getHash()                    Returns the current record's "hash" value
 * @method UserProfile            getUserProfile()             Returns the current record's "UserProfile" value
 * @method FacebookReviewGame     getFacebookReviewGame()      Returns the current record's "FacebookReviewGame" value
 * @method FacebookReviewGameUser setUserId()                  Sets the current record's "user_id" value
 * @method FacebookReviewGameUser setFacebookReviewGameId()    Sets the current record's "facebook_review_game_id" value
 * @method FacebookReviewGameUser setReferer()                 Sets the current record's "referer" value
 * @method FacebookReviewGameUser setPoints()                  Sets the current record's "points" value
 * @method FacebookReviewGameUser setHash()                    Sets the current record's "hash" value
 * @method FacebookReviewGameUser setUserProfile()             Sets the current record's "UserProfile" value
 * @method FacebookReviewGameUser setFacebookReviewGame()      Sets the current record's "FacebookReviewGame" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseFacebookReviewGameUser extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('facebook_review_game_user');
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('facebook_review_game_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('referer', 'varchar', 255, array(
             'type' => 'varchar',
             'length' => 255,
             ));
        $this->hasColumn('points', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));
        $this->hasColumn('hash', 'varchar', 255, array(
             'type' => 'varchar',
             'length' => 255,
             ));


        $this->index('user_hash', array(
             'fields' => 
             array(
              0 => 'hash',
             ),
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

        $this->hasOne('FacebookReviewGame', array(
             'local' => 'facebook_review_game_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}