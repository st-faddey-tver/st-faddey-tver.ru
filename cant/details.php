<?php
include '../include/topscripts.php';
include '../include/cantus.php';
$cantus = new Cantus(filter_input(INPUT_GET, 'shortname'));
$title = $cantus->title;
$description = $cantus->description;
$keywords = $cantus->keywords;
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
                <div class="d-flex justify-content-center small">
                    <div class="news_name">
                        <a href="<?=APPLICATION."/cantus/" ?>">Песнопения по алфавиту</a>
                    </div>
                </div>
                <hr />
                <h1><?=$cantus->name ?></h1>
                <?php $cantus->GetFragments(); ?>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>