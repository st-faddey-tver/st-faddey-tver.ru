<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если нет параметра id, переходим к списку
if(null === filter_input(INPUT_GET, 'id')) {
    header('Location: '.APPLICATION.'/admin/author/');
}

// Валидация формы
$form_valid = true;
$error_message = '';

$first_name_valid = '';

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'author_edit_submit')) {
    if(empty(filter_input(INPUT_POST, 'first_name'))) {
        $first_name_valid = ISINVALID;
        $form_valid = false;
    }
    
    if($form_valid) {
        $id = filter_input(INPUT_POST, 'id');
        $holy_order = filter_input(INPUT_POST, 'holy_order');
        if(empty($holy_order)) $holy_order = "NULL";
        $last_name = addslashes(filter_input(INPUT_POST, 'last_name'));
        $first_name = addslashes(filter_input(INPUT_POST, 'first_name'));
        $middle_name = addslashes(filter_input(INPUT_POST, 'middle_name'));
        
        $sql = "update author set holy_order = $holy_order, last_name = '$last_name', first_name = '$first_name', middle_name = '$middle_name' where id = $id";
        $error_message = (new Executer($sql))->error;
        
        if(empty($error_message)) {
            header('Location: '.APPLICATION."/admin/author/details.php".BuildQuery('id', $id));
        }
    }
}

// Получение объекта
$id = filter_input(INPUT_POST, 'id');
if(null === $id) {
    $id = filter_input(INPUT_GET, 'id');
}

$sql = "select holy_order, last_name, first_name, middle_name from author where id = $id";
$row = (new Fetcher($sql))->Fetch();

$holy_order = filter_input(INPUT_POST, 'holy_order');
if(empty($holy_order)) {
    $holy_order = $row['holy_order'];
}

$last_name = filter_input(INPUT_POST, 'last_name');
if(empty($last_name)) {
    $last_name = $row['last_name'];
}

$first_name = filter_input(INPUT_POST, 'first_name');
if(empty($first_name)) {
    $first_name = $row['first_name'];
}

$middle_name = filter_input(INPUT_POST, 'middle_name');
if(empty($middle_name)) {
    $middle_name = $row['middle_name'];
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
            <li><a href="<?=APPLICATION ?>/admin/author/">Авторы</a></li>
            <li><a href="<?=APPLICATION ?>/admin/author/details.php<?= BuildQuery('id', $id) ?>"><?= GetAuthorsFullName($holy_order, $last_name, $first_name, $middle_name) ?></a></li>
            <li>Редактирование автора</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Редактирование автора</h1>
                </div>
                <div class="p-1">
                    <a href="details.php<?= BuildQuery('id', $id) ?>" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Отмена</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <form method="post">
                        <input type="hidden" name="id" value="<?= $id ?>" />
                        <div class="form-group">
                            <label for="holy_order">Титул</label>
                            <select class="form-control" name="holy_order">
                                <option value="">...</option>
                                <?php foreach (HOLY_ORDERS as $holyorder): ?>
                                <option value="<?=$holyorder ?>"<?= $holy_order == $holyorder ? " selected='selected'" : "" ?>><?=HOLY_ORDER_NAMES[$holyorder] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Фамилия</label>
                            <input type="text" name="last_name" class="form-control" value="<?= htmlentities($last_name) ?>" />
                        </div>
                        <div class="form-group">
                            <label for="first_name">Имя<span class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control" value="<?= htmlentities($first_name) ?>" />
                            <div class="invalid-feedback">Имя обязательно</div>
                        </div>
                        <div class="form-group">
                            <label for="middle_name">Отчество</label>
                            <input type="text" name="middle_name" class="form-control" value="<?= htmlentities($middle_name) ?>" />
                        </div>
                        <button type="submit" name="author_edit_submit" class="btn btn-outline-dark mt-3"><i class="fas fa-save"></i>&nbsp;Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>