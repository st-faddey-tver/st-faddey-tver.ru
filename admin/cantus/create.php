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
$cycle_valid = '';
$type_valid = '';

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
    
    if(empty(filter_input(INPUT_POST, 'cycle'))) {
        $cycle_valid = ISINVALID;
        $form_valid = false;
    }
    
    if(empty(filter_input(INPUT_POST, 'type'))) {
        $type_valid = ISINVALID;
        $form_valid = false;
    }
    
    if($form_valid) {
        $beginning = addslashes(filter_input(INPUT_POST, 'beginning'));
        $name = addslashes(filter_input(INPUT_POST, 'name'));
        $shortname = addslashes(filter_input(INPUT_POST, 'shortname'));
        $cycle = filter_input(INPUT_POST, 'cycle');
        $type = filter_input(INPUT_POST, 'type');
        $tone = filter_input(INPUT_POST, 'tone'); if(empty($tone)) { $tone = "NULL"; }
        $month = filter_input(INPUT_POST, 'month'); if(empty($month)) { $month = "NULL"; }
        $day = filter_input(INPUT_POST, 'day'); if(empty($day)) { $day = "NULL"; }
        $position = filter_input(INPUT_POST, 'position');
        $mini_image1 = filter_input(INPUT_POST, 'mini_image1');
        $image1 = filter_input(INPUT_POST, 'image1');
        $mini_image2 = filter_input(INPUT_POST, 'mini_image2');
        $image2 = filter_input(INPUT_POST, 'image2');
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
        
        $sql = "insert into cantus (beginning, name, shortname, cycle, type, tone, month, day, position, mini_image1, image1, mini_image2, image2, title, description, keywords) values ('$beginning', '$name', '$shortname', $cycle, $type, $tone, $month, $day, $position, '$mini_image1', '$image1', '$mini_image2', '$image2', '$title', '$description', '$keywords')";
        $executer = new Executer($sql);
        $error_message = $executer->error;
        $insert_id = $executer->insert_id;
        
        if(empty($error_message)) {
            header('Location: '.APPLICATION."/admin/cantus/details.php".BuildQuery('shortname', $shortname));
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
            <li><a href="<?=APPLICATION ?>/admin/cantus/">Общенародное пение</a></li>
            <li>Новая страница</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Новая страница</h1>
                </div>
                <div class="p-1">
                    <a href="<?=APPLICATION ?>/admin/cantus/" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Отмена</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <form method="post">
                        <div class="form-group">
                            <label for="beginning">Начальные слова<span class="text-danger">*</span></label>
                            <input type="text" id="beginning" name="beginning" class="form-control<?=$beginning_valid ?>" value="<?= htmlentities(filter_input(INPUT_POST, 'beginning') ?? '') ?>" required="required" />
                            <div class="invalid-feedback">Начальные слова обязательно</div>
                        </div>
                        <div class="form-group">
                            <label for="name">Наименование<span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control<?=$name_valid ?>" value="<?= htmlentities(filter_input(INPUT_POST, 'name') ?? '') ?>" required="required" />
                            <div class="invalid-feedback">Наименование обязательно</div>
                        </div>
                        <div class="form-group">
                            <label for="shortname">Краткое наименование (только маленькие латинские буквы, точка или подчёркивание)</label>
                            <input type="text" id="shortname" name="shortname" class="form-control<?=$shortname_valid ?>" value="<?= filter_input(INPUT_POST, 'shortname') ?>" />
                            <div class="invalid-feedback">Только маленькие латинские буквы, точка или подчёркивание. Можно поле оставить пустым.</div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="cycle">Круг богослужений<span class="text-danger">*</span></label>
                                    <select id="cycle" name="cycle" class="form-control<?=$cycle_valid ?>" title="Круг богослужений" required="required">
                                        <option value="" hidden="hidden">...</option>
                                        <?php foreach (CYCLES as $item): ?>
                                        <option value="<?=$item ?>"<?= filter_input(INPUT_POST, 'cycle') == $item ? " selected='selected'" : "" ?>><?=CYCLE_NAMES[$item] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">Круг богослужений обязательно</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="type">Тип песнопения<span class="text-danger">*</span></label>
                                    <select id="type" name="type" class="form-control" title="Тип песнопения" required="required">
                                        <option value="" hidden="hidden">...</option>
                                        <?php foreach(CANT_TYPES as $item): ?>
                                        <option value="<?=$item ?>"<?= filter_input(INPUT_POST, 'type') == $item ? " selected='selected'" : "" ?>><?=CANT_TYPE_NAMES[$item] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">Тип песнопения обязательно</div>
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
                                    <label for="position">Порядковый номер</label>
                                    <input type="number" min="0" id="position" name="position" class="form-control" value="<?= filter_input(INPUT_POST, 'position') ?? 0 ?>" />
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
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="mini_image1">Мини-изображение 1</label>
                                    <input type="text" id="mini_image1" name="mini_image1" class="form-control" value="<?= filter_input(INPUT_POST, 'mini_image1') ?>" />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="image1">Изображение 1</label>
                                    <input type="text" id="image1" name="image1" class="form-control" value="<?= filter_input(INPUT_POST, 'image1') ?>" />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="mini_image2">Мини-изображение 2</label>
                                    <input type="text" id="mini_image2" name="mini_image2" class="form-control" value="<?= filter_input(INPUT_POST, 'mini_image2') ?>" />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="image2">Изображение 2</label>
                                    <input type="text" id="image2" name="image2" class="form-control" value="<?= filter_input(INPUT_POST, 'image2') ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" class="form-control" value="<?= htmlentities(filter_input(INPUT_POST, 'title') ?? '') ?>" />
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" class="form-control" rows="7"><?= htmlentities(filter_input(INPUT_POST, 'description') ?? '') ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="keywords">Keywords</label>
                            <textarea id="keywords" name="keywords" class="form-control" rows="7"><?= htmlentities(filter_input(INPUT_POST, 'keywords') ?? '') ?></textarea>
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