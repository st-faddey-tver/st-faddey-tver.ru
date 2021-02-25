<h2>Загрузить изображение</h2>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" id="scroll" name="scroll" />
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="width">Уменьшить ширину до</label>
                <input type="number" min="1" step="1" id="width" name="width" class="form-control" />
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="height">Уменьшить высоту до</label>
                <input type="number" min="1" step="1" id="height" name="height" class="form-control" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="file">Файл изображения</label>
        <input type="file" id="file" name="file" class="form-control" />
    </div>
    <div class="form-group">
        <button type="submit" id="upload_image_submit" name="upload_image_submit" class="btn btn-outline-dark"><i class="fas fa-upload"></i>&nbsp;Загрузить</button>
    </div>
</form>