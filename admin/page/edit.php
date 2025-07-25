<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}


// Если нет параметра id, переходим к списку
$id = filter_input(INPUT_GET, 'id');
if(empty($id)) {
    header('Location: '.APPLICATION.'/admin/page/');
}

// Валидация формы
$form_valid = true;
$error_message = '';

$name_valid = '';
$shortname_valid = '';

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, "edit_page_submit")) {
    if(empty(filter_input(INPUT_POST, "name"))) {
        $name_valid = ISINVALID;
        $form_valid = false;
    }
    
    if(!empty(filter_input(INPUT_POST, 'shortname')) && !filter_var(filter_input(INPUT_POST, 'shortname'), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-z0-9]+([._]?[a-z0-9]+)*$/")))) {
        $shortname_valid = ISINVALID;
        $form_valid = false;
    }
    
    if($form_valid) {
        $id = filter_input(INPUT_POST, 'id');
        $name = addslashes(filter_input(INPUT_POST, "name"));
        $shortname = filter_input(INPUT_POST, "shortname");
        $title = addslashes(filter_input(INPUT_POST, "title"));
        $description = addslashes(filter_input(INPUT_POST, "description"));
        $keywords = addslashes(filter_input(INPUT_POST, "keywords"));
        $image = addslashes(filter_input(INPUT_POST, 'image'));
        
        if(empty($shortname)) {
            $shortname = Romanize($name);
        }
        if(empty($shortname)) {
            $shortname = strval(time());
        }
        
        $shortnames_count = 1;
        do {
            $sql = "select count(id) shortnames_count from page where shortname='$shortname' and id<>$id";
            $fetcher = new Fetcher($sql);
            $error_message = $fetcher->error;
            
            if($row = $fetcher->Fetch()) {
                $shortnames_count = $row['shortnames_count'];
            }
            
            if($shortnames_count > 0) {
                $shortname = time().'_'.$shortname;
            }
        }while ($shortnames_count > 0);
        
        $sql = "update page set name='$name', shortname='$shortname', title='$title', description='$description', keywords='$keywords', image='$image' where id='$id'";
        $error_message = (new Executer($sql))->error;
        
        if(empty($error_message)) {
            header('Location: '.APPLICATION."/admin/page/details.php".BuildQuery("shortname", $shortname));
        }
    }
}

// Получение объекта
$sql = "select name, shortname, title, description, keywords, image from page where id=$id";
$row = (new Fetcher($sql))->Fetch();

$name = filter_input(INPUT_POST, 'name');
if(empty($name)) {
    $name = $row['name'];
}

$shortname = filter_input(INPUT_POST, 'shortname');
if(empty($shortname)) {
    $shortname = $row['shortname'];
}

$old_shortname = $row['shortname'];

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

$image = filter_input(INPUT_POST, 'image');
if(empty($image)) {
    $image = $row['image'];
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
            <li><a href="<?=APPLICATION ?>/admin/page/">Страницы</a></li>
            <li><a href="<?=APPLICATION ?>/admin/page/details.php<?= BuildQuery("shortname", $old_shortname) ?>"><?=$name ?></a></li>
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
                <div class="col-12 col-md-6">
                    <form method="post">
                        <input type="hidden" id="id" name="id" value="<?= filter_input(INPUT_GET, 'id') ?>" />
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
                        <div class="form-group">
                            <label for="image">Image</label>
                            <textarea id="image" name="image" class="form-control" rows="7"><?=$image ?></textarea>
                        </div>
                        <button type="submit" id="edit_page_submit" name="edit_page_submit" class="btn btn-outline-dark"><i class="fas fa-save"></i>&nbsp;Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>