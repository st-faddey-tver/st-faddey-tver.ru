<?php
include '../include/topscripts.php';
include '../include/page/page.php';

// Авторизация
if(!IsInRole(array('about', 'admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если нет параметра shortname, переходим к списку
$shortname = filter_input(INPUT_GET, 'shortname');
if(empty($shortname)) {
    header('Location: '.APPLICATION.'/admin/');
}

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, "seo-submit")) {
    $title = addslashes(filter_input(INPUT_POST, "title"));
    $description = addslashes(filter_input(INPUT_POST, "description"));
    $keywords = addslashes(filter_input(INPUT_POST, "keywords"));
    $shortname = filter_input(INPUT_POST, "shortname");
    
    $sql = "update page set title = '$title', description = '$description', keywords = '$keywords' where shortname = '$shortname'";
    $error_message = (new Executer($sql))->error;
}

// Получение объекта
$page = new Page($shortname);
$page->Top();
$error_message = $page->errorMessage;
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        include 'include/head.php';
        ?>
    </head>
    <body>
        <?php
        include 'include/header.php';
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
                <li><a href="<?=APPLICATION ?>/admin/page.php<?= BuildQueryRemove("mode") ?>"><?=$page->name ?></a></li>
                <li>SEO</li>
            </ul>
            <div class="container" style="margin-left: 0;">
                <div class="d-flex justify-content-between mb-2">
                    <div class="p-1">
                        <h1><?=$page->name ?></h1>
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
                            <a href="page.php<?= BuildQuery("shortname", filter_input(INPUT_GET, "shortname")) ?>" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Выход из SEO</a>
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
                            <input type="hidden" id="shortname" name="shortname" value="<?= filter_input(INPUT_GET, "shortname") ?>" />
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title" class="form-control" value="<?=$page->title ?>" />
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" class="form-control" rows="7"><?=$page->description ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="keywords">Keywords</label>
                                <textarea id="keywords" name="keywords" class="form-control" rows="7"><?=$page->keywords ?></textarea>
                            </div>
                            <button type="submit" id="seo-submit" name="seo-submit" class="btn btn-outline-dark"><i class="fas fa-save"></i>&nbsp;Сохранить</button>
                        </form>
                        <?php else: ?>
                        <h2>Title</h2>
                        <?=$page->title ?>
                        <h2>Description</h2>
                        <?=$page->description ?>
                        <h2>Keywords</h2>
                        <?=$page->keywords ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include 'include/footer.php';
        ?>
    </body>
</html>