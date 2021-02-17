<?php
include '../../include/topscripts.php';

// Валидация формы
define('ISINVALID', ' is-invalid');
$form_valid = true;
$error_message = '';

$username_valid = '';
$last_name_valid = '';
$first_name_valid = '';
$middle_name_valid = '';
$password_valid = '';

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'user_create_submit')) {
    if(empty(filter_input(INPUT_POST, 'username'))) {
        $username_valid = ISINVALID;
        $form_valid = false;
    }
    
    if(!filter_var(filter_input(INPUT_POST, 'username'), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9]+([._]?[a-zA-Z0-9]+)*$/")))){
        $username_valid = ISINVALID;
        $form_valid = false;
    }
    
    if(empty(filter_input(INPUT_POST, 'last_name'))) {
        $last_name_valid = ISINVALID;
        $form_valid = false;
    }
    
    if(empty(filter_input(INPUT_POST, 'first_name'))) {
        $first_name_valid = ISINVALID;
        $form_valid = false;
    }
    
    if(empty(filter_input(INPUT_POST, 'middle_name'))) {
        $middle_name_valid = ISINVALID;
        $form_valid = false;
    }
    
    if($form_valid) {
        $username = filter_input(INPUT_POST, 'username');
        $last_name = addslashes(filter_input(INPUT_POST, 'last_name'));
        $first_name = addslashes(filter_input(INPUT_POST, 'first_name'));
        $middle_name = addslashes(filter_input(INPUT_POST, 'middle_name'));
        $password = filter_input(INPUT_POST, 'password');
        $sql = "insert into user (username, last_name, first_name, middle_name, password) values ('$username', '$last_name', '$first_name', '$middle_name', password('$password'))";
        $executer = new Executer($sql);
        $error_message = $executer->error;
        $insert_id = $executer->insert_id;
        
        if(empty($error_message)) {
            header('Location: '.APPLICATION."/admin/user/");
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
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <ul class="breadcrumb">
                <li><a href="<?=APPLICATION ?>/">На главную</a></li>
                <li><a href="<?=APPLICATION ?>/admin/">Администратор</a></li>
                <li><a href="<?=APPLICATION ?>/admin/user/">Пользователи</a></li>
                <li>Создание пользователя</li>
            </ul>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="p-1">
                            <h1>Создание пользователя</h1>
                        </div>
                        <div class="p-1">
                            <a href="<?=APPLICATION ?>/admin/user/" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Отмена</a>
                        </div>
                    </div>
                    <form method="post">
                        <div class="form-group">
                            <label for="last_name">Фамилия</label>
                            <input type="text" id="last_name" name="last_name" class="form-control<?=$last_name_valid ?>" value="<?= htmlentities(filter_input(INPUT_POST, 'last_name')) ?>" required="required" />
                            <div class="invalid-feedback">Фамилия обязательно</div>
                        </div>
                        <div class="form-group">
                            <label for="first_name">Имя</label>
                            <input type="text" id="first_name" name="first_name" class="form-control<?=$first_name_valid ?>" value="<?= htmlentities(filter_input(INPUT_POST, 'first_name')) ?>" required="required" />
                            <div class="invalid-feedback">Имя обязательно</div>
                        </div>
                        <div class="form-group">
                            <label for="middle_name">Отчество</label>
                            <input type="text" id="middle_name" name="middle_name" class="form-control<?=$middle_name_valid ?>" value="<?= htmlentities(filter_input(INPUT_POST, 'middle_name')) ?>" required="required" />
                            <div class="invalid-feedback">Отчество обязательно</div>
                        </div>
                        <div class="form-group">
                            <label for="username">Логин</label>
                            <input type="text" id="username" name="username" class="form-control<?=$username_valid ?>" value="<?= htmlentities(filter_input(INPUT_POST, 'username')) ?>" required="required" />
                            <div class="invalid-feedback">Логин обязательно: только латинские буквы, цифры, точка и подчёркивание</div>
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input type="password" id="password" name="password" class="form-control<?=$password_valid ?>" value="<?= htmlentities(filter_input(INPUT_POST, 'password')) ?>" required="required" />
                            <div class="invalid-feedback">Пароль обязательно</div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-dark" id="user_create_submit" name="user_create_submit">Создать</button>
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