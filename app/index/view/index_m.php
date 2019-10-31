<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>m</title>
</head>
<body>
<div id="m">mmmmm</div>
</body>

<script src="/static/common/lib/jquery.1.12/jquery.js"></script>
<script>
    $.ajax({
        type: 'GET'
        ,url: 'http://hi.lp123456.com/api/index/info'
        ,data: {}
        ,dataType: 'json'
        ,success: function (data){
            // console.log(data);
            console.log('hi');
        }
    });
</script>
</html>
 