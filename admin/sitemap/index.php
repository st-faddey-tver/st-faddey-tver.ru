<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array('admin'))) {
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
                <li>sitemap.xml</li>
            </ul>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>sitemap.xml</h1>
                </div>
                <div class="p-1">
                    <a href="create.php" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Создать узел</a>
                </div>
            </div>
            <?php
            include '../include/footer.php';
            ?>
        </div>
    </body>
</html>