<!DOCTYPE html>
 <html>

 <head>
     @include('user.public.include_head')
 </head>

 <body style="background-color: #F2F2F2;overflow-y: scroll;">
    <div style="padding: 20px; background-color: #F2F2F2;">
        <blockquote class="layui-elem-quote">云蛙：二维码追溯信息详情</blockquote>
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-header">作物信息</div>
                    <div class="layui-card-body">
                        <p>作物位置：<span id="device_region_name"></span></p>
                        <p>大棚名称：<span id="device_room_name"></span></p>
                        <p>作物种类：<span id="crop_class_name"></span></p>
                        <p>作物品种：<span id="crop_variety"></span></p>
                        <p>种植数量：<span id="number_of_plants"></span></p>
                        <p>种植时间：<span id="start_time"></span></p>
                        <p>种植状态：<span id="status"></span></p>
                    </div>
                </div>
            </div>
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-header">批次信息</div>
                    <div class="layui-card-body">
                        <p>收获批次：<span id="batch"></span></p>
                        <p>收获数量：<span id="harvest_quantity"></span></p>
                        <p>收获时间：<span id="end_time"></span></p>
                        <p>抽检状态：<span id="sampling_status"></span></p>
                        <p>追溯二维码：<span id="qr_code_path"></span></p>
                    </div>
                </div>
            </div>
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-header">作物追溯事件日志</div>
                    <div class="layui-card-body">
                        <div class="layui-row">
                            <table lay-size="sm" id="crop_traceability_event_log" lay-filter="crop_traceability_event_log"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
     @include('user.public.include_js')
     <script>
          table.render({
            elem: '#crop_traceability_event_log'
            ,page: false 
            ,cols: [[ 
                ,{field: 'event_name', title: '事件名'}
                ,{field: 'event_content', title: '事件详情'}
                ,{field: 'event_time', title: '时间'}
            ]]
        });
        //  测试url
        //  http://code9.com:8080/user/crop_traceability/qrcode_info?token=shxDJGJ2zeg53oGqFHnxHMbimrOKr5h5Lran1Tn5T2n50PzPfoqAXsV9HpUo
        //  获取token
         function GetQueryString(name)
        {
            var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if(r!=null)return  unescape(r[2]); return null;
        }
        var token = GetQueryString("token");
        ajaxLoad1 = layer.load(1, {
            shade: [0.8, '#393D49']
        });
        $.ajax({ 
            type: "GET",
            url: '{{url("api/user/crop_traceability/qr_code_crop_traceability_info")}}/' + token,
            success: function(result){
                layer.close(ajaxLoad1);
                if (result.code > 0) {
                    layer.msg(result.msg);
                } 
                var data = result.data;
                // 渲染
                console.log(data.cropTraceability.device_room.device_region.name);
                $('#device_region_name').text(data.cropTraceability.device_room.device_region.name);
                $('#device_room_name').text(data.cropTraceability.device_room.name);
                $('#crop_class_name').text(data.cropTraceability.crop_class.name);
                $('#crop_variety').text(data.cropTraceability.crop_variety);
                $('#number_of_plants').text(data.cropTraceability.number_of_plants);
                $('#start_time').text(data.cropTraceability.start_time);
                switch(data.cropTraceability.status){
                    case '0':
                        $('#status').text("进行中");
                        break;
                    case '1':
                        $('#status').text("种植结束");
                        break;
                }
                $('#batch').text(data.crop_traceability.batch);
                $('#harvest_quantity').text(data.crop_traceability.harvest_quantity);
                $('#end_time').text(data.crop_traceability.end_time);
                // $('#sampling_status').text(data.crop_traceability.sampling_status);
                switch(data.crop_traceability.sampling_status){
                    case '0':
                        $('#sampling_status').text("未审核");
                        break;
                    case '1':
                        $('#sampling_status').text("审核通过");
                        break;
                    case '2':
                        $('#sampling_status').text("审核未通过");
                        break;
                }
                $('#qr_code_path').html('<img style="height:150px" src="'+data.crop_traceability.qr_code_path+'">');
                table.reload('crop_traceability_event_log', {
                    data: data.cropTraceabilityEventLog
                });
            }
        });
     </script>
 </body>

 </html>