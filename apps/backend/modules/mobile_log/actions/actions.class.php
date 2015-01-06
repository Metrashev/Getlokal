<?php

require_once dirname(__FILE__).'/../lib/mobile_logGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/mobile_logGeneratorHelper.class.php';

/**
 * mobile_log actions.
 *
 * @package    getLokal
 * @subpackage mobile_log
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mobile_logActions extends autoMobile_logActions
{

  public function executeListExport(sfWebRequest $request)
  {
    $response = $this->getResponse();
    $response->setContentType('text/csv');
    $response->setHttpHeader('Content-Disposition', 'attachment; filename=export.csv');

    $response->setContent($this->_array2csv($this->_getExportData()));
    return sfView::NONE;
  }

  protected function _array2csv(array $arr)
  {
    if (count($arr) == 0)
    {
      return null;
    }

    ob_start();
    $df = fopen('php://output', 'w');
    fputcsv($df, array_keys(reset($arr)));
    foreach ($arr as $row)
    {
      fputcsv($df, $row);
    }
    fclose($df);
    return ob_get_clean();
  }

  protected function _getExportData()
  {
    $data = array();
    $query = $this->buildQuery();

    foreach ($query->execute() as $m_log) {
      $data[] = array(
        'id' => $m_log->getId(),
        'user_id' => $m_log->getUserId(),
        'user' => (string) $m_log->getUserProfile(),
        'device' => $m_log->getDevice(),
        'version' => $m_log->getVersion(),
        'action' => $m_log->getAction(),
        'lat' => $m_log->getLat(),
        'lng' => $m_log->getLng(),
        'created_at' => $m_log->getCreatedAt(),
        'content' => $m_log->getForeign()
      );
    }

    return $data;
  }

}
