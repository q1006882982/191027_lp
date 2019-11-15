<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>在线商城后台管理</title>
    <?php include APP_PATH.'admin/view/public_resource.php'; ?>

</head>
<body>

<h2><a href="<?php echo $this->url('admin/manage/show');?>">返回管理员列表</a>系统 -- 添加管理员</h2>


<form method="post" id="form1">
    <dl class="form">
        <input type="text" name="id" value="<?php echo isset($one_data['id']) ? $one_data['id'] : 0;?>">
        <dd>用 户 名：<input type="text" name="name" class="text"
                         value="<?php echo isset($one_data['name']) ? $one_data['name'] : '';?>"
            /> ( * 2-20位之间 )
        </dd>
        <dd>密　　码：<input type="password" name="password" class="text" 
                        value="<?php echo isset($one_data['password']) ? $one_data['password'] : '';?>"
            /> ( * 大于6位 )
        </dd>
        <dd>确认密码：<input type="password" name="notpass" class="text" /> ( * 同密码一致 )</dd>
        <dd>等　　级：<select name="level">
                <option value="0">--请选择一个等级权限--</option>
                {html_options options=$AllLevel}
            </select> ( * 必须选定一个权限 )</dd>
        <dd><input type="button" value="提交" onclick="form_save(this, <?php echo isset($one_data['id']) ? $one_data['id'] : 0;?>)" class="submit" /></dd>
    </dl>
</form>

<script>

    function form_save(obj, id=0){
        ajaxObj(obj, {
            url: '<?php echo $this->url('admin/manage/save');?>'
            ,data: $('#form1').serialize()
            ,success: function (data) {
                alert(data.msg);
                if (data.code == 1) {
                    if(id){
                        var url = '<?php echo $_SERVER['HTTP_REFERER'];?>';
                    }else{
                        var url = '<?php echo $this->url('admin/manage/show');?>';
                    }
                    window.location.href = url;
                }
            }
        })
    }
</script>

</body>
</html>