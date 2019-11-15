/**
 * Created by Administrator on 2019/11/7.
 */

/*
* 依赖 jquery
* */


//ajax
function ajaxObj(obj, param){
    var $that = $(obj);
    $that.attr('disabled', 'disabled');
    //var layer_index = layer.load();

    param.type = param.type || 'post';
    param.data = param.data || {};
    param.dataType = param.dataType || 'json';
    param.error = param.error || function (data) {
            layer.msg('error');
            console.log(data);
        };
    param.complete = param.complete || function () {
            //layer.close(layer_index);
            $that.removeAttr('disabled');
        };

    $.ajax({
        url: param.url
        ,type: param.type
        ,data: param.data
        ,dataType: param.dataType
        ,success: function (data) {
            param.success(data);
        }
        ,error: function (data) {
            param.error(data);
        }
        ,complete: function () {
            param.complete();
        }
    });
}
function ajax(param, load=true){
    if (load == true) {
        var layer_index = layer.load();
    }

    param.type = param.type || 'post';
    param.data = param.data || {};
    param.dataType = param.dataType || 'json';
    param.error = param.error || function (data) {
            layer.msg('error');
            console.log(data);
        };
    param.complete = param.complete || function () {
            if (load == true) {
                layer.close(layer_index);
            }
        };

    $.ajax({
        url: param.url
        ,type: param.type
        ,data: param.data
        ,dataType: param.dataType
        ,success: function (data) {
            param.success(data);
        }
        ,error: function (data) {
            param.error(data);
        }
        ,complete: function () {
            param.complete();
        }
    });
}

//根据 总数,分页数生成 分页html
function page(obj_str, ajax_url, middle = 8) {
    var html = '';
    var page_index = 1;
    var total_page = 1;

    $.ajax({
        type: 'GET'
        , url: ajax_url
        , data: {}
        , dataType: 'json'
        , success: function (data) {
            console.log(data);
            var total = data.data.total;
            var size = data.data.page_size;
            var total_page = Math.ceil(total / size);
            if (total_page > 1) {
                var old_search = window.location.search.substr(1);
                var search_arr = old_search.split('&');
                for (var i = 0; i < search_arr.length; i++) {
                    if (search_arr[i].search('page=') >= 0) {
                        page_index = search_arr[i].split('=')[1];
                        search_arr.splice(i, 1)
                    }
                }
                var new_search = search_arr.join('&');
                var pre_path = window.location.pathname + '?' + new_search;

                for (var i = 1; i <= total_page; i++) {
                    if (i == page_index) {
                        html += '<span class="me">' + i + '</span>';
                    } else if (i < middle + 1) {
                        var url = pre_path + 'page=' + i;
                        html += '<a href="' + url + '">' + i + '</a>'
                    } else if (i == middle + 1) {
                        html += '...'
                    } else {
                        var url = pre_path + 'page=' + (total_page);
                        html += '<a href="' + url + '">' + (total_page) + '</a>'
                        break;
                    }
                }

                $(obj_str).append(html);
            }

        }
        ,error: function (data) {
            //console.log('err')
        }
        ,complete: function (data) {
            //console.log('complete')
        }
    });



}
