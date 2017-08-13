/**
 * Created by kilo on 2017/7/24.
 */

/* 通用工具库
 * 须支持：jquery-1.8.0.min.js
 * */
var MASTER = {};

MASTER.util = {
    /**
     * ajax函数
     * @param link 请求的连接
     * @param filters 请求的参数
     * @param suc 成功后执行的函数
     * @param err 失败后执行的函数
     */
    ajaxRequest: function (link, filters, suc, err) {
        $.ajax({
            url : link,
            data : filters,
            type : 'POST',
            datatype : 'json',
            success : function (d) {
                suc && suc(d);
            },
            error : function (d) {
                err && err(d);
            }
        });
    }
};