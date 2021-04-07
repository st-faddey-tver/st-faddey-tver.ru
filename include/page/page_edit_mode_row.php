<div class="row" style="border-top: solid 1px lightgray;">
    <div class="col-8">
        <?php
        if(null !== filter_input(INPUT_POST, 'page_fragment_edit_submit')) {
            $id = filter_input(INPUT_POST, 'id');
            
            if($id == $row['id']) {
                include 'edit_fragment_form.php';
            }
            else {
                echo $row['body'];
            }
        }
        else {
            echo $row['body'];
        }
        ?>
    </div>
    <div class="col-4 text-right">
        <form method="post">
            <input type="hidden" id="id" name="id" value="<?=$row['id'] ?>" />
            <input type="hidden" id="page_id" name="page_id" value="<?=$row['page_id'] ?>" />
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