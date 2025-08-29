<?php
include '../../include/topscripts.php';
include '../../include/cantus.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если нет параметра shortname, переходим к списку
$shortname = filter_input(INPUT_GET, 'shortname');
if(empty($shortname)) {
    header('Location: '.APPLICATION.'/admin/cantus/');
}

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'delete_cantus_submit')) {
    $id = filter_input(INPUT_POST, 'id');
    $upload_path = $_SERVER['DOCUMENT_ROOT'].APPLICATION."/images/content/";
    
    $sql = "select filename from cantus_image where cantus_id = $id";
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
        $sql = "delete from cantus_image where cantus_id = $id";
        $executer = new Executer($sql);
        $error_message = $executer->error;
        
        if(empty($error_message)) {
            $sql = "delete from cantus_fragment where cantus_id = $id";
            $executer = new Executer($sql);
            $error_message = $executer->error;
            
            if(empty($error_message)) {
                $sql = "delete from cantus where id = $id";
                $executer = new Executer($sql);
                $error_message = $executer->error;
                
                if(empty($error_message)) {
                    header('Location: '.APPLICATION.'/admin/cantus/');
                }
            }
        }
    }
}

// Получение объекта
$cantus = new Cantus($shortname);
$error_message = $cantus->errorMessage;
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
            <li><a href="<?=APPLICATION ?>/admin/cantus/">Общенародное пение</a></li>
            <li><a href="<?=APPLICATION ?>/admin/cantus/details.php<?= BuildQuery("shortname", $cantus->shortname) ?>"><?=$cantus->name ?></a></li>
            <li>Удаление страницы</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <p class="text-danger" style="font-size: xx-large;">Действительно удалить?</p>
                </div>
                <div class="p-1">
                    <a href="details.php<?= BuildQuery("shortname", $cantus->shortname) ?>" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Отмена</a>
                </div>
            </div>
            <div class="container" style="margin-left: 0;">
                <h1><?=$cantus->name ?></h1>
                <?php $cantus->GetFragments(); ?>
                <hr style="clear: both;" />
            </div>
            <form method="post">
                <input type="hidden" id="id" name="id" value="<?=$cantus->id ?>" />
                <button type="submit" id="delete_cantus_submit" name="delete_cantus_submit" class="btn btn-danger">Удалить</button>
            </form>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>