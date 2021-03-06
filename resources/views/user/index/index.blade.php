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

 <body>
     <div class="layui-layout layui-layout-admin">
         <div class="layui-header header header-demo">
             <div class="layui-main">
                 <div class="layui-logo">云蛙-物联网云棚后台</div>
                 <!-- 大屏幕显示区域 -->
                 <ul class="layui-nav layui-layout-right">
                     <li class="layui-nav-item">
                         <a href="javascript:;">
                             用户
                         </a>
                         <dl class="layui-nav-child">
                             <dd><a class="" id="outLogin" href="">退出</a></dd>
                         </dl>
                     </li>
                 </ul>
             </div>
         </div>

         <div class="layui-side layui-bg-black">
             <div class="layui-side-scroll">
                 <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                 <ul class="layui-nav layui-nav-tree" lay-filter="test">
                    <li class="layui-nav-item">
                         <a class="" href="javascript:;">位置房间管理</a>
                         <dl class="layui-nav-child">
                             <dd><a class="layui-open-tab" href="{{url('user/device_region')}}">区域管理</a></dd>
                             <dd><a class="layui-open-tab" href="{{url('user/device_room')}}">房间管理</a></dd>
                         </dl>
                     </li>
                     <li class="layui-nav-item">
                         <a class="" href="javascript:;">作物追溯管理</a>
                         <dl class="layui-nav-child">
                             <dd><a class="layui-open-tab" href="{{url('user/crop_traceability')}}">作物追溯</a></dd>
                             <dd><a class="layui-open-tab" href="{{url('user/crop_traceability/crop_traceability_batch/pending_review')}}">作物追溯待审核</a></dd>
                             <dd><a class="layui-open-tab" href="{{url('user/crop_traceability/crop_traceability_batch/audited')}}">作物追溯已审核</a></dd>
                         </dl>
                     </li>
                     <!-- <li class="layui-nav-item"><a class="layui-open-tab" href="{{url('user/crop_traceability')}}">作物追溯</a></li> -->
                     <li class="layui-nav-item">
                         <a class="" href="javascript:;">设备管理</a>
                         <dl class="layui-nav-child">
                             <dd><a class="layui-open-tab" href="{{url('user/device')}}">设备管理</a></dd>
                             <dd><a class="layui-open-tab" href="{{url('user/device/device_field_log')}}">设备日志</a></dd>
                             <dd><a class="layui-open-tab" href="{{url('user/device/device_event')}}">事件管理</a></dd>
                             <dd><a class="layui-open-tab" href="{{url('user/device/device_event_log')}}">事件日志</a></dd>
                         </dl>
                     </li>
                     <li class="layui-nav-item">
                         <a class="" href="javascript:;">数据分析</a>
                         <dl class="layui-nav-child">
                             <!-- 通过百度echer进行显示 -->
                             <dd><a class="layui-open-tab" href="{{url('user/data_analysis/visualization')}}">数据可视化</a></dd>
                             <!-- 整理显示为漂亮的数据大屏 -->
                             <dd><a class="layui-open-tab" href="{{url('user/data_analysis/big_screen')}}">数据大屏</a></dd>
                         </dl>
                     </li>
                     <li class="layui-nav-item"><a class="layui-open-tab" href="{{url('user/pest_warning/pest_warning_log')}}">病虫害天气预警记录</a></li>
                     <!--  layui-nav-itemed 打开选项卡 -->
                     <li class="layui-nav-item">
                         <a class="" href="javascript:;">社区交流</a>
                         <dl class="layui-nav-child">
                             <dd><a class="layui-open-tab" href="{{url('user/article')}}">文章浏览</a></dd>
                             <dd><a class="layui-open-tab" href="{{url('user/article/my')}}">我的文章</a></dd>
                             <dd><a class="layui-open-tab" href="{{url('user/article/my_comment')}}">我的评论</a></dd>
                             <dd><a class="layui-open-tab" href="{{url('user/article/my_collection')}}">我的收藏</a></dd>
                             <dd><a class="layui-open-tab" href="{{url('user/article/my_view')}}">最近浏览</a></dd>
                         </dl>
                     </li>
                     <li class="layui-nav-item"><a class="layui-open-tab" href="{{url('user/my')}}">个人信息</a></li>
                     <li class="layui-nav-item">
                         <a class="" href="javascript:;">登录通知管理</a>
                         <dl class="layui-nav-child">
                             <!-- 每次登录都要通知的通知 -->
                             <dd><a class="layui-open-tab" href="{{url('user/login_notice/immediate_login_notice')}}">即时通知</a></dd>
                             <!-- 用户只查看一次就不再显示的通知 -->
                             <dd><a class="layui-open-tab" href="{{url('user/login_notice/login_notice_log')}}">历史通知</a></dd>
                         </dl>
                     </li>
                     <li class="layui-nav-item"><a class="layui-open-tab" href="{{url('user/system_msg')}}">系统消息</a></li>
                 </ul>
             </div>
         </div>
        <div class="site-tree-mobile layui-hide">
            <i class="layui-icon"></i>
        </div>
        <div class="site-mobile-shade"></div>
         <div class="layui-body">
             <div class="layui-tab layui-tab-brief admin-nav-card" style="margin-top: 0px!important;" lay-filter="index-tab" lay-allowclose="true">
                 <ul class="layui-tab-title">
                     <li class="layui-this" lay-id="1">控制台</li>
                 </ul>
                 <div class="layui-tab-content" style="min-height: 150px; overflow-y:auto;background: #F2F2F2;">
                     <div class="layui-tab-item layui-show">
                        <div class="layui-card">
                            <div class="layui-card-body" style="background: #F2F2F2;">
                               <!-- 内容 -->
                                <!-- <div class="layui-fluid">
                                    <div class="layui-row layui-col-space5">
                                    <div class="layui-col-md2">
                                            <div class="layui-card">
                                                <div class="layui-card-header">区域数量</div>
                                                <div class="layui-card-body">
                                                2
                                                </div>
                                            </div>
                                        </div>
                                        <div class="layui-col-md2">
                                        <div class="layui-card">
                                            <div class="layui-card-header">房间数量</div>
                                            <div class="layui-card-body">
                                            20
                                            </div>
                                        </div>
                                        </div>
                                        <div class="layui-col-md2">
                                            <div class="layui-card">
                                                <div class="layui-card-header">设备数量</div>
                                                <div class="layui-card-body">
                                               66
                                                </div>
                                            </div>
                                        </div>
                                        <div class="layui-col-md2">
                                            <div class="layui-card">
                                                <div class="layui-card-header">字段数量</div>
                                                <div class="layui-card-body">
                                                260
                                                </div>
                                            </div>
                                        </div>
                                        <div class="layui-col-md2">
                                            <div class="layui-card">
                                                <div class="layui-card-header">当日请求次数</div>
                                                <div class="layui-card-body">
                                               6000
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="layui-col-md2">
                                            <div class="layui-card">
                                                <div class="layui-card-header">报警次数</div>
                                                <div class="layui-card-body">
                                               6
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="layui-col-md12">
                                        <div class="layui-card">
                                            <div class="layui-card-header">标题</div>
                                            <div class="layui-card-body">
                                            内容
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>       -->
                               <!-- end -->
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
             © zhdp
         </div>
     </div>
     @include('user.public.include_js')
     <script>
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
        // 退出登录
        $("#outLogin").click(function(){
            // 登录通知(每次)
            ajaxLoad20 = layer.load(1, {
                shade: [0.8, '#393D49']
            });
            $.ajax({ 
                type: "GET",
                url: "{{url('api/user/out')}}",
                success: function(result){
                    layer.close(ajaxLoad20);
                    layer.msg("正在跳转登录页面",{
                        shade: [0.8, '#393D49']
                    });
                    window.location.href = "{{url('user/login')}}";
                }
            });
            return false;
        });
        // 登录通知(每次)
        ajaxLoad2 = layer.load(1, {
            shade: [0.8, '#393D49']
        });
        $.ajax({ 
            type: "GET",
            url: "{{url('api/user/login_notice/immediate_login_notice/every_day_all')}}",
            success: function(result){
                layer.close(ajaxLoad2);
                if(result.code > 0){
                    // 防止登录失效 js出错
                    return layer.msg(result.msg,{
                        shade: [0.8, '#393D49']
                    });
                }
                var data = result.data;
                for (let index = 0; index < data.length; index++) {
                    layer.open({
                        type: 1,
                        title: data[index].title,
                        content: '<div style="padding:10px 30px 30px 30px"><div class="layui-row layui-col-space15"><div class="layui-col-md12"><div class="layui-card"><div class="layui-card-body">'+data[index].content+'</div></div></div></div></div>  '
                    });
                }
            }
        });
        // 登录通知(未读))
        ajaxLoad2 = layer.load(1, {
            shade: [0.8, '#393D49']
        });
        $.ajax({ 
            type: "GET",
            url: "{{url('api/user/login_notice/login_notice_log/unread_all')}}",
            success: function(result){
                layer.close(ajaxLoad2);
                if(result.code > 0){
                    // 防止登录失效 js出错
                    return layer.msg(result.msg,{
                        shade: [0.8, '#393D49']
                    });
                }
                var data = result.data;
                for (let index = 0; index < data.length; index++) {
                    layer.open({
                        type: 1,
                        title: data[index].login_notice.title,
                        content: '<div style="padding:10px 30px 30px 30px"><div class="layui-row layui-col-space15"><div class="layui-col-md12"><div class="layui-card"><div class="layui-card-body">'+data[index].login_notice.content+'</div></div></div></div></div>  '
                    });
                }
            }
        });
     </script>
 </body>

 </html>