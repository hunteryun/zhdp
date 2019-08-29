 <!DOCTYPE html>
 <html>

 <head>
     @include('user.public.include_head')
     <style>
         /* 第一个按钮禁止删除 */
         ul.layui-tab-title li:first-child i {
             display: none;
         }
     </style>
 </head>

 <body class="layui-layout-body">
     <div class="layui-layout layui-layout-admin">
         <div class="layui-header header header-demo">
             <div class="layui-main">
                 <div class="layui-logo">layui 后台布局</div>
                 <!-- 大屏幕显示区域 -->
                 <ul class="layui-nav layui-layout-left layui-hide-xs">
                     <li class="layui-nav-item"><a class="layui-open-tab" href="http://baidu.com">控制台</a></li>
                     <li class="layui-nav-item"><a class="layui-open-tab" href="">商品管理</a></li>
                     <li class="layui-nav-item"><a href="">用户</a></li>
                     <li class="layui-nav-item">
                         <a href="javascript:;">其它系统</a>
                         <dl class="layui-nav-child">
                             <dd><a href="">邮件管理</a></dd>
                             <dd><a href="">消息管理</a></dd>
                             <dd><a href="">授权管理</a></dd>
                         </dl>
                     </li>
                 </ul>
                 <ul class="layui-nav layui-layout-right">
                     <li class="layui-nav-item">
                         <a href="javascript:;">
                             <img src="//tva1.sinaimg.cn/crop.0.0.118.118.180/5db11ff4gw1e77d3nqrv8j203b03cweg.jpg" class="layui-nav-img">
                             贤心
                         </a>
                         <dl class="layui-nav-child">
                             <dd><a href="">退出</a></dd>
                         </dl>
                     </li>
                 </ul>
             </div>
         </div>

         <div class="layui-side layui-bg-black">
             <div class="layui-side-scroll">
                 <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                 <ul class="layui-nav layui-nav-tree" lay-filter="test">
                     <li class="layui-nav-item layui-nav-itemed">
                         <a class="" href="javascript:;">所有商品</a>
                         <dl class="layui-nav-child">
                             <dd><a href="javascript:;">列表一</a></dd>
                             <dd><a href="javascript:;">列表二</a></dd>
                             <dd><a href="javascript:;">列表三</a></dd>
                             <dd><a href="">超链接</a></dd>
                         </dl>
                     </li>
                     <li class="layui-nav-item">
                         <a href="javascript:;">解决方案</a>
                         <dl class="layui-nav-child">
                             <dd><a href="javascript:;">列表一</a></dd>
                             <dd><a href="javascript:;">列表二</a></dd>
                             <dd><a href="">超链接</a></dd>
                         </dl>
                     </li>
                     <li class="layui-nav-item"><a href="">云市场</a></li>
                     <li class="layui-nav-item"><a href="">发布商品</a></li>
                 </ul>
             </div>
         </div>

         <div class="layui-body">
             <div class="layui-tab layui-tab-brief admin-nav-card" style="margin-top: 0px!important;" lay-filter="index-tab" lay-allowclose="true">
                 <ul class="layui-tab-title">
                     <li class="layui-this" lay-id="1">网站设置</li>
                 </ul>
                 <div class="layui-tab-content" style="min-height: 150px; padding: 5px 0 0 0;overflow-y:auto;">
                     <div class="layui-tab-item layui-show">
                        <iframe src="" style="width: 100%;border: 0"></iframe>
                     </div>
                 </div>
             </div>
         </div>
         <div class="layui-footer layui-hide-xs">
             <!-- 底部固定区域 -->
             © layui.com - 底部固定区域
         </div>
     </div>
     @include('user.public.include_js')
     <script>
         var $ = layui.jquery,
             layer = layui.layer,
             element = layui.element; // Tab的切换功能，切换事件监听等，需要依赖element模块
            //  class="layui-open-tab" iframe 打开网页
         var tabList = {}; // 记录已经打开的tab
         $(function() {
             $('a[class=layui-open-tab]').each(function(index) {
                 $(this).click(function() {
                     var href = $(this).attr("href");
                     var title = $(this).text();
                     var id = new Date().getTime();
                     for (var i in tabList) {
                         if (tabList[i] == title) {
                            element.tabChange('index-tab', i); //切换到：用户管理
                             return false;
                         }
                     }
                     var key = 'layId' + id;
                     tabList[key] = title;
                     element.tabAdd('index-tab', {
                         title: title,
                         content: '<iframe src="'+href+'" style="width:100%;height:'+($('.layui-body').height() - 60)+'px;border:0"></iframe>',
                         id: key
                     });
                     element.tabChange('index-tab', key);  
                     return false;
                 });
             });
         });
        // //  响应设置iframe 高度
        $(window).on('resize', function () {
            var bodyHeight = $('.layui-body').height();
            $('.layui-body .layui-tab-content').find('.layui-tab-item').each(function () {
                $(this).height(bodyHeight - 60);
            });
        }).resize();
         //  监听tab删除
         element.on('tabDelete(index-tab)', function(data) {
            var key = 'layId' + $(this).parent().attr("lay-id");
            delete tabList[key];
         });
     </script>
 </body>

 </html>