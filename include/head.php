<meta charset="UTF-8">
<title><?= empty($title) ? "Храм священномученика Фаддея архиепископа Тверского" : $title ?></title>
<link href="<?=APPLICATION ?>/css/bootstrap.min.css" rel="stylesheet">
<link href="<?=APPLICATION ?>/fontawesome-free-5.15.2-web/css/all.min.css" rel="stylesheet" />
<link href="<?=APPLICATION ?>/fancybox-master/dist/jquery.fancybox.min.css" rel="stylesheet" />
<link href="<?=APPLICATION ?>/css/main.css?version=15" rel="stylesheet" />

<link rel="icon" type="image/png" sizes="16x16" href="<?=$_SERVER['REQUEST_SCHEME'].'://'. $_SERVER['HTTP_HOST'].APPLICATION ?>/favicon/favicon-16x16.png" />
<link rel="icon" type="image/png" sizes="32x32" href="<?=$_SERVER['REQUEST_SCHEME'].'://'. $_SERVER['HTTP_HOST'].APPLICATION ?>/favicon/favicon-32x32.png" />
<link rel="apple-touch-icon" sizes="180x180" href="<?=$_SERVER['REQUEST_SCHEME'].'://'. $_SERVER['HTTP_HOST'].APPLICATION ?>/favicon/apple-touch-icon.png">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
const TITLE = "Храм священномученика Фаддея архиепископа Тверского";
const DESCRIPTION = "Наш храм построен на месте обретения мощей священномученика Фаддея архиепископа Тверского. Здесь раньше находился храм иконы Божией Матери Неопалимая Купина, разрушенный в советское время. И с ним связаны целых пять имён, прославленных Церковью в лике новомучеников и исповеданников Российских.";
const KEYWORDS = "храм Фаддея, церковь Фаддея, храм святого Фаддея, церковь святого Фаддея, святой Фаддей архиепископ Тверской, священномученик Фаддей";
?>
<meta name="title" content="<?= empty($title) ? TITLE : $title ?>" />
<meta name="description" content="<?= empty($description) ? DESCRIPTION : $description ?>" />
<meta name="keywords" content="<?= empty($keywords) ? KEYWORDS : $keywords ?>" />
<meta property="og:title" content="<?= empty($title) ? TITLE : $title ?>" />
<meta property="og:url" content="<?= $_SERVER['REQUEST_SCHEME'].'://'. $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>" />
<meta property="og:description" content="<?= empty($description) ? DESCRIPTION : $description ?>" />
<meta property="og:image" content="<?= empty($image) ? $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].APPLICATION."/images/ikona.jpg" : $image ?>" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="ru_RU" />
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(75082543, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/75082543" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'GA_MEASUREMENT_ID');
</script>
<!-- /Global site tag (gtag.js) - Google Analytics -->
<!-- Top.Mail.Ru counter -->
<script type="text/javascript">
var _tmr = window._tmr || (window._tmr = []);
_tmr.push({id: "3527895", type: "pageView", start: (new Date()).getTime()});
(function (d, w, id) {
  if (d.getElementById(id)) return;
  var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
  ts.src = "https://top-fwz1.mail.ru/js/code.js";
  var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
  if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
})(document, window, "tmr-code");
</script>
<noscript><div><img src="https://top-fwz1.mail.ru/counter?id=3527895;js=na" style="position:absolute;left:-9999px;" alt="Top.Mail.Ru" /></div></noscript>
<!-- /Top.Mail.Ru counter -->
