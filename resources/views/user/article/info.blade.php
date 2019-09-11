<!DOCTYPE html>
 <html>

 <head>
     @include('user.public.include_head')
 </head>

 <body class="layui-layout-body" style="padding: 20px; background-color: #F2F2F2;overflow-y: scroll;">
     <div class="layui-card">
        <div class="layui-card-header" style="height: auto">
            标题：<span id="title">标题加载中...</span>
            用户：<span id="user_name"></span>
            时间：<span id="created_at"></span>
            查看：<span id="view_count">0</span>
            评论：<span id="comment_count">0</span>
        </div>
         <div class="layui-card-body" id="content">
            文章内容加载中
         </div>
     </div>
     <blockquote class="layui-elem-quote">
         评论
    </blockquote>
    <div id="article_comment">
        评论加载中...
    </div>
    <div id="article_comment_page"></div>
     @include('user.public.include_js')
     <script>
        var article_id = window.parent.article_id;
       //  获取文章详情
       ajaxLoad = layer.load(1, {
            shade: [0.8, '#393D49']
        });
        $.ajax({ 
            type: "GET",
            url: '{{url("api/user/article")}}/' + article_id,
            success: function(result){
                layer.close(ajaxLoad);
                if (result.code > 0) {
                    layer.msg(result.msg);
                } else {
                    article_info = result.data;
                    $('#title').html(article_info.title);
                    $('#user_name').html(article_info.user.name);
                    $('#created_at').html(article_info.created_at);
                    $('#view_count').html(article_info.view_count);
                    $('#comment_count').html(article_info.comment_count);
                    $('#content').html(article_info.content);
                }
            }
        });
        // 文章分页
        var laypage = layui.laypage;
        laypage.render({
            elem: 'article_comment_page'
            ,jump: function(obj, first){
                // 获取文章评论
                if(first){
                    // 第一次请求以获取首页评论
                    ajaxGetComment(first);
                }
            }
        });
        // 获取分页
        function ajaxGetComment(first, page = 1, limit = 10){
            $.ajax({ 
                type: "GET",
                url: '{{url("api/user/article_comment")}}?article_id=' + article_id + "&page="+page+"&limit="+limit,
                success: function(result){
                    if (result.code > 0) {
                        layer.msg(result.msg);
                    } else {
                        // 初始化分页
                        if(first){
                            // 这里需要覆盖文章分页的构造，如果不设置jump和count则无法显示分页
                            laypage.render({
                                elem: 'article_comment_page'
                                ,count: result.count
                                ,jump: function(obj, first){
                                    var page = obj.curr?obj.curr:1;
                                    var limit = obj.limit?obj.limit:10;
                                    // 加载到这里的时候已经获取到首页评论了，所以这里判断不是第一次才请求
                                    if(!first){
                                        ajaxGetComment(first, page, limit);
                                    }
                                }
                            });
                        }
                        // 渲染数据
                        var data = result.data;
                        var html = "";
                        for(var i = 0; i < data.length; i++){
                            html += '<div class="layui-card">';
                            html += '<a id="'+data[i].id+'"></a>';
                            html += '<div class="layui-card-header" style="height: auto">';
                                html += '用户:' + data[i].user_id;
                                html += ' 时间:' + data[i].created_at;
                            html += '</div>';
                                html += '<div class="layui-card-body">';
                                    html += data[i].content;
                                html += '</div>';
                            html += '</div>';
                        }   
                        $('#article_comment').html(html);
                    }
                }
            });
        }
     </script>
 </body>

 </html>