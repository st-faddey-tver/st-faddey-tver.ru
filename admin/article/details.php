<?php
include '../../include/topscripts.php';
include '../../include/news/news.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если нет параметра id, переход к списку
$id = filter_input(INPUT_GET, 'id');
if(empty($id)) {
    header('Location: '.APPLICATION."/admin/article/");
}

// Получение объекта
$date = '';
$holy_order = '';
$last_name = '';
$first_name = '';
$middle_name = '';
$name = '';
$shortname = '';
$body = '';

$sql = "select n.date, a.holy_order, a.last_name, a.first_name, a.middle_name, n.name, n.shortname, n.body, n.front, n.visible "
        . "from news n inner join author a on n.author_id = a.id "
        . "where n.id = $id";
$fetcher = new Fetcher($sql);
$error_message = $fetcher->error;

if($row = $fetcher->Fetch()) {
    $date = $row['date'];
    $holy_order = $row['holy_order'];
    $last_name = $row['last_name'];
    $first_name = $row['first_name'];
    $middle_name = $row['middle_name'];
    $name = $row['name'];
    $shortname = $row['shortname'];
    $body = $row['body'];
    $front = $row['front'];
    $visible = $row['visible'];
}

// Фрагменты
$news = new News($id);
$news->Top();
$error_message = $news->errorMessage;
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
            <li><a href="<?=APPLICATION ?>/admin/article/<?= BuildQueryRemove('id') ?>">Приходские заметки</a></li>
            <li><?=$name ?></li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <div class="text-right font-italic"><?= GetAuthorsFullName($holy_order, $last_name, $first_name, $middle_name) ?></div>
                    <h1><?=$name ?></h1>
                    <div style="font-size: smaller;"><?= DateTime::createFromFormat('Y-m-d', $row['date'])->format('d.m.Y') ?></div>
                </div>
                <div class="p-1">
                    <?php
                    if(filter_input(INPUT_GET, 'mode') == 'edit'):
                    ?>
                    <a href="<?= BuildQueryRemove("mode") ?>" class="btn btn-outline-dark" title="В обычный режим" data-toggle="tooltip"><i class="fas fa-undo-alt"></i>&nbsp;В обычный режим</a>
                    <?php
                    else:
                    ?>
                    <div class="btn-group">
                        <a href="<?=APPLICATION ?>/admin/article/" class="btn btn-outline-dark" title="К списку" data-toggle="tooltip"><i class="fas fa-undo-alt"></i></a>
                        <a href="edit.php<?= BuildQuery('id', $id) ?>" class="btn btn-outline-dark" title="Редактировать" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                        <a href="<?= BuildQuery("mode", "edit") ?>" class="btn btn-outline-dark" title="Редактировать содержимое" data-toggle="tooltip"><i class="fas fa-scroll"></i></a>
                        <a href="delete.php<?= BuildQuery('id', $id) ?>" class="btn btn-outline-dark" title="Удалить" data-toggle="tooltip"><i class="fas fa-trash-alt"></i></a>
                    </div>
                    <?php
                    endif;
                    ?>
                </div>
            </div>
            <div class="container" style="margin-left: 0;">
                <div class="content">
                    <div class="row">
                        <div class="col-6">
                            <div class="news_date"><?= DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y') ?>&nbsp;<?=$shortname ?>&nbsp;<?=$front ? 'front' : '' ?>&nbsp;<?=$visible ? 'visible' : '' ?></div>
                            <div class="news_body"><?=$body ?></div>
                        </div>
                    </div>
                    <hr />
                    <div class="bigfont">
                        <?php
                        if(filter_input(INPUT_GET, 'mode') == 'edit') {
                            $news->GetFragmentsEditMode();
                        }                            
                        else {
                            $news->GetFragments();
                        }
                        
                        $news->ShowCreateFragmentForm();
                        
                        if(filter_input(INPUT_GET, 'mode') != 'edit'):
                        ?>
                        <hr />
                        <h2>Изображения</h2>
                        <?php
                        $news->GetImages();
                        ?>
                        <div class="row">
                            <div class="col-8">
                                <?php
                                $news->ShowUploadImageForm();
                                ?>
                            </div>
                        </div>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>