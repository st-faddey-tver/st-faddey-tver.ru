<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array('admin'))) {
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

// Создание времени
if(null !== filter_input(INPUT_POST, 'time_create_submit')) {
    $schedule_date_id = filter_input(INPUT_POST, 'schedule_date_id');
    $time = filter_input(INPUT_POST, 'time');
    
    if(empty($time)) {
        $error_message = "Время обязательно.";
    }
    else {
        $sql = "insert into schedule_time (schedule_date_id, time) values ($schedule_date_id, '$time')";
        $error_message = (new Executer($sql))->error;
    }
}

// Получение объекта
$sql = "select sp.id sp_id, sp.start_date, sp.name period, sd.id sd_id, sd.date, st.id st_id, st.time, ss.id ss_id, ss.name service "
        . "from schedule_period sp "
        . "left join schedule_date sd on sd.schedule_period_id = sp.id "
        . "left join schedule_time st on st.schedule_date_id = sd.id "
        . "left join schedule_service ss on ss.schedule_time_id = st.id "
        . "order by sp.start_date, sd.date, st.time";
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
            $date['times'] = array();
            $dates[$sd_id] = $date;
            $period['dates'] = $dates;
            $periods[$sp_id] = $period;
        }
        else {
            $date = $dates[$sd_id];
        }
        $times = $date['times'];
        
        $st_id = $row['st_id'];
        if(!empty($st_id)) {
            if(!array_key_exists($st_id, $times)) {
                $time = array();
                $time['id'] = $st_id;
                $time['time'] = $row['time'];
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
        include '../include/head.php';
        ?>
    </head>
    <body>
        <?php
        include '../include/header.php';
        ?>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <ul class="breadcrumb">
                <li><a href="<?=APPLICATION ?>/">На главную</a></li>
                <li><a href="<?=APPLICATION ?>/admin/">Администратор</a></li>
                <li>Расписание богослужений</li>
            </ul>
            <h1>Расписание богослужений</h1>
            <?php foreach ($periods as $period): ?>
            <hr />
            <h2>
                <?=$period['period'] ?>&nbsp;(<?= DateTime::createFromFormat('Y-m-d', $period['start_date'])->format('d.m.Y') ?>)
                <form method="post" class="form-inline d-inline">
                    <input type="hidden" id="scroll" name="scroll" />
                    <input type="hidden" id="id" name="id" value="<?=$period['id'] ?>" />
                    <div class="btn-group">
                        <a class="btn btn-outline-dark" href="period_edit.php<?= BuildQuery('id', $period['id']) ?>"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-outline-dark confirmable" type="submit" id="period_delete_submit" name="period_delete_submit"><i class="fas fa-trash"></i></button>
                    </div>
                </form>
            </h2>
            <table class="table">
                <?php
                foreach ($period['dates'] as $date):
                $dDate = DateTime::createFromFormat('Y-m-d', $date['date']);
                ?>
                <thead class="thead-light">
                    <tr>
                        <th class="w-25"><?=$dDate->format("d.m.Y") ?></th>
                        <th><?=$weekdays[$dDate->format("N")] ?></th>
                        <th></th>
                        <th class="text-right">
                            <form method="post">
                                <input type="hidden" id="scroll" name="scroll" />
                                <input type="hidden" id="id" name="id" value="<?=$date['id'] ?>" />
                                <div class="btn-group">
                                    <a class="btn btn-outline-dark" href="date_edit.php<?= BuildQuery('id', $date['id']) ?>"><i class="fas fa-edit"></i></a>
                                    <button class="btn btn-outline-dark confirmable" type="submit" id="date_delete_submit" name="date_delete_submit"><i class="fas fa-trash"></i></button>
                                </div>
                            </form>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($date['times'] as $time):
                    $tTime = DateTime::createFromFormat("H:i:s", $time['time']);
                    ?>
                    <tr>
                        <td><?=$tTime->format('H:i') ?></td>
                        <td colspan="2"></td>
                        <td class="text-right">
                            <form method="post">
                                <input type="hidden" id="scroll" name="scroll" />
                                <input type="hidden" id="id" name="id" value="<?=$time['id'] ?>" />
                                <div class="btn-group">
                                    <a class="btn btn-outline-dark" href="service_edit.php<?= BuildQuery('id', $time['id']) ?>"><i class="fas fa-edit"></i></a>
                                    <button class="btn btn-outline-dark confirmable" type="submit" id="time_delete_submit" name="time_delete_submit"><i class="fas fa-trash"></i></button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4">
                            <form method="post" class="form-inline">
                                <input type="hidden" id="scroll" name="scroll" />
                                <input type="hidden" id="schedule_date_id" name="schedule_date_id" value="<?=$date['id'] ?>" />
                                <div class="form-group">
                                    <label for="time">Время</label>
                                    <input type="time" id="time" name="time" class="form-control ml-2 mr-2" required="required" />
                                </div>
                                <button type="submit" id="time_create_submit" name="time_create_submit" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Добавить время</button>
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
                                <div class="form-group">
                                    <label for="date">Дата</label>
                                    <input type="date" id="date" name="date" class="form-control ml-2 mr-2" required="required" />
                                </div>
                                <button type="submit" id="date_create_submit" name="date_create_submit" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Добавить дату</button>
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
                <button type="submit" id="period_create_submit" name="period_create_submit" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Добавить период</button>
            </form>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>