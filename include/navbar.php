<ul class="navbar-nav">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop_about" data-toggle="dropdown">О приходе</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item<?=$about_history_status ?>" href="<?=APPLICATION ?>/history/">Храм сщмч. Фаддея архиепископа Тверского</a></li>
            <li><a class="dropdown-item<?=$about_mina_status ?>" href="<?=APPLICATION ?>/mina_viktor_vikenty/">Храм мчч. Мины, Виктора и Викентия</a></li>
            <li style="position: relative;">
                <a class="dropdown-item dropdown-toggle" id="navbardrop_about_saints" data-toggle="dropdown" href="javascript: return false;">Святые прихода</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item<?=$about_saints_alexey_benemansky_status ?>" href="<?=APPLICATION ?>/alexey_benemansky/">Алексей Бенеманский</a>
                    <a class="dropdown-item<?=$about_saints_vera_truks_status ?>" href="<?=APPLICATION ?>/vera_truks/">Вера Трукс</a>
                    <a class="dropdown-item<?=$about_saints_ilya_benemansky_status ?>" href="<?=APPLICATION ?>/ilya_benemansky/">Илья Бенеманский</a>
                    <a class="dropdown-item<?=$about_saints_ilya_gromoglasov_status ?>" href="<?=APPLICATION ?>/ilya_gromoglasov/">Илья Громогласов</a>
                    <a class="dropdown-item<?=$about_saints_nikolay_maslov_status ?>" href="<?=APPLICATION ?>/nikolay_maslov/">Николай Маслов</a>
                    <a class="dropdown-item<?=$about_saints_faddey_uspensky_status ?>" href="<?=APPLICATION ?>/faddey_uspensky/">Фаддей Успенский</a>
                </div>
            </li>
            <li style="position: relative;">
                <a class="dropdown-item dropdown-toggle" id="navbardrop_about_treasures" data-toggle="dropdown" href="javascript: return false;">Святыни прихода</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item<?=$about_treasures_spyridon_status ?>" href="<?=APPLICATION ?>/st_spyridon/">Икона св. Спиридона Тримифунтского</a>
                    <a class="dropdown-item<?=$about_treasures_alexander_nevsky_status ?>" href="<?=APPLICATION ?>/st_alexander_nevsky/">Икона св. Александра Невского</a>
                </div>
            </li>
            <li><a class="dropdown-item<?=$about_volunteer_status ?>" href="<?=APPLICATION ?>/volunteer/">Волонтёры</a></li>
            <li><a class="dropdown-item<?=$about_pilgrimage_status ?>" href="<?=APPLICATION ?>/pilgrimage/">Паломничество</a></li>
            <li><a class="dropdown-item<?=$about_schedule_status ?>" href="<?=APPLICATION ?>/schedule/">Расписание богослужений</a></li>
            <li><a class="dropdown-item<?=$about_clergy_status ?>" href="<?=APPLICATION ?>/clergy/">Духовенство</a></li>
            <li><a class="dropdown-item<?=$about_news_status ?>" href="<?=APPLICATION ?>/news/">Все новости</a></li>
            <li><a class="dropdown-item<?=$about_media_status ?>" href="<?=APPLICATION ?>/mediacenter/">Медиацентр</a></li>
        </ul>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop_cantus" data-toggle="dropdown">Церковное пение</a>
        <div class="dropdown-menu">
            <a class="dropdown-item<?=$cantus_status ?>" href="<?=APPLICATION ?>/cantus/">Каталог-классификатор песнопений и их плакатов</a>
            <a class="dropdown-item<?=$cantus_ustav_status ?>" href="<?=APPLICATION ?>/ustav/">Видеолекции Е. С. Кустовского</a>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link<?=$articles_status ?>" href="<?=APPLICATION ?>/articles/">Приходские заметки</a>
    </li>
    <li class="nav-item">
        <a class="nav-link<?=$theater_status ?>" href="<?=APPLICATION ?>/theater/">Театральная студия</a>
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