<?php
include '../include/topscripts.php';
include '../include/page/page.php';

// Авторизация
if(!IsInRole(array('admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если нет параметра shortname, переходим к списку
$shortname = filter_input(INPUT_GET, 'shortname');
if(empty($shortname)) {
    header('Location: '.APPLICATION.'/admin/');
}

$page = new Page($shortname);
$page->Top();
$error_message = $page->errorMessage;
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        include 'include/head.php';
        ?>
    </head>
    <body>
        <?php
        include 'include/header.php';
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
                <li><?=$page->name ?></li>
            </ul>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1><?=$page->name ?></h1>
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
                        <a href="<?=APPLICATION ?>/admin/" class="btn btn-outline-dark" title="К списку" data-toggle="tooltip"><i class="fas fa-undo-alt"></i></a>
                        <a href="edit.php<?= BuildQuery("id", $page->id) ?>" class="btn btn-outline-dark" title="Редактировать" data-toggle="tooltip"><i class="fas fa-edit"></i></i></a>
                        <a href="<?= BuildQuery("mode", "edit") ?>" class="btn btn-outline-dark" title="Редактировать содержимое" data-toggle="tooltip"><i class="fas fa-scroll"></i></a>
                        <?php if(!$page->inmenu): ?>
                        <a href="delete.php<?= BuildQuery("shortname", $page->shortname) ?>" class="btn btn-outline-dark" title="Удалить" data-toggle="tooltip"><i class="fas fa-trash-alt"></i></a>
                        <?php endif; ?>
                    </div>
                    <?php
                    endif;
                    ?>
                </div>
            </div>
            <div class="container" style="margin-left: 0;">
                <div class="content bigfont">
                    <?php
                    if(filter_input(INPUT_GET, 'mode') == 'edit') {
                        $page->GetFragmentsEditMode();
                    }
                    else {
                        $page->GetFragments();
                    }
                    
                    $page->ShowCreateFragmentForm();
                    
                    if(filter_input(INPUT_GET, 'mode') != 'edit'):
                    ?>
                    <hr />
                    <h2>Изображения</h2>
                    <?php
                    $page->GetImages();
                    ?>
                    <div class="row">
                        <div class="col-8">
                            <?php
                            $page->ShowUploadImageForm();
                            ?>
                        </div>
                    </div>
                    <?php
                    endif;
                    ?>
                </div>
            </div>
        </div>
        <?php
        include 'include/footer.php';
        ?>
    </body>
</html>