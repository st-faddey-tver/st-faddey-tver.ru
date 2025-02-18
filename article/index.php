<?php
include '../include/topscripts.php';
$title = "Храм священномученика Фаддея архиепископа Тверского, приходские заметки";
$description = "Приходские заметки храма священномученика Фаддея архиепископа Тверского";
$keywords = "Приходские заметки храма святого Фаддея";
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
            <div class="content bigfont">
                <?php
                if(!empty($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                ?>
                <h1>Приходские заметки</h1>
                <?php
                $news_type_id = NEWS_TYPE_ARTICLES;
                $sql = "select count(id) pages_total_count from news where news_type_id = $news_type_id and visible = 1";
                $fetcher = new Fetcher($sql);
                $error_message = $fetcher->error;
                
                if($row = $fetcher->Fetch()) {
                    $pager_total_count = $row[0];
                }
                
                $sql = "select n.date, a.holy_order, a.last_name, a.first_name, a.middle_name, n.name, n.shortname "
                        . "from news n inner join author a on n.author_id = a.id "
                        . "where news_type_id = $news_type_id and visible = 1 "
                        . "order by n.date desc, n.id desc limit $pager_skip, $pager_take";
                $fetcher = new Fetcher($sql);
                
                while($row = $fetcher->Fetch()):
                $date = $row['date'];
                $holy_order = $row['holy_order'];
                $last_name = $row['last_name'];
                $first_name = $row['first_name'];
                $middle_name = $row['middle_name'];
                $name = $row['name'];
                $shortname = $row['shortname'];
                ?>
                <div class="font-italic"><?= GetAuthorsFullName($row['holy_order'], $row['last_name'], $row['first_name'], $row['middle_name']) ?></div>
                <div class="font-weight-bold" style="font-size: larger;"><a href="<?=APPLICATION."/articles/".$shortname ?>"><?=$row['name'] ?></a></div>
                <div class="mb-4" style="font-size: smaller;"><?= DateTime::createFromFormat('Y-m-d', $row['date'])->format('d.m.Y') ?></div>
                <?php
                endwhile;
                
                include '../include/pager_bottom.php';
                ?>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>