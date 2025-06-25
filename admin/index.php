<?php
include '../include/topscripts.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        include 'include/head.php';
        ?>
    </head>
    <body>
        <?php
        include 'include/header.php';
        ?>
        <ul class="breadcrumb">
            <li><a href="<?=APPLICATION ?>/">На главную</a></li>
            <li>Администратор</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <h1>Администратор</h1>
            <p><a href="page/">Страницы</a>
            <p><a href="schedule.php">Расписание богослужений</a></p>
            <p><a href="announcement">Объявления</a>
            <p><a href="news/">Новости</a></p>
            <p><a href="mediacenter/">Медиацентр</a></p>
            <p><a href="author">Авторы</a></p>
            <p><a href="article">Приходские заметки</a></p>
            <p><a href="theater/">Детская театральная студия &laquo;Раёк&raquo;</a></p>
            <p><a href="ustav/">Видеолекции Е. С. Кустовского</a></p>
            <p><a href="cantus/">Песнопения по алфавиту</a></p>
            <p><a href="sitemap/">sitemap.xml</a></p>
        </div>
        <?php
        include 'include/footer.php';
        ?>
    </body>
</html>