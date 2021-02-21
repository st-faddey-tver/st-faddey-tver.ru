<?php
include '../include/topscripts.php';

// Авторизация
if(!IsInRole(array('admin', 'editor'))) {
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
                        <li><a href="history/">История</a></li>
                    </ul>
                </div>
                <div class="col-6">
                    <?php
                    if(IsInRole(array('admin'))):
                    ?>
                    <p><a href="<?=APPLICATION ?>/admin/user/">Пользователи</a></p>
                    <?php
                    endif;
                    ?>
                </div>
            </div>
        </div>
        <?php
        include 'include/footer.php';
        ?>
    </body>
</html>