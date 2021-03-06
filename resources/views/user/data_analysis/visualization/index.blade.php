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
                        <select name="device_region_id" id="device_region_id" lay-search lay-filter="device_region_id">
                            <option value="" selected>区域:加载中...</option>
                        </select>
                    </div>
                    <div class="layui-inline">
                        <select name="device_room_id" id="device_room_id" lay-search lay-filter="device_room_id">
                            <option value="" selected>房间:请先选择区域.</option>
                        </select>
                    </div>
                    <div class="layui-inline">
                        <select name="id" id="id" lay-search lay-filter="id">
                            <option value="" selected>设备:请先选择房间</option>
                        </select>
                    </div>
                    <div class="layui-inline">
                        <select name="product_id" id="product_id" lay-search>
                            <option value="" selected>产品类型:加载中...</option>
                        </select>
                    </div>
                    <div class="layui-inline">
                        <select name="time" id="time" lay-search>
                            <option value="0.5" selected>时间:30分钟</option>
                            <option value="1" >时间:1小时</option>
                            <option value="5" >时间:5小时</option>
                            <option value="8" >时间:8小时</option>
                            <option value="12" >时间:12小时</option>
                            <option value="24" >时间:1天</option>
                            <option value="72" >时间:3天</option>
                            <option value="168" >时间:7天</option>
                            <option value="720" >时间:30天</option>
                            <option value="2160" >时间:90天</option>
                            <option value="8760" >时间:365天</option>
                        </select>
                    </div>
                    <div class="layui-inline">
                        <div class="layui-input-inline">
                            <button type="submit" id="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">搜索</button>
                            <button type="button" class="layui-btn" id="refresh-page">刷新</button> 
                        </div>
                    </div>
                </div>
            </form>
            <div style="padding: 20px; background-color: #F2F2F2;">
                <div class="layui-row layui-col-space15" id="layui-html-content">
                    
                </div>
            </div> 
         </div>
     </div>
     @include('user.public.include_js')
     <!-- 引入百度图表 -->
    <script src="{{asset('/js/echarts.min.js')}}" charset="utf-8"></script>
     <script>
            // 刷新页面
            $('#refresh-page').click(function(){
                window.location.reload();
            });
            // 获取作物分类
            ajaxLoad3 = layer.load(1, {
                shade: [0.8, '#393D49']
            });
            $.ajax({ 
                type: "GET",
                url: '{{url("api/user/crop_class/top")}}',
                success: function(result){
                    layer.close(ajaxLoad3);
                    if (result.code > 0) {
                        layer.msg(result.msg);
                    } else {
                        var html='<option value="" selected>作物分类:不限作物</option>';
                        $.each(result.data,function(key,value){
                            html+="<option value='"+value.id+"'>"+value.name+"</option>";
                        })
                        $('select[name=pid]').html(html);
                        form.render("select");
                    }
                }
            });
            //监听搜索
            form.on('submit(formSubmit)', function(data) {
                // 重载 table
                table.reload('crop_class', {
                    where: {
                        'pid': data.field.pid,
                        'name': data.field.name,
                    }
                });
                return false;
            });
            // 获取产品分类
            ajaxLoad6 = layer.load(1, {
                shade: [0.8, '#393D49']
            });
            $.ajax({ 
                type: "GET",
                url: '{{url("api/user/product/all")}}',
                success: function(result){
                    layer.close(ajaxLoad6);
                    if (result.code > 0) {
                        layer.msg(result.msg);
                    } else {
                        var html='<option value="" selected>产品分类:不限产品</option>';
                        $.each(result.data,function(key,value){
                            html+="<option value='"+value.id+"'>"+value.name+"</option>";
                        })
                        $('select[name=product_id]').html(html);
                        form.render("select");
                    }
                }
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
            // 监听区域选择
            form.on('select(device_region_id)', function(data){
                ajaxLoad5 = layer.load(1, {
                    shade: [0.8, '#393D49']
                });
                $.ajax({ 
                    type: "GET",
                    url: '{{url("api/user/device_room/all")}}?device_region_id='+data.value,
                    success: function(result){
                        layer.close(ajaxLoad5);
                        if (result.code > 0) {
                            layer.msg(result.msg);
                        } else {
                            var html='<option value="" selected>房间:不限房间</option>';
                            $.each(result.data,function(key,value){
                                html+="<option value='"+value.id+"'>"+value.name+"</option>";
                            })
                            $('select[name=device_room_id]').html(html);
                            form.render("select");
                        }
                    }
                });
            });   
            // 监听房间选择
            form.on('select(device_room_id)', function(data){
                ajaxLoad5 = layer.load(1, {
                    shade: [0.8, '#393D49']
                });
                $.ajax({ 
                    type: "GET",
                    url: '{{url("api/user/device/all")}}?device_room_id='+data.value,
                    success: function(result){
                        layer.close(ajaxLoad5);
                        if (result.code > 0) {
                            layer.msg(result.msg);
                        } else {
                            var html='<option value="" selected>设备:不限设备</option>';
                            $.each(result.data,function(key,value){
                                html+="<option value='"+value.id+"'>"+value.name+"</option>";
                            })
                            $('select[name=id]').html(html);
                            form.render("select");
                        }
                    }
                });
            });   
            //监听搜索
            form.on('submit(formSubmit)', function(data) {
                if(!data.field.device_region_id || !data.field.device_room_id){
                    layer.msg("请选择条件后进行查找");
                    return false;
                }
                ajaxLoad10 = layer.load(1, {
                    shade: [0.8, '#393D49']
                });
                $.ajax({ 
                    type: "POST",
                    url: '{{url("api/user/data_analysis/visualization")}}',
                    data: {
                        device_region_id: data.field.device_region_id,
                        device_room_id: data.field.device_room_id,
                        id: data.field.id,
                        product_id: data.field.product_id,
                        time: data.field.time,
                    },
                    success: function(result){
                        console.log(result);
                        layer.close(ajaxLoad10);
                        if (result.code > 0) {
                            layer.msg(result.msg);
                        } else {
                            var data = result.data;
                            //拼接数据
                            spliceData(data);
                        }
                    }
                });
                return false;
            });
            function spliceData(data){
                // 渲染 先清空
                $('#layui-html-content').html('');
                for(var i = 0; i < data.length; i++){
                    var option = {};
                    option.title = {
                        text: "设备:" + getName(data[i])
                    };
                    option.tooltip = {
                        trigger: 'axis'
                    };
                    option.grid = {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    };
                    option.legend = {
                        data:getTopFieldName(data[i])
                    };
                    option.xAxis = {
                        type: 'category',
                        data: getDataTime(data[i])
                    };
                    option.yAxis = {
                        type: 'value',
                    };
                    option.series =  getData(data[i]);
                    // // 渲染图表
                    console.log(option);
                    renderingHtml(option);
                }
            }
            // 获取设备名
            function getName(data){
                return data.name;
            }
            // 获取顶部点击按钮(字段名)
            function getTopFieldName(data){
                var data_top_field_name_list = [];
                // 字段数量
                if(data.device_field.length > 0){
                    for(var i = 0; i< data.device_field.length; i++){
                        data_top_field_name_list.push(data.device_field[i].name);
                    }
                }
                return data_top_field_name_list;
            }
            // 获取数据(折线图的数据)
            function getData(data){
                var data_list = [];
                // 字段数量
                if(data.device_field.length > 0){
                    // 循环字段
                    for(var i = 0; i < data.device_field.length; i ++){
                        var device_field = data.device_field[i];
                        if(device_field.device_field_log.length > 0){
                            var device_field_log = device_field.device_field_log;
                            var row = {};
                            row.name = device_field.name; 
                            row.type = 'line'; 
                            row.stack = '总量'; 
                            row.data = [];
                            for(var ii = 0; ii < device_field_log.length; ii ++){
                                row.data.push(device_field_log[ii].value)
                            }
                            data_list.push(row);
                        }
                    }
                }
                console.log(data_list);
                return data_list;
            }
            // 获取底部时间区间[获取第一个的][data=设备row,不是集合]
            function getDataTime(data){
                var data_time_list = [];
                // 字段数量
                if(data.device_field.length > 0){
                    // 日志数量
                    if(data.device_field['0'].device_field_log.length > 0){
                        var device_field_log_list = data.device_field['0'].device_field_log;
                        for(var i = 0; i< device_field_log_list.length; i++){
                            data_time_list.push(device_field_log_list[i].date);
                        }
                    }
                }
                return data_time_list;
            }

            function renderingHtml(option){
                var id = 'main'+rndNum();
                var html = '<div class="layui-col-md6"><div class="layui-card"><div class="layui-card-body"><div id="'+id+'" style="height:400px;"></div></div></div></div>'
                $('#layui-html-content').append(html);
                var myChart = echarts.init(document.getElementById(id));
                myChart.setOption(option);
            }
            // 生成随机id
            function rndNum(n = 8){
                var rnd="";
                for(var i=0;i<n;i++)
                    rnd+=Math.floor(Math.random()*10);
                return rnd;
            }
            // var html = '<div class="layui-col-md6"><div class="layui-card"><div class="layui-card-body"><div id="main" style="height:400px;"></div></div></div></div>'
        // // 基于准备好的dom，初始化echarts实例
        // var myChart = echarts.init(document.getElementById('main'));
        // // 指定图表的配置项和数据
        // var option = {
        //     xAxis: {
        //         type: 'category',
        //         data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
        //     },
        //     yAxis: {
        //         type: 'value'
        //     },
        //     series: [{
        //         data: [820, 932, 901, 934, 1290, 1330, 1320],
        //         type: 'line'
        //     }]
        // };
        // // 使用刚指定的配置项和数据显示图表。
        // myChart.setOption(option);
     </script>
 </body>

 </html>