<?php
include '../../include/topscripts.php';
include '../../include/cantus.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если нет параметра shortname, переходим к списку
$shortname = filter_input(INPUT_GET, 'shortname');
if(empty($shortname)) {
    header('Location: '.APPLICATION."/admin/cantus/");
}

// Получение объекта
$cantus = new Cantus($shortname);
$cantus->Top();
$error_message = $cantus->errorMessage;
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
            <li><?=$cantus->name ?></li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1><?=$cantus->name ?></h1>
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
                        <a href="edit.php<?= BuildQueryAddRemove('id', $cantus->id, 'shortname') ?>" class="btn btn-outline-dark" title="Редактировать" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                        <a href="<?= BuildQuery("mode", "edit") ?>" class="btn btn-outline-dark" title="Редактировать содержимое" data-toggle="tooltip"><i class="fas fa-scroll"></i></a>
                        <a href="delete.php<?= BuildQuery('shortname', $cantus->shortname) ?>" class="btn btn-outline-dark" title="Удалить" data-toggle="tooltip"><i class="fas fa-trash-alt"></i></a>
                    </div>
                    <?php
                    endif;
                    ?>
                </div>
            </div>
            <table class="table">
                <tr><td>Начало</td><td><?=$cantus->beginning ?></td></tr>
                <tr><td>Краткое наименование</td><td><?=$cantus->shortname ?></td></tr>
                <tr><td>Круг богослужений</td><td><?=CYCLE_NAMES[$cantus->cycle] ?></td></tr>
                <tr><td>Глас</td><td><?=$cantus->tone ?></td></tr>
                <tr><td>Месяц / день (юлианск.)</td><td><?=(key_exists($cantus->month, MONTH_NAMES) ? MONTH_NAMES[$cantus->month] : "").((!empty($cantus->month) && !empty($cantus->day)) ? " / " : "").$cantus->day ?></td></tr>
                <tr><td>Номер по порядку</td><td><?=$cantus->position ?></td></tr>
            </table>
            <div class="container" style="margin-left: 0;">
                <div class="content bigfont">
                    <?php
                    if(filter_input(INPUT_GET, 'mode') == 'edit') {
                        $cantus->GetFragmentsEditMode();
                    }
                    else {
                        $cantus->GetFragments();
                    }
                    
                    $cantus->ShowCreateFragmentForm();
                    ?>
                </div>
                <?php if(filter_input(INPUT_GET, 'mode') != 'edit'): ?>
                <hr />
                <h2>Изображения</h2>
                <?php $cantus->GetImages(); ?>
                <div class="row">
                    <div class="col-8">
                        <?php $cantus->ShowUploadImageForm(); ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>