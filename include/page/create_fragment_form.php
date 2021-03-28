<form method="post">
    <?php
    include $_SERVER['DOCUMENT_ROOT'].APPLICATION.'/include/virtual_keyboard.php';
    ?>
    <input type="hidden" id="page" name="page" value="<?=$this->page ?>" />
    <input type="hidden" id="scroll" name="scroll" />
    <div class="form-group">
        <textarea id="body" name="body" class="editor" style="font-size: 1.5rem;"></textarea>
    </div>
    <div class="form-group d-flex justify-content-between mb-auto">
        <button type="submit" id="create_fragment_submit" name="create_fragment_submit" class="btn btn-outline-dark p-1"><i class="fas fa-plus"></i>&nbsp;Добавить</button>
        <button type="button" class="btn btn-outline-dark p-1 btn_vk"><i class="fas fa-keyboard"></i>&nbsp;Виртуальная клавиатура</button>
    </div>
</form>