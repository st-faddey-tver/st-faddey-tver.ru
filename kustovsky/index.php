<?php
include '../include/topscripts.php';
$title = "Видеолекции Е. С. Кустовского";
$description = "Видеолекции Е. С. Кустовского";
$keywords = "Видеолекции Е. С. Кустовского";
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        include '../include/head.php';
        ?>
        <style>
            .news_name {
                font-size: 1.4rem;
            }
        </style>
    </head>
    <body>
        <?php
        include '../include/header.php';
        ?>
        <div class="container">
            <div class="content">
                <?php
                if(!empty($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                ?>
                <h1>Видеолекции Е. С. Кустовского</h1>
                <p>Евгений Сергеевич Кустовский &ndash; регент с огромным стажем и опытом, создатель и руководитель <a href="https://regentskiekursy.ru/" target="_blank" title="Отделения церковного пения и регентования Православного гуманитарного института 'Со-действие'">Отделения церковного пения и регентования Православного гуманитарного института &laquo;Со-действие&raquo;</a>. Курсы существуют с 1989 года, и ранее назывались Московские Православные Регентские Курсы.</p>
                <p>За 30 лет Евгений Сергеевич обучил не одну сотню регентов (его ученики служат не только в Москве и Подмосковье, но и за рубежом), подготовил и выпустил много сборников для клироса и учебных пособий.</p>
                <p>Лекции публикуются с согласия автора.</p>
                <p><img style='height: 1.8rem; width: auto;' src='https://st-faddey-tver.ru/documents/VK_Compact_Logo.svg' title='ВКонтакте' /><a href='https://vk.com/regentskiekursy' title='ВКонтакте' target='_blank'>https://vk.com/regentskiekursy</a></p>
                <hr />
                <?php
                $news_type_id = NEWS_TYPE_USTAV;
                $sql = "select date, name, shortname, body from news where news_type_id = $news_type_id and visible = 1 order by date desc, id desc";
                $fetcher = new Fetcher($sql);
                    
                while ($row = $fetcher->Fetch()):
                $date = $row['date'];
                $name = $row['name'];
                $shortname = $row['shortname'];
                $body = $row['body'];
                ?>
                <p class="news_name mb-4"><a href="<?=APPLICATION."/ustav/".$shortname ?>"><?=$name ?></a></p>
                <?php
                endwhile;
                ?>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>

