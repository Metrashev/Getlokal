<?php

/**
 * invite actions.
 *
 * @package    getLokal
 * @subpackage invite
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class inviteActions extends sfActions {
    private
            $points = 10,
            $body = '',
            $bodyP1 = '',
            $underBodySignature = '',
            $subject = '',
            $i18n = null;

    public function preExecute() {
        $this->getResponse()->setSlot('sub_module', 'invite');
        //$this->getResponse()->setSlot('sub_module_parameters', array('user' => $this->user));

        $this->i18n = $this->getContext()->getInstance()->getI18N();

        if (strpos($this->getContext()->getRequest()->getHost(), 'getlokal.com') !== false || (strpos($this->getContext()->getRequest()->getHost(), 'dev') !== false && strpos($this->getContext()->getRequest()->getHost(), 'mk.dev') === false && strpos($this->getContext()->getRequest()->getHost(), 'ro.dev') === false && strpos($this->getContext()->getRequest()->getHost(), 'rs.dev') === false) ) {
            $this->subject = $this->i18n->__('A friend just invited you to join getlokal.com!', null, 'mailsubject');

            if ($this->getUser()->getCulture() == 'bg') {
                $this->bodyP1 = 'Здравей {username},';

                if ($this->getUser()->getGuardUser()->getFirstName() || $this->getUser()->getGuardUser()->getLastName()) {
                    $this->body = "{$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()} те покани да се регистрираш на getlokal.com (http://www.getlokal.com/bg/sofia)!\n
Ако се присъединиш към getlokal, ще имаш възможност да пишеш ревюта за местата, които посещаваш, да добавяш снимки и да предлагаш нови места на сайта. Редовно организираме кампании и игри със страхотни награди, които можеш да спечелиш съвсем лесно. Освен това, всяко твое действие на сайта, отключва наистина готини значки.\n
За да се присъединиш, отвори http://www.getlokal.com/bg/register/{hash} \n
Ако приемеш поканата на {$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()} (" . $this->generateUrl('user_page', array('username' => $this->getUser()->getGuardUser()->getUsername()), true) . "), ще имаш възможност да следиш препоръките и местата, които посещава.\n
Можеш също да ни пишеш и във Facebook (http://www.facebook.com/getlokal).\n
Ако пък имаш смартфон с iOS или Android и искаш постоянно да се информираш за най-актуалните събития и места, виж мобилното ни приложение (http://app.getlokal.com).\n
Присъединявайки се към getlokal, можеш да получаваш седмичния ни е-мейл бюлетин и видео бюлетина ни getWeekend (getweekend.bg) с новини за най-актуалните събития, случки и препоръчани места.\n
За нас ще е чест да те приветстваме сред нас!\n
Екипът на getlokal.com & " . $this->getUser()->getGuardUser()->getFirstName() . " " . $this->getUser()->getGuardUser()->getLastName();
                }
                else {
                    $this->body = "Твой приятел те покани да се регистрираш на getlokal.com (http://www.getlokal.com/bg/sofia)!\n
Ако се присъединиш към getlokal, ще имаш възможност да пишеш ревюта за местата, които посещаваш, да добавяш снимки и да предлагаш нови места на сайта. Редовно организираме кампании и игри със страхотни награди, които можеш да спечелиш съвсем лесно. Освен това, всяко твое действие на сайта, отключва наистина готини значки.\n
За да се присъединиш, отвори http://www.getlokal.com/bg/register/{hash} \n
Можеш също да ни пишеш и във Facebook (http://www.facebook.com/getlokal).\n
Ако пък имаш смартфон с iOS или Android и искаш постоянно да се информираш за най-актуалните събития и места, виж мобилното ни приложение (http://app.getlokal.com).\n
Присъединявайки се към getlokal, можеш да получаваш седмичния ни е-мейл бюлетин и видео бюлетина ни getWeekend (getweekend.bg) с новини за най-актуалните събития, случки и препоръчани места.\n
За нас ще е чест да те приветстваме сред нас!\n
Екипът на getlokal.com";
                }

                $this->underBodySignature = "http://www.getlokal.com/bg/register/{hash}";
            }
            else {
                $this->bodyP1 = 'Hello {username},';

                if ($this->getUser()->getGuardUser()->getFirstName() || $this->getUser()->getGuardUser()->getLastName()) {
                    $this->body = "{$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()} is inviting you on getlokal.com (http://www.getlokal.com/en/sofia)!\n
If you enter the getlokal.com community, you'll be able to write reviews about the places you go out to, add photos of them and suggest new places. We often have campaigns with really great prizes, that you can win really easy. On top of that, for every action on our site you unlock cool badges.\n
To join, open http://www.getlokal.com/en/register/{hash} \n
By responding to {$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()}'s (" . $this->generateUrl('user_page', array('username' => $this->getUser()->getGuardUser()->getUsername()), true) . ") invite you will be able to see their recommendations and places they go out to.\n
We're also waiting for your feedback and ideas on Facebook (http://www.facebook.com/getlokal).\n
If you have an iPhone or Android device and you want to be connected to the latest events and places, take a look at our mobile app (http://app.getlokal.com).\n
Being part of our community you could also subscribe to our weekly newsletter including the getWeekend (getweekend.bg) video with events and place recommendations.\n
We will be honoured to have you onboard!\n
The getlokal.com team & " . $this->getUser()->getGuardUser()->getFirstName() . " " . $this->getUser()->getGuardUser()->getLastName();
                }
                else {
                    $this->body = "A friend of yours invited you on getlokal.com (http://www.getlokal.com/en/sofia)!\n
If you enter the getlokal.com community, you'll be able to write reviews about the places you go out to, add photos of them and suggest new places. We often have campaigns with really great prizes, that you can win really easy. On top of that, for every action on our site you unlock cool badges\n
To join, open http://www.getlokal.com/en/register/{hash} \n
We're also waiting for your feedback and ideas on Facebook (http://www.facebook.com/getlokal).\n
If you have an iPhone or Android device and you want to be connected to the latest events and places, take a look at our mobile app (http://app.getlokal.com).\n
Being part of our community you could also subscribe to our weekly newsletter including the getWeekend (getweekend.bg) video with events and place recommendations.\n
We will be honoured to have you onboard!\n
The getlokal.com team";
                }

                $this->underBodySignature = "http://www.getlokal.com/en/register/{hash}";
            }
        }
        elseif (strpos($this->getContext()->getRequest()->getHost(), 'getlokal.mk') !== false || strpos($this->getContext()->getRequest()->getHost(), 'mk.dev') !== false || strpos($this->getContext()->getRequest()->getHost(), 'mk.trunk') !== false) {
            $this->subject = $this->i18n->__('A friend just invited you to join getlokal.mk!', null, 'mailsubject');

            if ($this->getUser()->getCulture() == 'mk') {
                $this->bodyP1 = 'Здраво {username},';

                if ($this->getUser()->getGuardUser()->getFirstName() || $this->getUser()->getGuardUser()->getLastName()) {
                    $this->body = "{$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()} те поканува на getlokal.mk (http://www.getlokal.mk/mk/skopje)!\n
Доколку се приклучиш на getlokal.mk заедницата, ќе можеш да пишуваш препораки за местата каде што излегуваш, да додаваш слики од истите и да предложуваш нови места. Многу често имаме  и  натпревари каде доделуваме супер награди, кои можеш многу лесно да ги освоиш. Покрај тоа, за секоја твоја активност на страната отклучуваш одлични значки.\n
За да се приклучиш, отвори http://www.getlokal.mk/mk/register/{hash} \n
Со одговарање на поканата на {$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()} (" . $this->generateUrl('user_page', array('username' => $this->getUser()->getGuardUser()->getUsername()), true) . "), ќе можеш да видиш препораки и места каде што излегува.\n
Исто така очекуваме и твој коментар и идеи на Facebook (http://www.facebook.com/getlokal.mk).\n
Ако имаш iPhone или Android уред и сакаш да бидеш во тек со најновите настани и места, погледни ја нашата мобилна апликација (http://app.getlokal.com).\n
Ќе ни претставува голема чест ако ни се придружиш!\n
Тимот на getlokal.mk и " . $this->getUser()->getGuardUser()->getFirstName() . " " . $this->getUser()->getGuardUser()->getLastName();
                }
                else {
                    $this->body = "Твојот пријател те поканува на getlokal.mk (http://www.getlokal.mk/mk/skopje)!\n
Доколку се приклучиш на getlokal.mk заедницата, ќе можеш да пишуваш препораки за местата каде што излегуваш, да додаваш слики од истите и да предложуваш нови места. Многу често имаме  и  натпревари каде доделуваме супер награди, кои можеш многу лесно да ги освоиш. Покрај тоа, за секоја твоја активност на страната отклучуваш одлични значки.\n
За да се приклучиш, отвори http://www.getlokal.mk/mk/register/{hash} \n
Исто така очекуваме и твој коментар и идеи на Facebook (http://www.facebook.com/getlokal.mk).\n
Ако имаш iPhone или Android уред и сакаш да бидеш во тек со најновите настани и места, погледни ја нашата мобилна апликација (http://app.getlokal.com).\n
Ќе ни претставува голема чест ако ни се придружиш!\n
Тимот на getlokal.mk";
                }

                $this->underBodySignature = "http://www.getlokal.mk/mk/register/{hash}";
            }
            else {
                $this->bodyP1 = 'Hello {username},';

                if ($this->getUser()->getGuardUser()->getFirstName() || $this->getUser()->getGuardUser()->getLastName()) {
                    $this->body = "{$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()} is inviting you on getlokal.mk (http://www.getlokal.mk/en/skopje)!\n
If you enter the getlokal.com community, you'll be able to write reviews about the places you go out to, add photos of them and suggest new places. We often have campaigns with really great prizes, that you can win really easy. On top of that, for every action on our site you unlock cool badges.\n
To join, open http://www.getlokal.mk/en/register/{hash} \n
By responding to {$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()}'s (" . $this->generateUrl('user_page', array('username' => $this->getUser()->getGuardUser()->getUsername()), true) . ") invite you will be able to see their recommendations and places they go out to.\n
We're also waiting for your feedback and ideas on Facebook (http://www.facebook.com/getlokal.mk).\n
If you have an iPhone or Android device and you want to be connected to the latest events and places, take a look at our mobile app (http://app.getlokal.com).\n
We will be honoured to have you onboard!\n
The getlokal.mk team & " . $this->getUser()->getGuardUser()->getFirstName() . " " . $this->getUser()->getGuardUser()->getLastName();
                }
                else {
                    $this->body = "A friend of yours invited you on getlokal.mk (http://www.getlokal.mk/en/skopje)!\n
If you enter the getlokal.com community, you'll be able to write reviews about the places you go out to, add photos of them and suggest new places. We often have campaigns with really great prizes, that you can win really easy. On top of that, for every action on our site you unlock cool badges.\n
To join, open http://www.getlokal.mk/en/register/{hash} \n
We're also waiting for your feedback and ideas on Facebook (http://www.facebook.com/getlokal.mk).\n
If you have an iPhone or Android device and you want to be connected to the latest events and places, take a look at our mobile app (http://app.getlokal.com).\n
We will be honoured to have you onboard!\n
The getlokal.mk team";
                }

                $this->underBodySignature = "http://www.getlokal.mk/en/register/{hash}";
            }
        }
        elseif (strpos($this->getContext()->getRequest()->getHost(), 'getlokal.ro') !== false || strpos($this->getContext()->getRequest()->getHost(), 'ro.dev') !== false || strpos($this->getContext()->getRequest()->getHost(), 'ro.trunk') !== false) {
            $this->subject = $this->i18n->__('A friend just invited you to join getlokal.ro!', null, 'mailsubject');

            if ($this->getUser()->getCulture() == 'ro') {
                $this->bodyP1 = 'Bună {username},';

                if ($this->getUser()->getGuardUser()->getFirstName() || $this->getUser()->getGuardUser()->getLastName()) {
                    $this->body = "{$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()} te invită pe getlokal.ro (http://www.getlokal.ro/ro/bucuresti)!\n
Dacă intri în comunitatea getlokal.ro, vei putea scrie recomandări despre locurile în care ieşi şi adăuga foto. Uneori avem şi campanii cu premii faine, pe care le poţi câştiga super simplu. Pe lângă asta, pentru orice acţiune pe site câştigi badge-uri haioase!\n
Fă-ţi cont aici http://www.getlokal.ro/ro/register/{hash} \n
Dacă răspunzi invitaţiei trimise de {$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()} (" . $this->generateUrl('user_page', array('username' => $this->getUser()->getGuardUser()->getUsername()), true) . "), vei putea să vezi ce recomandări face şi care sunt locurile în care iese.\n
Hai şi pe Facebook (http://www.facebook.com/getlokal.ro).\n
Şi dacă ai un smartphone şi vrei să fii conectat tot timpul la ceea ce se întâmplă în oraşul tău, descarcă-ţi aplicaţia noastră de mobil (http://app.getlokal.com/app/ro).\n
Dacă faci parte din comunitatea noastră, vei fi la curent şi cu proiectul nostru video (http://www.getweekend.ro) săptămânal cu locuri faine de vizitat şi recomandările de weekend din partea getlokal Girl.\n
Te aşteptăm cu recomandări de locuri!\n
Echipa getlokal.ro & " . $this->getUser()->getGuardUser()->getFirstName() . " " . $this->getUser()->getGuardUser()->getLastName();
                }
                else {
                    $this->body = "Unul din prietenii tăi te invită pe getlokal.ro (http://www.getlokal.ro/ro/bucuresti)!\n
Dacă intri în comunitatea getlokal.ro, vei putea scrie recomandări despre locurile în care ieşi şi adăuga foto. Uneori avem şi campanii cu premii faine, pe care le poţi câştiga super simplu. Pe lângă asta, pentru orice acţiune pe site câştigi badge-uri haioase!\n
Fă-ţi cont aici http://www.getlokal.ro/ro/register/{hash} \n
Hai şi pe Facebook (http://www.facebook.com/getlokal.ro).\n
Şi dacă ai un smartphone şi vrei să fii conectat tot timpul la ceea ce se întâmplă în oraşul tău, descarcă-ţi aplicaţia noastră de mobil (http://app.getlokal.com/app/ro).\n
Dacă faci parte din comunitatea noastră, vei fi la curent şi cu proiectul nostru video (http://www.getweekend.ro) săptămânal cu locuri faine de vizitat şi recomandările de weekend din partea getlokal Girl.\n
Te aşteptăm cu recomandări de locuri!\n
Echipa getlokal.ro";
                }

                $this->underBodySignature = "http://www.getlokal.ro/ro/register/{hash}";
            }
            else {
                $this->bodyP1 = 'Hello {username},';

                if ($this->getUser()->getGuardUser()->getFirstName() || $this->getUser()->getGuardUser()->getLastName()) {
                    $this->body = "{$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()} is inviting you on getlokal.ro (http://www.getlokal.ro/en/bucuresti)!\n
If you enter the getlokal.ro community, you'll be able to write reviews about the places you go out to and add photos of them. We often have campaigns with really cool prizes, that you can win really easy. Besides that, for every action on our site you unlock badges.\n
To join, open http://www.getlokal.ro/en/register/{hash} \n
By responding to {$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()}'s (" . $this->generateUrl('user_page', array('username' => $this->getUser()->getGuardUser()->getUsername()), true) . ") invite you will be able to see their recommendations and places they go out to.\n
We're also waiting for your feedback and ideas on Facebook. (https://www.facebook.com/getlokal.ro)\n
If you have an iPhone or Android device and you want to be connected to the latest events and places, take a look at our mobile app (http://app.getlokal.com/app/ro).\n
Being part of our community means also receiving a weekly video (getweekend.ro) with weekend recommendations and place suggestions, from our getlokal Girl.\n
Looking forward on reading your reviews!\n
The getlokal.ro team & " . $this->getUser()->getGuardUser()->getFirstName() . " " . $this->getUser()->getGuardUser()->getLastName();
                }
                else {
                    $this->body = "A friend of yours invited you on getlokal.ro (http://www.getlokal.ro/en/bucuresti)!\n
If you enter the getlokal.ro community, you'll be able to write reviews about the places you go out to and add photos of them. We often have campaigns with really cool prizes, that you can win really easy. Besides that, for every action on our site you unlock badges.\n
To join, open http://www.getlokal.ro/en/register/{hash} \n
We're also waiting for your feedback and ideas on Facebook. (http://www.facebook.com/getlokal.ro).\n
If you have an iPhone or Android device and you want to be connected to the latest events and places, take a look at our mobile app (http://app.getlokal.com/app/ro).\n
Being part of our community means also receiving a weekly video (getweekend.ro) with weekend recommendations and place suggestions, from our getlokal Girl.\n
Looking forward on reading your reviews!\n
The getlokal.ro team";
                }

                $this->underBodySignature = "http://www.getlokal.ro/en/register/{hash}";
            }
        }
        elseif (strpos($this->getContext()->getRequest()->getHost(), 'getlokal.rs') !== false || strpos($this->getContext()->getRequest()->getHost(), 'rs.dev') !== false || strpos($this->getContext()->getRequest()->getHost(), 'rs.trunk') !== false) {
        $this->subject = $this->i18n->__('A friend just invited you to join getlokal.rs!', null, 'mailsubject');

            if ($this->getUser()->getCulture() == 'sr') {
                $this->bodyP1 = 'Zdravo {username},';

                if ($this->getUser()->getGuardUser()->getFirstName() || $this->getUser()->getGuardUser()->getLastName()) {
                    $this->body = "{$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()} te poziva da posetiš sajt www.getlokal.rs i preporučiš dobra mesta u svom gradu:\n
\"Pridruži mi se na www.getlokal.rs i pronađi, preporuči i podeli utiske o dobrim mestima u svom kraju. Možeš čitati i pisati preporuke o skoro svemu, počev od restorana i barova preko fitnes centara, salona za lepotu, pozorišta i o mnogim drugim mestima.
Takođe, možeš objavljivati fotografije svojih omiljenih mesta, biti u toku sa najnovijim događajima i osvajati veoma interesantne nagrade! 
Pridruži mi se odmah!
{$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()}\" \n
Pridruži se getlokal zajednici, klikni na link: http://www.getlokal.rs/sr/register/{hash} \n
{$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()} već piše preporuke, klikni na link: " . $this->generateUrl('user_page', array('username' => $this->getUser()->getGuardUser()->getUsername()), true) . " \n
Preuzmi i besplatnu mobilnu aplikaciju za svoj iPhone ili Android mobilni uređaj na linku: http://app.getlokal.com/?lang=sr \n
Pozdrav, 
" . $this->getUser()->getGuardUser()->getFirstName() . " " . $this->getUser()->getGuardUser()->getLastName(). " & getlokal tim";
                }
                else {
                    $this->body = "te poziva da posetiš sajt www.getlokal.rs i preporučiš dobra mesta u svom gradu:\n
Pridruži mi se na www.getlokal.rs i pronađi, preporuči i podeli utiske o dobrim mestima u svom kraju. Možeš čitati i pisati preporuke o skoro svemu, počev od restorana i barova preko fitnes centara, salona za lepotu, pozorišta i o mnogim drugim mestima.
Takođe, možeš objavljivati fotografije svojih omiljenih mesta, biti u toku sa najnovijim događajima i osvajati veoma interesantne nagrade! 
Pridruži mi se odmah! \n
Pridruži se getlokal zajednici, klikni na link: http://www.getlokal.rs/sr/register/{hash} \n
Preuzmi i besplatnu mobilnu aplikaciju za svoj iPhone ili Android mobilni uređaj na linku: http://app.getlokal.com/?lang=sr \n
Pozdrav, 
getlokal tim";
                }

                $this->underBodySignature = "http://www.getlokal.rs/sr/register/{hash}";
            }
            else {
                $this->bodyP1 = 'Hello {username},';

                if ($this->getUser()->getGuardUser()->getFirstName() || $this->getUser()->getGuardUser()->getLastName()) {
                    $this->body = "{$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()} is inviting you on getlokal.rs (http://www.getlokal.rs/en/beograd)!\n
If you enter the getlokal.rs community, you'll be able to write reviews about the places you go out to, add photos of them and suggest new places. We often have campaigns with really great prizes, that you can win really easy. On top of that, for every action on our site you unlock cool badges.\n
To join, open http://www.getlokal.rs/en/register/{hash} \n
By responding to {$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()}'s (" . $this->generateUrl('user_page', array('username' => $this->getUser()->getGuardUser()->getUsername()), true) . ") invite you will be able to see their recommendations and places they go out to.\n
We're also waiting for your feedback and ideas on Facebook (http://www.facebook.com/getlokal.rs).\n
If you have an iPhone or Android device and you want to be connected to the latest events and places, take a look at our mobile app (http://app.getlokal.com).\n
Being part of our community you could also subscribe to our weekly newsletter.\n
We will be honoured to have you onboard!\n
The getlokal.rs team & " . $this->getUser()->getGuardUser()->getFirstName() . " " . $this->getUser()->getGuardUser()->getLastName();
                }
                else {
                    $this->body = "A friend of yours invited you on getlokal.rs (http://www.getlokal.rs/en/beograd)!\n
If you enter the getlokal.rs community, you'll be able to write reviews about the places you go out to, add photos of them and suggest new places. We often have campaigns with really great prizes, that you can win really easy. On top of that, for every action on our site you unlock cool badges.\n
To join, open http://www.getlokal.rs/en/register/{hash} \n
We're also waiting for your feedback and ideas on Facebook (http://www.facebook.com/getlokal.rs).\n
If you have an iPhone or Android device and you want to be connected to the latest events and places, take a look at our mobile app (http://app.getlokal.com).\n
Being part of our community you could also subscribe to our weekly newsletter.\n
We will be honoured to have you onboard!\n
The getlokal.rs team";
                }

                $this->underBodySignature = "http://www.getlokal.rs/en/register/{hash}";
            }
        } elseif (strpos($this->getContext()->getRequest()->getHost(), 'getlokal.fi') !== false || (strpos($this->getContext()->getRequest()->getHost(), 'fi.dev') !== false || strpos($this->getContext()->getRequest()->getHost(), 'fi.trunk') !== false)) {
            $this->subject = $this->i18n->__('A friend just invited you to join getlokal.fi!', null, 'mailsubject');

            if ($this->getUser()->getCulture() == 'fi') {
                $this->bodyP1 = 'Hei {username},';

                if ($this->getUser()->getGuardUser()->getFirstName() || $this->getUser()->getGuardUser()->getLastName()) {
                    $this->body = "{$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()} kutsui Sinut getlokal.fi palveluun (http://www.getlokal.fi/fi/helsinki)!\n
Jos liityt getlokal.fi palveluun, voit kirjoittaa arvioita ja lisätä kuvia palveluista, joita käytät sekä suositella uusia paikkoja. Tutustu kamppanjoihimme, voit voittaa hienoja palkintoja. Jokainen päivityksesi nostaa aktiivitasoasi, kuinka korkealle Sinä pääset? \n

Liittyäksesi palveluun, avaa http://www.getlokal.fi/fi/register/{hash} \n
Vastaamalla tähän {$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()} (" . $this->generateUrl('user_page', array('username' => $this->getUser()->getGuardUser()->getUsername()), true) . "), kutsuun, voit nähdä arviot ja suositukset eri palveluista. \n
Odotamme myös kommentteja ja ideoitasi Facebookissa (http://www.facebook.com/getlokal).\n
Jos käytät iPhone tai Android mobiililaitetta ja haluat löytää kiinnostavimmat tapahtumat ja paikat, lataa mobiili sovelluksemme (http://app.getlokal.com).\n
Osana palveluamme voit myös tilata viikottaisen uutiskirjeemme, jossa viimeisimmät tapahtuma ja -palvelusuositukset. \n
Tervetuloa palveluumme! \n
Getlokal.fi tiimi & " . $this->getUser()->getGuardUser()->getFirstName() . " " . $this->getUser()->getGuardUser()->getLastName();
                }
                else {
                    $this->body = "Ystäväsi kutsui Sinut getlokal.fi palveluun (http://www.getlokal.fi/fi/helsinki)!\n
Jos liityt getlokal.fi palveluun, voit kirjoittaa arvioita ja lisätä kuvia palveluista, joita käytät sekä suositella uusia paikkoja. Tutustu kamppanjoihimme, voit voittaa hienoja palkintoja. Jokainen päivityksesi nostaa aktiivitasoasi, kuinka korkealle Sinä pääset? \n

Liittyäksesi palveluun, avaa http://www.getlokal.fi/fi/register/{hash} \n
Odotamme myös kommentteja ja ideoitasi Facebookissa (http://www.facebook.com/getlokal).\n
Jos käytät iPhone tai Android mobiililaitetta ja haluat löytää kiinnostavimmat tapahtumat ja paikat, lataa mobiili sovelluksemme (http://app.getlokal.com).\n
Osana palveluamme voit myös tilata viikottaisen uutiskirjeemme, jossa viimeisimmät tapahtuma ja -palvelusuositukset. \n
Tervetuloa palveluumme! \n
Getlokal.fi tiimi";
                }

                $this->underBodySignature = "http://www.getlokal.fi/fi/register/{hash}";
            }
            else {
                $this->bodyP1 = 'Hello {username},';

                if ($this->getUser()->getGuardUser()->getFirstName() || $this->getUser()->getGuardUser()->getLastName()) {
                    $this->body = "{$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()} is inviting you on getlokal.fi (http://www.getlokal.fi/en/helsinki)!\n
If you enter the getlokal.fi community, you'll be able to write reviews about the places you go out to, add photos of them and suggest new places. We often have campaigns with really great prizes, that you can win really easy. On top of that, for every action on our site you unlock cool badges.\n
To join, open http://www.getlokal.fi/en/register/{hash} \n
By responding to {$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()}'s (" . $this->generateUrl('user_page', array('username' => $this->getUser()->getGuardUser()->getUsername()), true) . ") invite you will be able to see their recommendations and places they go out to.\n
We're also waiting for your feedback and ideas on Facebook (http://www.facebook.fi/getlokal).\n
If you have an iPhone or Android device and you want to be connected to the latest events and places, take a look at our mobile app (http://app.getlokal.fi).\n
Being part of our community you could also subscribe to our weekly newsletter with events and place recommendations.\n
We will be honoured to have you onboard!\n
The getlokal.fi team & " . $this->getUser()->getGuardUser()->getFirstName() . " " . $this->getUser()->getGuardUser()->getLastName();
                }
                else {
                    $this->body = "A friend of yours invited you on getlokal.fi (http://www.getlokal.fi/en/helsinki)!\n
If you enter the getlokal.fi community, you'll be able to write reviews about the places you go out to, add photos of them and suggest new places. We often have campaigns with really great prizes, that you can win really easy. On top of that, for every action on our site you unlock cool badges\n
To join, open http://www.getlokal.fi/en/register/{hash} \n
We're also waiting for your feedback and ideas on Facebook (http://www.facebook.com/getlokal).\n
If you have an iPhone or Android device and you want to be connected to the latest events and places, take a look at our mobile app (http://app.getlokal.com).\n
Being part of our community you could also subscribe to our weekly newsletter with events and place recommendations.\n
We will be honoured to have you onboard!\n
The getlokal.fi team";
                }

                $this->underBodySignature = "http://www.getlokal.fi/en/register/{hash}";
            }
        }

        elseif (strpos($this->getContext()->getRequest()->getHost(), 'getlokal.hu') !== false || (strpos($this->getContext()->getRequest()->getHost(), 'hu.dev') !== false || strpos($this->getContext()->getRequest()->getHost(), 'hu.trunk') !== false)) {
            $this->subject = $this->i18n->__('A friend just invited you to join getlokal.hu!', null, 'mailsubject');

            if ($this->getUser()->getCulture() == 'hu') {
                $this->bodyP1 = 'Szia {username},';

                if ($this->getUser()->getGuardUser()->getFirstName() || $this->getUser()->getGuardUser()->getLastName()) {
                    $this->body = "{$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()} meghív téged getlokal.hu-ba (http://www.getlokal.hu/hu/budapest)!\n
Ha belépsz getlokal.com közösségébe írhatsz megjegyzéseket a helyekrol ahova szeretsz járni, fényképeket feltölteni róluk és új helyeket ajánlani. Gyakran szervezünk kampányokat igen nagy nyereményekkel, amelyeket igazán könnyen nyrhetsz. Ráadásul minden akció során a honlapunkon klassz cimkéket nyerhetsz. \n

A csatlakozáshoz nyíssd a http://www.getlokal.hu/hu/register/{hash} \n
Válaszolva {$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()} (" . $this->generateUrl('user_page', array('username' => $this->getUser()->getGuardUser()->getUsername()), true) . ") -nak, aki meghívot,  meg tudod nézni az ajánlatukat és a helyeket hová kimenni. \n
Úgyanakkor várjuk a visszajelzéseket és ötleteket a Facebook-ban (http://www.facebook.com/getlokal).\n
Ha van iPhone-od vagy Android készüléked és kapcsolatban akarsz lenni a legujjabb eseményekkel és helyekkel, nézd meg a mobil programunkat (http://app.getlokal.com).\n
Megtiszteltetésnek vesszük ha velünk tartasz! \n
Getlokal.hu csapata & " . $this->getUser()->getGuardUser()->getFirstName() . " " . $this->getUser()->getGuardUser()->getLastName();
                }
                else {
                    $this->body = "Barátod meghívott téged getlokal.com-ba (http://www.getlokal.com/hu/budapest)!\n
Ha belépsz getlokal.com közösségébe írhatsz megjegyzéseket a helyekrol ahova szeretsz járni, fényképeket feltölteni róluk és új helyeket ajánlani. Gyakran szervezünk kampányokat igen nagy nyereményekkel, amelyeket igazán könnyen nyrhetsz. Ráadásul minden akció során a honlapunkon klassz cimkéket nyerhetsz. \n

A csatlakozáshoz nyíssd a http://www.getlokal.hu/hu/register/{hash} \n
Úgyanakkor várjuk a visszajelzéseket és ötleteket a Facebook-ban (http://www.facebook.com/getlokal).\n
Ha van iPhone-od vagy Android készüléked és kapcsolatban akarsz lenni a legujjabb eseményekkel és helyekkel, nézd meg a mobil programunkat (http://app.getlokal.com).\n
Megtiszteltetésnek vesszük ha velünk tartasz! \n
Getlokal.hu csapata";
                }

                $this->underBodySignature = "http://www.getlokal.hu/hu/register/{hash}";
            }
            else {
                $this->bodyP1 = 'Hello {username},';

                if ($this->getUser()->getGuardUser()->getFirstName() || $this->getUser()->getGuardUser()->getLastName()) {
                    $this->body = "{$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()} is inviting you on getlokal.hu (http://www.getlokal.hu/en/budapest)!\n
If you enter the getlokal.hu community, you'll be able to write reviews about the places you go out to, add photos of them and suggest new places. We often have campaigns with really great prizes, that you can win really easy. On top of that, for every action on our site you unlock cool badges.\n
To join, open http://www.getlokal.hu/en/register/{hash} \n
By responding to {$this->getUser()->getGuardUser()->getFirstName()} {$this->getUser()->getGuardUser()->getLastName()}'s (" . $this->generateUrl('user_page', array('username' => $this->getUser()->getGuardUser()->getUsername()), true) . ") invite you will be able to see their recommendations and places they go out to.\n
We're also waiting for your feedback and ideas on Facebook (http://www.facebook.com/getlokal).\n
If you have an iPhone or Android device and you want to be connected to the latest events and places, take a look at our mobile app (http://app.getlokal.hu).\n
Being part of our community you could also subscribe to our weekly newsletter with events and place recommendations.\n
We will be honoured to have you onboard!\n
The getlokal.hu team & " . $this->getUser()->getGuardUser()->getFirstName() . " " . $this->getUser()->getGuardUser()->getLastName();
                }
                else {
                    $this->body = "A friend of yours invited you on getlokal.hu (http://www.getlokal.hu/en/budapest)!\n
If you enter the getlokal.hu community, you'll be able to write reviews about the places you go out to, add photos of them and suggest new places. We often have campaigns with really great prizes, that you can win really easy. On top of that, for every action on our site you unlock cool badges\n
To join, open http://www.getlokal.hu/en/register/{hash} \n
We're also waiting for your feedback and ideas on Facebook (http://www.facebook.com/getlokal).\n
If you have an iPhone or Android device and you want to be connected to the latest events and places, take a look at our mobile app (http://app.getlokal.com).\n
Being part of our community you could also subscribe to our weekly newsletter with events and place recommendations.\n
We will be honoured to have you onboard!\n
The getlokal.hu team";
                }

                $this->underBodySignature = "http://www.getlokal.hu/en/register/{hash}";
            }
        }


        $this->body = $this->bodyP1 . "\n\r" . $this->body;

        // Set hash for mails
        if (!$this->getUser()->hasAttribute('mhash')) {
            $hash = $this->_setHash();
            $this->getUser()->setAttribute('mhash', $hash);
        }
        else {
            $hash = $this->getUser()->getAttribute('mhash');
        }

        $this->body = str_replace('{hash}', $hash, $this->body);
        $this->underBodySignature = str_replace('{hash}', $hash, $this->underBodySignature);
        $this->underBodySignature = $this->i18n->__('To join getlokal click on this link:', null, 'user') . ' ' . $this->underBodySignature;

        // Very strange bug...
        $this->getUser()->setFlash('notice', null);
        $this->getUser()->setFlash('error', null);
    }

    public function executeIndex(sfWebRequest $request) {
        //$this->forward('invite', 'pm');
        $this->redirect('@invite_pm');
    }

    public function executePm(sfWebRequest $request) {
        $this->body = str_replace(' {username}', '', $this->body);

        $this->sendInvitePMForm = new sendInvitePMForm(array(), array('body' => $this->body));

        if ($request->isMethod('post')) {
            $this->sendInvitePMForm->bind($request->getParameter($this->sendInvitePMForm->getName()));

            if ($this->sendInvitePMForm->isValid())
            {
                $formValues = $this->sendInvitePMForm->getValues();

                $emails = $readyRegisteredEmails = array();
                foreach ($formValues as $name => $value) {
                    if (strpos($name, 'email_') !== false && $value) {
                        $emails[] = $value;
                    }
                }

                $this->body = $formValues['body'];

                $this->_saveIntoInvitedUsers($emails);

                $this->getUser()->setFlash('notice', $this->i18n->__('Your invite was sent successfully!', null, 'user'));
            }
        }
    }

    private function xmlToArray($xml) {
        $array = json_decode(json_encode($xml), true);

        foreach (array_slice($array, 0) as $key => $value) {
            if (empty($value)) {
                $array[$key] = null;
            }
            elseif (is_array($value)) {
                $array[$key] = $this->xmlToArray($value);
            }
        }

        return $array;
    }

    public function executeGetYahooContacts(sfWebRequest $request) {
        //YahooLogger::setDebug(true);
        //YahooLogger::setDebugDestination('CONSOLE');

        $yahooContacts = $tmpArr = array();

        //$routeName = sfContext::getInstance()->getRouting()->getCurrentRouteName();
        //$url = $this->generateUrl($routeName, array(), true);
        $url = $this->generateUrl('invite_yahoo_contacts', array(), true);
        $domain = getlokalPartner::getInstance();

        if ($domain == 1) {
            $domain = 'com';
        }
        else if ($domain == 2) {
            $domain = 'ro';
        }
        else if ($domain == 3) {
            $domain = 'mk';
        }
        else if ($domain == 4) {
            $domain = 'rs';
        }
        else {
            $domain = 'com';
        }

        // Check the user
        $hasSession = YahooSession::hasSession(
            sfConfig::get('app_yahoo_' . $domain . '_consumer_key'),
            sfConfig::get('app_yahoo_' . $domain . '_consumer_secret'),
            sfConfig::get('app_yahoo_' . $domain . '_app_id')
        );


        if (!$hasSession) {
            $authUrl = YahooSession::createAuthorizationUrl(
                sfConfig::get('app_yahoo_' . $domain . '_consumer_key'),
                sfConfig::get('app_yahoo_' . $domain . '_consumer_secret'),
                $url
                //sfConfig::get('app_yahoo_callback')
            );

            if ($authUrl) {
                $this->redirect($authUrl);
            }
        }
        else {
            // pass the credentials to initiate a session
            $session = YahooSession::requireSession(
                sfConfig::get('app_yahoo_' . $domain . '_consumer_key'),
                sfConfig::get('app_yahoo_' . $domain . '_consumer_secret'),
                sfConfig::get('app_yahoo_' . $domain . 'app_id')
            );

            if ($session) {
                // Get the currently sessioned user.
                $user = $session->getSessionedUser();

                // Load the profile for the current user.
                $profile = $user->getProfile();

                $profileContacts=$this->xmlToArray($user->getContactSync());



                //$profileContacts=$this->xmlToArray($user->getContacts());
                //var_dump($profileContacts['contacts']['contact']);
                //exit();

                //$profileContacts=$this->xmlToArray($user->getContacts(0, 100));
                //var_dump($profileContacts['contacts']['contact'][1]['fields']);
                //exit();



                /*
                $query = sprintf("select * from social.contacts where guid=me;");
                $response = $session->query($query);


                var_dump($response->query->results->contact);
                exit;

                if(isset($response)){

                   foreach($response->query->results->contact as $id){

                       foreach($id->fields as $subid){

                               if( $subid->type == 'email' )
                               echo $subid->value."<br />";
                       }
                   }
                }
                exit;
                */


                if (
                    isset($profileContacts['contactsync']['contacts']) &&
                    count($profileContacts['contactsync']['contacts'])
                ) {
                    foreach($profileContacts['contactsync']['contacts'] as $key=>$profileContact){
                        foreach($profileContact['fields'] as $contact) {
                            $tmpArr[$key][$contact['type']] = $contact['value'];
                        }
                    }
                }
            }
        }

        foreach ($tmpArr as $tmp) {
            $arr = array();
            $str = '';

            $arr[] = $tmp['name']['givenName'];
            $arr[] = $tmp['name']['middleName'];
            $arr[] = $tmp['name']['familyName'];

            $str = trim(implode(' ', $arr));

            if (!$str) {
                $str = $tmp['email'];
            }

            $yahooContacts[$tmp['email']] = $str;
        }

        YahooSession::clearSession();

        if (count($yahooContacts)) {
            foreach ($yahooContacts as $key => $value) {
                if (!$value) {
                    $yahooContacts[$key] = $key;
                }
            }
        }

        $this->getUser()->setAttribute('emailList', $yahooContacts);

        if (count($yahooContacts)) {
            $this->redirect('@invite_gy_check');
        } else {
            $this->getUser()->setFlash('error', $this->i18n->__('Your e-mail list is empty!', null, 'user'));
        }

        $this->setTemplate('executeGY');
    }

    public function executeGetGmailContacts(sfWebRequest $request) {
        $gmailContacts = array();
        //$routeName = sfContext::getInstance()->getRouting()->getCurrentRouteName();
        //$url = $this->generateUrl($routeName, array(), true);

        $url = $this->generateUrl('invite_gmail_contacts', array(), true);


        $client = new Google_Client();
        $client->setScopes("http://www.google.com/m8/feeds/");
        $client->setApplicationName(sfConfig::get('app_gmail_application_name'));
        $client->setClientId(sfConfig::get('app_gmail_client_id'));
        $client->setClientSecret(sfConfig::get('app_gmail_client_secret'));
        $client->setRedirectUri($url);
        $client->setDeveloperKey(sfConfig::get('app_gmail_developer_key'));


        if ($request->getParameter('code')) {
            $client->authenticate();
            $this->getUser()->setAttribute('gmail_token', $client->getAccessToken());

            $this->redirect(filter_var($url, FILTER_SANITIZE_URL));
        }

        if ($this->getUser()->getAttribute('gmail_token')) {
            $client->setAccessToken($this->getUser()->getAttribute('gmail_token'));
        }

        if ($client->getAccessToken()) {
          //$req = new Google_HttpRequest("https://www.google.com/m8/feeds/contacts/default/full?max-results=" . 100);
          $req = new Google_HttpRequest("https://www.google.com/m8/feeds/contacts/default/full");

          $val = $client->getIo()->authenticatedRequest($req);

          // The contacts api only returns XML responses.
          $response = simplexml_load_string($val->getResponseBody());

          foreach ($response->entry as $entry) {
            $gd = $entry->children("http://schemas.google.com/g/2005");

            foreach($gd->email as $emailNode) {
              $attributes = $emailNode->attributes();

              //$gmailContacts[] = array('title' => $entry->title->__toString(), 'email' => $attributes['address']->__toString());
              $gmailContacts[$attributes['address']->__toString()] = $entry->title->__toString();
            }
          }

          //$this->getUser()->setAttribute('gmail_token', $client->getAccessToken());
        } else {
            $this->redirect($client->createAuthUrl());
        }

        $this->getUser()->setAttribute('gmail_token', null);
        $client->revokeToken();

        if (count($gmailContacts)) {
            foreach ($gmailContacts as $key => $value) {
                if (!$value) {
                    $gmailContacts[$key] = $key;
                }
            }
        }

        $this->getUser()->setAttribute('emailList', $gmailContacts);

        if (count($gmailContacts)) {
            $this->redirect('@invite_gy_check');
        } else {
            $this->getUser()->setFlash('error', $this->i18n->__('Your e-mail list is empty!', null, 'user'));
        }

        $this->setTemplate('executeGY');
    }

    public function executeGY(sfWebRequest $request) {
        $this->getUser()->setAttribute('emailList', array());
        $this->getUser()->setFlash('isSend', true);
        $clicked = false;

        // Flash BUG!!!
        if (!$this->getUser()->hasFlash('notice')) {
            $this->getUser()->setFlash('notice', $this->getUser()->getAttribute('notice'));
            $this->getUser()->setAttribute('notice', null);
        }

        if ($request->getParameter('invite_choice', null) == 'gmail') {
            $this->forward('invite', 'getGmailContacts');
        } else if ($request->getParameter('invite_choice', null) == 'yahoo') {
            $this->forward('invite', 'getYahooContacts');
        }
    }

    // For google mails
    public function executeGYCheck(sfWebRequest $request) {
        if ($this->getUser()->getAttribute('emailList')) {
            $this->sendInviteGYForm = new sendInviteGYForm(array(), array('emails' => $this->getUser()->getAttribute('emailList'), 'body' => $this->body));

            if ($request->isMethod('post')) {
                $this->sendInviteGYForm->bind($request->getParameter($this->sendInviteGYForm->getName()));

                if ($this->sendInviteGYForm->isValid())
                {
                    //$this->getUser()->setAttribute('emailList', array());

                    $formValues = $this->sendInviteGYForm->getValues();

                    $this->body = $formValues['body'];

                    $this->_saveIntoInvitedUsers($formValues['email_lists'], null, 'gmail_yahoo');

                    $this->getUser()->setAttribute('notice', $this->i18n->__('Your invite was sent successfully!', null, 'user'));
                    $this->getUser()->setFlash('notice', $this->i18n->__('Your invite was sent successfully!', null, 'user'));

                    $this->redirect('@invite_gy');
                }
                else {
                    $this->getUser()->setFlash('isSend', true);
                }
            }
        }
        else
        {
            if (!$this->getUser()->getFlash('isSend', false)) {
                $this->redirect('@invite_gy');
            }
            else {
                $this->getUser()->setFlash('error', $this->i18n->__('Your e-mail list is empty!', null, 'user'));
                $this->redirect('@invite_gy');
            }
        }
    }

    private function getFacebookFriends(sfWebRequest $request, $user, $limit = 1, $offset = 0) {
        if (!$this->getUser()->getProfile()->getAccessToken() || !strlen(trim($this->getUser()->getProfile()->getAccessToken()))) {
            //$this->redirect('@invite');

            // Set page referer
            //$_SERVER['HTTP_REFERER'] = $this->generateUrl('invite_fb', array(), 'true');
            //$this->getUser()->setAttribute('invite.referer', $this->generateUrl('invite_fb', array(), 'true'));

            // Go to facebook connect
            $this->forward('user', 'FBLogin');
        }

        if ($user && $accessToken = $user->getUserProfile()->getAccessToken()) {
            $friendUrl = 'https://graph.facebook.com/me/friends?limit=' . $limit . '&offset=' . $offset . '&' . $accessToken;

            $response = json_decode(file_get_contents($friendUrl));
        }

        $friendList = array();

        foreach ($response->data as $key => $friend) {
            $name = $friend->name;

            if (mb_strlen($name,'utf8') > 15) {
                $name = mb_substr($name, 0, 14, 'utf8') . '...';
            }

            $friendList[$key]['id'] = $friend->id;
            $friendList[$key]['name'] = $name;
            if ($this->__checkIfUserExists($friend->id)) {
                $friendList[$key]['disabled'] = true;
            }
            else {
                $friendList[$key]['disabled'] = false;
            }
        }

        return array('friendList' => $friendList);
    }

    public function executeFacebook(sfWebRequest $request) {
        $app_id = "289748011093022";
        $app_secret = "517d65d2648bf350bb303914cb0ec664";
        $user = $this->getUser()->getGuardUser();
        $accessToken = $user->getUserProfile()->getAccessToken();

        $check_perm = "https://graph.facebook.com/me/permissions?" . $accessToken;
        $response = json_decode(file_get_contents($check_perm));
        $user_perm = $response->data;

        if(!$user_perm || $user_perm[0]->user_friends == false){
        $uri = $request->getUri();
        $this->getUser()->setAttribute('invite.referer', $uri);

        $my_url = $this->generateUrl('default', array('module' => 'user', 'action' => 'FBLogin'), true);
        $code = $request->getParameter('code');

            if (empty($code)) {
                $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url) . '&scope=user_location,email,user_birthday,offline_access,user_checkins';

                $this->redirect($dialog_url);
            }
        }

        $this->getUser()->getAttributeHolder()->remove('invite.referer');

        if (!$this->hash = $this->getUser()->getAttribute('hash', '')) {
            $this->hash = $this->_setHash();
            $this->getUser()->setAttribute('hash', $this->hash);
        }

        $limit = $request->getParameter('limit', 20);
        $offset = $request->getParameter('offset', 0);  //0, 10, 20, 30

        $facebookFriends = $this->getFacebookFriends($request, $user, $limit, $offset);

        $this->friendList = $facebookFriends['friendList'];


 /* OLD
        if ($response && count($response->data)) {
            $this->sendInviteFBForm = new sendInviteFBForm(array(), array('response' => $response));

            if ($request->isMethod('post') && !$this->getUser()->getFlash('isSend', false)) {
                $this->sendInviteFBForm->bind($request->getParameter($this->sendInviteFBForm->getName()));

                if ($this->sendInviteFBForm->isValid())
                {
                    $formValues = $this->sendInviteFBForm->getValues();

                    $this->_saveIntoInvitedUsers(null, $formValues['friend_lists'], 'facebook');

                    $this->getUser()->setFlash('isSend', true);
                    //$this->getUser()->setFlash('notice', 'Your invite was sent successfully!');
                }
            }
        }
        else {
            $this->getUser()->setFlash('error', 'Your facebook friend list is empty!');
        }
*/


        if ($request->isMethod('POST') && $friendId = $request->getPostParameter('friendId', false)) {
            $this->_saveIntoInvitedUsers(null, $friendId, 'facebook');
            return $this->renderText('');
        }

        if ($request->isMethod('POST') && $request->isXmlHttpRequest() && !$request->getPostParameter('friendId', false)) {
            $this->getResponse()->setContentType('application/json');
            return $this->renderText(json_encode(array('friendList' => $this->friendList)));
        }

        if (!count($this->friendList)) {
            $this->getUser()->setFlash('error', 'Your facebook friend list is empty!');
        }
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

    private function _saveIntoInvitedUsers($emails = null, $facebookUIDs = null, $invited_from = 'email') {
        if ($emails) {
            if (is_array($emails) && count($emails)) {
                foreach ($emails as $email) {
                    $this->_save($email, null, $invited_from);
                    $this->_sendInvites($email);
                }
            }
            else {
                $this->_sendInvites($emails);
            }

            $this->getUser()->setAttribute('mhash', NULL);
        }
        elseif ($facebookUIDs) {
            if (is_array($facebookUIDs) && count($facebookUIDs)) {
                foreach ($facebookUIDs as $facebookUID) {
                    $this->_save(null, $facebookUID, $invited_from);
                }
            }
            else {
                $this->_save(null, $facebookUIDs, $invited_from);
            }
        }

        $this->getUser()->setAttribute('emailList', array());
    }

    private function _save($email = null, $facebookUID = null, $invited_from = 'email') {
        if (!$this->getUser()->getId() || (!$email && !$facebookUID)) return false;

        /*
        if ($email) {
            $count = Doctrine::getTable('InvitedUser')
                ->createQuery('iu')
                ->where('iu.email = ?', $email)
                ->count();

            if ($count) return false;
        }
        elseif ($facebookUID) {
            $count = Doctrine::getTable('InvitedUser')
                ->createQuery('iu')
                ->where('iu.facebook_uid = ?', $facebookUID)
                ->count();

            if ($count) return false;
        }
        else {
            return false;
        }
        */

        $invitedUser = new invitedUser();

        if ($email) {
            $invitedUser->setEmail($email);

            $hash = $this->getUser()->getAttribute('mhash', $this->_setHash());
        }
        else {
            $invitedUser->setFacebookUid($facebookUID);

            $hash = $this->getUser()->getAttribute('hash', $this->_setHash());
            //$this->getUser()->setAttribute('hash', null);
        }

        $invitedUser->setHash($hash);
        $invitedUser->setInvitedFrom($invited_from);
        $invitedUser->setPointsToInvited($this->__calculatePoints());
        $invitedUser->setPointsToUser($this->__calculatePoints());
        $invitedUser->setUserId($this->getUser()->getId());
        $invitedUser->save();
    }

    private function _setHash() {
        $hash = md5(uniqid(rand(), true));
        $hash = substr($hash, 0, 30);

        return $hash;
    }

    private function _sendInvites($email = null) {
        $this->body = $this->__sanitarize($this->body);
        $this->underBodySignature = $this->__sanitarize($this->underBodySignature);

        $this->body = nl2br($this->body);
        $this->underBodySignature = nl2br($this->underBodySignature);

        $usernameArray = $this->getUser()->getAttribute('emailList', array());


        if (in_array($email, array_keys($usernameArray))) {
            $username = explode(" <", $usernameArray[$email]);
            $username = $username[0];
        }
        else {
            $username = '';
        }

        $this->bodyTmp = str_replace('{username}', $username, $this->body);

        myTools::sendMail(array($email => $username), $this->subject, 'invite', array('body' => $this->bodyTmp . "<br /><br />" . $this->underBodySignature));
    }

    private function __sanitarize ($param) {
        $param = strip_tags($param);

        $param = preg_replace("/<[^>]*>/", "", $param);

        return $param;
    }

    private function __calculatePoints() {
        return $this->points;
    }


    private function __checkIfUserExists($facebookID) {
        if ($user = Doctrine::getTable('UserProfile')->findOneByFacebookUid($facebookID)) {
            return true;
        }
        else {
            return false;
        }
    }
}
