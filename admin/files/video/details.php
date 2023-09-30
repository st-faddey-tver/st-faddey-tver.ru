<?php
include '../../../include/topscripts.php';
require_once '../../../getid3/getid3.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если не указан id, переходим к списку
$id = filter_input(INPUT_GET, 'id');
if(empty($id)) {
    header('Location: '.APPLICATION.'/admin/files/video/');
}

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'upload_video_submit')) {
    $name = filter_input(INPUT_POST, 'name');
    
    if($_FILES['file']['error'] == 0 && !empty($name)) {
        $filename = $_FILES['file']['name'];
        $targetFolder = $_SERVER['DOCUMENT_ROOT'].APPLICATION."/video/";
        
        $getID3 = new getID3();
        $videofile = $getID3->analyze($_FILES['file']['tmp_name']);
        $width = $videofile['video']['resolution_x'];
        $height = $videofile['video']['resolution_y'];
        
        while (file_exists($targetFolder.$filename)) {
            $filename = time().'_'.$filename;
        }
        
        $extension = pathinfo($_FILES['file']['name'])['extension'];
        if(mb_stripos($extension, '.') === false) {
            $extension = ".$extension";
        }
        
        $file_uploaded = move_uploaded_file($_FILES['file']['tmp_name'], $targetFolder.$filename);
        
        if($file_uploaded) {
            $name = addslashes($name);
            $sql = "insert into video (video_section_id, name, filename, width, height, extension) values ($id, '$name', '$filename', $width, $height, '$extension')";
            $error_message = (new Executer($sql))->error;
        }
        else {
            $error_message = "Ошибка при загрузке файла";
        }
    }
}

if(null !== filter_input(INPUT_POST, 'delete_video_submit')) {
    $id = filter_input(INPUT_POST, 'id');
    $filename = filter_input(INPUT_POST, 'filename');
    $upload_path = $_SERVER['DOCUMENT_ROOT'].APPLICATION."/video/";
    $filepath = $upload_path.$filename;
    
    $error_message = (new Executer("delete from video where id=$id"))->error;
    
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
$sql = "select ds.name, (select count(id) from video where video_section_id=ds.id) video_count from video_section ds where ds.id=$id";
$fetcher = new Fetcher($sql);
$row = $fetcher->Fetch();
$name = $row['name'];
$video_count = $row['video_count'];
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
            <li><a href="<?=APPLICATION ?>/admin/files/video/">Видео</a></li>
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
                    <h1><?=$name ?></h1>
                </div>
                <div class="p-1">
                    <div class="btn-group">
                        <a href="index.php<?= BuildQueryRemove('id') ?>" class="btn btn-outline-dark" title="К списку" data-toggle="tooltip"><i class="fas fa-undo-alt"></i></a>
                        <a href="edit.php<?= BuildQuery('id', $id) ?>" class="btn btn-outline-dark" title="Редактировать" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                        <?php if($video_count == 0): ?>
                        <a href="delete.php<?= BuildQuery('id', $id) ?>" class="btn btn-outline-dark" title="Удалить" data-toggle="tooltip"><i class="fas fa-trash-alt"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
            $sql = "select count(id) from video where video_section_id=$id";
            $fetcher = new Fetcher($sql);
            
            if($row = $fetcher->Fetch()) {
                $pager_total_count = $row[0];
            }
            
            $sql = "select id, name, filename, width, height, extension from video where video_section_id=$id limit $pager_skip, $pager_take";
            $fetcher = new Fetcher($sql);
            while ($row = $fetcher->Fetch()) {
                $src = $_SERVER['REQUEST_SCHEME'].'://'. $_SERVER['HTTP_HOST'].APPLICATION."/video/".$row['filename'];
                ?>
                <hr />
                <div class="row">
                    <div class="col-4">
                        <video controls="controls" width="100%" height="auto">
                            <source src="<?=$src ?>" type="video/<?= str_replace(".", "", $row['extension']) ?>" />
                            Ваш браузер не поддерживает этот формат.
                        </video>
                    </div>
                    <div class="col-8">
                        <p><strong><?= htmlentities($row['name']) ?></strong></p>
                        <p><?=$row['extension'] ?>,&nbsp;<?=$row['width'] ?>&nbsp;<i class="fas fa-times"></i>&nbsp;<?=$row['height'] ?></p>
                        <p class="src"><a href="<?=$src ?>" title="<?=$row['name'] ?>" download="<?=$row['filename'] ?>"><?=$src ?></a></p>
                        <div class="d-flex justify-content-between">
                            <div class="p-1">
                                <button class="btn btn-outline-dark copy_src" data-src="<?=$src ?>"><i class="fas fa-copy"></i>&nbsp;Скопировать ссылку<div class='alert alert-info clipboard_alert'>Скопировано</div></button>
                            </div>
                            <div class="p-1">
                                <form method="post">
                                    <input type="hidden" id="id" name="id" value="<?=$row['id']; ?>" />
                                    <input type="hidden" id="scroll" name="scroll" />
                                    <input type="hidden" id="filename" name="filename" value="<?=$row['filename'] ?>" />
                                    <button type="submit" class="btn btn-outline-dark confirmable" id="delete_video_submit" name="delete_video_submit"><i class="fas fa-trash-alt"></i>&nbsp;Удалить</button>
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
                    <h2>Загрузить видеофайл</h2>
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" id="scroll" name="scroll" />
                        <div class="form-group">
                            <label for="file">Наименование<span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" required="required" />
                            <div class="invalid-feedback">Наименование обязательно.</div>
                        </div>
                        <div class="form-group">
                            <label for="file">Видеофайл<span class="text-danger">*</span></label>
                            <input type="file" id="file" name="file" class="form-control" />
                        </div>
                        <div class="form-group">
                            <button type="submit" id="upload_video_submit" name="upload_video_submit" class="btn btn-outline-dark"><i class="fas fa-upload"></i>&nbsp;Загрузить</button>
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