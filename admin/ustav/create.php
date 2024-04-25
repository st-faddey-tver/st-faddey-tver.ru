<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Валидация формы
$form_valid = true;
$error_message = '';

$date_valid = '';
$body_valid = '';

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'ustav_create_submit')) {
    if(empty(filter_input(INPUT_POST, 'date'))) {
        $date_valid = ISINVALID;
        $form_valid = false;
    }
    
    if(empty(filter_input(INPUT_POST, 'body'))) {
        $body_valid = ISINVALID;
        $form_valid = false;
    }
    
    if($form_valid) {
        $date = filter_input(INPUT_POST, 'date');
        $body = addslashes(filter_input(INPUT_POST, 'body'));
        $event_type_id = EVENT_TYPE_USTAV;
        $top = filter_input(INPUT_POST, 'top') == 'on' ? 1 : 0;
        $visible = filter_input(INPUT_POST, 'visible') == 'on' ? 1: 0;
        
        $sql = "insert into event (date, body, event_type_id, top, visible) values ('$date', '$body', $event_type_id, $top, $visible)";
        $executer = new Executer($sql);
        $error_message = $executer->error;
        $insert_id = $executer->insert_id;
        
        if(empty($error_message)) {
            header('Location: '.APPLICATION."/admin/ustav/details.php". BuildQuery("id", $insert_id));
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
            <li>Новая запись</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Новая запись</h1>
                </div>
                <div class="p-1">
                    <a href="<?=APPLICATION ?>/admin/ustav/" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Отмена</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8">
                    <form method="post">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="date">Дата<span class="text-danger">*</span></label>
                                    <input type="date" id="date" name="date" class="form-control" value="<?= filter_input(INPUT_POST, 'date') ?? date('Y-m-d') ?>" />
                                    <div class="invalid-feedback">Дата обязательно</div>
                                </div>
                            </div>
                            <div class="col-4" style="padding-top: 30px;">
                                <div class="form-check">
                                    <?php
                                    $checked = ''; // " checked='checked'";
                                    if(null !== filter_input(INPUT_POST, 'top') && !filter_input(INPUT_POST, 'top')) {
                                        $checked = '';
                                    }
                                    ?>
                                    <input type="checkbox" class="form-check-input" id="top" name="top"<?=$checked ?> disabled="disabled" />
                                    <label class="form-check-label" for="top">Наверху</label>
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
                        <?php
                        include $_SERVER['DOCUMENT_ROOT'].APPLICATION.'/include/virtual_keyboard.php';
                        ?>
                        <div class="form-group">
                            <label for="body">Текст<span class="text-danger">*</span></label>
                            <textarea id="body" name="body" class="form-control<?=$body_valid ?>" style="height: 200px;" required="required"><?= filter_input(INPUT_POST, 'body') ?></textarea>
                            <div class="invalid-feedback">Текст обязательно</div>
                        </div>
                        <div class="form-group d-flex justify-content-between mb-auto">
                            <div class="p-1">
                                <button type="submit" id="ustav_create_submit" name="ustav_create_submit" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Создать</button>
                            </div>
                            <div class="p-1">
                                <button type="button" class="btn btn-outline-dark btn_vk"><i class="fas fa-keyboard"></i>&nbsp;Виртуальная клавиатура</button>
                            </div>
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