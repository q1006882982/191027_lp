<link rel="stylesheet" type="text/css" href="<?php echo COMMONLIB_PATH;?>Huploadify/Huploadify.css"/>
<script type="text/javascript" src="<?php echo COMMONLIB_PATH;?>/Huploadify/jquery.Huploadify.js"></script>
<div id="upload_<?php echo $name;?>"></div>
<input name="<?php echo $name;?>" type="hidden" value="<?php echo $value;?>">
<div id="img_<?php echo $name;?>"></div>
<script type="text/javascript">
    var name = '<?php echo $name;?>';
    var $input_img = $('[name='+name+']');
    var $img_container = $('#img_'+name);
    var tag = '';

    //获取path
    var path = $input_img.val();
    if (path) {
        var path_arr = path.split(';');
        var img = '';
        for(var i=0; i<path_arr.length; i++){
            var path_every = path_arr[i];
            img += '<div style="width:110px; display: inline-block;"><img src="' + path_every + '" alt="" style="width:100px; height: 100px; padding: 0 10px 0 0;"><button type="button" onclick="del_<?php echo $name;?>(this,\'' + path_every + '\')">删除</button></div>';
        }
        $img_container.append(img);
    }

    $('#upload_'+name).Huploadify({
        auto: true,
        fileTypeExts: '*.jpg;*.png;*.jpeg',
        multi: false,
        fileSizeLimit: 2048,
        removeTimeout: 1000,
        fileObjName: name,
        uploader: '<?php echo url('admin/UploadFile/upPic', ['name'=>$name]);?>',
        onUploadComplete: function (file, data, response) {
            data = JSON.parse(data);
            console.log(data);

            if ($input_img.val()) {
                tag = ';';
            }
            $input_img.val($input_img.val()+tag+data.data.url);

            var $img = $('<div style="width:110px; display: inline-block;"><img src="' + data.data.url + '" alt="" style="width:100px; height: 100px; padding: 0 10px 0 0;"><button type="button" onclick="del_<?php echo $name;?>(this,\'' + data.data.url + '\')">删除</button></div>');
            $img_container.append($img);
        },
        onCancel: function (file) {
            file = file['name'];
            console.log('需要删除的文件:' + file);
            // console.log();
            if (file !== null || file !== undefined || file !== '') {
                $.ajax({
                    type: "POST",
                    url: 'DeleteFile.php',
                    data: "deleteimg=" + file,
                    success: function (response) {
                        console.log('response');
                        console.log(response);
                    }
                });
            }
        }

    });

    function del_<?php echo $name;?>(obj, path)
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo url('admin/UploadFile/delPic');?>',
            data: {
                'path': path
            },
            success: function (data) {
                data = JSON.parse(data);
                if (data.code == 1) {
                    var arr1 = $input_img.val().split(';');
                    var arr2 = arr1.filter(function (val) {
                        return val != path;
                    });
                    var str1 = arr2.join(';');
                    $input_img.val(str1);
                    $(obj).parent().remove();
                }else{
                    layer.msg(data.msg);
                }

            }
        });

    }

</script>
