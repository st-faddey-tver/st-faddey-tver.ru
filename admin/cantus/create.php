<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Валидация формы
$form_valid = true;
$error_message = '';

$beginning_valid = '';
$name_valid = '';
$shortname_valid = '';
$cycle_id_valid = '';

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'cantus_create_submit')) {
    if(empty(filter_input(INPUT_POST, 'beginning'))) {
        $beginning_valid = ISINVALID;
        $form_valid = false;
    }
    
    if(empty(filter_input(INPUT_POST, 'name'))) {
        $name_valid = ISINVALID;
        $form_valid = false;
    }
    
    if(!empty(filter_input(INPUT_POST, 'shortname')) && !filter_var(filter_input(INPUT_POST, 'shortname'), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-z0-9]+([._]?[a-z0-9]+)*$/")))) {
        $shortname_valid = ISINVALID;
        $form_valid = false;
    }
    
    if(empty(filter_input(INPUT_POST, 'cycle_id'))) {
        $cycle_id_valid = ISINVALID;
        $form_valid = false;
    }
    
    if($form_valid) {
        $beginning = addslashes(filter_input(INPUT_POST, 'beginning'));
        $name = addslashes(filter_input(INPUT_POST, 'name'));
        $shortname = addslashes(filter_input(INPUT_POST, 'shortname'));
        $cycle_id = filter_input(INPUT_POST, 'cycle_id');
        $tone = filter_input(INPUT_POST, 'tone'); if(empty($tone)) { $tone = "NULL"; }
        $month = filter_input(INPUT_POST, 'month'); if(empty($month)) { $month = "NULL"; }
        $day = filter_input(INPUT_POST, 'day'); if(empty($day)) { $day = "NULL"; }
        $number = filter_input(INPUT_POST, 'number');
        $title = filter_input(INPUT_POST, 'title');
        $description = addslashes(filter_input(INPUT_POST, 'description'));
        $keywords = addslashes(filter_input(INPUT_POST, 'keywords'));
        
        if(empty($shortname)) {
            $shortname = Romanize($name);
        }
        
        if(empty($shortname)) {
            $shortname = time().'_'.$shortname;
        }
        
        $shortnames_count = 1;
        
        do {
            $sql = "select count(id) shortnames_count from news where shortname = '$shortname'";
            $fetcher = new Fetcher($sql);
            $error_message = $fetcher->error;
            
            if($row = $fetcher->Fetch()) {
                $shortnames_count = $row['shortnames_count'];
            }
            
            if($shortnames_count > 0) {
                $shortname = strval(time());
            }
        }while ($shortnames_count > 0);
        
        $sql = "insert into cantus (beginning, name, shortname, cycle_id, tone, month, day, number, title, description, keywords) values ('$beginning', '$name', '$shortname', $cycle_id, $tone, $month, $day, $number, '$title', '$description', '$keywords')";
        $executer = new Executer($sql);
        $error_message = $executer->error;
        $insert_id = $executer->insert_id;
        
        if(empty($error_message)) {
            header('Location: '.APPLICATION."/admin/cantus/details.php".BuildQuery('id', $insert_id));
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
        <ul class="breadcrumb">
            <li><a href="<?=APPLICATION ?>/">На главную</a></li>
            <li><a href="<?=APPLICATION ?>/admin/">Администратор</a></li>
            <li><a href="<?=APPLICATION ?>/admin/cantus/">Песнопения по алфавиту</a></li>
            <li>Новое песнопение</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Новое песнопение</h1>
                </div>
                <div class="p-1">
                    <a href="<?=APPLICATION ?>/admin/cantus/" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Отмена</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <form method="post">
                        <div class="form-group">
                            <label for="beginning">Начало<span class="text-danger">*</span></label>
                            <input type="text" id="beginning" name="beginning" class="form-control<?=$beginning_valid ?>" value="<?= filter_input(INPUT_POST, 'beginning') ?>" required="required" />
                            <div class="invalid-feedback">Начало обязательно</div>
                        </div>
                        <div class="form-group">
                            <label for="name">Заголовок<span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control<?=$name_valid ?>" value="<?= filter_input(INPUT_POST, 'name') ?>" required="required" />
                            <div class="invalid-feedback">Заголовок обязательно</div>
                        </div>
                        <div class="form-group">
                            <label for="shortname">Краткое наименование (только маленькие латинские буквы, точка или подчёркивание)</label>
                            <input type="text" id="shortname" name="shortname" class="form-control<?=$shortname_valid ?>" value="<?= filter_input(INPUT_POST, 'shortname') ?>" />
                            <div class="invalid-feedback">Только маленькие латинские буквы, точка или подчёркивание. Можно поле оставить пустым.</div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="cycle_id">Круг богослужений<span class="text-danger">*</span></label>
                                    <select id="cycle_id" name="cycle_id" class="form-control<?=$cycle_id_valid ?>" title="Круг богослужений" required="required">
                                        <option value="" hidden="">...</option>
                                        <?php foreach (CYCLES as $cycle): ?>
                                        <option value="<?=$cycle ?>"<?= filter_input(INPUT_POST, 'cycle_id') == $cycle ? " selected='selected'" : "" ?>><?=CYCLE_NAMES[$cycle] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">Круг богослужений обязательно</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="tone">Глас</label>
                                    <input type="number" min="1" max="8" id="tone" name="tone" class="form-control" value="<?= filter_input(INPUT_POST, 'tone') ?>" />
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="number">Порядковый номер</label>
                                    <input type="number" min="0" id="number" name="number" class="form-control" value="<?= filter_input(INPUT_POST, 'number') ?? 0 ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="month">Месяц (юлианск.)</label>
                                    <select id="month" name="month" class="form-control" title="Месяц (юлианск.)">
                                        <option value="">...</option>
                                        <?php foreach (MONTHS as $month): ?>
                                        <option value="<?=$month ?>"<?= filter_input(INPUT_POST, 'month') == $month ? " selected='selected'" : "" ?>><?=MONTH_NAMES[$month] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="day">День (юлианск.)</label>
                                    <input type="number" min="1" max="31" id="day" name="day" class="form-control" value="<?= filter_input(INPUT_POST, 'day') ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" class="form-control" value="<?= htmlentities(filter_input(INPUT_POST, 'title')) ?>" />
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" class="form-control" rows="7"><?= htmlentities(filter_input(INPUT_POST, 'description')) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="keywords">Keywords</label>
                            <textarea id="keywords" name="keywords" class="form-control" rows="7"><?= htmlentities(filter_input(INPUT_POST, 'keywords')) ?></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="cantus_create_submit" name="cantus_create_submit" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Создать</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>