<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если нет параметра id, переходим к списку
if(null === filter_input(INPUT_GET, 'id')) {
    header('Location: '.APPLICATION.'/admin/sitemap/');
}

// Валидация формы
$form_valid = true;
$error_message = '';

$loc_valid = '';

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'sitemap_edit_submit')) {
    if(empty(filter_input(INPUT_POST, 'loc'))) {
        $loc_valid = ISINVALID;
        $form_valid = false;
    }
    
    if($form_valid) {
        $id = filter_input(INPUT_POST, 'id');
        $loc = filter_input(INPUT_POST, 'loc');
        $lastmod = filter_input(INPUT_POST, 'lastmod');
        $changefreq = filter_input(INPUT_POST, 'changefreq');
        $priority = filter_input(INPUT_POST, 'priority');
        if(!is_numeric($priority)) $priority = "NULL";
        
        $sql = "update sitemap set loc='$loc', lastmod='$lastmod', changefreq='$changefreq', priority=$priority where id=$id";
        $error_message = (new Executer($sql))->error;
        
        if(empty($error_message)) {
            header('Location: '.APPLICATION."/admin/sitemap/details.php".BuildQuery('id', $id));
        }
    }
}

// Получение объекта
$id = filter_input(INPUT_POST, 'id');
if(null === $id) {
    $id = filter_input(INPUT_GET, 'id');
}

$sql = "select loc, lastmod, changefreq, priority from sitemap where id=$id";
$row = (new Fetcher($sql))->Fetch();

$loc = filter_input(INPUT_POST, 'loc');
if(null === $loc) {
    $loc = $row['loc'];
}

$lastmod = filter_input(INPUT_POST, 'lastmod');
if(null === $lastmod) {
    $lastmod = $row['lastmod'];
}

$changefreq = filter_input(INPUT_POST, 'changefreq');
if(null === $changefreq) {
    $changefreq = $row['changefreq'];
}

$priority = filter_input(INPUT_POST, 'priority');
if(null === $priority) {
    $priority = $row['priority'];
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
            <li><a href="<?=APPLICATION ?>/admin/sitemap/<?= BuildQueryRemove('id') ?>">sitemap.xml</a></li>
            <li><a href="<?=APPLICATION ?>/admin/sitemap/details.php<?= BuildQuery('id', $id) ?>">Просмотр узла</a></li>
            <li>Редактирование узла</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Редактирование узла</h1>
                </div>
                <div class="p-1">
                    <a href="details.php<?= BuildQuery('id', $id) ?>" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Отмена</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8">
                    <form method="post">
                        <input type="hidden" id="id" name="id" value="<?= filter_input(INPUT_GET, 'id') ?>" />
                        <div class="form-group">
                            <label for="loc">loc<span class="text-danger">*</span></label>
                            <input type="url" id="loc" name="loc" class="form-control" value="<?=$loc ?>" />
                            <div class="invalid-feedback">Неправильный формат URL</div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="lastmod">lastmod</label>
                                    <input type="date" id="lastmod" name="lastmod" class="form-control" value="<?=$lastmod ?>" />
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="changefreq">changefreq</label>
                                    <select class="form-control" id="changefreq" name="changefreq">
                                        <option value="">...</option>
                                        <option value="always"<?= $changefreq == "always" ? " selected='selected'" : "" ?>>always</option>
                                        <option value="hourly"<?= $changefreq == "hourly" ? " selected='selected'" : "" ?>>hourly</option>
                                        <option value="daily"<?= $changefreq == "daily" ? " selected='selected'" : "" ?>>daily</option>
                                        <option value="weekly"<?= $changefreq == "weekly" ? " selected='selected'" : "" ?>>weekly</option>
                                        <option value="monthly"<?= $changefreq == "monthly" ? " selected='selected'" : "" ?>>monthly</option>
                                        <option value="yearly"<?= $changefreq == "yearly" ? " selected='selected'" : "" ?>>yearly</option>
                                        <option value="never"<?= $changefreq == "never" ? " selected='selected'" : "" ?>>never</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="priority">priority</label>
                                    <input type="number" id="priority" name="priority" min="0.0" max="1.0" step="0.1" class="form-control" value="<?=$priority ?>" />
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="sitemap_edit_submit" name="sitemap_edit_submit" class="btn btn-outline-dark"><i class="fas fa-save"></i>&nbsp;Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>