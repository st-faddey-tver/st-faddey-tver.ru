<?php
include '../include/topscripts.php';
include '../include/page/page.php';

// Авторизация
if(!IsInRole(array('admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если нет параметра shortname, переходим к списку
$shortname = filter_input(INPUT_GET, 'shortname');
if(empty($shortname)) {
    header('Location: '.APPLICATION.'/admin/');
}

// Валидация формы
$form_valid = true;
$error_message = '';

$name_valid = '';
$shortname_valid = '';

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'page_edit_submit')) {
    if(empty(filter_input(INPUT_POST, 'name'))) {
        $name_valid = ISINVALID;
        $form_valid = false;
    }
    
    if(!empty(filter_input(INPUT_POST, 'shortname')) && !filter_var(filter_input(INPUT_POST, 'shortname'), FILTER_VALIDATE_REGEXP, array("options"=> array("regexp"=>"/^[a-z0-9]+([._]?[a-z0-9]+)*$/")))) {
        $shortname_valid = ISINVALID;
        $form_valid = false;
    }
    
    if($form_valid) {
        $id = filter_input(INPUT_POST, 'id');
        $name = addslashes(filter_input(INPUT_POST, 'name'));
        $shortname = filter_input(INPUT_POST, 'shortname');
        
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
        
        $sql = "update page set name='$name', shortname='$shortname' where id=$id";
        $error_message = (new Executer($sql))->error;
        if(empty($error_message)) {
            header('Location: '.APPLICATION."/admin/details.php?shortname=$shortname");
        }
    }
    
    $shortnames_count = 1;
}

// Получение данных
$page = new Page($shortname);
$page->Top();
$error_message = $page->errorMessage;
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
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <ul class="breadcrumb">
                <li><a href="<?=APPLICATION ?>/">На главную</a></li>
                <li><a href="<?=APPLICATION ?>/admin/">Администратор</a></li>
                <li><?=$page->name ?></li>
            </ul>
            <div class="container" style="margin-left: 0;">
                <div class="content bigfont">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="p-1">
                            <?php if(filter_input(INPUT_GET, "mode") == "edit"): ?>
                            <form method="post">
                                <input type="hidden" id="id" name="id" value="<?=$page->id ?>" />
                                <div class="form-group">
                                    <label for="name">Наименование</label>
                                    <input type="text" id="name" name="name" class="form-control<?=$name_valid ?>" value="<?= htmlentities($page->name) ?>" required="required" />
                                    <div class="invalid-feedback">Наименование обязательно</div>
                                </div>
                                <?php if($page->inmenu): ?>
                                <input type="hidden" id="shortname" name="shortname" value="<?=$page->shortname ?>" />
                                <?php else: ?>
                                <div class="form-group">
                                    <label for="shortname">Краткое наименование (только маленькие латинские буквы, точка или подчёркивание)</label>
                                    <input type="text" id="shortname" name="shortname" class="form-control<?=$shortname_valid ?>" value="<?=$shortname ?>" />
                                    <div class="invalid-feedback">Только маленькие латинские буквы, точка или подчёркивание. Можно поле оставить пустым.</div>
                                </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <button type="submit" id="page_edit_submit" name="page_edit_submit" class="btn btn-outline-dark"><i class="fas fa-save"></i>&nbsp;Сохранить</button>
                                </div>
                            </form>
                            <?php else: ?>
                            <h1><?=$page->name ?></h1>
                            <?php endif; ?>
                        </div>
                        <div class="p-1">
                            <?php
                            if(filter_input(INPUT_GET, 'mode') == 'edit'):
                            ?>
                            <a href="<?= BuildQueryRemove("mode") ?>" class="btn btn-outline-dark" title="Выход из редактирования" data-toggle="tooltip"><i class="fas fa-undo-alt"></i>&nbsp;Выход из редактирования</a>
                            <?php
                            else:
                            ?>
                            <div class="btn-group">
                                <a href="seo.php<?= BuildQuery("shortname", $page->shortname) ?>" class="btn btn-outline-dark" title="SEO" data-toggle="tooltip"><i class="fas fa-globe"></i>&nbsp;SEO</a>
                                <a href="<?= BuildQuery("mode", "edit") ?>" class="btn btn-outline-dark" title="Редактировать" data-toggle="tooltip"><i class="fas fa-edit"></i>&nbsp;Редактировать</a>
                                <?php if(!$page->inmenu): ?>
                                <a href="delete.php<?= BuildQuery("shortname", $page->shortname) ?>" class="btn btn-outline-dark" title="Удалить" data-toggle="tooltip"><i class="fas fa-trash-alt"></i>&nbsp;Удалить</a>
                                <?php endif; ?>
                            </div>
                            <?php
                            endif;
                            ?>
                        </div>
                    </div>
                    <?php
                    if(filter_input(INPUT_GET, 'mode') == 'edit') {
                        $page->GetFragmentsEditMode();
                    }
                    else {
                        $page->GetFragments();
                    }
                    
                    $page->ShowCreateFragmentForm();
                    
                    if(filter_input(INPUT_GET, 'mode') != 'edit'):
                    ?>
                    <hr />
                    <h2>Изображения</h2>
                    <?php
                    $page->GetImages();
                    ?>
                    <div class="row">
                        <div class="col-8">
                            <?php
                            $page->ShowUploadImageForm();
                            ?>
                        </div>
                    </div>
                    <?php
                    endif;
                    ?>
                </div>
            </div>
        </div>
        <?php
        include 'include/footer.php';
        ?>
    </body>
</html>