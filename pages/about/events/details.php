<?php
include '../../../include/topscripts.php';
include '../../../include/news/news.php';

$shortname = filter_input(INPUT_GET, 'shortname');

// Получение объекта
$sql = "select id, date, title, show_title from news where shortname='$shortname'";
$fetcher = new Fetcher($sql);
$error_message = $fetcher->error;

$id = '';
$date = '';
$title = '';
$show_title = '';

if(empty($error_message) && $row = $fetcher->Fetch()) {
    $id = $row['id'];
    $date = $row['date'];
    $title = $row['title'];
    $show_title = $row['show_title'];
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
                
                if($show_title):
                ?>
                <p><i><?= DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y') ?></i></p>
                <h1><?=$title ?></h1>
                <?php
                endif;
            
                $news->GetFragments();
                ?>
            </div>
        </div>
        <?php
        include '../../../include/footer.php';
        ?>
    </body>
</html>