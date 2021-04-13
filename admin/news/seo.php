<?php
include '../include/topscripts.php';
include '../include/page/page.php';

// Авторизация
if(!IsInRole(array('admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}


// Если нет параметра is_event, переход на главную страницу администратора
$is_event = filter_input(INPUT_GET, 'is_event');
if($is_event === null) {
    header('Location: '.APPLICATION."/admin/");
}

// Если нет параметра id, переход к списку
$id = filter_input(INPUT_GET, 'id');
if(empty($id)) {
    header('Location: '.APPLICATION."/admin/news/". BuildQuery('is_event', $is_event));
}

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, "seo-submit")) {
    $title = addslashes(filter_input(INPUT_POST, "title"));
    $description = addslashes(filter_input(INPUT_POST, "description"));
    $keywords = addslashes(filter_input(INPUT_POST, "keywords"));
    $id = filter_input(INPUT_POST, "id");
    
    $sql = "update news set title = '$title', description = '$description', keywords = '$keywords' where id = '$id'";
    $error_message = (new Executer($sql))->error;
}

// Получение объекта
$title = '';
$description = '';
$keywords = '';

$sql = "select title, description, keywords from news where id=$id";
$fetcher = new Fetcher($sql);
$error_message = $fetcher->error;

if($row = $fetcher->Fetch()) {
    $title = $row['title'];
    $description = $row['description'];
    $keywords = $row['keywords'];
}
?>