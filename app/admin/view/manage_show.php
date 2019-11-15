<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>在线商城后台管理</title>
    <?php include APP_PATH.'admin/view/public_resource.php'; ?>

</head>
<body>

<h2><a href="<?php echo $this->url('admin/manage/form');?>">添加管理员</a>系统 -- 管理员列表</h2>

<div id="list">
    <table>
        <tr>
            <th>用户名</th>
            <th>等级</th>
            <th>登录次数</th>
            <th>最后登录ip</th>
            <th>最后登录时间</th>
            <th>操作</th>
        </tr>
        <?php foreach($all_data as $data):?>
        <tr>
            <td><?php echo $data['name'];?></td>
            <td><?php echo $data['level_id'];?></td>
            <td><?php echo $data['login_count'];?></td>
            <td><?php echo $data['login_ip'];?></td>
            <td><?php echo $data['login_time'];?></td>
            <td><a href="<?php echo $this->url('admin/manage/form', ['id'=>$data['id']]);?>">
                    <img src="/static/admin/img/edit.gif" alt="编辑" title="编辑"/>
                </a>
                <a href="javascript:void(0)"
                   onclick="return del(this, <?php echo $data['id'];?>) ? true : false">
                    <img src="/static/admin/img/drop.gif" alt="删除" title="删除"/>
                </a>
            </td>
        </tr>
        <?php endforeach?>
        <?php if(empty($all_data)):;?>
        <tr>
            <td colspan="6">没有任何管理员</td>
        </tr>
        <?php endif;?>
    </table>
</div>
<div id="page"></div>

<script>
    page('#page', '/admin/manage/apiShowCount')
    
    function del(obj, id){
        ajaxObj(obj, {
            url: '<?php echo url('admin/manage/delete');?>'
            ,data:{id:id}
            ,success: function (data) {
                console.log(data);
                alert(data.msg);
                if (data.code == 1) {
                    window.location.reload();
                }
            }
        })
    }
</script>
</body>
</html>