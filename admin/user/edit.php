<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array('admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Валидация формы
define('ISINVALID', ' is-invalid');
$form_valid = true;
$error_message = '';

$username_valid = '';
$last_name_valid = '';
$first_name_valid = '';
$middle_name_valid = '';

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'user_edit_submit')) {
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
        $id = filter_input(INPUT_POST, 'id');
        $username = filter_input(INPUT_POST, 'username');
        $last_name = addslashes(filter_input(INPUT_POST, 'last_name'));
        $first_name = addslashes(filter_input(INPUT_POST, 'first_name'));
        $middle_name = addslashes(filter_input(INPUT_POST, 'middle_name'));
        $sql = "update user set username='$username', last_name='$last_name', first_name='$first_name', middle_name='$middle_name' where id=$id";
        
        $password = filter_input(INPUT_POST, 'password');
        if(!empty($password)) {
            $sql = "update user set username='$username', last_name='$last_name', first_name='$first_name', middle_name='$middle_name', password=password('$password') where id=$id";
        }
        
        $error_message = (new Executer($sql))->error;
        if($error_message == '') {
            header('Location: '.APPLICATION."/admin/user/details.php?id=$id");
        }
    }
}

// Если нет параметра id, переходим к списку
if(null === filter_input(INPUT_GET, 'id')) {
    header('Location: '.APPLICATION.'/admin/user/');
}

// Получение объекта
$id = filter_input(INPUT_POST, 'id');
if(empty($id)) {
    $id = filter_input(INPUT_GET, 'id');
}

$row = (new Fetcher("select username, last_name, first_name, middle_name from user where id=$id"))->Fetch();

$username = filter_input(INPUT_POST, 'username');
if(empty($username)) {
    $username = $row['username'];
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
            <li><a href="<?=APPLICATION ?>/admin/user/">Пользователи</a></li>
            <li><a href="<?=APPLICATION ?>/admin/user/details.php?id=<?=$id ?>"><?=$username ?></a></li>
            <li>Редактирование пользователя</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Редактирование пользователя</h1>
                </div>
                <div class="p-1">
                    <a href="<?=APPLICATION ?>/admin/user/details.php?id=<?=$id ?>" class="btn btn-outline-dark" title="Отмена" data-toggle="tooltip"><i class="fas fa-undo-alt"></i>&nbsp;Отмена</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">                    
                    <form method="post">
                        <input type="hidden" id="id" name="id" value="<?= filter_input(INPUT_GET, 'id') ?>" />
                        <div class="form-group">
                            <label for="username">Логин<span class="text-danger">*</span></label>
                            <input type="text" id="username" name="username" class="form-control<?=$username_valid ?>" value="<?= htmlentities($username) ?>" required="required" />
                            <div class="invalid-feedback">Логин обязательно: только латинские буквы, цифры, точка и подчёркивание</div>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Фамилия<span class="text-danger">*</span></label>
                            <input type="text" id="last_name" name="last_name" class="form-control<?=$last_name_valid ?>" value="<?= htmlentities($last_name) ?>" required="required" />
                            <div class="invalid-feedback">Фамилия обязательно</div>
                        </div>
                        <div class="form-group">
                            <label for="first_name">Имя<span class="text-danger">*</span></label>
                            <input type="text" id="first_name" name="first_name" class="form-control<?=$first_name_valid ?>" value="<?= htmlentities($first_name) ?>" required="required" />
                            <div class="invalid-feedback">Имя обязательно</div>
                        </div>
                        <div class="form-group">
                            <label for="middle_name">Отчество<span class="text-danger">*</span></label>
                            <input type="text" id="middle_name" name="middle_name" class="form-control<?=$middle_name_valid ?>" value="<?= htmlentities($middle_name) ?>" required="required" />
                            <div class="invalid-feedback">Отчество обязательно</div>
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input type="password" id="password" name="password" class="form-control" />
                            <div class="text-danger">(Если оставить поле пустым, пароль останется прежним)</div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-dark" id="user_edit_submit" name="user_edit_submit">Сохранить</button>
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