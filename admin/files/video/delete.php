<?php
include '../../../include/topscripts.php';

// Авторизация
if(!IsInRole(array('files', 'admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если не указан id, переходим к списку
$id = filter_input(INPUT_GET, 'id');
if(empty($id)) {
    header('Location: '.APPLICATION.'/admin/files/video/');
}

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'video_section_delete_submit')) {
    $id = filter_input(INPUT_POST, 'id');
    $sql = "delete from video_section where id=$id";
    $error_message = (new Executer($sql))->error;
    
    if(empty($error_message)) {
        header('Location: '.APPLICATION.'/admin/files/video/');
    }
}

// Получение объекта
$name = '';
$sql = "select name from video_section where id=$id";
$fetcher = new Fetcher($sql);
$error_message = $fetcher->error;

if($row = $fetcher->Fetch()) {
    $name = $row['name'];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        include '../../include/head.php';
        ?>
    </head>
    <body>
        <?php
        include '../../include/header.php';
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
                <li><a href="<?=APPLICATION ?>/admin/files/video/">Видео</a></li>
                <li><a href="<?=APPLICATION ?>/admin/files/video/details.php<?= BuildQuery("id", $id) ?>"><?=$name ?></a></li>
                <li>Удаление раздела</li>
            </ul>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h2 class="text-danger">Действительно удалить?</h2>
                </div>
                <div class="p-1">
                    <a href="details.php<?= BuildQuery('id', $id) ?>" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Отмена</a>
                </div>
            </div>
            <h1><?=$name ?></h1>
            <form method="post">
                <input type="hidden" id="id" name="id" value="<?= filter_input(INPUT_GET, 'id') ?>" />
                <button type="submit" id="video_section_delete_submit" name="video_section_delete_submit" class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i>&nbsp;Удалить</button>
            </form>
        </div>
        <?php
        include '../../include/footer.php';
        ?>
    </body>
</html>