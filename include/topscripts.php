<?php
include 'define.php';

global $weekdays;

$weekdays = array();
$weekdays[0] = 'Вс';
$weekdays[1] = 'Пн';
$weekdays[2] = 'Вт';
$weekdays[3] = 'Ср';
$weekdays[4] = 'Чт';
$weekdays[5] = 'Пт';
$weekdays[6] = 'Сб';

// Функции
function LoggedIn() {
    return !empty(filter_input(INPUT_COOKIE, USERNAME));
}

function GetUserId() {
    return filter_input(INPUT_COOKIE, USER_ID);
}

function IsInRole($role) {
    $cookie = filter_input(INPUT_COOKIE, ROLE);
    
    if(is_array($role)) {
        return in_array($cookie, $role);
    }
    else {
        return $cookie == $role;
    }
    
    return false;
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
        $role = '';
        $twofactor = 0;
        
        $sql = "select u.id, u.username, u.last_name, u.first_name, u.email, r.name role, r.twofactor "
                . "from user u "
                . "inner join role r on u.role_id=r.id "
                . "where u.username='$login_username' and u.password=password('$login_password')";
        
        $users_result = (new Grabber($sql))->result;
        
        foreach ($users_result as $row) {
            $user_id = $row['id'];
            $username = $row['username'];
            $last_name = $row['last_name'];
            $first_name = $row['first_name'];
            $middle_name = $row['middle_name'];
            $role = $row['role'];
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
            setcookie(ROLE, $role, 0, "/");
            header("Refresh:0");
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
    setcookie(ROLE, '', 0, "/");
    header("Refresh:0");
    header('Location: '.APPLICATION.'/');
}
?>