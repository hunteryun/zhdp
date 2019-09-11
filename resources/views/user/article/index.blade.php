 <!DOCTYPE html>
 <html>

 <head>
     @include('user.public.include_head')
 </head>

 <body class="layui-layout-body">
     <div class="layui-card">
         <div class="layui-card-body">
            <div class="layui-row">
                <div class="layui-btn-container">
                    <button type="button" class="layui-btn layui-btn-sm" id="refresh-page">刷新页面</button> 
                    <button type="button" class="layui-btn layui-btn-sm" id="refresh-article">刷新表格</button> 
                    <button type="button" class="layui-btn layui-btn-sm" id="add-article">发布文章</button> 
                </div>
            </div>
            <div class="layui-row">
                <script type="text/html" id="bar">
                    <a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="view">查看</a>
                </script>
                <table id="article" lay-filter="article"></table>
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
            table.render({
                elem: '#article'
                ,url: '{{url('api/user/article')}}' 
                ,page: true 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'title', title: '标题'}
                    ,{field: 'user_id', title: '发帖人', width:120, templet : function (d){
                        return d.user.name;
                    }}
                    ,{field: 'created_at', title: '时间', width:165}
                    ,{field: 'view_count', title: '浏览(次)', width:90}
                    ,{field: 'comment_count', title: '收藏(次)', width:90}
                    ,{fixed: 'right', title:'操作', toolbar: '#bar', width:80}
                ]]
            });
            table.on('tool(article)', function(obj){
                var data = obj.data;
                if(obj.event === 'view'){
                    window.article_id = data.id;
                    layer.open({
                        type:2,
                        title:'文章详情',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("user/article/info")}}',
                        // end:function(){
                        //     table.reload('article');
                        // }
                    });
                }
            });
            // 刷新页面
            $('#refresh-page').click(function(){
                window.location.reload();
            });
            // 刷新列表
            $('#refresh-article').click(function(){
                table.reload('article');
            });
            // 添加
            $('#add-article').click(function(){
                layer.open({
                    type:2,
                    title:'添加文章',
                    shadeClose:true,
                    shade:0.8,
                    area:['100%','100%'],
                    content:'{{url("user/article/add")}}',
                    end:function(){
                        table.reload('article');
                    }
                });
            });
     </script>
 </body>

 </html>