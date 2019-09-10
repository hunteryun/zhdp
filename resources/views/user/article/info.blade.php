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
     </script>
 </body>

 </html>