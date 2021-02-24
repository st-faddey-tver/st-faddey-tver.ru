<?php
include '../../include/topscripts.php';
include '../../include/page/page.php';

// Авторизация
if(!IsInRole(array('contact', 'admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

$page = new Page("contact");
$page->Top();
$error_message = $page->errorMessage;
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
                <li>Контакты</li>
            </ul>
            <div class="container" style="margin-left: 0;">
                <div class="content">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="p-1">
                            <h1>Контакты</h1>
                        </div>
                        <div class="p-1">
                            <?php
                            if(filter_input(INPUT_GET, 'mode') == 'edit'):
                            ?>
                            <a href="<?=APPLICATION ?>/admin/pages/contact.php" class="btn btn-outline-dark" title="Выход из редактирования" data-toggle="tooltip"><i class="fas fa-undo-alt"></i></a>
                            <?php
                            else:
                            ?>
                            <a href="<?=APPLICATION ?>/admin/pages/contact.php?mode=edit" class="btn btn-outline-dark" title="Редактировать" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                            <?php
                            endif;
                            ?>
                        </div>
                    </div>
                    <?php
                    if(filter_input(INPUT_GET, 'mode') == 'edit') {
                        $page->GetFragmentsEditMode();
                    }
                    else {
                        $page->GetFragments();
                    }
                    
                    $page->ShowCreateFragmentForm();
                    ?>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>