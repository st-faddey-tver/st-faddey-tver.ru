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
                <h1>Все события</h1>
                <?php
                $sql = "select count(id) pages_total_count from news where is_event=1";
                $fetcher = new Fetcher($sql);
                $error_message = $fetcher->error;
                
                if($row = $fetcher->Fetch()) {
                    $pager_total_count = $row[0];
                }
                
                $sql = "select date, title, shortname, body, show_title from news where is_event=1 order by date desc, id desc limit $pager_skip, $pager_take";
                $fetcher = new Fetcher($sql);
                
                while ($row = $fetcher->Fetch()):
                $date = $row['date'];
                $title = $row['title'];
                $shortname = $row['shortname'];
                $body = $row['body'];
                $show_title = $row['show_title'];
                
                if($show_title):
                ?>
                <div class="news_date"><?= DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y') ?></div>
                <div class="news_title"><a href="<?=APPLICATION."/events/".$shortname ?>"><?=$title ?></a></div>
                <?php
                endif;
                
                echo "<div class='events_body'>$body</div>";
                endwhile;
                include '../../../include/pager_bottom.php';
                ?>
            </div>
        </div>
        <?php
        include '../../../include/footer.php';
        ?>
    </body>
</html>