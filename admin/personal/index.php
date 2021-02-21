<?php
include '../../include/topscripts.php';

// Авторизация
if(!HasRole()) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Получение личных данных
$row = (new Fetcher("select username, last_name, first_name, middle_name from user where id=". GetUserId()))->Fetch();
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
            
            $password = filter_input(INPUT_GET, 'password');
            
            if($password == 'true') {
                echo "<div class='alert alert-info'>Пароль успешно изменён</div>";
            }
            ?>
            <ul class="breadcrumb">
                <li><a href="<?=APPLICATION ?>/">На главную</a></li>
                <li><a href="<?=APPLICATION ?>/admin/">Администратор</a></li>
                <li>Личные данные</li>
            </ul>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="p-1">
                            <h1>Личные данные</h1>
                        </div>
                        <div class="p-1">
                            <div class="btn-group">
                                <a href="<?=APPLICATION ?>/admin/personal/edit.php" class="btn btn-outline-dark" title="Редактировать" data-toggle="tooltip"><i class="fas fa-user-edit"></i></a>
                                <a href="<?=APPLICATION ?>/admin/personal/password.php" class="btn btn-outline-dark" title="Сменить пароль" data-toggle="tooltip"><i class="fas fa-key"></i></a>
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
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>