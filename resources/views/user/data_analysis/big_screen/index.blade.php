 <!DOCTYPE html>
 <html>

 <head>
     @include('user.public.include_head')
 </head>

 <body>
        <div class="layui-fluid" style="background-color: #F2F2F2;">
            <div class="layui-row layui-col-space15" id="layui-html-content">
                <!-- 设备数量分布(圆形图) -->
                <!-- 本周请求次数(周一到周日)(柱状图一周显示)) -->
                <!-- 设备事件(24小时)(折线图显示)) -->
                <!-- 设备事件分类(圆形图)) -->
                <div class="layui-col-md6">
                    <div class="layui-card">
                        <div class="layui-card-header">设备数量分布</div>
                        <div class="layui-card-body">
                            <div id="device" style="height:350px;"></div>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md6">
                    <div class="layui-card">
                        <div class="layui-card-header">本周请求次数</div>
                        <div class="layui-card-body">
                            <div id="request" style="height:350px;"></div>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md6">
                    <div class="layui-card">
                        <div class="layui-card-header">设备事件</div>
                        <div class="layui-card-body">
                            <div id="event_24" style="height:350px;"></div>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md6">
                    <div class="layui-card">
                        <div class="layui-card-header">设备事件分类</div>
                        <div class="layui-card-body">
                            <div id="event_24_class" style="height:350px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
     @include('user.public.include_js')
     <!-- 引入百度图表 -->
    <script src="{{asset('/js/echarts.min.js')}}" charset="utf-8"></script>
     <script>
        // 加载
        ajaxLoad2 = layer.load(1, {
            shade: [0.8, '#393D49']
        });
        $.ajax({ 
            type: "POST",
            url: "{{url('api/user/data_analysis/big_screen')}}",
            success: function(result){
                layer.close(ajaxLoad2);
                var data = result.data;
                device(data.deviceRegion);
                request(data.deviceFieldLogDayList);
                event_24(data.deviceEventLogList);
                event_24_class(data.deviceEventLogClassList);
            }
        });
        function device(data){
            title = [];
            list = [];
            for(var i in data){
                title.push(data[i].name);
                var row = {};
                    row.name = data[i].name,
                    row.value = data[i].device_num,
                    list.push(row);
            }
             // 基于准备好的dom，初始化echarts实例
            var myChart = echarts.init(document.getElementById('device'));
            // 指定图表的配置项和数据
            var option = {
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b}: {c} ({d}%)"
                },
                legend: {
                    orient: 'vertical',
                    x: 'left',
                    data:title
                },
                series: [
                    {
                        name:'访问来源',
                        type:'pie',
                        radius: ['50%', '70%'],
                        avoidLabelOverlap: false,
                        label: {
                            normal: {
                                show: false,
                                position: 'center'
                            },
                            emphasis: {
                                show: true,
                                textStyle: {
                                    fontSize: '30',
                                    fontWeight: 'bold'
                                }
                            }
                        },
                        labelLine: {
                            normal: {
                                show: false
                            }
                        },
                        data:list
                    }
                ]
            };

            // 使用刚指定的配置项和数据显示图表。
            myChart.setOption(option);
        }
        function request(data){
            title = [];
            value = [];
            for(var i in data){
                title.push(data[i].date);
                value.push(data[i].num);
            }
            // 基于准备好的dom，初始化echarts实例
            var myChart = echarts.init(document.getElementById('request'));
            // 指定图表的配置项和数据
            var option = option = {
                legend: {},
                tooltip: {},
                xAxis: {
                    type: 'category',
                    data: title
                },
                yAxis: {
                    type: 'value'
                },
                series: [{
                    data: value,
                    type: 'bar'
                }]
            };
            // 使用刚指定的配置项和数据显示图表。
            myChart.setOption(option);
        }
        function event_24(data){
            title = [];
            value = [];
            for(var i in data){
                title.push(data[i].date);
                value.push(data[i].num);
            }
            // 基于准备好的dom，初始化echarts实例
            var myChart = echarts.init(document.getElementById('event_24'));
            // 指定图表的配置项和数据
            var option = {
                legend: {},
                tooltip: {},
                xAxis: {
                    type: 'category',
                    data: title
                },
                yAxis: {
                    type: 'value'
                },
                series: [{
                    data: value,
                    type: 'line'
                }]
            };
            // 使用刚指定的配置项和数据显示图表。
            myChart.setOption(option);
        }
        function event_24_class(data){
            title = [];
            value = [];
            for(var i in data){
                if(data[i].type == 0){
                    data[i].type = "低于阈值";
                }
                if(data[i].type == 1){
                    data[i].type =  "等于阈值";
                }
                if(data[i].type == 2){
                    data[i].type =  "高于阈值";
                }
                // 
                title.push(data[i].type);
                var row = {};
                    row.value = data[i].num;
                    row.name = data[i].type;
                value.push(row);
            }
           // 基于准备好的dom，初始化echarts实例
         var myChart = echarts.init(document.getElementById('event_24_class'));
            // 指定图表的配置项和数据
            option = {
                title : {
                    x:'center'
                },
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    orient: 'vertical',
                    left: 'left',
                    data: title
                },
                series : [
                    {
                        name: '请求类型',
                        type: 'pie',
                        radius : '55%',
                        center: ['50%', '60%'],
                        data:value,
                        itemStyle: {
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }
                ]
            };  
            // 使用刚指定的配置项和数据显示图表。
            myChart.setOption(option);
        }
       
     </script>
 </body>

 </html>