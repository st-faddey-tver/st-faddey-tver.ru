<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array('admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если нет параметра id, переходим к списку
$id = filter_input(INPUT_GET, 'id');
if(empty($id)) {
    header('Location: '.APPLICATION.'/admin/event/');
}

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'delete_event_submit')) {
    $id = filter_input(INPUT_POST, 'id');
    $upload_path = $_SERVER['DOCUMENT_ROOT'].APPLICATION."/images/content";
    
    $sql = "select filename from event_image where event_id=$id";
    $fetcher = new Fetcher($sql);
    while ($row = $fetcher->Fetch()) {
        $filename = $row['filename'];
        if(file_exists($upload_path.$filename)) {
            if(!unlink($upload_path.$filename)) {
                $error_message = "Ошибка при удалении файла";
            }
        }
    }
    
    if(empty($error_message)) {
        $sql = "delete from event_image where event_id=$id";
        $error_message = (new Executer($sql))->error;
        
        if(empty($error_message)) {
            $sql = "delete from event where id=$id";
            $error_message = (new Executer($sql))->error;
            
            if(empty($error_message)) {
                header('Location: '.APPLICATION.'/admin/event/'.BuildQueryRemove('id'));
            }
        }
    }
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
        <ul class="breadcrumb">
            <li><a href="<?=APPLICATION ?>/">На главную</a></li>
            <li><a href="<?=APPLICATION ?>/admin/">Администратор</a></li>
            <li><a href="<?=APPLICATION ?>/admin/event/<?= BuildQueryRemove('id') ?>">События</a></li>
            <li><a href="<?=APPLICATION ?>/admin/event/details.php<?= BuildQuery('id', $id) ?>"><?=$date ?></a></li>
            <li>Удаление новости</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1 class="text-danger">Действительно удалить?</h1>
                </div>
                <div class="p-1">
                    <a href="details.php<?= BuildQuery('id', $id) ?>" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Отмена</a>
                </div>
            </div>
            <h2><?=$date ?> <?=($front ? "front" : "") ?> <?=($visible ? "visible" : "") ?></h2>
            <div class="container" style="margin-left: 0;">
                <div class="content">
                    <?=$body ?>
                    <hr style="clear: both;" />
                </div>
            </div>
            <form method="post">
                <input type="hidden" id="id" name="id" value="<?= filter_input(INPUT_GET, 'id') ?>" />
                <button type="submit" id="delete_event_submit" name="delete_event_submit" class="btn btn-danger">Удалить</button>
            </form>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>