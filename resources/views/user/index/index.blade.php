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
                     <li class="layui-nav-item"><a href="{{url('/')}}">网站首页</a></li>
                     <!-- <li class="layui-nav-item"><a class="layui-open-tab" href="">商品管理</a></li>
                     <li class="layui-nav-item"><a class="layui-open-tab" href="">用户</a></li>
                     <li class="layui-nav-item">
                         <a href="javascript:;">其它系统</a>
                         <dl class="layui-nav-child">
                             <dd><a class="layui-open-tab" href="">邮件管理</a></dd>
                             <dd><a class="layui-open-tab" href="">消息管理</a></dd>
                             <dd><a class="layui-open-tab" href="">授权管理</a></dd>
                         </dl>
                     </li> -->
                 </ul>
                 <ul class="layui-nav layui-layout-right">
                     <li class="layui-nav-item">
                         <a href="javascript:;">
                             <img src="//tva1.sinaimg.cn/crop.0.0.118.118.180/5db11ff4gw1e77d3nqrv8j203b03cweg.jpg" class="layui-nav-img">
                             贤心
                         </a>
                         <dl class="layui-nav-child">
                             <dd><a class="layui-open-tab" href="">退出</a></dd>
                         </dl>
                     </li>
                 </ul>
             </div>
         </div>

         <div class="layui-side layui-bg-black">
             <div class="layui-side-scroll">
                 <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                 <ul class="layui-nav layui-nav-tree" lay-filter="test">
                    <li class="layui-nav-item"><a class="layui-open-tab" href="">区域管理</a></li>
                    <li class="layui-nav-item"><a class="layui-open-tab" href="">房间管理</a></li>
                    <li class="layui-nav-item"><a class="layui-open-tab" href="">设备管理</a></li>
                     <!-- <li class="layui-nav-item layui-nav-itemed">
                         <a class="" href="javascript:;">所有商品</a>
                         <dl class="layui-nav-child">
                             <dd><a href="javascript:;">列表一</a></dd>
                             <dd><a href="javascript:;">列表二</a></dd>
                             <dd><a href="javascript:;">列表三</a></dd>
                             <dd><a class="layui-open-tab" href="">超链接</a></dd>
                         </dl>
                     </li>
                     <li class="layui-nav-item">
                         <a href="javascript:;">解决方案</a>
                         <dl class="layui-nav-child">
                             <dd><a href="javascript:;">列表一</a></dd>
                             <dd><a href="javascript:;">列表二</a></dd>
                             <dd><a class="layui-open-tab" href="">超链接</a></dd>
                         </dl>
                     </li>
                     <li class="layui-nav-item"><a class="layui-open-tab" href="">云市场</a></li>
                     <li class="layui-nav-item"><a class="layui-open-tab" href="">发布商品</a></li> -->
                 </ul>
             </div>
         </div>

         <div class="layui-body">
             <div class="layui-tab layui-tab-brief admin-nav-card" style="margin-top: 0px!important;" lay-filter="index-tab" lay-allowclose="true">
                 <ul class="layui-tab-title">
                     <li class="layui-this" lay-id="1">网站设置</li>
                 </ul>
                 <div class="layui-tab-content" style="min-height: 150px; overflow-y:auto;background: #F2F2F2;">
                     <div class="layui-tab-item layui-show">
                        <div class="layui-card">
                            <div class="layui-card-body">
                            <table class="layui-table" lay-even="" lay-skin="row">
                                <colgroup>
                                    <col width="200">
                                    <col>
                                </colgroup>
                                <thead>
                                    <tr>
                                    <th>配置名</th>
                                    <th>值</th>
                                    </tr> 
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>服务器IP地址</td>
                                        <td>{{$_SERVER['SERVER_ADDR']}}</td>
                                    </tr>
                                    <tr>
                                        <td>服务器域名</td>
                                        <td>{{$_SERVER['SERVER_NAME']}}</td>
                                    </tr>
                                    <tr>
                                        <td>服务器端口</td>
                                        <td>{{$_SERVER['SERVER_PORT']}}</td>
                                    </tr>
                                    <tr>
                                        <td>服务器版本</td>
                                        <td>{{php_uname('s').php_uname('r')}}</td>
                                    </tr>
                                    <tr>
                                        <td>服务器操作系统</td>
                                        <td>{{php_uname()}}</td>
                                    </tr>
                                    <tr>
                                        <td>PHP版本</td>
                                        <td>{{PHP_VERSION}}</td>
                                    </tr>
                                    <tr>
                                        <td>PHP安装路径</td>
                                        <td>{{DEFAULT_INCLUDE_PATH}}</td>
                                    </tr>
                                    <tr>
                                        <td>当前文件绝对路径</td>
                                        <td>{{__FILE__}}</td>
                                    </tr>
                                    <tr>
                                        <td>获取Http请求中Host值</td>
                                        <td>{{$_SERVER["HTTP_HOST"]}}</td>
                                    </tr>
                                    <tr>
                                        <td>Zend版本</td>
                                        <td>{{Zend_Version()}}</td>
                                    </tr>
                                    <tr>
                                        <td>Laravel版本</td>
                                        <td>{{app()::VERSION}}</td>
                                    </tr>
                                    <tr>
                                        <td>PHP运行方式</td>
                                        <td>{{php_sapi_name()}}</td>
                                    </tr>
                                    <tr>
                                        <td>服务器当前时间</td>
                                        <td>{{date("Y-m-d H:i:s")}}</td>
                                    </tr>
                                    <tr>
                                        <td>最大上传限制</td>
                                        <td>{{get_cfg_var ("upload_max_filesize")?get_cfg_var ("upload_max_filesize"):"不允许"}}</td>
                                    </tr>
                                    <tr>
                                        <td>最大执行时间</td>
                                        <td>{{get_cfg_var("max_execution_time")."秒 "}}</td>
                                    </tr>
                                    <tr>
                                        <td>脚本运行占用最大内存</td>
                                        <td>{{get_cfg_var ("memory_limit")?get_cfg_var("memory_limit"):"无"}}</td>
                                    </tr>
                                    <tr>
                                        <td>服务器解译引擎</td>
                                        <td>{{$_SERVER['SERVER_SOFTWARE']}}</td>
                                    </tr>
                                    <tr>
                                        <td>服务器系统目录</td>
                                        <td>{{$_SERVER['SystemRoot']}}</td>
                                    </tr>
                                    <tr>
                                        <td>服务器域名（主机名）</td>
                                        <td>{{$_SERVER['SERVER_NAME']}}</td>
                                    </tr>
                                    <tr>
                                        <td>服务器语言</td>
                                        <td>{{$_SERVER['HTTP_ACCEPT_LANGUAGE']}}</td>
                                    </tr>
                                    <tr>
                                        <td>服务器Web端口</td>
                                        <td>{{$_SERVER['SERVER_PORT']}}</td>
                                    </tr>
                                    <tr>
                                        <td>请求页面时通信协议的名称和版本</td>
                                        <td>{{$_SERVER['SERVER_PROTOCOL']}}</td>
                                    </tr>
                                </tbody>
                            </div>
                        </div>
                     </div>
                 </div>
             </div>
         </div>
         <div class="site-mobile-shade"></div>
         <div class="site-tree-mobile layui-hide">
             <i class="layui-icon"></i>
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
                         content: '<iframe src="' + href + '" style="width:100%;height:' + ($('.layui-body').height() - 60) + 'px;border:0"></iframe>',
                         id: key
                     });
                     element.tabChange('index-tab', key);
                     return false;
                 });
             });
         });
         // //  响应设置iframe 高度
         $(window).on('resize', function() {
             var bodyHeight = $('.layui-body').height();
             $('.layui-body .layui-tab-content').find('.layui-tab-item').each(function() {
                 $(this).height(bodyHeight - 60);
             });
         }).resize();
         //  监听tab删除
         element.on('tabDelete(index-tab)', function(data) {
             var key = $(this).parent().attr("lay-id");
             delete tabList[key];
         });
        //  监听显示侧边栏
        var treeMobile = $('.site-tree-mobile'),
            shadeMobile = $('.site-mobile-shade');
        treeMobile.on('click', function () {
            $('body').addClass('site-mobile');
        });
        shadeMobile.on('click', function () {
            $('body').removeClass('site-mobile');
        });
     </script>
 </body>

 </html>