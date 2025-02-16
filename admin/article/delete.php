<?php
include '../../include/topscripts.php';
include '../../include/news/news.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если нет параметра id, переходим к списку
$id = filter_input(INPUT_GET, 'id');
if(empty($id)) {
    header('Location: '.APPLICATION.'/admin/article/');
}

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'delete_news_submit')) {
    $id = filter_input(INPUT_POST, 'id');
    $upload_path = $_SERVER['DOCUMENT_ROOT'].APPLICATION."/images/content/";
    
    $sql = "select filename from news_image where news_id = $id";
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
        $sql = "delete from news_image where news_id = $id";
        $error_message = (new Executer($sql))->error;
        
        if(empty($error_message)) {
            $sql = "delete from news_fragment where news_id = $id";
            $error_message = (new Executer($sql))->error;
            
            if(empty($error_message)) {
                $sql = "delete from news where id = $id";
                $error_message = (new Executer($sql))->error;
                
                if(empty($error_message)) {
                    header('Location: '.APPLICATION.'/admin/article/'.BuildQueryRemove('id'));
                }
            }
        }
    }
}

// Получение объекта
$date = '';
$holy_order = '';
$last_name = '';
$first_name = '';
$middle_name = '';
$name = '';
$shortname = '';
$body = '';

$sql = "select n.date, a.holy_order, a.last_name, a.first_name, a.middle_name, n.name, n.shortname, n.body, n.front, n.visible "
        . "from news n inner join author a on n.author_id = a.id "
        . "where n.id = $id";
$fetcher = new Fetcher($sql);
$error_message = $fetcher->error;

if($row = $fetcher->Fetch()) {
    $date = $row['date'];
    $holy_order = $row['holy_order'];
    $last_name = $row['last_name'];
    $first_name = $row['first_name'];
    $middle_name = $row['middle_name'];
    $name = $row['name'];
    $shortname = $row['shortname'];
    $body = $row['body'];
    $front = $row['front'];
    $visible = $row['visible'];
}

// Фрагменты
$news = new News($id);
$error_message = $news->errorMessage;
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
            <li><a href="<?=APPLICATION ?>/admin/article/<?= BuildQueryRemove('id') ?>">Приходские заметки</a></li>
            <li><a href="<?=APPLICATION ?>/admin/article/details.php<?= BuildQuery('id', $id) ?>"><?=$name ?></a></li>
            <li>Удаление статьи</li>
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
            <div class="container" style="margin-left: 0;">
                <div class="content">
                    <div class="row">
                        <div class="col-6">
                            <div class="news_date"><?= DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y') ?>&nbsp;<?=$shortname ?>&nbsp;<?=$front ? 'front' : '' ?>&nbsp;<?=$visible ? 'visible' : '' ?></div>
                            <div class="news_name"><?=$name ?></div>
                            <div class="news_body"><?=$body ?></div>
                        </div>
                    </div>
                    <hr />
                    <div class="bigfont">
                        <?php
                        $news->GetFragments();
                        ?>
                    </div>
                </div>
            </div>
            <form method="post">
                <input type="hidden" id="id" name="id" value="<?= filter_input(INPUT_GET, 'id') ?>" />
                <button type="submit" id="delete_news_submit" name="delete_news_submit" class="btn btn-danger">Удалить</button>
            </form>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>