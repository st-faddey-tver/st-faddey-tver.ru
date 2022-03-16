<?php
include '../../include/topscripts.php';
include '../../include/page/page.php';

// Авторизация
if(!IsInRole(array('about', 'admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если нет параметра id, переходим к списку
$shortname = filter_input(INPUT_GET, 'shortname');
if(empty($shortname)) {
    header('Location: '.APPLICATION.'/admin/page/');
}

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'delete_page_submit')) {
    $id = filter_input(INPUT_POST, 'id');
    $upload_path = $_SERVER['DOCUMENT_ROOT'].APPLICATION."/images/content/";
    
    $sql = "select filename from page_image where page_id=$id";
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
        $sql = "delete from page_image where page_id=$id";
        $error_message = (new Executer($sql))->error;
        
        if(empty($error_message)) {
            $sql = "delete from page_fragment where page_id=$id";
            $error_message = (new Executer($sql))->error;
            
            if(empty($error_message)) {
                $sql = "delete from page where id=$id";
                $error_message = (new Executer($sql))->error;
                
                if(empty($error_message)) {
                    header('Location: '.APPLICATION.'/admin/page/');
                }
            }
        }
    }
}

// Получение объекта
$page = new Page($shortname);
$error_message = $page->errorMessage;
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
            <li><a href="<?=APPLICATION ?>/admin/page/">Страницы</a></li>
            <li><a href="<?=APPLICATION ?>/admin/page/details.php<?= BuildQuery("shortname", $page->shortname) ?>"><?=$page->name ?></a></li>
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
                    <h1 class="text-danger">Действительно удалить?</h1>
                </div>
                <div class="p-1">
                    <a href="details.php<?= BuildQuery("shortname", $page->shortname) ?>" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Отмена</a>
                </div>
            </div>
            <div class="container" style="margin-left: 0;">
                <h1><?=$page->name ?></h1>
                <?php
                $page->GetFragments();
                ?>
                <hr style="clear: both;" />
            </div>
            <form method="post">
                <input type="hidden" id="id" name="id" value="<?=$page->id ?>" />
                <button type="submit" id="delete_page_submit" name="delete_page_submit" class="btn btn-danger">Удалить</button>
            </form>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>