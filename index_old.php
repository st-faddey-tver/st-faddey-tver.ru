<?php
include 'include/topscripts.php';
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
        <div class="container">
            <div class="content">
                <?php
                if(!empty($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                
                $event_type_announcement = EVENT_TYPE_ANNOUNCEMENT;
                $sql = "select date, body from event where event_type_id = $event_type_announcement and visible = 1 order by date desc, id desc";
                $fetcher = new Fetcher($sql);
                $events_count = 0;
                
                while ($row = $fetcher->Fetch()):
                $date = $row['date'];
                $body = $row['body'];
                $events_count++;
                echo "<div class='events_body'>$body</div>";
                endwhile;
                
                if($events_count > 0) {
                    echo "<br />";
                }
                ?>
                <div class="row">
                <?php
                $news_type_id = NEWS_TYPE_NEWS;
                $sql = "select date, name, shortname, body from news where news_type_id = $news_type_id and front = 1 and visible = 1 order by date desc, id desc";
                $fetcher = new Fetcher($sql);
                $news_count = 0;
                
                while ($row = $fetcher->Fetch()):
                $date = $row['date'];
                $name = $row['name'];
                $shortname = $row['shortname'];
                $body = $row['body'];
                $news_count++;
                ?>
                    <div class="col-12 col-md-6">
                        <div class="news_date"><?= DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y') ?></div>
                        <div class="news_name"><a href="<?=APPLICATION."/news/".$shortname ?>"><?=$name ?></a></div>
                        <div class="news_body"><a href="<?=APPLICATION."/news/".$shortname ?>"><?=$body ?></a></div>
                    </div>
                <?php
                endwhile;
                ?>
                </div>
                <?php
                if($news_count > 0) {
                    echo "<div class='text-right mb-4' style='clear: both;'><a href='".APPLICATION."/news/' class='btn btn-sm btn-light'>Все новости&nbsp;<i class='fas fa-angle-double-right'></i></a></div>";
                }
                ?>
            </div>
        </div>
        <?php
        include 'include/footer.php';
        ?>
    </body>
</html>