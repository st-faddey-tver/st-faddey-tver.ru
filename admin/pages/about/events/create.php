<?php
include '../../../../include/topscripts.php';

// Авторизация
if(!IsInRole(array('about', 'admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Валидация формы
define('ISINVALID', ' is-invalid');
$form_valid = true;
$error_message = '';

$title_valid = '';
$shortname_valid = '';
$body_valid = '';

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'event_create_submit')) {
    if(empty(filter_input(INPUT_POST, 'title'))) {
        $title_valid = ISINVALID;
        $form_valid = false;
    }
    
    if(!empty(filter_input(INPUT_POST, 'shortname')) && !filter_var(filter_input(INPUT_POST, 'shortname'), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-z0-9]+([._]?[a-z0-9]+)*$/")))) {
        $shortname_valid = ISINVALID;
        $form_valid = false;
    }
    
    if(empty(filter_input(INPUT_POST, 'body'))) {
        $body_valid = ISINVALID;
        $form_valid = false;
    }
    
    if($form_valid) {
        $date = filter_input(INPUT_POST, 'date');
        $title = addslashes(filter_input(INPUT_POST, 'title'));
        $shortname = filter_input(INPUT_POST, 'shortname');
        $body = addslashes(filter_input(INPUT_POST, 'body'));
        $front = filter_input(INPUT_POST, 'front') == 'on' ? 1 : 0;
        $show_title = filter_input(INPUT_POST, 'show_title') == 'on' ? 1 : 0;

        if(empty($shortname)) {
            $shortname = Romanize($title);
        }
        if(empty($shortname)) {
            $shortname = time().'_'.$shortname;
        }
        
        $shortnames_count = 1;
        do {
            $sql = "select count(id) shortnames_count from news where shortname='$shortname'";
            $fetcher = new Fetcher($sql);
            $error_message = $fetcher->error;
            
            if($row = $fetcher->Fetch()) {
                $shortnames_count = $row['shortnames_count'];
            }
            
            if($shortnames_count > 0) {
                $shortname = time().'_'.$shortname;
            }
        }while ($shortnames_count > 0);
        
        $sql = "insert into news (is_event, date, title, shortname, body, front, show_title) values (1, '$date', '$title', '$shortname', '$body', $front, $show_title)";
        $executer = new Executer($sql);
        $error_message = $executer->error;
        
        if(empty($error_message)) {
            header('Location: '.APPLICATION."/admin/pages/about/events/");
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        include '../../../include/head.php';
        ?>
    </head>
    <body>
        <?php
        include '../../../include/header.php';
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
                <li><a href="<?=APPLICATION ?>/admin/pages/about/events/">Все события</a></li>
                <li>Новое событие</li>
            </ul>
            <div class="container" style="margin-left: 0;">
                <div class="d-flex justify-content-between mb-2">
                    <div class="p-1">
                        <h1>Новое событие</h1>
                    </div>
                    <div class="p-1">
                        <a href="index.php" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Отмена</a>
                    </div>
                </div>
                <form method="post">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="date">Дата</label>
                                <input type="date" id="date" name="date" class="form-control" value="<?= filter_input(INPUT_POST, 'date') ?? date('Y-m-d') ?>" />
                            </div>
                        </div>
                        <div class="col-4" style="padding-top: 30px;">
                            <div class="form-check">
                                <?php
                                $checked = " checked='checked'";
                                if(null != filter_input(INPUT_POST, 'front') && !filter_input(INPUT_POST, 'front')) {
                                    $checked = '';
                                }
                                ?>
                                <input type="checkbox" class="form-check-input" id="front" name="front"<?=$checked ?>" />
                                <label class="form-check-label" for="front">На первой странице</label>
                            </div>
                        </div>
                        <div class="col-4" style="padding-top: 30px;">
                            <div class="form-check">
                                <?php
                                $checked = " checked='checked'";
                                if(null != filter_input(INPUT_POST, 'show_title') && !filter_input(INPUT_POST, 'show_title')) {
                                    $checked = '';
                                }
                                ?>
                                <input type="checkbox" class="form-check-input" id="show_title" name="show_title"<?=$checked ?>" />
                                <label class="form-check-label" for="show_title">Показывать заголовок</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title">Заголовок<span class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" class="form-control<?=$title_valid ?>" value="<?= filter_input(INPUT_POST, 'title') ?>" required="required" />
                        <div class="invalid-feedback">Заголовок обязательно</div>
                    </div>
                    <div class="form-group">
                        <label for="shortname">Краткое наименование (только маленькие латинские буквы, точка или подчёркивание)</label>
                        <input type="text" id="shortname" name="shortname" class="form-control<?=$shortname_valid ?>" value="<?= filter_input(INPUT_POST, 'shortname') ?>" />
                        <div class="invalid-feedback">Только маленькие латинские буквы, точка или подчёркивание. Можно поле оставить пустым.</div>
                    </div>
                    <div class="form-group">
                        <label for="body">Текст<span class="text-danger">*</span></label>
                        <textarea id="body" name="body" class="form-control editor<?=$body_valid ?>" required="required"><?= filter_input(INPUT_POST, 'body') ?></textarea>
                        <div class="invalid-feedback">Текст обязательно</div>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="event_create_submit" name="event_create_submit" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Создать</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
        include '../../../include/footer.php';
        ?>
    </body>
</html>