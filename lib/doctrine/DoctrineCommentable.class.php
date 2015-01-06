<?php

/**
 * DoctrineTemplateClusterStorage
 *
 * Easily add custer file storage to your doctrine records
 *
 * @package     Didactic
 * @subpackage  Doctrine
 */
class DoctrineCommentable extends Doctrine_Template
{
    protected $_options = array(
              'credential' => ''
            );
    /**
     * Array of Timestampable options
     *
     * @var string
     */

    public function __construct(array $options = array())
    {
      $this->_options = Doctrine_Lib::arrayDeepMerge($this->_options, $options);
      
      $this->_plugin = new DoctrineCommentGenerator($this->_options);
    }
    /**
     * Set table definition for Commentable behavior
     *
     * @return void
     */
    public function setTableDefinition()
    {
      $this->hasColumn('comment_count', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));
    }
    
    public function setUp()
    {
      $this->hasMany($this->getTable()->getComponentName().'Comment as Comments', array(
              'local' => 'id',
              'foreign' => 'element_id'
          )
      );
      
      $this->_plugin->initialize($this->getTable());
    }
    
    public function getCommentableCredential()
    {
      return $this->_options['credential'];
    }
    
}