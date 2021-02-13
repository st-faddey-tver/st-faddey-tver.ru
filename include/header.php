<div class="container">
    <div class="header d-none d-md-block">
        <a href="<?=APPLICATION ?>/"><img src="<?=APPLICATION ?>/images/header_two_icons.jpg" class="img-fluid" /></a>
    </div>
    <nav class="navbar navbar-expand-sm neopalimy-navbar">
        <ul class="navbar-nav">
            <?php
            $home_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/index.php' ? ' disabled' : '';
            
            $about_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/about/index.php' ? ' disabled' : '';
            $about_history_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/about/history/index.php' ? ' disabled' : '';
            $about_saints_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/about/saints/index.php' ? ' disabled' : '';
            $about_schedule_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/about/schedule/index.php' ? ' disabled' : '';
            $about_clergy_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/about/clergy/index.php' ? ' disabled' : '';
            
            $youth_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/youth/index.php' ? ' disabled' : '';
            $youth_volunteer_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/youth/volunteer/index.php' ? ' disabled' : '';
            $youth_club_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/youth/club/index.php' ? ' disabled' : '';
            $youth_family_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/youth/family/index.php' ? ' disabled' : '';
            $youth_cinema_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/youth/cinema/index.php' ? ' disabled' : '';
            
            $education_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/education/index.php' ? ' disabled' : '';
            $education_sunday_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/education/sunday/index.php' ? ' disabled' : '';
            $education_sunday_schedule_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/education/sunday/schedule/index.php' ? ' disabled' : '';
            $education_sunday_documents_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/education/sunday/documents/index.php' ? ' disabled' : '';
            $education_sunday_teachers_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/education/sunday/teachers/index.php' ? ' disabled' : '';
            $education_preparation_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/education/preparation/index.php' ? ' disabled' : '';
            $education_preparation_schedule_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/education/preparation/schedule/index.php' ? ' disabled' : '';
            $education_preparation_documents_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/education/preparation/documents/index.php' ? ' disabled' : '';
            $education_preparation_teachers_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/education/preparation/teachers/index.php' ? ' disabled' : '';
            
            $pilgrimage_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/pilgrimage/index.php' ? ' disabled': '';
            
            $contact_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/contact/index.php' ? ' disabled' : '';
            
            $gallery_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/gallery/index.php' ? ' disabled' : '';
            ?>
            <li class="nav-item">
                <a class="nav-link<?=$home_status ?>" href="<?=APPLICATION ?>/"><i class="fas fa-home"></i></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle<?=$about_status ?>" href="#" id="navbardrop_about" data-toggle="dropdown">О храме</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item<?=$about_history_status ?>" href="<?=APPLICATION ?>/about/history/">История</a>
                    <a class="dropdown-item<?=$about_saints_status ?>" href="<?=APPLICATION ?>/about/saints/">Святые храма</a>
                    <a class="dropdown-item<?=$about_schedule_status ?>" href="<?=APPLICATION ?>/about/schedule/">Расписание богослужений</a>
                    <a class="dropdown-item<?=$about_clergy_status ?>" href="<?=APPLICATION ?>/about/clergy/">Духовенство</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle<?=$youth_status ?>" href="#" id="navbardrop_youth" data-toggle="dropdown">Молодёжь храма</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item<?=$youth_volunteer_status ?>" href="<?=APPLICATION ?>/youth/volunteer/">Добровольческое движение</a>
                    <a class="dropdown-item<?=$youth_club_status ?>" href="<?=APPLICATION ?>/youth/club/">Молодёжный клуб &laquo;Встреча&raquo;</a>
                    <a class="dropdown-item<?=$youth_family_status ?>" href="<?=APPLICATION ?>/youth/family/">Семейный клуб</a>
                    <a class="dropdown-item<?=$youth_cinema_status ?>" href="<?=APPLICATION ?>/youth/cinema/">Синематографический клуб</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle<?=$education_status ?>" href="#" id="navbardrop_education" data-toggle="dropdown">Образовательный центр</a>
                <ul class="dropdown-menu">
                    <li style="position: relative;">
                        <a class="dropdown-item dropdown-toggle<?=$education_sunday_status ?>" id="navbardrop_education_sunday" data-toggle="dropdown" href="#">Воскресная школа</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item<?=$education_sunday_schedule_status ?>" href="<?=APPLICATION ?>/education/sunday/schedule/">Расписание занятий</a>
                            <a class="dropdown-item<?=$education_sunday_documents_status ?>" href="<?=APPLICATION ?>/education/sunday/documents/">Документы</a>
                            <a class="dropdown-item<?=$education_sunday_teachers_status ?>" href="<?=APPLICATION ?>/education/sunday/teachers/">Преподаватели</a>
                        </div>
                    </li>
                    <li style="position: relative;">
                        <a class="dropdown-item dropdown-toggle<?=$education_preparation_status ?>" id="navbardrop_education_preparation" data-toggle="dropdown" href="#">Курсы подготовки для поступления в семинарию</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item<?=$education_preparation_schedule_status ?>" href="<?=APPLICATION ?>/education/preparation/schedule/">Расписание занятий</a>
                            <a class="dropdown-item<?=$education_preparation_documents_status ?>" href="<?=APPLICATION ?>/education/preparation/documents/">Документы</a>
                            <a class="dropdown-item<?=$education_preparation_teachers_status ?>" href="<?=APPLICATION ?>/education/preparation/teachers/">Преподаватели</a>
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
    </nav>
</div>