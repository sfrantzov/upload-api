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
        <a href="<?php echo \Illuminate\Support\Facades\URL::to('/sync')?>">Sync Version</a>
    </div>
    <div class="row">
        <div class="alert alert-success d-none" id="success">
            <strong>Success!</strong> <span id="successText">Indicates a successful or positive action.</span>
            <div id="files">
            </div>
        </div>
        <div class="alert alert-danger d-none" id="error">
            <strong>Error!</strong> <span id="errorText">Indicates a dangerous or potentially negative action.</span></div>
    </div>
    <div class="row">
        <form action="<?php echo \Illuminate\Support\Facades\URL::to('/api/v1/upload')?>" method="post" enctype="multipart/form-data" id="idForm">
            <div class="form-group">
                <label for="filesToUpload">Select images to upload</label>
                <input type="hidden" name="api_key" value="EPo1vxXzgDrNfUhe" id="api_key">
                <input type="file" class="form-control" id="filesToUpload" name="filesToUpload"
                       multiple
                       accept="<?php echo env('FILE_ALLOWED_TYPES_SITE') ?>"
                       data-file-size="<?php echo \App\Helpers\Helper::fileUploadMaxSize() ?>"
                >
                <small id="fileToUploadHelp" class="form-text text-muted">Accepted are only images with extensions: <?php echo env('FILE_ALLOWED_TYPES') ?></small>
            </div>
        </form>
    </div>
</div>
<script>
    $(function(){
        $("#filesToUpload").change(function() {
            $("#error").addClass('d-none');
            $("#errorText").html('');
            $("#success").addClass('d-none');
            $("#successText").html('');
            $("#files").html('');

            filesToUpload = $("#filesToUpload");
            let files = filesToUpload.get(0).files;
            for (let i = 0; i < files.length; i++) {
                if(files[i].size > filesToUpload.data('file-size')){
                    errorMessage("File " + files[i].name + " is too big");
                    continue;
                }
                processFile(files[i]);
            }
        });
    });

    function errorMessage(message) {
        $("#errorText").append('<div>' + message + '</div>');
        $("#error").removeClass('d-none');
    }

    function readFileAsync(file) {
        return new Promise((resolve, reject) => {
            let reader = new FileReader();
            reader.onload = () => {
                resolve(reader.result);
            };
            reader.onerror = reject;
            reader.readAsBinaryString(file);
        })
    }

    async function processFile(file) {
        try {
            let binaryData = await readFileAsync(file);
            let base64String = window.btoa(binaryData);
            var data = [{
                fileName: file.name,
                fileContent: base64String
            }];

            var form = $("#idForm");
            var url = form.attr('action');

            $.ajax({
                url: url,
                data: JSON.stringify(data),
                method: 'POST',
                processData: false,
                contentType: "application/json; charset=UTF-8",
                headers: {"API-KEY": $("#api_key").val()},
                success: function(result)
                {
                    if (parseInt(result.success) === 1) {
                        $("#successText").html(result.message);

                        var newHTML = '';
                        $.each(result.files, function(key) {
                            if (result.files[key].url) {
                                newHTML += '<div>File ' + result.files[key].name + ' is stored with download link <a href="' + result.files[key].url + '">' + result.files[key].url + '</a></div>';
                            } else {
                                newHTML += '<div>File ' + result.files[key].name + ' skipped (validation failed)</div>';
                            }
                        });
                        $("#files").append(newHTML);
                        $("#success").removeClass('d-none');
                    } else {
                        errorMessage(result.message)
                    }
                }
            });

        } catch (err) {
            console.log(err);
        }
    }
</script>
</body>
</html>