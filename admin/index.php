<?php
include '../include/topscripts.php';

// Авторизация
if(!IsInRole(array('editor', 'admin'))) {
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
                        <li><a href="about/history.php">История</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php
        include 'include/footer.php';
        ?>
    </body>
</html>