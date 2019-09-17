 <!DOCTYPE html>
 <html>

 <head>
     @include('admin.public.include_head')
 </head>

 <body>
     <div class="layui-card">
         <div class="layui-card-body">
            <form class="layui-form">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <div class="layui-btn-container">
                            <button type="button" class="layui-btn layui-btn-sm" id="refresh-page">刷新页面</button> 
                            <button type="button" class="layui-btn layui-btn-sm" id="refresh-device-region">刷新表格</button> 
                            <button type="button" class="layui-btn layui-btn-sm" id="add-device-region">添加作物分类</button> 
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <select name="pid" id="pid" lay-search>
                            <option value="" selected>作物分类:加载中...</option>
                        </select>
                    </div>
                    <div class="layui-inline">
                            <input type="text" name="name" autocomplete="off" placeholder="作物名称" class="layui-input">
                    </div>
                    <div class="layui-inline">
                        <div class="layui-input-inline">
                        <button type="submit" id="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">搜索</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="layui-row">
                <script type="text/html" id="bar">
                    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
                </script>
                <table lay-size="sm" id="crop_class" lay-filter="crop_class"></table>
            </div>
         </div>
     </div>
     @include('admin.public.include_js')
     <script>
            table.render({
                elem: '#crop_class'
                ,url: '{{url('api/admin/crop_class')}}' 
                ,page: true 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'name', title: '作物名称'}
                    ,{field: 'crop_class_parent_name', title: '所属分类', templet : function (d){
                        return d.crop_class_parent.name;
                    }}
                    ,{fixed: 'right', title:'操作', toolbar: '#bar', width:150}
                ]]
            });
            table.on('tool(crop_class)', function(obj){
                var data = obj.data;
                if(obj.event === 'del'){
                    ajaxLoad = layer.load(1, {
                        shade: [0.8, '#393D49']
                    });
                    layer.confirm('真的删除行么', function(index){
                        $.ajax({ 
                            type: "POST",
                            url: '{{url("api/admin/crop_class")}}/'+ data.id,
                            data: {
                                '_method': 'DELETE',
                                'name': data.value,
                            },
                            success: function(result){
                                layer.msg(result.msg);
                                if (result.code == 0) {
                                    table.reload('crop_class');
                                }
                            }
                        });
                        layer.close(index);
                    });
                    layer.close(ajaxLoad);
                } else if(obj.event === 'edit'){
                    window.edit_crop_class_info = data;
                    layer.open({
                        type:2,
                        title:'修改作物分类',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("admin/crop_class/edit")}}',
                        end:function(){
                            table.reload('crop_class');
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
                table.reload('crop_class');
            });
            // 添加
            $('#add-device-region').click(function(){
                layer.open({
                    type:2,
                    title:'添加作物分类',
                    shadeClose:true,
                    shade:0.8,
                    area:['100%','100%'],
                    content:'{{url("admin/crop_class/add")}}',
                    end:function(){
                        table.reload('crop_class');
                    }
                });
            });
            // 获取作物分类
            ajaxLoad3 = layer.load(1, {
                shade: [0.8, '#393D49']
            });
            $.ajax({ 
                type: "GET",
                url: '{{url("api/admin/crop_class/top")}}',
                success: function(result){
                    layer.close(ajaxLoad3);
                    if (result.code > 0) {
                        layer.msg(result.msg);
                    } else {
                        var html='<option value="" selected>作物分类:不限作物</option>';
                        $.each(result.data,function(key,value){
                            html+="<option value='"+value.id+"'>"+value.name+"</option>";
                        })
                        $('select[name=pid]').html(html);
                        form.render("select");
                    }
                }
            });
            //监听搜索
            form.on('submit(formSubmit)', function(data) {
                // 重载 table
                table.reload('crop_class', {
                    where: {
                        'pid': data.field.pid,
                        'name': data.field.name,
                    }
                });
                return false;
            });
     </script>
 </body>

 </html>