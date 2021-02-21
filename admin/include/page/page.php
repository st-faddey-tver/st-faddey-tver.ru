<?php
class Page {
    public function __construct($page_id) {
        $this->pageId = $page_id;
    }
    
    private $pageId;
    
    public function Head() {
        echo "<link href='".APPLICATION."/admin/cleditor/jquery.cleditor.css' rel='stylesheet' />";
    }

    public function Footer() {
        ?>
        <script src='<?=APPLICATION ?>/admin/cleditor/jquery.cleditor.js'></script>
        <script>
            $(document).ready(function () {
                $('textarea.editor').cleditor()[0].focus();
            });
        </script>
        <?php
    }

    public function GetFragmentsAdmin() {
        $sql = "select id, body from page_fragment where page_id = $this->pageId order by position";
        $fetcher = new Fetcher($sql);
        while ($row = $fetcher->Fetch()) {
            echo $row['body'];
        }
    }
    
    public function ShowCreateFragmentForm() {
        include 'create_fragment_form.php';
    }
}
?>