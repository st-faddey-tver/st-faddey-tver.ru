<div class="container">
    <div class="header d-none d-md-block">
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
    <nav class="navbar navbar-expand-sm neopalimy-navbar">
        <ul class="navbar-nav">
            <?php
            $home_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/index.php' ? ' disabled' : '';
            
            $about_history_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/about/history.php' ? ' disabled' : '';
            $about_saints_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/about/saints.php' ? ' disabled' : '';
            $about_schedule_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/about/schedule.php' ? ' disabled' : '';
            $about_clergy_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/about/clergy.php' ? ' disabled' : '';
            $about_events_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/about/news/index.php' && filter_input(INPUT_GET, 'is_event') == 1 ? ' disabled' : '';
            $about_news_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/about/news/index.php' && filter_input(INPUT_GET, 'is_event') == 0 ? ' disabled' : '';
            
            $youth_volunteer_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/youth/volunteer.php' ? ' disabled' : '';
            $youth_club_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/youth/club.php' ? ' disabled' : '';
            $youth_family_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/youth/family.php' ? ' disabled' : '';
            $youth_cinema_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/youth/cinema.php' ? ' disabled' : '';
            
            $education_sunday_schedule_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/education/sunday/schedule.php' ? ' disabled' : '';
            $education_sunday_documents_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/education/sunday/documents.php' ? ' disabled' : '';
            $education_sunday_teachers_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/education/sunday/teachers.php' ? ' disabled' : '';
            $education_preparation_schedule_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/education/preparation/schedule.php' ? ' disabled' : '';
            $education_preparation_documents_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/education/preparation/documents.php' ? ' disabled' : '';
            $education_preparation_teachers_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/education/preparation/teachers.php' ? ' disabled' : '';
            
            $pilgrimage_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/pilgrimage.php' ? ' disabled': '';
            
            $contact_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/contact.php' ? ' disabled' : '';
            
            $gallery_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pages/gallery.php' ? ' disabled' : '';
            ?>
            <li class="nav-item">
                <a class="nav-link<?=$home_status ?>" href="<?=APPLICATION ?>/"><i class="fas fa-home"></i></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop_about" data-toggle="dropdown">О храме</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item<?=$about_history_status ?>" href="<?=APPLICATION ?>/history/">История</a>
                    <a class="dropdown-item<?=$about_saints_status ?>" href="<?=APPLICATION ?>/saints/">Святые храма</a>
                    <a class="dropdown-item<?=$about_schedule_status ?>" href="<?=APPLICATION ?>/schedule/">Расписание богослужений</a>
                    <a class="dropdown-item<?=$about_clergy_status ?>" href="<?=APPLICATION ?>/clergy/">Духовенство</a>
                    <a class="dropdown-item<?=$about_events_status ?>" href="<?=APPLICATION ?>/events/">Все события</a>
                    <a class="dropdown-item<?=$about_news_status ?>" href="<?=APPLICATION ?>/news/">Все новости</a>
                </div>
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
                    <li style="position: relative;">
                        <a class="dropdown-item dropdown-toggle" id="navbardrop_education_sunday" data-toggle="dropdown" href="#">Воскресная школа</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item<?=$education_sunday_schedule_status ?>" href="<?=APPLICATION ?>/sunday/schedule/">Расписание занятий</a>
                            <a class="dropdown-item<?=$education_sunday_documents_status ?>" href="<?=APPLICATION ?>/sunday/documents/">Документы</a>
                            <a class="dropdown-item<?=$education_sunday_teachers_status ?>" href="<?=APPLICATION ?>/sunday/teachers/">Преподаватели</a>
                        </div>
                    </li>
                    <li style="position: relative;">
                        <a class="dropdown-item dropdown-toggle" id="navbardrop_education_preparation" data-toggle="dropdown" href="#">Курсы подготовки для поступления в семинарию</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item<?=$education_preparation_schedule_status ?>" href="<?=APPLICATION ?>/preparation/schedule/">Расписание занятий</a>
                            <a class="dropdown-item<?=$education_preparation_documents_status ?>" href="<?=APPLICATION ?>/preparation/documents/">Документы</a>
                            <a class="dropdown-item<?=$education_preparation_teachers_status ?>" href="<?=APPLICATION ?>/preparation/teachers/">Преподаватели</a>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link<?=$pilgrimage_status ?>" href="<?=APPLICATION ?>/pilgrimage/">Паломничество</a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?=$contact_status ?>" href="<?=APPLICATION ?>/contact/">Контакты</a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?=$gallery_status ?>" href="<?=APPLICATION ?>/gallery/">Фотогалерея</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a data-toggle="tooltip" title="Пожертвовать" href="javascript:void(0);" class="nav-link"><i class="fas fa-ruble-sign"></i></a>
            </li>
        </ul>
    </nav>
</div>