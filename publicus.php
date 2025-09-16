<?php
include 'include/topscripts.php';
$title = "Общенародное приходское пение";
$description = "Каталог-классификатор песнопений и их плакатов.";
$keywords = "общенародное пение, приходское пение, тексты песнопений";
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
        <div class="container">
            <div class="content bigfont">
                <?php
                if(!empty($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                ?>
                <h1>Общенародное приходское пение</h1>
                <p><a href="<?=APPLICATION ?>/cantus/">Каталог-классификатор песнопений и их плакатов</a></p>
            </div>
        </div>
        <?php
        include 'include/footer.php';
        ?>
    </body>
</html>