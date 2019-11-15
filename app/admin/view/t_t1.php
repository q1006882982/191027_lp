<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>t1</title>
    <?php include APP_PATH.'admin/view/public_resource.php'; ?>
    <script src="<?php echo COMMONLIB_PATH;?>ajaxfileupload.js"></script>
</head>
<body>
<input type="file" id="file" name="mfile" style="display: none;"/>
<input type="button" id="bt1" value="btn">
<input type="button" id="bt2" value="btn2">



<script>

    $('#bt2').on('click', function () {
        //克隆file
        var $old_file = $('#file');
        $old_file.click();
        //生成form,提交
        $('<form>').attr({id:'jUploadForm1573523916330'})
        .attr({action:'/admin/t/t2',method:'POST',enctype:'multipart/form-data'})
        .append($('#file').css({position:'absolute',top:'-1200px',left:'-1200px'}))
            .appendTo('body');
        $('#jUploadForm1573523916330').submit();
    });
    
    $('#bt1').on('click', function () {
        $('#file').click();
        $('#file').change(function () {
            $.ajaxFileUpload({
                url: '<?php echo url('admin/t/t2');?>',
                fileElementId:'file',
                dataType:'json',
                success:function(data, status){
                    //upload success
                    console.log(data)
                },
                error: function (data, status, e) {
                    //error
                    console.log(data)
                }
            })
        });

    });

</script>
</body>
</html>
