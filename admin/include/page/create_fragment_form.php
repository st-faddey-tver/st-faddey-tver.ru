<form method="post">
    <input type="hidden" id="page_id" name="page_id" value="<?=$this->pageId ?>" />
    <div class="form-group">
        <textarea id="body" name="body" class="editor"></textarea>
    </div>
    <div class="form-group">
        <button type="submit" id="create_fragment_submit" name="create_fragment_submit" class="btn btn-outline-dark">Добавить</button>
    </div>
</form>