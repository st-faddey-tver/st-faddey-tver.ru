<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
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
            <li>Детская театральная студия &laquo;Раёк&raquo;</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Детская театральная студия &laquo;Раёк&raquo;</h1>
                </div>
                <div class="p-1">
                    <a href="create.php" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Создать запись</a>
                </div>
            </div>
            <div class="container" style="margin-left: 0;">
                <div class="content bigfont">
                    <?php
                    $event_type_theater = EVENT_TYPE_THEATER;
                    $sql = "select count(id) events_count from event where event_type_id = $event_type_theater";
                    $fetcher = new Fetcher($sql);
                    $error_message = $fetcher->error;
                    
                    if($row = $fetcher->Fetch()) {
                        $pager_total_count = $row[0];
                    }
                    
                    $sql = "select id, date, body, front, visible from event where event_type_id = $event_type_theater order by date desc, id desc limit $pager_skip, $pager_take";
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
                    <hr />
                    <div style='font-size: smaller; font-style: italic;'><?= DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y') ?></div>
                    <?=$body ?>
                    <?php endwhile; ?>
                    <?php
                    include '../../include/pager_bottom.php';
                    ?>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>