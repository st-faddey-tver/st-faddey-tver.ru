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

// Создание дня
if(null !== filter_input(INPUT_POST, 'day_create_submit')) {
    $schedule_period_id = filter_input(INPUT_POST, 'schedule_period_id');
    $date = filter_input(INPUT_POST, 'date');
    
    if(empty($date)) {
        $error_message = "Дата обязательно.";
    }
    else {
        $sql = "insert into schedule_day (schedule_period_id, date) values ($schedule_period_id, '$date')";
        $error_message = (new Executer($sql))->error;
    }
}

// Получение объекта
$sql = "select sp.id sp_id, sp.start_date, sp.name period, sd.id sd_id, sd.date, ss.id ss_id, ss.time, ss.name service "
        . "from schedule_period sp "
        . "left join schedule_day sd on sd.schedule_period_id = sp.id "
        . "left join schedule_service ss on ss.schedule_day_id = sd.id "
        . "order by sp.start_date, sd.date, ss.time";
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
        $period['days'] = array();
        $periods[$sp_id] = $period;
    }
    else {
        $period = $periods[$sp_id];
    }
    $days = $period['days'];
    
    $sd_id = $row['sd_id'];
    if(!empty($sd_id)) {
        if(!array_key_exists($sd_id, $days)) {
            $day = array();
            $day['id'] = $sd_id;
            $day['date'] = $row['date'];
            $day['services'] = array();
            $days[$sd_id] = $day;
            $period['days'] = $days;
            $periods[$sp_id] = $period;
        }
        else {
            $day = $days[$sd_id];
        }
        $services = $day['services'];
        
        $ss_id = $row['ss_id'];
        if(!empty($ss_id)) {
            $service = array();
            $service['id'] = $ss_id;
            $service['time'] = $row['time'];
            $service['service'] = $row['service'];
            $services[$ss_id] = $service;
            $day['services'] = $services;
            $days[$sd_id] = $day;
            $period['days'] = $days;
            $periods[$sp_id] = $period;
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
            <h2><?=$period['period'] ?>&nbsp;(<?= DateTime::createFromFormat('Y-m-d', $period['start_date'])->format('d.m.Y') ?>)<a href="period_edit.php<?= BuildQuery('id', $period['id']) ?>" class="ml-2 mr-2 btn btn-outline-dark"><i class="fas fa-edit"></i></a><a href="period_delete.php<?= BuildQuery('id', $period['id']) ?>" class="btn btn-outline-dark"><i class="fas fa-trash"></i></a></h2>
            <table class="table">
                <?php foreach ($period['days'] as $day): ?>
                <thead class="thead-light">
                    <tr>
                        <th><?=$day['date'] ?></th>
                        <th></th>
                        <th></th>
                        <th>
                            <div class="btn-group">
                                <a class="btn btn-outline-dark" href="day_edit.php<?= BuildQuery('id', $day['id']) ?>"><i class="fas fa-edit"></i></a>
                                <a class="btn btn-outline-dark" href="day_delete.php<?= BuildQuery('id', $day['id']) ?>"><i class="fas fa-trash"></i></a>
                            </div>
                        </th>
                    </tr>
                </thead>
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
                                <button type="submit" id="day_create_submit" name="day_create_submit" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Добавить день</button>
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
                    <input type="text" id="name" name="name" class="form-control ml-2 mr-2" required="required" />
                </div>
                <button type="submit" id="period_create_submit" name="period_create_submit" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Добавить период</button>
            </form>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>