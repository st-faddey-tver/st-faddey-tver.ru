<?php
include '../../../../include/topscripts.php';
include '../../../../include/news/news.php';

// Авторизация
if(!IsInRole(array('about', 'admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если нет параметра is_event, переход на главную страницу администратора
$is_event = filter_input(INPUT_GET, 'is_event');
if($is_event === null) {
    header('Location: '.APPLICATION."/admin/");
}

// Если нет параметра id, переходим к списку
$id = filter_input(INPUT_GET, 'id');
if(empty($id)) {
    header('Location: '.APPLICATION.'/admin/pages/about/news/'. BuildQuery('is_event', $is_event));
}

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'delete_news_submit')) {
    $id = filter_input(INPUT_POST, 'id');
    $upload_path = $_SERVER['DOCUMENT_ROOT'].APPLICATION."/images/content/";
    
    $sql = "select filename from news_image where news_id=$id";
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
        $sql = "delete from news_image where news_id=$id";
        $error_message = (new Executer($sql))->error;
        
        if(empty($error_message)) {
            $sql = "delete from news_fragment where news_id=$id";
            $error_message = (new Executer($sql))->error;
            
            if(empty($error_message)) {
                $sql = "delete from news where id=$id";
                $error_message = (new Executer($sql))->error;
                
                if(empty($error_message)) {
                    header('Location: '.APPLICATION.'/admin/pages/about/news/'.BuildQueryRemove('id'));
                }
            }
        }
    }
}

// Получение объекта
$date = '';
$title = '';
$shortname = '';
$body = '';

$sql = "select date, title, shortname, body, front, show_title from news where id=$id";
$fetcher = new Fetcher($sql);
$error_message = $fetcher->error;

if($row = $fetcher->Fetch()) {
    $date = $row['date'];
    $title = $row['title'];
    $shortname = $row['shortname'];
    $body = $row['body'];
    $front = $row['front'];
    $show_title = $row['show_title'];
}

// Фрагменты
$news = new News($id);
$error_message = $news->errorMessage;
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
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <ul class="breadcrumb">
                <li><a href="<?=APPLICATION ?>/">На главную</a></li>
                <li><a href="<?=APPLICATION ?>/admin/">Администратор</a></li>
                <li><a href="<?=APPLICATION ?>/admin/pages/about/news/<?= BuildQueryRemove('id') ?>"><?=$is_event ? "Все события" : "Все новости" ?></a></li>
                <li><a href="<?=APPLICATION ?>/admin/pages/about/news/details.php<?= BuildQuery('id', $id) ?>"><?=$title ?></a></li>
                <li><?=$is_event ? "Удаление события" : "Удаление новости" ?></li>
            </ul>
            <div class="container" style="margin-left: 0;">
                <div class="d-flex justify-content-between mb-2">
                    <div class="p-1">
                        <h1 class="text-danger">Действительно удалить?</h1>
                    </div>
                    <div class="p-1">
                        <a href="details.php<?= BuildQuery('id', $id) ?>" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Отмена</a>
                    </div>
                </div>
                <div class="news_date"><?= DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y') ?>&nbsp;<?=$shortname ?>&nbsp;<?=$front ? 'front' : '' ?>&nbsp;<?=$show_title ? 'show_title' : '' ?></div>
                <div class="news_title"><?=$title ?></div>
                <?=$body ?>
                <hr />
                <?php
                $news->GetFragments();
                ?>
                <hr />
                <form method="post">
                    <input type="hidden" id="id" name="id" value="<?= filter_input(INPUT_GET, 'id') ?>" />
                    <button type="submit" id="delete_news_submit" name="delete_news_submit" class="btn btn-danger">Удалить</button>
                </form>
            </div>
        </div>
        <?php
        include '../../../include/footer.php';
        ?>
    </body>
</html>