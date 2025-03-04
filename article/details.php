<?php
include '../include/topscripts.php';
include '../include/news/news.php';

$shortname = filter_input(INPUT_GET, 'shortname');
$news_type_id = NEWS_TYPE_ARTICLES;

// Получение объекта
$sql = "select n.id, n.date, a.holy_order, a.last_name, a.first_name, a.middle_name, n.name, n.title, n.description, n.keywords, n.image "
        . "from news n inner join author a on n.author_id = a.id "
        . "where n.news_type_id = $news_type_id and n.shortname = '$shortname'";
$fetcher = new Fetcher($sql);
$error_message = $fetcher->error;

$id = '';
$date = '';
$holy_order = '';
$last_name = '';
$first_name = '';
$middle_name = '';
$name = '';
$title = '';
$description = '';
$keywords = '';
$image = '';

if(empty($error_message) && $row = $fetcher->Fetch()) {
    $id = $row['id'];
    $date = $row['date'];
    $holy_order = $row['holy_order'];
    $last_name = $row['last_name'];
    $first_name = $row['first_name'];
    $middle_name = $row['middle_name'];
    $name = $row['name'];
    $title = $row['title'];
    $description = $row['description'];
    $keywords = $row['keywords'];
    $image = $row['image'];
}

$previous_shortname = '';
$previous_name = '';

if(empty($error_message)) {
    $sql = "select shortname, name from news where news_type_id = $news_type_id and (date < '$date' or (date = '$date' and id < $id)) and visible = 1 order by date desc, id desc limit 1";
    $fetcher = new Fetcher($sql);
    $error_message = $fetcher->error;
    
    if(empty($error_message) && $row = $fetcher->Fetch()) {
        $previous_shortname = $row['shortname'];
        $previous_name = $row['name'];
    }
}

$next_shortname = '';
$next_name = '';

if(empty($error_message)) {
    $sql = "select shortname, name from news where news_type_id = $news_type_id and (date > '$date' or (date = '$date' and id > $id)) and visible = 1 order by date asc, id asc limit 1";
    $fetcher = new Fetcher($sql);
    $error_message = $fetcher->error;
    
    if(empty($error_message) && $row = $fetcher->Fetch()) {
        $next_shortname = $row['shortname'];
        $next_name = $row['name'];
    }
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
                ?>
                <div class="row small">
                    <div class="col-4 text-left">
                        <?php if(!empty($next_shortname)): ?>
                        <div class="news_name"><a href="<?=APPLICATION ?>/articles/<?=$next_shortname ?>" title="<?=$next_name ?>" data-toggle="tooltip" data-placement="right"><i class="fas fa-arrow-left"></i></a></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-4 text-center">
                        <div class="news_name">
                            <a href="<?=APPLICATION ?>/articles/">К списку</a>
                        </div>
                    </div>
                    <div class="col-4 text-right">
                        <?php if(!empty($previous_shortname)): ?>
                        <div class="news_name"><a href="<?=APPLICATION ?>/articles/<?=$previous_shortname ?>" title="<?=$previous_name ?>" data-toggle="tooltip" data-placement="left"><i class="fas fa-arrow-right"></i></a></div>
                        <?php endif; ?>
                    </div>
                </div>
                <hr />
                <div class="d-flex justify-content-between">
                    <div class="small"><i><?= DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y') ?></i></div>
                    <div class="text-right font-italic"><?= GetAuthorsFullName($holy_order, $last_name, $first_name, $middle_name) ?></div>
                </div>
                <h1><?=$name ?></h1>
                <?php
                $news->GetFragments();
                ?>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>