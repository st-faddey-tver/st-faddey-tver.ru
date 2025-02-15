<?php
include '../../include/topscripts.php';

// Авторизация
if(!IsInRole(array(ROLE_NAMES[ROLE_ADMIN]))) {
    header('Location: '.APPLICATION.'/admin/login.php');
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
            <li>sitemap.xml</li>
        </ul>
        <div class="container-fluid">
            <?php
            if(!empty($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>sitemap.xml</h1>
                </div>
                <div class="p-1">
                    <a href="create.php" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Создать узел</a>
                </div>
            </div>
            &lt;?xml version="1.0" encoding="UTF-8"?&gt;<br />
            &lt;urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"&gt;<br />
            <table class="table table-striped">
            <?php
            $sql = "select id, loc, lastmod, changefreq, priority from sitemap order by loc";
            $fetcher = new Fetcher($sql);
            $error_message = $fetcher->error;
            
            while ($row = $fetcher->Fetch()):
            ?>
                <tr>
                    <td>
                        &nbsp;&nbsp;&lt;url&gt;<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&lt;loc&gt;<strong><?=$row['loc'] ?></strong>&lt;/loc&gt;<br />
                        <?php
                        if(!empty($row['lastmod'])):
                        ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&lt;lastmod&gt;<strong><?=$row['lastmod'] ?></strong>&lt;/lastmod&gt;<br />
                        <?php
                        endif;
                        if(!empty($row['changefreq'])):
                        ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&lt;changefreq&gt;<strong><?=$row['changefreq'] ?></strong>&lt;/changefreq&gt;<br />
                        <?php
                        endif;
                        if(is_numeric($row['priority'])):
                        ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&lt;priority&gt;<strong><?=$row['priority'] ?></strong>&lt;/priority&gt;<br />
                        <?php
                        endif;
                        ?>
                        &nbsp;&nbsp;&lt;/url&gt;
                    </td>
                    <td><a href="details.php<?= BuildQuery("id", $row['id']) ?>" class="btn btn-outline-dark"><i class="fas fa-info-circle"></i>&nbsp;Подробнее...</a></td>
                </tr>
            <?php
            endwhile;
            ?>
            </table>
            <p>&lt;/urlset&gt;</p>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>