<?php
include 'include/topscripts.php';
include 'include/page/page.php';
$page = new Page(filter_input(INPUT_GET, 'shortname'));
$title = $page->title;
$description = $page->description;
$keywords = $page->keywords;
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
                echo "<h1>$page->name</h1>";
                $page->GetFragments();
                ?>
            </div>
        </div>
        <?php
        include 'include/footer.php';
        ?>
    </body>
</html>