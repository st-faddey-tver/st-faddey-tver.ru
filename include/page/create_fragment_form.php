<form method="post">
    <input type="hidden" id="page" name="page" value="<?=$this->page ?>" />
    <input type="hidden" id="scroll" name="scroll" />
    <div class="form-group">
        <textarea id="body" name="body" class="editor"></textarea>
    </div>
    <div class="form-group">
        <button type="submit" id="create_fragment_submit" name="create_fragment_submit" class="btn btn-outline-dark">Добавить</button>
    </div>
</form>