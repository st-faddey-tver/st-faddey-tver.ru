<?php
include 'define.php';

global $weekdays;

$weekdays = array();
$weekdays[1] = 'Понедельник';
$weekdays[2] = 'Вторник';
$weekdays[3] = 'Среда';
$weekdays[4] = 'Четверг';
$weekdays[5] = 'Пятница';
$weekdays[6] = 'Суббота';
$weekdays[7] = 'Воскресенье';

// Функции
function LoggedIn() {
    return !empty(filter_input(INPUT_COOKIE, USERNAME));
}

function GetUserId() {
    return filter_input(INPUT_COOKIE, USER_ID);
}

function IsInRole($param) {
    $roles = filter_input(INPUT_COOKIE, ROLES);
    
    if(!empty($roles)){
        $arr_roles = unserialize($roles);
        
        if(is_array($param)) {
            foreach ($param as $role) {
                if(in_array($role, $arr_roles)) {
                    return true;
                }
            }
        }
        else {
            return in_array($param, $arr_roles);
        }
    }
    
    return false;
}

function HasRole() {
    $roles = filter_input(INPUT_COOKIE, ROLES);
    
    if(!empty($roles)) {
        $arr_roles = unserialize($roles);
        
        if(is_array($arr_roles) && count($arr_roles) > 0) {
            return true;
        }
    }
    
    return false;
}

function Romanize($param) {
    $local_to_roman = array('а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y',
        'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f',
        'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
        'А' => 'a', 'Б' => 'b', 'В' => 'v', 'Г' => 'g', 'Д' => 'd', 'Е' => 'e', 'Ё' => 'e', 'Ж' => 'zh', 'З' => 'z', 'И' => 'i', 'Й' => 'y',
        'К' => 'k', 'Л' => 'l', 'М' => 'm', 'Н' => 'n', 'О' => 'o', 'П' => 'p', 'Р' => 'r', 'С' => 's', 'Т' => 't', 'У' => 'u', 'Ф' => 'f',
        'Х' => 'kh', 'Ц' => 'ts', 'Ч' => 'ch', 'Ш' => 'sh', 'Щ' => 'shch', 'Ъ' => '', 'Ы' => 'y', 'Ь' => '', 'Э' => 'e', 'Ю' => 'yu', 'Я' => 'ya',
        'a' => 'a', 'b' => 'b', 'c' => 'c', 'd' => 'd', 'e' => 'e', 'f' => 'f', 'g' => 'g', 'h' => 'h', 'i' => 'i', 'j' => 'j', 'k' => 'k', 'l' => 'l', 'm' => 'm',
        'n' => 'n', 'o' => 'o', 'p' => 'p', 'q' => 'q', 'r' => 'r', 's' => 's', 't' => 't', 'u' => 'u', 'v' => 'v', 'w' => 'w', 'x' => 'x', 'y' => 'y', 'z' => 'z',
        'A' => 'a', 'B' => 'b', 'C' => 'c', 'D' => 'd', 'E' => 'e', 'F' => 'f', 'G' => 'g', 'H' => 'h', 'I' => 'i', 'J' => 'j', 'K' => 'k', 'L' => 'l', 'M' => 'm',
        'N' => 'n', 'O' => 'o', 'P' => 'p', 'Q' => 'q', 'R' => 'r', 'S' => 's', 'T' => 't', 'U' => 'u', 'V' => 'v', 'W' => 'w', 'X' => 'x', 'Y' => 'y', 'Z' => 'z',
        '0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', ' ' => '_', '-' => '_', '.' => '.');
    
    $strlen = mb_strlen($param);
    $result = '';
    
    for($i=0; $i<$strlen; $i++) {
        $key = mb_substr($param, $i, 1);
        if(array_key_exists($key, $local_to_roman)) {
            $result .= $local_to_roman[$key];
        }
    }
    
    return $result;
}

function BuildQuery($key, $value) {
    $result = '';
    $get_params = $_GET;
    $get_params[$key] = $value;
    $result = http_build_query($get_params);
    
    if(!empty($result)) {
        $result = "?$result";
    }
    
    return $result;
}

function BuildQueryRemove($key) {
    $result = '';
    $get_params = $_GET;
    unset($get_params[$key]);
    $result = http_build_query($get_params);

    if(!empty($result)) {
        $result = "?$result";
    }
    
    return $result;
}

function ShowKeys($arr_param) {
    if(is_array($arr_param)) {
        foreach ($arr_param as $key) {
            echo "<button type='button' class='btn btn-outline-dark mr-2 mb-2 vk_btn' style='width: 40px; height: 40px;'>$key</button>";
        }
    }
}

// Классы
class Executer {
    public $error = '';
    public $insert_id = 0;
            
    function __construct($sql) {
        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);

        if($conn->connect_error) {
            $this->error = 'Ошибка соединения: '.$conn->connect_error;
            return;
        }
        
        $conn->query('set names utf8');
        $conn->query($sql);
        $this->error = $conn->error;
        $this->insert_id = $conn->insert_id;
        
        $conn->close();
    }
}

class Grabber {
    public  $error = '';
    public $result = array();
            
    function __construct($sql) {
        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
        
        if($conn->connect_error) {
            $this->error = 'Ошибка соединения: '.$conn->connect_error;
            return;
        }
        
        $conn->query('set names utf8');
        $result = $conn->query($sql);
        
        if(is_bool($result)) {
            $this->error = $conn->error;
        }
        else {
            $this->result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        
        $conn->close();
    }
}

class Fetcher {
    public $error = '';
    private $result;
            
    function __construct($sql) {
        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
        
        if($conn->connect_error) {
            $this->error = 'Ошибка соединения: '.$conn->connect_error;
            return;
        }
        
        $conn->query('set names utf8');
        $this->result = $conn->query($sql);
        
        if(is_bool($this->result)) {
            $this->error = $conn->error;
        }
        
        $conn->close();
    }
    
    function Fetch() {
        return mysqli_fetch_array($this->result);
    }
}

// Валидация формы логина
define('LOGINISINVALID', ' is-invalid');
$login_form_valid = true;

$login_username_valid = '';
$login_password_valid = '';

// Обработка отправки формы логина
if(null !== filter_input(INPUT_POST, 'login_submit')) {
    $login_username = filter_input(INPUT_POST, 'login_username');
    if(empty($login_username)) {
        $login_username_valid = LOGINISINVALID;
        $login_form_valid = false;
    }
    
    $login_password = filter_input(INPUT_POST, 'login_password');
    if(empty($login_password)) {
        $login_password_valid = LOGINISINVALID;
        $login_form_valid = false;
    }
    
    if($login_form_valid) {
        $user_id = '';
        $username = '';
        $last_name = '';
        $first_name = '';
        $middle_name = '';
        
        $sql = "select id, username, last_name, first_name, middle_name from user where username='$login_username' and password=password('$login_password')";
        $users_result = (new Grabber($sql))->result;
        
        foreach ($users_result as $row) {
            $user_id = $row['id'];
            $username = $row['username'];
            $last_name = $row['last_name'];
            $first_name = $row['first_name'];
            $middle_name = $row['middle_name'];
        }
        
        if(empty($user_id) || empty($username)) {
            $error_message = "Неправильный логин или пароль";
        }
        else {
            setcookie(USER_ID, $user_id, 0, "/");
            setcookie(USERNAME, $username, 0, "/");
            setcookie(LAST_NAME, $last_name, 0, "/");
            setcookie(FIRST_NAME, $first_name, 0, "/");
            setcookie(MIDDLE_NAME, $middle_name, 0, "/");
            
            $roles = array();
            $role_i = 0;
            $roles_result = (new Grabber("select r.name from user_role ur inner join role r on ur.role_id = r.id where ur.user_id = $user_id"))->result;
            
            foreach ($roles_result as $role_row) {
                $roles[$role_i++] = $role_row['name'];
            }
            
            setcookie(ROLES, serialize($roles), 0, '/');
            
            header("Refresh:0");
            header('Location: '.APPLICATION.'/admin/');
        }
    }
}

// Выход из системы
if(null !== filter_input(INPUT_POST, 'logout_submit')) {
    setcookie(USER_ID, '', 0, "/");
    setcookie(USERNAME, '', 0, "/");
    setcookie(LAST_NAME, '', 0, "/");
    setcookie(FIRST_NAME, '', 0, "/");
    setcookie(MIDDLE_NAME, '', 0, "/");
    setcookie(ROLES, '', 0, "/");
    header("Refresh:0");
    header('Location: '.APPLICATION.'/');
}
?>