<?php
include '../include/topscripts.php';
include '../include/news/news.php';

$shortname = filter_input(INPUT_GET, 'shortname');

// Получение объекта
$sql = "select id, date, name, show_name from news where shortname='$shortname'";
$fetcher = new Fetcher($sql);
$error_message = $fetcher->error;

$id = '';
$date = '';
$name = '';
$show_name = '';

if(empty($error_message) && $row = $fetcher->Fetch()) {
    $id = $row['id'];
    $date = $row['date'];
    $name = $row['name'];
    $show_name = $row['show_name'];
}

$news = new News($id);
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
        ?>
        <div class="container">
            <div class="content bigfont">
                <?php
                if(!empty($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                
                if($show_name):
                ?>
                <p class="small"><i><?= DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y') ?></i></p>
                <h1><?=$name ?></h1>
                <?php
                endif;
            
                $news->GetFragments();
                ?>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>