<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array('history', 'admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        include '../include/head.php';
        ?>
    </head>
    <body>
        <?php
        include '../include/header.php';
        ?>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <ul class="breadcrumb">
                <li><a href="<?=APPLICATION ?>/">На главную</a></li>
                <li><a href="<?=APPLICATION ?>/admin/">Администратор</a></li>
                <li>История</li>
            </ul>
            <h1>О храме</h1>
            <h2>История</h2>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>