    <script src="{{asset('/js/layui-v2.5.4/layui.all.js')}}" charset="utf-8"></script>
    <script src="{{asset('/js/app.js')}}" charset="utf-8"></script>
     <script>
         var $ = layui.jquery,
            layer = layui.layer,
            form = layui.form,
            table = layui.table,
            element = layui.element; 
         $.ajaxSetup({
            headers:{
                  Authorization:layui.data('user_info').token, 
            }
         });
     </script>