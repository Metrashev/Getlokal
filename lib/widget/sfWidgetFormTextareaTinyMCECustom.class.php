<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetFormTextareaTinyMCE represents a Tiny MCE widget.
 *
 * You must include the Tiny MCE JavaScript file by yourself.
 *
 * @package    symfony
 * @subpackage widget
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfWidgetFormTextareaTinyMCE.class.php 17192 2009-04-10 07:58:29Z fabien $
 */
class sfWidgetFormTextareaTinyMCECustom extends sfWidgetFormTextarea
{
  /**
   * Constructor.
   *
   * Available options:
   *
   *  * theme:  The Tiny MCE theme
   *  * width:  Width
   *  * height: Height
   *  * config: The javascript configuration
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('theme', 'advanced');
    $this->addOption('width');
    $this->addOption('height');
    $this->addOption('config', '');
  }

  /**
   * @param  string $name        The element name
   * @param  string $value       The value selected in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $textarea = parent::render($name, $value, $attributes, $errors);
	
	if(!in_array($_SERVER["SERVER_ADDR"], array('127.0.0.1', '10.2.1.73'))){
		$httpHost = $_SERVER['HTTP_HOST'];
		$httpHost = str_ireplace('https://', '', $httpHost);
		trim( $httpHost, '/');
		trim( $httpHost, ' ');
    	$_h = explode('.', $httpHost);
    	if(!@strpos($_SERVER['SCRIPT_NAME'], 'backend')){    	
    		$index1 = sizeof($_h)-2;
    		$index2 = sizeof($_h)-1;
    		$host = "{$_h[$index1]}.{$_h[$index2]}";
			$host = "document.domain ='".$host."'";
    	}
	}
    $js = sprintf(<<<EOF
<script type="text/javascript">
  %s
  tinyMCE.init({
    mode:                              "exact",
    elements:                          "%s",
    theme:                             "%s",
    plugins : "jbimages,safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount",
    %s
    %s
    theme_advanced_buttons1 : "forecolor,backcolor,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull",
    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,help,code,|preview",
    theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,advhr,|,ltr,rtl,|,fullscreen",
    theme_advanced_buttons4 : "moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,attribs,|,visualchars,nonbreaking,blockquote,pagebreak,insertimage,jbimages",
    theme_advanced_toolbar_location:   "top",
    theme_advanced_toolbar_align:      "left",
    theme_advanced_statusbar_location: "bottom",
    theme_advanced_resizing:           true,
   	convert_urls : 0,
    relative_urls: false
    %s
  });
</script>
EOF
    ,
	  (@$host)?:"",
      $this->generateId($name),
      $this->getOption('theme'),
      $this->getOption('width')  ? sprintf('width:                             "%spx",', $this->getOption('width')) : '',
      $this->getOption('height') ? sprintf('height:                            "%spx",', $this->getOption('height')) : '',
      $this->getOption('config') ? ",\n".$this->getOption('config') : ''
    );

    return $textarea.$js;
  }
}
