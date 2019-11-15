<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script src="/static/common/lib/jquery.1.12/jquery.js"></script>

</head>
<body>
<?php echo (new \app\admin\controller\UploadFile())->viewUpload('imgs', 'file1');?>
</body>
</html>
