<?php

/**
 * DoctrineTemplateClusterStorage
 *
 * Easily add custer file storage to your doctrine records
 *
 * @package     Didactic
 * @subpackage  Doctrine
 */
class DoctrineClusterStorage extends Doctrine_Template
{
    /**
     * Array of Timestampable options
     *
     * @var string
     */
    protected $_options = array();
    
    protected $defaults = array(
                                'options'       => array('notnull' => false),
                                'alias'         => null,
                                'type'          => 'varchar',
                                'size'          => '255',
                                'prefix'        => '',
                                'is_image'      => false,
                                'sizefield_name'=> false,
                                'crop'          => true,
                                'sizes'         => array(),
                                'primes'        => array(131, 53, 37)
                              );
    
    protected $_files = array();
    
    public function __construct(array $options = array())
    {
      $this->_options = $options;
    }

    /**
     * Set table definition for Timestampable behavior
     *
     * @return void
     */
    public function setTableDefinition()
    {
      foreach($this->_options as $name => $options)
      {
        if(!is_array($options)) $options = array($options);
        
        $options = Doctrine_Lib::arrayDeepMerge($this->defaults, $options);
        
        $this->_options[$name] = $options;
        
        if ($options['alias']) {
            $name .= ' as ' . $options['alias'];
        }
        
        if ($options['sizefield_name'] != false) {
          $this->hasColumn($options['sizefield_name'], 'string', 50, array(
            'type'    => 'string',
            'notnull' => false,
            'length'  => 50,
            'default' => 0
          ));
        }
        
        $this->hasColumn($name, $options['type'], $options['size'], $options['options']);
      }
      
      $this->addListener(new DoctrineListenerClusterStorage($this->_options));
    }
    
    public function getFile($field = null)
    {
      if(!array_key_exists($field, $this->_options))
      {
        $field = array_shift(@array_keys($this->_options));
      }
      
      if(!isset($this->_files[$this->getInvoker()->getOid()][$field]))
      {
        $this->_files[$this->getInvoker()->getOid()][$field] = new CloudStorage($this->_options[$field]);
      }
      
      return $this->_files[$this->getInvoker()->getOid()][$field];
    }
    
    public function setFile($v, $field = null)
    {
      if(!$v instanceof sfValidatedFile) return;
      
      if(!array_key_exists($field, $this->_options))
      {
        $field = array_shift(@array_keys($this->_options));
      }
      
      $this->getFile($field)->setFilename($v);
      $this->getFile($field)->setModified(true);
      
      $this->getInvoker()->set($field, $this->getFile($field)->getDiskname());
      if($this->getInvoker()->getTable()->hasField('file_url')) $this->getInvoker()->set('file_url', '');
    }
}
