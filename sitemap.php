<?php
header("Content-Type: text/xml");
echo '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php
include 'include/topscripts.php';
$sql = "select id, loc, lastmod, changefreq, priority from sitemap order by loc";
$fetcher = new Fetcher($sql);
    
while ($row = $fetcher->Fetch()):
?>
    <url>
        <loc><?=$row['loc'] ?></loc>
<?php
if(!empty($row['lastmod'])):
?>
        <lastmod><?=$row['lastmod'] ?></lastmod>
<?php
endif;
if(!empty($row['changefreq'])):
?>
        <changefreq><?=$row['changefreq'] ?></changefreq>
<?php
endif;
if(is_numeric($row['priority'])):
?>
        <priority><?=$row['priority'] ?></priority>
<?php
endif;
?>
    </url>
<?php
endwhile;
?>
</urlset>