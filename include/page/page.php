<?php
class Page {
    public function __construct($pageName) {
        $this->page = $pageName;
    }
    
    private $page;
    public $errorMessage;

    public function Top() {
        define('ISINVALID', ' is-invalid');
        $form_valid = true;
        $error_message = '';

        if(null !== filter_input(INPUT_POST, 'create_fragment_submit')) {
            $body = filter_input(INPUT_POST, 'body');
            
            if(!empty($body)) {
                $sql = "select ifnull(max(position), 0) max_position from page_fragment where page = '$this->page'";
                $row = (new Fetcher($sql))->Fetch();
                $position = intval($row['max_position']) + 1;
                
                $body = addslashes($body);
                $sql = "insert into page_fragment (page, body, position) values ('$this->page', '$body', $position)";
                $this->errorMessage = (new Executer($sql))->error;
            }
        }
        
        if(null !== filter_input(INPUT_POST, 'edit_fragment_submit')) {
            $id = filter_input(INPUT_POST, 'id');
            $body = filter_input(INPUT_POST, 'body');
            
            if(!empty($body)) {
                $body = addslashes($body);
                $sql = "update page_fragment set body='$body' where id=$id";
                $this->errorMessage = (new Executer($sql))->error;
            }
        }
        
        if(null !== filter_input(INPUT_POST, 'page_fragment_delete_submit')) {
            $id = filter_input(INPUT_POST, 'id');
            $this->errorMessage = (new Executer("delete from page_fragment where id=$id"))->error;
        }
        
        if(null !== filter_input(INPUT_POST, 'page_fragment_up_submit')) {
            $id = filter_input(INPUT_POST, 'id');
            $page = filter_input(INPUT_POST, 'page');
            $position = filter_input(INPUT_POST, 'position');
            
            if($row = (new Fetcher("select id, position from page_fragment where page='$page' and position<$position order by position desc limit 1"))->Fetch()) {
                $previous_id = $row['id'];
                $previous_position = $row['position'];
                
                $this->errorMessage = (new Executer("update page_fragment set position=$position where id=$previous_id"))->error;
                
                if(empty($this->errorMessage)) {
                    $this->errorMessage = (new Executer("update page_fragment set position=$previous_position where id=$id"))->error;
                }
            }
        }
        
        if(null !== filter_input(INPUT_POST, 'page_fragment_down_submit')) {
            $id = filter_input(INPUT_POST, 'id');
            $page = filter_input(INPUT_POST, 'page');
            $position = filter_input(INPUT_POST, 'position');
            
            if($row = (new Fetcher("select id, position from page_fragment where page='$page' and position>$position order by position asc limit 1"))->Fetch()) {
                $next_id = $row['id'];
                $next_position = $row['position'];
                
                $this->errorMessage = (new Executer("update page_fragment set position=$position where id=$next_id"))->error;
                
                if(empty($this->errorMessage)) {
                    $this->errorMessage = (new Executer("update page_fragment set position=$next_position where id=$id"))->error;
                }
            }
        }
        
        if(null !== filter_input(INPUT_POST, 'upload_image_submit')) {
            $name = filter_input(INPUT_POST, 'name');
            $max_width = filter_input(INPUT_POST, 'max_width');
            $max_height = filter_input(INPUT_POST, 'max_height');
            
            if($_FILES['file']['error'] == 0 && !empty($name)) {
                if(exif_imagetype($_FILES['file']['tmp_name'])) {
                    $image_size = getimagesize($_FILES['file']['tmp_name']);
                    $width = $image_size[0];
                    $height = $image_size[1];
                    $extension = image_type_to_extension($image_size[2]);
                    
                    $upload_path = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT').APPLICATION."/images/content/";
                    $romanized_name = Romanize($_FILES['file']['name']);
                    $final_name = $romanized_name;
                    
                    while (file_exists($upload_path.$final_name)) {
                        $final_name = time().'_'.$romanized_name;
                    }
                    
                    if(move_uploaded_file($_FILES['file']['tmp_name'], $upload_path.$final_name)) {
                        $name = addslashes($name);
                        $sql = "insert into page_image (page, name, filename, width, height, extension) values ('$this->page', '$name', '$final_name', $width, $height, '$extension')";
                        $this->errorMessage = (new Executer($sql))->error;
                    }
                    else {
                        $this->errorMessage = "Ошибка при загрузке файла";
                    }
                }
                else {
                    $this->errorMessage = "Файл не является изображением";
                }
            }
        }
    }

    public function GetFragments() {
        $sql = "select id, body from page_fragment where page = '$this->page' order by position";
        $fetcher = new Fetcher($sql);
        while ($row = $fetcher->Fetch()) {
            echo $row['body'];
        }
    }
    
    public function GetFragmentsEditMode() {
        $sql = "select id, page, body, position from page_fragment where page = '$this->page' order by position";
        $fetcher = new Fetcher($sql);
        while ($row = $fetcher->Fetch()):
        ?>
        <div class="row" style="border-top: solid 1px lightgray;">
            <div class="col-8">
                <?php
                if(null !== filter_input(INPUT_POST, 'page_fragment_edit_submit')) {
                    $id = filter_input(INPUT_POST, 'id');
                    
                    if($id == $row['id']) {
                        include 'edit_fragment_form.php';
                    }
                    else {
                        echo $row['body'];
                    }
                }
                else {
                    echo $row['body'];
                }
                ?>
            </div>
            <div class="col-4 text-right">
                <form method="post">
                    <input type="hidden" id="id" name="id" value="<?=$row['id'] ?>" />
                    <input type="hidden" id="page" name="page" value="<?=$row['page'] ?>" />
                    <input type="hidden" id="position" name="position" value="<?=$row['position'] ?>" />
                    <input type="hidden" id="scroll" name="scroll" />
                    <div class="btn-group text-right">
                        <button type="submit" id="page_fragment_up_submit" name="page_fragment_up_submit" class="btn btn-outline-dark" title="Вверх" data-toggle="tooltip"><i class="fas fa-arrow-up"></i></button>
                        <button type="submit" id="page_fragment_down_submit" name="page_fragment_down_submit" class="btn btn-outline-dark" title="Вниз" data-toggle="tooltip"><i class="fas fa-arrow-down"></i></button>
                        <button type="submit" id="page_fragment_edit_submit" name="page_fragment_edit_submit" class="btn btn-outline-dark" title="Редактировать" data-toggle="tooltip"><i class="fas fa-edit"></i></button>
                        <button type="submit" id="page_fragment_delete_submit" name="page_fragment_delete_submit" class="btn btn-outline-dark confirmable" title="Удалить" data-toggle="tooltip"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <?php
        endwhile;
    }

    public function ShowCreateFragmentForm() {
        include 'create_fragment_form.php';
    }
    
    public function GetImages() {
        $sql = "select id, name, filename, width, height, extension from page_image where page = '$this->page' order by id";
        $fetcher = new Fetcher($sql);
        while ($row = $fetcher->Fetch()):
        $src = filter_input(INPUT_SERVER, 'REQUEST_SCHEME').'://'. filter_input(INPUT_SERVER, 'HTTP_HOST').APPLICATION."/images/content/".$row['filename'];
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
                    <input type="hidden" id="filename" name="filename" />
                    <button type="submit" class="btn btn-outline-dark confirmable" id="delete_image_submit" name="delete_image_submit"><i class="fas fa-trash-alt"></i>&nbsp;Удалить</button>
                </form>
            </div>
        </div>
    </div>
</div>
        <?php
        endwhile;
    }
    
    public function ShowUploadImageForm() {
        include 'upload_image_form.php';
    }
}
?>