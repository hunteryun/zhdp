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
                            <button type="button" class="layui-btn layui-btn-sm" id="refresh-crop-traceability">刷新表格</button> 
                        </div>
                    </div>
                </div>
            </form>
            <div class="layui-row">
                <script type="text/html" id="bar">
                    <a class="layui-btn layui-btn-xs" lay-event="qualified">审核合格</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="failed">审核不合格</a>
                </script>
                <table lay-size="sm" id="pending_review" lay-filter="pending_review"></table>
            </div>
         </div>
     </div>
     @include('admin.public.include_js')
     <script>
            table.render({
                elem: '#pending_review'
                ,url: '{{url('api/admin/crop_traceability/crop_traceability_batch/pending_review')}}' 
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
                    ,{fixed: 'right', title:'操作', toolbar: '#bar', width:200}
                ]]
            });
            table.on('tool(pending_review)', function(obj){
                var data = obj.data;
                if(obj.event === 'qualified'){
                    ajaxLoad = layer.load(1, {
                        shade: [0.8, '#393D49']
                    });
                    layer.confirm('确定通过？', function(index){
                        $.ajax({ 
                            type: "POST",
                            url: '{{url("api/admin/crop_traceability/crop_traceability_batch/review")}}/'+ data.id,
                            data: {
                                '_method': 'PUT',
                                'sampling_status': '1',
                            },
                            success: function(result){
                                layer.msg(result.msg);
                                if (result.code == 0) {
                                    table.reload('pending_review');
                                }
                            }
                        });
                        layer.close(index);
                    });
                    layer.close(ajaxLoad);
                } else if(obj.event === 'failed'){
                    ajaxLoad = layer.load(1, {
                        shade: [0.8, '#393D49']
                    });
                    layer.confirm('确定驳回？', function(index){
                        $.ajax({ 
                            type: "POST",
                            url: '{{url("api/admin/crop_traceability/crop_traceability_batch/review")}}/'+ data.id,
                            data: {
                                '_method': 'PUT',
                                'sampling_status': '2',
                            },
                            success: function(result){
                                layer.msg(result.msg);
                                if (result.code == 0) {
                                    table.reload('pending_review');
                                }
                            }
                        });
                        layer.close(index);
                    });
                    layer.close(ajaxLoad);
                }else if(obj.event === 'showQrCode'){
                    layer.msg('<img style="width: 200px;height: 200px" src="'+data.qr_code_path+'">',{
                        title:'追溯二维码',
                        type : 1,
                        shade: [0.8, '#393D49'],
                        closeBtn: 1,
                        time: 0
                    });
                }
            });
            // 刷新页面
            $('#refresh-page').click(function(){
                window.location.reload();
            });
            // 刷新列表
            $('#refresh-crop-traceability').click(function(){
                table.reload('pending_review');
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