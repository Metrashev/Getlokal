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
class DoctrineListenerClusterStorage extends Doctrine_Record_Listener
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
    public function __construct(array $options)
    {
        $this->_options = $options;
    }

    /**
     * Set the created and updated Timestampable columns when a record is inserted
     *
     * @param Doctrine_Event $event
     * @return void
     */
    public function preSave(Doctrine_Event $event)
    {
      $modified = $event->getInvoker()->getModified();
      
      foreach($this->_options as $name => $field)
      {
        $updatedName = $event->getInvoker()->getTable()->getFieldName($name);
        
        /*if ( isset($modified[$updatedName]) && $event->getInvoker()->get($updatedName)) {
          $event->getInvoker()->set($updatedName, $event->getInvoker()->getFile($name)->save());
        }*/
        
        

        if ( $event->getInvoker()->getFile($name)->isModified() && $event->getInvoker()->get($updatedName)) {
          $event->getInvoker()->set($updatedName, $event->getInvoker()->getFile($name)->save());
          if($field['sizefield_name'])
            $event->getInvoker()->set($field['sizefield_name'], $event->getInvoker()->getFile($name)->getSize());
        }
      }
    }
    
    public function preDelete(Doctrine_Event $event)
    {
      foreach($this->_options as $name => $field)
      {
        $event->getInvoker()->getFile($name)->delete();
      }
    }
    
    public function postHydrate(Doctrine_Event $event)
    {
      if(is_object($event->data))
      {
        foreach($this->_options as $name => $field)
        {
          $filesize = $field['sizefield_name']? $event->data->get($field['sizefield_name']): 0;
          
          $event->data->getFile($name)->setFilename($event->data->get($name), $filesize);
        }
      }
    }
}
