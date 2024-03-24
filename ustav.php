<?php
include 'include/topscripts.php';
$title = "Видеолекции Е. С. Кустовского";
$description = "Видеолекции Евгения Сергеевича Кустовского из группы @posledovanie 'в контакте', а также из канала @KustUstav 'телеграм' с разрешения автора";
$keywords = "богослужебный устав, лекции по богослужебному уставу, Е. С. Кустовский, Евгений Сергеевич Кустовский";
$image = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].APPLICATION."/images/kustovsky.jpg";
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
        include 'include/pager_top.php';
        ?>
        <div class="container">
            <div class="content bigfont">
                <?php
                if(!empty($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                ?>
                <h1>Видеолекции Е. С. Кустовского</h1>
                <p>Евгений Сергеевич Кустовский - регент с огромным стажем и опытом, создатель и руководитель <a href="https://regentskiekursy.ru/" target="_blank" title="Отделения церковного пения и регентования Православного гуманитарного института 'Со-действие'">Отделения церковного пения и регентования Православного гуманитарного института &laquo;Со-действие&raquo;</a>. Курсы существуют с 1989 года, и ранее назывались Московские Православные Регентские Курсы.</p>
                <p>За 30 лет Евгений Сергеевич обучил не одну сотню регентов (его ученики служат не только в Москве и Подмосковье, но и за рубежом), подготовил и выпустил много сборников для клироса и учебных пособий.</p>
                <?php
                $event_type_ustav = EVENT_TYPE_USTAV;
                $sql = "select count(id) from event where event_type_id = $event_type_ustav and visible = 1";
                $fetcher = new Fetcher($sql);
                $error_message = $fetcher->error;
                
                if($row = $fetcher->Fetch()) {
                    $pager_total_count = $row[0];
                }
                
                $sql = "select date, body from event where event_type_id = $event_type_ustav and visible = 1 order by date desc, id desc limit $pager_skip, $pager_take";
                $fetcher = new Fetcher($sql);
                
                while ($row = $fetcher->Fetch()) {
                    $date = $row['date'];
                    $body = $row['body'];
                    echo "<hr style='clear: both' />";
                    // echo "<div style='font-size: smaller; font-style: italic;'>".DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y')."</div>";
                    echo $body;
                }
                ?>
                <br style="clear: both;" />
                <?php
                include 'include/pager_bottom.php';
                ?>
            </div>
        </div>
        <?php
        include 'include/footer.php';
        ?>
    </body>
</html>