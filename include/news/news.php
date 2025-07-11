<?php
include $_SERVER['DOCUMENT_ROOT'].APPLICATION.'/include/myimage.php';

class News {
    public function __construct($news_id) {
        $this->newsId = $news_id;
    }
    
    private $newsId;
    public $errorMessage;

    public function Top() {
        $form_valid = true;
        $error_message = '';

        if(null !== filter_input(INPUT_POST, 'create_fragment_submit')) {
            $body = filter_input(INPUT_POST, 'body');
            
            if(!empty($body)) {
                $sql = "select ifnull(max(position), 0) max_position from news_fragment where news_id = '$this->newsId'";
                $row = (new Fetcher($sql))->Fetch();
                $position = intval($row['max_position']) + 1;
                
                $body = addslashes($body);
                $sql = "insert into news_fragment (news_id, body, position) values ('$this->newsId', '$body', $position)";
                $this->errorMessage = (new Executer($sql))->error;
            }
        }
        
        if(null !== filter_input(INPUT_POST, 'edit_fragment_submit')) {
            $id = filter_input(INPUT_POST, 'id');
            $body = filter_input(INPUT_POST, 'body');
            
            if(!empty($body)) {
                $body = addslashes($body);
                $sql = "update news_fragment set body='$body' where id=$id";
                $this->errorMessage = (new Executer($sql))->error;
            }
        }
        
        if(null !== filter_input(INPUT_POST, 'fragment_delete_submit')) {
            $id = filter_input(INPUT_POST, 'id');
            $this->errorMessage = (new Executer("delete from news_fragment where id=$id"))->error;
        }
        
        if(null !== filter_input(INPUT_POST, 'fragment_up_submit')) {
            $id = filter_input(INPUT_POST, 'id');
            $news_id = filter_input(INPUT_POST, 'news_id');
            $position = filter_input(INPUT_POST, 'position');
            
            if($row = (new Fetcher("select id, position from news_fragment where news_id='$news_id' and position<$position order by position desc limit 1"))->Fetch()) {
                $previous_id = $row['id'];
                $previous_position = $row['position'];
                
                $this->errorMessage = (new Executer("update news_fragment set position=$position where id=$previous_id"))->error;
                
                if(empty($this->errorMessage)) {
                    $this->errorMessage = (new Executer("update news_fragment set position=$previous_position where id=$id"))->error;
                }
            }
        }
        
        if(null !== filter_input(INPUT_POST, 'fragment_down_submit')) {
            $id = filter_input(INPUT_POST, 'id');
            $news_id = filter_input(INPUT_POST, 'news_id');
            $position = filter_input(INPUT_POST, 'position');
            
            if($row = (new Fetcher("select id, position from news_fragment where news_id='$news_id' and position>$position order by position asc limit 1"))->Fetch()) {
                $next_id = $row['id'];
                $next_position = $row['position'];
                
                $this->errorMessage = (new Executer("update news_fragment set position=$position where id=$next_id"))->error;
                
                if(empty($this->errorMessage)) {
                    $this->errorMessage = (new Executer("update news_fragment set position=$next_position where id=$id"))->error;
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
                        $sql = "insert into news_image (news_id, name, filename, width, height, extension) values ('$this->newsId', '$name', '$myimage->filename', $myimage->width, $myimage->height, '$myimage->extension')";
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
            $upload_path = $_SERVER['DOCUMENT_ROOT'].APPLICATION."/images/content/";
            $filepath = $upload_path.$filename;
            
            $this->errorMessage = (new Executer("delete from news_image where id=$id"))->error;
            
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
        $sql = "select id, body from news_fragment where news_id = '$this->newsId' order by position";
        $fetcher = new Fetcher($sql);
        while ($row = $fetcher->Fetch()) {
            echo $row['body'];
        }
    }
    
    public function GetFragmentsEditMode() {
        $sql = "select id, news_id, body, position from news_fragment where news_id = '$this->newsId' order by position";
        $fetcher = new Fetcher($sql);
        while ($row = $fetcher->Fetch()) {
            include 'edit_mode_row.php';
        }
    }

    public function ShowCreateFragmentForm() {
        include 'create_fragment_form.php';
    }
    
    public function GetImages() {
        $sql = "select id, name, filename, width, height, extension from news_image where news_id = '$this->newsId' order by id";
        $fetcher = new Fetcher($sql);
        while ($row = $fetcher->Fetch()) {
            $src = $_SERVER['REQUEST_SCHEME'].'://'. $_SERVER['HTTP_HOST'].APPLICATION."/images/content/".$row['filename'];
            include 'fragment_image_row.php';
        }
    }
    
    public function ShowUploadImageForm() {
        include 'upload_image_form.php';
    }
}
?>