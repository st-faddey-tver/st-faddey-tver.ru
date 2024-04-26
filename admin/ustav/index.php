<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        include '../include/head.php';
        ?>
        <style>
            .news_name {
                font-size: 1.4rem;
            }
        </style>
    </head>
    <body>
        <?php
        include '../include/header.php';
        ?>
        <ul class="breadcrumb">
            <li><a href="<?=APPLICATION ?>/">На главную</a></li>
            <li><a href="<?=APPLICATION ?>/admin/">Администратор</a></li>
            <li>Видеолекции Е. С. Кустовского</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Видеолекции Е. С. Кустовского</h1>
                </div>
                <div class="p-1">
                    <a href="create.php" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Создать лекцию</a>
                </div>
            </div>
            <div class="container" style="margin-left: 0;">
                <div class="content">
                    <?php
                    $news_type_id = NEWS_TYPE_USTAV;    
                    $sql = "select id, date, name, shortname, body, front, visible from news where news_type_id = $news_type_id order by date desc, id desc";
                    $fetcher = new Fetcher($sql);
                    $error_message = $fetcher->error;
                        
                    while ($row = $fetcher->Fetch()):
                    $id = $row['id'];
                    $date = $row['date'];
                    $name = $row['name'];
                    $shortname = $row['shortname'];
                    $body = $row['body'];
                    $front = $row['front'];
                    $visible = $row['visible'];
                    ?>
                    <p class="news_name"><a href='details.php<?= BuildQuery('id', $id) ?>'><?=$name ?></a></p>
                    <?php
                    endwhile;
                    ?>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>