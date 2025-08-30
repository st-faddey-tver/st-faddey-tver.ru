<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если нет параметра id, переходим к списку
$id = filter_input(INPUT_GET, 'id');
if(empty($id)) {
    header('Location: '.APPLICATION.'/admin/cantus/');
}

// Валидация формы
$form_valid = true;
$error_message = '';

$beginning_valid = '';
$name_valid = '';
$shortname_valid = '';
$cycle_valid = '';

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, "edit_cantus_submit")) {
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
    
    if($form_valid) {
        $id = filter_input(INPUT_POST, 'id');
        $beginning = addslashes(filter_input(INPUT_POST, "beginning"));
        $name = addslashes(filter_input(INPUT_POST, "name"));
        $shortname = filter_input(INPUT_POST, "shortname");
        $cycle = filter_input(INPUT_POST, "cycle");
        $tone = filter_input(INPUT_POST, "tone"); if(empty($tone)) { $tone = "NULL"; }
        $month = filter_input(INPUT_POST, "month"); if(empty($month)) { $month = "NULL"; }
        $day = filter_input(INPUT_POST, "day"); if(empty($day)) { $day = "NULL"; }
        $position = filter_input(INPUT_POST, "position");
        $title = filter_input(INPUT_POST, "title");
        $description = filter_input(INPUT_POST, "description");
        $keywords = filter_input(INPUT_POST, "keywords");
        
        if(empty($shortname)) {
            $shortname = Romanize($name);
        }
        
        if(empty($shortname)) {
            $shortname = strval(time());
        }
        
        $shortnames_count = 1;
        do {
            $sql = "select count(id) shortnames_count from cantus where shortname = '$shortname' and id <> $id";
            $fetcher = new Fetcher($sql);
            $error_message = $fetcher->error;
            
            if($row = $fetcher->fetch()) {
                $shortnames_count = $row['shortnames_count'];
            }
            
            if($shortnames_count > 0) {
                $shortname = time().'_'.$shortname;
            }
        }while ($shortnames_count > 0);
        
        $sql = "update cantus set beginning = '$beginning', name = '$name', shortname = '$shortname', cycle = $cycle, tone = $tone, month = $month, day = $day, position = $position, title = '$title', description = '$description', keywords = '$keywords' where id = $id";
        $executer = new Executer($sql);
        $error_message = $executer->error;
        
        if(empty($error_message)) {
            header('Location: '.APPLICATION."/admin/cantus/details.php".BuildQuery("shortname", $shortname));
        }
    }
}

// Получение объекта
$sql = "select beginning, name, shortname, cycle, tone, month, day, position, title, description, keywords from cantus where id = $id";
$fetcher = new Fetcher($sql);
$row = $fetcher->Fetch();

$beginning = filter_input(INPUT_POST, 'beginning');
if(empty($beginning)) {
    $beginning = $row['beginning'];
}

$name = filter_input(INPUT_POST, 'name');
if(empty($name)) {
    $name = $row['name'];
}

$shortname = filter_input(INPUT_POST, 'shortname');
if(empty($shortname)) {
    $shortname = $row['shortname'];
}

$old_shortname = $row['shortname'];

$cycle = filter_input(INPUT_POST, 'cycle');
if(empty($cycle)) {
    $cycle = $row['cycle'];
}

$tone = filter_input(INPUT_POST, 'tone');
if(empty($tone)) {
    $tone = $row['tone'];
}

$month = filter_input(INPUT_POST, 'month');
if(empty($month)) {
    $month = $row['month'];
}

$day = filter_input(INPUT_POST, 'day');
if(empty($day)) {
    $day = $row['day'];
}

$position = filter_input(INPUT_POST, 'position');
if(empty($position)) {
    $position = $row['position'];
}

$title = filter_input(INPUT_POST, 'title');
if(empty($title)) {
    $title = $row['title'];
}

$description = filter_input(INPUT_POST, 'description');
if(empty($description)) {
    $description = $row['description'];
}

$keywords = filter_input(INPUT_POST, 'keywords');
if(empty($keywords)) {
    $keywords = $row['keywords'];
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
            <li><a href="<?=APPLICATION ?>/admin/cantus/details.php<?= BuildQuery("shortname", $old_shortname) ?>"><?=$name ?></a></li>
            <li>Редактирование страницы</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Редактирование страницы</h1>
                </div>
                <div class="p-1">
                    <a href="details.php<?= BuildQueryAddRemove("shortname", $old_shortname, 'id') ?>" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Выход</a>
                </div>
            </div>
            <div class="row">
                <div class=" col-12 col-md-6">
                    <form method="post">
                        <input type="hidden" id="id" name="id" value="<?= filter_input(INPUT_GET, 'id') ?>" />
                        <div class="form-group">
                            <label for="beginning">Начальные слова<span class="text-danger">*</span></label>
                            <input type="text" id="beginning" name="beginning" class="form-control<?=$beginning_valid ?>" value="<?= htmlentities($beginning) ?>" required="required" />
                            <div class="invalid-feedback">Начальные слова обязательно</div>
                        </div>
                        <div class="form-group">
                            <label for="name">Наименование<span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control<?=$name_valid ?>" value="<?= htmlentities($name) ?>" required="required" />
                            <div class="invalid-feedback">Наименование обязательно</div>
                        </div>
                        <div class="form-group">
                            <label for="shortname">Краткое наименование (только маленькие латинские буквы, точка или подчёркивание)</label>
                            <input type="text" id="shortname" name="shortname" class="form-control<?=$shortname_valid ?>" value="<?= htmlentities($shortname) ?>" />
                            <div class="invalid-feedback">Только маленькие латинские буквы, цифры, точка и подчёркивание</div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="cycle">Круг богослужений<span class="text-danger">*</span></label>
                                    <select id="cycle" name="cycle" class="form-control<?=$cycle_valid ?>" title="Круг богослужений" required="required">
                                        <option value="" hidden="hidden">...</option>
                                        <?php foreach (CYCLES as $item): ?>
                                        <option value="<?=$item ?>"<?= $item == $cycle ? " selected='selected'" : "" ?>><?=CYCLE_NAMES[$item] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">Круг богослужений обязательно</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="tone">Глас</label>
                                    <input type="number" min="1" max="8" id="tone" name="tone" class="form-control" value="<?= $tone ?>" />
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="position">Порядковый номер</label>
                                    <input type="number" min="0" id="position" name="position" class="form-control" value="<?=$position ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="month">Месяц (юлианск.)</label>
                                    <select id="month" name="month" class="form-control" title="Месяц (юлианск.)">
                                        <option value="">...</option>
                                        <?php foreach (MONTHS as $item): ?>
                                        <option value="<?=$item ?>"<?= $item == $month ? " selected='selected'" : "" ?>><?=MONTH_NAMES[$item] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="day">День (юлианск.)</label>
                                    <input type="number" min="1" max="31" id="day" name="day" class="form-control" value="<?=$day ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" class="form-control" value="<?=$title ?>" />
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" class="form-control" rows="7"><?=$description ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="keywords">Keywords</label>
                            <textarea id="keywords" name="keywords" class="form-control" rows="7"><?=$keywords ?></textarea>
                        </div>
                        <button type="submit" id="edit_cantus_submit" name="edit_cantus_submit" class="btn btn-outline-dark"><i class="fas fa-save"></i>&nbsp;Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>