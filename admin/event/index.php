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
        include '../../include/pager_top.php';
        ?>
        <ul class="breadcrumb">
            <li><a href="<?=APPLICATION ?>/">На главную</a></li>
            <li><a href="<?=APPLICATION ?>/admin/">Администратор</a></li>
            <li>События</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>События</h1>
                </div>
                <div class="p-1">
                    <a href="create.php" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Создать событие</a>
                </div>
            </div>
            <div class="container" style="margin-left: 0;">
                <div class="content">
                    <?php
                    $sql = "select count(id) events_count from event";
                    $fetcher = new Fetcher($sql);
                    $error_message = $fetcher->error;
                    
                    if($row = $fetcher->Fetch()) {
                        $pager_total_count = $row[0];
                    }
                    
                    $sql = "select id, date, body, front, visible from event order by date desc, id desc limit $pager_skip, $pager_take";
                    $fetcher = new Fetcher($sql);
                    $error_message = $fetcher->error;
                    
                    while ($row = $fetcher->Fetch()):
                    $id = $row['id'];
                    $date = $row['date'];
                    $body = $row['body'];
                    $front = $row['front'];
                    $visible = $row['visible'];
                    ?>
                    <hr style="clear: both;" />
                    <h2><a href="details.php<?= BuildQuery("id", $id) ?>"><?=$date ?> <?=($front ? "front" : "") ?> <?=($visible ? "visible" : "") ?></a></h2>
                    <?=$body ?>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>