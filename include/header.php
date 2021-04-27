<div class="top" style="background-image: url(<?=APPLICATION ?>/images/shapka_zima.jpg); background-position-x: center; background-position-y: top; background-size: cover;">
    <div class="container" style="margin-bottom: 0;">
        <div class="header">
            <a href="<?=APPLICATION ?>/"><img src="<?=APPLICATION ?>/images/header_prozrachny.png" class="img-fluid" /></a>
            <div class="d-none d-md-block" style="font-family: Times New Roman, Times, serif; position: absolute; top: 50%; left: 1%; color: #913d14; font-size: large; line-height: normal; font-style: italic; font-weight: bold; width: 25%; text-align: left;">
                &#8222;Сними обувь твою с ног твоих, ибо место, на котором ты стоишь, есть земля святая.&#8220;
                <div style="text-align: right; font-size: smaller;">Исх 3:5</div>
            </div>
            <div class="d-none d-md-block" style="font-family: Times New Roman, Times, serif; position: absolute; top: 50%; right: 1%; color: #913d14; font-size: large; line-height: normal; font-style: italic; font-weight: bold; width: 25%; text-align: left;">
                &#8222;Не унывайте,<br />Христос ведь с нами.&#8220;
                <div style="text-align: right; font-size: smaller;">Св. Фаддей</div>
            </div>
            <?php
            if(HasRole()):
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
$about_saints_vera_truks_status = filter_input(INPUT_GET, 'shortname') == 'vera_truks' ? ' disabled' : '';
$about_saints_ilya_benemansky_status = filter_input(INPUT_GET, 'shortname') == 'ilya_benemansky' ? ' disabled' : '';
$about_saints_ilya_gromoglasov_status = filter_input(INPUT_GET, 'shortname') == 'ilya_gromoglasov' ? ' disabled' : '';
$about_saints_nikolay_maslov_status = filter_input(INPUT_GET, 'shortname') == 'nikolay_maslov' ? ' disabled' : '';
$about_saints_faddey_uspensky_status = filter_input(INPUT_GET, 'shortname') == 'faddey_uspensky' ? ' disabled' : '';
$about_schedule_status = filter_input(INPUT_GET, 'shortname') == 'schedule' ? ' disabled' : '';
$about_clergy_status = filter_input(INPUT_GET, 'shortname') == 'clergy' ? ' disabled' : '';
$about_events_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/allevents/index.php' ? ' disabled' : '';
$about_news_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/allnews/index.php' ? ' disabled' : '';
    
$youth_volunteer_status = filter_input(INPUT_GET, 'shortname') == 'volunteer' ? ' disabled' : '';
$youth_club_status = filter_input(INPUT_GET, 'shortname') == 'club' ? ' disabled' : '';
$youth_family_status = filter_input(INPUT_GET, 'shortname') == 'family' ? ' disabled' : '';
$youth_cinema_status = filter_input(INPUT_GET, 'shortname') == 'cinema' ? ' disabled' : '';
    
$education_sunday_status = filter_input(INPUT_GET, 'shortname') == 'sunday' ? ' disabled' : '';
$education_preparation_status = filter_input(INPUT_GET, 'shortname') == 'preparation' ? ' disabled' : '';
    
$pilgrimage_status = filter_input(INPUT_GET, 'shortname') == 'pilgrimage' ? ' disabled': '';
$contact_status = filter_input(INPUT_GET, 'shortname') == 'contact' ? ' disabled' : '';
$donation_status = filter_input(INPUT_GET, 'shortname') == 'donation' ? ' disabled' : '';
?>
<nav class="navbar navbar-expand-lg neopalimy-navbar">
    <div class="container">
        <a class="navbar-brand<?=$home_status ?>" href="<?=APPLICATION ?>/">
            <i class="fas fa-home"></i>
        </a>
        <a href="<?=APPLICATION ?>/donation/" class="nav-link<?=$donation_status ?> d-inline d-lg-none" data-toggle="tooltip" title="Пожертвовать"><i class="fas fa-ruble-sign"></i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <!--span class="navbar-toggler-icon"></span-->
            <span class="menu-toggler">Меню</span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop_about" data-toggle="dropdown">О храме</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item<?=$about_history_status ?>" href="<?=APPLICATION ?>/history/">История</a></li>
                        <li style="position: relative;">
                            <a class="dropdown-item dropdown-toggle" id="navbardrop_about_saints" data-toggle="dropdown" href="javascript: return false;">Святые храма</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item<?=$about_saints_vera_truks_status ?>" href="<?=APPLICATION ?>/vera_truks/">Вера Трукс</a>
                                <a class="dropdown-item<?=$about_saints_ilya_benemansky_status ?>" href="<?=APPLICATION ?>/ilya_benemansky/">Илья Бенеманский</a>
                                <a class="dropdown-item<?=$about_saints_ilya_gromoglasov_status ?>" href="<?=APPLICATION ?>/ilya_gromoglasov/">Илья Громогласов</a>
                                <a class="dropdown-item<?=$about_saints_nikolay_maslov_status ?>" href="<?=APPLICATION ?>/nikolay_maslov/">Николай Маслов</a>
                                <a class="dropdown-item<?=$about_saints_faddey_uspensky_status ?>" href="<?=APPLICATION ?>/faddey_uspensky/">Фаддей Успенский</a>
                            </div>
                        </li>
                        <li><a class="dropdown-item<?=$about_schedule_status ?>" href="<?=APPLICATION ?>/schedule/">Расписание богослужений</a></li>
                        <li><a class="dropdown-item<?=$about_clergy_status ?>" href="<?=APPLICATION ?>/clergy/">Духовенство</a></li>
                        <li><a class="dropdown-item<?=$about_events_status ?>" href="<?=APPLICATION ?>/events/">Все события</a></li>
                        <li><a class="dropdown-item<?=$about_news_status ?>" href="<?=APPLICATION ?>/news/">Все новости</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop_youth" data-toggle="dropdown">Молодёжь храма</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item<?=$youth_volunteer_status ?>" href="<?=APPLICATION ?>/volunteer/">Добровольческое движение</a>
                        <a class="dropdown-item<?=$youth_club_status ?>" href="<?=APPLICATION ?>/club/">Молодёжный клуб &laquo;Встреча&raquo;</a>
                        <a class="dropdown-item<?=$youth_family_status ?>" href="<?=APPLICATION ?>/family/">Семейный клуб</a>
                        <a class="dropdown-item<?=$youth_cinema_status ?>" href="<?=APPLICATION ?>/cinema/">Синематографический клуб</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop_education" data-toggle="dropdown">Образовательный центр</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item<?=$education_sunday_status ?>" href="<?=APPLICATION ?>/sunday/">Воскресная школа</a></li>
                        <li><a class="dropdown-item<?=$education_preparation_status ?>" href="<?=APPLICATION ?>/preparation/">Курсы подготовки для поступления в семинарию</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?=$pilgrimage_status ?>" href="<?=APPLICATION ?>/pilgrimage/">Паломничество</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?=$contact_status ?>" href="<?=APPLICATION ?>/contact/">Контакты</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a title="Пожертвовать" href="<?=APPLICATION ?>/donation/" class="nav-link<?=$donation_status ?>">Пожертвовать</a>
                </li>
            </ul>
        </div>
    </div>
</nav>