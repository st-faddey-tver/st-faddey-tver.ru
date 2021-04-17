<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array('about', 'admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если нет параметра id, переход к списку
$id = filter_input(INPUT_GET, 'id');
if(empty($id)) {
    header('Location: '.APPLICATION."/admin/event/");
}

// Получение объекта
$date = '';
$body = '';
$front = 0;
$visible = 0;

$sql = "select date, body, front, visible from event where id=$id";
$fetcher = new Fetcher($sql);
$error_message = $fetcher->error;

if($row = $fetcher->Fetch()) {
    $date = $row['date'];
    $body = $row['body'];
    $front = $row['front'];
    $visible = $row['visible'];
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
        ?>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <ul class="breadcrumb">
                <li><a href="<?=APPLICATION ?>/">На главную</a></li>
                <li><a href="<?=APPLICATION ?>/admin/">Администратор</a></li>
                <li><a href="<?=APPLICATION ?>/admin/event/">Все события</a></li>
                <li><?=$date ?> <?=($front ? "front" : "") ?> <?=($visible ? "visible" : "") ?></li>
            </ul>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1><?=$date ?> <?=($front ? "front" : "") ?> <?=($visible ? "visible" : "") ?></h1>
                </div>
                <div class="p-1">
                    <div class="btn-group">
                        <a href="<?=APPLICATION ?>/admin/event/" class="btn btn-outline-dark" title="К списку"><i class="fas fa-undo-alt"></i></a>
                        <a href="edit.php" class="btn btn-outline-dark" title="Редактировать"><i class="fas fa-edit"></i></a>
                        <a href="delete.php" class="btn btn-outline-dark" title="Удалить"><i class="fas fa-trash-alt"></i></a>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-left: 0;">
                <div class="content">
                    <?=$body ?>
                    <hr style="clear: both;" />
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>