<?php
include '../include/topscripts.php';
?>
<!doctype html>
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
            <div class="content">
                <?php
                if(!empty($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                ?>
                <div class="d-flex justify-content-between">
                    <div class="p-1">
                        <h1>Контакты</h1>
                    </div>
                    <div class="p-1">
                        <button class="btn btn-primary"><i class="fas fa-ruble-sign"></i></button>
                    </div>
                </div>
                <table class="table">
                    <tr>
                        <th style="width: 20%;">Адрес</th>
                        <td>170007, г. Тверь, ул. Кропоткина, кладбище Неопалимой Купины</td>
                    </tr>
                    <tr>
                        <th>Телефон</th>
                        <td>+7 904 008-22-24</td>
                    </tr>
                    <tr>
                        <th>E-Mail</th>
                        <td><a href="mailto:st-faddey-tver@yandex.ru">st-faddey-tver@yandex.ru</a></td>
                    </tr>
                    <tr>
                        <th>Группа &laquo;В контакте&raquo;</th>
                        <td><a href="https://vk.com/hram_sv.faddeya" target="_blank">https://vk.com/hram_sv.faddeya</a></td>
                    </tr>
                    <tr>
                        <th>Как добраться</th>
                        <td>
                            <p><strong>1 вариант</strong></p>
                            <p>От &laquo;Тверецкого моста&raquo; через Тьмаку двигаться по улице Академика Туполева на восток. У белого здания с угловой башней и шпилем повернуть направо на улицу Новая Заря. Добраться до Свято-Екатерининского женского монастыря, и около него повернуть налево на улицу Кропоткина. Далее прямо.</p>
                            <p><strong>2 вариант</strong></p>
                            <p>От &laquo;Тверецкого моста&raquo; через Тьмаку двигаться по улице Академика Туполева на восток. У коричневого здания с угловой башней повернуть направо на улицу 1-ю Александра Невского. Двигаться вперёд, пока не закончится асфальтированная дорога. На этом месте будет пересечение с улицей Кропоткина. Повернуть налево. Далее прямо.</p>
                            <p><strong>3 вариант</strong></p>
                            <p>Добраться до Восточного моста, его затверецкой стороны. Храм хорошо виден с моста. Спуститься вниз по каменной лестнице и пройти в западном направлении.</p>
                            <p><strong>4 вариант</strong></p>
                            <p>По Восточному мосту проехать в Затверечье, повернуть направо перед автозаправочной станцией и сразу же снова направо. Ехать вперёд до конца, повернуть направо, проехать под мостом. Далее прямо к храму.</p>
                            <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Ae558ad24cbdb9d87ba4d9324aa21ed9a46a4fd34c478c1a26bd9ab3b0cbbdc9b&amp;width=100%25&amp;height=504&amp;lang=ru_RU&amp;scroll=true"></script>
                        </td>
                    </tr>
                </table>
                
                <br/><br/><br/><br/><br/><br/><br/>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>