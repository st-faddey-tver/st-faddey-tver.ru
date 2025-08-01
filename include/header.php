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
<div class="top" id="top" style="background-image: url(<?=APPLICATION ?>/images/shapka_zima.jpg); background-position-x: center; background-position-y: top; background-size: cover;">
    <div class="container" style="margin-bottom: 0;">
        <div class="header">
            <a href="<?=APPLICATION ?>/"><img src="<?=APPLICATION ?>/images/header_prozrachny.png?date=20231120" class="img-fluid d-none d-md-block" /></a>
            <div class="d-none d-md-block" style="font-family: Times New Roman, Times, serif; position: absolute; top: 50%; left: 1%; color: #913d14; font-size: large; line-height: normal; font-style: italic; font-weight: bold; width: 25%; text-align: left;">
                &#8222;Сними обувь твою с ног твоих, ибо место, на котором ты стоишь, есть земля святая.&#8220;
                <div style="text-align: right; font-size: smaller;">Исх 3:5</div>
            </div>
            <div class="d-none d-md-block" style="font-family: Times New Roman, Times, serif; position: absolute; top: 50%; right: 1%; color: #913d14; font-size: large; line-height: normal; font-style: italic; font-weight: bold; width: 25%; text-align: left;">
                &#8222;Не унывайте,<br />Христос ведь с нами.&#8220;
                <div style="text-align: right; font-size: smaller;">Сщмч. Фаддей</div>
            </div>
            
            <div class="d-flex d-md-none row">
                <div class="col-4">
                    <a href="<?=APPLICATION ?>/"><img src="<?=APPLICATION ?>/images/petrov_image_400.png" class="img-fluid" /></a>
                </div>
                <div class="col-8 pt-2">
                    <a href="<?=APPLICATION ?>/"><img src="<?=APPLICATION ?>/images/header_slav_transparent.png?date=20231120" class="img-fluid" /></a>
                </div>
            </div>
            
            <?php
            if(IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))):
            ?>
            <div style="position: absolute; right: 0; bottom: 0;">
                <a class="btn btn-danger" href="<?=APPLICATION ?>/admin/">Администратор</a>
            </div>
            <?php
            endif;
            ?>
        </div>
    </div>
</div>
<?php
$home_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/index.php' ? ' disabled' : '';
    
$about_history_status = filter_input(INPUT_GET, 'shortname') == 'history' ? ' disabled' : '';
$about_mina_status = filter_input(INPUT_GET, 'shortname') == 'mina_viktor_vikenty' ? ' disabled' : '';
$about_saints_alexey_benemansky_status = filter_input(INPUT_GET, 'shortname') == 'alexey_benemansky' ? ' disabled' : '';
$about_saints_vera_truks_status = filter_input(INPUT_GET, 'shortname') == 'vera_truks' ? ' disabled' : '';
$about_saints_ilya_benemansky_status = filter_input(INPUT_GET, 'shortname') == 'ilya_benemansky' ? ' disabled' : '';
$about_saints_ilya_gromoglasov_status = filter_input(INPUT_GET, 'shortname') == 'ilya_gromoglasov' ? ' disabled' : '';
$about_saints_nikolay_maslov_status = filter_input(INPUT_GET, 'shortname') == 'nikolay_maslov' ? ' disabled' : '';
$about_saints_faddey_uspensky_status = filter_input(INPUT_GET, 'shortname') == 'faddey_uspensky' ? ' disabled' : '';
$about_treasures_spyridon_status = filter_input(INPUT_GET, 'shortname') == 'st_spyridon' ? ' disabled' : '';
$about_treasures_alexander_nevsky_status = filter_input(INPUT_GET, 'shortname') == 'st_alexander_nevsky' ? ' disabled' : '';
$about_volunteer_status = filter_input(INPUT_GET, 'shortname') == 'volunteer' ? ' disabled' : '';    
$about_pilgrimage_status = filter_input(INPUT_GET, 'shortname') == 'pilgrimage' ? ' disabled' : '';
$about_schedule_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/schedule.php' ? ' disabled' : '';
$about_clergy_status = filter_input(INPUT_GET, 'shortname') == 'clergy' ? ' disabled' : '';
$about_news_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/allnews/index.php' ? ' disabled' : '';
$about_media_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/media/index.php' ? ' disabled' : '';

$cantus_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/cant/index.php' ? ' disabled' : '';
$cantus_ustav_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/kustovsky/index.php' ? ' disabled' : '';

$articles_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/article/index.php' ? ' disabled' : '';
$theater_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/theater.php' ? ' disabled' : '';
$icon_status = filter_input(INPUT_GET, 'shortname') == 'icon' ? ' disabled' : '';
$contact_status = filter_input(INPUT_GET, 'shortname') == 'contact' ? ' disabled' : '';
$donation_status = filter_input(INPUT_GET, 'shortname') == 'donation' ? ' disabled' : '';
?>
<nav class="navbar navbar-expand-lg neopalimy-navbar">
    <div class="container">
        <a class="navbar-brand<?=$home_status ?>" href="<?=APPLICATION ?>/">
            <i class="fas fa-home"></i><span class="d-none d-md-inline d-lg-none">&nbsp;Храм сщмч. Фаддея</span>
        </a>
        <a href="<?=APPLICATION ?>/donation/" class="nav-link<?=$donation_status ?> d-inline d-lg-none" data-toggle="tooltip" title="Пожертвовать"><i class="fas fa-ruble-sign"></i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="menu-toggler">Меню</span>
            <!--span class="navbar-toggler-icon"></span-->
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <?php
            include 'navbar.php';
            ?>
        </div>
    </div>
</nav>
<nav class="navbar navbar-expand-lg neopalimy-navbar" id="navbar_hideable" style="display: none;">
    <div class="container">
        <a class="navbar-brand<?=$home_status ?>" href="<?=APPLICATION ?>/">
            <i class="fas fa-home"></i><span class="d-none d-md-inline d-lg-none">&nbsp;Храм сщмч. Фаддея</span>
        </a>
        <a href="<?=APPLICATION ?>/donation/" class="nav-link<?=$donation_status ?> d-inline d-lg-none" data-toggle="tooltip" title="Пожертвовать"><i class="fas fa-ruble-sign"></i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbarHideable">
            <span class="menu-toggler">Меню</span>
            <!--span class="navbar-toggler-icon"></span-->
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbarHideable">
            <?php
            include 'navbar.php';
            ?>
        </div>
    </div>
</nav>