<h2>Загрузить изображение</h2>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" id="scroll" name="scroll" />
    <div class="form-group">
        <label for="file">Наименование<span class="text-danger">*</span></label>
        <input type="text" id="name" name="name" class="form-control" required="required" />
        <div class="invalid-feedback">Наименование обязательно.</div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="width">Уменьшить ширину до</label>
                <input type="number" min="1" step="1" id="max_width" name="max_width" class="form-control" />
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="height">Уменьшить высоту до</label>
                <input type="number" min="1" step="1" id="max_height" name="max_height" class="form-control" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="file">Файл изображения<span class="text-danger">*</span></label>
        <input type="file" id="file" name="file" class="form-control" />
    </div>
    <div class="form-group">
        <button type="submit" id="upload_image_submit" name="upload_image_submit" class="btn btn-outline-dark"><i class="fas fa-upload"></i>&nbsp;Загрузить</button>
    </div>
</form>