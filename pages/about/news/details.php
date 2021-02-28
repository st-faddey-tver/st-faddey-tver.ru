<?php
include '../../../include/topscripts.php';
include '../../../include/news/news.php';

$is_event = filter_input(INPUT_GET, 'is_event');
$shortname = filter_input(INPUT_GET, 'shortname');

// Получение объекта
$sql = "select id, date, title from news where shortname='$shortname'";
$fetcher = new Fetcher($sql);
$error_message = $fetcher->error;

$id = '';
$date = '';
$title = '';

if($row = $fetcher->Fetch()) {
    $id = $row['id'];
    $date = $row['date'];
    $title = $row['title'];
}

$news = new News($id);
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
        ?>
        <div class="container">
            <div class="content">
                <?php
                if(!empty($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                ?>
                <h1><?=$title ?></h1>
                <?php
                $news->GetFragments();
                ?>
            </div>
        </div>
        <?php
        include '../../../include/footer.php';
        ?>
    </body>
</html>