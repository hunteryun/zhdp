 <!DOCTYPE html>
 <html>

 <head>
     @include('admin.public.include_head')
 </head>

 <body>
    <div class="layui-container" style="padding:15px">
        <form class="layui-form layui-form-pane" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">文章分类</label>
                <div class="layui-input-inline">
                    <select id="article_class_id" name="article_class_id" lay-verify="required">
                        <option value="">加载分类中...</option>
                    </select>     
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">作物种类</label>
                <div class="layui-input-inline">
                    <select id="crop_class_parent_id" name="crop_class_parent_id" lay-verify="required" lay-filter="crop_class_parent_id">
                        <option value="">作物种类加载中...</option>
                    </select>     
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">作物名称</label>
                <div class="layui-input-inline">
                    <select id="crop_class_id" name="crop_class_id" lay-verify="required">
                        <option value="">请选择作物种类</option>
                    </select>     
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">文章标题</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="title" lay-verify="required" autocomplete="off" placeholder="文章标题">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">文章内容</label>
                <div class="layui-input-block">
                    <textarea type="text" class="layui-textarea" id="content" name="content" placeholder="文章内容"></textarea>
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
         //  获取文章分类列表
        ajaxLoad2 = layer.load(1, {
            shade: [0.8, '#393D49']
        });
        $.ajax({ 
            type: "GET",
            url: '{{url("api/admin/article_class/all")}}',
            success: function(result){
                layer.close(ajaxLoad2);
                if (result.code > 0) {
                    layer.msg(result.msg);
                } else {
                    var html='<option value="">请选择文章分类</option>';
                    $.each(result.data,function(key,value){
                        html+="<option value='"+value.id+"'>"+value.name+"</option>";
                    })
                    $('select[name=article_class_id]').html(html);
                    form.render("select");
                }
            }
        });
        //  获取顶级种植作物列表
        ajaxLoad1 = layer.load(1, {
            shade: [0.8, '#393D49']
        });
        $.ajax({ 
            type: "GET",
            url: '{{url("api/admin/crop_class/top")}}',
            success: function(result){
                layer.close(ajaxLoad1);
                if (result.code > 0) {
                    layer.msg(result.msg);
                } else {
                    var html='<option value="">请选择种植作物</option>';
                    $.each(result.data,function(key,value){
                        html+="<option value='"+value.id+"'>"+value.name+"</option>";
                    })
                    $('select[name=crop_class_parent_id]').html(html);
                    form.render("select");
                }
            }
        });
        // 获取分类下的种植作物
        form.on('select(crop_class_parent_id)', function(data){
            //  获取种植种类列表
            ajaxLoad2 = layer.load(1, {
                shade: [0.8, '#393D49']
            });
            $.ajax({ 
                type: "GET",
                url: '{{url("api/admin/crop_class/top")}}/' + data.value,
                success: function(result){
                    layer.close(ajaxLoad2);
                    if (result.code > 0) {
                        layer.msg(result.msg);
                    } else {
                        var html='<option value="">请选择种植作物</option>';
                        $.each(result.data,function(key,value){
                            html+="<option value='"+value.id+"'>"+value.name+"</option>";
                        })
                        $('select[name=crop_class_id]').html(html);
                        form.render("select");
                    }
                }
            });
        });   
        // 初始化编辑器
        var layedit = layui.layedit;
        var layeditNode = layedit.build('content',{
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
            ]
        }); 
         //监听提交
         form.on('submit(formSubmit)', function(data) {
             var content = layedit.getContent(layeditNode);
             if(typeof content == "undefined" || content == null || content == ""){
                 return layer.alert("请输入文章正文");
             }
             formLoad = layer.load(1, {
                 shade: [0.8, '#393D49']
             });
             $.ajax({ 
                type: "POST",
                url: '{{url("api/admin/article")}}',
                data: {
                    'article_class_id': data.field.article_class_id,
                    'crop_class_id': data.field.crop_class_id,
                    'title': data.field.title,
                    'content': content,
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