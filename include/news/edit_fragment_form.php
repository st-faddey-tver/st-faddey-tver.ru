<form method="post">
    <input type="hidden" id="id" name="id" value="<?=$row['id'] ?>" />
    <input type="hidden" id="scroll" name="scroll" />
    <div class="form-group">
        <textarea id="body" name="body" class="form-control" rows="10"><?= htmlentities($row['body']) ?></textarea>
    </div>
    <div class="form-group d-flex justify-content-between mb-2">
        <div class="p-1">
            <button type="submit" id="edit_fragment_submit" name="edit_fragment_submit" class="btn btn-outline-dark"><i class="fas fa-save"></i>&nbsp;Сохранить</button>
        </div>
        <div class="p-1">
            <button type="submit" id="cancel_fragment_submit" name="cancel_fragment_submit" class="btn btn-outline-dark"><i class="fas fa-undo-alt"></i>&nbsp;Отмена</button>
        </div>
    </div>
</form>