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
            <li style="position: relative;">
                <a class="dropdown-item dropdown-toggle" id="navbardrop_about_treasures" data-toggle="dropdown" href="javascript: return false;">Святыни храма</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item<?=$about_treasures_spyridon_status ?>" href="<?=APPLICATION ?>/st_spyridon/">Икона св. Спиридона Тримифунтского</a>
                    <a class="dropdown-item<?=$about_treasures_alexander_nevsky_status ?>" href="<?=APPLICATION ?>/st_alexander_nevsky/">Икона св. Александра Невского</a>
                </div>
            </li>
            <li><a class="dropdown-item<?=$about_schedule_status ?>" href="<?=APPLICATION ?>/schedule/">Расписание богослужений</a></li>
            <li><a class="dropdown-item<?=$about_clergy_status ?>" href="<?=APPLICATION ?>/clergy/">Духовенство</a></li>
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
        <a class="nav-link<?=$education_sunday_status ?>" href="<?=APPLICATION ?>/sunday/">Воскресная школа</a>
    </li>
    <li class="nav-item">
        <a class="nav-link<?=$pilgrimage_status ?>" href="<?=APPLICATION ?>/pilgrimage/">Паломничество</a>
    </li>
    <li class="nav-item">
        <a class="nav-link<?=$icon_status ?>" href="<?=APPLICATION ?>/icon/">Иконопись</a>
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