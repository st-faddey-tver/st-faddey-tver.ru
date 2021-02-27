<?php
include '../../../../include/topscripts.php';

// Авторизация
if(!IsInRole(array('about', 'admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        include '../../../include/head.php';
        ?>
    </head>
    <body>
        <?php
        include '../../../include/header.php';
        include '../../../../include/pager_top.php';
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
                <li>Все события</li>
            </ul>
            <div class="container" style="margin-left: 0;">
                <div class="content">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="p-1">
                            <h1>Все события</h1>
                        </div>
                        <div class="p-1">
                            <a href="create.php" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Создать событие</a>
                        </div>
                    </div>
                    <?php
                    $sql = "select count(id) pages_total_count from news where is_event=1";
                    $fetcher = new Fetcher($sql);
                    $error_message = $fetcher->error;
                    
                    if($row = $fetcher->Fetch()) {
                        $pager_total_count = $row[0];
                    }
                    
                    $sql = "select id, date, title, shortname, body from news n where n.is_event=1 order by n.date desc, n.id desc limit $pager_skip, $pager_take";
                    $fetcher = new Fetcher($sql);
                    $error_message = $fetcher->error;
                    
                    while ($row = $fetcher->Fetch()):
                    $id = $row['id'];
                    $date = $row['date'];
                    $title = $row['title'];
                    $shortname = $row['shortname'];
                    $body = $row['body'];
                    ?>
                    <p><?= DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y') ?></p>
                    <h2><a href='details.php<?= BuildQuery('id', $id) ?>'><?=$title ?></a></h2>
                    <h3><?=$shortname ?></h3>
                    <?=$body ?>
                    <hr />
                    <?php
                    endwhile;
                    
                    include '../../../../include/pager_bottom.php';
                    ?>
                </div>
            </div>
        </div>
        <?php
        include '../../../include/footer.php';
        ?>
    </body>
</html>