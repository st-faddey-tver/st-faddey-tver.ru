<?php
class Page {
    public function __construct($pageName) {
        $this->page = $pageName;
    }
    
    private $page;
    public $errorMessage;

    public function Top() {
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
    }


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

    public function GetFragments() {
        $sql = "select id, body from page_fragment where page = '$this->page' order by position";
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