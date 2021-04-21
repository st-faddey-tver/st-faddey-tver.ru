<?php
include '../include/topscripts.php';
$title = "Храм священномученика Фаддея архиепископа Тверского, события";
$description = "События храма священномученика Фаддея архиепископа Тверского";
$keywords = "События храма святого Фаддея";
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
        include '../include/pager_top.php';
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
                $sql = "select count(id) pages_total_count from event";
                $fetcher = new Fetcher($sql);
                $error_message = $fetcher->error;
                
                if($row = $fetcher->Fetch()) {
                    $pager_total_count = $row[0];
                }
                
                $sql = "select date, body from event where visible=1 order by date desc, id desc limit $pager_skip, $pager_take";
                $fetcher = new Fetcher($sql);
                
                while ($row = $fetcher->Fetch()):
                $date = $row['date'];
                $body = $row['body'];
                
                echo "<div class='events_body'>$body</div>";
                endwhile;
                include "../include/pager_bottom.php";
                ?>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>