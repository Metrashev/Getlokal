<?php

/**
 * widget actions.
 *
 * @package    getLokal
 * @subpackage widget
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class widgetActions extends sfActions
{

  public function executePlace(sfWebRequest $request)
  {
    $this->getResponse()->setSlot('body_class', 'place');

    $this->company = Doctrine::getTable('Company')->createQuery('c')
      ->leftJoin('c.Image i')
      ->where('c.id = ?', $request->getParameter('id'))
      ->andWhere('c.status = ?', CompanyTable::VISIBLE)
      // ->andWhere('i.id = c.image_id')
      ->fetchOne();

    $this->forward404Unless($this->company);
  }

  public function executeEvents(sfWebRequest $request)
  {
    $this->getResponse()->setSlot('body_class', 'events');

    $start_date = date('Y-m-d');

    $city = $request->getParameter('city', getlokalPartner::getDefaultCity());
    $query = Doctrine::getTable('Event')->createQuery('e')
      ->innerJoin('e.Translation t')
      ->leftJoin('e.EventPage ep')
      ->leftJoin('ep.CompanyPage cp')
      ->leftJoin('cp.Company co')
      ->leftJoin('e.Image i')
      ->where('e.location_id = ?', $city)
      ->addWhere('e.start_at >= ?', $start_date)
      ->orderBy('e.recommended DESC')
      ->orderBy('e.start_at')
      ->limit(20);

    if ($category = $request->getParameter('category')) {
      $originalQ = $query->copy();
      if (strstr($category, ',')) {
        $categories = explode(',', $category);
        if (!in_array('', $categories)) {
          $query->andWhereIn('e.category_id', $categories);
        }
      } else {
        $query->addWhere('e.category_id = ?', $request->getParameter('category'));
      }
      if ($query->count() == 0) {
        $query = $originalQ;
      }
    }

    $this->events = $query->execute();

    // identify weekend
    $friday = strtotime('friday');
    $sunday = strtotime('sunday');
    if ($friday > $sunday) {
      $friday = time();
    }

    $weekend = array(date('Y-m-d', $friday), date('Y-m-d', $sunday));
    $this->weekend = $query->copy()
      ->addWhere('e.start_at >= ? AND e.end_at <= ?', $weekend)
      ->execute();

    // city form
    $this->city_form = new sfFormSymfony();
    $this->city_form->setWidgets(array(
      'width' => new sfWidgetFormInputHidden(),
      'height' => new sfWidgetFormInputHidden(),
      'color' => new sfWidgetFormInputHidden(),
      'city' => new sfWidgetFormDoctrineChoice(array(
        'model' => 'City',
        'query' => CityTable::defaultCitiesQuery($this->getUser()->getCountry()->getId())
      )
    )));
    $this->city_form->bind(compact('city') + array(
      'width' => $request->getParameter('width'),
      'height' => $request->getParameter('height'),
      'color' => $request->getParameter('color', 'white'),
    ));
  }

}
