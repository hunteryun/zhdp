 <!DOCTYPE html>
 <html>

 <head>
     @include('admin.public.include_head')
 </head>

 <body>
    <div class="layui-container" style="padding:15px">
        <form class="layui-form layui-form-pane" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">字段名称</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="name" lay-verify="required" autocomplete="off" placeholder="字段名称">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">字段标识符</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="field" lay-verify="required" autocomplete="off" placeholder="字段标识符">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">字段类型</label>
                <div class="layui-input-inline">
                    <select id="field_type_id" name="field_type_id" lay-verify="required" lay-filter="field_type_id">
                        <option value="">加载类型中...</option>
                    </select>     
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">字段长度</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="field_type_length" lay-verify="required" autocomplete="off" placeholder="字段长度">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">字段默认值</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="default" autocomplete="off" placeholder="字段默认值">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">公共字段</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="common_field" autocomplete="off" placeholder="公共字段">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">公共字段排序</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="common_field_sort" value="0" autocomplete="off" placeholder="公共字段排序">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">字段描述</label>
                <div class="layui-input-inline">
                    <textarea type="text" class="layui-textarea" name="desc" placeholder=""></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">字段排序</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="sort" value="0" autocomplete="off" placeholder="字段排序">
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
         var product_id = window.parent.product_id;
         //  获取区域列表
        ajaxLoad = layer.load(1, {
            shade: [0.8, '#393D49']
        });
        // 缓存字段类型列表,用来判断长度
        var field_type_list;
        var field_type_length = 0;
        $.ajax({ 
            type: "GET",
            url: '{{url("api/admin/field_type/all")}}',
            success: function(result){
                layer.close(ajaxLoad);
                if (result.code > 0) {
                    layer.msg(result.msg);
                } else {
                    field_type_list = result.data;
                    var html='<option value="">请选择字段类型</option>';
                    $.each(result.data,function(key,value){
                        html+="<option value='"+value.id+"'>"+value.name+"|max-length:"+value.field_type_length+"</option>";
                    })
                    $('select[name=field_type_id]').html(html);
                    form.render("select");
                }
            }
        });
        form.on('select(field_type_id)', function(data){
            $.each(field_type_list,function(key,value){
                $('input[name=field_type_length]').val(value.field_type_length);
            });
        });      
         //监听提交
         form.on('submit(formSubmit)', function(data) {
             formLoad = layer.load(1, {
                 shade: [0.8, '#393D49']
             });
             $.ajax({ 
                type: "POST",
                url: '{{url("api/admin/product/product_field")}}',
                data: {
                    'product_id': product_id,
                    'name': data.field.name,
                    'field': data.field.field,
                    'field_type_id': data.field.field_type_id,
                    'field_type_length': data.field.field_type_length,
                    'default': data.field.default,
                    'common_field': data.field.common_field,
                    'common_field_sort': data.field.common_field_sort,
                    'desc': data.field.desc,
                    'sort': data.field.sort,
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