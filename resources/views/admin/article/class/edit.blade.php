 <!DOCTYPE html>
 <html>

 <head>
     @include('admin.public.include_head')
 </head>

 <body>
    <div class="layui-container" style="padding:15px">
        <form class="layui-form layui-form-pane" action="">
        <div class="layui-form-item">
                <label class="layui-form-label">分类名称</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="name" lay-verify="required" autocomplete="off" placeholder="文章分类名称">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">描述</label>
                <div class="layui-input-inline">
                    <textarea type="text" class="layui-textarea" name="desc" placeholder="描述"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">分类排序</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="sort" value="0" lay-verify="required" autocomplete="off" placeholder="分类排序">
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
        var article_class_info =  window.parent.edit_article_class_info;
        //  初始化input
        $("input[name='name']").val(article_class_info.name);
        $("textarea[name='desc']").val(article_class_info.desc);
        $("input[name='sort']").val(article_class_info.sort);
         //监听提交
         form.on('submit(formSubmit)', function(data) {
             formLoad = layer.load(1, {
                 shade: [0.8, '#393D49']
             });
             $.ajax({ 
                type: "POST",
                url: '{{url("api/admin/article_class")}}/' + article_class_info.id,
                data: {
                    '_method': 'PUT',
                    'name': data.field.name,
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