<?php
include '../../include/topscripts.php';
include '../../include/page/page.php';

// Авторизация
if(!IsInRole(array('admin'))) {
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

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, "seo-submit")) {
    $title = addslashes(filter_input(INPUT_POST, "title"));
    $description = addslashes(filter_input(INPUT_POST, "description"));
    $keywords = addslashes(filter_input(INPUT_POST, "keywords"));
    $id = filter_input(INPUT_POST, "id");
    
    $sql = "update news set title = '$title', description = '$description', keywords = '$keywords' where id = '$id'";
    $error_message = (new Executer($sql))->error;
}

// Получение объекта
$name = '';
$title = '';
$description = '';
$keywords = '';

$sql = "select name, title, description, keywords from news where id=$id";
$fetcher = new Fetcher($sql);
$error_message = $fetcher->error;

if($row = $fetcher->Fetch()) {
    $name = $row['name'];
    $title = $row['title'];
    $description = $row['description'];
    $keywords = $row['keywords'];
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
                <li><a href="<?=APPLICATION ?>/admin/news/<?= BuildQueryRemove("id") ?>"><?=$is_event ? "Все события" : "Все новости" ?></a></li>
                <li><a href="details.php<?= BuildQueryRemove("mode") ?>"><?=$name ?></a></li>
                <li>SEO</li>
            </ul>
            <div class="container" style="margin-left: 0;">
                <div class="d-flex justify-content-between mb-2">
                    <div class="p-1">
                        <h1><?=$name ?></h1>
                    </div>
                    <div class="p-1">
                        <?php
                        if(filter_input(INPUT_GET, "mode") == "edit"):
                        ?>
                        <a href="<?= BuildQueryRemove("mode") ?>" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Выход из редактирования</a>
                        <?php
                        else:
                        ?>
                        <div class="btn-group">
                            <a href="details.php<?= BuildQuery("id", filter_input(INPUT_GET, "id")) ?>" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Выход из SEO</a>
                            <a href="<?= BuildQuery("mode", "edit") ?>" class="btn btn-outline-dark"><i class="fas fa-edit"></i>&nbsp;Редактировать</a>
                        </div>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <?php if(filter_input(INPUT_GET, "mode") == "edit"): ?>
                        <form method="post" action="<?= BuildQueryRemove("mode") ?>">
                            <input type="hidden" id="id" name="id" value="<?= filter_input(INPUT_GET, "id") ?>" />
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title" class="form-control" value="<?=$title ?>" />
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" class="form-control" rows="7"><?=$description ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="keywords">Keywords</label>
                                <textarea id="keywords" name="keywords" class="form-control" rows="7"><?=$keywords ?></textarea>
                            </div>
                            <button type="submit" id="seo-submit" name="seo-submit" class="btn btn-outline-dark"><i class="fas fa-save"></i>&nbsp;Сохранить</button>
                        </form>
                        <?php else: ?>
                        <h2>Title</h2>
                        <?=$title ?>
                        <h2>Description</h2>
                        <?=$description ?>
                        <h2>Keywords</h2>
                        <?=$keywords ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>