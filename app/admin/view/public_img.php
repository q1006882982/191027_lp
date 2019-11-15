<link rel="stylesheet" type="text/css" href="<?php echo COMMONLIB_PATH;?>Huploadify/Huploadify.css"/>
<script type="text/javascript" src="<?php echo COMMONLIB_PATH;?>/Huploadify/jquery.Huploadify.js"></script>
<div id="upload_<?php echo $name;?>"></div>
<input name="<?php echo $name;?>" type="hidden" value="<?php echo $value;?>">
<div id="img_<?php echo $name;?>">
    <div style="width:110px; display: inline-block;">
        <img src="<?php echo $value;?>" alt="" style="width:100px; height: 100px; padding: 0 10px 0 0;">
    </div>
</div>
<script type="text/javascript">
    var name = '<?php echo $name;?>';
    var y_$img_container = $('#img_'+name);
    var y_$img = y_$img_container.find('img');
    var y_$input_img = $('[name='+name+']');

    $('#upload_'+name).Huploadify({
        auto:true,
        fileTypeExts:'*.jpg;*.png;*.jpeg',
        multi:false,
        fileSizeLimit:2048,
        removeTimeout:1000,
        fileObjName:'<?php echo $name;?>',
//        uploader:'{:url("admin/UploadFile/upPic")}?fname={$name}',
        uploader:'<?php echo url('admin/UploadFile/upPic',['name'=>$name]);?>',
        onUploadComplete:function(file,data,response){
            data = JSON.parse(data);
            y_$input_img.val(data.data.url);
            y_$img.attr('src', data.data.url);
        },
        onCancel:function(file){
            file = file['name'];
            console.log('需要删除的文件:'+file);
            // console.log();
            if (file !== null || file !== undefined || file !== '') {
                $.ajax({
                    type:"POST",
                    url:'DeleteFile.php',
                    data: "deleteimg=" + file,
                    success:function(response){
                        console.log(response);
                    }
                });
            }
        }

    });

    function del_<?php echo $name;?>(obj, path) {
        //ajax 删除文件
        $.ajax({
            type:'POST',
            url:'{:url("admin/UploadFile/delPic")}',
            data: {
                'path': path
            },
            success:function(data){
                console.log(data);
                if (data.code == 1) {
                    $(obj).prev().attr('src','');
                    y_$input_img.val('');
                }else {
                    layer.msg(data.msg);
                }
            }
        });

    }

</script>
