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
                    <button type="button" class="layui-btn layui-btn-sm" id="refresh-product-field-region">刷新表格</button> 
                    <button type="button" class="layui-btn layui-btn-sm" id="add-product-field-region">添加</button> 
                </div>
            </div>
            <div class="layui-row">
                <script type="text/html" id="bar">
                    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
                </script>
                <table id="product_field" lay-filter="product_field"></table>
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
         var product_id = window.parent.product_id;
            table.render({
                elem: '#product_field'
                ,url: '{{url('api/user/product/product_field/all')}}?product_id='+product_id
                ,page: false 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'name', title: '名称'}
                    ,{field: 'field', title: '标识符'}
                    ,{field: 'field_type_id', title: '类型id'}
                    ,{field: 'field_type_length', title: '长度'}
                    ,{field: 'default', title: '默认值'}
                    ,{field: 'common_field', title: '公共字段'}
                    ,{field: 'common_field_sort', title: '公共字段排序'}
                    ,{field: 'desc', title: '描述'}
                    ,{field: 'sort', title: '排序'}
                    ,{fixed: 'right', title:'操作', toolbar: '#bar', width:210}
                ]]
            });
            table.on('tool(product_field)', function(obj){
                var data = obj.data;
                if(obj.event === 'del'){
                    ajaxLoad = layer.load(1, {
                        shade: [0.8, '#393D49']
                    });
                    layer.confirm('真的删除行么', function(index){
                        $.ajax({ 
                            type: "POST",
                            url: '{{url("api/user/product/product_field")}}/'+ data.id,
                            data: {
                                '_method': 'DELETE',
                                'name': data.value,
                            },
                            success: function(result){
                                layer.msg(result.msg);
                                if (result.code == 0) {
                                    table.reload('product_field');
                                }
                            }
                        });
                        layer.close(index);
                    });
                    layer.close(ajaxLoad);
                } else if(obj.event === 'edit'){
                    window.edit_product_field_info = data;
                    layer.open({
                        type:2,
                        title:'修改',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("user/product/product_field/edit")}}',
                        end:function(){
                            table.reload('product_field');
                        }
                    });
                }
            });
            // 刷新页面
            $('#refresh-page').click(function(){
                window.location.reload();
            });
            // 刷新列表
            $('#refresh-product-field-region').click(function(){
                table.reload('product_field');
            });
            // 添加
            $('#add-product-field-region').click(function(){
                window.product_id = product_id;
                layer.open({
                    type:2,
                    title:'添加',
                    shadeClose:true,
                    shade:0.8,
                    area:['100%','100%'],
                    content:'{{url("user/product/product_field/add")}}',
                    end:function(){
                        table.reload('product_field');
                    }
                });
            });
     </script>
 </body>

 </html>