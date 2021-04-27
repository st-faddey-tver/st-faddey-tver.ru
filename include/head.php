<meta charset="UTF-8">
<title><?= empty($title) ? "Храм священномученика Фаддея архиепископа Тверского" : $title ?></title>
<link href="<?=APPLICATION ?>/css/bootstrap.min.css" rel="stylesheet">
<link href="<?=APPLICATION ?>/fontawesome-free-5.15.2-web/css/all.min.css" rel="stylesheet" />
<link href="<?=APPLICATION ?>/fancybox-master/dist/jquery.fancybox.min.css" rel="stylesheet" />
<link href="<?=APPLICATION ?>/css/main.css?version=8" rel="stylesheet" />

<link rel="apple-touch-icon" sizes="180x180" href="<?=APPLICATION ?>/apple-touch-icon.png" />
<link rel="icon" type="image/png" sizes="32x32" href="<?=APPLICATION ?>/favicon-32x32.png" />
<link rel="icon" type="image/png" sizes="16x16" href="<?=APPLICATION ?>/favicon-16x16.png" />
<link rel="1manifest" href="<?= APPLICATION ?>/site.webmanifest" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="msapplication-TileColor" content="#da532c" />
<meta name="theme-color" content="#ffffff" />
<?php
const TITLE = "Храм священномученика Фаддея архиепископа Тверского";
const DESCRIPTION = "Наш храм построен на месте обретения мощей священномученика Фаддея архиепископа Тверского. Здесь раньше находился храм иконы Божией Матери Неопалимая Купина, разрушенный в советское время. И с ним связаны целых пять имён, прославленных Церковью в лике новомучеников и исповеданников Российских.";
const KEYWORDS = "храм Фаддея, церковь Фаддея, храм святого Фаддея, церковь святого Фаддея, святой Фаддей архиепископ Тверской, священномученик Фаддей";
?>
<meta name="title" content="<?= empty($title) ? TITLE : $title ?>" />
<meta name="description" content="<?= empty($description) ? DESCRIPTION : $description ?>" />
<meta name="keywords" content="<?= empty($keywords) ? KEYWORDS : $keywords ?>" />
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
<!--LiveInternet counter-->
<script>
new Image().src = "https://counter.yadro.ru/hit?r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";h"+escape(document.title.substring(0,150))+
";"+Math.random();
</script>
<!--/LiveInternet-->
