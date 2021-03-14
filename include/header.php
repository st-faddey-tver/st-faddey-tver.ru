<div class="container">
    <div class="header d-none d-lg-block">
        <a href="<?=APPLICATION ?>/"><img src="<?=APPLICATION ?>/images/header_two_icons.jpg" class="img-fluid" /></a>
        <div style="font-family: Times New Roman, Times, serif; position: absolute; top: 50%; left: 1%; color: #913d14; font-size: large; line-height: normal; font-style: italic; font-weight: bold; width: 25%; text-align: left;">
            &#8222;Сними обувь твою с ног твоих, ибо место, на котором ты стоишь, есть земля святая.&#8220;
            <div style="text-align: right; font-size: smaller;">Исх 3:5</div>
        </div>
        <div style="font-family: Times New Roman, Times, serif; position: absolute; top: 50%; right: 1%; color: #913d14; font-size: large; line-height: normal; font-style: italic; font-weight: bold; width: 25%; text-align: left;">
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
    <a href="<?=APPLICATION ?>/">
    <div class="header d-block d-lg-none" style="background-image: url(<?=APPLICATION ?>/images/shapka1000ps.jpg); background-position-x: 100%; background-position-y: 50%;">
        <div class="row">
            <div class="col-3">
                <img src="<?=APPLICATION ?>/images/neopalimaya1000.jpg" style="height: 150px;" />
            </div>
            <div class="col-6">
                <div class="h-50 pt-3" style="font-size: 1.6rem; font-family: Times New Roman, Times, serif; color: #913d14; font-style: italic; font-weight: bold;">&#8222;Не унывайте, Христос ведь с нами.&#8220;</div>
                <div class="text-right h-50" style="font-size: 1.4rem; font-family: Times New Roman, Times, serif; color: #913d14; font-style: italic; font-weight: bold;">Св. Фаддей</div>
            </div>
            <div class="col-3 text-right">
                <img src="<?=APPLICATION ?>/images/ikona.jpg" style="height: 150px;" />
            </div>
        </div>
    </div>
        </a>
    <?php
    $home_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/index.php' ? ' disabled' : '';
    
    $about_history_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/about/history.php' ? ' disabled' : '';
    $about_saints_nikolay_maslov_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/about/saints/nikolay_maslov.php' ? ' disabled' : '';
    $about_saints_ilya_gromoglasov_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/about/saints/ilya_gromoglasov.php' ? ' disabled' : '';
    $about_saints_ilya_benemansky_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/about/saints/ilya_benemansky.php' ? ' disabled' : '';
    $about_saints_faddey_uspensky_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/about/saints/faddey_uspensky.php' ? ' disabled' : '';
    $about_schedule_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/about/schedule.php' ? ' disabled' : '';
    $about_clergy_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/about/clergy.php' ? ' disabled' : '';
    $about_events_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/about/events/index.php' ? ' disabled' : '';
    $about_news_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/about/news/index.php' ? ' disabled' : '';
    
    $youth_volunteer_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/youth/volunteer.php' ? ' disabled' : '';
    $youth_club_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/youth/club.php' ? ' disabled' : '';
    $youth_family_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/youth/family.php' ? ' disabled' : '';
    $youth_cinema_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/youth/cinema.php' ? ' disabled' : '';
    
    $education_sunday_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/education/sunday.php' ? ' disabled' : '';
    $education_preparation_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/education/preparation.php' ? ' disabled' : '';
    
    $pilgrimage_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/pilgrimage.php' ? ' disabled': '';
    $contact_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/contact.php' ? ' disabled' : '';
    $donation_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/donation.php' ? ' disabled' : '';
    ?>
    <nav class="navbar navbar-expand-lg neopalimy-navbar">
        <a class="navbar-brand<?=$home_status ?>" href="<?=APPLICATION ?>/">
            <i class="fas fa-home"></i><span class="d-inline d-lg-none">&nbsp;&nbsp;Храм сщмч. Фаддея архиепископа Тверского</span>
        </a>
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
                            <a class="dropdown-item dropdown-toggle" id="navbardrop_about_saints" data-toggle="dropdown" href="#">Святые храма</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item<?=$about_saints_nikolay_maslov_status ?>" href="<?=APPLICATION ?>/nikolay_maslov/">Николай Маслов</a>
                                <a class="dropdown-item<?=$about_saints_ilya_gromoglasov_status ?>" href="<?=APPLICATION ?>/ilya_gromoglasov/">Илья Громогласов</a>
                                <a class="dropdown-item<?=$about_saints_ilya_benemansky_status ?>" href="<?=APPLICATION ?>/ilya_benemansky/">Илья Бенеманский</a>
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
                    <a data-toggle="tooltip" title="Пожертвовать" href="<?=APPLICATION ?>/donation/" class="nav-link<?=$donation_status ?>"><span class="d-inline d-lg-none">Пожертвовать&nbsp;</span><i class="fas fa-ruble-sign"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</div>