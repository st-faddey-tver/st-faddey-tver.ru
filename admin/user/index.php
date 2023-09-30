<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
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
        <ul class="breadcrumb">
            <li><a href="<?=APPLICATION ?>/">На главную</a></li>
            <li><a href="<?=APPLICATION ?>/admin/">Администратор</a></li>
            <li>Пользователи</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
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
                            . "(select group_concat(distinct role_id separator ',') from user_role ur where user_id = u.id) roles "
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
                        <td>
                            <?php
                            $role_ids = explode(',', $row['roles']);
                            $role_local_names = array();
                            foreach ($role_ids as $role_id) {
                                array_push($role_local_names, ROLE_LOCAL_NAMES[$role_id]);
                            }
                            echo implode(', ', $role_local_names);
                            ?>
                        </td>
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