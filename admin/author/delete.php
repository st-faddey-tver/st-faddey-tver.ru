<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если нет параметра id, переход к списку
$id = filter_input(INPUT_GET, 'id');
if(empty($id)) {
    header('Location: '.APPLICATION."/admin/author/");
}

// Обработка отправки формы
if(null !== filter_input(INPUT_POST, 'delete_autor_submit')) {
    $id = filter_input(INPUT_POST, 'id');
    $sql = "delete from author where id = $id";
    $error_message = (new Executer($sql))->error;
    
    if(empty($error_message)) {
        header('Location: '.APPLICATION.'/admin/author/'.BuildQueryRemove('id'));
    }
}

// Получение объекта
$holy_order = null;
$last_name = '';
$first_name = '';
$middle_name = '';

$sql = "select holy_order, last_name, first_name, middle_name from author where id = $id";
$fetcher = new Fetcher($sql);
$error_message = $fetcher->error;

if($row = $fetcher->Fetch()) {
    $holy_order = $row['holy_order'];
    $last_name = $row['last_name'];
    $first_name = $row['first_name'];
    $middle_name = $row['middle_name'];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        include '../include/head.php';
        ?>
    </head>
    <body>
        <?php
        include '../include/header.php';        
        include '../../include/pager_top.php';
            
        $news_type_id = NEWS_TYPE_ARTICLES;
    
        $sql = "select count(id) from news where news_type_id = $news_type_id and author_id = $id";
        $fetcher = new Fetcher($sql);
        $error_message = $fetcher->error;
            
        if($row = $fetcher->Fetch()) {
            $pager_total_count = $row[0];
        }
        ?>
        <ul class="breadcrumb">
            <li><a href="<?=APPLICATION ?>/">На главную</a></li>
            <li><a href="<?=APPLICATION ?>/admin/">Администратор</a></li>
            <li><a href="<?=APPLICATION ?>/admin/author/">Авторы</a></li>
            <li><a href="<?=APPLICATION ?>/admin/author/details.php<?= BuildQuery('id', $id) ?>"><?= GetAuthorsFullName($holy_order, $first_name, $middle_name, $last_name) ?></a></li>
            <li>Удаление автора</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1 class="text-danger">Действительно удалить?</h1>
                </div>
                <div class="p-1">
                    <a href="details.php<?= BuildQuery('id', $id) ?>" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Отмена</a>
                </div>
            </div>
            <h2><?= GetAuthorsFullName($holy_order, $last_name, $first_name, $middle_name) ?></h2>
            <?php if($pager_total_count == 0): ?>
            <form method="post">
                <input type="hidden" name="id" value="<?=$id ?>" />
                <button type="submit" name="delete_autor_submit" class="btn btn-danger mt-3">Удалить</button>
            </form>
            <?php endif; ?>
            <!-- Список статей -->
            <?php
            $sql = "select id, name from news where news_type_id = $news_type_id and author_id = $id order by date desc, id desc limit $pager_skip, $pager_take";
            $fetcher = new Fetcher($sql);
            $error_message = $fetcher->error;
            
            while($row = $fetcher->Fetch()):
            $article_id = $row['id'];
            $article_name = $row['name'];
            ?>
            <p><a href="<?=APPLICATION ?>/admin/article/details.php<?= BuildQuery('id', $article_id) ?>"><?= $article_name ?></a></p>
            <?php
            endwhile;
            
            include '../../include/pager_bottom.php';
            ?>
            <!-- Конец списка статей -->
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>