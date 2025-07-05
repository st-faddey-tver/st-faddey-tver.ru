<?php
include $_SERVER['DOCUMENT_ROOT'].APPLICATION.'/include/myimage.php';

class Cantus {
    public function __construct($shortname) {
        $sql = "select id, beginning, name, shortname, cycle, tone, month, day, position, title, description, keywords from cantus where shortname = '$shortname'";
        $fetcher = new Fetcher($sql);
        
        if($row = $fetcher->Fetch()) {
            $this->id = $row["id"];
            $this->beginning = htmlentities($row["beginning"]);
            $this->name = htmlentities($row["name"]);
            $this->shortname = $row["shortname"];
            $this->cycle = $row["cycle"];
            $this->tone = $row["tone"];
            $this->month = $row["month"];
            $this->day = $row["day"];
            $this->position = $row["position"];
            $this->title = htmlentities($row["title"]);
            $this->description = htmlentities($row["description"]);
            $this->keywords = htmlentities($row["keywords"]);
        }
    }
    
    public $id;
    public $beginning;
    public $name;
    public $shortname;
    public $cycle;
    public $tone;
    public $month;
    public $day;
    public $position;
    public $title;
    public $description;
    public $keywords;
    public $errorMessage;
    
    public function Top() {
        $form_valid = true;
        $error_message = '';

        if(null !== filter_input(INPUT_POST, 'create_fragment_submit')) {
            $body = filter_input(INPUT_POST, 'body');
            
            if(!empty($body)) {
                $sql = "select ifnull(max(position), 0) max_position from cantus_fragment where cantus_id = '$this->id'";
                $fetcher = new Fetcher($sql);
                
                if($row = $fetcher->Fetch()) {
                    $position = intval($row['max_position']) + 1;
                }
                
                $body = addslashes($body);
                $sql = "insert into cantus_fragment (cantus_id, body, position) values ('$this->id', '$body', $position)";
                $executer = new Executer($sql);
                $this->errorMessage = $executer->error;
            }
        }
        
        if(null !== filter_input(INPUT_POST, 'edit_fragment_submit')) {
            $id = filter_input(INPUT_POST, 'id');
            $body = filter_input(INPUT_POST, 'body');
            
            if(!empty($body)) {
                $body = addslashes($body);
                $sql = "update cantus_fragment set body = '$body' where id = $id";
                $executer = new Executer($sql);
                $this->errorMessage = $executer->error;
            }
        }
        
        if(null !== filter_input(INPUT_POST, 'fragment_delete_submit')) {
            $id = filter_input(INPUT_POST, 'id');
            $sql = "delete from cantus_fragment where id = $id";
            $executer = new Executer($sql);
            $this->errorMessage = $executer->error;
        }
        
        if(null !== filter_input(INPUT_POST, 'fragment_up_submit')) {
            $id = filter_input(INPUT_POST, 'id');
            $cantus_id = filter_input(INPUT_POST, 'parent_id');
            $position = filter_input(INPUT_POST, 'position');
            $sql = "select id, position from cantus_fragment where cantus_id = '$cantus_id' and position < $position order by position desc limit 1";
            $fetcher = new Fetcher($sql);
            
            if($row = $fetcher->Fetch()) {
                $previous_id = $row['id'];
                $previous_position = $row['position'];
                $sql = "update cantus_fragment set position = $position where id = $previous_id";
                $executer = new Executer($sql);
                $this->errorMessage = $executer->error;
                
                if(empty($this->errorMessage)) {
                    $sql = "update cantus_fragment set position = $previous_position where id = $id";
                    $executer = new Executer($sql);
                    $this->errorMessage = $executer->error;
                }
            }
        }
        
        if(null !== filter_input(INPUT_POST, 'fragment_down_submit')) {
            $id = filter_input(INPUT_POST, 'id');
            $cantus_id = filter_input(INPUT_POST, 'parent_id');
            $position = filter_input(INPUT_POST, 'position');
            $sql = "select id, position from cantus_fragment where cantus_id = '$cantus_id' and position > $position order by position asc limit 1";
            $fetcher = new Fetcher($sql);
            
            if($row = $fetcher->Fetch()) {
                $next_id = $row['id'];
                $next_position = $row['position'];
                $sql = "update cantus_fragment set position = $position where id = $next_id";
                $executer = new Executer($sql);
                $this->errorMessage = $executer->error;
                
                if(empty($this->errorMessage)) {
                    $sql = "update cantus_fragment set position = $next_position where id = $id";
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
                        $sql = "insert into cantus_image (cantus_id, name, filename, width, height, extension) values ('$this->id', '$name', '$myimage->filename', $myimage->width, $myimage->height, '$myimage->extension')";
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
            
            $sql = "delete from cantus_image where id = $id";
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
        $sql = "select id, body from cantus_fragment where cantus_id = '$this->id' order by position";
        $fetcher = new Fetcher($sql);
        while ($row = $fetcher->Fetch()) {
            echo $row['body'];
        }
    }
    
    public function GetFragmentsEditMode() {
        $sql = "select id, cantus_id, body, position from cantus_fragment where cantus_id = '$this->id' order by position";
        $fetcher = new Fetcher($sql);
        while ($row = $fetcher->Fetch()) {
            $id = $row['id'];
            $parent_id = $row['cantus_id'];
            $position = $row['position'];
            include 'fragments/edit_mode_row.php';
        }
    }

    public function ShowCreateFragmentForm() {
        include 'fragments/create_fragment_form.php';
    }
    
    public function GetImages() {
        $sql = "select id, name, filename, width, height, extension from cantus_image where cantus_id = '$this->id' order by id";
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