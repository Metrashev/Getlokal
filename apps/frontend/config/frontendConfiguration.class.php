<?php

class frontendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
     $this->dispatcher->connect('user.write_log', array('LogUserListener', 'listenToWriteLog'));

     $this->dispatcher->connect('social.write_message', array('NotifyListener',
                                                                 'listenToWriteMessage'));

     $this->dispatcher->connect('social.start_follow', array('NotifyListener',
                                                                 'listenToFollow'));
     $this->dispatcher->connect('social.badge_won', array('NotifyListener',
                                                                 'listenToWonBadge'));

  }
}
