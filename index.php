<?php
include 'include/topscripts.php';
?>
<!doctype html>
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
                
                $sql = "select date, title, shortname, body, show_title from news where is_event=1 and front=1 order by date desc, id desc";
                $fetcher = new Fetcher($sql);
                $events_count = 0;
                
                while ($row = $fetcher->Fetch()):
                $date = $row['date'];
                $title = $row['title'];
                $shortname = $row['shortname'];
                $body = $row['body'];
                $show_title = $row['show_title'];
                $events_count++;
                
                if($show_title):
                ?>
                <div class="news_date"><?= DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y') ?></div>
                <div class="news_title"><a href="<?=APPLICATION."/events/".$shortname ?>"><?=$title ?></a></div>
                <?php
                endif;
                echo "<div class='events_body'>$body</div>";
                endwhile;
                
                if($events_count > 0) {
                    echo "<div class='text-right mb-4' style='clear: both;'><a href='".APPLICATION."/events/' class='btn btn-sm btn-light'>Все события&nbsp;<i class='fas fa-angle-double-right'></i></a></div>";
                }
                ?>              
                <div class="row">
                <?php
                $sql = "select date, title, shortname, body, show_title from news where is_event=0 and front=1 order by date desc, id desc";
                $fetcher = new Fetcher($sql);
                $news_count = 0;
                
                while ($row = $fetcher->Fetch()):
                $date = $row['date'];
                $title = $row['title'];
                $shortname = $row['shortname'];
                $body = $row['body'];
                $show_title = $row['show_title'];
                $news_count++;
                ?>
                    <div class="col-6">
                        <?php if($show_title): ?>
                        <div class="news_date"><?= DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y') ?></div>
                        <div class="news_title"><a href="<?=APPLICATION."/news/".$shortname ?>"><?=$title ?></a></div>
                        <?php endif; ?>
                        <div class="news_body"><?=$body ?></div>
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