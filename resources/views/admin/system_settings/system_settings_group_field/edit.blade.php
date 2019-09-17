 <!DOCTYPE html>
 <html>

 <head>
     @include('admin.public.include_head')
 </head>

 <body>
    <div class="layui-container" style="padding:15px">
        <form class="layui-form layui-form-pane" action="">
        <div class="layui-form-item">
                <label class="layui-form-label">设置组</label>
                <div class="layui-input-inline">
                    <select id="system_settings_group_id" name="system_settings_group_id" lay-verify="required">
                        <option value="">加载设置组中...</option>
                    </select>     
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">设置名称</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="name" lay-verify="required" autocomplete="off" placeholder="设置名称">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">唯一标识</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="field" lay-verify="required" autocomplete="off" placeholder="唯一标识">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">设置描述</label>
                <div class="layui-input-block">
                    <textarea type="text" class="layui-textarea" name="desc" placeholder="设置描述"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">设置类型</label>
                <div class="layui-input-inline">
                    <select id="type" name="type" lay-verify="required">
                        <option value="0">普通文本</option>
                        <option value="1">文本域</option>
                        <option value="2">单选</option>
                        <option value="3">多选</option>
                    </select>     
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">选项</label>
                <div class="layui-input-block">
                    <textarea type="text" class="layui-textarea" name="option" placeholder="选项如果是单选或多选，选项请以逗号隔开。文本则不填写"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">值</label>
                <div class="layui-input-block">
                    <textarea type="text" class="layui-textarea" name="value" placeholder="选项如果是单选或多选，选项key请以逗号隔开。文本则直接填写"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="submit" id="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">提交</button>
                    <button type="reset" id="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
     @include('admin.public.include_js')
     <script>
        //  获取父页面传过来的值
        var system_settings_group_field_info =  window.parent.edit_system_settings_group_field_info;
        console.log(system_settings_group_field_info);
        //  初始化input
        $("input[name='name']").val(system_settings_group_field_info.name);
        $("input[name='field']").val(system_settings_group_field_info.field);
        $("input[name='field']").val(system_settings_group_field_info.field);
        $("textarea[name='desc']").val(system_settings_group_field_info.desc);
        $("select[name='type']").val(system_settings_group_field_info.type);
        $("textarea[name='option']").val(system_settings_group_field_info.option);
        $("textarea[name='value']").val(system_settings_group_field_info.value);
        form.render("select");
        //  获取设置组列表
        ajaxLoad = layer.load(1, {
            shade: [0.8, '#393D49']
        });
        $.ajax({ 
            type: "GET",
            url: '{{url("api/admin/system_settings/system_settings_group/all")}}',
            success: function(result){
                layer.close(ajaxLoad);
                if (result.code > 0) {
                    layer.msg(result.msg);
                } else {
                    var html='<option value="">请选择设置组</option>';
                    $.each(result.data,function(key,value){
                        if(value.id == system_settings_group_field_info.system_settings_group_id){
                            html+="<option value='"+value.id+"' selected>"+value.name+"</option>";
                        }else{
                            html+="<option value='"+value.id+"'>"+value.name+"</option>";
                        }
                    })
                    $('select[name=system_settings_group_id]').html(html);
                    form.render("select");
                }
            }
        });
         //监听提交
         form.on('submit(formSubmit)', function(data) {
             formLoad = layer.load(1, {
                 shade: [0.8, '#393D49']
             });
             $.ajax({ 
                type: "PUT",
                url: '{{url("api/admin/system_settings/system_settings_group_field")}}/' + system_settings_group_field_info.id,
                data: {
                    '_method': 'PUT',
                    'system_settings_group_id': data.field.system_settings_group_id,
                    'name': data.field.name,
                    'field': data.field.field,
                    'desc': data.field.desc,
                    'type': data.field.type,
                    'option': data.field.option,
                    'value': data.field.value,
                },
                success: function(result){
                    layer.close(formLoad);
                    if (result.code > 0) {
                        layer.msg(result.msg);
                    } else {
                        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                        parent.layer.close(index); //再执行关闭   
                    }
                }
            });
             return false;
         });
     </script>
 </body>

 </html>