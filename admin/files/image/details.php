<?php
include '../../../include/topscripts.php';
include '../../../include/myimage/myimage.php';

// Авторизация
if(!IsInRole(array('files', 'admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если не указан id, переходим к списку
$id = filter_input(INPUT_GET, 'id');
if(empty($id)) {
    header('Location: '.APPLICATION.'/admin/files/image/');
}

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'upload_image_submit')) {
    $name = filter_input(INPUT_POST, 'name');
    $max_width = filter_input(INPUT_POST, 'max_width');
    $max_height = filter_input(INPUT_POST, 'max_height');
    
    if($_FILES['file']['error'] == 0 && !empty($name)) {
        if(exif_imagetype($_FILES['file']['tmp_name'])) {
            $myimage = new MyImage($_FILES['file']['tmp_name']);
            $file_uploaded = $myimage->ResizeAndSave($_SERVER['DOCUMENT_ROOT'].APPLICATION."/image/content/", $max_width, $max_height);
            
            if($file_uploaded) {
                $name = addslashes($name);
                $sql = "insert into image (image_section_id, name, filename, width, height, extension) values ($id, '$name', '$myimage->filename', $myimage->width, $myimage->height, '$myimage->extension')";
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
    $upload_path = $_SERVER['DOCUMENT_ROOT'].APPLICATION."/image/content/";
    $filepath = $upload_path.$filename;
    
    $error_message = (new Executer("delete from image where id=$id"))->error;
    
    if(empty($error_message)) {
        if(file_exists($filepath)) {
            if(!unlink($filepath)) {
                $error_message = "Ошибка при удалении файла";
            }
        }
    }
}

// Получение объекта
$id = filter_input(INPUT_GET, 'id');
$sql = "select ims.name, (select count(id) from image where image_section_id=ims.id) images_count from image_section ims where ims.id=$id";
$fetcher = new Fetcher($sql);
$row = $fetcher->Fetch();
$name = $row['name'];
$images_count = $row['images_count'];
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
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <ul class="breadcrumb">
                <li><a href="<?=APPLICATION ?>/">На главную</a></li>
                <li><a href="<?=APPLICATION ?>/admin/">Администратор</a></li>
                <li><a href="<?=APPLICATION ?>/admin/files/image/">Изображения</a></li>
                <li><?=$name ?></li>
            </ul>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1><?=$name ?></h1>
                </div>
                <div class="p-1">
                    <div class="btn-group">
                        <a href="index.php<?= BuildQueryRemove('id') ?>" class="btn btn-outline-dark" title="К списку" data-toggle="tooltip"><i class="fas fa-undo-alt"></i></a>
                        <a href="edit.php<?= BuildQuery('id', $id) ?>" class="btn btn-outline-dark" title="Редактировать" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                        <?php if($images_count == 0): ?>
                        <a href="delete.php<?= BuildQuery('id', $id) ?>" class="btn btn-outline-dark" title="Удалить" data-toggle="tooltip"><i class="fas fa-trash-alt"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
            $sql = "select count(id) from image where image_section_id=$id";
            $fetcher = new Fetcher($sql);
            
            if($row = $fetcher->Fetch()) {
                $pager_total_count = $row[0];
            }
            
            $sql = "select id, name, filename, width, height, extension from image where image_section_id=$id limit $pager_skip, $pager_take";
            $fetcher = new Fetcher($sql);
            while ($row = $fetcher->Fetch()) {
                $src = $_SERVER['REQUEST_SCHEME'].'://'. $_SERVER['HTTP_HOST'].APPLICATION."/image/content/".$row['filename'];
                ?>
                <div class="row mb-5">
                    <div class="col-2">
                        <a href="<?=$src ?>" title="Открыть в новом окне" target="_blank"><img src="<?=$src ?>" title="<?=$row['name'] ?>" class="img-fluid" /></a>
                    </div>
                    <div class="col-10" style="border-top: solid 1px lightgray;">
                        <p><strong><?= htmlentities($row['name']) ?></strong></p>
                        <p><?=$row['extension'] ?>,&nbsp;<?=$row['width'] ?>&nbsp;<i class="fas fa-times"></i>&nbsp;<?=$row['height'] ?></p>
                        <p class="src"><?=$src ?></p>
                        <div class="d-flex justify-content-between mb-2">
                            <div class="p-1">
                                <button class="btn btn-outline-dark copy_src" data-src="<?=$src ?>"><i class="fas fa-copy"></i>&nbsp;Скопировать ссылку<div class='alert alert-info clipboard_alert'>Скопировано</div></button>
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
                <?php
            }
            echo '<hr />';
            include '../../../include/pager_bottom.php';
            ?>
            <div class="row">
                <div class="col-6">
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
                                    <label for="height">Уменьшить высоту до</label>
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
        include '../../include/footer.php';
        ?>
    </body>
</html>