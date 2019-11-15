/*
* 这是一个控制静态资源引入的js, 防止多次引入
* */
var m_require_path_arr = [];
function m_require(file_path) {
    if (!in_array(file_path, m_require_path_arr)) {
        importCssJs.js(file_path);
        m_require_path_arr.push(file_path);
    }
}

function in_array(val, arr) {
    for(var i=0; i<arr.length; i++){
        if (val == arr[i]) {
            return true;
        }
    }
    return false;
}

var importCssJs = {
    css: function(path) {
        if(!path || path.length === 0) {
            throw new Error('参数"path"错误');
        }
        var head = document.getElementsByTagName('head')[0];
        var link = document.createElement('link');
        link.href = path;
        link.rel = 'stylesheet';
        link.type = 'text/css';
        head.appendChild(link);
    },
    js: function(path) {
        if(!path || path.length === 0) {
            throw new Error('参数"path"错误');
        }
        var head = document.getElementsByTagName('head')[0];
        var script = document.createElement('script');
        script.src = path;
        script.type = 'text/javascript';
        head.appendChild(script);
    }
}
