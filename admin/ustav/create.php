<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Валидация формы
$form_valid = true;
$error_message = '';

$name_valid = '';
$shortname_valid = '';
$body_valid = '';

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'news_create_submit')) {
    if(empty(filter_input(INPUT_POST, 'name'))) {
        $name_valid = ISINVALID;
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
        $name = addslashes(filter_input(INPUT_POST, 'name'));
        $shortname = filter_input(INPUT_POST, 'shortname');
        $body = addslashes(filter_input(INPUT_POST, 'body'));
        $news_type_id = NEWS_TYPE_USTAV;
        $front = filter_input(INPUT_POST, 'front') == 'on' ? 1 : 0;
        $visible = filter_input(INPUT_POST, 'visible') == 'on' ? 1 : 0;
        $title = addslashes(filter_input(INPUT_POST, 'title'));
        $description = addslashes(filter_input(INPUT_POST, 'description'));
        $keywords = addslashes(filter_input(INPUT_POST, 'keywords'));
        $image = addslashes(filter_input(INPUT_POST, 'image'));

        if(empty($shortname)) {
            $shortname = Romanize($name);
        }
        if(empty($shortname)) {
            $shortname = time().'_'.$shortname;
        }
        
        $shortnames_count = 1;
        do {
            $sql = "select count(id) shortnames_count from news where shortname = '$shortname' and news_type_id = $news_type_id";
            $fetcher = new Fetcher($sql);
            $error_message = $fetcher->error;
            
            if($row = $fetcher->Fetch()) {
                $shortnames_count = $row['shortnames_count'];
            }
            
            if($shortnames_count > 0) {
                $shortname = strval(time());
            }
        }while ($shortnames_count > 0);
        
        $sql = "insert into news (date, name, shortname, body, news_type_id, front, visible, title, description, keywords, image) values ('$date', '$name', '$shortname', '$body', $news_type_id, $front, $visible, '$title', '$description', '$keywords', '$image')";
        $executer = new Executer($sql);
        $error_message = $executer->error;
        $insert_id = $executer->insert_id;
        
        if(empty($error_message)) {
            header('Location: '.APPLICATION."/admin/ustav/details.php". BuildQuery('id', $insert_id));
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
            <li><a href="<?=APPLICATION ?>/admin/ustav/">Видеолекции Е. С. Кустовского</a></li>
            <li>Новая новость</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Новая лекция</h1>
                </div>
                <div class="p-1">
                    <a href="<?=APPLICATION ?>/admin/ustav/" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Отмена</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
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
                                    $checked = ''; // " checked='checked'";
                                    if(null !== filter_input(INPUT_POST, 'front') && !filter_input(INPUT_POST, 'front')) {
                                        $checked = '';
                                    }
                                    ?>
                                    <input type="checkbox" class="form-check-input" id="front" name="front"<?=$checked ?> disabled="disabled" />
                                    <label class="form-check-label" for="front">На первой странице</label>
                                </div>
                            </div>
                            <div class="col-4" style="padding-top: 30px;">
                                <div class="form-check">
                                    <?php
                                    $checked = "";
                                    if(null !== filter_input(INPUT_POST, 'visible') && filter_input(INPUT_POST, 'visible')) {
                                        $checked = " checked='checked'";
                                    }
                                    ?>
                                    <input type="checkbox" class="form-check-input" id="visible" name="visible"<?=$checked ?> />
                                    <label class="form-check-label" for="visible">Показывать</label>
                                </div>
                            </div>
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
                        <div class="form-group">
                            <label for="body">Текст<span class="text-danger">*</span></label>
                            <textarea id="body" name="body" class="form-control editor<?=$body_valid ?>" rows="7" required="required"><?= filter_input(INPUT_POST, 'body') ?></textarea>
                            <div class="invalid-feedback">Текст обязательно</div>
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
                            <label for="image">Image</label>
                            <textarea id="image" name="image" class="form-control" rows="7"><?= htmlentities(filter_input(INPUT_POST, 'image')) ?></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="news_create_submit" name="news_create_submit" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Создать</button>
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