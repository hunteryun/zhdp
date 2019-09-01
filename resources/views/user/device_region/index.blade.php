 <!DOCTYPE html>
 <html>

 <head>
     @include('user.public.include_head')
 </head>

 <body class="layui-layout-body">
     <div class="layui-card">
         <div class="layui-card-body">
             <table class="layui-table" lay-data="{height:315, url:'{{url('api/device_region')}}', page:true, id:'device_region'}" lay-filter="device_region">
                 <thead>
                     <tr>
                         <th lay-data="{field:'id', width:80, sort: true}">ID</th>
                         <th lay-data="{field:'username', width:80}">用户名</th>
                         <th lay-data="{field:'sex', width:80, sort: true}">性别</th>
                         <th lay-data="{field:'city'}">城市</th>
                         <th lay-data="{field:'sign'}">签名</th>
                         <th lay-data="{field:'experience', sort: true}">积分</th>
                         <th lay-data="{field:'score', sort: true}">评分</th>
                         <th lay-data="{field:'classify'}">职业</th>
                         <th lay-data="{field:'wealth', sort: true}">财富</th>
                     </tr>
                 </thead>
             </table>
         </div>
     </div>
     @include('user.public.include_js')
 </body>

 </html>