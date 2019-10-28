<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>hi</title>
</head>
<body>
<?php foreach($res as $k=>$v):?>
    <div><?php echo $v['name']?></div>
    <div><?php echo $v['age']?></div>
<?php endforeach?>
</body>
</html>
