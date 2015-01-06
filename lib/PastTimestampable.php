<?php
/*
 *  $Id$
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.doctrine-project.org>.
 */

/**
 * Doctrine_Template_Timestampable
 *
 * Easily add created and updated at timestamps to your doctrine records that are automatically set
 * when records are saved
 *
 * @package     Doctrine
 * @subpackage  Template
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link        www.doctrine-project.org
 * @since       1.0
 * @version     $Revision$
 * @author      Konsta Vesterinen <kvesteri@cc.hut.fi>
 */
class PastTimestampable extends Doctrine_Template_Timestampable
{
  public function getCreatedAgo($field = 'updated_at', $format = "d M Y")
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers( 'i18N' );
    $date_diff = time() - $this->getInvoker()->getDateTimeObject($field)->format('U');

    if($date_diff < 345600)
    {
      $days = floor($date_diff/(60*60*24));

      $hours = floor(($date_diff-($days*60*60*24))/(60*60));

      $minutes = floor(($date_diff-($days*60*60*24)-($hours*60*60))/60);

      if ($days) {
        return format_number_choice('[1]1 day ago|(1,+Inf]%count% days ago', array('%count%' => $days), $days,'timeStamps'); 
        
      } elseif ($hours) {
        return format_number_choice('[1]1 hour ago|(1,+Inf]%count% hours ago', array('%count%' => $hours), $hours,'timeStamps'); 
      }
       return format_number_choice('[1]1 munite ago|(1,+Inf]%count% munites ago', array('%count%' => $munites), $munites, 'timeStamps'); 

    }
   
    
    return $this->getInvoker()->getDateTimeObject($field)->format($minutes);
  }
  
/**
   * Get the I18n array of choices from the one
   * given in parameter, if i18n enabled.
   * @param array $choices An array instance of choices
   */
  
}