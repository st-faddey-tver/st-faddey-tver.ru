<?php
include '../include/topscripts.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Создание периода
if(null !== filter_input(INPUT_POST, 'period_create_submit')) {
    $start_date = filter_input(INPUT_POST, 'start_date');
    $name = filter_input(INPUT_POST, 'name');
    
    if(empty($start_date)) {
        $error_message = "Начальная дата обязательно.";
    }
    else if(empty($name)) {
        $error_message = "Наименование обязательно";
    }
    else {
        $name = addslashes($name);
        $sql = "insert into schedule_period (start_date, name) values ('$start_date', '$name')";
        $error_message = (new Executer($sql))->error;
    }
}

// Удаление периода
if(null !== filter_input(INPUT_POST, 'period_delete_submit')) {
    $id = filter_input(INPUT_POST, 'id');
    $sql = "delete from schedule_period where id = $id";
    $error_message = (new Executer($sql))->error;
}

// Создание даты
if(null !== filter_input(INPUT_POST, 'date_create_submit')) {
    $schedule_period_id = filter_input(INPUT_POST, 'schedule_period_id');
    $date = filter_input(INPUT_POST, 'date');
    
    if(empty($date)) {
        $error_message = "Дата обязательно.";
    }
    else {
        $sql = "insert into schedule_date (schedule_period_id, date) values ($schedule_period_id, '$date')";
        $error_message = (new Executer($sql))->error;
    }
}

// Удаление даты
if(null !== filter_input(INPUT_POST, 'date_delete_submit')) {
    $id = filter_input(INPUT_POST, 'id');
    $sql = "delete from schedule_date where id = $id";
    $error_message = (new Executer($sql))->error;
}

// Создание праздника
if(null !== filter_input(INPUT_POST, 'holiday_create_submit')) {
    $schedule_date_id = filter_input(INPUT_POST, 'schedule_date_id');
    $name = filter_input(INPUT_POST, 'name');
    
    if(empty($name)) {
        $error_message = "Наименование праздника обязательно.";
    }
    else {
        $name = addslashes($name);
        $sql = "insert into schedule_holiday (schedule_date_id, name) values ($schedule_date_id, '$name')";
        $error_message = (new Executer($sql))->error;
    }
}

// Удаление праздника
if(null !== filter_input(INPUT_POST, 'holiday_delete_submit')) {
    $id = filter_input(INPUT_POST, 'id');
    $sql = "delete from schedule_holiday where id = $id";
    $error_message = (new Executer($sql))->error;
}

// Создание времени
if(null !== filter_input(INPUT_POST, 'time_create_submit')) {
    $schedule_date_id = filter_input(INPUT_POST, 'schedule_date_id');
    $time = filter_input(INPUT_POST, 'time');
    $endtime = empty(filter_input(INPUT_POST, 'endtime')) ? 'NULL' : "'".filter_input(INPUT_POST, 'endtime')."'";
    $temple_id = filter_input(INPUT_POST, 'temple_id');
    
    if(empty($time)) {
        $error_message = "Время обязательно.";
    }
    else {
        $sql = "insert into schedule_time (schedule_date_id, time, endtime, temple_id) values ($schedule_date_id, '$time', $endtime, $temple_id)";
        $error_message = (new Executer($sql))->error;
    }
}

// Удаление времени
if(null !== filter_input(INPUT_POST, 'time_delete_submit')) {
    $id = filter_input(INPUT_POST, 'id');
    $sql = "delete from schedule_time where id = $id";
    $error_message = (new Executer($sql))->error;
}

// Создание службы
if(null !== filter_input(INPUT_POST, 'service_create_submit')) {
    $schedule_time_id = filter_input(INPUT_POST, 'schedule_time_id');
    $name = filter_input(INPUT_POST, 'name');
    
    if(empty($name)) {
        $error_message = "Наименование службы обязательно.";
    }
    else {
        $name = addslashes($name);
        $sql = "insert into schedule_service (schedule_time_id, name) values ($schedule_time_id, '$name')";
        $error_message = (new Executer($sql))->error;
    }
}

// Удаление службы
if(null !== filter_input(INPUT_POST, 'service_delete_submit')) {
    $id = filter_input(INPUT_POST, 'id');
    $sql = "delete from schedule_service where id = $id";
    $error_message = (new Executer($sql))->error;
}

// Получение объекта
$sql = "select sp.id sp_id, sp.start_date, sp.name period, "
        . "sd.id sd_id, sd.date, "
        . "sh.id sh_id, sh.name holiday, "
        . "st.id st_id, st.time, st.endtime, st.temple_id, "
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
                $time['temple_id'] = $row['temple_id'];
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
        <ul class="breadcrumb">
            <li><a href="<?=APPLICATION ?>/">На главную</a></li>
            <li><a href="<?=APPLICATION ?>/admin/">Администратор</a></li>
            <li>Расписание богослужений</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <h1>Расписание богослужений</h1>
            <?php foreach ($periods as $period): ?>
            <hr />
            <h2>
                <?php
                $period_date = DateTime::createFromFormat('Y-m-d', $period['start_date']);
                ?>
                <?=$period['period'] ?>&nbsp;(<?=$period_date->format('j ').$months_genitive[$period_date->format('n')].$period_date->format(' Y г.') ?>)
                <?php if(count($period['dates']) == 0): ?>
                <form method="post" class="form-inline d-inline">
                    <input type="hidden" id="scroll" name="scroll" />
                    <input type="hidden" id="id" name="id" value="<?=$period['id'] ?>" />
                    <div class="btn-group">
                        <button class="btn btn-outline-dark confirmable" type="submit" id="period_delete_submit" name="period_delete_submit" title="Удалить период" data-toggle="tooltip"><i class="fas fa-trash"></i></button>
                    </div>
                </form>
                <?php endif; ?>
            </h2>
            <table class="table">
                <?php
                foreach ($period['dates'] as $date):
                $dDate = DateTime::createFromFormat('Y-m-d', $date['date']);
                ?>
                <thead class="thead-light">
                    <tr>
                        <th class="w-25 align-top"><?=$dDate->format("d.m.Y") ?></th>
                        <th class="align-top"><?=$weekdays[$dDate->format("N")] ?></th>
                        <th class="align-top">
                            <?php foreach ($date['holidays'] as $holiday): ?>
                            <div class="mt-1 mb-1 text-danger">
                                <?=$holiday['holiday'] ?>
                                <form method="post" class="form-inline d-inline">
                                    <input type="hidden" id="scroll" name="scroll" />
                                    <input type="hidden" id="id" name="id" value="<?=$holiday['id'] ?>" />
                                    <button type="submit" id="holiday_delete_submit" name="holiday_delete_submit" class="btn btn-outline-dark confirmable" title="Удалить праздник" data-toggle="tooltip"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                            <?php endforeach; ?>
                            <form method="post">
                                <input type="hidden" id="scroll" name="scroll" />
                                <input type="hidden" id="schedule_date_id" name="schedule_date_id" value="<?=$date['id'] ?>" />
                                <div class="input-group">
                                    <input type="text" maxlength="100" id="name" name="name" class="form-control" placeholder="Добавить праздник" required="required" />
                                    <div class="input-group-append">
                                        <button type="submit" id="holiday_create_submit" name="holiday_create_submit" class="btn btn-outline-dark" title="Добавить праздник" data-toggle="tooltip"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </form>
                        </th>
                        <th class="text-right align-top">
                            <?php if(count($date['times']) == 0 && count($date['holidays']) == 0): ?>
                            <form method="post">
                                <input type="hidden" id="scroll" name="scroll" />
                                <input type="hidden" id="id" name="id" value="<?=$date['id'] ?>" />
                                <div class="btn-group">
                                    <button class="btn btn-outline-dark confirmable" type="submit" id="date_delete_submit" name="date_delete_submit" title="Удалить дату" data-toggle="tooltip"><i class="fas fa-trash"></i></button>
                                </div>
                            </form>
                            <?php endif; ?>
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
                    $tTempleId = $time['temple_id'];
                    ?>
                    <tr>
                        <td class="align-top"><?=$tTime->format('H:i') ?><?= empty($tEndTime) ? '' : '&nbsp;&ndash;&nbsp;'.$tEndTime->format('H:i') ?> (<?=TEMPLE_NAMES[$tTempleId] ?>)</td>
                        <td class="align-top" colspan="2">
                            <?php foreach ($time['services'] as $service): ?>
                            <div class="mt-1 mb-1">
                                <?=$service['service'] ?>
                                <form method="post" class="form-inline d-inline">
                                    <input type="hidden" id="scroll" name="scroll" />
                                    <input type="hidden" id="id" name="id" value="<?=$service['id'] ?>" />
                                    <button type="submit" id="service_delete_submit" name="service_delete_submit" class="btn btn-outline-dark confirmable" title="Удалить службу" data-toggle="tooltip"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                            <?php endforeach; ?>
                            <form method="post">
                                <input type="hidden" id="scroll" name="scroll" />
                                <input type="hidden" id="schedule_time_id" name="schedule_time_id" value="<?=$time['id'] ?>" />
                                <div class="input-group">
                                    <input type="text" maxlength="100" id="name" name="name" class="form-control" placeholder="Добавить службу" required="required" />
                                    <div class="input-group-append">
                                        <button type="submit" id="service_create_submit" name="service_create_submit" class="btn btn-outline-dark" title="Добавить службу" data-toggle="tooltip"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </form>
                        </td>
                        <td class="text-right align-top">
                            <?php if(count($time['services']) == 0): ?>
                            <form method="post">
                                <input type="hidden" id="scroll" name="scroll" />
                                <input type="hidden" id="id" name="id" value="<?=$time['id'] ?>" />
                                <div class="btn-group">
                                    <button class="btn btn-outline-dark confirmable" type="submit" id="time_delete_submit" name="time_delete_submit" title="Удалить время" data-toggle="tooltip"><i class="fas fa-trash"></i></button>
                                </div>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4">
                            <form method="post" class="form-inline">
                                <input type="hidden" id="scroll" name="scroll" />
                                <input type="hidden" id="schedule_date_id" name="schedule_date_id" value="<?=$date['id'] ?>" />
                                <input type="time" id="time" name="time" class="form-control" required="required" />
                                <input type="time" id="endtime" name="endtime" class="form-control" />
                                <div class="input-group">
                                    <select name="temple_id" class="form-control">
                                        <?php foreach (TEMPLE_NAMES as $key => $value): ?>
                                        <option value="<?=$key ?>"><?=$value ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="input-group-append">
                                        <button type="submit" id="time_create_submit" name="time_create_submit" class="btn btn-outline-dark" title="Добавить время" data-toggle="tooltip"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </form>
                        </td>
                    </tr>
                </tbody>
                <?php endforeach; ?>
                <thead class="thead-light">
                    <tr>
                        <th colspan="4">
                            <form method="post" class="form-inline">
                                <input type="hidden" id="scroll" name="scroll" />
                                <input type="hidden" id="schedule_period_id" name="schedule_period_id" value="<?=$period['id'] ?>" />
                                <div class="input-group">
                                    <input type="date" id="date" name="date" class="form-control" required="required" />
                                    <div class="input-group-append">
                                        <button type="submit" id="date_create_submit" name="date_create_submit" class="btn btn-outline-dark" title="Добавить дату" data-toggle="tooltip"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </form>
                        </th>
                    </tr>
                </thead>
            </table>
            <?php endforeach; ?>
            <hr />
            <form method="post" class="form-inline">
                <input type="hidden" id="scroll" name="scroll" />
                <div class="form-group">
                    <label for="start_date">Начальная дата</label>
                    <input type="date" id="start_date" name="start_date" class="form-control ml-2 mr-2" required="required" />
                </div>
                <div class="form-group">
                    <label for="name">Наименование</label>
                    <input type="text" maxlength="50" id="name" name="name" class="form-control ml-2 mr-2" required="required" />
                </div>
                <button type="submit" id="period_create_submit" name="period_create_submit" class="btn btn-outline-dark" title="Добавить период" data-toggle="tooltip"><i class="fas fa-plus"></i>&nbsp;Добавить период</button>
            </form>
        </div>
        <?php
        include 'include/footer.php';
        ?>
    </body>
</html>