<?php
include '../../../include/topscripts.php';
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
        include '../../../include/pager_top.php';
        ?>
        <div class="container">
            <div class="content">
                <?php
                if(!empty($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                ?>
                <h1>Все новости</h1>
                <div class="row">
                    <?php
                    $sql = "select count(id) pages_total_count from news where is_event=0";
                    $fetcher = new Fetcher($sql);
                    $error_message = $fetcher->error;
                    
                    if($row = $fetcher->Fetch()) {
                        $pager_total_count = $row[0];
                    }
                    
                    $sql = "select date, title, shortname, body from news where is_event=0 order by date desc, id desc limit $pager_skip, $pager_take";
                    $fetcher = new Fetcher($sql);
                    
                    while ($row = $fetcher->Fetch()):
                    $date = $row['date'];
                    $title = $row['title'];
                    $shortname = $row['shortname'];
                    $body = $row['body'];
                    ?>
                    <div class="col-6">
                        <div class="news_date"><?= DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y') ?></div>
                        <div class="news_title"><a href="<?=APPLICATION."/news/".$shortname ?>"><?=$title ?></a></div>
                        <div class="news_body"><?=$body ?></div>
                    </div>
                    <?php
                    endwhile;
                    ?>
                </div>
                <?php
                include '../../../include/pager_bottom.php';
                ?>
            </div>
        </div>
        <?php
        include '../../../include/footer.php';
        ?>
    </body>
</html>