<?php
include '../include/topscripts.php';
$title = "Общенародное пение";
$description = "На нашем приходе каждая церковная служба сопровождается общенародным пением прихожан совместно с хором. Это способствует лучшему пониманию службы, а также единению в молитве и усилению соборного духа православного народа. На нашем сайте мы публикуем тексты песнопений, которые поются прихожанами на службах в нашем храме.";
$keywords = "общенародное пение, тексты песнопений";

const SORT_BEGINNING = 0;
const SORT_NAME = 1;
const SORT_CYCLE = 2;

$sort = filter_input(INPUT_GET, 'sort') ?? SORT_BEGINNING;
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
                <h1>Общенародное пение</h1>
                <p class="d-none">На нашем приходе каждая церковная служба сопровождается общенародным пением прихожан совместно с хором. Это способствует лучшему пониманию службы, а также единению в молитве и усилению соборного духа православного народа. На этом сайте мы публикуем тексты песнопений, которые поются прихожанами на службах в нашем храме.</p>
                <table class="table">
                    <tr>
                        <th>
                            Начало
                            <?php if($sort == SORT_BEGINNING): ?>
                            <i class="fas fa-arrow-down" style="color: black; font-size: large;"></i>
                            <?php else: ?>
                            <a href="<?= APPLICATION."/cantus/". BuildQueryRemove('sort') ?>"><i class="fas fa-arrow-down" style="font-size: medium;"></i></a>
                            <?php endif; ?>
                        </th>
                        <th>
                            Наименование
                            <?php if($sort == SORT_NAME): ?>
                            <i class="fas fa-arrow-down" style="color: black; font-size: large;"></i>
                            <?php else: ?>
                            <a href="<?= BuildQuery('sort', SORT_NAME) ?>"><i class="fas fa-arrow-down" style="font-size: medium;"></i></a>
                            <?php endif; ?>
                        </th>
                        <th>
                            Круг
                            <span class="text-nowrap">
                            богослужений
                            <?php if($sort == SORT_CYCLE): ?>
                            <i class="fas fa-arrow-down" style="color: black; font-size: large;"></i>
                            <?php else: ?>
                            <a href="<?= BuildQuery('sort', SORT_CYCLE) ?>"><i class="fas fa-arrow-down" style="font-size: medium;"></i></a>
                            <?php endif; ?>
                            </span>
                        </th>
                    </tr>
                    <?php
                    $order = "beginning";
                    if($sort == SORT_NAME) {
                        $order = "name";
                    }
                    elseif($sort == SORT_CYCLE) {
                        $order = "cycle, month, day, tone, position";
                    }
                    $sql = "select beginning, shortname, name, cycle, tone, month, day from cantus order by $order";
                    $fetcher = new Fetcher($sql);
                    
                    while($row = $fetcher->Fetch()):
                        $beginning = htmlentities($row['beginning'] ?? '');
                        $shortname = $row['shortname'];
                        $name = htmlentities($row['name'] ?? '');
                        $cycle = $row['cycle'];
                        $tone = $row['tone'];
                        $month = $row['month'];
                        $day = $row['day'];
                    ?>
                    <tr>
                        <td><a href="<?=APPLICATION."/cantus/".$shortname ?>"><?=$beginning ?>...</a></td>
                        <td><a href="<?=APPLICATION."/cantus/".$shortname ?>"><?=$name ?></a></td>
                        <td><?=CYCLE_NAMES[$cycle] ?><?=$cycle == CYCLE_WEEKLY ? ", <span class='text-nowrap'>гл. $tone</span>" : "" ?><?=$cycle == CYCLE_YEARLY || $cycle == CYCLE_EASTER ? ", <span class='text-nowrap'>$day ".MONTH_GENETIVES[$month]."</span>" : "" ?></td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>