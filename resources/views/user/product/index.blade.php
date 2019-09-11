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
                    <button type="button" class="layui-btn layui-btn-sm" id="refresh-device-region">刷新表格</button> 
                    <button type="button" class="layui-btn layui-btn-sm" id="add-device-region">添加产品</button> 
                </div>
            </div>
            <div class="layui-row">
                <script type="text/html" id="bar">
                    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                    <a class="layui-btn layui-btn-xs" lay-event="product_field">字段管理</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
                </script>
                <table lay-size="sm" id="product" lay-filter="product"></table>
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
            table.render({
                elem: '#product'
                ,url: '{{url('api/user/product')}}' 
                ,page: true 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'name', title: '产品名称'}
                    ,{field: 'desc', title: '产品描述'}
                    ,{fixed: 'right', title:'操作', toolbar: '#bar', width:210}
                ]]
            });
            table.on('tool(product)', function(obj){
                var data = obj.data;
                if(obj.event === 'del'){
                    ajaxLoad = layer.load(1, {
                        shade: [0.8, '#393D49']
                    });
                    layer.confirm('真的删除行么', function(index){
                        $.ajax({ 
                            type: "POST",
                            url: '{{url("api/user/product")}}/'+ data.id,
                            data: {
                                '_method': 'DELETE',
                                'name': data.value,
                            },
                            success: function(result){
                                layer.msg(result.msg);
                                if (result.code == 0) {
                                    table.reload('product');
                                }
                            }
                        });
                        layer.close(index);
                    });
                    layer.close(ajaxLoad);
                } else if(obj.event === 'product_field'){
                    window.product_id = data.id;
                    layer.open({
                        type:2,
                        title:'字段管理',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("user/product/product_field")}}',
                        end:function(){
                            table.reload('product');
                        }
                    });
                } else if(obj.event === 'edit'){
                    window.edit_product_info = data;
                    layer.open({
                        type:2,
                        title:'修改产品',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("user/product/edit")}}',
                        end:function(){
                            table.reload('product');
                        }
                    });
                }
            });
            // 刷新页面
            $('#refresh-page').click(function(){
                window.location.reload();
            });
            // 刷新列表
            $('#refresh-device-region').click(function(){
                table.reload('product');
            });
            // 添加
            $('#add-device-region').click(function(){
                layer.open({
                    type:2,
                    title:'添加产品',
                    shadeClose:true,
                    shade:0.8,
                    area:['100%','100%'],
                    content:'{{url("user/product/add")}}',
                    end:function(){
                        table.reload('product');
                    }
                });
            });
     </script>
 </body>

 </html>