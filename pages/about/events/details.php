<?php
include '../../../include/topscripts.php';
include '../../../include/news/news.php';

$shortname = filter_input(INPUT_GET, 'shortname');

// Получение объекта
$sql = "select id, date, title from news where shortname='$shortname'";
$fetcher = new Fetcher($sql);
$error_message = $fetcher->error;

$id = '';
$date = '';
$title = '';

if(empty($error_message) && $row = $fetcher->Fetch()) {
    $id = $row['id'];
    $date = $row['date'];
    $title = $row['title'];
}

if(empty($error_message)) {
    $sql = "select shortname, title from news where is_event = 1 and (date < '$date' or (date = '$date' and id < $id)) order by date desc, id desc limit 1";
    $fetcher = new Fetcher($sql);
    $error_message = $fetcher->error;
}

$previous_shortname = '';
$previous_title = '';

if(empty($error_message) && $row = $fetcher->Fetch()) {
    $previous_shortname = $row['shortname'];
    $previous_title = $row['title'];
}

if(empty($error_message)) {
    $sql = "select shortname, title from news where is_event = 1 and (date > '$date' or (date = '$date' and id > $id)) order by date asc, id asc limit 1";
    $fetcher = new Fetcher($sql);
    $error_message = $fetcher->error;
}

$next_shortname = '';
$next_title = '';

if(empty($error_message) && $row = $fetcher->Fetch()) {
    $next_shortname = $row['shortname'];
    $next_title = $row['title'];
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
                <div class="row">
                    <div class="col-4 text-left">
                        <?php if(!empty($next_shortname)): ?>
                        <div class="news_title"><a href="<?=APPLICATION ?>/events/<?=$next_shortname ?>" title="<?=$next_title ?>" data-toggle="tooltip" data-placement="right"><i class="fas fa-arrow-left"></i></a></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-4 text-center">
                        <div class="news_title">
                            <a href="<?=APPLICATION ?>/events/">Все события</a>
                        </div>
                    </div>
                    <div class="col-4 text-right">
                        <?php if(!empty($previous_shortname)): ?>
                        <div class="news_title"><a href="<?=APPLICATION ?>/events/<?=$previous_shortname ?>" title="<?=$previous_title ?>" data-toggle="tooltip" data-placement="left"><i class="fas fa-arrow-right"></i></a></div>
                        <?php endif; ?>
                    </div>
                </div>
                <hr />
                <p><i><?= DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y') ?></i></p>
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