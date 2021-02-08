<?php
include 'include/topscripts.php';
?>
<!doctype html>
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
        <div class="container">
            <?php
            if(!empty($error_message)) {
               echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <h1>Храм в честь сщмч. Фаддея, архиепископа Тверского</h1>
            <h2>Сайт в разработке. Зайдите через несколько дней.</h2>
        </div>
        <?php
        include 'include/footer.php';
        ?>
    </body>
</html>