<?php
include '../include/topscripts.php';

// Авторизация
if(!HasRole()) {
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
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <ul class="breadcrumb">
                <li><a href="<?=APPLICATION ?>/">На главную</a></li>
                <li>Администратор</li>
            </ul>
            <h1>Администратор</h1>
            <p><a href="page/">Страницы</a>
            <p><a href="schedule.php">Расписание богослужений</a></p>
            <p><a href="event/">Все события</a>
            <p><a href="news/">Все новости</a></p>
        </div>
        <?php
        include 'include/footer.php';
        ?>
    </body>
</html>