 <!DOCTYPE html>
 <html>

 <head>
     @include('admin.public.include_head')
 </head>

 <body>
    <div class="layui-container" style="padding:15px">
        <form class="layui-form layui-form-pane" action="">
        <div class="layui-form-item">
                <label class="layui-form-label">通知标题</label>
                <div class="layui-input-block">
                    <input type="text" class="layui-input" name="title" lay-verify="required" autocomplete="off" placeholder="登陆通知名称">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">通知类型</label>
                <div class="layui-input-inline">
                    <select id="type" name="type" lay-verify="required" lay-filter="type" disabled>
                        <option value="0">每次显示</option>
                        <option value="1">只显示一次</option>
                    </select>   
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">通知内容</label>
                <div class="layui-input-block">
                    <textarea type="text" class="layui-textarea" id="content" name="content" placeholder="登陆通知内容"></textarea>
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
        //  获取父页面传过来的值
        console.log(window.parent.edit_login_notice_info);
        var login_notice_info =  window.parent.edit_login_notice_info;
        //  初始化input
        $("input[name='title']").val(login_notice_info.title);
        $("textarea[name='content']").val(login_notice_info.content);
        $("select[name='type']").val(login_notice_info.type);
        form.render("select");
         //监听提交
         form.on('submit(formSubmit)', function(data) {
            var content = layedit.getContent(layeditNode);
             if(typeof content == "undefined" || content == null || content == ""){
                 return layer.alert("请输入通知内容");
             }
             formLoad = layer.load(1, {
                 shade: [0.8, '#393D49']
             });
             $.ajax({ 
                type: "POST",
                url: '{{url("api/admin/login_notice")}}/' + login_notice_info.id,
                data: {
                    '_method': 'PUT',
                    'title': data.field.title,
                    'content': content,
                    // 'type': data.field.type,
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