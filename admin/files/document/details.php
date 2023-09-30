<?php
include '../../../include/topscripts.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если не указан id, переходим к списку
$id = filter_input(INPUT_GET, 'id');
if(empty($id)) {
    header('Location: '.APPLICATION.'/admin/files/document/');
}

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'upload_document_submit')) {
    $name = filter_input(INPUT_POST, 'name');
    
    if($_FILES['file']['error'] == 0 && !empty($name)) {
        $filename = $_FILES['file']['name'];
        $targetFolder = $_SERVER['DOCUMENT_ROOT'].APPLICATION."/documents/";
        
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
            $sql = "insert into document (document_section_id, name, filename, extension) values ($id, '$name', '$filename', '$extension')";
            $error_message = (new Executer($sql))->error;
        }
        else {
            $error_message = "Ошибка при загрузке файла";
        }
    }
}

if(null !== filter_input(INPUT_POST, 'delete_document_submit')) {
    $id = filter_input(INPUT_POST, 'id');
    $filename = filter_input(INPUT_POST, 'filename');
    $upload_path = $_SERVER['DOCUMENT_ROOT'].APPLICATION."/documents/";
    $filepath = $upload_path.$filename;
    
    $error_message = (new Executer("delete from document where id=$id"))->error;
    
    if(empty($error_message)) {
        if(file_exists($filepath)) {
            if(!unlink($filepath)) {
                $error_message = "Ошибка при удалении файла";
            }
        }
    }
}

// Получение иконки по расширению
function GetAwesomeIcon($extension) {
    switch ($extension) {
        case '.txt':
            return "far fa-file-alt";
            
        case '.jpg':
        case '.jpeg':
        case '.png':
        case '.bmp':
        case '.gif':
        case '.tif':
        case '.tiff':
            return "far fa-file-image";

        case ".doc":
        case ".docx":
        case ".odt":
            return "fas fa-file-word";
            
        case ".xls":
        case ".xlsx":
        case ".ods":
            return "fas fa-file-excel";

        case ".pdf":
            return "fas fa-file-pdf";

        case ".zip":
        case ".rar":
        case ".7z":
        case ".gzip":
            return "fas fa-file-archive";
            
        case ".mp3":
        case ".wav":
        case ".midi":
        case ".aac":
            return "fas fa-file-audio";
            
        case ".mp4":
        case ".avi":
        case ".mkv":
        case ".wmv":
        case ".flv":
        case ".mpeg":
            return "fas fa-file-video";

        case ".html":
        case ".htm":
        case ".mht":
            return "fas fa-file-code";
            
        case ".ppt":
        case ".pptx":
        case ".odp":
            return "fas fa-file-powerpoint";
            
        case ".mdb":
        case ".accdb":
        case ".sql":
        case ".odb":
            return "fas fa-database";
            
        case ".iso":
            return "fas fa-compact-disc";
            
        case ".cdr":
        case ".odg";
            return "fas fa-file-image";
        
        case ".torrent":
            return "fas fa-file-download";
            
        case ".djvu":
            return "fas fa-book-open";

        case ".fb2":
        case ".epub":
        case ".mobi":
            return "fas fa-book";
            
        case ".psd":
            return "far fa-image";
    }
    
    return "far fa-file";
}

// Получение объекта
$id = filter_input(INPUT_GET, 'id');
$sql = "select ds.name, (select count(id) from document where document_section_id=ds.id) documents_count from document_section ds where ds.id=$id";
$fetcher = new Fetcher($sql);
$row = $fetcher->Fetch();
$name = $row['name'];
$documents_count = $row['documents_count'];
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
            <li><a href="<?=APPLICATION ?>/admin/files/document/">Документы</a></li>
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
                        <?php if($documents_count == 0): ?>
                        <a href="delete.php<?= BuildQuery('id', $id) ?>" class="btn btn-outline-dark" title="Удалить" data-toggle="tooltip"><i class="fas fa-trash-alt"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
            $sql = "select count(id) from document where document_section_id=$id";
            $fetcher = new Fetcher($sql);
            
            if($row = $fetcher->Fetch()) {
                $pager_total_count = $row[0];
            }
            
            $sql = "select id, name, filename, extension from document where document_section_id=$id limit $pager_skip, $pager_take";
            $fetcher = new Fetcher($sql);
            while ($row = $fetcher->Fetch()) {
                $src = $_SERVER['REQUEST_SCHEME'].'://'. $_SERVER['HTTP_HOST'].APPLICATION."/documents/".$row['filename'];
                ?>
                <hr />
                <div class="row">
                    <div class="col-1">
                        <a href="<?=$src ?>" title="<?=$row['name'] ?>" download="<?=$row['filename'] ?>"><i class="<?= GetAwesomeIcon($row['extension']) ?> fa-5x"></i></a>
                    </div>
                    <div class="col-11">
                        <p><strong><?= htmlentities($row['name']) ?></strong></p>
                        <p><?=$row['extension'] ?></p>
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
                                    <button type="submit" class="btn btn-outline-dark confirmable" id="delete_document_submit" name="delete_document_submit"><i class="fas fa-trash-alt"></i>&nbsp;Удалить</button>
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
                    <h2>Загрузить документ</h2>
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" id="scroll" name="scroll" />
                        <div class="form-group">
                            <label for="file">Наименование<span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" required="required" />
                            <div class="invalid-feedback">Наименование обязательно.</div>
                        </div>
                        <div class="form-group">
                            <label for="file">Файл документа<span class="text-danger">*</span></label>
                            <input type="file" id="file" name="file" class="form-control" />
                        </div>
                        <div class="form-group">
                            <button type="submit" id="upload_document_submit" name="upload_document_submit" class="btn btn-outline-dark"><i class="fas fa-upload"></i>&nbsp;Загрузить</button>
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