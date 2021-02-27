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
            <div class="row">
                <div class="col-6">
                    <p>О храме</p>
                    <ul>
                        <li><a href="pages/about/history.php">История</a></li>
                        <li><a href="pages/about/saints.php">Святые храма</a></li>
                        <li><a href="pages/about/schedule.php">Расписание богослужений</a></li>
                        <li><a href="pages/about/clergy.php">Духовенство</a></li>
                        <li><a href="pages/about/events/">Все события</a></li>
                    </ul>
                    <p>Молодёжь храма</p>
                    <ul>
                        <li><a href="pages/youth/volunteer.php">Добровольческое движение</a></li>
                        <li><a href="pages/youth/club.php">Молодёжный клуб &laquo;Встреча&raquo;</a></li>
                        <li><a href="pages/youth/family.php">Семейный клуб</a></li>
                        <li><a href="pages/youth/cinema.php">Синематографический клуб</a></li>
                    </ul>
                    <p><a href="pages/contact.php">Контакты</a></p>
                </div>
            </div>
        </div>
        <?php
        include 'include/footer.php';
        ?>
    </body>
</html>