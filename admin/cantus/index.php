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
            <li>Каталог-классификатор песнопений и их плакатов</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Каталог-классификатор песнопений и их плакатов</h1>
                </div>
                <div class="p-1">
                    <a href="create.php" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Создать страницу</a>
                </div>
            </div>
            <div class="container" style="margin-left: 0;">
                <div class="content bigfont">
                    <?php
                    $sql = "select beginning, shortname from cantus order by beginning";
                    $fetcher = new Fetcher($sql);
                    $error_message = $fetcher->error;
                    
                    while($row = $fetcher->Fetch()):
                    $beginning = $row['beginning'];
                    $shortname = $row['shortname'];
                    ?>
                    <p><a href="details.php<?= BuildQuery('shortname', $shortname) ?>"><?=$beginning ?></a></p>
                    <?php
                    endwhile;
                    ?>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>