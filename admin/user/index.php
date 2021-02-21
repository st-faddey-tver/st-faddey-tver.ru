<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array('admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
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
                <li>Пользователи</li>
            </ul>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Пользователи</h1>
                </div>
                <div class="p-1">
                    <a href="create.php" class="btn btn-outline-dark mr-2">
                        <i class="fas fa-user-plus"></i>&nbsp;Создать
                    </a>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Зарегистрирован</th>
                        <th>Логин</th>
                        <th>Фамилия</th>
                        <th>Имя</th>
                        <th>Отчество</th>
                        <th>Роли</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "select u.id, date_format(u.date, '%d.%m.%Y') date, u.username, u.last_name, u.first_name, u.middle_name, "
                            . "(select group_concat(distinct r.local_name separator ', ') from role r inner join user_role ur on ur.role_id = r.id where ur.user_id = u.id) roles "
                            . "from user u order by u.last_name asc";
                    $fetcher = new Fetcher($sql);
                    $error_message = $fetcher->error;
                    
                    while ($row = $fetcher->Fetch()):
                    ?>
                    <tr>
                        <td><?=$row['date'] ?></td>
                        <td><?=$row['username'] ?></td>
                        <td><?= htmlentities($row['last_name']) ?></td>
                        <td><?= htmlentities($row['first_name']) ?></td>
                        <td><?= htmlentities($row['middle_name']) ?></td>
                        <td><?= htmlentities($row['roles']) ?></td>
                        <td><a href="details.php?id=<?=$row['id'] ?>" class="btn btn-outline-dark" title="Подробно" data-toggle="tooltip"><i class="fas fa-user"></i></a></td>
                    </tr>
                    <?php
                    endwhile;
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>