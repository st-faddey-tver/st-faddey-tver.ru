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
        
$role_id_valid = '';

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'create_user_role_submit')) {
    $role_id = filter_input(INPUT_POST, 'role_id');
    if(empty($role_id)) {
        $role_id_valid = ISINVALID;
        $form_valid = false;
    }
    
    if($form_valid) {
        $user_id = filter_input(INPUT_POST, 'user_id');
        $error_message = (new Executer("insert into user_role (user_id, role_id) values ($user_id, $role_id)"))->error;
    }
}

if(null !== filter_input(INPUT_POST, 'delete_user_role_submit')) {
    $user_id = filter_input(INPUT_POST, 'user_id');
    $role_id = filter_input(INPUT_POST, 'role_id');
    $error_message = (new Executer("delete from user_role where user_id = $user_id and role_id = $role_id"))->error;
}

// Если нет параметра id, переход к списку
$id = filter_input(INPUT_GET, 'id');
if(empty($id)) {
    header('Location: '.APPLICATION.'/admin/user/');
}

// Получение объекта
$username = '';
$last_name = '';
$first_name = '';
$middle_name = '';

$sql = "select username, last_name, first_name, middle_name from user where id = $id";
$fetcher = new Fetcher($sql);
$error_message = $fetcher->error;

if($row = $fetcher->Fetch()) {
    $username = $row['username'];
    $last_name = $row['last_name'];
    $first_name = $row['first_name'];
    $middle_name = $row['middle_name'];
}

$roles = (new Grabber("select id, local_name from role where id not in (select role_id from user_role where user_id = $id) order by local_name"))->result;
$myroles = (new Grabber("select ur.user_id, ur.role_id, r.local_name from role r inner join user_role ur on r.id = ur.role_id where ur.user_id = $id order by local_name"))->result;
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
                <li><?=$username ?></li>
            </ul>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="p-1">
                            <h1><?=$username ?></h1>
                        </div>
                        <div class="p-1 text-right">
                            <div class="btn-group">
                                <a href="<?=APPLICATION ?>/admin/user/" class="btn btn-outline-dark" title="К списку" data-toggle="tooltip"><i class="fas fa-undo"></i></a>
                                <a href="<?=APPLICATION ?>/admin/user/edit.php?id=<?=$id ?>" class="btn btn-outline-dark" title="Редактировать" data-toggle="tooltip"><i class="fas fa-user-edit"></i></a>
                                <a href="<?=APPLICATION ?>/admin/user/delete.php?id=<?=$id ?>" class="btn btn-outline-dark" title="Удалить" data-toggle="tooltip"><i class="fas fa-trash-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>Логин</th>
                            <td><?=$username ?></td>
                        </tr>
                        <tr>
                            <th>Фамилия</th>
                            <td><?=$last_name ?></td>
                        </tr>
                        <tr>
                            <th>Имя</th>
                            <td><?=$first_name ?></td>
                        </tr>
                        <tr>
                            <th>Отчество</th>
                            <td><?=$middle_name ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-12 col-md-6">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="p-1">
                            <h2>Роли</h2>
                        </div>
                        <div class="p-1">
                            <form method="post" class="form-inline">
                                <input type="hidden" id="user_id" name="user_id" value="<?= filter_input(INPUT_GET, 'id') ?>" />
                                <div class="form-group">
                                    <select id="role_id" name="role_id" class="form-control<?=$role_id_valid ?>" required="required">
                                        <option value="">...</option>
                                        <?php
                                        foreach ($roles as $role) {
                                            $id = $role['id'];
                                            $local_name = $role['local_name'];
                                            echo "<option value='$id'>$local_name</option>";
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">*</div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control" id="create_user_role_submit" name="create_user_role_submit">
                                        <i class="fas fa-plus"></i>&nbsp;Добавить
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <tbody>
                            <?php
                            foreach ($myroles as $row):
                            ?>
                            <tr>
                                <td><?=$row['local_name'] ?></td>
                                <td style="width: 15%;">
                                    <form method="post">
                                        <input type="hidden" id="user_id" name="user_id" value="<?=$row['user_id'] ?>" />
                                        <input type="hidden" id="role_id" name="role_id" value="<?=$row['role_id'] ?>" />
                                        <button type="submit" id="delete_user_role_submit" name="delete_user_role_submit" class="form-control confirmable text-nowrap"><i class="fas fa-trash-alt"></i>&nbsp;Удалить</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>