 <!DOCTYPE html>
 <html>

 <head>
     @include('user.public.include_head')
 </head>

 <body class="layui-layout-body">
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
            </form>
            <!-- 文章列表 -->
            <div class="layui-row">
                <script type="text/html" id="bar">
                    <a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="view">查看</a>
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
                ,url: '{{url('api/user/article_comment/my')}}' 
                ,page: true 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'article.title', title: '文章标题', templet : function (d){
                        return d.article.title;
                    }}
                    ,{field: 'content', title: '评论内容'}
                    ,{field: 'created_at', title: '时间'}
                    ,{fixed: 'right', title:'操作', toolbar: '#bar', width:60}
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
                        content:'{{url("user/article/info")}}#'+data.id,
                        end:function(){
                            table.reload('article');
                        }
                    });
                }
            });
            // 刷新页面
            $('#refresh-page').click(function(){
                return window.location.reload();
            });
            // 刷新列表
            $('#refresh-article').click(function(){
                return table.reload('article');
            });
     </script>
 </body>

 </html>