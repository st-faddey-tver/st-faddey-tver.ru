<?php
include '../include/topscripts.php';
?>
<!doctype html>
<html>
    <head>
        <?php
        include '../include/head.php';
        ?>
    </head>
    <body>
         <div class="container">
    <div class="header d-none d-md-block">
        <a href="<?=APPLICATION ?>/"><img src="<?=APPLICATION ?>/images/header_with_text.jpg" class="img-fluid" /></a>
        <div class="ikona_top">
            <img src="<?=APPLICATION ?>/images/ikona.jpg" class="img-fluid" />
        </div>
    </div>
    <nav class="navbar navbar-expand-sm neopalimy-navbar">
        <ul class="navbar-nav">
            <?php
            $home_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/index.php' ? ' disabled' : '';
            $about_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/about/index.php' ? ' disabled' : '';
            $contact_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/contact/index.php' ? ' disabled' : '';
            $old_status = filter_input(INPUT_SERVER, 'PHP_SELF') == APPLICATION.'/old/index.php' ? ' disabled' : '';
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
            <li class="nav-item">
                <a class="nav-link<?=$old_status ?>" href="<?=APPLICATION ?>/old">Старая версия</a>
            </li>
        </ul>
    </nav>
</div>       
        <div class="container">
            <div class="content">
                <?php
                if(!empty($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                ?>
                <h1>Старая версия</h1>
                <p>Раздел в разработке.</p>
                <br/><br/><br/><br/><br/><br/><br/>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>