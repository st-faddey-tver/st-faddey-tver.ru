<?php
include $_SERVER['DOCUMENT_ROOT'].APPLICATION.'/include/myimage.php';

class Page {
    public function __construct($shortname) {
        $sql = "select id, name, inmenu, title, description, keywords, image from page where shortname = '$shortname'";
        $fetcher = new Fetcher($sql);
        
        if($row = $fetcher->Fetch()) {
            $this->id = $row['id'];
            $this->name = htmlentities($row['name']);
            $this->shortname = $shortname;
            $this->inmenu = $row['inmenu'];
            $this->title = htmlentities($row['title']);
            $this->description = htmlentities($row['description']);
            $this->keywords = htmlentities($row['keywords']);
            $this->image = htmlentities($row['image']);
        }
    }
    
    public $id;
    public $name;
    public $shortname;
    public $inmenu;
    public $title;
    public $description;
    public $keywords;
    public $image;
    public $errorMessage;

    public function Top() {
        $form_valid = true;
        $error_message = '';

        if(null !== filter_input(INPUT_POST, 'create_fragment_submit')) {
            $body = filter_input(INPUT_POST, 'body');
            
            if(!empty($body)) {
                $sql = "select ifnull(max(position), 0) max_position from page_fragment where page_id = '$this->id'";
                $fetcher = new Fetcher($sql);
                
                if($row = $fetcher->Fetch()) {
                    $position = intval($row['max_position']) + 1;
                }
                
                $body = addslashes($body);
                $sql = "insert into page_fragment (page_id, body, position) values ('$this->id', '$body', $position)";
                $executer = new Executer($sql);
                $this->errorMessage = $executer->error;
            }
        }
        
        if(null !== filter_input(INPUT_POST, 'edit_fragment_submit')) {
            $id = filter_input(INPUT_POST, 'id');
            $body = filter_input(INPUT_POST, 'body');
            
            if(!empty($body)) {
                $body = addslashes($body);
                $sql = "update page_fragment set body = '$body' where id = $id";
                $executer = new Executer($sql);
                $this->errorMessage = $executer->error;
            }
        }
        
        if(null !== filter_input(INPUT_POST, 'fragment_delete_submit')) {
            $id = filter_input(INPUT_POST, 'id');
            $sql = "delete from page_fragment where id = $id";
            $executer = new Executer($sql);
            $this->errorMessage = $executer->error;
        }
        
        if(null !== filter_input(INPUT_POST, 'fragment_up_submit')) {
            $id = filter_input(INPUT_POST, 'id');
            $page_id = filter_input(INPUT_POST, 'parent_id');
            $position = filter_input(INPUT_POST, 'position');
            $sql = "select id, position from page_fragment where page_id = '$page_id' and position < $position order by position desc limit 1";
            $fetcher = new Fetcher($sql);
            
            if($row = $fetcher->Fetch()) {
                $previous_id = $row['id'];
                $previous_position = $row['position'];
                $sql = "update page_fragment set position=$position where id = $previous_id";
                $executer = new Executer($sql);
                $this->errorMessage = $executer->error;
                
                if(empty($this->errorMessage)) {
                    $sql = "update page_fragment set position = $previous_position where id = $id";
                    $executer = new Executer($sql);
                    $this->errorMessage = $executer->error;
                }
            }
        }
        
        if(null !== filter_input(INPUT_POST, 'fragment_down_submit')) {
            $id = filter_input(INPUT_POST, 'id');
            $page_id = filter_input(INPUT_POST, 'page_id');
            $position = filter_input(INPUT_POST, 'position');
            $sql = "select id, position from page_fragment where page_id = '$page_id' and position > $position order by position asc limit 1";
            $fetcher = new Fetcher($sql);
            
            if($row = $fetcher->Fetch()) {
                $next_id = $row['id'];
                $next_position = $row['position'];
                $sql = "update page_fragment set position = $position where id = $next_id";
                $executer = new Executer($sql);
                $this->errorMessage = $executer->error;
                
                if(empty($this->errorMessage)) {
                    $sql = "update page_fragment set position = $next_position where id = $id";
                    $executer = new Executer($sql);
                    $this->errorMessage = $executer->error;
                }
            }
        }
        
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
                        $sql = "insert into page_image (page_id, name, filename, width, height, extension) values ('$this->id', '$name', '$myimage->filename', $myimage->width, $myimage->height, '$myimage->extension')";
                        $executer = new Executer($sql);
                        $this->errorMessage = $executer->error;
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
            $upload_path = $_SERVER['DOCUMENT_ROOT'].APPLICATION."/images/content/";
            $filepath = $upload_path.$filename;
            
            $sql = "delete from page_image where id = $id";
            $executer = new Executer($sql);
            $this->errorMessage = $executer->error;
            
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
        $sql = "select id, body from page_fragment where page_id = '$this->id' order by position";
        $fetcher = new Fetcher($sql);
        while ($row = $fetcher->Fetch()) {
            echo $row['body'];
        }
    }
    
    public function GetFragmentsEditMode() {
        $sql = "select id, page_id, body, position from page_fragment where page_id = '$this->id' order by position";
        $fetcher = new Fetcher($sql);
        while ($row = $fetcher->Fetch()) {
            $id = $row['id'];
            $parent_id = $row['page_id'];
            $position = $row['position'];
            include 'fragments/edit_mode_row.php';
        }
    }

    public function ShowCreateFragmentForm() {
        include 'fragments/create_fragment_form.php';
    }
    
    public function GetImages() {
        $sql = "select id, name, filename, width, height, extension from page_image where page_id = '$this->id' order by id";
        $fetcher = new Fetcher($sql);
        while ($row = $fetcher->Fetch()) {
            $src = $_SERVER['REQUEST_SCHEME'].'://'. $_SERVER['HTTP_HOST'].APPLICATION."/images/content/".$row['filename'];
            include 'fragments/fragment_image_row.php';
        }
    }
    
    public function ShowUploadImageForm() {
        include 'fragments/upload_image_form.php';
    }
}
?>