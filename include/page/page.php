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
        
        if(null !== filter_input(INPUT_POST, 'page_fragment_delete_submit')) {
            $id = filter_input(INPUT_POST, 'id');
            $this->errorMessage = (new Executer("delete from page_fragment where id=$id"))->error;
        }
        
        if(null !== filter_input(INPUT_POST, 'page_fragment_up_submit')) {
            $id = filter_input(INPUT_POST, 'id');
            $page = filter_input(INPUT_POST, 'page');
            $position = filter_input(INPUT_POST, 'position');
            
            $row = (new Fetcher("select id, position from page_fragment where page='$page' and position<$position order by position desc limit 1"))->Fetch();
            $previous_id = $row['id'];
            $previous_position = $row['position'];
            
            $this->errorMessage = (new Executer("update page_fragment set position=$position where id=$previous_id"))->error;
            
            if(empty($this->errorMessage)) {
                $this->errorMessage = (new Executer("update page_fragment set position=$previous_position where id=$id"))->error;
            }
        }
        
        if(null !== filter_input(INPUT_POST, 'page_fragment_down_submit')) {
            $id = filter_input(INPUT_POST, 'id');
            $page = filter_input(INPUT_POST, 'page');
            $position = filter_input(INPUT_POST, 'position');
            
            $row = (new Fetcher("select id, position from page_fragment where page='$page' and position>$position order by position asc limit 1"))->Fetch();
            $next_id = $row['id'];
            $next_position = $row['position'];
            
            $this->errorMessage = (new Executer("update page_fragment set position=$position where id=$next_id"))->error;
            
            if(empty($this->errorMessage)) {
                $this->errorMessage = (new Executer("update page_fragment set position=$next_position where id=$id"))->error;
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
        while ($row = $fetcher->Fetch()):
        ?>
        <div class="row" style="border-top: solid 1px lightgray;">
            <div class="col-8">
                <?=$row['body'] ?>
            </div>
            <div class="col-4 text-right">
                <form method="post">
                    <input type="hidden" id="id" name="id" value="<?=$row['id'] ?>" />
                    <input type="hidden" id="page" name="page" value="<?=$row['page'] ?>" />
                    <input type="hidden" id="position" name="position" value="<?=$row['position'] ?>" />
                    <input type="hidden" id="scroll" name="scroll" />
                    <div class="btn-group text-right">
                        <button type="submit" id="page_fragment_up_submit" name="page_fragment_up_submit" class="btn btn-outline-dark" title="Вверх" data-toggle="tooltip"><i class="fas fa-arrow-up"></i></button>
                        <button type="submit" id="page_fragment_down_submit" name="page_fragment_down_submit" class="btn btn-outline-dark" title="Вниз" data-toggle="tooltip"><i class="fas fa-arrow-down"></i></button>
                        <button type="submit" id="page_fragment_edit_submit" name="page_fragment_edit_submit" class="btn btn-outline-dark" title="Редактировать" data-toggle="tooltip"><i class="fas fa-edit"></i></button>
                        <button type="submit" id="page_fragment_delete_submit" name="page_fragment_delete_submit" class="btn btn-outline-dark confirmable" title="Удалить" data-toggle="tooltip"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <?php
        endwhile;
    }

    public function ShowCreateFragmentForm() {
        include 'create_fragment_form.php';
    }
}
?>