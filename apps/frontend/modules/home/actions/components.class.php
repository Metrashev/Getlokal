 <?php
class homeComponents extends sfComponents
{
 CONST FACEBOOK_BG = 'http://www.facebook.com/getlokal';
 CONST FACEBOOK_RO = 'http://www.facebook.com/getlokal.ro'; 
 CONST FACEBOOK_MK = 'http://www.facebook.com/getlokal.mk';
 CONST FACEBOOK_RS = 'https://www.facebook.com/pages/getlokalrs/348813735232427?ref=ts&fref=ts';
// CONST FACEBOOK_FI = 'http://www.facebook.com/getlokal.fi';
 CONST FACEBOOK_FI = 'http://www.facebook.com/getlokal';
 CONST FACEBOOK_CZ = 'http://www.facebook.com/getlokal';
 CONST FACEBOOK_SK = 'http://www.facebook.com/getlokal';
 CONST FACEBOOK_HU = 'http://www.facebook.com/getlokal';
 CONST FACEBOOK_PT = 'http://www.facebook.com/getlokal';
 CONST FACEBOOK_ME = 'http://www.facebook.com/getlokal';
 CONST FACEBOOK_RU = 'http://www.facebook.com/getlokal';


 CONST PLUS_BG = 'https://plus.google.com/107281061798826098705/posts';
 CONST PLUS_RO = 'https://plus.google.com/105307511231555757137?prsrc=3';
 CONST PLUS_MK = 'https://plus.google.com/u/0/101550121514033570313/posts'; 
 CONST PLUS_RS = 'https://plus.google.com/u/0/107641928245143400221/posts';
// CONST PLUS_FI = 'https://plus.google.com/107281061798826098705/posts';
 CONST PLUS_FI = 'https://plus.google.com/107281061798826098705/posts';
 CONST PLUS_CZ = 'https://plus.google.com/107281061798826098705/posts';
 CONST PLUS_SK = 'https://plus.google.com/107281061798826098705/posts';
 CONST PLUS_HU = 'https://plus.google.com/107281061798826098705/posts';
 CONST PLUS_PT = 'https://plus.google.com/107281061798826098705/posts';
 CONST PLUS_ME = 'https://plus.google.com/107281061798826098705/posts';
 CONST PLUS_RU = 'https://plus.google.com/107281061798826098705/posts';


 CONST TWITTER_BG = 'https://twitter.com/getlokal';
 CONST TWITTER_RO = 'https://twitter.com/getlokalro';
 CONST TWITTER_MK = 'https://twitter.com/getlokalmk';
 CONST TWITTER_RS = 'https://twitter.com/getlokalrs';
 //CONST TWITTER_FI = 'https://twitter.com/getlokalfi';
 CONST TWITTER_FI = 'https://twitter.com/getlokal';
 CONST TWITTER_CZ = 'https://twitter.com/getlokal';
 CONST TWITTER_SK = 'https://twitter.com/getlokal';
 CONST TWITTER_HU = 'https://twitter.com/getlokal';
 CONST TWITTER_PT = 'https://twitter.com/getlokal';
 CONST TWITTER_ME = 'https://twitter.com/getlokal';
 CONST TWITTER_RU = 'https://twitter.com/getlokal';

 CONST TUBE_BG = 'http://www.youtube.com/getlokal';
 CONST TUBE_RO = 'http://www.youtube.com/getlokalro';
 CONST TUBE_MK = 'http://www.youtube.com/getlokalmk';
// CONST TUBE_FI = 'http://www.youtube.com/getlokal';
 CONST TUBE_FI = 'http://www.youtube.com/getlokal';
 CONST TUBE_CZ = 'http://www.youtube.com/getlokal';
 CONST TUBE_SK = 'http://www.youtube.com/getlokal';
 CONST TUBE_HU = 'http://www.youtube.com/getlokal';
 CONST TUBE_PT = 'http://www.youtube.com/getlokal';
 CONST TUBE_ME = 'http://www.youtube.com/getlokal';
 CONST TUBE_RU = 'http://www.youtube.com/getlokal';

    public function executeLanguages()
    {

      $countries = array(
            'bg' => array(
                array('name' =>'Български',  'code' => 'bg'),
                array('name' =>'English',    'code' => 'en'),
            ),
            'ro' => array(
                array('name' =>'Română',     'code' => 'ro'),
                array('name' =>'English',    'code' => 'en'),
            ),
            'mk' => array(
                array('name' =>'Македонски', 'code' => 'mk'),
                array('name' =>'English',    'code' => 'en'),
            ),
            'sr' => array(
                array('name' =>'Srpski',     'code' => 'sr'),
                array('name' =>'English',    'code' => 'en'),
            ),
            'fi' => array(
                array('name' =>'Suomi',      'code' => 'fi'),
                array('name' =>'English',    'code' => 'en'),
                array('name' =>'Русский',    'code' => 'ru'),
            ),
            'cs' => array(
                array('name' =>'Český',      'code' => 'cs'),
                array('name' =>'English',    'code' => 'en'),
                array('name' =>'Slovak',  'code' => 'sk'),
            ),
            'sk' => array(
                array('name' =>'Slovak',  'code' => 'sk'),
                array('name' =>'English',    'code' => 'en'),
                array('name' =>'Český',      'code' => 'cs'),
            ),
            'hu' => array(
                array('name' =>'Magyar',     'code' => 'hu'),
                array('name' =>'English',    'code' => 'en'),
            ),
            'pt' => array(
                array('name' =>'Portuguese', 'code' => 'pt'),
                array('name' =>'English',    'code' => 'en'),
            ),
            'me' => array(
                array('name' =>'Crnogorski', 'code' => 'me'),
                array('name' =>'English',    'code' => 'en'),
            ),
      		'ru'=> array(
      			array('name' => 'Русский', 'code' => 'ru'),
      			array('name' =>'English',    'code' => 'en'),
      		)

        );
        $lang_array = $countries[$this->getUser()->getCountry()->getSlug()];

        $lang_counter = count($lang_array);
        if($lang_counter > 2){
            for($i=0; $i < $lang_counter; $i++){
                if($lang_array[$i]['code'] == $this->getUser()->getCulture()){
                    $arr = array_splice($lang_array, $i, 1);
                    $lang_array = array_merge($arr, $lang_array);
                }
            }
            $this->language = $lang_array;
        }
        else{
            $this->language = $this->getUser()->getCulture() == 'en'? array_reverse($lang_array): $lang_array;
        }
        $routing = sfContext::getInstance ()->getRouting ();
        $request = sfContext::getInstance ()->getRequest ();

        $controller = sfContext::getInstance ()->getController ();
        $route_name = $routing->getCurrentRouteName ();
        $parameters = $controller->convertUrlStringToParameters ( $routing->getCurrentInternalUri () );
        
        
        if(!isset($parameters[1]['city'])) 
        	if($city = sfContext::getInstance()->getRequest()->getParameter("city",false))
        		$parameters[1]['city'] = $city;
        
        if(!isset($parameters[1]['county'])){
        	if($county = sfContext::getInstance()->getRequest()->getParameter("county",false)){
	        	$parameters[1]['county'] = $county;
        	}
        }
        
        for($i=0; $i < $lang_counter; $i++){
            $parameters [1] ['sf_culture'] = $this->language[$i]['code'];


            if (isset($parameters [1] ['module']) && isset($parameters [1] ['action']) && $parameters [1] ['module'] == 'home' and ($parameters [1] ['action'] == 'category'))
            {
                $parameters [1] ['slug'] = Doctrine::getTable ( 'Sector' ) -> getTranslatedSlug($parameters [1] ['slug'], $this->language[$i]['code']);

            }
            elseif (isset($parameters [1] ['module']) && isset($parameters [1] ['action']) && $parameters [1] ['module'] == 'home' and ($parameters [1] ['action'] == 'classification' or $parameters [1] ['action'] == 'locations' or $parameters [1] ['action'] == 'sublevel' or $parameters [1] ['action'] == 'streetClassification'))
            {
                $parameters [1] ['sector'] = Doctrine::getTable ( 'Sector' ) -> getTranslatedSlug($parameters [1] ['sector'], $this->language[$i]['code']);
                $parameters [1] ['slug'] = Doctrine::getTable ( 'Classification' ) -> getTranslatedSlug($parameters [1] ['slug'], $this->language[$i]['code']);
            }
            elseif (isset($parameters [1] ['module']) && $parameters [1] ['module'] == 'article' and ($parameters [1] ['action'] == 'show'))
            {
                $slug = Doctrine::getTable ( 'Article' ) ->getTranslatedSlug($parameters [1] ['slug'], $this->language[$i]['code']);
                if ($slug){
                    $parameters [1] ['slug'] = $slug;
                }else {
                    $route_name = "article_index";
                    $parameters [1] = array();
                    $parameters [1] ['sf_culture'] = $this->language[$i]['code'];
                }
            }
            elseif (isset($parameters [1] ['module']) && isset($parameters [1] ['action']) && $parameters [1] ['module'] == 'article' and ($parameters [1] ['action'] == 'category'))
            {
                $slug = Doctrine::getTable ( 'CategoryArticle' ) ->getTranslatedSlug($parameters [1] ['slug'], $this->language[$i]['code']);
                if ($slug){
                    $parameters [1] ['slug'] = $slug;
                }else {
                    $route_name = "article_index";
                    $parameters [1] = array();
                    $parameters [1] ['sf_culture'] = $this->language[$i]['code'];
                }
            }
            if(isset($parameters[1]) && isset($parameters[1]['module']) && $parameters[1]['module'] == 'search'){
            	$parameters[1]['module'] = 'home';
            	$this->{"uri_$i"} = $routing->generate ( $route_name, $parameters [1] );
            }elseif(isset($parameters[1]['city']) 
            		&& isset($parameters[1]['sf_culture']) 
            		&& isset($parameters[1]['action'])
            		&& isset($parameters[1]['module'])
            		&& ($parameters[1]['action'] == 'index')
            		&& ($parameters[1]['module'] == 'home'))
            {
            	$route_name = "home";
            	$this->{"uri_$i"} = $routing->generate ( $route_name, array_merge ( $request->getGetParameters (), $parameters [1] ) );
            }elseif(isset($parameters[1]['county']) 
            		&& isset($parameters[1]['sf_culture']) 
            		&& isset($parameters[1]['action'])
            		&& isset($parameters[1]['module'])
            		&& ($parameters[1]['action'] == 'index')
            		&& ($parameters[1]['module'] == 'home'))
            {
            	$route_name = "homeCounty";
            	$this->{"uri_$i"} = $routing->generate ( $route_name, array_merge ( $request->getGetParameters (), $parameters [1] ) );
            }else{
            	$this->{"uri_$i"} = $routing->generate ( $route_name, array_merge ( $request->getGetParameters (), $parameters [1] ) );
            }
        }
    }
    public function executeSocial_sidebar() 
    {

        $partner = getlokalPartner::getInstance();
        
        if($partner == getlokalPartner::GETLOKAL_BG ){
            $this->facebook = self::FACEBOOK_BG;
            // $this->plus = self::PLUS_BG;
            // $this->twitter = self::TWITTER_BG;
            // $this->tube = self::TUBE_BG;
        }
        if($partner == getlokalPartner::GETLOKAL_RO) {
            $this->facebook = self::FACEBOOK_RO;
            // $this->plus = self::PLUS_RO;
            // $this->twitter = self::TWITTER_RO;
            // $this->tube = self::TUBE_RO;
        }
        if($partner == getlokalPartner::GETLOKAL_MK) {
            $this->facebook = self::FACEBOOK_MK;
            // $this->plus = self::PLUS_MK;
            // $this->twitter = self::TWITTER_MK;
            // $this->tube = self::TUBE_MK;
         }
         if($partner == getlokalPartner::GETLOKAL_RS) {
            $this->facebook = self::FACEBOOK_RS;
            // $this->plus = self::PLUS_RS;
            // $this->twitter = self::TWITTER_RS;
            //$this->tube = self::TUBE_RS;
         }
         if($partner == getlokalPartner::GETLOKAL_FI) {
            $this->facebook = self::FACEBOOK_FI;
            // $this->plus = self::PLUS_FI;
            // $this->twitter = self::TWITTER_FI;
            // $this->tube = self::TUBE_FI;
         }
         
        if($partner == getlokalPartner::GETLOKAL_CZ) {
            $this->facebook = self::FACEBOOK_CZ;
            // $this->plus = self::PLUS_CZ;
            // $this->twitter = self::TWITTER_CZ;
            // $this->tube = self::TUBE_CZ;
         }
         if($partner == getlokalPartner::GETLOKAL_SK) {
            $this->facebook = self::FACEBOOK_SK;
            // $this->plus = self::PLUS_SK;
            // $this->twitter = self::TWITTER_SK;
            // $this->tube = self::TUBE_SK;
         }
         if($partner == getlokalPartner::GETLOKAL_HU) {
            $this->facebook = self::FACEBOOK_HU;
            // $this->plus = self::PLUS_HU;
            // $this->twitter = self::TWITTER_HU;
            // $this->tube = self::TUBE_HU;
         }
         if($partner == getlokalPartner::GETLOKAL_PT) {
            $this->facebook = self::FACEBOOK_PT;
            // $this->plus = self::PLUS_PT;
            // $this->twitter = self::TWITTER_PT;
            // $this->tube = self::TUBE_PT;
         }
         if($partner == getlokalPartner::GETLOKAL_ME) {
            $this->facebook = self::FACEBOOK_ME;
            // $this->plus = self::PLUS_ME;
            // $this->twitter = self::TWITTER_ME;
            // $this->tube = self::TUBE_ME;
         }
         if($partner == getlokalPartner::GETLOKAL_RU) {
            $this->facebook = self::FACEBOOK_RU;
            // $this->plus = self::PLUS_RU;
            // $this->twitter = self::TWITTER_RU;
            // $this->tube = self::TUBE_RU;
         }

   }
   
   public function executeFeed()
   {
   	$this->user = $this->getUser()->getGuardUser();
  	$this->profile = $this->user->getUserProfile();
        $this->user_page = $this->profile->getUserPage();
        $this->activities = array();    
        $this->page = isset($page) ? $page: 1;    
        $query = Doctrine::getTable('Activity')
                ->createQuery('a')  
                ->leftJoin('a.UserProfile')              
                ->leftJoin('a.Image')
                ->leftJoin('a.Page')
                ->where('user_id !='.$this->user->getId());
        
        $sql= 'select distinct activity.id from activity 
        where 
        (page_id  IN (select page_id from follow_page where user_id='.$this->user->getId ().' and 
        follow_page.created_at < activity.created_at and
        follow_page.newsfeed = true)
        or user_id IN (select foreign_id from page inner join follow_page on follow_page.page_id = page.id where follow_page.user_id='.$this->user->getId ().' and 
        follow_page.created_at < activity.created_at and
        follow_page.newsfeed = true))
        and activity.user_id != '.$this->user->getId (); 
        
        $sql= 'select distinct activity.id from activity
        where
        (page_id  IN (select page_id from follow_page where 1 and
        follow_page.created_at < activity.created_at and
        follow_page.newsfeed = true)
        or user_id IN (select foreign_id from page inner join follow_page on follow_page.page_id = page.id where 1 and
        follow_page.created_at < activity.created_at and
        follow_page.newsfeed = true))
        and 1 ORDER BY `updated_at` DESC LIMIT 10';
     
        $con = Doctrine::getConnectionByTableName('Activity');       
        $result = $con->execute($sql);
        $ids=array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
            $ids[] = $row['id'];
        }
        
        if (!empty($ids)){
            $query = Doctrine::getTable('Activity')
                ->createQuery('a')  
                ->leftJoin('a.UserProfile')              
                ->leftJoin('a.Image')
                ->leftJoin('a.Page')
                 ->whereIN('a.id', $ids)
                 ->orderBy('a.created_at DESC');


            $this->pager = new sfDoctrinePager ( 'Activity', 10 );
            $this->pager->setPage ( $this->page );
            $this->pager->setQuery ( $query);
            $this->pager->init ();


        }
    }
    
    public function executeNotifications()
    {
        $this->user = $this->getUser()->getGuardUser();
        $this->page_admin = $this->getUser()->getPageAdminUser();
        $page_id= null;
        if ($this->page_admin){
            $page_id = $this->page_admin->getPageId();
        }
        if ($this->user) {
            $this->feed_info = $this->user->getUserNotificationsInfo($page_id, true, null, 5);
            $this->feed_info_count = $this->user->getUserNotificationsCount($page_id, false, null);				
        }
    }
    
    public function executeMessageNotifications() 
    {
        $this->user = $this->getUser()->getGuardUser();
        $this->page_admin = $this->getUser()->getPageAdminUser();
        $page_id= null;
        if ($this->page_admin){
            $page_id = $this->page_admin->getPageId();
        }
        if ($this->user) {

            $this->message_info = $this->user->getUserNotificationsInfo($page_id, true, 'Message', 5);
            $this->message_info_count = $this->user->getUserNotificationsCount($page_id, false, 'Message');
        }

    }
}