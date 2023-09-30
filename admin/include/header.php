<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <ul class="navbar-nav">
        <?php
        $admin_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/admin/index.php' ? ' disabled' : '';
            
        $files_images_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/admin/files/images.php' ? ' disabled' : '';
        $files_audio_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/admin/files/audio.php' ? ' disabled' : '';
        $files_video_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/admin/files/video.php' ? ' disabled' : '';
        $files_documents_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/admin/files/documents.php' ? ' disabled' : '';
            
        $user_status = (substr_compare(filter_input(INPUT_SERVER, 'PHP_SELF'), APPLICATION.'/admin/user', 0, strlen(APPLICATION.'/admin/user')) == 0 ? ' disabled' : '');
        $personal_status = (substr_compare(filter_input(INPUT_SERVER, 'PHP_SELF'), APPLICATION.'/admin/personal', 0, strlen(APPLICATION.'/admin/personal')) == 0 ? ' disabled' : '');
        ?>
        <li class="nav-item">
            <a class="nav-link" href="<?=APPLICATION ?>/">На главную</a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?=$admin_status ?>" href="<?=APPLICATION ?>/admin/">Администратор</a>
        </li>
        <?php
        if(IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))):
        ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop_files" data-toggle="dropdown">Файлы</a>
            <div class="dropdown-menu">
                <a class="dropdown-item<?=$files_images_status ?>" href="<?=APPLICATION ?>/admin/files/image/">Изображения</a>
                <a class="dropdown-item<?=$files_audio_status ?>" href="<?=APPLICATION ?>/admin/files/audio/">Аудио</a>
                <a class="dropdown-item<?=$files_audio_status ?>" href="<?=APPLICATION ?>/admin/files/video/">Видео</a>
                <a class="dropdown-item<?=$files_documents_status ?>" href="<?=APPLICATION ?>/admin/files/document/">Документы</a>
            </div>
        </li>
        <li class="nav_item">
            <a class="nav-link<?=$user_status ?>" href="<?=APPLICATION ?>/admin/user/">Пользователи</a>
        </li>
        <?php
        endif;
        ?>
        <li class="nav-item">
            <a class="nav-link<?=$personal_status ?>" href="<?=APPLICATION ?>/admin/personal/">Личные данные</a>
        </li>
    </ul>
    <form class="form-inline ml-auto" method="post">
        <label class="text-light"><?= filter_input(INPUT_COOKIE, LAST_NAME).' '. filter_input(INPUT_COOKIE, FIRST_NAME).' '. filter_input(INPUT_COOKIE, MIDDLE_NAME) ?></label>
        &nbsp;&nbsp;
        <button type="submit" class="btn btn-outline-light" id="logout_submit" name="logout_submit">Выход&nbsp;<i class="fas fa-sign-out-alt"></i></button>
    </form>
</nav>