/**
 * Created by kilo on 2017/7/24.
 */

MASTER.Short = {
    urlhtml : $('#url'),
    long_url : $('#long_url'),

    init: function () {
        var that = this;
        $('body').on('click', '#make_short_url', function () {
            that.getShortUrl();
        });
    },

    getShortUrl : function () {
        //锁定模板
        //获取参数
        var filters = {
            url : MASTER.Short.long_url.val()
        };
        //请求数据
        MASTER.util.ajaxRequest(MASTER.api.shortUrl, filters, function (d) {
            // if(d.ret == 0 && d.data != null){
            //     MASTER.Short.appenUrl(d.data);
                MASTER.Short.appenUrl(d);
            // }
        }, function (d) {
            
        });
        //解锁模板
    },

    appenUrl : function (data) {
        MASTER.Short.urlhtml.val(data);
    }
};

MASTER.Short.init();



