(function (window) {

    'use strict';

    var dendrogram = {
        requestEvent: {
            apply: function (url, data, method, callback) {
                method = typeof method !== 'undefined' ? method : 'POST';
                callback = typeof callback == 'function' ? callback : function (d) {
                };
                data._token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    dataType: 'json',
                    type: method,
                    url: url,
                    data: data,
                    success: function (d) {
                        callback(d);
                    },
                    error:function (d) {
                        callback(d);
                    }
                });
            }
        },
        tree:{
            init:function () {
                var objs = document.getElementsByClassName('dendrogram-adjacency-retract');
                console.log(objs.length)
                for (var i=0;i<objs.length;i++) {
                    objs[i].onclick = dendrogram.tree.retract;
                }
            },
            addForm:function () {

            },
            upForm:function () {

            },
            delete:function () {
                
            },
            retract:function () {
                console.log(this)
            }
        }
    };

    if (typeof define === 'function' && define.amd) {
        // AMD
        define(dendrogram);
    } else {
        window.dendrogram = dendrogram;
    }
})(window);