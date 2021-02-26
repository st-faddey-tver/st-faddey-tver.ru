<div class="row mb-5">
    <div class="col-2">
        <a href="<?=$src ?>" title="Открыть в новом окне" target="_blank"><img src="<?=$src ?>" title="<?=$row['name'] ?>" class="img-fluid" /></a>
    </div>
    <div class="col-10" style="border-top: solid 1px lightgray;">
        <p><strong><?= htmlentities($row['name']) ?></strong></p>
        <p><?=$row['extension'] ?>,&nbsp;<?=$row['width'] ?>&nbsp;<i class="fas fa-times"></i>&nbsp;<?=$row['height'] ?></p>
        <p class="src"><?=$src ?></p>
        <div class="d-flex justify-content-between mb-2">
            <div class="p-1">
                <button class="btn btn-outline-dark copy_src" data-src="<?=$src ?>"><i class="fas fa-copy"></i>&nbsp;Скопировать ссылку<div class='alert alert-info clipboard_alert'>Скопировано</div></button>
            </div>
            <div class="p-1">
                <form method="post">
                    <input type="hidden" id="id" name="id" value="<?=$row['id']; ?>" />
                    <input type="hidden" id="scroll" name="scroll" />
                    <input type="hidden" id="filename" name="filename" value="<?=$row['filename'] ?>" />
                    <button type="submit" class="btn btn-outline-dark confirmable" id="delete_image_submit" name="delete_image_submit"><i class="fas fa-trash-alt"></i>&nbsp;Удалить</button>
                </form>
            </div>
        </div>
    </div>
</div>