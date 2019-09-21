<!DOCTYPE html>
 <html>

 <head>
     @include('user.public.include_head')
 </head>

 <body class="layui-layout-body" style="padding: 20px; background-color: #F2F2F2;overflow-y: scroll;">

     <div class="layui-card">
        <div class="layui-card-header">收获批次</div>
         <div class="layui-card-body">
            <div class="layui-row">
                <table lay-size="sm" id="crop_traceability_batch" lay-filter="crop_traceability_batch"></table>
            </div>
         </div>
     </div>
     <div class="layui-card">
        <div class="layui-card-header">事件日志表</div>
         <div class="layui-card-body">
            <div class="layui-row">
                <table lay-size="sm" id="crop_traceability_event_log" lay-filter="crop_traceability_event_log"></table>
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
        var device_room_id = window.parent.edit_crop_traceability_info.device_room_id;
        $(function(){ 
            table.reload('crop_traceability_batch', {
                url: '{{url("api/user/crop_traceability/crop_traceability_batch/all")}}/' + device_room_id
            });
            table.reload('crop_traceability_event_log', {
                url: '{{url("api/user/crop_traceability/crop_traceability_event_log/all")}}/' + device_room_id
            });
    　　}); 
        table.render({
            elem: '#crop_traceability_batch'
            ,page: false 
            ,cols: [[ 
                ,{field: 'batch', title: '收获批次'}
                ,{field: 'harvest_quantity', title: '收获数量'}
                ,{field: 'end_time', title: '收获时间'}
                ,{field: 'sampling_status', title: '抽检状态', templet : function (d){
                    if(d.sampling_status == '0'){
                        return '未抽检';
                    }else if(d.sampling_status == '1'){
                        return '抽检合格';
                    }else if(d.sampling_status == '2'){
                        return '抽检不合格';
                    }
                }}
            ]]
        });
        table.render({
            elem: '#crop_traceability_event_log'
            ,page: false 
            ,cols: [[ 
                ,{field: 'event_name', title: '事件名'}
                ,{field: 'event_content', title: '事件详情'}
                ,{field: 'event_time', title: '时间'}
            ]]
        });
        
     </script>
 </body>

 </html>