 <!DOCTYPE html>
 <html>

 <head>
     @include('user.public.include_head')
 </head>

 <body class="layui-layout-body">


     <div class="layui-tab-content page-tab-content">
         <div class="layui-tab-item layui-show">
             <form class="layui-form layui-form-pane" method="post">
                 <div class="layui-form-item">
                     <label class="layui-form-label">区域名称</label>
                     <div class="layui-input-inline">
                         <input type="text" class="layui-input" name="name" lay-verify="required" autocomplete="off" placeholder="区域名称">
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
     </div>
     @include('user.public.include_js')
     <script>
         var $ = layui.jquery,
             form = layui.form,
             layer = layui.layer;
         //监听提交
         form.on('submit(formSubmit)', function(data) {
             formLoad = layer.load(1, {
                 shade: [0.8, '#393D49']
             });
             $.ajax({ 
                type: "POST",
                url: '{{url("api/user/device_region")}}',
                beforeSend: function(xhr) { 
                    xhr.setRequestHeader("Authorization", layui.data('user_info').token);  
                },
                data: {
                    'name': data.field.name,
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