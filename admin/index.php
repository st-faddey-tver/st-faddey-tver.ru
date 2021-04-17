<?php
include '../include/topscripts.php';

// Авторизация
if(!HasRole()) {
    header('Location: '.APPLICATION.'/admin/login.php');
}
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
        include '../include/pager_top.php';
        ?>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <ul class="breadcrumb">
                <li><a href="<?=APPLICATION ?>/">На главную</a></li>
                <li>Администратор</li>
            </ul>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Администратор</h1>
                </div>
                <div class="p-1">
                    <a href="create.php" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Создать страницу</a>
                </div>
            </div>
            
            <div class="row">
                <div class="col-6">
                    <?php
                    $sql = "select count(id) from page";
                    $fetcher = new Fetcher($sql);
                    if($row = $fetcher->Fetch()) {
                        $pager_total_count = $row[0];
                    }
                    
                    $sql = "select name, shortname, inmenu from page order by inmenu desc, name asc limit $pager_skip, $pager_take";
                    $fetcher = new Fetcher($sql);
                    while ($row = $fetcher->Fetch()):
                    $bg_class = $row['inmenu'] == 1 ? "bg-warning" : "bg-white";
                    ?>
                    <p><a class="<?=$bg_class ?>" href="details.php?shortname=<?=$row['shortname'] ?>"><?=$row['name'] ?></a></p>
                    <?php
                    endwhile;
                    ?>
                    <hr/>
                    <p>О храме</p>
                    <ul>
                        <li><a href="page.php?shortname=history">История</a></li>
                        <li>
                            Святые храма
                            <ul>
                                <li><a href="page.php?shortname=vera_truks">Вера Трукс</a></li>
                                <li><a href="page.php?shortname=ilya_benemansky">Илья Бенеманский</a></li>
                                <li><a href="page.php?shortname=ilya_gromoglasov">Илья Громогласов</a></li>
                                <li><a href="page.php?shortname=nikolay_maslov">Николай Маслов</a></li>
                                <li><a href="page.php?shortname=faddey_uspensky">Фаддей Успенский</a></li>
                            </ul>
                        </li>
                        <li><a href="page.php?shortname=schedule">Расписание богослужений</a></li>
                        <li><a href="page.php?shortname=clergy">Духовенство</a></li>
                        <li><a href="news/<?= BuildQuery('is_event', 1) ?>">Все события</a></li>
                        <li><a href="news/<?= BuildQuery('is_event', 0) ?>">Все новости</a></li>
                    </ul>
                    <p>Молодёжь храма</p>
                    <ul>
                        <li><a href="page.php?shortname=volunteer">Добровольческое движение</a></li>
                        <li><a href="page.php?shortname=club">Молодёжный клуб &laquo;Встреча&raquo;</a></li>
                        <li><a href="page.php?shortname=family">Семейный клуб</a></li>
                        <li><a href="page.php?shortname=cinema">Синематографический клуб</a></li>
                    </ul>
                    <p>Образовательный центр</p>
                    <ul>
                        <li><a href="page.php?shortname=sunday">Воскресная школа</a></li>
                        <li><a href="page.php?shortname=preparation">Курсы подготовки к поступлению в семинарию</a></li>
                    </ul>
                    <p><a href="page.php?shortname=pilgrimage">Паломничество</a></p>
                    <p><a href="page.php?shortname=contact">Контакты</a></p>
                    <p><a href="page.php?shortname=donation">Пожертвовать</a></p>
                </div>
                <div class="col-6">
                    <p><a href="event/">Все события</a>
                    <p><a href="news/">Все новости</a></p>
                </div>
            </div>
            <?php
            include '../include/pager_bottom.php';
            ?>
        </div>
        <?php
        include 'include/footer.php';
        ?>
    </body>
</html>