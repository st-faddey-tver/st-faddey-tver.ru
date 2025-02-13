<?php
include '../include/topscripts.php';
$title = "Храм священномученика Фаддея архиепископа Тверского, приходские заметки";
$description = "Приходские заметки храма священномученика Фаддея архиепископа Тверского";
$keywords = "Приходские заметки храма святого Фаддея";
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
        include '../include/pager_top.php';
        ?>
        <div class="container">
            <div class="content">
                <?php
                if(!empty($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                ?>
                <h1>Приходские заметки</h1>
                <?php
                include '../include/pager_bottom.php';
                ?>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>