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
        
        if(null !== filter_input(INPUT_POST, 'delete_image_submit')) {
            $id = filter_input(INPUT_POST, 'id');
            $filename = filter_input(INPUT_POST, 'filename');
            $upload_path = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT').APPLICATION."/images/content/";
            $filepath = $upload_path.$filename;
            
            $this->errorMessage = (new Executer("delete from page_image where id=$id"))->error;
            
            if(empty($this->errorMessage)) {
                if(file_exists($filepath)) {
                    if(!unlink($filepath)) {
                        $this->errorMessage = "Ошибка при удалении файла";
                    }
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
        while ($row = $fetcher->Fetch()) {
            include 'page_edit_mode_row.php';
        }
    }

    public function ShowCreateFragmentForm() {
        include 'create_fragment_form.php';
    }
    
    public function GetImages() {
        $sql = "select id, name, filename, width, height, extension from page_image where page = '$this->page' order by id";
        $fetcher = new Fetcher($sql);
        while ($row = $fetcher->Fetch()) {
            $src = filter_input(INPUT_SERVER, 'REQUEST_SCHEME').'://'. filter_input(INPUT_SERVER, 'HTTP_HOST').APPLICATION."/images/content/".$row['filename'];
            include 'fragment_image_row.php';
        }
    }
    
    public function ShowUploadImageForm() {
        include 'upload_image_form.php';
    }
}
?>