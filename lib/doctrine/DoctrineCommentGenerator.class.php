<?php

class DoctrineCommentGenerator extends Doctrine_Record_Generator
{
  //protected $_options = array();

  public  function __construct($options)
  {
    $this->addOptions($options);
  }
  
  public function initOptions()
  {
    $builderOptions  = array(
                          'suffix' =>  '.class.php',
                          'baseClassesDirectory' => 'base',
                          'generateBaseClasses' => true,
                          'generateTableClasses' => true,
                          'baseClassName' => 'sfDoctrineRecord'
                         );
            
    $this->setOption('builderOptions', $builderOptions);             
    $this->setOption('className', '%CLASS%Comment');
    $this->setOption('generateFiles', true);
    $this->setOption('generatePath', sfConfig::get('sf_lib_dir').DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.'doctrine');
  }

  public function buildRelation()
  {
    $this->buildForeignRelation('Comments');
    $this->buildLocalRelation('Element');
  }
  
  public  function getRelationLocalKey()
  {
    return 'element_id';
  }

  public function setTableDefinition()
  {
    $this->hasColumn('id', 'integer', null, array('primary'  => true, 'autoincrement' =>  true));
    $this->hasColumn('element_id', 'integer', 4, array(
      'type' => 'integer',
      'notnull' => true,
      'length' => '4',
    ));

    $this->hasColumn('user_id', 'integer', 4, array(
      'type' => 'integer',
      'notnull' => true,
      'length' => '4',
    ));
    
    $this->hasColumn('comment', 'string', 450, array(
      'type' => 'string',
      'notnull' => true,
      'length' => '450',
    ));
    
    $this->hasColumn('moderator_id', 'integer', 4, array(
      'type' => 'integer',
      'length' => '4',
    ));

    $this->addListener(new DoctrineCommantableListener());
    
  }

  public function setUp()
  {
    $this->hasOne('sfGuardUser as sfGuardUser', array(
      'local' => 'user_id',
      'foreign' => 'id',
      'onDelete' => 'CASCADE',
      'onUpdate' => 'CASCADE'
    ));

    $this->hasOne('sfGuardUser as Moderator', array(
      'local' => 'moderator_id',
      'foreign' => 'id',
      'onDelete' => 'CASCADE',
      'onUpdate' => 'CASCADE'
    ));

    $timestampable0 = new Doctrine_Template_Timestampable();
    $this->actAs($timestampable0);
  }
  
  public function generateClassFromTable(Doctrine_Table $table)
  {
    $definition = array(
      'columns'       => $table->getColumns(),
      'tableName'     => $table->getTableName(),
      'actAs'         => $table->getTemplates(),
      'relations'     => $table->getRelations(),
      'generate_once' => true
    );
    
    return $this->generateClass($definition);
  }
  
  public  function addOptions(array  $options)
  {
    $this->_options = Doctrine_Lib::arrayDeepMerge($this->_options, $options);
  }
}
