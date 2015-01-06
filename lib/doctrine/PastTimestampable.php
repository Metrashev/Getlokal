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
    $date_diff = time() - $this->getInvoker()->getDateTimeObject($field)->format('U');

    if($date_diff < 345600)
    {
      $days = floor($date_diff/(60*60*24));

      $hours = floor(($date_diff-($days*60*60*24))/(60*60));

      $minutes = floor(($date_diff-($days*60*60*24)-($hours*60*60))/60);

      if ($days) {
        return "acum ".$days." zile";
      } elseif ($hours) {
        return "acum ".$hours." ore";
      }
      
      return "acum ".$minutes." minute";
    }
    
    return $this->getInvoker()->getDateTimeObject($field)->format($format);
  }
}
