 <!DOCTYPE html>
 <html>

 <head>
     @include('user.public.include_head')
 </head>

 <body>
     <div class="layui-card">
         <div class="layui-card-body">
            <form class="layui-form">
                 <div class="layui-form-item">
                    <div class="layui-inline">
                        <div class="layui-btn-container">
                            <button type="button" class="layui-btn layui-btn-sm" id="refresh-page">刷新页面</button> 
                            <button type="button" class="layui-btn layui-btn-sm" id="refresh-article">刷新表格</button> 
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                            <select name="article_class_id" id="article_class_id" lay-search>
                                <option value="" selected>文章分类:加载中...</option>
                                <!-- <option value="" selected>文章分类:不限分类</option> -->
                            </select>
                        </div>
                    <div class="layui-inline">
                            <select name="status" id="status" lay-search>
                                <option value="" selected>帖子状态:综合</option>
                                <option value="1">帖子状态:未结</option>
                                <option value="2">帖子状态:已结</option>
                                <option value="3">帖子状态:精华</option>
                            </select>
                        </div>
                    <div class="layui-inline">
                            <select name="crop_class_id" id="crop_class_id" lay-search>
                                <option value="" selected>文章分类:加载中...</option>
                                <!-- <option value="" selected>作物分类:不限作物</option> -->
                            </select>
                    </div>
                    <div class="layui-inline">
                            <input type="text" name="title" autocomplete="off" placeholder="请输入标题" class="layui-input">
                    </div>
                    <div class="layui-inline">
                        <div class="layui-input-inline">
                        <button type="submit" id="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">搜索</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- 文章列表 -->
            <div class="layui-row">
                <script type="text/html" id="bar">
                    <a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="view">查看</a>
                    <a class="layui-btn layui-btn-xs" lay-event="cancel_article_collection">取消收藏</a>
                </script>
                <table lay-size="sm" id="article" lay-filter="article"></table>
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
            // 获取表格对象以重载  
            var articleTable = table.render({
                elem: '#article'
                ,url: '{{url('api/user/article_collection/my')}}' 
                ,page: true 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'article_class_name', title: '分类', templet : function (d){
                        return d.article.article_class.name;
                    }}
                    ,{field: 'crop_class_name', title: '作物', templet : function (d){
                        return d.article.crop_class.name;
                    }}
                    ,{field: 'title', title: '标题', templet : function (d){
                        return d.article.title;
                    }}
                    ,{field: 'user_id', title: '发帖人', templet : function (d){
                        return d.article.user.name;
                    }}
                    ,{field: 'created_at', title: '收藏时间'}
                    // ,{field: 'view_count', title: '浏览'}
                    ,{field: 'comment_count', title: '评论', templet : function (d){
                        return d.article.comment_count;
                    }}
                    // ,{field: 'article_collection_count', title: '收藏'}
                    ,{fixed: 'right', title:'操作', toolbar: '#bar', width:150}
                ]]
            });
            table.on('tool(article)', function(obj){
                var data = obj.data;
                if(obj.event === 'view'){
                    window.article_id = data.article_id;
                    layer.open({
                        type:2,
                        title:'文章详情',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("user/article/info")}}',
                        end:function(){
                            table.reload('article');
                        }
                    });
                }else if(obj.event === 'cancel_article_collection'){
                    var article_id = data.article_id;
                    // 取消收藏
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
                                }else{
                                    layer.msg("收藏成功");
                                }
                            }else{
                                // 取消收藏成功
                                if (result.code > 0) {
                                    layer.msg("取消收藏失败");
                                }else{
                                    layer.msg("取消收藏成功");
                                }
                            }
                            table.reload('article');
                        }
                    });
                }
                // cancel_article_collection
            });
            // 刷新页面
            $('#refresh-page').click(function(){
                return window.location.reload();
            });
            // 刷新列表
            $('#refresh-article').click(function(){
                return table.reload('article');
            });
            // 获取文章分类
            ajaxLoad2 = layer.load(1, {
                shade: [0.8, '#393D49']
            });
            $.ajax({ 
                type: "GET",
                url: '{{url("api/user/article_class/all")}}',
                success: function(result){
                    layer.close(ajaxLoad2);
                    if (result.code > 0) {
                        layer.msg(result.msg);
                    } else {
                        var html='<option value="" selected>文章分类:不限分类</option>';
                        $.each(result.data,function(key,value){
                            html+="<option value='"+value.id+"'>"+value.name+"</option>";
                        })
                        $('select[name=article_class_id]').html(html);
                        form.render("select");
                    }
                }
            });
            // 获取作物分类
            ajaxLoad3 = layer.load(1, {
                shade: [0.8, '#393D49']
            });
            $.ajax({ 
                type: "GET",
                url: '{{url("api/user/crop_class/all_child")}}',
                success: function(result){
                    layer.close(ajaxLoad3);
                    if (result.code > 0) {
                        layer.msg(result.msg);
                    } else {
                        var html='<option value="" selected>作物分类:不限作物</option>';
                        $.each(result.data,function(key,value){
                            html+="<option value='"+value.id+"'>"+value.name+"</option>";
                        })
                        $('select[name=crop_class_id]').html(html);
                        form.render("select");
                    }
                }
            });
            //监听搜索
            form.on('submit(formSubmit)', function(data) {
                // 重载 table
                articleTable.reload({
                    where: {
                        'article_class_id': data.field.article_class_id,
                        'crop_class_id': data.field.crop_class_id,
                        'status': data.field.status,
                        'title': data.field.title,
                    }
                });
                return false;
         });
     </script>
 </body>

 </html>