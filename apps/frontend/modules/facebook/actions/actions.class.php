<?php

class facebookActions extends sfActions
{
  private
  $body = '',
  $bodyP1 = '',
  $underBodySignature = '',
  $subject = '';

  public function preExecute()
  {
    //sfConfig::set('app_server_enable_static', false);

    header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');

  }
  public function executeGame1(sfWebRequest $request)
  {
    if(!$this->getUser()->isAuthenticated())
    {
      $this->getResponse()->setContent("<script type='text/javascript'>top.location.href='{$this->generateUrl('default', array('module' => 'facebook', 'action' => 'login'), true)}';</script>");

      return sfView::NONE;
    }

    $this->name = '';
    $this->setLayout('modal');
    $texts = array(
    1 => array(
    0 => array(
    0 => 'Prietenel Filtratus',
    1 => 'Romanticus Nefiltratus',
    2 => 'Spumcel Rockulescu',
    3 => 'Solitarean Hameius',
    4 =>  'Aleatorius Nefiltratus',
    5 =>  'Metallis Introvertus'
    ),
    1 => array(
    0 =>  'Hamei Bioburtescu',
    1 =>  'Emoționel Orzulescu',
    2 =>  'Buda Berescu',
    3 =>   'Hippie Sihastrul',
    4 =>  'Spontanus Berevoiescu',
    5 =>  'Solitar Spumescu'
    ),
    2 => array(
    0 =>  'Gășculeanu Shoo-uap',
    1 =>  'Emoționel Doo-uap-uap',
    2 =>  'Colegescu Superhit',
    3 =>   'Nefiltrel Agaeanu',
    4 =>  'Spontanel Nefiltrescu',
    5 =>  'Singuraticus Berescu',
    ),
    3 => array(
    0 =>  'Șlagăr Nostalgicus',
    1 =>  'Șlăgărel Loverescu',
    2 =>  'Colegialis Berescu',
    3 =>  'Agitatus Singularis',
    4 =>  'Bass Improvizescu',
    5 =>  'Antisocialis Implozius',
    ),
    4 => array(
    0 =>  'Rebelescu Nefiltrater',
    1 =>  'Iuberel Punkulescu',
    2 =>  'Antisistemus Filtrater',
    3 =>   'Rebelion Beriescu',
    4 =>  'Spontanus Sticlescu',
    5 =>  'Singuraticus Dozescu',
    ),
    5 => array(
    0 => 'Beric Dozescu',
    1 => 'Flirtel Nefiltratescu',
    2 => 'Socializel Vorbărescu',
    3 => 'Hameius Loneliner',
    4 => 'Nefiltratus Flirtater',
    5 => 'Singurel Flirtater',
    ),
    ),
    2 => array(
    0 => array(
    0 =>  'Sauvignon Heavymetalus',
    1 =>  'Demisec Lovereanu',
    2 =>  'Reisling Prietenosus',
    3 =>  'Sauvignon Agitatus',
    4 =>  'Strugurel Oricinescu',
    5 =>  'Rockerel Acăsescu',
    ),
    1 => array(
    0 =>  'Cabernet Loialus',
    1 =>  'Pinot Romanticus',
    2 =>  'Ottonel Prieteneanu',
    3 =>  'Hipiotus Chardoneanu',
    4 =>  'Cabernet Instanter',
    5 =>  'Singuraticus Paharenschi',
    ),
    2 => array(
    0 =>  'Shoo-uap-uap Strugurescu',
    1 =>  'Do-uap Shi-shi-raz',
    2 =>  'Amiciția Păhrescu',
    3 =>  'Ottonel-Singurel Vineanu',
    4 =>  'Sho-uap Pinotescu',
    5 =>  'Do-uap do-uap Nostalgicus',
    ),
    3 => array(
    0 =>  'Strugurel Breakbeatescu',
    1 =>  'Emoionel Electronescu',
    2 =>  'Mustescu Veseleanu',
    3 =>  'Dark-Drum Pinotescu',
    4 =>  'Strugurel Spontanus',
    5 =>  'Ottonel Acăseanu',
    ),
    4 => array(
    0 =>  'Punkarel Gășcanu',
    1 =>  'Fidelian Demisecu',
    2 =>  'Antisistemus Prietenescu',
    3 =>  'Vorbrel Cotescu',
    4 =>  'Disponibil Revoluionarus',
    5 =>  'Singurel Revolutionarus'
    ),
    5 => array(
    0 =>  'Vorbrel Vermut',
    1 =>  'Logoree Flirtescu',
    2 =>  'Păhrel Prietenescu',
    3 =>   'Extravert Fetescu',
    4 =>  'Oricinel Cotescu',
    5 =>  'Linitel Vinescu'
    ),
    ),
    3 => array(
    0 => array(
    0 =>  'Mojito Supratus',
    1 =>  'Cubalibre Agitatus',
    2 =>  'Colegialis Vodkamica',
    3 =>  'Prietenel Caipirinhescu',
    4 =>  'GinTonic Spontanus',
    5 =>  'Singurel  Heavymetalescu',
    ),
    1 => array(
    0 =>  'Hipiotus Mojitescu',
    1 =>  'Emoionel Britpopescu',
    2 =>  'Cosmopolit Amicescu',
    3 =>  'MaiTai Britpopescu',
    4 =>  'Mojito Spontanus',
    5 =>  'Linitel Mojitovici',
    ),
    2 => array(
    0 =>  'Cocktelian Găculescu',
    1 =>  'Cocktelian Romanticus',
    2 =>  'Sho-uap Cosmopolitus',
    3 =>  'Flirtel Mojitoleanu',
    4 =>  'Cocktelic Nimereanu',
    5 =>  'Marguerit Linitescu'
    ),
    3 => array(
    0 =>  'Amicescu Breakbitescu',
    1 =>  'Emoționel Agitescu',
    2 =>  'Breakbeat Woorkaholicus',
    3 =>  'Electro - Improvizescu',
    4 =>  'Electro - Nimerescu',
    5 =>  'Singurel Agitescu'
    ),
    4 => array(
    0 =>  'Marguerit Agitescu',
    1 =>  'Nesincerel Dezorientescu',
    2 =>  'Antisistem Mojitovici',
    3 =>  'Împrietenel Margaritescu',
    4 =>  'Nimerel Margaritescu',
    5 =>  'Linitel Antisistemescu'
    ),
    5 => array(
    0 =>  'Caipiriniel Prietenescu',
    1 =>  'Marguerit Romanticus',
    2 =>  'Socializescu Nemicater',
    3 =>  'Singurel Improvizescu',
    4 =>  'Nimerel Margaritescu',
    5 =>  'Linitel Singurescu'
    ),
    ),
    4 => array(
    0 => array(
    0 =>  'Șurubelniță Prietenescu',
    1 =>  'Emoionel Heavymetalescu',
    2 =>  'Agitatus Workaholix',
    3 =>  'Singurel Rockescu',
    4 =>  'Nimerel Whiskescu',
    5 =>  'Screwdriver Singurescu',
    ),
    1 => array(
    0 =>  'Tonic Britpopescu',
    1 =>  'Romanticus Clăshescu',
    2 =>  'Workoholix Whiskescu',
    3 =>  'Singurel Improvizescu',
    4 =>  'Nimerel Agățescu',
    5 =>  'Introvert Britpopescu',
    ),
    2 => array(
    0 =>  'Shoo-uap Screwdriverescu',
    1 =>  'Romanțat Ginescu',
    2 =>  'Workoholix Sho-uap-uap',
    3 =>  'Extravert Screwdriverescu',
    4 =>  'Spontan Prietenescu',
    5 =>  'Do-uap-uap Acăsescu',
    ),
    3 => array(
    0 =>  'Grupel Blackbassensius',
    1 =>  'Electro Romanticus',
    2 =>  'CubaLibrean Workoholicus',
    3 =>  'Singurel Dubescu',
    4 =>  'Șurubelniț Disponibilescu',
    5 =>  'Linitel Screwdriverescu'
    ),
    4 => array(
    0 =>  'Antisistem Prietenescu',
    1 =>  'Emoționel Antisistemescu',
    2 =>  'Workoholic Vodkanescu',
    3 =>  'Vodkarian Libertinescu',
    4 =>  'Rebelic Wiscanu',
    5 =>  'Singurel Punkescu'
    ),
    5 => array(
    0 =>  'Șurubelniț Prietenescu',
    1 =>  'CubaLibrean Emoționescu',
    2 =>  'Amicel Screwdriverescu',
    3 =>  'Extravert Whiskescu',
    4 =>  'Vodkarian Improvizescu',
    5 =>  'Liniștel Acăsescu'
    ),
    ),
    5 => array(
    0 => array(
    0 =>  'Amicițius Tequileanu',
    1 =>  'Emoționel Heavymetălescu',
    2 =>  'Amicel Tequilescu',
    3 =>  'Mahmurel Agaeanu',
    4 =>  'Absintel Mahmureanu',
    5 =>  'Acăsel Vodkescu'
    ),
    1 => array(
    0 =>  'Amicel Britpopescu',
    1 =>  'Absintel Loverescu',
    2 =>  'Mahmurel Workescu',
    3 =>  'Spontănean Britpopescu',
    4 =>  'Hippie Flirtescu',
    5 =>  'Singurel Hipiotus'
    ),
    2 => array(
    0 =>  'Sho-uap Absintean',
    1 =>  'Sho-uap-uap Prietenescu',
    2 =>  'Absintel Colegeanu',
    3 =>  'Împrietenel Absintescu',
    4 =>  'Disponibilean Shoo-uapescu',
    5 =>  'Acăsel Sho-uap-uap'
    ),
    3 => array(
    0 =>  'Amicel Breakbeatescu',
    1 =>  'Emoționel Breakbeatescu',
    2 =>  'Colegialis Tequileanu',
    3 =>  'Extravert Absintescu',
    4 =>  'Improviz Electronescu',
    5 =>  'Vodkalian Acăsescu'
    ),
    4 => array(
    0 =>  'Vodkalian Rebeliescu',
    1 =>  'Emoționel Independentus',
    2 =>  'Absintel Antisistemic',
    3 =>  'Extravert Independentus',
    4 =>  'Întâmplător Absinteanu',
    5 =>  'Acăsel Tequileanu'
    ),
    5 => array(
    0 =>  'Prietenos Împiediceanu',
    1 =>  'Emoționel Impiediceanu',
    2 =>  'Workalian Împiediceanu',
    3 =>  'Absintean Împrietenescu',
    4 =>  'Norocel Absinteanu',
    5 =>  'Acăsel Împiediceanu'
    ),
    ),
    6 => 'Discernământus Preaplinus!'
    );

    if($request->hasParameter('reset'))
    {
      Doctrine::getTable('FacebookGame')
      ->createQuery('fb')
      ->where('fb.user_id = ?', $this->getUser()->getId())
      ->andWhere('fb.game = ?', 'gl_ro_party_name')
      ->delete()
      ->execute();
    }

    $query = Doctrine::getTable('FacebookGame')
    ->createQuery('g')
    ->where('g.user_id = ?', $this->getUser()->getId())
    ->andWhere('g.game = ?', 'gl_ro_party_name');

    if($query->count() && $a = $query->execute())
    {
      foreach($a as $answer)
      $answers[$answer->getQuestion()] = $answer->getAnswer();

      $this->image = Doctrine::getTable('Image')->find($answer->getUid());

      if(is_array($texts[$answers['drink']]))
      $this->name = $texts[$answers['drink']][$answers['dance']][$answers['friends']];
      else
      $this->name = $texts[$answers['drink']];

      return 'Done';
    }


    if($request->isMethod('post') && $request->getParameter('q1'))
    {
      $answers = array(
        'place_name' => $request->getParameter('q1'),
        'place_id'   => $request->getParameter('q1_id'),
        'drink'      => in_array($request->getParameter('q2'), array(0,1,2,3,4,5))? $request->getParameter('q2') + 1: 0,
        'dance'      => $request->getParameter('q3'),
        'friends'    => $request->getParameter('q4'),
      );

      $src_image = imagecreatefrompng(sfConfig::get('sf_web_dir').'/images/facebook/v1/award.png');

      $src_drink = imagecreatefrompng(sfConfig::get('sf_web_dir').'/images/facebook/v1/a'.$answers['drink'] .'.png');

      $user_image = imagecreatefromstring(file_get_contents('https://graph.facebook.com/'. $this->getUser()->getProfile()->getFacebookUid(). '/picture?type=large'));

      $width = imagesx($user_image);
      $final = imagecreatetruecolor(672, 403);

      imagecopyresampled($final, $user_image, 75, 79, 0, 0, 120, 120, $width, $width);
      imagecopy($final, $src_drink, 473, 85, 0, 0, 117, 117);
      imagecopy($final, $src_image, 0, 0, 0, 0, 672, 403);

      $white  = imagecolorallocate($final, 255, 255, 255);
      $orange = imagecolorallocate($final, 214, 83, 37);
      $font  = sfConfig::get('sf_web_dir').'/images/facebook/v1/OpenSans-Bold.ttf';

      $text = $this->getUser()->getProfile()->getFirstName(). ',';
      $size = imagettfbbox(30, 0, $font, $text);
      imagettftext($final, 30, 0, 336 - ($size[4] / 2), 155, $white, $font, $text);

      if(is_array($texts[$answers['drink']]))
      $this->name = $texts[$answers['drink']][$answers['dance']][$answers['friends']];
      else
      $this->name = $texts[$answers['drink']];
      $size = imagettfbbox(30, 0, $font, $this->name);
      imagettftext($final, 30, 0, 336 - ($size[4] / 2), 310, $orange, $font, $this->name);

      $tmp = sfConfig::get('sf_upload_dir'). '/'. uniqid(). '.jpg';
      imagejpeg($final, $tmp, 80);

      $file = new sfValidatedFile ( uniqid() . '.jpg', filetype ( $tmp ), $tmp, filesize ( $tmp ) );

      $this->image  = new Image();
      $this->image->setFile($file);
      $this->image->setUserId($this->getUser()->getId());
      $this->image->setType('profile');
      $this->image->save();

      $token = "AAAELIqTwuGcBACTaVgQUqeG0QbHW03B95bxaVUz6lENMLuz8ySMjHEHmFv8npiZCZCWmRurrAGHLnV0xwLWslnOyhGkCyXfJArMqw0TVy07stsGpCm";

      $url = '';
      if($company = Doctrine::getTable('Company')->find($answers['place_id']))
      {
        $url = ' ---> '.$this->getController()->genUrl($company->getUri(), true);
      }

      $ch = curl_init ();
      curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me/photos" );
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
      curl_setopt($ch, CURLOPT_AUTOREFERER, true );
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false ); # required for https urls
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, array(
        'source'  => '@'. $this->image->getFile()->getDiskPath(),
        'message' => 'Pe testate, în '. $answers['place_name']. '!'.$url.'
Daca vrei sa afli care e numele tău de party - fă-ți și tu testul
http://apps.facebook.com/getlokal-party-name',
        'access_token' => $this->getUser()->getProfile()->getFBtoken()
      ));
      //$result = curl_exec($ch);

      $uid = $this->image->getId();
      foreach($answers as $key => $value)
      {
        $facebookGame = new FacebookGame();
        $facebookGame->setUserId($this->getUser()->getId());
        $facebookGame->setGame('gl_ro_party_name');
        $facebookGame->setQuestion($key);
        $facebookGame->setAnswer($value);
        $facebookGame->setUid($uid);
        $facebookGame->save();
      }

      return 'Done';
    }
  }

  public function executeGame1bg(sfWebRequest $request) {
    if (!$this->getUser()->isAuthenticated()) {
      $this->getResponse()->setContent("<script type='text/javascript'>top.location.href='{$this->generateUrl('default', array('module' => 'facebook', 'action' => 'login', 'app' => '3'), true)}';</script>");

      return sfView::NONE;
    }

    $this->name = '';
    $this->setLayout('modal');

    $drinkTypes = array(
    0 => array('Туборг', 'Загорка', 'Хайнекен', 'Гинес', 'Ариана'),
    1 => array('Шардоне', 'Розе', 'Кюве', 'Зинфандел', 'Каберне'),
    2 => array('Пиня колада', 'Дайкири', 'Скрюдрайвър', 'Мохито', 'Манхатън'),
    3 => array('Уиски', 'Водка', 'Текила', 'Коняк', 'Ром'),
    4 => array('Минерал', 'Извор'),
    );

    $musicGenres = array(
    0 => array('Метъла', 'Хард Рока', 'Траша', 'Рокера', 'Рок\'н\'Рола'),
    1 => array('Колдплея', 'Музата', 'Стереофоника', 'Килъра', 'Сноупатрула'),
    2 => array('Абата', 'Бониема', 'Сисикеча', 'Битълса', 'Елвиса'),
    3 => array('Скрилекса', 'Печенката', 'Скеча', 'Балкански', 'Криспи'),
    4 => array('Пистълса', 'Погото', 'Клаша', 'Студжиса', 'Рамонеса'),
    5 => array('Тъгата', 'Скуката'),
    );



    if ($request->hasParameter('reset')) {
      $results = Doctrine::getTable('FacebookGame')
      ->createQuery('fb')
      ->where('fb.user_id = ?', $this->getUser()->getId())
      ->andWhere('fb.game = ?', 'gl_bg_party_name')
      //->delete()
      ->execute();

      if (count($results) && $results) {
        if ($partyName = $results[0]->getPartyName()) {
          $partyName->delete();
        }

        foreach ($results as $result) {
          $result->delete();
        }
      }
    }


    $query = Doctrine::getTable('FacebookGame')
    ->createQuery('fg')
    ->where('fg.user_id = ?', $this->getUser()->getId())
    ->andWhere('fg.game = ?', 'gl_bg_party_name')
    ->andWhere('fg.question = ?', 'drink');

    $result = $query->fetchOne(array(), Doctrine_Core::HYDRATE_RECORD);

    if ($result) {
      $this->drink = ($result->getAnswer()) ? $result->getAnswer() : 0;

      $this->image = Doctrine::getTable('Image')->find($result->getUid());

      $this->name = $result->getPartyName()->getName();

      if ($this->image) {
        return 'Done';
      }
    }


    $userImage = null;
    $imageType = 'large';
    $userImagePath = 'https://graph.facebook.com/' . $this->getUser()->getProfile()->getFacebookUid() . '/picture?type=';
    //$userImagePath = 'https://graph.facebook.com/100000853180167/picture?type=';
    $this->getFbImage($imageType, $userImagePath, $userImage);


    // php v.5.4 only
    //list($width, $height) = getimagesizefromstring($userImage);

    // php v.5.3
    list($width, $height) = getimagesize($userImagePath . $imageType);

    $this->userImageFileName = $this->getUser()->getProfile()->getFacebookUid() . '.jpg';
    $userImagePath = sfConfig::get('sf_upload_dir') . '/' . $this->userImageFileName;

    $final = imagecreatetruecolor(88, 88);

    // From string
    imagecopyresampled($final, imagecreatefromstring($userImage), 0, 0, 0, 0, 88, 88, $width, $height);

    // From jpg
    //imagecopyresampled($final, imagecreatefromjpeg($userImagePath), 0, 0, 0, 0, 88, 88, $width, $height);

    $imagejpg = imagejpeg($final, $userImagePath, 100);

    $this->userName = $this->getUser()->getGuardUser()->getFirstName();


    if ($request->isMethod('post') && $request->getPostParameter('q3', false)) {
      $answers = array(
                'place_name' => $request->getPostParameter('q3', null),
                'place_id' => $request->getPostParameter('q3_id', null),
                'drink' => in_array($request->getPostParameter('q1'), array(0, 1, 2, 3, 4)) ? $request->getPostParameter('q1') : 0,
                'dance' => in_array($request->getPostParameter('q2'), array(0, 1, 2, 3, 4, 5)) ? $request->getPostParameter('q2') : 0,
                'friends' => '',
      );

      $this->drink = $answers['drink'];

      // Generate username here...
      $firstName = $drinkTypes[$answers['drink']][array_rand($drinkTypes[$answers['drink']])];
      $lastName =  $musicGenres[$answers['dance']][array_rand($musicGenres[$answers['dance']])];
      $this->name = $firstName . ' ' . $lastName;

      // Create an image
      $srcImage = imagecreatefrompng(sfConfig::get('sf_web_dir') . '/images/facebook/v1/bg/bg_award.png');
      $userImage = $final;

      $holst = imagecreatetruecolor(332, 214);
      imagecopyresampled($holst, $userImage, 24, 22, 0, 0, 86, 86, 86, 86);
      imagecopy($holst, $srcImage, 0, 0, 0, 0, 332, 214);

      $partyNameColor = imagecolorallocate($holst, 255, 255, 255);
      $partyNameShadowColor = imagecolorallocate($holst, 27, 126, 250);
      $nameFontColor = imagecolorallocate($holst, 206, 13, 95);
      $textFontColor = imagecolorallocate($holst, 59, 0, 13);

      $font1 = sfConfig::get('sf_web_dir') . '/images/facebook/v1/bg/myriadpro-boldit.ttf';
      $font2 = sfConfig::get('sf_web_dir') . '/images/facebook/v1/bg/myriadpro-it.ttf';

      $text1 = $this->getUser()->getProfile()->getFirstName() . ", ";
      $text2 = 'след 00:00 часа в';
      $text3 = $answers['place_name'];
      $text4 = 'се подвизаваш като:';

      $fs1 = 20; // name
      $fs2 = 16; // place
      $fs3 = 16; // text
      $fs4 = 25; // Party name

      $size1 = imagettfbbox($fs1, 0, $font1, $text1);
      $this->calculateFontSize($size1, $font1, $text1, $fs1);
      imagettftext($holst, $fs1, 0, 114, 60, $nameFontColor, $font1, $text1);

      $size2 = imagettfbbox($fs3, 0, $font2, $text2);
      imagettftext($holst, $fs3, 0, 114, 86, $textFontColor, $font2, $text2);

      $size3 = imagettfbbox($fs2, 0, $font1, $text3);
      $this->calculateFontSize($size3, $font1, $text3, $fs2);
      imagettftext($holst, $fs2, 0, 114, 112, $nameFontColor, $font1, $text3);

      $size4 = imagettfbbox($fs3, 0, $font2, $text4);
      imagettftext($holst, $fs3, 0, 114, 138, $textFontColor, $font2, $text4);
      //$this->name = 'Загорка Абата';
      $size5 = imagettfbbox($fs4, 0, $font1, $this->name);
      $this->calculateFontSize($size5, $font1, $this->name, $fs4, 260);
      imagettftext($holst, $fs4, 0, 168 - ($size5[4] / 2), 188, $partyNameShadowColor, $font1, $this->name);

      $size6 = imagettfbbox($fs4, 0, $font1, $this->name);

      $this->calculateFontSize($size6, $font1, $this->name, $fs4, 260);
      imagettftext($holst, $fs4, 0, 167 - ($size6[4] / 2), 186, $partyNameColor, $font1, $this->name);

      $tmp = sfConfig::get('sf_upload_dir') . '/' . uniqid() . '_game_bg.jpg';
      imagejpeg($holst, $tmp, 100);

      $file = new sfValidatedFile(uniqid() . '.jpg', filetype($tmp), $tmp, filesize($tmp));


      $this->image = new Image();
      $this->image->setFile($file);
      $this->image->setUserId($this->getUser()->getId());
      //$this->image->setType('profile');
      $this->image->save();

      $token = "AAAB7DN67FXQBAI23GQv6NM3W2L6NNwZAMaUqMBz7wHgFllaffw1Jayj8GEw6KqZBoZCsCyYAC6jO1G1vM2gdsFeRM9lIf8zP2OjibnJZCoiZBGPQVVTvW";

      $url = '';
      if ($company = Doctrine::getTable('Company')->find($answers['place_id'])) {
        $url = ' ---> ' . $this->getController()->genUrl($company->getUri(), true);
      }
      /*
       // http://developers.facebook.com/tools/explorer?method=GET&path=100001642136166%3Ffields%3Did%2Cname
       // use id from $result = curl_exec($ch);
       // use application "Care e numele tau de party?"
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me/photos");
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_AUTOREFERER, true);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); # required for https urls
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_POSTFIELDS, array(
       'source' => '@' . $this->image->getFile()->getDiskPath(),
       'message' => 'Разбери своето парти име на:
       http://apps.facebook.com/getlokal-pname-bg',
       'access_token' => $this->getUser()->getProfile()->getFBtoken()
       ));
       $result = curl_exec($ch);
       */
      $partyName = new PartyName();
      $partyName->setName($this->name);
      $partyName->save();

      $uid = $this->image->getId();
      foreach ($answers as $key => $value) {
        $facebookGame = new FacebookGame();
        $facebookGame->setUserId($this->getUser()->getId());
        $facebookGame->setGame('gl_bg_party_name');
        $facebookGame->setQuestion($key);
        $facebookGame->setAnswer($value);
        $facebookGame->setUid($uid);
        $facebookGame->setPartyName($partyName);
        $facebookGame->save();
      }

      return 'Done';
    }
  }

  // Bulgarian`s game
  public function executeGame2bg(sfWebRequest $request) {
    // Culture for the game
    $culture = 'bg';
    $hasOpened = true;
    $this->setLayout('modal');
    // Get i18n
    $i18n = $this->getContext()->getInstance()->getI18N();
    /*
     GAME STAT

     CREATE VIEW facebook_users_for_game2 AS


     SELECT sgu.first_name 'FIRST_NAME', sgu.last_name 'LAST_NAME', sgu.email_address 'EMAIL', up.gender 'GENDER', CONCAT(cty.name, ' - ', cty.slug) 'CITY', frgu.referer REGEXP 'from=' AS 'REFERER'

     FROM facebook_review_game_user AS frgu

     INNER JOIN sf_guard_user AS sgu ON (sgu.id = frgu.user_id)
     INNER JOIN user_profile AS up ON (up.id = sgu.id)
     INNER JOIN city AS cty ON (cty.id = up.city_id)

     WHERE frgu.facebook_review_game_id = 2

     ORDER BY frgu.id ASC
     */



        /* WITH COUNT OF REVIEWS
     SELECT sgu.first_name 'FIRST_NAME', sgu.last_name 'LAST_NAME', sgu.email_address 'EMAIL', up.gender 'GENDER', CONCAT(cty.name, ' - ', cty.slug) 'CITY', frgu.referer REGEXP 'from=' AS 'REFERER', (SELECT COUNT(r.id) FROM review AS r WHERE r.user_id = sgu.id AND (r.created_at >= '2013-04-19 00:00:00' AND r.created_at <= '2013-05-23 23:59:59')) AS REVIEWS

     FROM facebook_review_game_user AS frgu

     INNER JOIN sf_guard_user AS sgu ON (sgu.id = frgu.user_id)
     INNER JOIN user_profile AS up ON (up.id = sgu.id)
     INNER JOIN city AS cty ON (cty.id = up.city_id)

     WHERE frgu.facebook_review_game_id = 8

     ORDER BY frgu.id ASC
        */



    /*
     DO NOT REMOVE :)

     A better way to save to Database
     $toDatabse = base64_encode(serialize($data));  // Save to database
     $fromDatabase = unserialize(base64_decode($data)); //Getting Save Format

     $params = array(
     'compare_param1' => array('gender' => 'Жени', 'text2' => 'подкрепи жените в'),
     'compare_param2' => array('gender' => 'Мъже', 'text2' => 'подкрепи мъжете в'),
     'mail'  => array(
     'subject' => "те кани да спечелиш романтична вечеря за двама",
     'bodyP1' => "Здрасти,",
     'body1' => "Аз участвах в Голямата надпревара на getlokal.\n",
     'prize' => "Участвай и ти и можеш да спечелиш романтична вечеря за двама за Св. Валентин и бутилка вино за Св. Трифон Зарезан. \n",
     'body2' => "Лесно и забавно е! \n",
     'signature' => "\n\r от Голямата надпревара \n\r",
     ),
     'facebook' => array(
     'share_on_wal_msg' => "Участвай в надпреварата кои са по-романтични - жените или мъжете на:
     http://apps.facebook.com/getlokal-big-race",

     )
     );


     $params = array(
     'compare_param1' => array('place' => 'София', 'text2' => 'подкрепи София в'),
     'compare_param2' => array('place' => 'Страната', 'text2' => 'подкрепи страната в'),
     'mail'  => array(
     'subject' => "те кани да спечелиш екскурзия",
     'bodyP1' => "Здрасти,",
     'body1' => "Аз участвах в Голямата надпревара на getlokal.\n",
     'prize' => "Участвай и ти и можеш да спечелиш екскурзия до Велико Търново за деня на Освобождението на България. \n",
     'body2' => "Лесно и забавно е! \n",
     'signature' => "\n\r от Голямата надпревара \n\r",
     ),
     'facebook' => array(
     'share_on_wal_msg' => "Участвай в надпреварата кои са най-известните забележителности:
     http://apps.facebook.com/sofia-vs-country",

     )
     );


     $params = array(
     'compare_param1' => array('place' => 'Поп-фолк', 'text2' => 'каза ДА на поп-фолка в'),
     'compare_param2' => array('place' => 'Друго', 'text2' => 'каза НЕ на поп-фолка в'),
     'mail'  => array(
     'subject' => "те кани да спечелиш 2 билета за DEPECHE MODE.",
     'bodyP1' => "Здрасти,",
     'body1' => "Аз участвах в Голямата надпревара на getlokal.\n",
     'prize' => "Участвай и ти и можеш да спечелиш 2 билета за DEPECHE MODE. \n",
     'body2' => "Лесно и забавно е! \n",
     'signature' => "\n\r от Голямата надпревара \n\r",
     ),
     'facebook' => array(
     'share_on_wal_msg' => "Участвай в надпреварата 'Кой е твоя стил?' на
     http://apps.facebook.com/pop-folk-vs-other",

     )
     );


     echo base64_encode(serialize($params));
     //var_dump($params);
     exit;
     */

    //$this->getUser()->signOut();
    //exit;

    $this->facebookGame = Doctrine::getTable('FacebookReviewGame')
    ->createQuery('frg')
    ->where('frg.lang = ? and frg.status = ?', array($culture, 'opened'))
                ->andWhereNotIn('frg.id', array(5,6,7))
    ->fetchOne();

    if (!$this->facebookGame) {
      //$this->redirect('@homepage');
      // Get last closed game
      $this->facebookGame = Doctrine::getTable('FacebookReviewGame')
      ->createQuery('frg')
      ->where('frg.lang = ? and frg.status = ?', array($culture, 'closed'))
      ->orderBy('frg.id DESC')
      ->fetchOne();

      if ($this->facebookGame)
      {
        $hasOpened = false;
        $this->setTemplate('game2bgSplash');
      }
      else {
        $this->redirect('@homepage');
      }
    }

    if ($hasOpened && !$this->getUser()->isAuthenticated()) {
      if (strpos($request->getHost(), 'facebook.com') !== false || strpos($request->getReferer(), $this->facebookGame->getSlug()) !== false || strpos($request->getReferer(), '?from=facebook_game') !== false || strpos($request->getReferer(), 'iframehost.com') !== false) {
        $this->getResponse()->setContent("<script type='text/javascript'>top.location.href='{$this->generateUrl('default', array('module' => 'facebook', 'action' => 'login', 'app' => $this->facebookGame->getSlug()), true)}';</script>");
      }
      else {
        if (!$this->getUser()->hasAttribute('game.referer') || !$this->getUser()->getAttribute('game.referer', false)) {
          $this->getUser()->setAttribute('game.referer', $this->generateUrl('default', array('module' => 'facebook', 'action' => 'game2bg', 'sf_culture' => 'bg'), true));
        }
        $this->getResponse()->setContent("<script type='text/javascript'>top.location.href='{$this->generateUrl('sf_guard_signin', array(), true)}';</script>");
      }

      return sfView::NONE;
    }

    // Get game parameters from DB...
    $gameParams = unserialize(base64_decode($this->facebookGame->getFinalSupportText()));

    if (strpos($request->getHost(), 'facebook.com') !== false || strpos($request->getReferer(), $this->facebookGame->getSlug()) !== false || strpos($request->getReferer(), '?from=facebook_game') !== false || strpos($request->getReferer(), 'iframehost.com') !== false) {
      $this->isFbGame = true;
    }
    else {
      $this->isFbGame = false;

      $this->getResponse()->setTitle($this->facebookGame->getTitle());
    }


    //Show or hide an additional links
    // Winners and results
    $query = Doctrine::getTable('FacebookReviewGame')
    ->createQuery('frg')
    ->where('frg.lang = ? and frg.status = ?', array($culture, 'closed'))
    ->orderBy('frg.id DESC');

    $this->games = $query->execute();

    if ($type = $request->getGetParameter('type', null)) {
      if ($type == 'winners') {
        error_reporting(0);
        /*
         $query = Doctrine::getTable('FacebookReviewGame')
         ->createQuery('frg')
         ->where('frg.lang = ? and frg.status = ?', array($culture, 'closed'));

         $this->games = $query->execute();
         */
        $this->setTemplate('game2bgWinners');
      }
      elseif ($type == 'results') {
        error_reporting(0);
        /*
         $query = Doctrine::getTable('FacebookReviewGame')
         ->createQuery('frg')
         ->where('frg.lang = ? and frg.status = ?', array($culture, 'closed'));

         $this->games = $query->execute();
         */
        $this->setTemplate('game2bgResults');
      }
      elseif ($type == 'awards') {
        error_reporting(0);
        $this->setTemplate('game2bgAwards');
      }
    }

    // Set layout



    // Game form
    $this->gameForm = new FacebookGame2Form();

    $this->inviteFromMailUrl = $this->generateUrl('default', array('module' => 'facebook', 'action' => 'game2bg', 'sf_culture' => 'bg'), true);

    // Invite
    $this->_setSubject($gameParams['mail']['subject']);
    $this->_setBody($gameParams, $this->inviteFromMailUrl);

    $this->sendInvitePMForm = new sendInvitePMForm(array(), array('body' => $this->body));

    if ($request->isMethod('post') && $request->getPostParameter('sendInvite', false) && $request->isXmlHttpRequest()) {
      $postData = $request->getPostParameter('formValues');
      $postData = explode('&', $postData);

      $formData = array();
      foreach ($postData as $key => $data) {
        $data = urldecode($data);
        $tmpKey = str_replace("sendInvitePM[", "", $data);
        $tmpKey = explode("]=", $tmpKey);
        $tmpKey = $tmpKey[0];

        $tmpData = explode("]=", $data);

        $formData[$tmpKey] = $tmpData[1];
      }

      $this->sendInvitePMForm->bind($formData);

      if ($this->sendInvitePMForm->isValid())
      {
        $formValues = $this->sendInvitePMForm->getValues();

        $emails = $readyRegisteredEmails = array();
        foreach ($formValues as $name => $value) {
          if (strpos($name, 'email_') !== false && $value) {
            $emails[] = $value;
          }
        }

        $tmpBody = $this->body;
        $this->body = $formValues['body'];

        $this->_send($emails);

        return $this->renderText(json_encode(array('success' => true, 'message' => $i18n->__('Your invite was sent successfully!', null, 'user'), 'body' => $tmpBody)));
      }
      else {
        $errors = array();
        foreach($this->sendInvitePMForm->getErrorSchema()->getErrors() as $widget => $error) {
          $errors[$widget] = $i18n->__($error->__toString(), null, 'form');
        }

        return $this->renderText(json_encode(array('error' => true, 'errors' => $errors)));
      }
    }


    // Send review
    if ($request->isMethod('post') && $request->getPostParameter('save', false) && $request->getPostParameter('review_place', false) && $request->getPostParameter('review_stars', false) && $request->getPostParameter('review_text', false)) {
      $companyPage = Doctrine::getTable('CompanyPage')->find($request->getPostParameter('review_place', NULL));

      if (!$companyPage) {
        exit(json_encode(array('error' => true)));
      }

      if ($this->facebookGame->getSlug() == 'getlokal-big-race') {
        // Get user gender
        $gender = '';
        if ($this->getUser()->getProfile()->getGender() == 'f') {
          $gender = $gameParams['compare_param1']['gender'];
          $text2 = $gameParams['compare_param1']['text2'];
        }
        else {
          $gender = $gameParams['compare_param2']['gender'];
          $text2 = $gameParams['compare_param2']['text2'];
        }
      }
      elseif ($this->facebookGame->getSlug() == 'sofia-vs-country') {
        $gender = '';
        if ($companyPage->getCompany()->getCity()->getSlug() == 'sofia' && $companyPage->getCompany()->getCountryId() == 1)
        {
          $gender = $gameParams['compare_param1']['place'];
          $text2 = $gameParams['compare_param1']['text2'];
        }
        else {
          $gender = $gameParams['compare_param2']['place'];
          $text2 = $gameParams['compare_param2']['text2'];
        }
      }
      elseif ($this->facebookGame->getSlug() == 'pop-folk-vs-other') {
        if (!$request->getPostParameter('genre', false) || $request->getPostParameter('genre', false) > 2) {
          exit(json_encode(array('error' => true)));
        }

        $gender = '';
        // pop-folk
        if ($request->getPostParameter('genre', false) == 1) {
          $gender = $gameParams['compare_param1']['place'];
          $text2 = $gameParams['compare_param1']['text2'];
        }
        // other
        else {
          $gender = $gameParams['compare_param2']['place'];
          $text2 = $gameParams['compare_param2']['text2'];
        }
      }

      // Create a directory
      if (!is_dir(sfConfig::get('sf_upload_dir') . '/facebook_game')) {
        mkdir(sfConfig::get('sf_upload_dir') . '/facebook_game');
      }

      try {
        $obj = $this->getUser()->getGuardUser();

        if ($obj) {
          $firstName = $obj->getFirstName();
        }
      } catch (Exception $exc) {
        $this->redirect('default', array('module' => 'facebook', 'action' => 'game2bg'));
      }



      if ($this->facebookGame->getSlug() == 'getlokal-big-race') {
        // Create an image
        $srcImage = imagecreatefrompng(sfConfig::get('sf_web_dir') . '/images/facebook/prizes/bg/game_' . $this->facebookGame->getId() . '_award_big.png');

        $holst = imagecreatetruecolor(403, 260);
        imagecopy($holst, $srcImage, 0, 0, 0, 0, 403, 260);

        $userNameColor = imagecolorallocate($holst, 225, 123, 170);
        $textColor = imagecolorallocate($holst, 234, 243, 251);

        $text1 = $firstName;

        $font1 = sfConfig::get('sf_web_dir') . '/images/facebook/v3/bg/pt-sans-narrow-bold.ttf';

        // Font size
        $fs1 = 36; // name
        $fs2 = 24; // name

        $size1 = imagettfbbox($fs1, 0, $font1, $text1);
        $this->calculateFontSize($size1, $font1, $text1, $fs1, 260);
        imagettftext($holst, $fs1, 0, 18, 40, $userNameColor, $font1, $text1);

        $size2 = imagettfbbox($fs2, 0, $font1, $text2);
        $this->calculateFontSize($size2, $font1, $text2, $fs2, 400);
        imagettftext($holst, $fs2, 0, 18, 73, $textColor, $font1, $text2);
      }
      elseif ($this->facebookGame->getSlug() == 'sofia-vs-country') {
        // Create an image
        $srcImage = imagecreatefrompng(sfConfig::get('sf_web_dir') . '/images/facebook/prizes/bg/game_' . $this->facebookGame->getId() . '_award_big.png');

        $holst = imagecreatetruecolor(403, 260);
        imagecopy($holst, $srcImage, 0, 0, 0, 0, 403, 260);

        $userNameColor = imagecolorallocate($holst, 255, 255, 255);
        $textColor = imagecolorallocate($holst, 255, 255, 255);

        $text1 = $firstName;

        $font1 = sfConfig::get('sf_web_dir') . '/images/facebook/v3/bg/pt-sans-narrow-bold.ttf';

        // Font size
        $fs1 = 29; // name
        $fs2 = 21; // name

        $size1 = imagettfbbox($fs1, 0, $font1, $text1);
        $this->calculateFontSize($size1, $font1, $text1, $fs1, 260);
        imagettftext($holst, $fs1, 0, 18, 36, $userNameColor, $font1, $text1);

        $size2 = imagettfbbox($fs2, 0, $font1, $text2);
        $this->calculateFontSize($size2, $font1, $text2, $fs2, 400);
        imagettftext($holst, $fs2, 0, 18, 58, $textColor, $font1, $text2);
      }
      elseif ($this->facebookGame->getSlug() == 'pop-folk-vs-other') {
        // Create an image
        $srcImage = imagecreatefrompng(sfConfig::get('sf_web_dir') . '/images/facebook/prizes/bg/game_' . $this->facebookGame->getId() . '_award_big.png');

        $holst = imagecreatetruecolor(403, 260);
        imagecopy($holst, $srcImage, 0, 0, 0, 0, 403, 260);

        $userNameColor = imagecolorallocate($holst, 255, 255, 255);
        $textColor = imagecolorallocate($holst, 255, 255, 255);

        $text1 = $firstName;

        $font1 = sfConfig::get('sf_web_dir') . '/images/facebook/v3/bg/pt-sans-narrow-bold.ttf';

        // Font size
        $fs1 = 28; // name
        $fs2 = 16; // name

        $size1 = imagettfbbox($fs1, 0, $font1, $text1);
        $this->calculateFontSize($size1, $font1, $text1, $fs1, 260);
        imagettftext($holst, $fs1, 0, 10, 35, $userNameColor, $font1, $text1);

        $size2 = imagettfbbox($fs2, 0, $font1, $text2);
        $this->calculateFontSize($size2, $font1, $text2, $fs2, 400);
        imagettftext($holst, $fs2, 0, 10, 58, $textColor, $font1, $text2);
      }

      //$tmp = sfConfig::get('sf_upload_dir') . '/' . uniqid() . '_game_bg.jpg';
      $tmp = sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_bg.jpg';
      imagejpeg($holst, $tmp, 100);


      if ($this->facebookGame->getSlug() == 'getlokal-big-race') {
        // Create a small image
        $smallSrcImage = imagecreatefrompng(sfConfig::get('sf_web_dir') . '/images/facebook/prizes/bg/game_' . $this->facebookGame->getId() . '_award_small.png');
        $firstName = $this->getUser()->getGuardUser()->getFirstName();

        $smallHolst = imagecreatetruecolor(111, 74);
        imagecopy($smallHolst, $smallSrcImage, 0, 0, 0, 0, 111, 74);

        $userNameColor = imagecolorallocate($smallHolst, 225, 123, 170);
        $textColor = imagecolorallocate($smallHolst, 234, 243, 251);

        $text1 = $firstName;
        $font1 = sfConfig::get('sf_web_dir') . '/images/facebook/v3/bg/pt-sans-narrow-bold.ttf';

        // Font size
        $fs1 = 10.25; // name
        $fs2 = 6.83; // name

        $smallSize1 = imagettfbbox($fs1, 0, $font1, $text1);
        $this->calculateFontSize($smallSize1, $font1, $text1, $fs1, 75);
        imagettftext($smallHolst, $fs1, 0, 6, 12, $userNameColor, $font1, $text1);

        $smallSize2 = imagettfbbox($fs2, 0, $font1, $text2);
        $this->calculateFontSize($smallSize2, $font1, $text2, $fs2, 100);
        imagettftext($smallHolst, $fs2, 0, 6, 20, $textColor, $font1, $text2);
      }
      elseif ($this->facebookGame->getSlug() == 'sofia-vs-country') {
        // Create a small image
        $smallSrcImage = imagecreatefrompng(sfConfig::get('sf_web_dir') . '/images/facebook/prizes/bg/game_' . $this->facebookGame->getId() . '_award_small.png');
        $firstName = $this->getUser()->getGuardUser()->getFirstName();

        $smallHolst = imagecreatetruecolor(111, 74);
        imagecopy($smallHolst, $smallSrcImage, 0, 0, 0, 0, 111, 74);

        $userNameColor = imagecolorallocate($smallHolst, 255, 255, 255);
        $textColor = imagecolorallocate($smallHolst, 255, 255, 255);

        $text1 = $firstName;
        $font1 = sfConfig::get('sf_web_dir') . '/images/facebook/v3/bg/pt-sans-narrow-bold.ttf';

        // Font size
        $fs1 = 9; // name
        $fs2 = 6.80; // name

        $smallSize1 = imagettfbbox($fs1, 0, $font1, $text1);
        $this->calculateFontSize($smallSize1, $font1, $text1, $fs1, 75);
        imagettftext($smallHolst, $fs1, 0, 6, 10, $userNameColor, $font1, $text1);

        $smallSize2 = imagettfbbox($fs2, 0, $font1, $text2);
        $this->calculateFontSize($smallSize2, $font1, $text2, $fs2, 100);
        imagettftext($smallHolst, $fs2, 0, 6, 17, $textColor, $font1, $text2);
      }
      elseif ($this->facebookGame->getSlug() == 'pop-folk-vs-other') {
        // Create a small image
        $smallSrcImage = imagecreatefrompng(sfConfig::get('sf_web_dir') . '/images/facebook/prizes/bg/game_' . $this->facebookGame->getId() . '_award_small.png');
        $firstName = $this->getUser()->getGuardUser()->getFirstName();

        $smallHolst = imagecreatetruecolor(111, 74);
        imagecopy($smallHolst, $smallSrcImage, 0, 0, 0, 0, 111, 74);

        $userNameColor = imagecolorallocate($smallHolst, 255, 255, 255);
        $textColor = imagecolorallocate($smallHolst, 255, 255, 255);

        $text1 = $firstName;
        $font1 = sfConfig::get('sf_web_dir') . '/images/facebook/v3/bg/pt-sans-narrow-bold.ttf';

        // Font size
        $fs1 = 9; // name
        $fs2 = 6.5; // name

        $smallSize1 = imagettfbbox($fs1, 0, $font1, $text1);
        $this->calculateFontSize($smallSize1, $font1, $text1, $fs1, 75);
        imagettftext($smallHolst, $fs1, 0, 2, 10, $userNameColor, $font1, $text1);

        $smallSize2 = imagettfbbox($fs2, 0, $font1, $text2);
        $this->calculateFontSize($smallSize2, $font1, $text2, $fs2, 100);
        imagettftext($smallHolst, $fs2, 0, 2, 20, $textColor, $font1, $text2);
      }

      $this->shareImg = sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_bg_share.jpg';
      imagejpeg($smallHolst, $this->shareImg, 100);

      $protocol = ($request->isSecure()) ? 'https://' : 'http://';
      $this->shareImg = $protocol . $request->getHost() . '/uploads/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_bg_share.jpg';



      $this->getResponse()->setCookie('from', $this->facebookGame->getSlug());


      // Generate an image
      $tmp = sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_bg.jpg';
      $file = new sfValidatedFile(uniqid() . '.jpg', filetype($tmp), $tmp, filesize($tmp));

      // Save generated image
      $this->image = new Image();
      $this->image->setFile($file);
      $this->image->setUserId($this->getUser()->getId());
      $this->image->save();

      // Save review
      $review = new Review();
      $review->setUserId($this->getUser()->getId());
      $review->setCompanyId($companyPage->getCompany()->getId());
      $review->setText($request->getPostParameter('review_text', ''));
      $review->setRating($request->getPostParameter('review_stars', '1'));
      //$review->setReferer('facebook_game2_bg');
      $review->save();

      // Save user
      $facebookReviewGameUser = new FacebookReviewGameUser();
      $facebookReviewGameUser->setUserId($this->getUser()->getId());
      $facebookReviewGameUser->setFacebookReviewGameId($this->facebookGame->getId());
      //$facebookReviewGameUser->setReferer($this->getUser()->setAttribute('game.referer', ''));
      $facebookReviewGameUser->setReferer($request->getReferer());
      $facebookReviewGameUser->save();

      // Remove referer attribute
      $this->getUser()->setAttribute('game.referer', NULL);

      // Increment and save game result
      $query = Doctrine::getTable('FacebookReviewGameResult')
      ->createQuery('frgr')
      ->where('frgr.facebook_review_game_id = ? and frgr.param1 = ?', array($this->facebookGame->getId(), $gender));

      $facebookReviewGameResult = $query->fetchOne();

      if ($facebookReviewGameResult)
      {
        $total = $facebookReviewGameResult->getParam2() + 1;

        $facebookReviewGameResult->setParam2($total);
      }
      else {
        $facebookReviewGameResult = new FacebookReviewGameResult();
        $facebookReviewGameResult->setFacebookReviewGameId($this->facebookGame->getId());
        $facebookReviewGameResult->setParam1($gender);
        $facebookReviewGameResult->setParam2(1);
      }

      $facebookReviewGameResult->save();

      // Count all users for current game
      $count = $this->facebookGame->getCountUsers();


      // All results
      $tmpArr = $this->facebookGame->getUserResults($count);
      $resArr['result'] = $tmpArr;

      $resArr['error'] = false;
      $resArr['total'] = $count;
      $resArr['image'] = $this->shareImg;
      //$protocol = ($request->isSecure()) ? 'https://' : 'http://';
      //$resArr['image'] = $protocol . $request->getHost() . '/uploads/facebook_game/' . $this->getUser()->getId() . '_game_bg_share.jpg';


      $token = "AAAFipGQmRHsBAE7gJL8cYTawrvUr2RP4J03IYb1TKqqWiaPCCEAX1YgATHMC59NbyVMR8QQZA5fbZCjmWwSes4AVegsRKqDrwdYHqfZA2U99mubgD1Q";

      // http://developers.facebook.com/tools/explorer?method=GET&path=100001642136166%3Ffields%3Did%2Cname
      // use id from $result = curl_exec($ch);
      // use application "Care e numele tau de party?"
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me/photos");
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_AUTOREFERER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); # required for https urls
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                'source' => '@' . $this->image->getFile()->getDiskPath(),
                'message' => $gameParams['facebook']['share_on_wal_msg'],
                'access_token' => $this->getUser()->getProfile()->getFBtoken()
      ));
      $result = curl_exec($ch);

      if (file_exists(sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_bg.jpg')) {
        //@unlink(sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->getUser()->getId() . '_game_bg.jpg');
        //@unlink(sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->getUser()->getId() . '_game_bg_share.jpg');
      }

      // Return response
      exit(json_encode($resArr));
    }

    // Remove referer attribute
    $this->getUser()->setAttribute('game.referer', NULL);
  }



  // COPY GAME
  public function executeGame2cbg(sfWebRequest $request) {
    // Culture for the game
    $culture = 'bg';
    $hasOpened = true;
    $this->setLayout('modal');
    // Get i18n
    $i18n = $this->getContext()->getInstance()->getI18N();

    $this->facebookGame = Doctrine::getTable('FacebookReviewGame')
    ->createQuery('frg')
    ->where('frg.lang = ? and frg.status = ?', array($culture, 'opened'))
                ->andWhereNotIn('frg.id', array(5,6,7))
    ->fetchOne();

    if (!$this->facebookGame) {
      //$this->redirect('@homepage');
      // Get last closed game
      $this->facebookGame = Doctrine::getTable('FacebookReviewGame')
      ->createQuery('frg')
      ->where('frg.lang = ? and frg.status = ?', array($culture, 'closed'))
      ->orderBy('frg.id DESC')
      ->fetchOne();

      if ($this->facebookGame)
      {
        $hasOpened = false;
        $this->setTemplate('game2bgSplash');
      }
      else {
        $this->redirect('@homepage');
      }
    }

    if ($hasOpened && !$this->getUser()->isAuthenticated()) {
      if (strpos($request->getHost(), 'facebook.com') !== false || strpos($request->getReferer(), $this->facebookGame->getSlug()) !== false || strpos($request->getReferer(), '?from=facebook_game_copy') !== false || strpos($request->getReferer(), 'iframehost.com') !== false) {
        $this->getResponse()->setContent("<script type='text/javascript'>top.location.href='{$this->generateUrl('default', array('module' => 'facebook', 'action' => 'login', 'app' => $this->facebookGame->getSlug() . '-copy'), true)}';</script>");
      }
      else {
        if (!$this->getUser()->hasAttribute('game.referer') || !$this->getUser()->getAttribute('game.referer', false)) {
          $this->getUser()->setAttribute('game.referer', $this->generateUrl('default', array('module' => 'facebook', 'action' => 'game2cbg', 'sf_culture' => 'bg'), true));
        }
        $this->getResponse()->setContent("<script type='text/javascript'>top.location.href='{$this->generateUrl('sf_guard_signin', array(), true)}';</script>");
      }

      return sfView::NONE;
    }

    // Get game parameters from DB...
    $gameParams = unserialize(base64_decode($this->facebookGame->getFinalSupportText()));

    if (strpos($request->getHost(), 'facebook.com') !== false || strpos($request->getReferer(), $this->facebookGame->getSlug()) !== false || strpos($request->getReferer(), '?from=facebook_game_copy') !== false || strpos($request->getReferer(), 'iframehost.com') !== false) {
      $this->isFbGame = true;
    }
    else {
      $this->isFbGame = false;

      $this->getResponse()->setTitle($this->facebookGame->getTitle());
    }


    //Show or hide an additional links
    // Winners and results
    $query = Doctrine::getTable('FacebookReviewGame')
    ->createQuery('frg')
    ->where('frg.lang = ? and frg.status = ?', array($culture, 'closed'))
    ->orderBy('frg.id DESC');

    $this->games = $query->execute();

    if ($type = $request->getGetParameter('type', null)) {
      if ($type == 'winners') {
        error_reporting(0);
        /*
         $query = Doctrine::getTable('FacebookReviewGame')
         ->createQuery('frg')
         ->where('frg.lang = ? and frg.status = ?', array($culture, 'closed'));

         $this->games = $query->execute();
         */
        $this->setTemplate('game2cbgWinners');
      }
      elseif ($type == 'results') {
        error_reporting(0);
        /*
         $query = Doctrine::getTable('FacebookReviewGame')
         ->createQuery('frg')
         ->where('frg.lang = ? and frg.status = ?', array($culture, 'closed'));

         $this->games = $query->execute();
         */
        $this->setTemplate('game2cbgResults');
      }
      elseif ($type == 'awards') {
        error_reporting(0);
        $this->setTemplate('game2cbgAwards');
      }
    }

    // Set layout



    // Game form
    $this->gameForm = new FacebookGame2Form();

    $this->inviteFromMailUrl = $this->generateUrl('default', array('module' => 'facebook', 'action' => 'game2cbg', 'sf_culture' => 'bg'), true);

    // Invite
    $this->_setSubject($gameParams['mail']['subject']);
    $this->_setBody($gameParams, $this->inviteFromMailUrl);

    $this->sendInvitePMForm = new sendInvitePMForm(array(), array('body' => $this->body));

    if ($request->isMethod('post') && $request->getPostParameter('sendInvite', false) && $request->isXmlHttpRequest()) {
      $postData = $request->getPostParameter('formValues');
      $postData = explode('&', $postData);

      $formData = array();
      foreach ($postData as $key => $data) {
        $data = urldecode($data);
        $tmpKey = str_replace("sendInvitePM[", "", $data);
        $tmpKey = explode("]=", $tmpKey);
        $tmpKey = $tmpKey[0];

        $tmpData = explode("]=", $data);

        $formData[$tmpKey] = $tmpData[1];
      }

      $this->sendInvitePMForm->bind($formData);

      if ($this->sendInvitePMForm->isValid())
      {
        $formValues = $this->sendInvitePMForm->getValues();

        $emails = $readyRegisteredEmails = array();
        foreach ($formValues as $name => $value) {
          if (strpos($name, 'email_') !== false && $value) {
            $emails[] = $value;
          }
        }

        $tmpBody = $this->body;
        $this->body = $formValues['body'];

        $this->_send($emails);

        return $this->renderText(json_encode(array('success' => true, 'message' => $i18n->__('Your invite was sent successfully!', null, 'user'), 'body' => $tmpBody)));
      }
      else {
        $errors = array();
        foreach($this->sendInvitePMForm->getErrorSchema()->getErrors() as $widget => $error) {
          $errors[$widget] = $i18n->__($error->__toString(), null, 'form');
        }

        return $this->renderText(json_encode(array('error' => true, 'errors' => $errors)));
      }
    }


    // Send review
    if ($request->isMethod('post') && $request->getPostParameter('save', false) && $request->getPostParameter('review_place', false) && $request->getPostParameter('review_stars', false) && $request->getPostParameter('review_text', false)) {
      $companyPage = Doctrine::getTable('CompanyPage')->find($request->getPostParameter('review_place', NULL));

      if (!$companyPage) {
        exit(json_encode(array('error' => true)));
      }

      if ($this->facebookGame->getSlug() == 'pop-folk-vs-other') {
        if (!$request->getPostParameter('genre', false) || $request->getPostParameter('genre', false) > 2) {
          exit(json_encode(array('error' => true)));
        }

        $gender = '';
        // pop-folk
        if ($request->getPostParameter('genre', false) == 1) {
          $gender = $gameParams['compare_param1']['place'];
          $text2 = $gameParams['compare_param1']['text2'];
        }
        // other
        else {
          $gender = $gameParams['compare_param2']['place'];
          $text2 = $gameParams['compare_param2']['text2'];
        }
      }

      // Create a directory
      if (!is_dir(sfConfig::get('sf_upload_dir') . '/facebook_game')) {
        mkdir(sfConfig::get('sf_upload_dir') . '/facebook_game');
      }

      try {
        $obj = $this->getUser()->getGuardUser();

        if ($obj) {
          $firstName = $obj->getFirstName();
        }
      } catch (Exception $exc) {
        $this->redirect('default', array('module' => 'facebook', 'action' => 'game2cbg'));
      }


      if ($this->facebookGame->getSlug() == 'pop-folk-vs-other') {
        // Create an image
        $srcImage = imagecreatefrompng(sfConfig::get('sf_web_dir') . '/images/facebook/prizes/bg/game_' . $this->facebookGame->getId() . '_award_big.png');

        $holst = imagecreatetruecolor(403, 260);
        imagecopy($holst, $srcImage, 0, 0, 0, 0, 403, 260);

        $userNameColor = imagecolorallocate($holst, 255, 255, 255);
        $textColor = imagecolorallocate($holst, 255, 255, 255);

        $text1 = $firstName;

        $font1 = sfConfig::get('sf_web_dir') . '/images/facebook/v3/bg/pt-sans-narrow-bold.ttf';

        // Font size
        $fs1 = 28; // name
        $fs2 = 16; // name

        $size1 = imagettfbbox($fs1, 0, $font1, $text1);
        $this->calculateFontSize($size1, $font1, $text1, $fs1, 260);
        imagettftext($holst, $fs1, 0, 10, 35, $userNameColor, $font1, $text1);

        $size2 = imagettfbbox($fs2, 0, $font1, $text2);
        $this->calculateFontSize($size2, $font1, $text2, $fs2, 400);
        imagettftext($holst, $fs2, 0, 10, 58, $textColor, $font1, $text2);
      }

      //$tmp = sfConfig::get('sf_upload_dir') . '/' . uniqid() . '_game_bg.jpg';
      $tmp = sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_bg.jpg';
      imagejpeg($holst, $tmp, 100);


      if ($this->facebookGame->getSlug() == 'pop-folk-vs-other') {
        // Create a small image
        $smallSrcImage = imagecreatefrompng(sfConfig::get('sf_web_dir') . '/images/facebook/prizes/bg/game_' . $this->facebookGame->getId() . '_award_small.png');
        $firstName = $this->getUser()->getGuardUser()->getFirstName();

        $smallHolst = imagecreatetruecolor(111, 74);
        imagecopy($smallHolst, $smallSrcImage, 0, 0, 0, 0, 111, 74);

        $userNameColor = imagecolorallocate($smallHolst, 255, 255, 255);
        $textColor = imagecolorallocate($smallHolst, 255, 255, 255);

        $text1 = $firstName;
        $font1 = sfConfig::get('sf_web_dir') . '/images/facebook/v3/bg/pt-sans-narrow-bold.ttf';

        // Font size
        $fs1 = 9; // name
        $fs2 = 6.5; // name

        $smallSize1 = imagettfbbox($fs1, 0, $font1, $text1);
        $this->calculateFontSize($smallSize1, $font1, $text1, $fs1, 75);
        imagettftext($smallHolst, $fs1, 0, 2, 10, $userNameColor, $font1, $text1);

        $smallSize2 = imagettfbbox($fs2, 0, $font1, $text2);
        $this->calculateFontSize($smallSize2, $font1, $text2, $fs2, 100);
        imagettftext($smallHolst, $fs2, 0, 2, 20, $textColor, $font1, $text2);
      }

      $this->shareImg = sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_bg_share.jpg';
      imagejpeg($smallHolst, $this->shareImg, 100);

      $protocol = ($request->isSecure()) ? 'https://' : 'http://';
      $this->shareImg = $protocol . $request->getHost() . '/uploads/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_bg_share.jpg';



      $this->getResponse()->setCookie('from', $this->facebookGame->getSlug());


      // Generate an image
      $tmp = sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_bg.jpg';
      $file = new sfValidatedFile(uniqid() . '.jpg', filetype($tmp), $tmp, filesize($tmp));

      // Save generated image
      $this->image = new Image();
      $this->image->setFile($file);
      $this->image->setUserId($this->getUser()->getId());
      $this->image->save();

      // Save review
      $review = new Review();
      $review->setUserId($this->getUser()->getId());
      $review->setCompanyId($companyPage->getCompany()->getId());
      $review->setText($request->getPostParameter('review_text', ''));
      $review->setRating($request->getPostParameter('review_stars', '1'));
      //$review->setReferer('facebook_game2_bg');
      $review->save();

      // Save user
      $facebookReviewGameUser = new FacebookReviewGameUser();
      $facebookReviewGameUser->setUserId($this->getUser()->getId());
      $facebookReviewGameUser->setFacebookReviewGameId($this->facebookGame->getId());
      //$facebookReviewGameUser->setReferer($this->getUser()->setAttribute('game.referer', ''));
      $facebookReviewGameUser->setReferer($request->getReferer());
      $facebookReviewGameUser->save();

      // Remove referer attribute
      $this->getUser()->setAttribute('game.referer', NULL);

      // Increment and save game result
      $query = Doctrine::getTable('FacebookReviewGameResult')
      ->createQuery('frgr')
      ->where('frgr.facebook_review_game_id = ? and frgr.param1 = ?', array($this->facebookGame->getId(), $gender));

      $facebookReviewGameResult = $query->fetchOne();

      if ($facebookReviewGameResult)
      {
        $total = $facebookReviewGameResult->getParam2() + 1;

        $facebookReviewGameResult->setParam2($total);
      }
      else {
        $facebookReviewGameResult = new FacebookReviewGameResult();
        $facebookReviewGameResult->setFacebookReviewGameId($this->facebookGame->getId());
        $facebookReviewGameResult->setParam1($gender);
        $facebookReviewGameResult->setParam2(1);
      }

      $facebookReviewGameResult->save();

      // Count all users for current game
      $count = $this->facebookGame->getCountUsers();


      // All results
      $tmpArr = $this->facebookGame->getUserResults($count);
      $resArr['result'] = $tmpArr;

      $resArr['error'] = false;
      $resArr['total'] = $count;
      $resArr['image'] = $this->shareImg;
      //$protocol = ($request->isSecure()) ? 'https://' : 'http://';
      //$resArr['image'] = $protocol . $request->getHost() . '/uploads/facebook_game/' . $this->getUser()->getId() . '_game_bg_share.jpg';


      $token = "AAAFipGQmRHsBAE7gJL8cYTawrvUr2RP4J03IYb1TKqqWiaPCCEAX1YgATHMC59NbyVMR8QQZA5fbZCjmWwSes4AVegsRKqDrwdYHqfZA2U99mubgD1Q";

      // http://developers.facebook.com/tools/explorer?method=GET&path=100001642136166%3Ffields%3Did%2Cname
      // use id from $result = curl_exec($ch);
      // use application "Care e numele tau de party?"
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me/photos");
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_AUTOREFERER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); # required for https urls
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                'source' => '@' . $this->image->getFile()->getDiskPath(),
                'message' => $gameParams['facebook']['share_on_wal_msg'],
                'access_token' => $this->getUser()->getProfile()->getFBtoken()
      ));
      $result = curl_exec($ch);

      if (file_exists(sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_bg.jpg')) {
        //@unlink(sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->getUser()->getId() . '_game_bg.jpg');
        //@unlink(sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->getUser()->getId() . '_game_bg_share.jpg');
      }

      // Return response
      exit(json_encode($resArr));
    }

    // Remove referer attribute
    $this->getUser()->setAttribute('game.referer', NULL);
  }

  /***************  FB game 2, romanian version******************** */

  protected function facebookSDK($game)
  {
    // This method only works for game2ro game, for now
    $configs = array(
      'bere-vs-vin' => array(
        'appId' => '525540210839584',
        'secret' => '0304e34691ac6a7e9cdb148e43dc5efc'
      ),
      'hot-summer-race' => array(
        'appId' => '191865117646261',
        'secret' => '72835c0a7d8d6a196856e0fbfffce721'
      )
    );
    if (!isset($configs[$game])) {
      return;
    }
    $facebook = new Facebook($configs[$game]);

    if ($facebook->getUser())
    {
      $profile = Doctrine::getTable('UserProfile')->findOneByFacebookUid($facebook->getUser());
      if ($profile)
      {
        // log user in
        $signed_request = $facebook->getSignedRequest();
        $profile->setAccessToken($signed_request['oauth_token']);
        $profile->save();

        $this->getUser()->signIn($profile->getSfGuardUser(), true);
      }
    }

    if (!$this->getUser()->isAuthenticated())
    {
      $request = sfContext::getInstance()->getRequest();
      $protocol = ($request->isSecure()) ? 'https://' : 'http://';
      $fbUrl = $protocol . 'apps.facebook.com/';

      // if user doesn't have a profile yet, than make him login
      $this->getUser()->setAttribute('game.referer', $fbUrl . $game . '/');
      $this->do_fb_connect = true;
    }
  }

  public function executeGame2ro(sfWebRequest $request) {
    // Culture for the game
    $culture = 'ro';
    $hasOpened = true;
    $this->setLayout('modal');
    // Get i18n
    $i18n = $this->getContext()->getInstance()->getI18N();


/*
//$this->getUser()->signout();
if ($this->getUser()->isAuthenticated()) {
    exit('Is auth');
}
else {
    $this->getResponse()->setContent("<script type='text/javascript'>top.location.href='{$this->generateUrl('default', array('module' => 'facebook', 'action' => 'login', 'app' => 'big-race-ro'), true)}';</script>");
    return sfView::NONE;
}
exit('ok');
*/

    $this->facebookGame = Doctrine::getTable('FacebookReviewGame')
    ->createQuery('frg')
    ->where('frg.lang = ? and frg.status = ?', array($culture, 'opened'))
    ->fetchOne();

    if (!$this->facebookGame) {
      //$this->redirect('@homepage');
      // Get last closed game
      $this->facebookGame = Doctrine::getTable('FacebookReviewGame')
      ->createQuery('frg')
      ->where('frg.lang = ? and frg.status = ?', array($culture, 'closed'))
      ->orderBy('frg.id DESC')
      ->fetchOne();

      if ($this->facebookGame)
      {
        $hasOpened = false;
        $this->setTemplate('game2roSplash');
      }
      else
      {
        $this->redirect('@homepage');
      }
    }

//    if ($hasOpened && !$this->getUser()->isAuthenticated()) {

      if (strpos($request->getHost(), 'facebook.com') !== false || strpos($request->getReferer(), $this->facebookGame->getSlug()) !== false || strpos($request->getReferer(), '?from=facebook_game_copy') !== false || strpos($request->getReferer(), 'iframehost.com') !== false) {
        $this->getResponse()->setContent("<script type='text/javascript'>top.location.href='{$this->generateUrl('default', array('module' => 'facebook', 'action' => 'login', 'app' => $this->facebookGame->getSlug()), true)}';</script>");
        $this->facebookSDK('bere-vs-vin');
      }
      else
      {
        if (!$this->getUser()->hasAttribute('game.referer') || !$this->getUser()->getAttribute('game.referer', false)) {
          $this->getUser()->setAttribute('game.referer', $this->generateUrl('default', array('module' => 'facebook', 'action' => 'game2ro', 'sf_culture' => 'ro'), true));
        }
        $this->getResponse()->setContent("<script type='text/javascript'>top.location.href='{$this->generateUrl('sf_guard_signin', array(), true)}';</script>");
      }
//      return sfView::NONE;
//    }

    // Get game parameters from DB...
    $gameParams = unserialize(base64_decode($this->facebookGame->getFinalSupportText()));

    if (strpos($request->getHost(), 'facebook.com') !== false || strpos($request->getReferer(), $this->facebookGame->getSlug()) !== false || strpos($request->getReferer(), '?from=facebook_game_copy') !== false || strpos($request->getReferer(), 'iframehost.com') !== false) {
      $this->isFbGame = true;
    }
    else {
      $this->isFbGame = false;

      $this->getResponse()->setTitle($this->facebookGame->getTitle());
    }

    //Show or hide an additional links
    // Winners and results
    $query = Doctrine::getTable('FacebookReviewGame')
    ->createQuery('frg')
    ->where('frg.lang = ? and frg.status = ?', array($culture, 'closed'))
    ->orderBy('frg.id DESC');

    $this->games = $query->execute();

    if ($type = $request->getGetParameter('type', null)) {
      if ($type == 'winners') {
        error_reporting(0);
        /*
         $query = Doctrine::getTable('FacebookReviewGame')
         ->createQuery('frg')
         ->where('frg.lang = ? and frg.status = ?', array($culture, 'closed'));

         $this->games = $query->execute();
         */
        $this->setTemplate('game2roWinners');
      }
      elseif ($type == 'results') {
        error_reporting(0);
        /*
         $query = Doctrine::getTable('FacebookReviewGame')
         ->createQuery('frg')
         ->where('frg.lang = ? and frg.status = ?', array($culture, 'closed'));

         $this->games = $query->execute();
         */
        $this->setTemplate('game2roResults');
      }
      elseif ($type == 'awards') {
        error_reporting(0);
        $this->setTemplate('game2roAwards');
      }
    }

    // Set layout



    // Game form
    $this->gameForm = new FacebookGame2Form();

    $this->inviteFromMailUrl = $this->generateUrl('default', array('module' => 'facebook', 'action' => 'game2ro', 'sf_culture' => 'ro'), true);

    // Invite

     $gameParams = array(
     'compare_param1' => array('gender' => 'bere', 'text2' => 'bere'),
     'compare_param2' => array('gender' => 'vin', 'text2' => 'vin'),
     'mail'  => array(
     'subject' => "te invită să aduni şanse pentru un iPad2!",
     'bodyP1' => "Bună!",
     'body1' => "Particip la concursul getlokal.ro!",
     'prize' => " Încerci şi tu?\n\n",
     'body2' => "from Bere vs. vin",
     'signature' => "\n\r",
     ));

    $this->_setSubject($gameParams['mail']['subject']);
    $this->_setBody($gameParams, $this->inviteFromMailUrl);

    $this->sendInvitePMForm = new sendInvitePMForm(array(), array('body' => $this->body));

    if ($request->isMethod('post') && $request->getPostParameter('sendInvite', false) && $request->isXmlHttpRequest()) {
      $postData = $request->getPostParameter('formValues');
      $postData = explode('&', $postData);

      $formData = array();
      foreach ($postData as $key => $data) {
        $data = urldecode($data);
        $tmpKey = str_replace("sendInvitePM[", "", $data);
        $tmpKey = explode("]=", $tmpKey);
        $tmpKey = $tmpKey[0];

        $tmpData = explode("]=", $data);

        $formData[$tmpKey] = $tmpData[1];
      }

      $this->sendInvitePMForm->bind($formData);

      if ($this->sendInvitePMForm->isValid())
      {
        $formValues = $this->sendInvitePMForm->getValues();

        $emails = $readyRegisteredEmails = array();
        foreach ($formValues as $name => $value) {
          if (strpos($name, 'email_') !== false && $value) {
            $emails[] = $value;
          }
        }

        $tmpBody = $this->body;
        $this->body = $formValues['body'];

        $this->_send($emails);

        return $this->renderText(json_encode(array('success' => true, 'message' => $i18n->__('Your invite was sent successfully!', null, 'user'), 'body' => $tmpBody)));
      }
      else {
        $errors = array();
        foreach($this->sendInvitePMForm->getErrorSchema()->getErrors() as $widget => $error) {
          $errors[$widget] = $i18n->__($error->__toString(), null, 'form');
        }

        return $this->renderText(json_encode(array('error' => true, 'errors' => $errors)));
      }
    }


    // Send review
    if ($request->isMethod('post') && $request->getPostParameter('save', false) && $request->getPostParameter('review_place', false) && $request->getPostParameter('review_stars', false) && $request->getPostParameter('review_text', false)) {
      $companyPage = Doctrine::getTable('CompanyPage')->find($request->getPostParameter('review_place', NULL));

      if (!$companyPage) {
        exit(json_encode(array('error' => true)));
      }

      if ($this->facebookGame->getSlug() == 'big-race-ro') {
        if (!$request->getPostParameter('genre', false) || $request->getPostParameter('genre', false) > 2) {
          exit(json_encode(array('error' => true)));
        }

        $gender = '';
        // pop-folk
        if ($request->getPostParameter('genre', false) == 1) {
          $gender = 'Bucureşti';
          $text2 = $gameParams['compare_param1']['text2'];
        }
        // other
        else {
          $gender = 'provincie';
          $text2 = $gameParams['compare_param2']['text2'];
        }
      }

      elseif ($this->facebookGame->getSlug() == 'bere-vs-vin') {
        if (!$request->getPostParameter('genre', false) || $request->getPostParameter('genre', false) > 2) {
          exit(json_encode(array('error' => true)));
        }

        $gender = '';
        // bere
        if ($request->getPostParameter('genre', false) == 1) {
          $gender = 'bere';
          $text2 = $gameParams['compare_param1']['text2'];
        }
        // vin
        else {
          $gender = 'vin';
          $text2 = $gameParams['compare_param2']['text2'];
        }
      }

      // Create a directory
      if (!is_dir(sfConfig::get('sf_upload_dir') . '/facebook_game')) {
        mkdir(sfConfig::get('sf_upload_dir') . '/facebook_game');
      }

      try {
        $obj = $this->getUser()->getGuardUser();

        if ($obj) {
          $firstName = $obj->getFirstName();
        }
      } catch (Exception $exc) {
        $this->redirect('default', array('module' => 'facebook', 'action' => 'game2ro'));
      }


      if ($this->facebookGame->getSlug() == 'big-race-ro') {
        // Create an image
        $srcImage = imagecreatefrompng(sfConfig::get('sf_web_dir') . '/images/facebook/prizes/ro/game_' . $this->facebookGame->getId() . '_prize_big_award.png');

        $holst = imagecreatetruecolor(403, 260);
        imagecopy($holst, $srcImage, 0, 0, 0, 0, 403, 260);

        $userNameColor = imagecolorallocate($holst, 255, 255, 255);
        $textColor = imagecolorallocate($holst, 255, 255, 255);

        $text1 = $firstName;

        $font1 = sfConfig::get('sf_web_dir') . '/images/facebook/v3/bg/pt-sans-narrow-bold.ttf';

        // Font size
        $fs1 = 28; // name
        $fs2 = 16; // name

        $size1 = imagettfbbox($fs1, 0, $font1, $text1);
        $this->calculateFontSize($size1, $font1, $text1, $fs1, 260);
        imagettftext($holst, $fs1, 0, 10, 35, $userNameColor, $font1, $text1);

        $size2 = imagettfbbox($fs2, 0, $font1, $text2);
        $this->calculateFontSize($size2, $font1, $text2, $fs2, 400);
        imagettftext($holst, $fs2, 0, 10, 58, $textColor, $font1, $text2);
      }

      if ($this->facebookGame->getSlug() == 'bere-vs-vin') {
        // Create an image
        $srcImage = imagecreatefrompng(sfConfig::get('sf_web_dir') . '/images/facebook/prizes/ro/game_' . $this->facebookGame->getId() . '_prize_big_award.png');

        $holst = imagecreatetruecolor(403, 260);
        imagecopy($holst, $srcImage, 0, 0, 0, 0, 403, 260);
      }

      //$tmp = sfConfig::get('sf_upload_dir') . '/' . uniqid() . '_game_bg.jpg';
      $tmp = sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_bg.jpg';
      imagejpeg($holst, $tmp, 100);


      if ($this->facebookGame->getSlug() == 'big-race-ro') {
        // Create a small image
        $smallSrcImage = imagecreatefrompng(sfConfig::get('sf_web_dir') . '/images/facebook/prizes/ro/game_' . $this->facebookGame->getId() . '_prize_small.png');
        $firstName = $this->getUser()->getGuardUser()->getFirstName();

        $smallHolst = imagecreatetruecolor(111, 74);
        imagecopy($smallHolst, $smallSrcImage, 0, 0, 0, 0, 111, 74);

        $userNameColor = imagecolorallocate($smallHolst, 255, 255, 255);
        $textColor = imagecolorallocate($smallHolst, 255, 255, 255);

        $text1 = $firstName;
        $font1 = sfConfig::get('sf_web_dir') . '/images/facebook/v3/bg/pt-sans-narrow-bold.ttf';

        // Font size
        $fs1 = 9; // name
        $fs2 = 6.5; // name

        $smallSize1 = imagettfbbox($fs1, 0, $font1, $text1);
        $this->calculateFontSize($smallSize1, $font1, $text1, $fs1, 75);
        imagettftext($smallHolst, $fs1, 0, 2, 10, $userNameColor, $font1, $text1);

        $smallSize2 = imagettfbbox($fs2, 0, $font1, $text2);
        $this->calculateFontSize($smallSize2, $font1, $text2, $fs2, 100);
        imagettftext($smallHolst, $fs2, 0, 2, 20, $textColor, $font1, $text2);
      }

      if ($this->facebookGame->getSlug() == 'bere-vs-vin') {
        // Create a small image
        $smallSrcImage = imagecreatefrompng(sfConfig::get('sf_web_dir') . '/images/facebook/prizes/ro/game_' . $this->facebookGame->getId() . '_prize_small.png');
        $firstName = $this->getUser()->getGuardUser()->getFirstName();

        $smallHolst = imagecreatetruecolor(111, 74);
        imagecopy($smallHolst, $smallSrcImage, 0, 0, 0, 0, 111, 74);
      }

      $this->shareImg = sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_bg_share.jpg';
      imagejpeg($smallHolst, $this->shareImg, 100);

      $protocol = ($request->isSecure()) ? 'https://' : 'http://';
      $this->shareImg = $protocol . $request->getHost() . '/uploads/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_bg_share.jpg';



      $this->getResponse()->setCookie('from', $this->facebookGame->getSlug());


      // Generate an image
      $tmp = sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_bg.jpg';
      $file = new sfValidatedFile(uniqid() . '.jpg', filetype($tmp), $tmp, filesize($tmp));

      // Save generated image
      $this->image = new Image();
      $this->image->setFile($file);
      $this->image->setUserId($this->getUser()->getId());
      $this->image->save();

      // Save review
      $review = new Review();
      $review->setUserId($this->getUser()->getId());
      $review->setCompanyId($companyPage->getCompany()->getId());
      $review->setText($request->getPostParameter('review_text', ''));
      $review->setRating($request->getPostParameter('review_stars', '1'));
      //$review->setReferer('facebook_game2_bg');gen
      $review->save();

      // Save user
      $facebookReviewGameUser = new FacebookReviewGameUser();
      $facebookReviewGameUser->setUserId($this->getUser()->getId());
      $facebookReviewGameUser->setFacebookReviewGameId($this->facebookGame->getId());
      //$facebookReviewGameUser->setReferer($this->getUser()->setAttribute('game.referer', ''));
      $facebookReviewGameUser->setReferer($request->getReferer());
      $facebookReviewGameUser->save();

      // Remove referer attribute
      $this->getUser()->setAttribute('game.referer', NULL);


      // Increment and save game result
      $query = Doctrine::getTable('FacebookReviewGameResult')
      ->createQuery('frgr')
      ->where('frgr.facebook_review_game_id = ? and frgr.param1 = ?', array($this->facebookGame->getId(), $gender));

      $facebookReviewGameResult = $query->fetchOne();

      if ($facebookReviewGameResult)
      {
        $total = $facebookReviewGameResult->getParam2() + 1;

        $facebookReviewGameResult->setParam2($total);
      }
      else {
        $facebookReviewGameResult = new FacebookReviewGameResult();
        $facebookReviewGameResult->setFacebookReviewGameId($this->facebookGame->getId());
        $facebookReviewGameResult->setParam1($gender);
        $facebookReviewGameResult->setParam2(1);
      }

      $facebookReviewGameResult->save();

      // Count all users for current game
      $count = $this->facebookGame->getCountUsers();


      // All results
      $tmpArr = $this->facebookGame->getUserResults($count);
      $resArr['result'] = $tmpArr;

      $resArr['error'] = false;
      $resArr['total'] = $count;
      $resArr['image'] = $this->shareImg;
      //$protocol = ($request->isSecure()) ? 'https://' : 'http://';
      //$resArr['image'] = $protocol . $request->getHost() . '/uploads/facebook_game/' . $this->getUser()->getId() . '_game_bg_share.jpg';


      $token = "AAAFipGQmRHsBAE7gJL8cYTawrvUr2RP4J03IYb1TKqqWiaPCCEAX1YgATHMC59NbyVMR8QQZA5fbZCjmWwSes4AVegsRKqDrwdYHqfZA2U99mubgD1Q";

      // http://developers.facebook.com/tools/explorer?method=GET&path=100001642136166%3Ffields%3Did%2Cname
      // use id from $result = curl_exec($ch);
      // use application "Care e numele tau de party?"
      /*$ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me/photos");
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_AUTOREFERER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); # required for https urls
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                'source' => '@' . $this->image->getFile()->getDiskPath(),
                'message' => $gameParams['facebook']['share_on_wal_msg'],
                'access_token' => $this->getUser()->getProfile()->getFBtoken()
      ));
      $result = curl_exec($ch);
      */
      if (file_exists(sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_bg.jpg')) {
        //@unlink(sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->getUser()->getId() . '_game_bg.jpg');
        //@unlink(sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->getUser()->getId() . '_game_bg_share.jpg');
      }

      // Return response
      exit(json_encode($resArr));
    }
    // Remove referer attribute
//    $this->getUser()->setAttribute('game.referer', NULL);
  }

  /*********************** End game 2 romanian version ************************************/

  // Macedinian`s game
  public function executeGame2mk(sfWebRequest $request) {
    // Culture for the game
    $culture = 'mk';
    $hasOpened = true;

    // Get i18n
    $i18n = $this->getContext()->getInstance()->getI18N();

    /*
     GAME STAT

     CREATE VIEW facebook_users_for_game1 AS


     SELECT sgu.first_name 'FIRST_NAME', sgu.last_name 'LAST_NAME', sgu.email_address 'EMAIL', up.gender 'GENDER', CONCAT(cty.name, ' - ', cty.slug) 'CITY', frgu.referer REGEXP 'from=' AS 'REFERER'

     FROM facebook_review_game_user AS frgu

     INNER JOIN sf_guard_user AS sgu ON (sgu.id = frgu.user_id)
     INNER JOIN user_profile AS up ON (up.id = sgu.id)
     INNER JOIN city AS cty ON (cty.id = up.city_id)

     WHERE frgu.facebook_review_game_id = 1

     ORDER BY frgu.id ASC
     */

    /*
     DO NOT REMOVE :)
     $params = array(
     'compare_param1' => array('gender' => 'Момци', 'text2' => 'Гласаше за момците'),
     'compare_param2' => array('gender' => 'Девојки', 'text2' => 'Гласаше за девоjките'),
     'mail'  => array(
     'subject' => "те кани да освоиш ваучер за вечера",
     'bodyP1' => "Здраво,",
     'body1' => "Јас учествував во Големиот натпревар на getlokal.\n",
     'prize' => "Учествувај и ти, и можеш да освоиш ваучер за вечера во ресторан Дион во вредност од 3000 денари! \n",
     'body2' => "Лесно е и забавно! \n",
     'signature' => "\n\r од Големиот натпревар \n\r",
     ),
     'facebook' => array(
     'share_on_wal_msg' => "Учествувај во натпреварот кои подобро се забавуваат кога излегуваат сами – момците или девојките:
     http://apps.facebook.com/momci-vs-devojki",

     )
     );


     echo base64_encode(serialize($params));
     //var_dump($params);
     exit;
     */


    //$this->getUser()->signOut();
    //exit;

    $this->facebookGame = Doctrine::getTable('FacebookReviewGame')
    ->createQuery('frg')
    ->where('frg.lang = ? and frg.status = ?', array($culture, 'opened'))
                ->andWhereNotIn('frg.id', array(5,6,7))
    ->fetchOne();

    if (!$this->facebookGame) {
      //$this->redirect('@homepage');
      // Get last closed game
      $this->facebookGame = Doctrine::getTable('FacebookReviewGame')
      ->createQuery('frg')
      ->where('frg.lang = ? and frg.status = ?', array($culture, 'closed'))
      ->orderBy('frg.id DESC')
      ->fetchOne();

      if ($this->facebookGame)
      {
        $hasOpened = false;
        $this->setTemplate('game2mkSplash');
      }
      else {
        $this->redirect('@homepage');
      }
    }

    if ($hasOpened && !$this->getUser()->isAuthenticated()) {
      if (strpos($request->getHost(), 'facebook.com') !== false || strpos($request->getReferer(), $this->facebookGame->getSlug()) !== false || strpos($request->getReferer(), '?from=facebook_game') !== false || strpos($request->getReferer(), 'iframehost.com') !== false) {
        //$this->getResponse()->setContent("<script type='text/javascript'>top.location.href='{$this->generateUrl('default', array('module' => 'facebook', 'action' => 'login', 'app' => '4'), true)}';</script>");

        $this->getResponse()->setContent("<script type='text/javascript'>top.location.href='{$this->generateUrl('default', array('module' => 'facebook', 'action' => 'login', 'app' => $this->facebookGame->getSlug()), true)}';</script>");
      }
      else {
        if (!$this->getUser()->hasAttribute('game.referer') || !$this->getUser()->getAttribute('game.referer', false)) {
          $this->getUser()->setAttribute('game.referer', $this->generateUrl('default', array('module' => 'facebook', 'action' => 'game2mk', 'sf_culture' => 'mk'), true));
        }

        $this->getResponse()->setContent("<script type='text/javascript'>top.location.href='{$this->generateUrl('sf_guard_signin', array(), true)}';</script>");
      }

      return sfView::NONE;
    }

    // Get game parameters from DB...
    $gameParams = unserialize(base64_decode($this->facebookGame->getFinalSupportText()));

    if (strpos($request->getHost(), 'facebook.com') !== false || strpos($request->getReferer(), $this->facebookGame->getSlug()) !== false || strpos($request->getReferer(), '?from=facebook_game') !== false || strpos($request->getReferer(), 'iframehost.com') !== false) {
      $this->isFbGame = true;
    }
    else {
      $this->isFbGame = false;

      $this->getResponse()->setTitle($this->facebookGame->getTitle());
    }


    //Show or hide an additional links
    // Winners and results
    $query = Doctrine::getTable('FacebookReviewGame')
    ->createQuery('frg')
    ->where('frg.lang = ? and frg.status = ?', array($culture, 'closed'))
    ->orderBy('frg.id DESC');

    $this->games = $query->execute();

    if ($type = $request->getGetParameter('type', null)) {
      if ($type == 'winners') {
        error_reporting(0);
        /*
         $query = Doctrine::getTable('FacebookReviewGame')
         ->createQuery('frg')
         ->where('frg.lang = ? and frg.status = ?', array($culture, 'closed'));

         $this->games = $query->execute();
         */
        $this->setTemplate('game2mkWinners');
      }
      elseif ($type == 'results') {
        error_reporting(0);
        /*
         $query = Doctrine::getTable('FacebookReviewGame')
         ->createQuery('frg')
         ->where('frg.lang = ? and frg.status = ?', array($culture, 'closed'));

         $this->games = $query->execute();
         */
        $this->setTemplate('game2mkResults');
      }
      elseif ($type == 'awards') {
        error_reporting(0);
        $this->setTemplate('game2mkAwards');
      }
    }

    // Set layout
    $this->setLayout('modal');


    // Game form
    $this->gameForm = new FacebookGame2Form();
    $this->inviteFromMailUrl = $this->generateUrl('default', array('module' => 'facebook', 'action' => 'game2mk', 'sf_culture' => 'mk'), true);

    // Invite
    $this->_setSubject($gameParams['mail']['subject']);
    $this->_setBody($gameParams, $this->inviteFromMailUrl);

    $this->sendInvitePMForm = new sendInvitePMForm(array(), array('body' => $this->body));

    if ($request->isMethod('post') && $request->getPostParameter('sendInvite', false) && $request->isXmlHttpRequest()) {
      $postData = $request->getPostParameter('formValues');
      $postData = explode('&', $postData);

      $formData = array();
      foreach ($postData as $key => $data) {
        $data = urldecode($data);
        $tmpKey = str_replace("sendInvitePM[", "", $data);
        $tmpKey = explode("]=", $tmpKey);
        $tmpKey = $tmpKey[0];

        $tmpData = explode("]=", $data);

        $formData[$tmpKey] = $tmpData[1];
      }

      $this->sendInvitePMForm->bind($formData);

      if ($this->sendInvitePMForm->isValid())
      {
        $formValues = $this->sendInvitePMForm->getValues();

        $emails = $readyRegisteredEmails = array();
        foreach ($formValues as $name => $value) {
          if (strpos($name, 'email_') !== false && $value) {
            $emails[] = $value;
          }
        }

        $tmpBody = $this->body;
        $this->body = $formValues['body'];

        $this->_send($emails);

        return $this->renderText(json_encode(array('success' => true, 'message' => $i18n->__('Your invite was sent successfully!', null, 'user'), 'body' => $tmpBody)));
      }
      else {
        $errors = array();
        foreach($this->sendInvitePMForm->getErrorSchema()->getErrors() as $widget => $error) {
          $errors[$widget] = $i18n->__($error->__toString(), null, 'form');
        }

        return $this->renderText(json_encode(array('error' => true, 'errors' => $errors)));
      }
    }

    // Send review
    if ($request->isMethod('post') && $request->getPostParameter('save', false) && $request->getPostParameter('review_place', false) && $request->getPostParameter('review_stars', false) && $request->getPostParameter('review_text', false)) {
      $companyPage = Doctrine::getTable('CompanyPage')->find($request->getPostParameter('review_place', NULL));

      if (!$companyPage) {
        exit(json_encode(array('error' => true)));
      }

      if ($this->facebookGame->getSlug() == 'momci-vs-devojki') {
        // Get user gender
        $gender = '';
        if ($this->getUser()->getProfile()->getGender() == 'm') {
          $gender = $gameParams['compare_param1']['gender'];
          $text2 = $gameParams['compare_param1']['text2'];
        }
        else {
          $gender = $gameParams['compare_param2']['gender'];
          $text2 = $gameParams['compare_param2']['text2'];
        }
      }


      // Create a directory
      if (!is_dir(sfConfig::get('sf_upload_dir') . '/facebook_game')) {
        mkdir(sfConfig::get('sf_upload_dir') . '/facebook_game');
      }

      try {
        $obj = $this->getUser()->getGuardUser();

        if ($obj) {
          $firstName = $obj->getFirstName() . ' ' . $obj->getLastName();
        }
      } catch (Exception $exc) {
        $this->redirect('default', array('module' => 'facebook', 'action' => 'game2mk'));
      }


      if ($this->facebookGame->getSlug() == 'momci-vs-devojki') {
        // Create an image
        $srcImage = imagecreatefrompng(sfConfig::get('sf_web_dir') . '/images/facebook/prizes/mk/game_' . $this->facebookGame->getId() . '_award_big.png');

        $holst = imagecreatetruecolor(403, 260);
        imagecopy($holst, $srcImage, 0, 0, 0, 0, 403, 260);

        $userNameColor = imagecolorallocate($holst, 255, 255, 255);
        $textColor = imagecolorallocate($holst, 255, 255, 255);

        $text1 = $firstName;

        $font1 = sfConfig::get('sf_web_dir') . '/images/facebook/v3/mk/MYRIADPRO-BOLDCOND.ttf';

        // Font size
        $fs1 = 30; // name
        $fs2 = 16.5; // name

        $size1 = imagettfbbox($fs1, 0, $font1, $text1);
        $this->calculateFontSize($size1, $font1, $text1, $fs1, 370);
        imagettftext($holst, $fs1, 0, 18, 34, $userNameColor, $font1, $text1);

        $size2 = imagettfbbox($fs2, 0, $font1, $text2);
        $this->calculateFontSize($size2, $font1, $text2, $fs2, 400);
        imagettftext($holst, $fs2, 0, 18, 54, $textColor, $font1, $text2);
      }

      //$tmp = sfConfig::get('sf_upload_dir') . '/' . uniqid() . '_game_bg.jpg';
      $tmp = sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_mk.jpg';
      imagejpeg($holst, $tmp, 100);


      if ($this->facebookGame->getSlug() == 'momci-vs-devojki') {
        // Create a small image
        $smallSrcImage = imagecreatefrompng(sfConfig::get('sf_web_dir') . '/images/facebook/prizes/mk/game_' . $this->facebookGame->getId() . '_award_small.png');
        $firstName = $this->getUser()->getGuardUser()->getFirstName() . ' ' . $this->getUser()->getGuardUser()->getLastName();

        $smallHolst = imagecreatetruecolor(111, 74);
        imagecopy($smallHolst, $smallSrcImage, 0, 0, 0, 0, 111, 74);

        $userNameColor = imagecolorallocate($smallHolst, 255, 255, 255);
        $textColor = imagecolorallocate($smallHolst, 255, 255, 255);

        $text1 = $firstName;
        $font1 = sfConfig::get('sf_web_dir') . '/images/facebook/v3/mk/MYRIADPRO-BOLDCOND.ttf';

        // Font size
        $fs1 = 10.25; // name
        $fs2 = 6.83; // name

        $smallSize1 = imagettfbbox($fs1, 0, $font1, $text1);
        $this->calculateFontSize($smallSize1, $font1, $text1, $fs1, 120);
        imagettftext($smallHolst, $fs1, 0, 6, 12, $userNameColor, $font1, $text1);

        $smallSize2 = imagettfbbox($fs2, 0, $font1, $text2);
        $this->calculateFontSize($smallSize2, $font1, $text2, $fs2, 100);
        imagettftext($smallHolst, $fs2, 0, 6, 20, $textColor, $font1, $text2);
      }

      $this->shareImg = sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_mk_share.jpg';
      imagejpeg($smallHolst, $this->shareImg, 100);

      $protocol = ($request->isSecure()) ? 'https://' : 'http://';
      $this->shareImg = $protocol . $request->getHost() . '/uploads/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_mk_share.jpg';



      $this->getResponse()->setCookie('from', $this->facebookGame->getSlug());


      // Generate an image
      $tmp = sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_mk.jpg';
      $file = new sfValidatedFile(uniqid() . '.jpg', filetype($tmp), $tmp, filesize($tmp));

      // Save generated image
      $this->image = new Image();
      $this->image->setFile($file);
      $this->image->setUserId($this->getUser()->getId());
      $this->image->save();

      // Save review
      $review = new Review();
      $review->setUserId($this->getUser()->getId());
      $review->setCompanyId($companyPage->getCompany()->getId());
      $review->setText($request->getPostParameter('review_text', ''));
      $review->setRating($request->getPostParameter('review_stars', '1'));
      //$review->setReferer('facebook_game2_bg');
      $review->save();

      // Save user
      $facebookReviewGameUser = new FacebookReviewGameUser();
      $facebookReviewGameUser->setUserId($this->getUser()->getId());
      $facebookReviewGameUser->setFacebookReviewGameId($this->facebookGame->getId());
      //$facebookReviewGameUser->setReferer($this->getUser()->setAttribute('game.referer', ''));
      $facebookReviewGameUser->setReferer($request->getReferer());
      $facebookReviewGameUser->save();

      // Remove referer attribute
      $this->getUser()->setAttribute('game.referer', NULL);

      // Increment and save game result
      $query = Doctrine::getTable('FacebookReviewGameResult')
      ->createQuery('frgr')
      ->where('frgr.facebook_review_game_id = ? and frgr.param1 = ?', array($this->facebookGame->getId(), $gender));

      $facebookReviewGameResult = $query->fetchOne();

      if ($facebookReviewGameResult)
      {
        $total = $facebookReviewGameResult->getParam2() + 1;

        $facebookReviewGameResult->setParam2($total);
      }
      else {
        $facebookReviewGameResult = new FacebookReviewGameResult();
        $facebookReviewGameResult->setFacebookReviewGameId($this->facebookGame->getId());
        $facebookReviewGameResult->setParam1($gender);
        $facebookReviewGameResult->setParam2(1);
      }

      $facebookReviewGameResult->save();

      // Count all users for current game
      $count = $this->facebookGame->getCountUsers();


      // All results
      $tmpArr = $this->facebookGame->getUserResults($count);
      $resArr['result'] = $tmpArr;

      $resArr['error'] = false;
      $resArr['total'] = $count;
      $resArr['image'] = $this->shareImg;
      //$protocol = ($request->isSecure()) ? 'https://' : 'http://';
      //$resArr['image'] = $protocol . $request->getHost() . '/uploads/facebook_game/' . $this->getUser()->getId() . '_game_mk_share.jpg';


      $token = "AAAFipGQmRHsBAE7gJL8cYTawrvUr2RP4J03IYb1TKqqWiaPCCEAX1YgATHMC59NbyVMR8QQZA5fbZCjmWwSes4AVegsRKqDrwdYHqfZA2U99mubgD1Q";

      // http://developers.facebook.com/tools/explorer?method=GET&path=100001642136166%3Ffields%3Did%2Cname
      // use id from $result = curl_exec($ch);
      // use application "Care e numele tau de party?"
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me/photos");
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_AUTOREFERER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); # required for https urls
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                'source' => '@' . $this->image->getFile()->getDiskPath(),
                'message' => $gameParams['facebook']['share_on_wal_msg'],
                'access_token' => $this->getUser()->getProfile()->getFBtoken()
      ));
      $result = curl_exec($ch);

      if (file_exists(sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_mk.jpg')) {
        //@unlink(sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->getUser()->getId() . '_game_mk.jpg');
        //@unlink(sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->getUser()->getId() . '_game_mk_share.jpg');
      }

      // Return response
      exit(json_encode($resArr));
    }


    if ($request->isMethod('post') && $request->getPostParameter('statistic', false)) {
      // Count all users for current game
      $count = $this->facebookGame->getCountUsers();

      // All results
      $tmpArr = $this->facebookGame->getUserResults($count);
      $resArr['result'] = $tmpArr;

      $resArr['error'] = false;
      $resArr['total'] = $count;

      // Return response
      exit(json_encode($resArr));
    }

    // Remove referer attribute
    $this->getUser()->setAttribute('game.referer', NULL);
  }


        // Trima za kusmet - Lucky three (bg, sr, mk)
        public function executeGame3(sfWebRequest $request) {
            if ($request->getParameter('show_report', false)) {
                ini_set('max_execution_time', 6000);
                set_time_limit(0);
                ini_set('memory_limit', '1024M');

                $this->getResponse()->clearHttpHeaders();
                $this->getResponse()->setHttpHeader('Pragma-Type', 'public');
                $this->getResponse()->setHttpHeader('Expires', '0');
                $this->getResponse()->setHttpHeader('Content-Type', 'application/CSV'); // text/csv
                $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename=report.csv');
                $this->getResponse()->setHttpHeader('Content-Transfer-Encoding', 'binary');


                $gameId = $request->getParameter('game_id', 6);
                $output = '';

                $con = Doctrine::getConnectionByTableName('facebook_review_game_user');
                $query = $con->execute(
                        "SELECT sgu.id AS USER_ID, frgu.hash, sgu.username AS USERNAME, sgu.first_name AS FIRSTNAME, sgu.last_name AS LASTNAME,
                        sgu.email_address AS EMAIL, CONCAT(c.name, ' - ', c.slug) AS CITY,
                        (SELECT SUM(frgu1.POINTS) FROM facebook_review_game_user AS frgu1 WHERE frgu1.user_id = sgu.id) AS POINTS,
                        iu.invited_from AS INVITED_USER_FROM, frgu.referer REGEXP 'from=' AS 'REFERER'

                        FROM facebook_review_game_user as frgu

                        INNER JOIN sf_guard_user AS sgu ON (frgu.user_id = sgu.id)
                        INNER JOIN user_profile AS up ON (sgu.id = up.id)
                        INNER JOIN city AS c ON (c.id = up.city_id)

                        LEFT JOIN invited_user AS iu ON (iu.user_id = frgu.user_id AND iu.hash = frgu.hash)

                        WHERE frgu.facebook_review_game_id = ? AND frgu.created_at >= '2013-04-12 00:00:00' AND frgu.created_at <= '2013-06-27 23:59:59'
                        GROUP BY sgu.id
                        ORDER BY POINTS DESC
                        /*ORDER BY sgu.id DESC*/
                    ", array($gameId));

                $users = $query->fetchAll();

                foreach ($users as $user) {
                    /* Only users who has any points */
                    $repeat = floor($user['POINTS'] / 3);

                    if ($repeat) {
                        for($i = 1; $i <= $repeat; $i++) {
                            $output .= $user['FIRSTNAME'] . ',' . $user['LASTNAME'] . ',' . $user['EMAIL']
                                    . ',' . $user['CITY'] . ',' . $user['POINTS'] . ',' . $user['INVITED_USER_FROM']
                                    . ',' . (!$user['REFERER'] ? 'site' : 'facebook') . ',' . $this->generateUrl('user_page', array('username' => $user['USERNAME']), true) . "\n";
                        }
                    }
                    else {
                        $output .= $user['FIRSTNAME'] . ',' . $user['LASTNAME'] . ',' . $user['EMAIL']
                            . ',' . $user['CITY'] . ',' . $user['POINTS'] . ',' . $user['INVITED_USER_FROM']
                            . ',' . (!$user['REFERER'] ? 'site' : 'facebook') . ',' . $this->generateUrl('user_page', array('username' => $user['USERNAME']), true) . "\n";
                    }
                }

                if ($output) {
                    $output = 'FIRSTNAME,LASTNAME,EMAIL,CITY,POINTS,INVITED_USER_FROM,REFERER,PROFILE_URL' . "\n" . $output . "\n";
                }

                return $this->renderText($output);
                exit;
            }
/*
 *
 *
 * SELECT sgu.id AS USER_ID, frgu.hash, sgu.username AS USERNAME, sgu.first_name AS FIRSTNAME, sgu.last_name AS LASTNAME,
                            sgu.email_address AS EMAIL, CONCAT(c.name, ' - ', c.slug) AS CITY, (SELECT SUM(frgu1.POINTS) FROM facebook_review_game_user AS frgu1) AS POINTS,
                            iu.invited_from AS INVITED_USER_FROM, frgu.referer REGEXP 'from=' AS 'REFERER'

                            FROM facebook_review_game_user as frgu

                            INNER JOIN sf_guard_user AS sgu ON (frgu.user_id = sgu.id)
                            INNER JOIN user_profile AS up ON (sgu.id = up.id)
                            INNER JOIN city AS c ON (c.id = up.city_id)

                            LEFT JOIN invited_user AS iu ON (iu.user_id = frgu.user_id AND iu.hash = frgu.hash)

                            WHERE frgu.facebook_review_game_id = ?
                            GROUP BY frgu.hash
                            ORDER BY sgu.id DESC
 */
            /*
            SELECT frgu.hash, sgu.first_name AS FIRSTNAME, sgu.last_name AS LASTNAME, sgu.email_address AS EMAIL, CONCAT(c.name, ' - ', c.slug) AS CITY, frgu.points AS POINTS, iu.invited_from AS INVITED_USER_FROM, frgu.referer REGEXP 'from=' AS 'REFERER'
            FROM facebook_review_game_user as frgu
            INNER JOIN sf_guard_user AS sgu ON (frgu.user_id = sgu.id)
            INNER JOIN user_profile AS up ON (sgu.id = up.id)
            INNER JOIN city AS c ON (c.id = up.city_id)

            LEFT JOIN invited_user AS iu ON (iu.user_id = frgu.user_id AND iu.hash = frgu.hash)

            WHERE frgu.facebook_review_game_id = 5
            */

            $this->getUser()->setAttribute('luckyTreeCode', $request->getParameter('code', NULL));

            $hasOpened = true;
            $this->fromFacebookGame = false;
            $this->userIsAuthenticated = $this->getUser()->isAuthenticated();
            $mailObject = null;
            $invalidObject = false;
            $this->setLayout('modal');

            /*-+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+-*/

            // Culture for the game
            $this->culture = $request->getParameter('sf_culture');    //$this->getUser()->getCulture();

            if (!in_array($this->culture, array('bg', 'sr', 'rs', 'mk'))) {
                $this->culture = 'bg';
            }

            // Get i18n
            $i18n = $this->getContext()->getInstance()->getI18N();

            /*-+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+-*/

            $this->facebookGame = Doctrine::getTable('FacebookReviewGame')
                                    ->createQuery('frg')
                                    ->where('frg.lang = ? and frg.status = ?', array($this->culture, 'opened'))
                                    ->fetchOne();

            if (!$this->facebookGame) {
                // Get last closed game
                $this->facebookGame = Doctrine::getTable('FacebookReviewGame')
                                    ->createQuery('frg')
                                    ->where('frg.lang = ? and frg.status = ?', array($this->culture, 'closed'))
                                    ->orderBy('frg.id DESC')
                                    ->fetchOne();

                if ($this->facebookGame)
                {
                    $hasOpened = false;
                    $this->setTemplate('game3Splash');
                }
                 else {
                    $this->redirect('@homepage');
                }
            }

            /*-+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+-*/

            // Get the user referer
            if (strpos($request->getHost(), 'facebook.com') !== false ||
                strpos($request->getReferer(), $this->facebookGame->getSlug()) !== false ||
                strpos($request->getReferer(), '?from=lucky-three-bg') !== false ||
                strpos($request->getReferer(), '?from=lucky-three-mk') !== false ||
                strpos($request->getReferer(), '?from=lucky-three-sr') !== false ||
                strpos($request->getReferer(), 'iframehost.com') !== false)
            {
                $this->fromFacebookGame = true;
            }
            else {
                if (!$this->getUser()->hasAttribute('game.referer') || !$this->getUser()->getAttribute('game.referer', false)) {
                    $this->getUser()->setAttribute('game.referer', $this->generateUrl('default', array('module' => 'facebook', 'action' => 'game3', 'sf_culture' => $this->culture), true));
                }

                $this->getResponse()->setTitle($this->facebookGame->getTitle());
            }

            /*-+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+-*/

            //Show or hide an additional links
            // Winners and results
            $query = Doctrine::getTable('FacebookReviewGame')
                    ->createQuery('frg')
                    ->where('frg.lang = ? and frg.status = ?', array($this->culture, 'closed'))
                    ->orderBy('frg.id DESC');

            $this->games = $query->execute();

            if ($type = $request->getGetParameter('type', null)) {
                if ($type == 'winners') {
                    error_reporting(0);

                    $this->setTemplate('game3Winners');
                }
                elseif ($type == 'results') {
                    error_reporting(0);

                    $this->setTemplate('game3Results');
                }
                elseif ($type == 'awards') {
                    error_reporting(0);

                    $this->setTemplate('game3Awards');
                }
            }

            /*-+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+-*/

            if (!$request->isMethod('post')) {
                $this->getUser()->setAttribute('emailList', array());
                $this->getUser()->setAttribute('emailList_static', null);
            }


            // For FB redirect
            if ($this->getUser()->getAttribute('goToStep', false) == 2) {
                $this->getUser()->setAttribute('hash', NULL);

                $this->hash = $this->_setHash();
                $this->getUser()->setAttribute('hash', $this->hash);
/*
                // Save user
                $facebookReviewGameUser = new FacebookReviewGameUser();
                $facebookReviewGameUser->setUserId($this->getUser()->getId());
                $facebookReviewGameUser->setFacebookReviewGameId($this->facebookGame->getId());
                //$facebookReviewGameUser->setReferer($this->getUser()->setAttribute('game.referer', ''));
                $facebookReviewGameUser->setReferer($request->getReferer());
                $facebookReviewGameUser->setHash($this->hash);
                $facebookReviewGameUser->save();
*/
                // Remove referer attribute
                $this->getUser()->setAttribute('game.referer', NULL);
                $this->getUser()->setAttribute('luckyTreeCode', NULL);
//$this->getUser()->setAttribute('goToStep', NULL);
                //return $this->renderText(json_encode(array('hash' => $this->hash)));
            }


            if ($request->isMethod('post') && $request->getPostParameter('step', false) && $request->isXmlHttpRequest()) {
                if ($request->getPostParameter('step', false) == 'step2') {
                    $this->getUser()->setAttribute('alreadySaved', false);
                    $this->getUser()->setAttribute('hash', NULL);

                    $this->hash = $this->_setHash();
                    $this->getUser()->setAttribute('hash', $this->hash);


                    // Create a directory
                    if (!is_dir(sfConfig::get('sf_upload_dir') . '/facebook_game')) {
                        mkdir(sfConfig::get('sf_upload_dir') . '/facebook_game');
                    }

                    try {
                        $obj = $this->getUser()->getGuardUser();

                        if ($obj) {
                            $firstName = $obj->getFirstName();
                            $lastName = $obj->getLastName();
                        }
                    } catch (Exception $exc) {
                        $this->redirect('default', array('module' => 'facebook', 'action' => 'game3'));
                    }

                    $text2 = $i18n->__('Invite your friends', null, 'facebookgame');


                    // Create an image
                    $srcImage = imagecreatefrompng(sfConfig::get('sf_web_dir') . '/images/facebook/prizes/' . $this->culture . '/game_' . $this->facebookGame->getId() . '_award_big.png');

                    $holst = imagecreatetruecolor(403, 260);
                    imagecopy($holst, $srcImage, 0, 0, 0, 0, 403, 260);

                    $userNameColor = imagecolorallocate($holst, 255, 255, 255);
                    $textColor = imagecolorallocate($holst, 255, 255, 255);

                    $text1 = $firstName . ' ' . $lastName;

                    $font = sfConfig::get('sf_web_dir') . '/images/facebook/v3/bg/pt-sans-narrow-bold.ttf';

                    // Font size
                    $fs1 = 28; // name
                    $fs2 = 16; // text

                    $size1 = imagettfbbox($fs1, 0, $font, $text1);
                    $this->calculateFontSize($size1, $font, $text1, $fs1, 260);
                    imagettftext($holst, $fs1, 0, 10, 35, $userNameColor, $font, $text1);

                    $size2 = imagettfbbox($fs2, 0, $font, $text2);
                    $this->calculateFontSize($size2, $font, $text2, $fs2, 400);
                    imagettftext($holst, $fs2, 0, 10, 58, $textColor, $font, $text2);

                    $tmp = sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_' . $this->culture . '.jpg';
                    imagejpeg($holst, $tmp, 100);



                    // Create a small image
                    $smallSrcImage = imagecreatefrompng(sfConfig::get('sf_web_dir') . '/images/facebook/prizes/' . $this->culture . '/game_' . $this->facebookGame->getId() . '_award_small.png');

                    $smallHolst = imagecreatetruecolor(111, 74);
                    imagecopy($smallHolst, $smallSrcImage, 0, 0, 0, 0, 111, 74);

                    $userNameColor = imagecolorallocate($smallHolst, 0, 0, 0);
                    $textColor = imagecolorallocate($smallHolst, 0, 0, 0);

                    $text1 = $firstName . ' ' . $lastName;
                    $font = sfConfig::get('sf_web_dir') . '/images/facebook/v3/bg/pt-sans-narrow-bold.ttf';

                    // Font size
                    $fs1 = 9; // name
                    $fs2 = 6.6; // name

                    $smallSize1 = imagettfbbox($fs1, 0, $font, $text1);
                    $this->calculateFontSize($smallSize1, $font, $text1, $fs1, 75);
                    imagettftext($smallHolst, $fs1, 0, 2, 10, $userNameColor, $font, $text1);

                    $smallSize2 = imagettfbbox($fs2, 0, $font, $text2);
                    $this->calculateFontSize($smallSize2, $font, $text2, $fs2, 100);
                    imagettftext($smallHolst, $fs2, 0, 2, 18, $textColor, $font, $text2);


                    $this->shareImg = sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_' . $this->culture . '_share.jpg';
                    imagejpeg($smallHolst, $this->shareImg, 100);

                    $protocol = ($request->isSecure()) ? 'https://' : 'http://';
                    $this->shareImg = $protocol . $request->getHost() . '/uploads/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_' . $this->culture . '_share.jpg';
                    $this->shareImgBig = $protocol . $request->getHost() . '/uploads/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_' . $this->culture . '.jpg';

                    $this->getResponse()->setCookie('from', $this->facebookGame->getSlug());


                    // Generate an image
                    $tmp = sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_' . $this->culture . '.jpg';
                    $file = new sfValidatedFile(uniqid() . '.jpg', filetype($tmp), $tmp, filesize($tmp));

                    // Save generated image
                    $this->image = new Image();
                    $this->image->setFile($file);
                    $this->image->setUserId($this->getUser()->getId());
                    $this->image->save();


                    // Remove referer attribute
                    $this->getUser()->setAttribute('game.referer', NULL);
                    $this->getUser()->setAttribute('luckyTreeCode', NULL);

                    return $this->renderText(json_encode(array('hash' => $this->hash, 'image_sm' => $this->shareImg, 'image' => $this->shareImgBig)));
                }

                if ($request->getPostParameter('step', false) == 'step3') {
                    $this->getUser()->setAttribute('emailList_static', null);

/*
                    $cntUserGames = Doctrine::getTable('FacebookReviewGameUser')
                                        ->createQuery('frgu')
                                        ->where('frgu.facebook_review_game_id = ? and frgu.user_id = ?', array($this->facebookGame->getId(), $this->getUser()->getId()))
                                        ->count();

                    $con = Doctrine::getConnectionByTableName('facebook_review_game_user');
                    $query = $con->execute('SELECT COUNT(*) AS cnt FROM facebook_review_game_user AS frgu
                        INNER JOIN invited_user AS iu ON (iu.user_id = frgu.user_id AND frgu.hash = iu.hash)
                        WHERE frgu.facebook_review_game_id = ? and frgu.user_id = ?
                        ', array($this->facebookGame->getId(), $this->getUser()->getId()));

                    $cntInvites = $query->fetch();

                    return $this->renderText(json_encode(array('success' => true, 'count' => $cntUserGames, 'cntInv' => $cntInvites['cnt'], 'image' => $this->shareImg)));
 */


                    $con = Doctrine::getConnectionByTableName('facebook_review_game_user');
                    $query1 = $con->execute('SELECT COUNT(DISTINCT(iu.facebook_uid)) AS cnt FROM facebook_review_game_user AS frgu
                        INNER JOIN invited_user AS iu ON (iu.user_id = frgu.user_id AND frgu.hash = iu.hash)
                        WHERE frgu.facebook_review_game_id = ? and frgu.user_id = ?
                        ', array($this->facebookGame->getId(), $this->getUser()->getId()));

                    $res1 = $query1->fetch();


                    $query2 = $con->execute('SELECT COUNT(DISTINCT(iu.email)) AS cnt FROM facebook_review_game_user AS frgu
                        INNER JOIN invited_user AS iu ON (iu.user_id = frgu.user_id AND frgu.hash = iu.hash)
                        WHERE frgu.facebook_review_game_id = ? and frgu.user_id = ?
                        ', array($this->facebookGame->getId(), $this->getUser()->getId()));

                    $res2 = $query2->fetch();

                    $cntInvites = $res1['cnt'] + $res2['cnt'];


                    $query = Doctrine_Query::create()
                       ->select("sum(frgu.points) as sm")
                       ->from('FacebookReviewGameUser frgu')
                       ->where('frgu.facebook_review_game_id = ? and frgu.user_id = ?', array($this->facebookGame->getId(), $this->getUser()->getId()))
                       ->fetchArray();

                    // count - game plays, cntInv - count of invited and registered users
                    return $this->renderText(json_encode(array('success' => true, 'count' => (int) floor($query[0]['sm']/3), 'cntInv' => (int) $cntInvites)));
                }

                die();
            }

            /*-+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+-*/

            $url = $this->generateUrl('default', array('module' => 'facebook', 'action' => 'game3'), true) . '?code=' . $this->getUser()->getAttribute('hash');

            $gameParams['mail'] = array(
                'subject' => $i18n->__('invites you to win iPhone 5',  null, 'facebookgame'),
                'bodyP1' => $i18n->__("Hi!",  null, 'facebookgame'),
                'body1' => $i18n->__("I'm participating in getlokal.com's game", null, 'facebookgame') . " (" . $this->generateUrl('default', array('module' => 'facebook', 'action' => 'game3'), true) . "#HASH#). \n\r",
                'prize' => $i18n->__("Please, register to help me win the Weekly Prize and the iPhone 5!",  null, 'facebookgame') . " \n" . $i18n->__('After you register, invite your friends and you can also enter the game with a chance to win.', null, 'facebookgame') . " \n",
                'body2' => "\n" . $i18n->__("Thank you!",  null, 'facebookgame') . " \n\n",
                'presignature' => $i18n->__("Best Regards,",  null, 'facebookgame') . "\n\r",
                'signature' => "\n\r",
            );

            $this->_setSubject($i18n->__('invites you to win iPhone 5', null, 'facebookgame'));
            //$this->_setSubject($i18n->__('те кани да спечелиш iPhone 5', null, 'facebookgame'));
            $this->_setBody($gameParams, $url);


            $this->inviteFromMailUrl = $this->generateUrl('default', array('module' => 'facebook', 'action' => 'game3'), true);

            $this->sendInvitePMForm = new sendInvitePMForm(array(), array('body' => $this->body));

            if ($this->getUser()->getGuardUser() && $request->isMethod('post') && $request->getPostParameter('sendInvite', false) && $request->isXmlHttpRequest()) {
                $postData = $request->getPostParameter('formValues');
                $postData = explode('&', $postData);

                $formData = array();
                foreach ($postData as $key => $data) {
                    $data = urldecode($data);
                    $tmpKey = str_replace("sendInvitePM[", "", $data);
                    $tmpKey = explode("]=", $tmpKey);
                    $tmpKey = $tmpKey[0];

                    $tmpData = explode("]=", $data);

                    $formData[$tmpKey] = $tmpData[1];
                }

                $this->sendInvitePMForm->bind($formData);

                if ($this->sendInvitePMForm->isValid())
                {
                    if (!$this->getUser()->getAttribute('alreadySaved', false)) {
                        // Save user
                        $facebookReviewGameUser = new FacebookReviewGameUser();
                        $facebookReviewGameUser->setUserId($this->getUser()->getId());
                        $facebookReviewGameUser->setFacebookReviewGameId($this->facebookGame->getId());
                        //$facebookReviewGameUser->setReferer($this->getUser()->setAttribute('game.referer', ''));
                        $facebookReviewGameUser->setReferer($request->getReferer());
                        $facebookReviewGameUser->setHash($this->getUser()->getAttribute('hash', ''));
                        $facebookReviewGameUser->save();

                        $this->getUser()->setAttribute('alreadySaved', true);
                    }

                    $formValues = $this->sendInvitePMForm->getValues();

                    $emails = $readyRegisteredEmails = array();
                    foreach ($formValues as $name => $value) {
                        if (strpos($name, 'email_') !== false && $value) {
                            $emails[] = $value;
                        }
                    }

                    $tmpBody = $this->body;
                    $this->body = $formValues['body'];

                    if ($emails && count($emails)) {
                        foreach ($emails as $email) {
                            $this->_saveIntoInvitedUsers($email);
                        }
                    }

                    $this->_send($emails);

                    return $this->renderText(json_encode(array('success' => true, 'message' => $i18n->__('Your invite was sent successfully!', null, 'user'), 'body' => $tmpBody)));
                }
                else {
                    $errors = array();
                    foreach($this->sendInvitePMForm->getErrorSchema()->getErrors() as $widget => $error) {
                        $errors[$widget] = $i18n->__($error->__toString(), null, 'form');
                    }

                    return $this->renderText(json_encode(array('error' => true, 'errors' => $errors)));
                }
            }


            if ($this->getUser()->getGuardUser() && $request->isMethod('post') && $request->getPostParameter('friendsList', false) && $request->isXmlHttpRequest()) {
                if ($html = $this->_friendsList($request, $this->facebookGame)) {
                    return $this->renderText(json_encode(array('success' => true, 'html' => $html)));
                }
                else {
                    return $this->renderText(json_encode(array('error' => true)));
                }
            }


            if ($this->getUser()->getGuardUser() && $request->isMethod('post') && $request->getPostParameter('sendInviteFB', false) && $request->isXmlHttpRequest()) {
                $id = $request->getPostParameter('friendId', '');

                if ($id) {
                    if (!$this->getUser()->getAttribute('alreadySaved', false)) {
                        // Save user
                        $facebookReviewGameUser = new FacebookReviewGameUser();
                        $facebookReviewGameUser->setUserId($this->getUser()->getId());
                        $facebookReviewGameUser->setFacebookReviewGameId($this->facebookGame->getId());
                        //$facebookReviewGameUser->setReferer($this->getUser()->setAttribute('game.referer', ''));
                        $facebookReviewGameUser->setReferer($request->getReferer());
                        $facebookReviewGameUser->setHash($this->getUser()->getAttribute('hash', ''));
                        $facebookReviewGameUser->save();

                        $this->getUser()->setAttribute('alreadySaved', true);
                    }


                    $this->_saveIntoInvitedUsers(null, $id, 'facebook');

                    // send
                    return $this->renderText(json_encode(array('success' => true, 'message' => $i18n->__('Your invite was sent successfully!', null, 'user'))));
                }
                else {
                    return $this->renderText(json_encode(array('error' => true, 'errors' => $errors)));
                }
            }


            if ($this->getUser()->getGuardUser() && !$this->fromFacebookGame) {
                if (stripos($this->getUser()->getGuardUser()->getEmailAddress(), 'gmail') !== false || stripos($this->getUser()->getGuardUser()->getEmailAddress(), 'yahoo') !== false) {
                    $mailObject = $this->__getMailObject($this->getUser()->getGuardUser()->getEmailAddress());

                    $this->isShort = true;
                } else {
                    $this->isShort = false;
                }

                $this->authorizeGYUrl = $this->generateUrl('default', array('module' => 'facebook', 'action' => 'game3'), true);
                $this->GYFormUrl = $this->generateUrl('default', array('module' => 'facebook', 'action' => 'game3'), true);


                $this->sendInviteGYForm = new sendInviteGYForm(array(), array('emails' => $this->getUser()->getAttribute('emailList'), 'body' => $this->body, 'removeCSRF' => true));

                if ($request->isMethod('post') && $request->getPostParameter('sendInviteGY', false) && $request->isXmlHttpRequest()) {
                    $postData = $request->getPostParameter('GYMailValues');
                    $postData = explode('&', $postData);

                    $formData = array();
                    foreach ($postData as $key => $data) {
                        $data = urldecode($data);

                        if (strpos($data, 'email_lists') === false) {
                            $tmpKey = str_replace("sendInviteGY[", "", $data);
                            $tmpKey = explode("]=", $tmpKey);
                            $tmpKey = $tmpKey[0];

                            $tmpData = explode("]=", $data);

                            $formData[$tmpKey] = $tmpData[1];
                        }
                        else {
                            $tmpData = explode("]=", $data);

                            if (!isset($formData['email_lists']) || !is_array($formData['email_lists'])) {
                                $formData['email_lists'] = array();
                            }

                            array_push($formData['email_lists'], $tmpData[1]);
                        }
                    }

                    $this->sendInviteGYForm->bind($formData);

                    if ($this->sendInviteGYForm->isValid())
                    {
                        if (!$this->getUser()->getAttribute('alreadySaved', false)) {
                            // Save user
                            $facebookReviewGameUser = new FacebookReviewGameUser();
                            $facebookReviewGameUser->setUserId($this->getUser()->getId());
                            $facebookReviewGameUser->setFacebookReviewGameId($this->facebookGame->getId());
                            //$facebookReviewGameUser->setReferer($this->getUser()->setAttribute('game.referer', ''));
                            $facebookReviewGameUser->setReferer($request->getReferer());
                            $facebookReviewGameUser->setHash($this->getUser()->getAttribute('hash', ''));
                            $facebookReviewGameUser->save();

                            $this->getUser()->setAttribute('alreadySaved', true);
                        }

                        //$this->getUser()->setAttribute('emailList', array());

                        $tmpBody = $this->body;
                        $this->body = $formData['body'];

                        if ($formData['email_lists'] && count($formData['email_lists'])) {
                            foreach ($formData['email_lists'] as $email) {
                                $this->_saveIntoInvitedUsers($email, null, 'gmail_yahoo');
                            }
                        }

                        if (!$this->getUser()->getAttribute('emailList_static', false)) {
                            $this->getUser()->setAttribute('emailList_static', $this->getUser()->getAttribute('emailList', array()));
                        }

                        $this->_send($formData['email_lists']);

                        return $this->renderText(json_encode(array('success' => true, 'message' => $i18n->__('Your invite was sent successfully!', null, 'user'), 'body' => $tmpBody)));
                    }
                    else {
                        //echo $this->sendInviteGYForm->renderGlobalErrors();

                        foreach($this->sendInviteGYForm->getErrorSchema()->getErrors() as $widget => $error) {
                            $errors[$widget] = $i18n->__($error->__toString(), null, 'form');
                        }

                        //$errorGY = $i18n->__('Wrong e-mail address or/and password!', null, 'user');

                        return $this->renderText(json_encode(array('error' => true, 'errors' => $errors)));
                    }
                }

                $this->loginMailForm = new loginMailForm(array(), array('isShort' => $this->isShort, 'removeCSRF' => true));

                if ($request->isMethod('post') && $request->getPostParameter('authorizeGY', false) && $request->isXmlHttpRequest()) {
                    $postData = $request->getPostParameter('loginGYMailValues');
                    $postData = explode('&', $postData);

                    $formData = array();
                    foreach ($postData as $key => $data) {
                        $data = urldecode($data);
                        $tmpKey = str_replace("loginMail[", "", $data);
                        $tmpKey = explode("]=", $tmpKey);
                        $tmpKey = $tmpKey[0];

                        $tmpData = explode("]=", $data);

                        $formData[$tmpKey] = $tmpData[1];
                    }

                    $this->loginMailForm->bind($formData); //$request->getParameter($this->loginMailForm->getName())
                    $errorGY = false;

                    if ($this->loginMailForm->isValid())
                    {
                        $formValues = $this->loginMailForm->getValues();

                        if ($this->isShort) {
                            $mailObject->setUsername($this->getUser()->getGuardUser()->getEmailAddress());
                        }
                        else {
                            if (!$mailObject = $this->__getMailObject($formValues['email_address'])) {
                                $invalidObject = true;
                            }
                            else {
                                $mailObject->setUsername($formValues['email_address']);
                            }
                        }

                        if (!$invalidObject) {
                            $mailObject->setPassword($formValues['email_password']);

                            if (get_class($mailObject) == 'Yahoo_mail') {
                                $param = 'ALL';
                            }
                            elseif (get_class($mailObject) == 'G_mail') {
                                $param = 'SINGLE';
                            }

                            // Try to connect to mail server
                            if ($mailObject->init($param) !== false) {
                                //$this->results = $mailObject->toHtml('', '<br />');

                                if (count($mailObject->getEmailsArray())) {
                                    $this->getUser()->setAttribute('emailList', $mailObject->getEmailsArray());
                                    //$this->getRequest()->setParameter('emailList', $mailObject->getEmailsArray());

//                                  $GYSendFormTemplate = $this->renderPartial('inviteViaGY');
                                    $this->sendInviteGYForm = new sendInviteGYForm(array(), array('emails' => $this->getUser()->getAttribute('emailList'), 'body' => $this->body));
                                    $GYSendFormTemplate = $this->getPartial('inviteViaGY', array('url' => $this->GYFormUrl, 'sendInviteGYForm' => $this->sendInviteGYForm));

                                    // Close the connection and unset the object
                                    unset($mailObject);

                                    return $this->renderText(json_encode(array('success' => true, 'html' => $GYSendFormTemplate)));
                                }
                                else {
                                    unset($mailObject);

                                    $errorGY = $i18n->__('Your e-mail list is empty!', null, 'user');
                                }
                            }
                            else {
                                $errorGY = $i18n->__('Wrong e-mail address or/and password!', null, 'user');
                            }
                        }
                        else {
                            $errorGY = $i18n->__('You entered a wrong e-mail address format!', null, 'user');
                        }
                    }
                    else {
                        //echo $this->loginMailForm->renderGlobalErrors();

                        foreach($this->loginMailForm->getErrorSchema()->getErrors() as $widget => $error) {
                            $errors[$widget] = $i18n->__($error->__toString(), null, 'form');
                        }

                        //$errorGY = $i18n->__('Wrong e-mail address or/and password!', null, 'user');

                        return $this->renderText(json_encode(array('error' => true, 'errors' => $errors)));
                    }

                    if ($errorGY) {
                        if ($this->isShort) {
                            return $this->renderText(json_encode(array('error' => true, 'errors' => array('email_password' => $errorGY))));
                        }
                        else {
                            return $this->renderText(json_encode(array('error' => true, 'errors' => array('email_address' => $errorGY))));
                        }
                    }
                    else {
                        return $this->renderText(json_encode(array('success' => true, 'message' => $i18n->__('Your invite was sent successfully!', null, 'user'), 'body' => $tmpBody)));
                    }
                }
            }

            /*-+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+--+-+-*/
        }

        private function _friendsList(sfWebRequest $request, $facebookGame = null) {
            if ($request->isMethod('post') && $request->getPostParameter('friendsList', false) && $request->isXmlHttpRequest()) {
                $inviteFacebookUrl = $this->generateUrl('default', array('module' => 'facebook', 'action' => 'game3'), true);
                $friendsList = $disabledList = array();
                foreach ($request->getPostParameter('friendsList', array()) as $friend) {
                    $name = $friend['name'];
                    $id = $friend['id'];

                    if (mb_strlen($name,'utf8') > 15) {
                        $name = mb_substr($name, 0, 14, 'utf8') . '...';
                    }

                    $friendsList[$id] = $name;
                    if ($this->__checkIfUserExists($id)) {
                        $disabledList[] = $id;
                    }
                }

                $html = $this->getPartial('friendsList', array('friendsList' => $friendsList, 'disabledList' => $disabledList, 'url' => $inviteFacebookUrl, 'body' => $this->body, 'facebookGame' => $facebookGame));

                return $html;
            }

            return false;
        }

        private function __checkIfUserExists($facebookID) {
            if ($user = Doctrine::getTable('UserProfile')->findOneByFacebookUid($facebookID)) {
                return true;
            }
            else {
                return false;
            }
        }

        private function _saveIntoInvitedUsers($email = null, $facebookUID = null, $invited_from = 'email') {
            if (!$this->getUser()->getId() || (!$email && !$facebookUID)) return false;

            $invitedUser = new invitedUser();

            if ($email) {
                $invitedUser->setEmail($email);

                $hash = $this->getUser()->getAttribute('hash', $this->_setHash());
            }
            else {
                $invitedUser->setFacebookUid($facebookUID);

                $hash = $this->getUser()->getAttribute('hash', $this->_setHash());
                //$this->getUser()->setAttribute('hash', null);
            }

            $invitedUser->setHash($hash);
            $invitedUser->setInvitedFrom($invited_from);
            $invitedUser->setPointsToInvited(10);
            $invitedUser->setPointsToUser(10);
            $invitedUser->setUserId($this->getUser()->getId());
            $invitedUser->save();
        }

        private function __getMailObject($email = null) {
            $isMail = 0;
            $mailObject = null;

            $isMail = (stripos($email, '@gmail') !== false ? 1 : $isMail);
            $isMail = (stripos($email, '@yahoo') !== false ? 2 : $isMail);

            switch ($isMail) {
                case 1:
                    $mailObject = new G_mail();
                    break;
                case 2:
                    $mailObject = new Yahoo_mail();
                    break;
                //default:
                //    $mailObject = new G_mail();
            }

            return $mailObject;
        }

        private function _setHash() {
            $hash = md5(time() . uniqid(rand(), true));
            $hash = substr($hash, 0, 30);

            return $hash;
        }

  private function _setSubject($subject) {
    $this->subject = $this->getUser()->getProfile()->getFirstName() . ' ' . $subject;
  }

  private function _setBody($gameParams, $gameUrl, $prize = '') {
    $this->bodyP1 = $gameParams['mail']['bodyP1'];
    $this->body = $gameParams['mail']['body1'];
    $this->body .= $gameParams['mail']['prize'];
    $this->body .=  $gameParams['mail']['body2'];

    $this->underBodySignature = (isset($gameParams['mail']['presignature']) ? $gameParams['mail']['presignature'] : '') . $this->getUser()->getProfile()->getFirstName() . ' '. $this->getUser()->getProfile()->getLastName() . $gameParams['mail']['signature'] . " {$gameUrl}";

    $this->body = $this->bodyP1 . "\n\r" . $this->body;
  }

  // Save into invite tbl
  private function _send($emails = null) {
    if ($emails) {
      if (is_array($emails) && count($emails)) {
        foreach ($emails as $key => $email) {
          $this->_sendInvites($email, 2);
        }
      }
      else {
        $this->_sendInvites($emails);
      }
    }

    $this->getUser()->setAttribute('emailList', array());
  }

  private function _sendInvites($email = null, $key = 0) {
    $this->body = $this->__sanitarize($this->body);
    //$this->underBodySignature = $this->__sanitarize($this->underBodySignature);

                if ($key > 1) {
            $this->body = nl2br($this->body);
                  $this->underBodySignature = nl2br($this->underBodySignature);
                }

    $usernameArray = $this->getUser()->getAttribute('emailList', array());


    if (in_array($email, array_keys($usernameArray))) {
      $username = explode(" <", $usernameArray[$email]);
      $username = $username[0];
    }
    else {
      $username = '';
    }

    myTools::sendMail(array($email => $username), $this->subject, 'invite', array('body' => $this->body . "<br /><br />" . $this->underBodySignature));
  }

  private function __sanitarize ($param) {
    $param = strip_tags($param);

    $param = preg_replace("/<[^>]*>/", "", $param);

    return $param;
  }

  // Autocomplete
  public function executeSearch(sfWebRequest $request) {
    $this->cityId = $request->getParameter('cityId');
    $this->placeStr = trim($request->getParameter('place', null));
    $this->culture = $this->getUser()->getCulture();

    $this->places = $this->__search($this->placeStr, $this->cityId);
  }

  //Autocomplete romanian version
  public function executeSearchro(sfWebRequest $request) {
    $this->cityId = $request->getParameter('cityId');
    $this->placeStr = trim($request->getParameter('place', null));
    $this->culture = $this->getUser()->getCulture();

    $this->places = $this->__search($this->placeStr, $this->cityId);
  }

  // Autocomplete
  private function __search($placeName, $cityId, $limit = 10) {
    $placeName = mb_convert_case($placeName, MB_CASE_TITLE, "UTF-8");
    $placeName = "%" . $placeName . "%";

    $query = Doctrine::getTable('CompanyPage')
    ->createQuery('p')
    ->innerJoin('p.Company c')
    ->where('(c.title LIKE ? or c.title_en LIKE ? ) and c.city_id = ? and c.status=0', array ($placeName, $placeName, $cityId))
    ->andWhere('c.status = ? ', CompanyTable::VISIBLE)
    ->orderBy('p.created_at DESC')
    ->groupBy('c.id')
    ->limit($limit);

    // echo $query->getSqlQuery(), "<br />", $placeName, "<br />", $cityId;
    // exit;

    return $query->execute();
  }

  // Get facebook image
  public function getFbImage(&$imageType = 'large', &$userImagePath, &$userImage) {
    $userImage = file_get_contents($userImagePath . $imageType);

    // php v.5.4 only
    //list($width, $height) = getimagesizefromstring($userImage);

    // php v.5.3
    list($width, $height) = getimagesize($userImagePath . $imageType);

    if ($width != $height) {
      $imageType = 'square';
      $this->getFbImage($imageType, $userImagePath, $userImage);
    }
    else {
      return array($imageType, $userImagePath, $userImage);
    }
  }

  // Calc fontsize
  public function calculateFontSize(&$size = null, $font, $text, &$fs, $maxW = 147, $maxFSize = 5) {
    if ($size[2] - $size[0] > $maxW && $fs != $maxFSize) {
      $fs--;
      $size = imagettfbbox($fs, 0, $font, $text);

      $this->calculateFontSize($size, $font, $text, $fs, $maxW, $maxFSize);
    }
    else {
      $size = imagettfbbox($fs, 0, $font, $text);

      return array($size, $fs);
    }
  }
  /* END */

  public function executeAutocomplete(sfWebRequest $request) {
    $query = Doctrine::getTable('Company')
    ->createQuery('c')
    ->innerJoin('c.Translation ctr')
    ->where('ctr.title LIKE ?', '%' . $request->getParameter('term') . '%')
    ->andWhere('c.country_id = ?', $this->getUser()->getCountry()->getId())
    ->limit(10);

    $return = array();
    $culture = sfContext::getInstance()->getUser()->getCulture();
    foreach ($query->execute() as $company) {
      $return[] = array(
                'value' => $company->getCompanyTitleByCulture(),
                'id' => $company->getId()
      );
    }

    $this->getResponse()->setContent(json_encode($return));

    return sfView::NONE;
  }

  public function executeAutocompleteCity(sfWebRequest $request) {
    $query = Doctrine::getTable('City')
    ->createQuery('c')
    ->innerJoin('c.Translation ctr')
    ->innerJoin('c.County co')
    ->where('ctr.name LIKE ?', '%' . $request->getParameter('term') . '%')
    ->andWhere('co.country_id = ?', $this->getUser()->getCountry()->getId())
    ->limit(10);

    $return = array();

    foreach ($query->execute() as $city) {
      $return[] = array(
                'value' => $city->getName(),
                'id' => $city->getId()
      );
    }

    $this->getResponse()->setContent(json_encode($return));

    return sfView::NONE;
  }

  public function executeLogin(sfWebRequest $request) {
            $config = array(
    1 => array(
                'app_id' => '293718400743527',
                'app_secret' => '5e1924a908737ea7dd228642e8fafeab',
                'url' => 'http://apps.facebook.com/getlokal-party-name/'
                ),

                2 => array(
                'bg' => array(
                    'app_id' => '558060340886089',
                    'app_secret' => '35ec14aaa5e09ea367ac2b94d868d4fc',
                    'url' => 'http://apps.facebook.com/reviewmania-x-bg',
                    'permisions'  => 'publish_actions,user_friends,user_location,email,user_birthday'
                    ),
                'ro' => array(
                    'app_id' => '370054869750634',
                    'app_secret' => '7bb7b78cb3658d55c0b785b0dc0b0454',
                    'url' => 'http://apps.facebook.com/reviewmania-x-ro'
                    ),
                'mk' => array(
                    'app_id' => '644296142259425',
                    'app_secret' => 'f8722cc688dfea7a90cdb4d7542d55ac',
                    'url' => 'http://apps.facebook.com/reviewmania-mk'
                    ),
        		'sr' => array(
                    'app_id' => '685816038129660',
                    'app_secret' => '2808ed6f149f67e7157ae44551841353',
                    'url' => 'http://apps.facebook.com/reviewmania-x-sr',
                    'permisions'  => 'user_likes,user_photos,user_friends,user_location,photo_upload,email,user_birthday'
                    )
                ),

                    // BG party game
                    //3
                '3' => array(
                    'app_id' => '135295206626676',
                    'app_secret' => 'af4cff3ae85822f5f950195c93712f1e',
                    'url' => 'http://apps.facebook.com/getlokal-pname-bg/'
                    ),

                    // BG muge vs jeni
                    // 4
                'getlokal-big-race' => array(
                    'app_id' => '389933171098747',
                    'app_secret' => 'a529b9eb441be9500b560bb65e92695f',
                    'url' => 'http://apps.facebook.com/getlokal-big-race'
                    ),

                    // BG Sofia vs country
                    // 5
                'sofia-vs-country' => array(
                    'app_id' => '139337716231028',
                    'app_secret' => 'd1f9f304708ed7b48764681826ac455f',
                    'url' => 'http://apps.facebook.com/sofia-vs-country'
                    ),

                    // BG momci vs devojli
                'momci-vs-devojki' => array(
                    'app_id' => '131526950354477',
                    'app_secret' => '74c8f874014a1208e77214d2b3ce2167',
                    'url' => 'http://apps.facebook.com/momci-vs-devojki'
                    ),
                    /*
                     4 => array(
                     'app_id'      => '389933171098747',
                     'app_secret'  => 'a529b9eb441be9500b560bb65e92695f',
                     'url'         => 'http://apps.facebook.com/getlokal-big-race'
                     ),
                     */
                    5 => array(
                    'app_id'      => '127234997453806',
                    'app_secret'  => '8a519a6b2fe1413a74f9feabf20474e0',
                    'url'         => 'http://apps.facebook.com/getlokal-getlove',
                    'permisions'  => 'user_photos,user_birthday,user_likes,photo_upload,user_status,user_events,user_location'       
                    ),

                'pop-folk-vs-other' => array(
                    'app_id' => '101255206731369',
                    'app_secret' => '15d6c42e397863587cab8ed8c397e922',
                    'url' => 'http://apps.facebook.com/pop-folk-vs-other'
                    ),

                'pop-folk-vs-other-copy' => array(
                    'app_id' => '590322517647631',
                    'app_secret' => '91c3fc5daa7f4bd703e61be90cb49fb1',
                    'url' => 'http://apps.facebook.com/pop-folk-vs-others'
                    ),

                'big-race-ro' => array(
                    'app_id' => '394728430634966',
                    'app_secret' => '579bf7e47d016361eb3b57bd139a8cd5',
                    'url' => 'http://apps.facebook.com/big-race-ro'
                    ),

        		'bere-vs-vin' => array(
                    'app_id' => '525540210839584',
                    'app_secret' => '0304e34691ac6a7e9cdb148e43dc5efc',
                    'url' => 'http://apps.facebook.com/bere-vs-vin'
                    ),

/*
                // TEST
                'big-race-ro' => array(
                    'app_id' => '132152363602991',
                    'app_secret' => 'f6403518651b5ec2a1366998414e794b',
                    'url' => 'http://apps.facebook.com/mys_test_app'
                    ),
*/

                // Lucky three
                'lucky-three-bg' => array(
                    'app_id' => '430198693740282',
                    'app_secret' => 'f0d2d0ccfcab13149a93a80f2652d607',
                    'url' => 'http://apps.facebook.com/lucky-three-bg'
                ),

                'lucky-three-sr' => array(
                    'app_id' => '111070179087144',
                    'app_secret' => '89f79e8e79911e94cf1d283aaa738bc9',
                    'url' => 'http://apps.facebook.com/lucky-three-sr'
                ),

                'lucky-three-mk' => array(
                    'app_id' => '579081232109732',
                    'app_secret' => '4e097719948eb92a18c6fba8bce0c904',
                    'url' => 'http://apps.facebook.com/lucky-three-mk'
                ),

				'hot-summer-race' => array(
                    'app_id' => '191865117646261',
                    'app_secret' => '72835c0a7d8d6a196856e0fbfffce721',
                    'url' => 'http://apps.facebook.com/hot-summer-race'
                 )
            );

            if ($request->getParameter('app', false) == 'lucky-three-bg' || $request->getParameter('app', false) == 'lucky-three-sr' || $request->getParameter('app', false) == 'lucky-three-mk') {
                $this->getUser()->setAttribute('goToStep', '2');
            }
            else {
                $this->getUser()->setAttribute('goToStep', NULL);
            }

                $app_config = $config[$request->getParameter('app', 1)];
                if(isset($app_config[$this->getUser()->getCountry()->getSlug()]))
                $app_config = $app_config[$this->getUser()->getCountry()->getSlug()];

                $my_url = $this->generateUrl ( 'default', array ('module' => 'facebook', 'action' => 'login', 'app' => $request->getParameter('app', 1) ), true );

                $this->getUser()->setReferer($request->getParameter('referer'));

                $code = $request->getParameter ( 'code' );

                // Loop redirect bugfix
                if ($request->getParameter('error') == 'access_denied' || $request->getParameter('error_code') == '200') {
                    $this->redirect('http://www.facebook.com/me');
                }

                if(empty ( $code )) {
                  $permisions = isset($app_config['permisions'])? ','. $app_config['permisions']: '';
                  $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" . $app_config['app_id'] . "&redirect_uri=" . urlencode ( $my_url ) . '&scope=user_location,email,user_birthday,offline_access,user_checkins,publish_actions'. $permisions;

                  $this->redirect($dialog_url);
                }

                $token_url = "https://graph.facebook.com/oauth/access_token?client_id=" . $app_config['app_id'] . "&redirect_uri=" . urlencode($my_url) . "&client_secret=" . $app_config['app_secret'] . "&code=" . $code;

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $token_url);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_AUTOREFERER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); # required for https urls

                $access_token = curl_exec($ch);

                curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me?" . $access_token);

                $user_data = json_decode(curl_exec($ch), true);

                if (isset($user_data['id']) && $user_data ['id']) {
                    $profile = Doctrine::getTable('UserProfile')->findOneByFacebookUid($user_data ['id']);
                }
                else {
                    $profile = null;
                }

                if (!$profile) {
                  if (!$user = Doctrine::getTable('sfGuardUser')->findOneByEmailAddress($user_data ['email'])) {
                    curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me/picture?type=large&" . $access_token);

                    $temp_pic = sfConfig::get('sf_upload_dir') . '/' . uniqid('tmp_') . '.jpg';
                    file_put_contents($temp_pic, curl_exec($ch));

                    $file = new sfValidatedFile(myTools::cleanUrl($user_data ['name']) . '.jpg', filetype($temp_pic), $temp_pic, filesize($temp_pic));

                    $password = substr(md5(rand(100000, 999999)), 0, 8);

                    $user = new sfGuardUser ();
                    $user->setEmailAddress($user_data ['email']);
                    $user->setUsername(substr(uniqid(md5(rand()), true), 0, 8));
                    $user->setFirstName($user_data ['first_name']);
                    $user->setLastName($user_data ['last_name']);
                    $user->setPassword($password);
                    $user->save();

                    $date = DateTime::createFromFormat('m/d/Y', $user_data ['birthday']);

                    /*
                     * OLD
                     $query = Doctrine::getTable('City')->createQuery('c')->innerJoin('c.County co')->where('co.country_id = ?', $this->getUser()->getCountry()->getId());

                     $profile = new UserProfile ();

                     $fbUserCity = array_shift(explode(',', $user_data['location']['name']));

                     if ($city = $query->andWhere('c.name LIKE ? OR c.name_en LIKE ?', array($fbUserCity, $fbUserCity))->fetchOne()) {
                     $profile->setCityId($city->getId());
                     $country_id = $city->getCounty()->getCountryId();
                     $profile->setCountryId($country_id);
                     } else {
                     $profile->setCountryId(getlokalPartner::getInstance());
                     $city = Doctrine::getTable('City')
                     ->createQuery('c')
                     ->innerJoin('c.County co')
                     ->where('co.country_id = ?', getlokalPartner::getInstance())
                     ->orderBy('c.is_default DESC')
                     ->limit(1)
                     ->fetchOne();

                     $profile->setCityId($city->getId());
                     }
                     */

                    $profile = new UserProfile ();
                    $profile->setId($user->getId());
                        $profile->setFacebookUid($user_data['id']);
                    $profile->setGender($user_data ['gender'] == 'male' ? 'm' : 'f' );
                    $profile->setBirthDate($date->format('Y-m-d'));
                    $profile->setFacebookUrl($user_data ['link']);


                    if (isset($user_data['location']['name']) && $user_data['location']['name']) {
                      $location = explode(", ", $user_data['location']['name']);

                      $country = array_pop($location);

                      $result = Doctrine_Query::create()
                      ->from('Country c')
                      ->where('c.name = ? OR c.name_en = ?', array($country, $country))
                      ->fetchOne();

                      if ($result && $result->getId()) {
                        $tmpCountryId = $result->getId();
                      }
                      else {
                        $tmpCountryId = getlokalPartner::getInstance();
                      }

                      $tmpCityId = null;

                      if ($location) {
                        $founded = false;

                        foreach ($location as $locCity) {
                          $city = $locCity;

                          $result = Doctrine_Query::create()
                          ->from('City c')
                          ->innerJoin('c.Translation ct')
                          ->innerJoin('c.County co')->where('co.country_id = ?', $tmpCountryId)
                          ->where('ct.name = ?', $city)
                          ->fetchOne();

                          if ($result && $result->getId()) {
                            $founded = true;

                            $tmpCityId = $result->getId();
                            break 1;
                          }
                        }

                        if (!$founded) {
                          $city = Doctrine::getTable('City')->createQuery('c')->innerJoin('c.County co')->where('co.country_id = ?', $tmpCountryId)->orderBy('c.is_default DESC')->limit(1)->fetchOne();

                          if ($city) {
                            $tmpCityId = $city->getId();
                          }
                        }
                      }
                      else {
                        $city = Doctrine::getTable('City')->createQuery('c')->innerJoin('c.County co')->where('co.country_id = ?', $tmpCountryId)->orderBy('c.is_default DESC')->limit(1)->fetchOne();

                        if ($city) {
                          $tmpCityId = $city->getId();
                        }
                      }
                    }
                    else {
                      $tmpCountryId = getlokalPartner::getInstance();

                      $city = Doctrine::getTable('City')->createQuery('c')->innerJoin('c.County co')->where('co.country_id = ?', $tmpCountryId)->orderBy('c.is_default DESC')->limit(1)->fetchOne();
                      if ($city) {
                        $tmpCityId = $city->getId();
                      }
                    }

                    if ($tmpCountryId && $tmpCityId) {
                      $profile->setCityId($tmpCityId);
                      $profile->setCountryId($tmpCountryId);
                    }

                    $profile->save();

                    $image = new Image ();
                    $image->setFile($file);
                    $image->setUserId($profile->getId());
                    $image->setCaption($user_data ['name']);
                    $image->setType('profile');
                    $image->setStatus('approved');
                    $image->save();

                    $profile->clearRelated();
                    $profile->setImageId($image->getId());
                    $profile->save();

                    @unlink($temp_pic);


                    //User profile and newsletter
                    $user_settings = new UserSetting();
                    $user_settings->setId($profile->getId());

                    if ($profile->getCountryId() > 4) {
                      $user_settings->setAllowContact(true);
                      $user_settings->setAllowNewsletter(false);
                    } else {
                      $user_settings->setAllowContact(true);
                      $user_settings->setAllowNewsletter(true);
                      $user_settings->setAllowPromo(true);
                    }

                    $user_settings->save();

                    // Subscribe to newsletter
                    $newsletters = NewsletterTable::retrieveActivePerCountryForUser($profile->getCountryId());
                    if ($newsletters) {
                      foreach ($newsletters as $newsletter) {
                        $usernewsletter = new NewsletterUser ();
                        $usernewsletter->setNewsletterId($newsletter->getId());
                        $usernewsletter->setUserId($user->getId());
                        $usernewsletter->setIsActive(1);
                        $usernewsletter->save();
                      }

                      MC::subscribe_unsubscribe($user);
                    }

                    //myTools::sendMail ( $user, 'Welcome to Getlokal', 'fbRegister', array ('password' => $password ) );
                  } else {
                    if (!$user->getPassword()) {
                      $password = substr(md5(rand(100000, 999999)), 0, 8);
                      $user->setPassword($password);
                      $user->save();
                    }
                    $profile = $user->getUserProfile();
                    if (!$profile->getFacebookUid()) {
                      $profile->setFacebookUid($user_data ['id']);
                            //$this->__calculateGamePoints(NULL, $user_data['id']);
                    }
                  }

                    $this->__calculateGamePoints(NULL, $user->getUserProfile()->getFacebookUid());
                }

                if (!$profile->getCountryId())
                $profile->setCountryId($this->getUser()->getCountry()->getId());

                $profile->setAccessToken($access_token);
                $profile->save();

                $this->getUser()->signIn($profile->getSfGuardUser(), true);

                // Set city after login
                if ($this->getUser()->getCountry()->getId() == $this->getUser()->getProfile()->getCountry()->getId()) {
                  $this->getUser()->setCity($this->getUser()->getProfile()->getCity());
                  $this->getUser()->setAttribute('user.set_city_after_login', true);
                }

                $this->redirect($app_config['url']);
  }

  public function executeReview(sfWebRequest $request)
  {
    if($this->getUser()->getCountry()->getSlug() == 'mk' || strpos($request->getReferer(), 'reviewmania-mk') !== false){
      $this->setTemplate('reviewMania');
      if($request->isMethod('post') && $request->getParameter('play'))
      {
        $this->setTemplate('review');
      }
    }


    if($this->getUser()->getCountry()->getSlug() == 'mk') {
    if (!$this->getUser()->isAuthenticated()) {
      if (strpos($request->getHost(), 'facebook.com') !== false || strpos($request->getReferer(), 'facebook.com') !== false || strpos($request->getReferer(), '?from=facebook_game_reviews') !== false || strpos($request->getReferer(), 'reviewmania-mk') !== false || strpos($request->getReferer(), 'iframehost.com') !== false) {
        $this->getResponse()->setContent("<script type='text/javascript'>top.location.href='{$this->generateUrl('default', array('module' => 'facebook', 'action' => 'login', 'app' => 2), true)}';</script>");
      }
      else {
        if (!$this->getUser()->hasAttribute('game.referer') || !$this->getUser()->getAttribute('game.referer', false)) {
          $this->getUser()->setAttribute('game.referer', $this->generateUrl('default', array('module' => 'facebook', 'action' => 'review', 'sf_culture' => 'mk'), true));
        }
        $this->getResponse()->setContent("<script type='text/javascript'>top.location.href='{$this->generateUrl('sf_guard_signin', array(), true)}';</script>");
      }

      return sfView::NONE;
    }
  }

  else {
    if(!$this->getUser()->isAuthenticated()) {
      $this->getResponse()->setContent("<script type='text/javascript'>top.location.href='{$this->generateUrl('default', array('module' => 'facebook', 'action' => 'login', 'app' => 2), true)}';</script>");

      return sfView::NONE;
      }
  }

    $this->app_id = array(
      'bg' => '558060340886089',
      'ro' => '370054869750634',
      'mk' => '644296142259425',
      'sr' => '685816038129660'
      );

      $this->setLayout('modal');

      if(!$this->city = Doctrine::getTable('City')->find($request->getParameter('city_id', 0)))
      {
        $this->city = Doctrine::getTable('City')
        ->createQuery('c')
        ->innerJoin('c.County co')
        ->where('co.country_id = ?', $this->getUser ()->getCountry ()->getId ())
        ->orderBy('c.id = '. $this->getUser()->getAttribute('city_id', 0). ' DESC')
        ->addOrderBy('c.is_default DESC')
        ->fetchOne();
      }

      $this->getUser()->setAttribute('city_id', $this->city->getId());

      $this->sectors = Doctrine::getTable('Sector')
      ->createQuery('s')
      ->innerJoin('s.Translation st')
      ->orderBy('st.rank')
      ->where('st.rank > 0')
      ->limit(5)
      ->execute();

      if($this->getUser()->getCountry()->getSlug() == 'ro')
      {
        $names = array('Restaurante', 'Baruri', 'Cluburi', 'Cafenele & ceainării', 'Entertainment');
        foreach($this->sectors as $i=>$sector)
        {
        $sector->setTitle($names[$i]);
        }
      }

      if(!$request->getParameter('sector_id'))
      {
        $request->setParameter('sector_id', $this->sectors->getPrimaryKeys());
      }

      if($this->getUser()->getCountry()->getSlug() == 'sr'){
         $this->count = Doctrine::getTable('Review')
        ->createQuery('r')
        ->where('r.user_id = ?', $this->getUser()->getId())
        ->andWhere('r.referer = ?', 'rev_mania_april14')
        ->groupBy('r.company_id')
        ->count();

      }
      elseif($this->getUser()->getCountry()->getSlug() == 'bg'){
         $this->count = Doctrine::getTable('Review')
        ->createQuery('r')
        ->where('r.user_id = ?', $this->getUser()->getId())
        ->andWhere('r.referer = ?', 'rev_mania_bg_new')
        ->groupBy('r.company_id')
        ->count();

      }
      else{
        $this->count = Doctrine::getTable('Review')
        ->createQuery('r')
        ->where('r.user_id = ?', $this->getUser()->getId())
        ->andWhere('r.created_at > ?', '2013-10-01 00:00:00')
        ->groupBy('r.company_id')
        ->count();
      }

      if($request->isMethod('post') && $request->getParameter('next'))
      {
        $this->setTemplate('review');

        $this->sectors = Doctrine::getTable('Sector')
        ->createQuery('s')
        ->whereIn('s.id', $request->getParameter('sector_id'))
        ->limit(5)
        ->execute();

        $black_list = (array) $this->getUser()->getAttribute('black_list', array(0));
        $black_list = $this->cleanList($black_list);

        $query = Doctrine::getTable('Company')
        ->createQuery('c')
        ->leftJoin('c.Image')
        ->innerJoin('c.Sector s')
        ->innerJoin('s.Translation')
        ->leftJoin('c.TopReview')
        ->leftJoin('c.Review r WITH r.user_id = ?', $this->getUser()->getId())
        ->innerJoin('c.Classification cl')
        ->innerJoin('cl.ClassificationSector cs')
        ->whereIn('cs.sector_id', $request->getParameter('sector_id'))
        ->andWhere('c.city_id = ?', $this->city->getId())
        ->andWhere('c.status = 0')
        ->andWhere('c.country_id = ?', $this->getUser()->getCountry()->getId())
        ->andWhere('c.city_id = ?', $this->city->getId())
        ->andWhere('r.id IS NULL')
        ->andWhereNotIn('c.id', $black_list)
        ->limit(3)
//        ->orderBy('c.score ASC')
        ->addOrderBy('RAND()');

        $this->count = $query->count();

        $this->places = $query->execute();

        if($this->getUser()->getCountry()->getSlug() == 'sr'){
          $this->reviews_count = Doctrine::getTable('Review')
          ->createQuery('r')
          ->where('r.user_id = ?', $this->getUser()->getId())
          ->andWhere('r.referer = ?', 'rev_mania_april14')
          ->groupBy('r.company_id')
          ->count();
        } 
        elseif($this->getUser()->getCountry()->getSlug() == 'bg'){
          $this->reviews_count = Doctrine::getTable('Review')
          ->createQuery('r')
          ->where('r.user_id = ?', $this->getUser()->getId())
          ->andWhere('r.referer = ?', 'rev_mania_bg_new')
          ->groupBy('r.company_id')
          ->count();
        } 
        else{
          $this->reviews_count = Doctrine::getTable('Review')
          ->createQuery('r')
          ->where('r.user_id = ?', $this->getUser()->getId())
          ->andWhere('r.created_at > ?', '2013-10-01 00:00:00')
          ->groupBy('r.company_id')
          ->count();
        }

        return 'Done';
      }
  }

  public function cleanList($old_list)
  {
    $black_list = array();

    foreach($old_list as $id)
    {
      if($id > 1) $black_list[] = $id;
    }
    return $black_list;
  }

  public function executeLoadReview(sfWebRequest $request)
  {
    $black_list = (array) $this->getUser()->getAttribute('black_list', array());
    $black_list[] = $request->getParameter('id');
    $this->getUser()->setAttribute('black_list', $black_list);

    foreach($request->getParameter('ids', array()) as $id)
    $black_list[] = $id;

    $black_list = $this->cleanList($black_list);

    $company = Doctrine::getTable('Company')
    ->createQuery('c')
    ->leftJoin('c.Image')
    ->leftJoin('c.Review r WITH r.user_id = ?', $this->getUser()->getId())
    ->leftJoin('c.TopReview')
    ->innerJoin('c.Classification cl')
    ->innerJoin('cl.ClassificationSector cs')
    ->whereIn('cs.sector_id', $request->getParameter('sector_id'))
    ->andWhere('c.city_id = ?', $request->getParameter('city_id'))
    ->andWhere('c.status = 0')
    ->andWhere('c.country_id = ?', $this->getUser()->getCountry()->getId())
    ->andWhere('r.user_id IS NULL')
    ->andWhereNotIn('c.id', $black_list)
    ->limit(1)
    ->orderBy('c.score DESC')
    ->addOrderBy('RAND()')
    ->fetchOne();

    if($this->getUser()->getCountry()->getSlug() == 'sr'){
      $count = Doctrine::getTable('Review')
      ->createQuery('r')
      ->where('r.user_id = ?', $this->getUser()->getId())
      ->andWhere('r.referer = ?', 'rev_mania_april14')
      ->groupBy('r.company_id')
      ->count();
    } 
    elseif($this->getUser()->getCountry()->getSlug() == 'bg'){
      $count = Doctrine::getTable('Review')
      ->createQuery('r')
      ->where('r.user_id = ?', $this->getUser()->getId())
      ->andWhere('r.referer = ?', 'rev_mania_bg_new')
      ->groupBy('r.company_id')
      ->count();
    } 
    else{
      $count = Doctrine::getTable('Review')
      ->createQuery('r')
      ->where('r.user_id = ?', $this->getUser()->getId())
      ->andWhere('r.created_at > ?', '2013-10-01 00:00:00')
      ->groupBy('r.company_id')
      ->count();
    }


    if($company) {
      if($this->getUser()->getCountry()->getSlug() == 'mk')
      {
        $this->getResponse()->setContent($this->getPartial('placeBox', array('company' => $company, 'form' => new ReviewForm(), 'count' => $count)));
      }else
      {
        $this->getResponse()->setContent($this->getPartial('placeBox', array('company' => $company, 'form' => new ReviewForm(), 'count' => $count)));
      }
    }
    return sfView::NONE;
  }

  public function executeReviewSave(sfWebRequest $request)
  {
/*
 * REPORT FOR REVIEW GAMES
select user_id AS USER_ID, sgu.first_name AS FIRST_NAME, sgu.last_name AS LAST_NAME, sgu.email_address AS EMAIL, r.created_at AS CREATED_AT,

(
  select count(sub_r.id) as cnt from review as sub_r
  inner join company as sub_c on (sub_c.id = sub_r.company_id)
  where sub_r.user_id = r.user_id and sub_r.referer = 'facebook_game_reviews' and sub_c.country_id = 3
  and (sub_r.created_at >= '2013-03-28 00:00:00' and sub_r.created_at <= '2013-04-28 23:59:59')
) AS TOTAL_REVIEWS,

(
  select FLOOR(count(sub_r.id) / 3) as cnt from review as sub_r
  inner join company as sub_c on (sub_c.id = sub_r.company_id)
  where sub_r.user_id = r.user_id and sub_r.referer = 'facebook_game_reviews' and sub_c.country_id = 3
  and (sub_r.created_at >= '2013-03-28 00:00:00' and sub_r.created_at <= '2013-04-28 23:59:59')
) AS NUM_CHANCES

from review as r
inner join company as c on (c.id = r.company_id)
inner join sf_guard_user as sgu on (sgu.id = r.user_id)
where
r.referer = 'facebook_game_reviews'
and c.country_id = 3
and (r.created_at >= '2013-03-28 00:00:00' and r.created_at <= '2013-04-28 23:59:59')
 */
    $this->forward404Unless($company = Doctrine::getTable('Company')->find($request->getParameter('id')));

    $form = null;
    if($this->getUser()->getCountry()->getSlug() == 'mk'){
      $form = new ReviewFBForm();
    }else{
      $form = new ReviewFBForm();
    }
    $params = $request->getParameter($form->getName());
//    var_dump($params);
//    exit();
    $form->bind($params);

    if($form->isValid())
    {

      $review = $form->updateObject();
      $review->setCompanyId($company->getId());
      $review->setUserId($this->getUser()->getId());

      if($this->getUser()->getCountry()->getSlug() == 'sr'){
        $review->setReferer('rev_mania_april14');
      } 
      elseif($this->getUser()->getCountry()->getSlug() == 'bg'){
        $review->setReferer('rev_mania_bg_new');
      }
      else{
        $review->setReferer('facebook_review_game');
      }

      $review->save();
    } else{
      $errors = array();
        foreach($form->getErrorSchema()->getErrors() as $widget => $error) {
          $errors[$widget] = $error->__toString();
        }
//        var_dump($errors);
    }

    if($this->getUser()->getCountry()->getSlug() == 'sr'){
      $count = Doctrine::getTable('Review')
      ->createQuery('r')
      ->where('r.user_id = ?', $this->getUser()->getId())
      ->andWhere('r.referer = ?', 'rev_mania_april14')
      ->groupBy('r.company_id')
      ->count();
    } 
    elseif($this->getUser()->getCountry()->getSlug() == 'bg'){
      $count = Doctrine::getTable('Review')
      ->createQuery('r')
      ->where('r.user_id = ?', $this->getUser()->getId())
      ->andWhere('r.referer = ?', 'rev_mania_bg_new')
      ->groupBy('r.company_id')
      ->count();
    }
    else{
      $count = Doctrine::getTable('Review')
      ->createQuery('r')
      ->where('r.user_id = ?', $this->getUser()->getId())
      ->andWhere('r.created_at > ?', '2013-10-01 00:00:00')
      ->groupBy('r.company_id')
      ->count();
    }

    $this->getResponse()->setContent($this->getPartial('placeBox', array('company' => $company, 'form' => $form, 'count' => $count)));

    $this->redirectUnless($request->isXmlHttpRequest(), $request->getReferer());
    return sfView::NONE;
  }

        private function __calculateGamePoints($email = null, $facebookUID = null) {
            $gameCode = null;
            $gameType = null;
            $gameId = null;

            if ($this->getUser()->hasAttribute('luckyTreeCode', false)) {
                $gameCode = $this->getUser()->getAttribute('luckyTreeCode', '');
                $gameType = 'LuckyTree';

                if ($this->getUser()->getCulture() == 'bg') {
                    $gameId = 5;
                }
                elseif ($this->getUser()->getCulture() == 'mk') {
                    $gameId = 6;
                }
                elseif ($this->getUser()->getCulture() == 'sr') {
                    $gameId = 7;
                }
                else {
                    $gameId = 5;
                }
            }
            else {
                if ($this->getUser()->getCulture() == 'bg') {
                    $gameId = 5;
                }
                elseif ($this->getUser()->getCulture() == 'mk') {
                    $gameId = 6;
                }
                elseif ($this->getUser()->getCulture() == 'sr') {
                    $gameId = 7;
                }
                else {
                    $gameId = 5;
                }
            }

            $this->getUser()->setAttribute('luckyTreeCode', NULL);

            if (true || $gameCode) {
                $query = Doctrine::getTable('InvitedUser')
                         ->createQuery('iu');
                         // without a code
                         //->where('iu.hash = ?', $gameCode);

                if ($email) {
                    $query->andWhere('iu.email =?', $email);
                }
                elseif ($facebookUID) {
                    $query->andWhere('iu.facebook_uid =?', $facebookUID);
                }

                $query->addGroupBy('iu.user_id');

                $result = $query->execute();

                //if ($result = $query->fetchOne()) {
                foreach ($result as $res) {
                    $sQuery = Doctrine::getTable('FacebookReviewGameUser')
                             ->createQuery('frgu')
                             ->where('frgu.facebook_review_game_id =?', $gameId)
                             ->andWhere('frgu.user_id =?', $res->getUserId());
                             // without a code
                             //->andWhere('frgu.hash =?', $gameCode);

                    if ($sResul = $sQuery->fetchOne()) {
                        $points = $sResul->getPoints() + 1;
                        $sResul->setPoints($points);
                        $sResul->save();
                    }
                }
            }
        }

  public function executeGetLove(sfWebRequest $request)
  {
    if(!$this->getUser()->isAuthenticated())
    {
      $this->getResponse()->setContent("<script type='text/javascript'>top.location.href='{$this->generateUrl('default', array('module' => 'facebook', 'action' => 'login', 'app' => 5), true)}';</script>");

      return sfView::NONE;
    }

    $access_token = $this->getUser()->getProfile()->getFBtoken();
    $this->access_token = $access_token;
    $this->setLayout('modal');

    if($request->hasParameter('reset'))
    {
      Doctrine::getTable('FacebookGame')
      ->createQuery('fb')
      ->where('fb.user_id = ?', $this->getUser()->getId())
      ->andWhere('fb.game = ?', 'gl_ro_get_love')
      ->delete()
      ->execute();
    }
    /*
     $query = Doctrine::getTable('FacebookGame')
     ->createQuery('g')
     ->where('g.user_id = ?', $this->getUser()->getId())
     ->andWhere('g.game = ?', 'gl_ro_get_love');

     if($query->count() && $a = $query->execute())
     {
     foreach($a as $answer)
     $answers[$answer->getQuestion()] = $answer->getAnswer();

     $this->image = Doctrine::getTable('Image')->find($answer->getUid());

     return 'Success';
     }
     */
    if($request->getParameter('step', 1) == 2)
    {
      $fql_multiquery_url = 'https://graph.facebook.com/'
      . 'fql?q={"friends":"SELECT+uid,name,pic_square+FROM+user+WHERE+uid+IN+(SELECT+uid2+FROM+friend+WHERE+uid1=me())+ORDER+BY+name",'
      . '"relationship":"SELECT+uid,pic_square,name+FROM+user+WHERE+uid+IN+(SELECT+significant_other_id+FROM+user+WHERE+uid=me())"}'
      . '&access_token=' . $access_token;

      $fql_multiquery_result = myTools::curl_get_file($fql_multiquery_url);
      $fql_multiquery_obj = json_decode($fql_multiquery_result, true);

      //var_dump($fql_multiquery_obj);die();

      foreach($fql_multiquery_obj['data'] as $data)
      {

        if($data['name'] == 'friends')
        {
          $this->friends = json_encode($data['fql_result_set']);
        }
        if($data['name'] == 'relationship')
        {
          $this->relationship = $data['fql_result_set'][0];
        }
      }

      return 'Form';
    }

    if($request->getParameter('step', 1) == 3)
    {
      $friend_id = $request->getParameter('friend_id');
      $q = array(
        'pic'       => urlencode("SELECT src FROM photo WHERE object_id IN (SELECT object_id FROM photo_tag WHERE subject = me()) AND object_id IN (SELECT object_id FROM photo_tag WHERE subject = {$friend_id}) ORDER BY created ASC"),
        'likes'     => urlencode("SELECT name, type, pic FROM page WHERE page_id IN (SELECT page_id FROM page_fan WHERE uid = me()) AND page_id IN (SELECT page_id FROM page_fan WHERE uid = {$friend_id})"),
        'events'    => urlencode("SELECT pic, name FROM event WHERE eid IN (SELECT eid FROM event_member WHERE uid = {$friend_id}) AND eid IN (SELECT eid FROM event_member WHERE uid = me())"),
        'checkins'  => urlencode("SELECT pic, name FROM page WHERE page_id IN (SELECT page_id FROM location_post WHERE ({$friend_id} IN tagged_uids OR author_uid = {$friend_id} ) ) AND page_id IN ( SELECT page_id FROM location_post WHERE ({$this->getUser()->getProfile()->getFacebookUid()} IN tagged_uids OR author_uid = {$this->getUser()->getProfile()->getFacebookUid()} ))"),
        'friends'   => urlencode("SELECT mutual_friend_count, name, sex FROM user WHERE uid = {$friend_id}"),
        'my_name'   => urlencode("SELECT name FROM user WHERE uid = me()")
      );

      $fql_multiquery_url = 'https://graph.facebook.com/fql?q='. json_encode($q). '&access_token=' . $access_token;
      $fql_multiquery_obj = json_decode(myTools::curl_get_file($fql_multiquery_url), true);

      $friends = json_decode(myTools::curl_get_file('https://graph.facebook.com/me/mutualfriends/1634517256?limit=8&access_token='. $access_token), true);
      $events = $likes = $checkins = array();
      foreach($fql_multiquery_obj['data'] as $data)
      {
        if($data['name'] == 'pic')
        {
          foreach($data['fql_result_set'] as $i => $img)
          if($i == 0)
          $pic = $data['fql_result_set'][0]['src'];
          else
          $images[] = $img;
        }
        if($data['name'] == 'likes')
        {
          foreach($data['fql_result_set'] as $like)
          $likes[$like['type']][] = $like;
        }
        if($data['name'] == 'events')
        {
          foreach($data['fql_result_set'] as $event)
          $events[] = $event;
        }
        if($data['name'] == 'checkins')
        {
          foreach($data['fql_result_set'] as $checkin)
          $checkins[] = $checkin;
        }
        if($data['name'] == 'friends')
        {
          $friend = $data['fql_result_set'][0];
        }
        if($data['name'] == 'my_name')
        {
          $my_name = $data['fql_result_set'][0]['name'];
        }
      }

      $over   = imagecreatefrompng(sfConfig::get('sf_web_dir').'/images/facebook/v4/diploma.png');
      $final  = imagecreatetruecolor(1200, 1214);
      $this->friend_name = $friend['name'];
      if($friend['sex'] != 'male')
      {
        $face2  = imagecreatefromstring(myTools::curl_get_file('https://graph.facebook.com/me/picture?access_token='. $access_token));
        $face1  = imagecreatefromstring(myTools::curl_get_file("https://graph.facebook.com/{$friend_id}/picture?access_token=". $access_token));
      }
      else
      {
        $face1  = imagecreatefromstring(myTools::curl_get_file('https://graph.facebook.com/me/picture?access_token='. $access_token));
        $face2  = imagecreatefromstring(myTools::curl_get_file("https://graph.facebook.com/{$friend_id}/picture?access_token=". $access_token));
      }
      if (isset($pic)){
        $pic    = imagecreatefromstring(myTools::curl_get_file($pic. "?access_token=". $access_token));
      }
      $width = imagesx($face1);
      imagecopyresampled($final, $face1, 425, 118, 0, 0, 90, 90, $width, $width);
      $width = imagesx($face2);
      imagecopyresampled($final, $face2, 664, 89, 0, 0, 90, 90, $width, $width);

      imagecopy($final, $over, 0, 0, 0, 0, 1200, 1214);
      if (isset($pic)){
        $width = imagesx($pic);
        $height = imagesy($pic);
        list($tx, $ty, $tw, $th) = myTools::getCopyRegion($width, $height, 181, 117);
      }
      imagecopyresampled($final, $pic, 852, 107, $tx, $ty, 181, 117, $tw, $th);
      if (isset($images)){
        foreach($images as $i => $pic)
        {
          $pic    = imagecreatefromstring(myTools::curl_get_file($pic['src']));
          $width  = imagesx($pic);
          $height = imagesy($pic);
          list($tx, $ty, $tw, $th) = myTools::getCopyRegion($width, $height, 60, 60);

          if($i==0)
          {
            list($tx, $ty, $tw, $th) = myTools::getCopyRegion($width, $height, 140, 139);

            imagecopyresampled($final, $pic, 651, 472, $tx, $ty, 140, 139, $tw, $th);
          }
          elseif($i<4)
          imagecopyresampled($final, $pic, 812 + (($i - 1) * 81), 472, $tx, $ty, 60, 60, $tw, $th);
          elseif($i<5)
          imagecopyresampled($final, $pic, 812 + (($i - 4) * 81), 552, $tx, $ty, 60, 60, $tw, $th);
          else
          {
            break;
          }
        }
      }
      foreach($friends['data'] as $i => $f)
      {
        $pic    = imagecreatefromstring(myTools::curl_get_file("https://graph.facebook.com/{$f['id']}/picture?access_token=". $access_token));

        $width = imagesx($pic);

        if($i<5)
        imagecopyresampled($final, $pic, 167 + ($i * 81), 472, 0, 0, 60, 60, $width, $width);
        else
        imagecopyresampled($final, $pic, 167 + (($i - 5) * 81), 552, 0, 0, 60, 60, $width, $width);
      }

      $purple = imagecolorallocate($final, 78, 61, 87);
      $white  = imagecolorallocate($final, 255, 255, 255);
      $blue   = imagecolorallocate($final, 133, 197, 200);
      $font   = sfConfig::get('sf_web_dir').'/images/facebook/v1/OpenSans-Bold.ttf';
      $fonti  = sfConfig::get('sf_web_dir').'/images/facebook/v1/OpenSans-BoldItalic.ttf';
      $fontl  = sfConfig::get('sf_web_dir').'/images/facebook/v1/OpenSans-Light.ttf';

      $text = $friend['name']." + ". $my_name;
      $size = imagettfbbox(38, 0, $font, $text);
      imagettftext($final, 38, 0, 600 - (($size[2] - $size[0]) / 2), 710, $blue, $font, $text);

      if(($friend['mutual_friend_count'] - 8) > 0)
      {
        $size = imagettfbbox(28, 0, $fonti, '+ '. ($friend['mutual_friend_count'] - 8));
        imagettftext($final, 28, 0, 480 - (($size[2] - $size[0]) / 2), 595, $white, $fonti, '+ '. ($friend['mutual_friend_count'] - 8));
      }
      if(count($images) - 5 > 0)
      {
        $size = imagettfbbox(28, 0, $fonti, '+ '. (count($images) - 5));
        imagettftext($final, 28, 0, 965 - (($size[2] - $size[0]) / 2), 595, $white, $fonti, '+ '. (count($images) - 5));
      }
      if($request->getParameter('place'))
      {
        //$text = substr($request->getParameter('place'), 0, 15);
        //$size = imagettfbbox(18, 0, $fonti, $text);
        //imagettftext($final, 18, 0, 950 - (($size[2] - $size[0]) / 2), 315, $purple, $fonti, $text);

        if (strlen($request->getParameter('place')) > 21) {
          $text = substr($request->getParameter('place'), 0, 21) . '...';
        }
        else {
          $text = substr($request->getParameter('place'), 0, 21);
        }

        $size = imagettfbbox(11, 0, $fonti, $text);
        imagettftext($final, 11, 0, 945 - (($size[2] - $size[0]) / 2), 315, $purple, $fonti, $text);
      }
      if (isset($likes['MUSICIAN/BAND'])){
        foreach($likes['MUSICIAN/BAND'] as $i => $like)
        {
          if($i == 3)
          {
            imagettftext($final, 30, 0, 345, 945, $white, $font, '+alte '. (count($likes['MUSICIAN/BAND']) - 3));
            break;
          }
          imagettftext($final, 16, 0, 380, 810 + ($i * 40), $white, $fontl, $like['name']);
        }
      }
      $i=0;
      $count_shows = isset($likes['TV SHOW'] ) ? count($likes['TV SHOW']) : 0 ;
      $count_movies =isset($likes['MOVIE'] )?  count( $likes['MOVIE']): 0;


      if ($count_shows ){

        foreach($likes['TV SHOW'] as $i => $like)
        {
          if($i == 3)
          {
            imagettftext($final, 30, 0, 824, 945, $white, $font, '+alte '. ($count_shows + $count_movies - 3));
            break;
          }
          $name = (strlen($like['name']) > 30 ? substr($like['name'], 0, 30).'...' : $like['name']);
          imagettftext($final, 16, 0, 860, 810 + ($i * 40), $white, $fontl, $name );
        }

      }
      if ($count_movies && $i < 3)
      {

        foreach($likes['MOVIE'] as $j => $like)
        {
          if($i == 3)
          {
            imagettftext($final, 30, 0, 824, 945, $white, $font, '+alte '. ($count_shows + $count_movies - 3));
            break;
          } elseif($i > 3)
          {
            break;
          }
          $i++;
          $name = (strlen($like['name']) > 30 ? substr($like['name'], 0, 30).'...' : $like['name']);

          imagettftext($final, 16, 0, 860, 810 + ($i * 40), $white, $fontl, $name );
        }


      }
      //OR $likes['MOVIE THEATER']


      foreach($events as $i => $like)
      {
        if($i == 3)
        {
          imagettftext($final, 30, 0, 345, 1175, $white, $font, '+alte '. (count($events) - 3));
          break;
        }
        $name = (strlen($like['name']) > 30 ? substr($like['name'], 0, 30).'...' : $like['name']);
        imagettftext($final, 16, 0, 380, 1045 + ($i * 40), $white, $fontl, $name );
      }
      foreach($checkins as $i => $like)
      {
        if($i == 3)
        {
          imagettftext($final, 30, 0, 824, 1175, $white, $font, '+alte '. (count($checkins) - 3));
          break;
        }
        $name = (strlen($like['name']) > 30 ? substr($like['name'], 0, 30).'...' : $like['name']);
        imagettftext($final, 16, 0, 860, 1045 + ($i * 40), $white, $fontl, $name );
      }

      $tmp = sfConfig::get('sf_upload_dir'). '/'. uniqid(). '.jpg';
      imagejpeg($final, $tmp, 80);

      $file = new sfValidatedFile ( uniqid() . '.jpg', filetype ( $tmp ), $tmp, filesize ( $tmp ) );

      $this->image  = new Image();
      $this->image->setFile($file);
      $this->image->setUserId($this->getUser()->getId());
      $this->image->setType('profile');
      $this->image->save();

      $game = new FacebookGame();
      $game->setUid($this->image->getId());
      $game->setUserId($this->getUser()->getId());
      $game->setGame('gl_ro_get_love');
      $game->setQuestion('place_id');
      $game->setAnswer($request->getParameter('place_id'));
      if($request->getParameter('save_photo'))
      {
        $game->setShared(true);
      }
      $game->save();

      $place = ($request->getParameter('place_id') ? Doctrine::getTable('Company')->findOneById($request->getParameter('place_id')): null);
      $message= 'Am generat poza de mai sus cu aplicatia getLove. Incerci si tu? http://apps.facebook.com/getlokal-getlove!';
      if ($place)
      {

        $place_link= $this->getController()->genUrl($place->getUri(ESC_RAW), true);
        $message = 'Cu '.$this->friend_name.' imi place sa ies in '.$place->getCompanyTitle().' (' .$place_link. ')'.'. '.$message;
      }
      if($request->getParameter('save_photo'))
      {
        $ch = curl_init ();
        curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me/photos" );
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_AUTOREFERER, true );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false ); # required for https urls
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
          'source'  => '@'. $this->image->getFile()->getDiskPath(),
          'message' => $message ,
        'access_token' => $access_token
        ));

        $result = curl_exec($ch);
      }
      /*q1=SELECT pic FROM user WHERE uid IN (SELECT significant_other_id FROM user WHERE uid=me());
       q2=SELECT uid, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1=me())";*/
      return 'Success';
    }
    return 'Start';
  }

  public function executeGame4(sfWebRequest $request){
    // Culture for the game
    $culture = 'bg';
    $hasOpened = true;
    $this->setLayout('modal');
    // Get i18n
    $i18n = $this->getContext()->getInstance()->getI18N();

    $this->facebookGame = Doctrine::getTable('FacebookReviewGame')
      ->createQuery('frg')
      ->where('frg.lang = ? and frg.status = ? and id=?', array($culture, 'opened',10))
      //->andWhereNotIn('frg.id', array(5,6,7))
      ->fetchOne();

    
    
    if (!$this->facebookGame) {
      //$this->redirect('@homepage');
      // Get last closed game
      $this->facebookGame = Doctrine::getTable('FacebookReviewGame')
      ->createQuery('frg')
      ->where('frg.lang = ? and frg.status = ?', array($culture, 'closed'))
      ->orderBy('frg.id DESC')
      ->fetchOne();

      if ($this->facebookGame)
      {
        $hasOpened = false;
        $this->setTemplate('game4Splash');
      }
      else {
        $this->redirect('@homepage');
      }
    }

  if ($hasOpened && !$this->getUser()->isAuthenticated()) {
      if (strpos($request->getHost(), 'facebook.com') !== false || strpos($request->getReferer(), $this->facebookGame->getSlug()) !== false || strpos($request->getReferer(), '?from=the-wall') !== false || strpos($request->getReferer(), 'iframehost.com') !== false) {
        $this->getResponse()->setContent("<script type='text/javascript'>top.location.href='{$this->generateUrl('default', array('module' => 'facebook', 'action' => 'login', 'app' => $this->facebookGame->getSlug()), true)}';</script>");
      }
      else {
        if (!$this->getUser()->hasAttribute('game.referer') || !$this->getUser()->getAttribute('game.referer', false)) {
          $this->getUser()->setAttribute('game.referer', $this->generateUrl('default', array('module' => 'facebook', 'action' => 'game4', 'sf_culture' => 'bg'), true));

		}
        $this->getResponse()->setContent("<script type='text/javascript'>top.location.href='{$this->generateUrl('sf_guard_signin', array(), true)}';</script>");
      }

      return sfView::NONE;
    }
/*    
    //var_dump($this->facebookGame->getSlug());exit();
     if (strpos($request->getHost(), 'facebook.com') !== false || strpos($request->getReferer(), $this->facebookGame->getSlug()) !== false || strpos($request->getReferer(), '?from=the-wall') !== false || strpos($request->getReferer(), 'iframehost.com') !== false) {
     	$this->getResponse()->setContent("<script type='text/javascript'>top.location.href='{$this->generateUrl('default', array('module' => 'facebook', 'action' => 'login', 'app' => $this->facebookGame->getSlug()), true)}';</script>");
        //$this->facebookSDK('hot-summer-race');
      }
      else
      {
        if (!$this->getUser()->hasAttribute('game.referer') || !$this->getUser()->getAttribute('game.referer', false)) {
          $this->getUser()->setAttribute('game.referer', $this->generateUrl('default', array('module' => 'facebook', 'action' => 'game4', 'sf_culture' => 'bg'), true));
        }
        $this->getResponse()->setContent("<script type='text/javascript'>top.location.href='{$this->generateUrl('sf_guard_signin', array(), true)}';</script>");
      }
*/



    // Get game parameters from DB...
    $gameParams = unserialize(base64_decode($this->facebookGame->getFinalSupportText()));

    if (strpos($request->getHost(), 'facebook.com') !== false || strpos($request->getReferer(), $this->facebookGame->getSlug()) !== false || strpos($request->getReferer(), '?from=the-wall') !== false || strpos($request->getReferer(), 'iframehost.com') !== false) {
      $this->isFbGame = true;
    }
    else {
      $this->isFbGame = false;

      $this->getResponse()->setTitle($this->facebookGame->getTitle());
    }

    
    
    //Show or hide an additional links
    // Winners and results
    $query = Doctrine::getTable('FacebookReviewGame')
    ->createQuery('frg')
    ->where('frg.lang = ? and frg.status = ?', array($culture, 'closed'))
    ->orderBy('frg.id DESC');

    $this->games = $query->execute();

    // Game form
    $this->gameForm = new FacebookGame2Form();

    $this->inviteFromMailUrl = $this->generateUrl('default', array('module' => 'facebook', 'action' => 'game4', 'sf_culture' => 'bg'), true);

    // Send review
    if ($request->isMethod('post') && $request->getPostParameter('save', false) && $request->getPostParameter('review_place', false) && $request->getPostParameter('review_stars', false) && $request->getPostParameter('review_text', false)) {
      $companyPage = Doctrine::getTable('CompanyPage')->find($request->getPostParameter('review_place', NULL));

      if (!$companyPage) {
        exit(json_encode(array('error' => true)));
      }

/*      if ($this->facebookGame->getSlug() == 'the-wall') {
        // Get user gender
        $gender = 'test';
      }
*/
      // Create a directory
      if (!is_dir(sfConfig::get('sf_upload_dir') . '/facebook_game')) {
        mkdir(sfConfig::get('sf_upload_dir') . '/facebook_game');
      }

      try {
        $obj = $this->getUser()->getGuardUser();

        if ($obj) {
          $firstName = $obj->getFirstName();
        }
      } catch (Exception $exc) {
        $this->redirect('default', array('module' => 'facebook', 'action' => 'game4'));
      }

      if ($this->facebookGame->getSlug() == 'hot-summer-race') {
        // Create an image
        $srcImage = imagecreatefrompng(sfConfig::get('sf_web_dir') . '/images/facebook/prizes/bg/game_' . $this->facebookGame->getId() . '_award_big.png');

        $holst = imagecreatetruecolor(403, 260);
        imagecopy($holst, $srcImage, 0, 0, 0, 0, 403, 260);

        $userNameColor = imagecolorallocate($holst, 255, 255, 255);
        $textColor = imagecolorallocate($holst, 255, 255, 255);

        $text1 = $firstName;

        $font1 = sfConfig::get('sf_web_dir') . '/images/facebook/v3/bg/pt-sans-narrow-bold.ttf';

        // Font size
        $fs1 = 36; // name
        $fs2 = 24; // name

        $size1 = imagettfbbox($fs1, 0, $font1, $text1);
        $this->calculateFontSize($size1, $font1, $text1, $fs1, 260);
        imagettftext($holst, $fs1, 0, 18, 40, $userNameColor, $font1, $text1);

        $size2 = imagettfbbox($fs2, 0, $font1, $text2);
        $this->calculateFontSize($size2, $font1, $text2, $fs2, 400);
        imagettftext($holst, $fs2, 0, 18, 73, $textColor, $font1, $text2);
      }

      //$tmp = sfConfig::get('sf_upload_dir') . '/' . uniqid() . '_game_bg.jpg';
      $tmp = sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_bg.jpg';
      imagejpeg($holst, $tmp, 100);


      if ($this->facebookGame->getSlug() == 'hor-summer-race') {
        // Create a small image
        $smallSrcImage = imagecreatefrompng(sfConfig::get('sf_web_dir') . '/images/facebook/prizes/bg/game_' . $this->facebookGame->getId() . '_award_small.png');
        $firstName = $this->getUser()->getGuardUser()->getFirstName();

        $smallHolst = imagecreatetruecolor(111, 74);
        imagecopy($smallHolst, $smallSrcImage, 0, 0, 0, 0, 111, 74);

        $userNameColor = imagecolorallocate($smallHolst, 255, 255, 255);
        $textColor = imagecolorallocate($smallHolst, 255, 255, 255);

        $text1 = $firstName;
        $font1 = sfConfig::get('sf_web_dir') . '/images/facebook/v3/bg/pt-sans-narrow-bold.ttf';

        // Font size
        $fs1 = 10.25; // name
        $fs2 = 6.83; // name

        $smallSize1 = imagettfbbox($fs1, 0, $font1, $text1);
        $this->calculateFontSize($smallSize1, $font1, $text1, $fs1, 75);
        imagettftext($smallHolst, $fs1, 0, 6, 12, $userNameColor, $font1, $text1);

        $smallSize2 = imagettfbbox($fs2, 0, $font1, $text2);
        $this->calculateFontSize($smallSize2, $font1, $text2, $fs2, 100);
        imagettftext($smallHolst, $fs2, 0, 6, 20, $textColor, $font1, $text2);
      }


      $this->shareImg = sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_bg_share.jpg';
      imagejpeg($smallHolst, $this->shareImg, 100);

      $protocol = ($request->isSecure()) ? 'https://' : 'http://';
      $this->shareImg = $protocol . $request->getHost() . '/uploads/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_bg_share.jpg';


      $this->getResponse()->setCookie('from', $this->facebookGame->getSlug());


      // Generate an image
      $tmp = sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_bg.jpg';
      $file = new sfValidatedFile(uniqid() . '.jpg', filetype($tmp), $tmp, filesize($tmp));

      // Save generated image
      $this->image = new Image();
      $this->image->setFile($file);
      $this->image->setUserId($this->getUser()->getId());
      $this->image->save();

      // Save review
      $review = new Review();
      $review->setUserId($this->getUser()->getId());
      $review->setCompanyId($companyPage->getCompany()->getId());
      $review->setText($request->getPostParameter('review_text', ''));
      $review->setRating($request->getPostParameter('review_stars', '1'));
      //$review->setReferer('facebook_game2_bg');
      $review->save();

      // Save user
      $facebookReviewGameUser = new FacebookReviewGameUser();
      $facebookReviewGameUser->setUserId($this->getUser()->getId());
      $facebookReviewGameUser->setFacebookReviewGameId($this->facebookGame->getId());
      //$facebookReviewGameUser->setReferer($this->getUser()->setAttribute('game.referer', ''));
      $facebookReviewGameUser->setReferer($request->getReferer());
      $facebookReviewGameUser->save();

      // Remove referer attribute
      $this->getUser()->setAttribute('game.referer', NULL);

      // Increment and save game result
      $query = Doctrine::getTable('FacebookReviewGameResult')
      ->createQuery('frgr')
      ->where('frgr.facebook_review_game_id = ? and frgr.param1 = ?', array($this->facebookGame->getId(), 'the-wall-results'));

      $facebookReviewGameResult = $query->fetchOne();

      if ($facebookReviewGameResult)
      {
        $total = $facebookReviewGameResult->getParam2() + 1;

        $facebookReviewGameResult->setParam2($total);
      }
      else {
        $facebookReviewGameResult = new FacebookReviewGameResult();
        $facebookReviewGameResult->setFacebookReviewGameId($this->facebookGame->getId());
        $facebookReviewGameResult->setParam1('the-wall-results');
        $facebookReviewGameResult->setParam2(1);
      }

      $facebookReviewGameResult->save();

      // Count all users for current game
      $count = $this->facebookGame->getCountUsers();


      // All results
      $tmpArr = $this->facebookGame->getUserResults($count);
      $resArr['result'] = $tmpArr;

      $resArr['error'] = false;
      $resArr['total'] = $count;
      $resArr['image'] = $this->shareImg;
      //$protocol = ($request->isSecure()) ? 'https://' : 'http://';
      //$resArr['image'] = $protocol . $request->getHost() . '/uploads/facebook_game/' . $this->getUser()->getId() . '_game_bg_share.jpg';


      $token = "AAAFipGQmRHsBAE7gJL8cYTawrvUr2RP4J03IYb1TKqqWiaPCCEAX1YgATHMC59NbyVMR8QQZA5fbZCjmWwSes4AVegsRKqDrwdYHqfZA2U99mubgD1Q";

      // http://developers.facebook.com/tools/explorer?method=GET&path=100001642136166%3Ffields%3Did%2Cname
      // use id from $result = curl_exec($ch);
      // use application "Care e numele tau de party?"
      $ch = curl_init();
//      curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me/photos");
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_AUTOREFERER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); # required for https urls
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                'source' => '@' . $this->image->getFile()->getDiskPath(),
                'message' => $gameParams['facebook']['share_on_wal_msg'],
                'access_token' => $this->getUser()->getProfile()->getFBtoken()
      ));
      $result = curl_exec($ch);

      if (file_exists(sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->facebookGame->getId() . '_' . $this->getUser()->getId() . '_game_bg.jpg')) {
        //@unlink(sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->getUser()->getId() . '_game_bg.jpg');
        //@unlink(sfConfig::get('sf_upload_dir') . '/facebook_game/' . $this->getUser()->getId() . '_game_bg_share.jpg');
      }

      // Return response
      exit(json_encode($resArr));
    }
    
    // Remove referer attribute
    $this->getUser()->setAttribute('game.referer', NULL);

  }

}
