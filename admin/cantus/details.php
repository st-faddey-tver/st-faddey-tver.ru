<?php
include '../../include/topscripts.php';
//include '../../include/news/news.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если нет параметра id, переходим к списку
$id = filter_input(INPUT_GET, 'id'); echo "ID = $id --- <br />";
if(empty($id)) {
    header('Location: '.APPLICATION."/admin/cantus/");
}

// Получение объекта
$beginning = '';
$name = '';
$shortname = '';
$cycle_id = null;
$tone = null;
$month = null;
$day = null;
$number = null;

$sql = "select beginning, name, shortname, cycle_id, tone, month, day, number from cantus where id = $id";
$fetcher = new Fetcher($sql);
$error_message = $fetcher->error;

if($row = $fetcher->Fetch()) {
    $beginning = $row['beginning'];
    $name = $row['name'];
    $shortname = $row['shortname'];
    $cycle_id = $row['cycle_id'];
    $tone = $row['tone'];
    $month = $row['month'];
    $day = $row['day'];
    $number = $row['number'];
}

// Фрагменты
//$news = new News($id);
//$news->Top();
//$error_message = $news->errorMessage;
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
            <li><a href="<?=APPLICATION ?>/admin/cantus/">Песнопения по алфавиту</a></li>
            <li><?=$name ?></li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1><?=$name ?></h1>
                </div>
                <div class="p-1">
                    <?php
                    if(filter_input(INPUT_GET, 'mode') == 'edit'):
                    ?>
                    <a href="<?= BuildQueryRemove("mode") ?>" class="btn btn-outline-dark" title="В обычный режим" data-toggle="tooltip"><i class="fas fa-undo-alt"></i>&nbsp;В обычный режим</a>
                    <?php
                    else:
                    ?>
                    <div class="btn-group">
                        <a href="<?=APPLICATION ?>/admin/cantus/" class="btn btn-outline-dark" title="К списку" data-toggle="tooltip"><i class="fas fa-undo-alt"></i></a>
                        <a href="edit.php<?= BuildQuery('id', $id) ?>" class="btn btn-outline-dark" title="Редактировать" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                        <a href="<?= BuildQuery("mode", "edit") ?>" class="btn btn-outline-dark" title="Редактировать содержимое" data-toggle="tooltip"><i class="fas fa-scroll"></i></a>
                        <a href="delete.php<?= BuildQuery('id', $id) ?>" class="btn btn-outline-dark" title="Удалить" data-toggle="tooltip"><i class="fas fa-trash-alt"></i></a>
                    </div>
                    <?php
                    endif;
                    ?>
                </div>
            </div>
            <table class="table">
                <tr><td>Начало</td><td><?=$beginning ?></td></tr>
                <tr><td>Краткое наименование</td><td><?=$shortname ?></td></tr>
                <tr><td>Круг богослужений</td><td><?=CYCLE_NAMES[$cycle_id] ?></td></tr>
                <tr><td>Глас</td><td><?=$tone ?></td></tr>
                <tr><td>Месяц / день (юлианск.)</td><td><?=MONTH_NAMES[$month]." / ".$day ?></td></tr>
                <tr><td>Номер по порядку</td><td><?=$number ?></td></tr>
            </table>
            <div class="container" style="margin-left: 0;">
                <div class="content bigfont">
                    <hr />
                    <h2>Изображения</h2>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>