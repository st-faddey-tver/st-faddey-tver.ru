<?php
include '../../include/topscripts.php';
include '../../include/page/page.php';

// Авторизация
if(!IsInRole(array('history', 'admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

$page = new Page("history");
$page->Top();
$error_message = $page->errorMessage;
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        include '../include/head.php';
        $page->Head();
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
                <li>История</li>
            </ul>
            <div class="container" style="margin-left: 0;">
                <div class="content">
                    <h1>О храме</h1>
                    <h2>История</h2>
                    <?php
                    $page->GetFragments();
                    ?>
                </div>
            </div>
            <?php
            $page->ShowCreateFragmentForm();
            ?>
        </div>
        <?php
        include '../include/footer.php';
        $page->Footer();
        ?>
    </body>
</html>