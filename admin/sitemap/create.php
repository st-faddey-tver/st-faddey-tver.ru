<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Валидация формы
$form_valid = true;
$error_message = '';

$loc_valid = '';

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'sitemap_create_submit')) {
    if(empty(filter_input(INPUT_POST, 'loc'))) {
        $loc_valid = ISINVALID;
        $form_valid = false;
    }
    
    if($form_valid) {
        $loc = filter_input(INPUT_POST, 'loc');
        $lastmod = filter_input(INPUT_POST, 'lastmod');
        $changefreq = filter_input(INPUT_POST, 'changefreq');
        $priority = filter_input(INPUT_POST, 'priority');
        if(!is_numeric($priority)) $priority = "NULL";
        
        $sql = "insert into sitemap (loc, lastmod, changefreq, priority) values ('$loc', '$lastmod', '$changefreq', $priority)";
        $executer = new Executer($sql);
        $error_message = $executer->error;
        $insert_id = $executer->insert_id;
        
        if(empty($error_message)) {
            header('Location: '.APPLICATION."/admin/sitemap/details.php".BuildQuery("id", $insert_id));
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
            <li><a href="<?=APPLICATION ?>/admin/sitemap/">sitemap.xml</a></li>
            <li>Новый узел</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Новый узел</h1>
                </div>
                <div class="p-1">
                    <a href="<?=APPLICATION ?>/admin/sitemap/" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Отмена</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8">
                    <form method="post">
                        <div class="form-group">
                            <label for="loc">loc<span class="text-danger">*</span></label>
                            <input type="url" id="loc" name="loc" class="form-control<?=$loc_valid ?>" value="<?= filter_input(INPUT_POST, 'loc') ?>" required="required" />
                            <div class="invalid-feedback">Неправильный формат URL</div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="lastmod">lastmod</label>
                                    <input type="date" id="lastmod" name="lastmod" class="form-control" value="<?= filter_input(INPUT_POST, 'lastmod') ?? date("Y-m-d") ?>" />
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="changefreq">changefreq</label>
                                    <select class="form-control" id="changefreq" name="changefreq">
                                        <option value="">...</option>
                                        <option value="always"<?= filter_input(INPUT_POST, 'changefreq') == "always" ? " selected='selected'" : "" ?>>always</option>
                                        <option value="hourly"<?= filter_input(INPUT_POST, 'changefreq') == "hourly" ? " selected='selected'" : "" ?>>hourly</option>
                                        <option value="daily"<?= filter_input(INPUT_POST, 'changefreq') == "daily" ? " selected='selected'" : "" ?>>daily</option>
                                        <option value="weekly"<?= filter_input(INPUT_POST, 'changefreq') == "weekly" ? " selected='selected'" : "" ?>>weekly</option>
                                        <option value="monthly"<?= filter_input(INPUT_POST, 'changefreq') == "monthly" ? " selected='selected'" : "" ?>>monthly</option>
                                        <option value="yearly"<?= filter_input(INPUT_POST, 'changefreq') == "yearly" ? " selected='selected'" : "" ?>>yearly</option>
                                        <option value="never"<?= filter_input(INPUT_POST, 'changefreq') == "never" ? " selected='selected'" : "" ?>>never</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="priority">priority</label>
                                    <input type="number" id="priority" name="priority" min="0.0" max="1.0" step="0.1" class="form-control" value="<?= filter_input(INPUT_POST, 'priority') ?>" />
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="sitemap_create_submit" name="sitemap_create_submit" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Создать</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>