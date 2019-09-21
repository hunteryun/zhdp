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

        $(function(){ 
            table.reload('crop_traceability_batch', {
                url: '{{url("api/user/crop_traceability/token_crop_traceability_batch")}}/' + token
            });
            table.reload('crop_traceability_event_log', {
                url: '{{url("api/user/crop_traceability/token_crop_traceability_event_log")}}/' + token
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
                ,{field: 'qr_code_path', title: '二维码(点击大图)', templet : function (d){
                    if(d.qr_code_path.length > 0){
                        return '<img style="width: auto;" src="'+d.qr_code_path+'">';
                    }else{
                        return "";
                    }
                }, event : 'showQrCode'}
            ]]
        });
        //监听工具条 
        table.on('tool(crop_traceability_batch)', function(obj){ //注：tool 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
            var data = obj.data; //获得当前行数据
            var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
            var tr = obj.tr; //获得当前行 tr 的 DOM 对象（如果有的话）
            layer.msg('<img style="width: 200px;height: 200px" src="'+data.qr_code_path+'">',{
                title:'作物追溯二维码',
                type : 1,
                shade: [0.8, '#393D49'],
                closeBtn: 1,
                time: 0
            });
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