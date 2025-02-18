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
    </head>
    <body>
        <?php
        include '../include/header.php';
        include '../../include/pager_top.php';
        ?>
        <ul class="breadcrumb">
            <li><a href="<?=APPLICATION ?>/">На главную</a></li>
            <li><a href="<?=APPLICATION ?>/admin/">Администратор</a></li>
            <li>Приходские заметки</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Приходские заметки</h1>
                </div>
                <div class="p-1">
                    <a href="create.php" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Создать статью</a>
                </div>
            </div>
            <div class="container" style="margin-left: 0;">
                <div class="content bigfont">
                    <?php
                    $news_type_id = NEWS_TYPE_ARTICLES;
                    
                    $sql = "select count(id) pages_total_count from news where news_type_id = $news_type_id";
                    $fetcher = new Fetcher($sql);
                    $error_message = $fetcher->error;
                    
                    if($row = $fetcher->Fetch()) {
                        $pager_total_count = $row[0];
                    }
                    
                    $sql = "select n.id, n.date, a.holy_order, a.last_name, a.first_name, a.middle_name, n.name, n.visible "
                            . "from news n inner join author a on n.author_id = a.id "
                            . "where n.news_type_id = $news_type_id "
                            . "order by n.id desc";
                    $fetcher = new Fetcher($sql);
                    $error_message = $fetcher->error;
                    
                    while($row = $fetcher->Fetch()):
                    ?>
                    <div class="font-italic"><?= GetAuthorsFullName($row['holy_order'], $row['last_name'], $row['first_name'], $row['middle_name']) ?></div>
                    <div class="font-weight-bold" style="font-size: larger;"><a href="details.php<?= BuildQuery('id', $row['id']) ?>"><?=$row['name'] ?></a><?=$row['visible'] ? '' : " <span class='text-danger'>INVISIBLE</span>" ?></div>
                    <div class="mb-4" style="font-size: smaller;"><?= DateTime::createFromFormat('Y-m-d', $row['date'])->format('d.m.Y') ?></div>
                    <?php
                    endwhile;
                    ?>
                    <?php
                    include '../../include/pager_bottom.php';
                    ?>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>