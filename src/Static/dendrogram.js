(function (window) {

    'use strict';

    var dendrogram = {
        icon_data:{
        'expand':'<span class="dendrogram-icon"><svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg"><polygon stroke="#fff" fill="#fff" points="13 2 18 2 18 7 17 7 17 3 13 3"></polygon><polygon stroke="#fff" fill="#fff" points="2 13 3 13 3 17 7 17 7 18 2 18"></polygon><path fill="none" stroke="#fff" stroke-width="1.1" d="M11,9 L17,3"></path><path fill="none" stroke="#fff" stroke-width="1.1" d="M3,17 L9,11"></path></svg></span>',
        'shrink':'<span class="dendrogram-icon"><svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg"><polygon stroke="#fff" fill="#fff" points="11 4 12 4 12 8 16 8 16 9 11 9"></polygon><polygon stroke="#fff" fill="#fff" points="4 11 9 11 9 16 8 16 8 12 4 12"></polygon><path stroke="#fff" fill="#fff" stroke-width="1.1" d="M12,8 L18,2"></path><path stroke="#fff" fill="#fff" stroke-width="1.1" d="M2,18 L8,12"></path></svg></span>',
        'grow':'<span class="dendrogram-icon"><svg width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle fill="none" stroke="#fff" stroke-width="1.1" cx="9.5" cy="9.5" r="9"></circle><line fill="none" stroke="#fff" x1="9.5" y1="5" x2="9.5" y2="14"></line><line fill="none" stroke="#fff" x1="5" y1="9.5" x2="14" y2="9.5"></line></svg></span> ',
        'ban':'<span class="dendrogram-icon"><svg width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle fill="none" stroke="#fff" stroke-width="1.1" cx="9.5" cy="9.5" r="9"></circle><line fill="none" stroke="#fff" stroke-width="1.1" x1="4" y1="3.5" x2="16" y2="16.5"></line></svg></span> '
        },
        requestEvent: {
            apply: function (url, data, method, callback) {
                method = typeof method !== 'undefined' ? method : 'POST';
                callback = typeof callback == 'function' ? callback : function (d) {
                };

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
        bindClassEnvent:function (className,event,func) {
            var objs = document.getElementsByClassName(className);
            for (var i=0;i<objs.length;i++) {
                objs[i].addEventListener(event,func);
            }
        },
        removeChildDom:function (dom) {
            while(dom.hasChildNodes()){
                dom.removeChild(dom.firstChild);
            }
        },
        appendChildDom:function (dom,html) {
            dom.innerHTML = html;
        },
        relpaceChild:function(dom,html){
            dendrogram.removeChildDom(dom);
            dendrogram.appendChildDom(dom,html);
        },
        tree:{
            init:function () {
                dendrogram.bindClassEnvent('dendrogram-adjacency-retract','click',dendrogram.tree.shrink);
            },
            addForm:function () {

            },
            upForm:function () {

            },
            delete:function () {
                
            },
            shrink:function () {
                var node = this.parentNode;
                var sign = node.getAttribute('data-sign');
                if(sign == 0){
                    dendrogram.relpaceChild(this,dendrogram.icon_data.shrink);
                    node.setAttribute('data-sign',1);
                    node.parentNode.childNodes[3].setAttribute('style', 'display:block');
                    return;
                }
                dendrogram.relpaceChild(this,dendrogram.icon_data.expand);
                node.setAttribute('data-sign',0);
                node.parentNode.childNodes[3].setAttribute('style', 'display:none');
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