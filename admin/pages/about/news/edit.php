<?php
include '../../../../include/topscripts.php';

// Авторизация
if(!IsInRole(array('about', 'admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если нет параметра is_event, переход на главную страницу администратора
$is_event = filter_input(INPUT_GET, 'is_event');
if($is_event === null) {
    header('Location: '.APPLICATION."/admin/");
}

// Валидация формы
define('ISINVALID', ' is-invalid');
$form_valid = true;
$error_message = '';

$title_valid = '';
$shortname_valid = '';
$body_valid = '';

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'news_edit_submit')) {
    if(empty(filter_input(INPUT_POST, 'title'))) {
        $title_valid = ISINVALID;
        $form_valid = false;
    }
    
    if(!empty(filter_input(INPUT_POST, 'shortname')) && !filter_var(filter_input(INPUT_POST, 'shortname'), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-z0-9]+([._]?[a-z0-9]+)*$/")))) {
        $shortname_valid = ISINVALID;
        $form_valid = false;
    }
    
    if(empty(filter_input(INPUT_POST, 'body'))) {
        $body_valid = ISINVALID;
        $form_valid = false;
    }
    
    if($form_valid) {
        $id = filter_input(INPUT_POST, 'id');
        $date = filter_input(INPUT_POST, 'date');
        $title = addslashes(filter_input(INPUT_POST, 'title'));
        $shortname = filter_input(INPUT_POST, 'shortname');
        $body = addslashes(filter_input(INPUT_POST, 'body'));
        $front = filter_input(INPUT_POST, 'front') == 'on' ? 1 : 0;
        $show_title = filter_input(INPUT_POST, 'show_title') == 'on' ? 1 : 0;
        
        if(empty($shortname)) {
            $shortname = Romanize($title);
        }
        if(empty($shortname)) {
            $shortname = strval(time());
        }
        
        $shortnames_count = 1;
        do {
            $sql = "select count(id) shortnames_count from news where shortname='$shortname' and id<>$id";
            $fetcher = new Fetcher($sql);
            $error_message = $fetcher->error;
            
            if($row = $fetcher->Fetch()) {
                $shortnames_count = $row['shortnames_count'];
            }
            
            if($shortnames_count > 0) {
                $shortname = time().'_'.$shortname;
            }
        }while ($shortnames_count > 0);
        
        $sql = "update news set date='$date', title='$title', shortname='$shortname', body='$body', front=$front, show_title=$show_title where id=$id";
        $error_message = (new Executer($sql))->error;
        if(empty($error_message)) {
            header('Location: '.APPLICATION."/admin/pages/about/news/details.php".BuildQuery('id', $id));
        }
    }
}

// Если нет параметра id, переходим к списку
if(null === filter_input(INPUT_GET, 'id')) {
    header('Location: '.APPLICATION.'/admin/pages/about/news/'. BuildQuery('is_event', $is_event));
}

// Получение объекта
$id = filter_input(INPUT_POST, 'id');
if(empty($id)) {
    $id = filter_input(INPUT_GET, 'id');
}

$sql = "select date, title, shortname, body, front, show_title from news where id=$id";
$row = (new Fetcher($sql))->Fetch();

$date = filter_input(INPUT_POST, 'date');
if(empty($date)) {
    $date = $row['date'];
}

$title = filter_input(INPUT_POST, 'title');
if(empty($title)) {
    $title = $row['title'];
}

$shortname = filter_input(INPUT_POST, 'shortname');
if(empty($shortname)) {
    $shortname = $row['shortname'];
}

$body = filter_input(INPUT_POST, 'body');
if(empty($body)) {
    $body = $row['body'];
}

if(null !== filter_input(INPUT_POST, 'news_edit_submit')) {
    $front = filter_input(INPUT_POST, 'front') == 'on' ? 1 : 0;
    $show_title = filter_input(INPUT_POST, 'show_title') == 'on' ? 1 : 0;
}
else {
    $front = $row['front'];
    $show_title = $row['show_title'];
}
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
                <li><?=$is_event ? "Редактирование события" : "Редактирование новости" ?></li>
            </ul>
            <div class="container" style="margin-left: 0;">
                <div class="d-flex justify-content-between mb-2">
                    <div class="p-1">
                        <h1><?=$is_event ? "Редактирование события" : "Редактирование новости" ?></h1>
                    </div>
                    <div class="p-1">
                        <a href="details.php<?= BuildQuery('id', $id) ?>" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Отмена</a>
                    </div>
                </div>
                <form method="post">
                    <input type="hidden" id="id" name="id" value="<?= filter_input(INPUT_GET, 'id') ?>" />
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="date">Дата</label>
                                <input type="date" id="date" name="date" class="form-control" value="<?=$date ?>" />
                            </div>
                        </div>
                        <div class="col-4" style="padding-top: 30px;">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="front" name="front"<?=($front ? " checked='checked'" : '') ?>" />
                                <label class="form-check-label" for="front">На первой странице</label>
                            </div>
                        </div>
                        <div class="col-4" style="padding-top: 30px;">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="show_title" name="show_title"<?=($show_title ? " checked='checked'" : '') ?>" />
                                <label class="form-check-label" for="show_title">Показывать заголовок</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title">Заголовок<span class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" class="form-control<?=$title_valid ?>" value="<?= htmlentities($title) ?>" required="required" />
                        <div class="invalid-feedback">Заголовок обязательно</div>
                    </div>
                    <div class="form-group">
                        <label for="shortname">Краткое наименование (только маленькие латинские буквы, точка или подчёркивание)</label>
                        <input type="text" id="shortname" name="shortname" class="form-control<?=$shortname_valid ?>" value="<?=$shortname ?>" />
                        <div class="invalid-feedback">Только маленькие латинские буквы, точка или подчёркивание. Можно поле оставить пустым.</div>
                    </div>
                    <div class="form-group">
                        <label for="body">Текст<span class="text-danger">*</span></label>
                        <textarea id="body" name="body" class="form-control editor<?=$body_valid ?>" required="required"><?= htmlentities($body) ?></textarea>
                        <div class="invalid-feedback">Текст обязательно</div>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="news_edit_submit" name="news_edit_submit" class="btn btn-outline-dark"><i class="fas fa-save"></i>&nbsp;Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
        include '../../../include/footer.php';
        ?>
    </body>
</html>