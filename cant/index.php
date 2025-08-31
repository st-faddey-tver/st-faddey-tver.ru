<?php
include '../include/topscripts.php';
$title = "Общенародное пение";
$description = "На нашем приходе каждая церковная служба сопровождается общенародным пением прихожан совместно с хором. Это способствует лучшему пониманию службы, а также единению в молитве и усилению соборного духа православного народа. На нашем сайте мы публикуем тексты песнопений, которые поются прихожанами на службах в нашем храме.";
$keywords = "общенародное пение, тексты песнопений";

const SORT_BEGINNING = 0;
const SORT_TYPE = 1;
const SORT_TONE = 2;
const SORT_DATE = 3;

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
                        <th class="text-nowrap">
                            Начальные слова
                            <?php if($sort == SORT_BEGINNING): ?>
                            <i class="fas fa-arrow-down" style="color: black; font-size: large;"></i>
                            <?php else: ?>
                            <a href="<?= APPLICATION."/cantus/". BuildQueryRemove('sort') ?>"><i class="fas fa-arrow-down" style="font-size: medium;"></i></a>
                            <?php endif; ?>
                        </th>
                        <th class="text-nowrap">
                            Тип
                            <?php if($sort == SORT_TYPE): ?>
                            <i class="fas fa-arrow-down" style="color: black; font-size: large;"></i>
                            <?php else: ?>
                            <a href="<?= BuildQuery('sort', SORT_TYPE) ?>"><i class="fas fa-arrow-down" style="font-size: medium;"></i></a>
                            <?php endif; ?>
                        </th>
                        <th class="text-nowrap">
                            Глас
                            <?php if($sort == SORT_TONE): ?>
                            <i class="fas fa-arrow-down" style="color: black; font-size: large;"></i>
                            <?php else: ?>
                            <a href="<?= BuildQuery('sort', SORT_TONE) ?>"><i class="fas fa-arrow-down" style="font-size: medium;"></i></a>
                            <?php endif; ?>
                        </th>
                        <th>
                            Дата
                            <?php if($sort == SORT_DATE): ?>
                            <i class="fas fa-arrow-down" style="color: black; font-size: large;"></i>
                            <?php else: ?>
                            <a href="<?= BuildQuery('sort', SORT_DATE) ?>"><i class="fas fa-arrow-down" style="font-size: medium;"></i></a>
                            <?php endif; ?>
                        </th>
                    </tr>
                    <?php
                    $order = "beginning";
                    if($sort == SORT_TYPE) {
                        $order = "type, tone, month, day";
                    }
                    elseif($sort == SORT_TONE) {
                        $order = "tone, type, month, day";
                    }
                    elseif($sort == SORT_DATE) {
                        $order = "month, day, tone, type";
                    }
                    $sql = "select beginning, shortname, type, ifnull(tone, 9) as tone, ifnull(month, 13) as month, day from cantus order by $order";
                    $fetcher = new Fetcher($sql);
                    
                    while($row = $fetcher->Fetch()):
                        $beginning = htmlentities($row['beginning'] ?? '');
                        $shortname = $row['shortname'];
                        $type = $row['type'];
                        $tone = $row['tone'];
                        $month = $row['month'];
                        $day = $row['day'];
                    ?>
                    <tr>
                        <td><a href="<?=APPLICATION."/cantus/".$shortname ?>"><?=$beginning ?>...</a></td>
                        <td><?=CANT_TYPE_NAMES[$type] ?></td>
                        <td><?=(empty($tone) || $tone > 8) ? '' : $tone ?></td>
                        <td class="text-nowrap"><?=(empty($month) || empty($day) || !key_exists($month, MONTH_GENETIVES)) ? '' : $day.' '.MONTH_GENETIVES[$month] ?></td>
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