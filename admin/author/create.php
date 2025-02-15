<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Валидация формы
$form_valid = true;
$error_message = '';

$first_name_valid = '';

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'author_create_submit')) {
    if(empty(filter_input(INPUT_POST, 'first_name'))) {
        $first_name_valid = ISINVALID;
        $form_valid = false;
    }
    
    if($form_valid) {
        $holy_order = filter_input(INPUT_POST, 'holy_order');
        if(!is_numeric($holy_order)) $holy_order = "NULL";
        $last_name = addslashes(filter_input(INPUT_POST, 'last_name'));
        $first_name = addslashes(filter_input(INPUT_POST, 'first_name'));
        $middle_name = addslashes(filter_input(INPUT_POST, 'middle_name'));
        
        $sql = "insert into author (holy_order, last_name, first_name, middle_name) values ($holy_order, '$last_name', '$first_name', '$middle_name')";
        $executer = new Executer($sql);
        $error_message = $executer->error;
        $insert_id = $executer->insert_id;
        
        if(empty($error_message)) {
            header("Location: ".APPLICATION."/admin/author/details.php".BuildQuery("id", $insert_id));
        }
    }
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
            <li>Новый автор</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Новый автор</h1>
                </div>
                <div class="p-1">
                    <a href="<?=APPLICATION ?>/admin/author/" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Отмена</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <form method="post">
                        <div class="form-group">
                            <label for="holy_order">Титул</label>
                            <select class="form-control" name="holy_order">
                                <option value="">...</option>
                                <?php foreach (HOLY_ORDERS as $holyorder): ?>
                                <option value="<?=$holyorder ?>"<?= filter_input(INPUT_POST, 'holyorder') == $holyorder ? " selected='selected'" : "" ?>><?=HOLY_ORDER_NAMES[$holyorder] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Фамилия</label>
                            <input type="text" name="last_name" class="form-control" value="<?= htmlentities(filter_input(INPUT_POST, 'last_name')) ?>" />
                        </div>
                        <div class="form-group">
                            <label for="first_name">Имя<span class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control" value="<?= htmlentities(filter_input(INPUT_POST, 'first_name')) ?>" required="required" />
                            <div class="invalid-feedback">Имя обязательно</div>
                        </div>
                        <div class="form-group">
                            <label for="middle_name">Отчество</label>
                            <input type="text" name="middle_name" class="form-control" value="<?= htmlentities(filter_input(INPUT_POST, 'middle_name')) ?>" />
                        </div>
                        <button type="submit" name="author_create_submit" class="btn btn-outline-dark mt-3"><i class="fas fa-plus"></i>&nbsp;Создать</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>