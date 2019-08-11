<!DOCTYPE html>
<html>
<head>
    <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <h2>Test Files Upload</h2>
    </div>
    <div class="row">
        <div class="alert alert-success d-none" id="success">
            <strong>Success!</strong><span id="successText">Indicates a successful or positive action.</span>
            <div id="files">
            </div>
        </div>
        <div class="alert alert-danger d-none" id="error">
            <strong>Error!</strong><span id="errorText">Indicates a dangerous or potentially negative action.</span></div>
    </div>
    <form action="/api/v1/upload" method="post" enctype="multipart/form-data" id="idForm">
        <div class="form-group">
            <label for="exampleInputEmail1">Select images to upload</label>
            <input type="hidden" name="api_key" value="EPo1vxXzgDrNfUhe" id="api_key">
            <input type="file" class="form-control" id="filesToUpload" name="filesToUpload"
                   multiple accept="<?php echo env('FILE_ALLOWED_TYPES_SITE') ?>"
                   data-file-size="<?php echo \App\Helpers\Helper::fileUploadMaxSize() ?>"
                   data-post-size="<?php echo \App\Helpers\Helper::postMaxSize() ?>"
            >
            <small id="fileToUploadHelp" class="form-text text-muted">Accepted are only images with extensions: <?php echo env('FILE_ALLOWED_TYPES') ?></small>
        </div>
        <button type="submit" class="btn btn-primary" id="submit">Upload</button>
    </form>
</div>

</div>

</div>
<script>
    var data = [];
    $(function(){
        $("#filesToUpload").change(function(e) {
            data = {};
            let postSize = 0;
            let files = $("#filesToUpload").get(0).files;
            for (let i = 0; i < files.length; i++) {
                if(files[i].size > $("#filesToUpload").data('file-size')){
                    errorMessage("File " + files[i].name + " is too big");
                    this.value = "";
                    data = {};
                    return;
                };

                postSize += files[i].size;

                let reader = new FileReader();
                reader.fileName = files[i].name;
                reader.readAsBinaryString(files[i]);
                reader.onload = function (){
                    let binaryData = reader.result;
                    let base64String = window.btoa(binaryData);
                    data[i] = {
                        fileName: reader.fileName,
                        fileContent: base64String
                    };

                };
                if(postSize > $("#filesToUpload").data('post-size')){
                    errorMessage("Post size is too big");
                    this.value = "";
                    data = {};
                    return;
                }
            }
            $("#error").addClass('d-none');
        });


        $("#idForm").submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                url: url,
                data: JSON.stringify(data),
                method: 'POST',
                processData: false,
                contentType: "application/json; charset=UTF-8",
                headers: {"API-KEY": $("#api_key").val()},
                success: function(data)
                {
                    if (data.success == 1) {
                        $("#successText").html(data.message);

                        var newHTML = '';
                        $.each(data.files, function(key) {
                            if (data.files[key].url) {
                                newHTML += '<div>File ' + data.files[key].name + ' is stored with download link <a href="' + data.files[key].url + '">' + data.files[key].url + '</a></div>';
                            } else {
                                newHTML += '<div>File ' + data.files[key].name + ' skipped (validation failed)</div>';
                            }
                        });
                        $("#files").html(newHTML);
                        $("#success").removeClass('d-none');
                        $("#error").addClass('d-none');

                    } else {
                        errorMessage(data.message)
                    }
                }
            });
        });
    });

    function errorMessage(message) {
        $("#errorText").html(message);
        $("#error").removeClass('d-none');
        $("#success").addClass('d-none');
    }
</script>
</body>
</html>