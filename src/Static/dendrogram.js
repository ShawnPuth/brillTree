(function (window) {

    'use strict';

    var dendrogram = {
        icon_data:{
            'expand':'<span class="dendrogram-icon"><svg width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#fff" stroke-width="1.1" cx="9.5" cy="9.5" r="9"></circle> <line fill="none" stroke="#fff" x1="9.5" y1="5" x2="9.5" y2="14"></line> <line fill="none" stroke="#fff" x1="5" y1="9.5" x2="14" y2="9.5"></line></svg></span>',
            'shrink':'<span class="dendrogram-icon"><svg width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#fff" stroke-width="1.1" cx="9.5" cy="9.5" r="9"></circle> <line fill="none" stroke="#fff" x1="5" y1="9.5" x2="14" y2="9.5"></line></svg></span>',
            'grow':'<span class="dendrogram-icon"><svg width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="social"><line fill="none" stroke="#fff" stroke-width="1.1" x1="13.4" y1="14" x2="6.3" y2="10.7"></line><line fill="none" stroke="#fff" stroke-width="1.1" x1="13.5" y1="5.5" x2="6.5" y2="8.8"></line><circle fill="none" stroke="#fff" stroke-width="1.1" cx="15.5" cy="4.6" r="2.3"></circle><circle fill="none" stroke="#fff" stroke-width="1.1" cx="15.5" cy="14.8" r="2.3"></circle><circle fill="none" stroke="#fff" stroke-width="1.1" cx="4.5" cy="9.8" r="2.3"></circle></svg></span> ',
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
            tabAnimeFlag:false,
            init:function () {
                dendrogram.bindClassEnvent('dendrogram-adjacency-tab','click',dendrogram.tree.tab);
            },
            addForm:function () {

            },
            upForm:function () {

            },
            delete:function () {
                
            },
            tab:function () {
                var node = this.parentNode;
                var sign = node.getAttribute('data-sign');
                var children = node.parentNode.childNodes[3];

                if(dendrogram.tree.shrinkAnimeFlag){
                    console.log('animetion is running')
                    return;
                }
                dendrogram.tree.shrinkAnimeFlag = true;

                if(sign == 0){//open
                    dendrogram.relpaceChild(this,dendrogram.icon_data.shrink);
                    node.setAttribute('data-sign',1);
                    children.setAttribute('style', 'display:block');
                    children.classList.remove('dendrogram-animation-reverse');
                    children.classList.add('dendrogram-animation-slide-top-small');
                }else {//shut
                    dendrogram.relpaceChild(this, dendrogram.icon_data.expand);
                    node.setAttribute('data-sign', 0);
                    children.classList.remove('dendrogram-animation-slide-top-small');
                    var t = setTimeout(function(){
                        children.classList.add('dendrogram-animation-reverse');
                    },0);
                }

                children.addEventListener('animationend',function callback(){
                    if(sign == 1) {
                        children.setAttribute('style', 'display:none');
                        clearTimeout(t);
                    }
                    children.removeEventListener('animationend',callback);
                    dendrogram.tree.shrinkAnimeFlag = false;
                });
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