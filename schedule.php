<?php
include 'include/topscripts.php';
$title = "Расписание богослужений";
$description = "Расписание богослужений храма священномученика Фаддея архиепископа Тверского";
$keywords = "расписание богослужений, расписание богослужений храма святого Фаддея, расписание богослужений церкви святого Фаддея";

// Получение объекта
$sql = "select sp.id sp_id, sp.start_date, sp.name period, "
        . "sd.id sd_id, sd.date, "
        . "sh.id sh_id, sh.name holiday, "
        . "st.id st_id, st.time, st.endtime, "
        . "ss.id ss_id, ss.name service "
        . "from schedule_period sp "
        . "left join schedule_date sd on sd.schedule_period_id = sp.id "
        . "left join schedule_holiday sh on sh.schedule_date_id = sd.id "
        . "left join schedule_time st on st.schedule_date_id = sd.id "
        . "left join schedule_service ss on ss.schedule_time_id = st.id "
        . "order by sp.start_date, sd.date, sh.id, st.time, st.endtime, ss.id";
$grabber = new Grabber($sql);
$schedule = $grabber->result;
$error_message = $grabber->error;

$periods = array();

foreach ($schedule as $row) {
    $sp_id = $row['sp_id'];
    if(!array_key_exists($sp_id, $periods)) {
        $period = array();
        $period['id'] = $sp_id;
        $period['period'] = $row['period'];
        $period['start_date'] = $row['start_date'];
        $period['dates'] = array();
        $periods[$sp_id] = $period;
    }
    else {
        $period = $periods[$sp_id];
    }
    $dates = $period['dates'];
    
    $sd_id = $row['sd_id'];
    if(!empty($sd_id)) {
        if(!array_key_exists($sd_id, $dates)) {
            $date = array();
            $date['id'] = $sd_id;
            $date['date'] = $row['date'];
            $date['holidays'] = array();
            $date['times'] = array();
            $dates[$sd_id] = $date;
            $period['dates'] = $dates;
            $periods[$sp_id] = $period;
        }
        else {
            $date = $dates[$sd_id];
        }
        $holidays = $date['holidays'];
        $times = $date['times'];
        
        $sh_id = $row['sh_id'];
        if(!empty($sh_id)) {
            if(!array_key_exists($sh_id, $holidays)) {
                $holiday = array();
                $holiday['id'] = $sh_id;
                $holiday['holiday'] = $row['holiday'];
                $holidays[$sh_id] = $holiday;
                $date['holidays'] = $holidays;
                $dates[$sd_id] = $date;
                $period['dates'] = $dates;
                $periods[$sp_id] = $period;
            }
        }
        
        $st_id = $row['st_id'];
        if(!empty($st_id)) {
            if(!array_key_exists($st_id, $times)) {
                $time = array();
                $time['id'] = $st_id;
                $time['time'] = $row['time'];
                $time['endtime'] = $row['endtime'];
                $time['services'] = array();
                $times[$st_id] = $time;
                $date['times'] = $times;
                $dates[$sd_id] = $date;
                $period['dates'] = $dates;
                $periods[$sp_id] = $period;
            }
            else {
                $time = $times[$st_id];
            }
            $services = $time['services'];
            
            $ss_id = $row['ss_id'];
            if(!empty($ss_id)) {
                $service = array();
                $service['id'] = $ss_id;
                $service['service'] = $row['service'];
                $services[$ss_id] = $service;
                $time['services'] = $services;
                $times[$st_id] = $time;
                $date['times'] = $times;
                $dates[$sd_id] = $date;
                $period['dates'] = $dates;
                $periods[$sp_id] = $period;
            }
        }
    }
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
        ?>
        <div class="container">
            <div class="content bigfont">
                <?php
                if(!empty($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                ?>
                <h1>Расписание богослужений</h1>
                <?php foreach ($periods as $period): ?>
                <hr />
                <h2><?=$period['period'] ?></h2>
                <table class="table">
                    <?php
                    foreach ($period['dates'] as $date):
                    $dDate = DateTime::createFromFormat ('Y-m-d', $date['date']);
                    ?>
                    <thead class="thead-light">
                        <tr class="d-none d-md-table-row">
                            <th class="w-25 align-top"><?=$dDate->format('j ').$months_genitive[$dDate->format('n')].$dDate->format(' Y г.') ?></th>
                            <th class="align-top"><?=$weekdays[$dDate->format("N")] ?></th>
                            <th class="align-top">
                                <?php foreach ($date['holidays'] as $holiday): ?>
                                <div class="text-danger"><?=$holiday['holiday'] ?></div>
                                <?php endforeach; ?>
                            </th>
                        </tr>
                        <tr class="d-table-row d-md-none">
                            <th>
                                <div class="d-block font-italic"><?=$dDate->format('j ').$months_genitive[$dDate->format('n')].$dDate->format(' Y г.') ?></div>
                                <div class="d-block"><?=$weekdays[$dDate->format("N")] ?></div>
                                <?php foreach ($date['holidays'] as $holiday): ?>
                                <div class="text-danger d-block"><?=$holiday['holiday'] ?></div>
                                <?php endforeach; ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($date['times'] as $time):
                        $tTime = DateTime::createFromFormat("H:i:s", $time['time']);
                        $tEndTime = null;
                        if(!empty($time['endtime'])) {
                            $tEndTime = DateTime::createFromFormat("H:i:s", $time['endtime']);
                        }
                        ?>
                        <tr class="d-none d-md-table-row">
                            <td class="align-top w-25"><?=$tTime->format('H:i') ?><?= empty($tEndTime) ? '' : '&nbsp;&ndash;&nbsp;'.$tEndTime->format('H:i') ?></td>
                            <td class="align-top" colspan="2">
                                <?php foreach ($time['services'] as $service): ?>
                                <div><?=$service['service'] ?></div>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <tr class="d-table-row d-md-none">
                            <td>
                                <div class="d-block font-italic"><?=$tTime->format('H:i') ?><?= empty($tEndTime) ? '' : '&nbsp;&ndash;&nbsp;'.$tEndTime->format('H:i') ?></div>
                                <?php foreach ($time['services'] as $service): ?>
                                <div class="d-block"><?=$service['service'] ?></div>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <?php endforeach; ?>
                </table>
                <?php endforeach; ?>
                <hr />
            </div>
        </div>
        <?php
        include 'include/footer.php';
        ?>
    </body>
</html>