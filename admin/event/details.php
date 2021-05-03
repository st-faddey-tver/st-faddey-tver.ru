<?php
include '../../include/topscripts.php';
include '../../include/myimage/myimage.php';

// Авторизация
if(!IsInRole(array('admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если нет параметра id, переход к списку
$id = filter_input(INPUT_GET, 'id');
if(empty($id)) {
    header('Location: '.APPLICATION."/admin/event/");
}

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'upload_image_submit')) {
    $name = filter_input(INPUT_POST, 'name');
    $max_width = filter_input(INPUT_POST, 'max_width');
    $max_height = filter_input(INPUT_POST, 'max_height');
    
    if($_FILES['file']['error'] == 0 && !empty($name)) {
        if(exif_imagetype($_FILES['file']['tmp_name'])) {
            $myimage = new MyImage($_FILES['file']['tmp_name']);
            $file_uploaded = $myimage->ResizeAndSave($_SERVER['DOCUMENT_ROOT'].APPLICATION."/images/content/", $max_width, $max_height);
            
            if($file_uploaded) {
                $name = addslashes($name);
                $sql = "insert into event_image (event_id, name, filename, width, height, extension) values($id, '$name', '$myimage->filename', $myimage->width, $myimage->height, '$myimage->extension')";
                $error_message = (new Executer($sql))->error;
            }
            else {
                $error_message = "Ошибка при загрузке файла";
            }
        }
        else {
            $error_message = "Файл не является изображением";
        }
    }
}

if(null !== filter_input(INPUT_POST, 'delete_image_submit')) {
    $id = filter_input(INPUT_POST, 'id');
    $filename = filter_input(INPUT_POST, 'filename');
    $upload_path = $_SERVER['DOCUMENT_ROOT'].APPLICATION."/images/content/";
    $filepath = $upload_path.$filename;
    
    $error_message = (new Executer("delete from event_image where id=$id"))->error;
    
    if(empty($error_message)) {
        if(file_exists($filepath)) {
            if(!unlink($filepath)) {
                $error_message = "Ошибка при удалении файла";
            }
        }
    }
}

// Получение объекта
$id = filter_input(INPUT_GET, "id");
$date = '';
$body = '';
$front = 0;
$visible = 0;

$sql = "select date, body, front, visible from event where id=$id";
$fetcher = new Fetcher($sql);
$error_message = $fetcher->error;

if($row = $fetcher->Fetch()) {
    $date = $row['date'];
    $body = $row['body'];
    $front = $row['front'];
    $visible = $row['visible'];
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
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <ul class="breadcrumb">
                <li><a href="<?=APPLICATION ?>/">На главную</a></li>
                <li><a href="<?=APPLICATION ?>/admin/">Администратор</a></li>
                <li><a href="<?=APPLICATION ?>/admin/event/">События</a></li>
                <li><?=$date ?> <?=($front ? "front" : "") ?> <?=($visible ? "visible" : "") ?></li>
            </ul>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1><?=$date ?> <?=($front ? "front" : "") ?> <?=($visible ? "visible" : "") ?></h1>
                </div>
                <div class="p-1">
                    <div class="btn-group">
                        <a href="<?=APPLICATION ?>/admin/event/" class="btn btn-outline-dark" title="К списку"><i class="fas fa-undo-alt"></i></a>
                        <a href="edit.php<?= BuildQuery("id", $id) ?>" class="btn btn-outline-dark" title="Редактировать"><i class="fas fa-edit"></i></a>
                        <a href="delete.php<?= BuildQuery("id", $id) ?>" class="btn btn-outline-dark" title="Удалить"><i class="fas fa-trash-alt"></i></a>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-left: 0;">
                <div class="content">
                    <?=$body ?>
                    <hr style="clear: both;" />
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <?php
                    $sql = "select id, name, filename, width, height, extension from event_image where event_id=". filter_input(INPUT_GET, "id");
                    $fetcher = new Fetcher($sql);
                    while ($row = $fetcher->Fetch()):
                        $src = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].APPLICATION."/images/content/".$row['filename'];
                    ?>
                    <hr style="clear: both;" />
                    <div class="row">
                        <div class="col-2">
                            <a href="<?=$src ?>" title="Открыть в новом окне" target="_blank"><img src="<?=$src ?>" title="<?=$row['name'] ?>" class="img-fluid" /></a>
                        </div>
                        <div class="col-10">
                            <p class="font-weight-bold"><?=$row['name'] ?></p>
                            <p><?=$row['extension'] ?>,&nbsp;<?=$row['width'] ?>&nbsp;<i class="fas fa-times"></i>&nbsp;<?=$row['height'] ?></p>
                            <p class="src"><?=$src ?></p>
                            <div class="d-flex justify-content-between mb-2">
                                <div class="p-1">
                                    <button class="btn btn-outline-dark copy_src" data-src="<?=$src ?>"><i class="fas fa-copy"></i>&nbsp;Скопировать ссылку<div class="alert alert-info clipboard_alert">Скопировано</div></button>
                                </div>
                                <div class="p-1">
                                    <form method="post">
                                        <input type="hidden" id="id" name="id" value="<?=$row['id']; ?>" />
                                        <input type="hidden" id="scroll" name="scroll" />
                                        <input type="hidden" id="filename" name="filename" value="<?=$row['filename'] ?>" />
                                        <button type="submit" class="btn btn-outline-dark confirmable" id="delete_image_submit" name="delete_image_submit"><i class="fas fa-trash-alt"></i>&nbsp;Удалить</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                    <h2>Загрузить изображение</h2>
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" id="scroll" name="scroll" />
                        <div class="form-group">
                            <label for="file">Наименование<span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" required="required" />
                            <div class="invalid-feedback">Наименование обязательно.</div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="width">Уменьшить ширину до</label>
                                    <input type="number" min="1" step="1" id="max_width" name="max_width" class="form-control" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="height">Уменьшить длину до</label>
                                    <input type="number" min="1" step="1" id="max_height" name="max_height" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="file">Файл изображения<span class="text-danger">*</span></label>
                            <input type="file" id="file" name="file" class="form-control" />
                        </div>
                        <div class="form-group">
                            <button type="submit" id="upload_image_submit" name="upload_image_submit" class="btn btn-outline-dark"><i class="fas fa-upload"></i>&nbsp;Загрузить</button>
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