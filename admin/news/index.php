<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array('admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если нет параметра is_event, переход на главную страницу администратора
$is_event = filter_input(INPUT_GET, 'is_event');
if($is_event === null) {
    header('Location: '.APPLICATION."/admin/");
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
                <li><?=$is_event ? "Все события" : "Все новости" ?></li>
            </ul>
            <div class="container" style="margin-left: 0;">
                <div class="content">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="p-1">
                            <h1><?=$is_event ? "Все события" : "Все новости" ?></h1>
                        </div>
                        <div class="p-1">
                            <a href="create.php<?= BuildQuery('is_event', $is_event) ?>" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;<?=$is_event ? "Создать событие" : "Создать новость" ?></a>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        $sql = "select count(id) pages_total_count from news where is_event=$is_event";
                        $fetcher = new Fetcher($sql);
                        $error_message = $fetcher->error;
                        
                        if($row = $fetcher->Fetch()) {
                            $pager_total_count = $row[0];
                        }
                        
                        $sql = "select id, date, name, shortname, body, front, visible from news n where n.is_event=$is_event order by n.date desc, n.id desc limit $pager_skip, $pager_take";
                        $fetcher = new Fetcher($sql);
                        $error_message = $fetcher->error;
                        
                        while ($row = $fetcher->Fetch()):
                        $id = $row['id'];
                        $date = $row['date'];
                        $name = $row['name'];
                        $shortname = $row['shortname'];
                        $body = $row['body'];
                        $front = $row['front'];
                        $visible = $row['visible'];
                        ?>
                        <div class="<?=$is_event ? 'col-12' : 'col-6' ?>">
                            <div class="<?=$is_event ? 'text-info' : 'news_date' ?>"><?= DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y') ?>&nbsp;<?=$shortname ?>&nbsp;<?=($front ? 'front' : '') ?>&nbsp;<?=$visible ? 'visible' : '' ?></div>
                            <div class="news_name"><a href='details.php<?= BuildQuery('id', $id) ?>'><?=$name ?></a></div>
                            <div class="<?=$is_event ? 'events_body' : 'news_body' ?>"><?=$body ?></div>
                        </div>
                        <?php
                        endwhile;
                        ?>
                    </div>
                    <hr />
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