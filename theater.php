<?php
include 'include/topscripts.php';
$title = "Детская театральная студия &laquo;Раёк&raquo;";
$description = "Детская театральная студия \"Раёк\"";
$keywords = "театральная студия, детская театральная студия, студия Раёк";
$image = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].APPLICATION."/images/rayok.jpg";
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
        include 'include/pager_top.php';
        ?>
        <div class="container">
            <div class="content bigfont">
                <?php
                if(!empty($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                ?>
                <h1>Детская театральная студия &laquo;Раёк&raquo;</h1>
                <?php
                $event_type_theater = EVENT_TYPE_THEATER;
                $sql = "select count(id) from event where event_type_id = $event_type_theater and visible = 1";
                $fetcher = new Fetcher($sql);
                $error_message = $fetcher->error;
                
                if($row = $fetcher->Fetch()) {
                    $pager_total_count = $row[0];
                }
                
                $sql = "select date, body from event where event_type_id = $event_type_theater and visible = 1 order by date desc, id desc limit $pager_skip, $pager_take";
                $fetcher = new Fetcher($sql);
                
                while ($row = $fetcher->Fetch()) {
                    $date = $row['date'];
                    $body = $row['body'];
                    echo "<hr />";
                    echo "<div style='font-size: smaller; font-style: italic;'>".DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y')."</div>";
                    echo $body;
                }
                ?>
                <br style="clear: both;" />
                <?php
                include 'include/pager_bottom.php';
                ?>
            </div>
        </div>
        <?php
        include 'include/footer.php';
        ?>
    </body>
</html>