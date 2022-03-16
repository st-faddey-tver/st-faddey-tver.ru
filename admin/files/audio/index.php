<?php
include '../../../include/topscripts.php';

// Авторизация
if(!IsInRole(array('files', 'admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Валидация формы
define('ISINVALID', ' is-invalid');
$form_valid = true;
$error_message = '';

$name_valid = '';

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'create_audio_section_submit')) {
    if(empty(filter_input(INPUT_POST, 'name'))) {
        $name_valid = ISINVALID;
        $form_valid = false;
    }
    
    if($form_valid) {
        $name = addslashes(filter_input(INPUT_POST, 'name'));
        $sql = "insert into audio_section (name) values ('$name')";
        $executer = new Executer($sql);
        $error_message = $executer->error;
        $insert_id = $executer->insert_id;
        
        if(empty($error_message)) {
            header('Location: details.php'.BuildQuery('id', $insert_id));
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        include '../../include/head.php';
        ?>
    </head>
    <body>
        <?php
        include '../../include/header.php';
        include '../../../include/pager_top.php';
        ?>
        <ul class="breadcrumb">
            <li><a href="<?=APPLICATION ?>/">На главную</a></li>
            <li><a href="<?=APPLICATION ?>/admin/">Администратор</a></li>
            <li>Аудио</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Аудио</h1>
                </div>
                <div class="p-1">
                    <form method="post" class="form-inline">
                        <div class="input-group">
                            <input type="text" id="name" name="name" placeholder="Новый раздел" class="form-control<?=$name_valid ?>" required="required" />
                            <div class="input-group-append">
                                <button type="submit" id="create_audio_section_submit" name="create_audio_section_submit" class="input-group-text"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php
            $sql = "select count(id) from audio_section";
            $fetcher = new Fetcher($sql);
            
            if($row = $fetcher->Fetch()) {
                $pager_total_count = $row[0];
            }
                
            $sql = "select id, name from audio_section order by name asc limit $pager_skip, $pager_take";
            $fetcher = new Fetcher($sql);
                
            while ($row = $fetcher->Fetch()):
            $id = $row['id'];
            $name = $row['name'];
            ?>
            <p><a href="details.php<?= BuildQuery('id', $id) ?>"><?=$name ?></a></p>
            <?php
            endwhile;
            ?>
            <hr />
            <?php
            include '../../../include/pager_bottom.php';
            ?>
        </div>
        <?php
        include '../../include/footer.php';
        ?>
    </body>
</html>