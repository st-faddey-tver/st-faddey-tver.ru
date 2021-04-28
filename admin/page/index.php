<?php
include '../../include/topscripts.php';

// Авторизация
if(!HasRole()) {
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
        include '../../include/pager_top.php';
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
                <li>Страницы</li>
            </ul>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Страницы</h1>
                </div>
                <div class="p-1">
                    <a href="create.php" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Создать страницу</a>
                </div>
            </div>
            <?php
            $sql = "select count(id) from page";
            $fetcher = new Fetcher($sql);
            if($row = $fetcher->Fetch()) {
                $pager_total_count = $row[0];
            }
            
            $sql = "select name, shortname, inmenu from page order by inmenu desc, name asc limit $pager_skip, $pager_take";
            $fetcher = new Fetcher($sql);
            
            while ($row = $fetcher->Fetch()):
            $bg_class = $row['inmenu'] == 1 ? "bg-warning" : "bg-white";
            ?>
            <p><a class="<?=$bg_class ?>" href="details.php<?= BuildQuery("shortname", $row['shortname']) ?>"><?=$row['name'] ?></a></p>
            <?php
            endwhile;
            include '../../include/pager_bottom.php';
            ?>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>