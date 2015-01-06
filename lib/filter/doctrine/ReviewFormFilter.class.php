<?php

/**
 * Review filter form.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ReviewFormFilter extends BaseReviewFormFilter {
	public function configure() {
		$this->setWidget ( 'id', new sfWidgetFormFilterInput ( array ('with_empty' => false ) ) );
		$this->setValidator ( 'id', new sfValidatorSchemaFilter ( 'text', new sfValidatorNumber ( array ('required' => false ) ) ) );

		$this->widgetSchema ['first_name'] = new sfWidgetFormFilterInput ( array ('with_empty' => false ) );
		$this->widgetSchema ['last_name'] = new sfWidgetFormFilterInput ( array ('with_empty' => false ) );

		$this->validatorSchema ['first_name'] = new sfValidatorPass ( array ('required' => false ) );
		$this->validatorSchema ['last_name'] = new sfValidatorPass ( array ('required' => false ) );
		
		$this->widgetSchema['city_id'] = new sfWidgetFormDoctrineJQueryAutocompleter(array(
				'model' => 'City',
				'method' => 'getLocation',
				'url' => sfContext::getInstance()
				->getRouting()
				->generate('default', array(
						'module' => 'user_profile',
						'action' => 'autocomplete' ) ),
				'config' => ' {
          		  scrollHeight: 250,
         		  autoFill: false,
          		  cacheLength: 0,
        		  delay: 1,
        		  max: 10,
        		  minChars:0
        		}'
		));
		
		$this->setValidator(
				'city_id',
				new sfValidatorDoctrineChoice(array(
						'required' => false,
						'model' => 'City'
				)
				));

		$this->widgetSchema ['sector'] = new sfWidgetFormFilterInput ( array ('with_empty' => false ) );
		$this->setValidator ( 'sector', new sfValidatorPass ( array ('required' => false ) ) );

		$this->widgetSchema ['cassification'] = new sfWidgetFormFilterInput ( array ('with_empty' => false ) );
		$this->setValidator ( 'cassification', new sfValidatorPass ( array ('required' => false ) ) );

		$this->widgetSchema ['referer'] = new sfWidgetFormChoice ( array ('choices' => $this->getChoices () ) );
		$this->validatorSchema ['referer'] = new sfValidatorChoice ( array ('required' => false, 'choices' => array_keys ( $this->getChoices () ) ) );

		$this->setWidget('text_length', new sfWidgetFormChoice(array(
				'choices' => array('' => 'All', 1 => 'more than 1000 symbols')
		)));
		$this->setValidator('text_length', new sfValidatorChoice(array(
				'required' => false,
				'choices' => array('', 1)
		)));
		
		$this->useFields ( array ('id', 'text', 'first_name', 'last_name', 'city_id', 'recommended_at', 'created_at', 'sector', 'cassification', 'referer', 'text_length' ) );
	}

	protected function getChoices($sector_id = null) {
		$choices = array ();

		$dql = Doctrine_Query::create ()->select ( 'referer' )->from ( 'Review r' )->addGroupBy ( 'referer' );

		$this->rows = $dql->execute ();

		if ($this->rows) {
			$choices[''] = 'All';

			$setParent = false;
			foreach ( $this->rows as $row ) {
				//$choices [$row ['referer']] = $row ['referer'];
				if (!in_array($row['referer'], array('', ' ', 'ios', 'android'))) {
					if (!$setParent) {
						$choices['site'] = 'Site';

						$setParent = true;
					}

					$choices[$row['referer']] = "&nbsp;&nbsp;--" . $row['referer'];
				}
			}

			$setParent = false;
			foreach ($this->rows as $row) {
				if (in_array($row['referer'], array('ios', 'android'))) {
					if (!$setParent) {
						$choices['mobile'] = 'Mobile';
						$setParent = true;
					}

					$choices[$row['referer']] = "&nbsp;&nbsp;--" . $row['referer'];
				}
			}
		}

		return $choices;
	}

	public function buildQuery(array $values) {
		$query = parent::buildQuery ( $values );

		$rootAlias = $query->getRootAlias ();

		if (isset ( $values ['first_name'] ) && $values ['first_name'] ['text']) {
			$query->andWhere ( 'sf.first_name LIKE ?', '%' . $values ['first_name'] ['text'] . '%' );
		}
		if (isset ( $values ['last_name'] ) && $values ['last_name'] ['text']) {
			$query->andWhere ( 'sf.last_name LIKE ?', '%' . $values ['last_name'] ['text'] . '%' );
		}
		if (isset ( $values ['city_id'] ) && $values ['city_id']) {
			$query->andWhere ( 'c.city_id = ?', $values ['city_id'] );
		}

		if ((isset ( $values ['cassification'] ) && $values ['cassification'] ['text']) || (isset ( $values ['sector'] ) && $values ['sector'] ['text'])) {
			$query->leftJoin ( 'c.CompanyClassification cc' )->innerJoin ( 'cc.Classification cs' );
		}
		if (isset ( $values ['cassification'] ) && $values ['cassification'] ['text']) {
			$query->innerJoin ( 'cs.Translation cst' )->addWhere ( 'cst.title like ? or cst.short_title like ? ', array ($values ['cassification'] ['text'] . '%', $values ['cassification'] ['text'] . '%' ) );
		}
		if (isset ( $values ['sector'] ) && $values ['sector'] ['text']) {
			$query->leftJoin ( 'cs.ClassificationSector css' )->innerJoin ( 'css.Sector s' )->innerJoin ( 's.Translation st' )->addWhere ( 'st.title like ?', array ($values ['sector'] ['text'] . '%' ) );
		}

		/*if (isset ( $values ['referer'] )) {
			$query->addWhere ( $rootAlias . '.referer = ?', array ($values ['referer'] ) );
		}*/

		if (isset($values['referer'])) {
			if ($values['referer'] == 'site') {
				$query->andWhereNotIn($rootAlias . '.referer', array('ios', 'android'));
			} else if ($values['referer'] == 'mobile') {
				$query->andWhereIn($rootAlias . '.referer', array('ios', 'android'));
			} else {
				$query->addWhere($rootAlias . '.referer = ?', array($values['referer']));
			}
		}
		if (isset($values['text_length'])) {
			$query->andWhere('CHAR_LENGTH(r.text) > 1000')->orderBy('CHAR_LENGTH(r.text) ASC');
		}

		return $query;
	}
	
	/*public function addTextLengthColumnQuery($query, $field, $value) {
		if ($value['text'] != '') {
			Doctrine::getTable ( 'Review' )->applyTextLengthFilter ( $query, $value['text'] );
		}
	}*/

}
