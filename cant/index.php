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
        <style>
            table.table tr td {
                padding: 0.4rem;
            }
        </style>
    </head>
    <body>
        <?php
        include '../include/header.php';
        ?>
        <div id="mini_image" class="d-none" style="position: absolute; width: 700px; z-index: 200;">
            <img id="mini_image_img" alt="Плакат" class="img-fluid" />
        </div>
        <div class="container">
            <div class="content">
                <?php
                if(!empty($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                ?>
                <h1><a name="header">Общенародное пение</a></h1>
                <p class="d-none">На нашем приходе каждая церковная служба сопровождается общенародным пением прихожан совместно с хором. Это способствует лучшему пониманию службы, а также единению в молитве и усилению соборного духа православного народа. На этом сайте мы публикуем тексты песнопений, которые поются прихожанами на службах в нашем храме.</p>
                <table class="table">
                    <tr>
                        <th class="text-nowrap">
                            Начальные слова
                            <?php if($sort == SORT_BEGINNING): ?>
                            <i class="fas fa-arrow-down" style="color: black; font-size: large;"></i>
                            <?php else: ?>
                            <a href="<?= APPLICATION."/cantus/". BuildQueryRemove('sort')."#header" ?>"><i class="fas fa-arrow-down" style="font-size: medium;"></i></a>
                            <?php endif; ?>
                        </th>
                        <th class="text-nowrap">
                            Тип
                            <?php if($sort == SORT_TYPE): ?>
                            <i class="fas fa-arrow-down" style="color: black; font-size: large;"></i>
                            <?php else: ?>
                            <a href="<?= BuildQuery('sort', SORT_TYPE)."#header" ?>"><i class="fas fa-arrow-down" style="font-size: medium;"></i></a>
                            <?php endif; ?>
                        </th>
                        <th class="text-nowrap">
                            Глас
                            <?php if($sort == SORT_TONE): ?>
                            <i class="fas fa-arrow-down" style="color: black; font-size: large;"></i>
                            <?php else: ?>
                            <a href="<?= BuildQuery('sort', SORT_TONE)."#header" ?>"><i class="fas fa-arrow-down" style="font-size: medium;"></i></a>
                            <?php endif; ?>
                        </th>
                        <th>
                            Дата
                            <?php if($sort == SORT_DATE): ?>
                            <i class="fas fa-arrow-down" style="color: black; font-size: large;"></i>
                            <?php else: ?>
                            <a href="<?= BuildQuery('sort', SORT_DATE)."#header" ?>"><i class="fas fa-arrow-down" style="font-size: medium;"></i></a>
                            <?php endif; ?>
                        </th>
                        <th></th>
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
                    $sql = "select beginning, shortname, type, ifnull(tone, 9) as tone, ifnull(month, 13) as month, day, mini_image1, image1, mini_image2, image2 from cantus where visible = 1 order by $order";
                    $fetcher = new Fetcher($sql);
                    
                    while($row = $fetcher->Fetch()):
                        $beginning = htmlentities($row['beginning'] ?? '');
                        $shortname = $row['shortname'];
                        $type = $row['type'];
                        $tone = $row['tone'];
                        $month = $row['month'];
                        $day = $row['day'];
                        $mini_image1 = $row['mini_image1'];
                        $image1 = $row['image1'];
                        $mini_image2 = $row['mini_image2'];
                        $image2 = $row['image2'];
                    ?>
                    <tr>
                        <td><a href="<?=APPLICATION."/cantus/".$shortname ?>"><?=$beginning ?>...</a></td>
                        <td><?=CANT_TYPE_NAMES[$type] ?></td>
                        <td><?=(empty($tone) || $tone > 8) ? '' : $tone ?></td>
                        <td class="text-nowrap"><?=(empty($month) || empty($day) || !key_exists($month, MONTH_GENETIVES)) ? '' : $day.' '.MONTH_GENETIVES[$month] ?></td>
                        <td class="text-nowrap">
                            <?php if(!empty($mini_image1) && !empty($image1)): ?>
                            <a title="Скачать плакат" data-toggle="tooltip" data-placement="right" target="_blank" href="<?=$image1 ?>"><i class="fa fa-file-image" style="font-size: large;" onmouseenter="javascript: MouseEnterPlakat(event, '<?=$mini_image1 ?>');" onmouseout="javascript: MouseOutPlakat();"></i></a>
                            <?php endif; ?>
                            <?php if(!empty($mini_image2) && !empty($image2)): ?>
                            <a title="Скачать плакат" data-toggle="tooltip" data-placement="right" target="_blank" href="<?=$image2 ?>"><i class="fa fa-file-image" style="font-size: large;" onmouseenter="javascript: MouseEnterPlakat(event, '<?=$mini_image2 ?>');" onmouseout="javascript: MouseOutPlakat();"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
    <script>
        function MouseEnterPlakat(event, src) {
            $('#mini_image_img').attr('src', src);
            $('#mini_image').css('top', (event.pageY - 100) + 'px');
            $('#mini_image').css('left', (event.pageX - 750) + 'px');
            $('#mini_image').removeClass('d-none');
        }
        
        function MouseOutPlakat() {
            $('#mini_image').addClass('d-none');
            $('#mini_image_img').removeAttr('src');
            $('#mini_image').css('top', '');
            $('#mini_image').css('left', '');
        }
    </script>
</html>