 <!DOCTYPE html>
 <html>

 <head>
     @include('user.public.include_head')
 </head>

 <body>
     <div class="layui-card">
         <div class="layui-card-body">
            <form class="layui-form">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <div class="layui-btn-container">
                            <button type="button" class="layui-btn layui-btn-sm" id="refresh-page">刷新页面</button> 
                            <button type="button" class="layui-btn layui-btn-sm" id="refresh-crop-traceability">刷新表格</button> 
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <select name="device_region_id" id="device_region_id" lay-search lay-filter="device_region_id">
                            <option value="" selected>区域:加载中...</option>
                        </select>
                    </div>
                    <div class="layui-inline">
                        <div class="layui-input-inline">
                        <button type="submit" id="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">搜索</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="layui-row">
                <table lay-size="sm" id="pending_review" lay-filter="pending_review"></table>
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
            table.render({
                elem: '#pending_review'
                ,url: '{{url('api/user/crop_traceability/crop_traceability_batch/pending_review')}}' 
                ,page: true 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'device_room.name', title: '房间', templet : function (d){
                        return d.crop_traceability.device_room.name;
                    }}
                    ,{field: 'crop_class.name', title: '作物', templet : function (d){
                        return d.crop_traceability.crop_class.name;
                    }}
                    ,{field: 'crop_variety', title: '作物品种', templet : function (d){
                        return d.crop_traceability.crop_variety;
                    }}
                    ,{field: 'end_time', title: '收获时间', templet : function (d){
                        return d.end_time;
                    }}
                    ,{field: 'harvest_quantity', title: '收获数量', templet : function (d){
                        return d.harvest_quantity;
                    }}
                    ,{field: 'batch', title: '收获批次', templet : function (d){
                        return d.batch;
                    }}
                    ,{field: 'sampling_status', title: '审核状态', templet : function (d){
                        if(d.sampling_status == '0'){
                            return '待审核';
                        }else if(d.sampling_status == '1'){
                            return '审核合格';
                        }else if(d.sampling_status == '2'){
                            return '审核未通过';
                        }
                    }}
                    ,{field: 'qr_code_path', title: '追溯二维码', templet : function (d){
                        return d.qr_code_path.length > 0 ?'<img style="height:20px;" src="'+d.qr_code_path+'">' : '';
                    }, event : 'showQrCode'}
                ]]
            });
            // 刷新页面
            $('#refresh-page').click(function(){
                window.location.reload();
            });
            // 刷新列表
            $('#refresh-crop-traceability').click(function(){
                table.reload('pending_review');
            });
            // 获取区域分类
            ajaxLoad3 = layer.load(1, {
                shade: [0.8, '#393D49']
            });
            $.ajax({ 
                type: "GET",
                url: '{{url("api/user/device_region/all")}}',
                success: function(result){
                    layer.close(ajaxLoad3);
                    if (result.code > 0) {
                        layer.msg(result.msg);
                    } else {
                        var html='<option value="" selected>区域分类:不限区域</option>';
                        $.each(result.data,function(key,value){
                            html+="<option value='"+value.id+"'>"+value.name+"</option>";
                        })
                        $('select[name=device_region_id]').html(html);
                        form.render("select");
                    }
                }
            });
            //监听工具条 
            table.on('tool(pending_review)', function(obj){ //注：tool 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
                var data = obj.data; //获得当前行数据
                var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
                var tr = obj.tr; //获得当前行 tr 的 DOM 对象（如果有的话）
                if(layEvent == 'showQrCode'){
                    layer.msg('<img style="width: 200px;height: 200px" src="'+data.qr_code_path+'">',{
                        title:'追溯二维码',
                        type : 1,
                        shade: [0.8, '#393D49'],
                        closeBtn: 1,
                        time: 0
                    });
                }
            });
            //监听搜索
            form.on('submit(formSubmit)', function(data) {
                // 重载 table
                table.reload('pending_review',{
                    where: {
                        'device_region_id': data.field.device_region_id,
                    }
                });
                return false;
            });
     </script>
 </body>

 </html>