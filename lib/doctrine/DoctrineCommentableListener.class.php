<?php

/**
 * Listener for the Timestampable behavior which automatically sets the created
 * and updated columns when a record is inserted and updated.
 *
 * @package     Doctrine
 * @subpackage  Template
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link        www.phpdoctrine.org
 * @since       1.0
 * @version     $Revision$
 * @author      Konsta Vesterinen <kvesteri@cc.hut.fi>
 */
class DoctrineCommantableListener extends Doctrine_Record_Listener
{
    /**
     * Array of timestampable options
     *
     * @var string
     */
    protected $_options = array();

    /**
     * __construct
     *
     * @param string $options 
     * @return void
     */
    public function __construct(array $options = array())
    {
        $this->_options = $options;
    }

    /**
     * Set the created and updated Timestampable columns when a record is inserted
     *
     * @param Doctrine_Event $event
     * @return void
     */
    public function postDelete(Doctrine_Event $event)
    {
      $record = $event->getInvoker();
      
      $this->updateCommentCount($record);
    }
    
    public function postInsert(Doctrine_Event $event)
    {
      $record = $event->getInvoker();
      
      $this->updateCommentCount($record);
    }
    
    protected function updateCommentCount($record)
    {
      $count = $record->getTable()
                        ->createQuery('c')
                        ->where('c.element_id = ?', array($record->getElementId()))
                        ->count();
      
      $element = $record->getElement();
      $element->setCommentCount($count);
      $element->save();
    }
}
