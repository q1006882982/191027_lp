<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>t2</title>
</head>
<body>

<button type="button" id="bt1">send</button>
</body>

<script src="/static/common/lib/jquery.1.12/jquery.js"></script>
<script>
    console.log('cc');

    $('#bt1').on('click', function (){
        console.log('cc');
        $.ajax({
            type: 'GET'
            ,url: '/admin/index/t1'
            ,data: {}
            // ,dataType: 'json'
            ,success: function (data){
                console.log(data);
            }
            ,error: function (data){
                console.log('error');
            }
            ,complete: function (){
                console.log('compltete');
            }
        });
    });
</script>
</html>
