<?php require_once './vendor/autoload.php'; ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href='ui/Jcrop/css/jquery.Jcrop.min.css'/>
    <link rel="stylesheet" href='ui/bootstrap-3.3.5/css/bootstrap.min.css'/>
</head>
<body>
<section class="container">
    <div class="row">
        <div class="col-sm-12">
            <form action="process.php" method="POST" id="imageCropForm" enctype='multipart/form-data'>

                <input type="hidden" name="horizonatal_pos" id="horizonatal_pos">
                <input type="hidden" name="vertical_pos" id="vertical_pos">
                <input type="hidden" name="crop_img_height" id="crop_img_height">
                <input type="hidden" name="crop_img_width" id="crop_img_width">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Image Cropping</h4>
                    </div>
                    <div class="panel-body">
                        <!--<img id="googleImage" src="https://www.google.com.bd/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png"/>-->
                        <div class="form-group" style="width: 100%;height: 600px;overflow: auto">
                            <div id="imageCropperPreviewBox">
                                <img id="imageCropperPreview"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Avatar</label>
                            <input type="file" id="imageUplodder" name="file" class="form-control"/>
                        </div>

                        <div id="uploadPreview"></div>
                    </div>
                    <div class="panel-footer text-right">
                        <input type="reset" value="Clear" class="btn btn-default"/>
                        <input type="submit" value="Save" id="startUpload" class="btn btn-primary"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php if (isset($_GET['path'])): ?>
        <div class="panel">
            <div class="panel-body">
                <img src="<?php echo $_GET['path'] ?>"/>
            </div>
        </div>
    <?php endif; ?>
</section>
<script type="text/javascript" src='ui/jquery/1.11.0/jquery.min.js'></script>
<script type="text/javascript" src='ui/Jcrop/js/jquery.Jcrop.min.js'></script>
<script type="text/javascript">
    $(document).ready(function (e) {

        $(function () {

            $('#imageCropperPreviewBox').Jcrop({
                onSelect: updateCoords,
                onChange: updateCoords
            });
        });
        $.fn.serializeToJson = function () {
            return $(this).serializeArray().reduce(function (a, x) {
                a[x.name] = x.value;
                return a;
            }, {});
        };

        function updateCoords(c) {
            $('#horizonatal_pos').val(c.x);
            $('#vertical_pos').val(c.y);
            $('#crop_img_height').val(c.h);
            $('#crop_img_width').val(c.w);
        }
        ;

        function checkCoords() {
            if (parseInt($('#w').val()))
                return true;
            alert('Please select a crop region then press submit.');
            return false;
        }

        function readImage(file) {

            var reader = new FileReader();
            var image = new Image();

            reader.readAsDataURL(file);
            reader.onload = function (_file) {
                image.src = _file.target.result;              // url.createObjectURL(file);
                image.onload = function () {
                    var w = this.width,
                        h = this.height,
                        t = file.type, // ext only: // file.type.split('/')[1],
                        n = file.name,
                        s = ~~(file.size / 1024) + 'KB';

                    //$('#imageCropperPreview').append('<img src="' + this.src + '"> ' + w + 'x' + h + ' ' + s + ' ' + t + ' ' + n + '<br>');
                    $('#imageCropperPreview').attr('src', this.src).css({
                        width: this.width,
                        height: this.height,
                        display: 'block',
                        visibility: 'visible'
                    }).Jcrop({
                        onSelect: updateCoords,
                        onChange: updateCoords
                    });


                };
                image.onerror = function () {
                    alert('Invalid file type: ' + file.type);
                };
            };

        }

        $("#imageUplodder").change(function (e) {
            if (this.disabled)
                return alert('File upload not supported!');
            var F = this.files;
            if (F && F[0])
                for (var i = 0; i < F.length; i++)
                    readImage(F[i]);
        });

    });

</script>
</body>
</html>
