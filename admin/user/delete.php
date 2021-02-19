<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array('admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'delete_user_submit')) {
    $id = filter_input(INPUT_POST, 'id');
    if(GetUserId() != $id) {
        $error_message = (new Executer("delete from user_role where user_id=$id"))->error;
        
        if(empty($error_message)) {
            $error_message = (new Executer("delete from user where id=$id"))->error;
            
            if(empty($error_message)) {
                header('Location: '.APPLICATION.'/admin/user/');
            }
        }
    }
}

// Если нет параметра id, переходим к списку
if(null == filter_input(INPUT_GET, 'id')) {
    header('Location: '.APPLICATION.'/admin/user/');
}

// Получение объекта
$id = filter_input(INPUT_GET, 'id');
$row = (new Fetcher("select username, last_name, first_name, middle_name from user where id=$id"))->Fetch();
$username = $row['username'];
$last_name = $row['last_name'];
$first_name = $row['first_name'];
$middle_name = $row['middle_name'];
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
                <li><a href="<?=APPLICATION ?>/admin/user/details.php?id=<?=$id ?>"><?=$username ?></a></li>
                <li>Удаление пользователя</li>
            </ul>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="p-1">
                            <h1 class="text-danger">Действительно удалить?</h1>
                        </div>
                        <div class="p-1">
                            <a href="<?=APPLICATION ?>/admin/user/details.php?id=<?=$id ?>" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Отмена</a>
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
                    <form method="post">
                        <input type="hidden" id="id" name="id" value="<?= filter_input(INPUT_GET, 'id') ?>" />
                        <button type="submit" id="delete_user_submit" name="delete_user_submit" class="btn btn-danger">Удалить</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>