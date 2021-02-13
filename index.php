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
            <div class="content">
                <?php
                if(!empty($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                ?>
                <h1>Сайт в разработке</h1>
                <h2>Зайдите через несколько дней.</h2>
                <br/><br/><br/><br/><br/><br/><br/>
            </div>
        </div>
        <?php
        include 'include/footer.php';
        ?>
    </body>
</html>