<?php
include '../include/topscripts.php';
$title = "Песнопения по алфавиту";
$description = "На нашем приходе каждая церковная служба сопровождается общенародным пением прихожан совместно с хором. Это способствует лучшему пониманию службы, а также единению в молитве и усилению соборного духа православного народа. На нашем сайте мы публикуем тексты песнопений, которые поются прихожанами на службах в нашем храме.";
$keywords = "общенародное пение, тексты песнопений";
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
        <div class="container">
            <div class="content bigfont">
                <?php
                if(!empty($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                ?>
                <h1>Песнопения по алфавиту</h1>
                <p>На нашем приходе каждая церковная служба сопровождается общенародным пением прихожан совместно с хором. Это способствует лучшему пониманию службы, а также единению в молитве и усилению соборного духа православного народа. На нашем сайте мы публикуем тексты песнопений, которые поются прихожанами на службах в нашем храме.</p>
                <hr />
                <?php
                $sql = "select beginning, shortname from cantus order by beginning";
                $fetcher = new Fetcher($sql);
                
                while($row = $fetcher->Fetch()):
                    $beginning = $row['beginning'];
                    $shortname = $row['shortname'];
                ?>
                <p class="news_name mb-4"><a href="<?=APPLICATION."/cantus/".$shortname ?>"><?=$beginning ?>...</a></p>
                <?php endwhile; ?>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>