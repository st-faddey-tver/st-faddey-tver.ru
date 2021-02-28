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
                
                while (($row = $fetcher->Fetch())):
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
                ?>
                <div class="text-right"><a href="<?=APPLICATION ?>/events/" class="btn btn-sm btn-light">Все события&nbsp;<i class="fas fa-angle-double-right"></i></a></div>
            </div>
        </div>
        <?php
        include 'include/footer.php';
        ?>
    </body>
</html>