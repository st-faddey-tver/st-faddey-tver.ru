<?php
include '../../include/topscripts.php';
include '../../include/news/news.php';

// Авторизация
if(!IsInRole(array('about', 'admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если нет параметра is_event, переход на главную страницу администратора
$is_event = filter_input(INPUT_GET, 'is_event');
if($is_event === null) {
    header('Location: '.APPLICATION."/admin/");
}

// Если нет параметра id, переход к списку
$id = filter_input(INPUT_GET, 'id');
if(empty($id)) {
    header('Location: '.APPLICATION."/admin/news/". BuildQuery('is_event', $is_event));
}

// Получение объекта
$date = '';
$name = '';
$shortname = '';
$body = '';

$sql = "select date, name, shortname, body, front, visible from news where id=$id";
$fetcher = new Fetcher($sql);
$error_message = $fetcher->error;

if($row = $fetcher->Fetch()) {
    $date = $row['date'];
    $name = $row['name'];
    $shortname = $row['shortname'];
    $body = $row['body'];
    $front = $row['front'];
    $visible = $row['visible'];
}

// Фрагменты
$news = new News($id);
$news->Top();
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
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <ul class="breadcrumb">
                <li><a href="<?=APPLICATION ?>/">На главную</a></li>
                <li><a href="<?=APPLICATION ?>/admin/">Администратор</a></li>
                <li><a href="<?=APPLICATION ?>/admin/news/<?= BuildQueryRemove('id') ?>"><?=$is_event ? "Все события" : "Все новости" ?></a></li>
                <li><?=$name ?></li>
            </ul>
            <div class="container" style="margin-left: 0;">
                <div class="content">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="p-1">
                            <h1><?=$name ?></h1>
                        </div>
                        <div class="p-1">
                            <div class="btn-group">
                                <a href="index.php<?= BuildQueryRemove('id') ?>" class="btn btn-outline-dark" title="К списку" data-toggle="tooltip"><i class="fas fa-undo-alt"></i></a>
                                <a href="edit.php<?= BuildQuery('id', $id) ?>" class="btn btn-outline-dark" title="Редактировать" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                                <a href="delete.php<?= BuildQuery('id', $id) ?>" class="btn btn-outline-dark" title="Удалить" data-toggle="tooltip"><i class="fas fa-trash-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="<?=$is_event ? 'col-12' : 'col-6' ?>">
                            <div class="<?=$is_event ? 'text-info' : 'news_date' ?>"><?= DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y') ?>&nbsp;<?=$shortname ?>&nbsp;<?=$front ? 'front' : '' ?>&nbsp;<?=$visible ? 'visible' : '' ?></div>
                            <div class="news_name"><?=$name ?></div>
                            <div class="<?=$is_event ? 'event_body' : 'news_body' ?>"><?=$body ?></div>
                        </div>
                    </div>
                    <hr />
                    <div class="d-flex justify-content-between mb-2">
                        <div class="p-1">
                            <h2>Полный текст</h2>
                        </div>
                        <div class="p-1">
                            <?php
                            if(filter_input(INPUT_GET, 'mode') == 'edit'):
                            ?>
                            <a href="details.php<?= BuildQueryRemove('mode') ?>" class="btn btn-outline-dark" title="Выход из редактирования" data-toggle="tooltip"><i class="fas fa-undo-alt"></i>&nbsp;Выход из редактирования</a>
                            <?php
                            else:
                            ?>
                            <div class="btn-group">
                                <a href="seo.php<?= BuildQuery("id", filter_input(INPUT_GET, "id")) ?>" class="btn btn-outline-dark" title="SEO" data-toggle="tooltip"><i class="fas fa-globe"></i>&nbsp;SEO</a>
                                <a href="details.php<?= BuildQuery('mode', 'edit') ?>" class="btn btn-outline-dark" title="Редактировать" data-toggle="tooltip"><i class="fas fa-edit"></i>&nbsp;Редактировать</a>
                            </div>
                            <?php
                            endif;
                            ?>
                        </div>
                    </div>
                    <div class="bigfont">
                        <?php
                        if(filter_input(INPUT_GET, 'mode') == 'edit') {
                            $news->GetFragmentsEditMode();
                        }                            
                        else {
                            $news->GetFragments();
                        }
                        
                        $news->ShowCreateFragmentForm();
                        
                        if(filter_input(INPUT_GET, 'mode') != 'edit'):
                        ?>
                    </div>
                    <hr />
                    <h2>Изображения</h2>
                    <?php
                    $news->GetImages();
                    ?>
                    <div class="row">
                        <div class="col-8">
                            <?php
                            $news->ShowUploadImageForm();
                            ?>
                        </div>
                    </div>
                    <?php
                    endif;
                    ?>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>