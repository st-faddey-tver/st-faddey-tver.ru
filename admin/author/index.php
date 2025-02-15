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
            <li>Авторы</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Авторы</h1>
                </div>
                <div class="p-1">
                    <a href="create.php" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Создать автора</a>
                </div>
            </div>
            <table class="table">
            <?php
            $sql = "select id, holy_order, last_name, first_name, middle_name from author order by last_name, first_name, middle_name";
            $fetcher = new Fetcher($sql);
            $error_message = $fetcher->error;
            
            while ($row = $fetcher->Fetch()):
            ?>
                <tr>
                    <td><?= empty($row['holy_order']) ? '' : HOLY_ORDER_NAMES[$row['holy_order']] ?></td>
                    <td><?=$row['last_name'] ?></td>
                    <td><?=$row['first_name'] ?></td>
                    <td><?=$row['middle_name'] ?></td>
                    <td class="text-right">
                        <a href="details.php<?= BuildQuery("id", $row['id']) ?>" class="btn btn-outline-dark"><i class="fas fa-info-circle"></i>&nbsp;Подробнее...</a>
                    </td>
                </tr>
            <?php
            endwhile;
            ?>
            </table>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>