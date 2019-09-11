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
            收藏：<span id="article_collection_count">0</span>
            <button type="button" class="layui-btn layui-btn-xs layui-btn-primary" id="article-collection">收藏</button> 
        </div>
         <div class="layui-card-body" id="content">
            文章内容加载中
         </div>
     </div>
     <blockquote class="layui-elem-quote">
         回复
    </blockquote>
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-form layui-form-pane">
                <div class="layui-form-item layui-form-text">
                    <div class="layui-input-block">
                        <textarea type="text" class="layui-textarea" id="my-comment" name="my-comment" placeholder="评论内容"></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <button type="submit" id="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">提交</button>
                </div>
            </div>
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
                    $('#article_collection_count').html(article_info.article_collection_count);
                    $('#content').html(article_info.content);
                }
            }
        });
        // 收藏
        $.ajax({ 
            type: "GET",
            url: '{{url("api/user/article_collection")}}/' + article_id,
            success: function(result){
                if (result.code > 0) {
                    $('#article-collection').text('收藏');
                    $('#article-collection').addClass("layui-btn-primary");
                } else {
                    $('#article-collection').text('已收藏');
                    $('#article-collection').removeClass("layui-btn-primary");
                }
                // 点击收藏事件
                $('#article-collection').click(function(){
                    //  获取文章详情
                    ajaxLoad2 = layer.load(1, {
                        shade: [0.8, '#393D49']
                    });
                    $.ajax({ 
                        type: "POST",
                        url: '{{url("api/user/article_collection")}}?article_id=' + article_id,
                        success: function(result){
                            layer.close(ajaxLoad2);
                            // status 0 取消收藏 1 收藏
                            if(result.status > 0){
                                // 收藏成功
                                if (result.code > 0) {
                                    layer.msg("收藏失败");
                                    $('#article-collection').text('收藏');
                                    $('#article-collection').addClass("layui-btn-primary");
                                }else{
                                    layer.msg("收藏成功");
                                    $('#article-collection').text('已收藏');
                                    $('#article-collection').removeClass("layui-btn-primary");
                                }
                            }else{
                                // 取消收藏成功
                                if (result.code > 0) {
                                    layer.msg("取消收藏失败");
                                    $('#article-collection').text('已收藏');
                                    $('#article-collection').removeClass("layui-btn-primary");
                                }else{
                                    layer.msg("取消收藏成功");
                                    $('#article-collection').text('收藏');
                                    $('#article-collection').addClass("layui-btn-primary");
                                }
                            }
                        }
                    });
                });
            }
        });

        // 初始化编辑器
        var layedit = layui.layedit;
        var layeditNode = layedit.build('my-comment',{
            tool:[  
                'strong' //加粗
                ,'italic' //斜体
                ,'underline' //下划线
                ,'del' //删除线
                ,'|' //分割线
                ,'left' //左对齐
                ,'center' //居中对齐
                ,'right' //右对齐
                ,'link' //超链接
                ,'unlink' //清除链接
                ,'face' //表情
            ],
            height: 150
        }); 
         //监听评论提交
         form.on('submit(formSubmit)', function(data) {
             var content = layedit.getContent(layeditNode);
             if(typeof content == "undefined" || content == null || content == ""){
                 return layer.alert("请输入评论内容");
             }
             formLoad = layer.load(1, {
                 shade: [0.8, '#393D49']
             });
             $.ajax({ 
                type: "POST",
                url: '{{url("api/user/article_comment")}}',
                data: {
                    'article_id': article_id,
                    'content': content,
                },
                success: function(result){
                    if (result.code > 0) {
                        layer.msg(result.msg);
                    } else {
                        // 刷新页面 
                        window.location.reload();
                    }
                    layer.close(formLoad);
                }
            });
             return false;
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
            //  获取评论列表
            ajaxLoad1 = layer.load(1, {
                shade: [0.8, '#393D49']
            });
            $.ajax({ 
                type: "GET",
                url: '{{url("api/user/article_comment")}}?article_id=' + article_id + "&page="+page+"&limit="+limit,
                success: function(result){

                    layer.close(ajaxLoad1);

                    if (result.code > 0) {
                        layer.msg(result.msg);
                    } else {
                        // 初始化分页
                        if(first){
                            // 这里需要覆盖文章分页的构造，如果不设置jump和count则无法显示分页
                            laypage.render({
                                elem: 'article_comment_page'
                                ,count: result.count
                                ,height: 150
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
                                html += '用户:' + data[i].user.name;
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