<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array('editor', 'admin'))) {
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
                <li>Личные данные</li>
            </ul>
            <h1>Личные данные</h1>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>