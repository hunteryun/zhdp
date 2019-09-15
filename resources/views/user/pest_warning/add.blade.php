 <!DOCTYPE html>
 <html>

 <head>
     @include('user.public.include_head')
 </head>

 <body>
    <div class="layui-container" style="padding:15px">
        <form class="layui-form layui-form-pane" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">预警标题</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="title" lay-verify="required" autocomplete="off" placeholder="预警标题">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">预警类型</label>
                <div class="layui-input-inline">
                    <select id="type" name="type" lay-verify="required" lay-filter="type">
                        <option value="0">病虫害预警</option>
                        <option value="1">天气预警</option>
                    </select>   
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">开始时间</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" id="start_time" name="start_time" autocomplete="off" placeholder="开始时间(选填)">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">结束时间</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" id="end_time" name="end_time" autocomplete="off" placeholder="结束时间(选填)">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">预警信息</label>
                <div class="layui-input-block">
                    <textarea type="text" class="layui-textarea" name="warning" placeholder="预警信息"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">防止措施</label>
                <div class="layui-input-block">
                    <textarea type="text" class="layui-textarea" name="content" placeholder="防止措施"></textarea>
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
     @include('user.public.include_js')
     <script>
           var laydate = layui.laydate;
            laydate.render({
                elem: '#start_time' 
                ,type: 'datetime'
                ,calendar: true
            });
            laydate.render({
                elem: '#end_time' 
                ,type: 'datetime'
                ,calendar: true
            });
            
         //监听提交
         form.on('submit(formSubmit)', function(data) {
             formLoad = layer.load(1, {
                 shade: [0.8, '#393D49']
             });
             $.ajax({ 
                type: "POST",
                url: '{{url("api/user/pest_warning")}}',
                data: {
                    'title': data.field.title,
                    'type': data.field.type,
                    'start_time': data.field.start_time,
                    'end_time': data.field.end_time,
                    'warning': data.field.warning,
                    'content': data.field.content,
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