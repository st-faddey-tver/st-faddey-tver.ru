<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array('admin'))) {
    header('Location: '.APPLICATION.'/admin/login.php');
}

// Если нет параметра id, переход к списку
$id = filter_input(INPUT_GET, 'id');
if(empty($id)) {
    header('Location: '.APPLICATION."/admin/sitemap/");
}

// Получение объекта
$id = filter_input(INPUT_GET, "id");
$loc = '';
$lastmod = '';
$changefreq = '';
$priority = null;

$sql = "select loc, lastmod, changefreq, priority from sitemap where id=$id";
$fetcher = new Fetcher($sql);
$error_message = $fetcher->error;

if($row = $fetcher->Fetch()) {
    $loc = $row['loc'];
    $lastmod = $row['lastmod'];
    $changefreq = $row['changefreq'];
    $priority = $row['priority'];
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
        ?>
        <ul class="breadcrumb">
            <li><a href="<?=APPLICATION ?>/">На главную</a></li>
            <li><a href="<?=APPLICATION ?>/admin/">Администратор</a></li>
            <li><a href="<?=APPLICATION ?>/admin/sitemap/">sitemap.xml</a></li>
            <li>Просмотр узла</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Просмотр узла</h1>
                </div>
                <div class="p-1">
                    <div class="btn-group">
                        <a href="<?=APPLICATION ?>/admin/sitemap/" class="btn btn-outline-dark" title="К списку" data-toggle="tooltip"><i class="fas fa-undo-alt"></i></a>
                        <a href="edit.php<?= BuildQuery("id", $id) ?>" class="btn btn-outline-dark" title="Редактировать" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                        <a href="delete.php<?= BuildQuery("id", $id) ?>" class="btn btn-outline-dark" title="Удалить" data-toggle="tooltip"><i class="fas fa-trash-alt"></i></a>
                    </div>
                </div>
            </div>
            &nbsp;&nbsp;&lt;url&gt;<br />
            &nbsp;&nbsp;&nbsp;&nbsp;&lt;loc&gt;<strong><?=$loc ?></strong>&lt;/loc&gt;<br />
                <?php
                if(!empty($lastmod)):
                ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&lt;lastmod&gt;<strong><?=$lastmod ?></strong>&lt;/lastmod&gt;<br />
                <?php
                endif;
                if(!empty($changefreq)):
                ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&lt;changefreq&gt;<strong><?=$changefreq ?></strong>&lt;/changefreq&gt;<br />
                <?php
                endif;
                if(is_numeric($priority)):
                ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&lt;priority&gt;<strong><?=$priority ?></strong>&lt;/priority&gt;<br />
                <?php
                endif;
                ?>
            &nbsp;&nbsp;&lt;/url&gt;
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>