(function (window) {

    'use strict';

    var dendrogram = {
        icon_data:{
            retract:'<svg class="dendrogram-icon"><svg width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle fill="none" stroke="#fff" stroke-width="1.1" cx="9.5" cy="9.5" r="9"></circle> <svg width="20" height="20" stroke="#fff" fill="#fff" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><polygon points="8 5 13 10 8 15"></polygon></svg> </svg> </span>',
            spread:'<svg class="dendrogram-icon"><svg width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle fill="none" stroke="#fff" stroke-width="1.1" cx="9.5" cy="9.5" r="9"></circle> <svg width="20" height="20" stroke="#fff" fill="#fff" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><polygon points="8 5 13 10 8 15"></polygon></svg> </svg> </span>',
            grow:'<span class="dendrogram-icon"><svg width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle fill="none" stroke="#fff" stroke-width="1.1" cx="9.5" cy="9.5" r="9"></circle><line fill="none" stroke="#fff" x1="9.5" y1="5" x2="9.5" y2="14"></line><line fill="none" stroke="#fff" x1="5" y1="9.5" x2="14" y2="9.5"></line></svg></span> ',
            ban:'<span class="dendrogram-icon"><svg width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle fill="none" stroke="#fff" stroke-width="1.1" cx="9.5" cy="9.5" r="9"></circle><line fill="none" stroke="#fff" stroke-width="1.1" x1="4" y1="3.5" x2="16" y2="16.5"></line></svg></span> ',
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
            console.log(html)
            dom.innerHTML = html;
        },
        tree:{
            init:function () {
                dendrogram.bindClassEnvent('dendrogram-adjacency-retract','click',dendrogram.tree.retract);
            },
            addForm:function () {

            },
            upForm:function () {

            },
            delete:function () {
                
            },
            retract:function () {
                var node = this.parentNode;
                dendrogram.removeChildDom(this);
                dendrogram.appendChildDom(this,dendrogram.icon_data.ban);
                node.removeChild(node.firstChild);
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