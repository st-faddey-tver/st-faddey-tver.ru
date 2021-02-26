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
                    $myimage = new MyImage($_FILES['file']['tmp_name']);
                    $file_uploaded = $myimage->ResizeAndSave($_SERVER['DOCUMENT_ROOT'].APPLICATION."/images/content/", $max_width, $max_height);
                    
                    /*$image_size = getimagesize($_FILES['file']['tmp_name']);
                    $width = $image_size[0];
                    $height = $image_size[1];
                    $extension = image_type_to_extension($image_size[2]);
                    
                    $upload_path = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT').APPLICATION."/images/content/";
                    $romanized_name = Romanize($_FILES['file']['name']);
                    $final_name = $romanized_name;
                    
                    while (file_exists($upload_path.$final_name)) {
                        $final_name = time().'_'.$romanized_name;
                    }
                    
                    $file_uploaded = false;
                    $dest_height = 0;
                    $dest_width = 0;
                    
                    if((empty($max_height) || $max_height >= $height) && ($max_width == 0 || $max_width >= $width)) {
                        $file_uploaded = move_uploaded_file($_FILES['file']['tmp_name'], $upload_path.$final_name);
                    }
                    else {
                        if(empty($max_height) && !empty($max_width)) {
                            $dest_width = $max_width;
                            $dest_height = $height * $max_width / $width;
                        }
                        
                        if(!empty($max_height) && empty($max_width)) {
                            $dest_height = $max_height;
                            $dest_width = $width * $max_height / $height;
                        }
                        
                        if(!empty($max_height) && !empty($max_width)) {
                            $dest_width = $max_width;
                            $dest_height = $height * $max_width / $width;
                            
                            if($dest_height > $max_height) {
                                $dest_height = $max_height;
                                $dest_width = $width * $max_height / $height;
                            }
                        }
                        
                        $src_image = null;
                        $dest_image = imagecreatetruecolor($dest_width, $dest_height);
                        
                        switch ($image_size[2]) {
                        case IMG_BMP:
                            $src_image = imagecreatefrombmp($_FILES['file']['tmp_name']);
                            imagecopyresampled($dest_image, $src_image, 0, 0, 0, 0, $dest_width, $dest_height, $width, $height);
                            $file_uploaded = imagebmp($dest_image, $upload_path.$final_name);
                            break;
                        
                        case IMG_GIF:
                            $src_image = imagecreatefromgif($_FILES['file']['tmp_name']);
                            imagecopyresampled($dest_image, $src_image, 0, 0, 0, 0, $dest_width, $dest_height, $width, $height);
                            $file_uploaded = imagegif($dest_image, $upload_path.$final_name);
                            break;
                        
                        case IMG_JPG:
                            $src_image = imagecreatefromjpeg($_FILES['file']['tmp_name']);
                            imagecopyresampled($dest_image, $src_image, 0, 0, 0, 0, $dest_width, $dest_height, $width, $height);
                            $file_uploaded = imagejpeg($dest_image, $upload_path.$final_name);
                            break;
                        
                        case IMG_JPEG:
                            $src_image = imagecreatefromjpeg($_FILES['file']['tmp_name']);
                            imagecopyresampled($dest_image, $src_image, 0, 0, 0, 0, $dest_width, $dest_height, $width, $height);
                            $file_uploaded = imagejpeg($dest_image, $upload_path.$final_name);
                            break;
                        
                        case IMG_PNG:
                            $src_image = imagecreatefrompng($_FILES['file']['tmp_name']);
                            imagecopyresampled($dest_image, $src_image, 0, 0, 0, 0, $dest_width, $dest_height, $width, $height);
                            $file_uploaded = imagepng($dest_image, $upload_path.$final_name);
                            break;
                        
                        case IMG_WBMP:
                            $src_image = imagecreatefromwbmp($_FILES['file']['tmp_name']);
                            imagecopyresampled($dest_image, $src_image, 0, 0, 0, 0, $dest_width, $dest_height, $width, $height);
                            $file_uploaded = imagewbmp($dest_image, $upload_path.$final_name);
                            break;
                        
                        case IMG_WEBP:
                            $src_image = imagecreatefromwebp($_FILES['file']['tmp_name']);
                            imagecopyresampled($dest_image, $src_image, 0, 0, 0, 0, $dest_width, $dest_height, $width, $height);
                            $file_uploaded = imagewebp($dest_image, $upload_path.$final_name);
                            break;
                        
                        case IMG_XPM:
                            $src_image = imagecreatefromxpm($_FILES['file']['tmp_name']);
                            imagecopyresampled($dest_image, $src_image, 0, 0, 0, 0, $dest_width, $dest_height, $width, $height);
                            $file_uploaded = imagexbm($dest_image, $upload_path.$final_name);
                            break;
                        }
                        
                        $image_size = getimagesize($upload_path.$final_name);
                        $width = $image_size[0];
                        $height = $image_size[1];
                    }*/
                    
                    if($file_uploaded) {
                        $name = addslashes($name);
                        $sql = "insert into page_image (page, name, filename, width, height, extension) values ('$this->page', '$name', '$myimage->filename', $myimage->width, $myimage->height, '$myimage->extension')";
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