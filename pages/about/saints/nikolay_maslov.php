<?php
include '../../../include/topscripts.php';
include '../../../include/page/page.php';
$page = new Page("nikolay_maslov");
?>
<!doctype html>
<html>
    <head>
        <?php
        include '../../../include/head.php';
        ?>
    </head>
    <body>
        <?php
        include '../../../include/header.php';
        ?>
        <div class="container">
            <div class="content">
                <?php
                if(!empty($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                ?>
                <h1>Святые храма, Николай Маслов</h1>
                <?php
                $page->GetFragments();
                ?>
            </div>
        </div>
        <?php
        include '../../../include/footer.php';
        ?>
    </body>
</html>