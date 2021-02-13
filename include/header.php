<div class="container">
    <div class="header d-none d-md-block">
        <a href="<?=APPLICATION ?>/"><img src="<?=APPLICATION ?>/images/header_two_icons.jpg" class="img-fluid" /></a>
    </div>
    <nav class="navbar navbar-expand-sm neopalimy-navbar">
        <ul class="navbar-nav">
            <?php
            $home_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/index.php' ? ' disabled' : '';
            $about_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/about/index.php' ? ' disabled' : '';
            $contact_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/contact/index.php' ? ' disabled' : '';
            ?>
            <li class="nav-item">
                <a class="nav-link<?=$home_status ?>" href="<?=APPLICATION ?>/"><i class="fas fa-home"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?=$about_status ?>" href="<?=APPLICATION ?>/about/">О святом Фаддее</a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?=$contact_status ?>" href="<?=APPLICATION ?>/contact/">Контакты</a>
            </li>
        </ul>
    </nav>
</div>