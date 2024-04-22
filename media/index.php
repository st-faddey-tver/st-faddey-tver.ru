<?php
include '../include/topscripts.php';
$title = "Храм священномученика Фаддея архиепископа Тверского, медиацентр";
$description = "Медиацентр храма священномученика Фаддея архиепископа Тверского";
$keywords = "Медиацентр храма святого Фаддея";
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        include '../include/head.php';
        ?>
        <style>
            .news_name {
                font-size: 1.4rem;
            }
        </style>
    </head>
    <body>
        <?php
        include '../include/header.php';
        include '../include/pager_top.php';
        ?>
        <div class="container">
            <div class="content">
                <?php
                if(!empty($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                ?>
                <h1>Медиацентр</h1>
                <div class="row">
                    <?php
                    $news_type_id = NEWS_TYPE_MEDIACENTER;
                    $sql = "select count(id) pages_total_count from news where news_type_id = $news_type_id and visible = 1";
                    $fetcher = new Fetcher($sql);
                    $error_message = $fetcher->error;
                    
                    if($row = $fetcher->Fetch()) {
                        $pager_total_count = $row[0];
                    }
                    
                    $sql = "select date, name, shortname, body from news where news_type_id = $news_type_id and visible = 1 order by date desc, id desc limit $pager_skip, $pager_take";
                    $fetcher = new Fetcher($sql);
                    
                    while ($row = $fetcher->Fetch()):
                    $date = $row['date'];
                    $name = $row['name'];
                    $shortname = $row['shortname'];
                    $body = $row['body'];
                    ?>
                    <div class="col-12 col-md-6">
                        <div class="news_date"><?= DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y') ?></div>
                        <div class="news_body"><a href="<?=APPLICATION."/mediacenter/".$shortname ?>"><?=$body ?></a></div>
                        <div class="news_name mb-4"><a href="<?=APPLICATION."/mediacenter/".$shortname ?>"><?=$name ?></a></div>
                    </div>
                    <?php
                    endwhile;
                    ?>
                </div>
                <?php
                include '../include/pager_bottom.php';
                ?>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>

