<!DOCTYPE html>
 <html>

 <head>
     @include('user.public.include_head')
 </head>

 <body class="layui-layout-body" style="padding: 20px; background-color: #F2F2F2;overflow-y: scroll;">

     <div class="layui-card">
        <div class="layui-card-header">设备列表</div>
         <div class="layui-card-body">
            <div class="layui-row">
                <table lay-size="sm" id="device" lay-filter="device"></table>
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
         var device_room_id = window.parent.device_room_info.id;
            table.render({
                elem: '#device'
                ,url: '{{url('api/user/device/all')}}?device_room_id='+device_room_id
                ,page: false 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'name', title: '设备名称'}
                    ,{field: 'token', title: 'TOKEN'}
                    ,{field: 'desc', title: '设备描述'}
                ]]
            });
     </script>
 </body>

 </html>