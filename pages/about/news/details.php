<?php
include '../../../include/topscripts.php';
include '../../../include/news/news.php';

$is_event = filter_input(INPUT_GET, 'is_event');
$shortname = filter_input(INPUT_GET, 'shortname');

// Получение объекта
$sql = "select n.id, n.date, n.title, "
        . "(select shortname from news where is_event=$is_event and date(date) < date(n.date) or (date(date) = date(n.date) and id < n.id) order by date asc, id asc limit 1) previous_shortname, "
        . "(select shortname from news where is_event=$is_event and date(date) > date(n.date) or (date(date) = date(n.date) and id > n.id) order by date desc, id desc limit 1) next_shortname "
        . "from news n "
        . "where n.shortname='$shortname'";
$fetcher = new Fetcher($sql);
$error_message = $fetcher->error;

$id = '';
$date = '';
$title = '';
$previous_shortname = '';
$next_shortname = '';

if($row = $fetcher->Fetch()) {
    $id = $row['id'];
    $date = $row['date'];
    $title = $row['title'];
    $previous_shortname = $row['previous_shortname'];
    $next_shortname = $row['next_shortname'];
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
                        <?php if(!empty($previous_shortname)): ?>
                        <a href="<?=APPLICATION ?>/<?=$is_event ? 'events' : 'news' ?>/<?=$previous_shortname ?>" class="btn btn-outline-dark"><i class="fas fa-arrow-left"></i></a>
                        <?php endif; ?>
                    </div>
                    <div class="col-4 text-center">
                        <?php if($is_event): ?>
                        <a href="<?=APPLICATION ?>/events/" class="btn btn-outline-dark">Все события</a>
                        <?php else: ?>
                        <a href="<?=APPLICATION ?>/news/" class="btn btn-outline-dark">Все новости</a>
                        <?php endif; ?>
                    </div>
                    <div class="col-4 text-right">
                        <?php if(!empty($next_shortname)): ?>
                        <a href="<?=APPLICATION ?>/<?=$is_event ? 'events' : 'news' ?>/<?=$next_shortname ?>" class="btn btn-outline-dark"><i class="fas fa-arrow-right"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
                <hr />
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