<form method="post">
    <input type="hidden" id="news_id" name="news_id" value="<?=$this->newsId ?>" />
    <input type="hidden" id="scroll" name="scroll" />
    <div class="form-group">
        <textarea id="body" name="body" class="form-control" rows="10"></textarea>
    </div>
    <div class="form-group">
        <button type="submit" id="create_fragment_submit" name="create_fragment_submit" class="btn btn-outline-dark"><i class="fas fa-plus"></i>&nbsp;Добавить</button>
    </div>
</form>