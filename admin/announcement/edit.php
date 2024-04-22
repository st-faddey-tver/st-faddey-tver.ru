<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если нет параметра id, переходим к списку
if(null === filter_input(INPUT_GET, 'id')) {
    header('Location: '.APPLICATION.'/admin/announcement/');
}

// Валидация формы
$form_valid = true;
$error_message = '';

$date_valid = '';
$body_valid = '';

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'announcement_edit_submit')) {
    if(empty(filter_input(INPUT_POST, 'date'))) {
        $date_valid = ISINVALID;
        $form_valid = false;
    }
    
    if(empty(filter_input(INPUT_POST, 'body'))) {
        $body_valid = ISINVALID;
        $form_valid = false;
    }
    
    if($form_valid) {
        $id = filter_input(INPUT_POST, 'id');
        $date = filter_input(INPUT_POST, 'date');
        $body = addslashes(filter_input(INPUT_POST, 'body'));
        $front = filter_input(INPUT_POST, 'front') == 'on' ? 1 : 0;
        $visible = filter_input(INPUT_POST, 'visible') == 'on' ? 1 : 0;
        
        $sql = "update event set date='$date', body='$body', front=$front, visible=$visible where id=$id";
        $error_message = (new Executer($sql))->error;
        
        if(empty($error_message)) {
            header('Location: '.APPLICATION."/admin/announcement/details.php".BuildQuery('id', $id));
        }
    }
}

// Получение объекта
$id = filter_input(INPUT_POST, 'id');
if(empty($id)) {
    $id = filter_input(INPUT_GET, 'id');
}

$sql = "select date, body, front, visible from event where id=$id";
$row = (new Fetcher($sql))->Fetch();

$date = filter_input(INPUT_POST, 'date');
if(empty($date)) {
    $date = $row['date'];
}

$body = filter_input(INPUT_POST, 'body');
if(empty($body)) {
    $body = $row['body'];
}

if(null !== filter_input(INPUT_POST, 'announcement_edit_submit')) {
    $front = filter_input(INPUT_POST, 'front') == 'on' ? 1 : 0;
    $visible = filter_input(INPUT_POST, 'visible') == 'on' ? 1 : 0;
}
else {
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
            <li><a href="<?=APPLICATION ?>/admin/announcement/<?= BuildQueryRemove('id') ?>">Объявления</a></li>
            <li><a href="<?=APPLICATION ?>/admin/announcement/details.php<?= BuildQuery('id', $id) ?>"><?=$date ?></a></li>
            <li>Редактирование объявление</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Редактирование объявлени</h1>
                </div>
                <div class="p-1">
                    <a href="details.php<?= BuildQuery('id', $id) ?>" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Отмена</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8">
                    <form method="post">
                        <input type="hidden" id="id" name="id" value="<?= filter_input(INPUT_GET, 'id') ?>" />
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="date">Дата<span class="text-danger">*</span></label>
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
                                    <input type="checkbox" class="form-check-input" id="visible" name="visible"<?=($visible ? " checked='checked'" : '') ?> />
                                    <label class="form-check-label" for="visible">Показывать</label>
                                </div>
                            </div>
                        </div>
                        <?php
                        include $_SERVER['DOCUMENT_ROOT'].APPLICATION.'/include/virtual_keyboard.php';
                        ?>
                        <div class="form-group">
                            <label for="body">Текст<span class="text-danger">*</span></label>
                            <textarea id="body" name="body" class="form-control<?=$body_valid ?>" style="height: 200px;" required="required"><?= htmlentities($body) ?></textarea>
                            <div class="invalid-feedback">Текст обязательно</div>
                        </div>
                        <div class="form-group d-flex justify-content-between mb-auto">
                            <div class="p-1">
                                <button type="submit" id="announcement_edit_submit" name="announcement_edit_submit" class="btn btn-outline-dark"><i class="fas fa-save"></i>&nbsp;Сохранить</button>
                            </div>
                            <div class="p-1">
                                <button type="button" class="btn btn-outline-dark btn_vk"><i class="fas fa-keyboard"></i>&nbsp;Виртуальная клавиатура</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>