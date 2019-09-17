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
                    <input type="text" class="layui-input" name="title" lay-verify="required" autocomplete="off" placeholder="登陆通知名称" disabled>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">通知类型</label>
                <div class="layui-input-inline">
                    <select id="type" name="type" lay-verify="required" lay-filter="type" disabled>
                        <option value="0">天气预警</option>
                        <option value="1">病虫害预警</option>
                        <option value="2">设备预警</option>
                        <option value="3">文章被回复</option>
                    </select>   
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">通知内容</label>
                <div class="layui-input-block">
                    <textarea type="text" class="layui-textarea" id="content" name="content" placeholder="登陆通知内容"></textarea>
                </div>
            </div>
        </form>
    </div>
     @include('admin.public.include_js')
     <script>
        //  获取父页面传过来的值
        var system_msg_info =  window.parent.system_msg_info;
        // 获取通知详情
        ajaxLoad = layer.load(1, {
            shade: [0.8, '#393D49']
        });
        $.ajax({ 
            type: "GET",
            url: '{{url("api/admin/system_msg")}}/' + system_msg_info.id,
            success: function(result){
                layer.close(ajaxLoad);
                if (result.code > 0) {
                    layer.msg(result.msg);
                } else {
                    system_msg = result.data;
                    $("input[name='title']").val(system_msg.title);
                    $("textarea[name='content']").val(system_msg.content);
                    $("select[name='type']").val(system_msg.type);
                    form.render("select");
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
                }
            }
        });

        
     </script>
 </body>

 </html>