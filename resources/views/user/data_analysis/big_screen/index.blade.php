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
         // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('device'));
        // 指定图表的配置项和数据
        var option = {
            backgroundColor: '#2c343c',

            title: {
                text: 'Customized Pie',
                left: 'center',
                top: 20,
                textStyle: {
                    color: '#ccc'
                }
            },

            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },

            visualMap: {
                show: false,
                min: 80,
                max: 600,
                inRange: {
                    colorLightness: [0, 1]
                }
            },
            series : [
                {
                    name:'访问来源',
                    type:'pie',
                    radius : '55%',
                    center: ['50%', '50%'],
                    data:[
                        {value:335, name:'直接访问'},
                        {value:310, name:'邮件营销'},
                        {value:274, name:'联盟广告'},
                        {value:235, name:'视频广告'},
                        {value:400, name:'搜索引擎'}
                    ].sort(function (a, b) { return a.value - b.value; }),
                    roseType: 'radius',
                    label: {
                        normal: {
                            textStyle: {
                                color: 'rgba(255, 255, 255, 0.3)'
                            }
                        }
                    },
                    labelLine: {
                        normal: {
                            lineStyle: {
                                color: 'rgba(255, 255, 255, 0.3)'
                            },
                            smooth: 0.2,
                            length: 10,
                            length2: 20
                        }
                    },
                    itemStyle: {
                        normal: {
                            color: '#c23531',
                            shadowBlur: 200,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    },

                    animationType: 'scale',
                    animationEasing: 'elasticOut',
                    animationDelay: function (idx) {
                        return Math.random() * 200;
                    }
                }
            ]
        };
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
         // 基于准备好的dom，初始化echarts实例
         var myChart = echarts.init(document.getElementById('request'));
        // 指定图表的配置项和数据
        var option = option = {
            xAxis: {
                type: 'category',
                data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
            },
            yAxis: {
                type: 'value'
            },
            series: [{
                data: [120, 200, 150, 80, 70, 110, 130],
                type: 'bar'
            }]
        };
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
         // 基于准备好的dom，初始化echarts实例
         var myChart = echarts.init(document.getElementById('event_24'));
        // 指定图表的配置项和数据
        var option = {
            xAxis: {
                type: 'category',
                data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
            },
            yAxis: {
                type: 'value'
            },
            series: [{
                data: [820, 932, 901, 934, 1290, 1330, 1320],
                type: 'line'
            }]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
         // 基于准备好的dom，初始化echarts实例
         var myChart = echarts.init(document.getElementById('event_24_class'));
        // 指定图表的配置项和数据
        option = {
            title : {
                text: '某站点用户访问来源',
                subtext: '纯属虚构',
                x:'center'
            },
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient: 'vertical',
                left: 'left',
                data: ['直接访问','邮件营销','联盟广告','视频广告','搜索引擎']
            },
            series : [
                {
                    name: '访问来源',
                    type: 'pie',
                    radius : '55%',
                    center: ['50%', '60%'],
                    data:[
                        {value:335, name:'直接访问'},
                        {value:310, name:'邮件营销'},
                        {value:234, name:'联盟广告'},
                        {value:135, name:'视频广告'},
                        {value:1548, name:'搜索引擎'}
                    ],
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
     </script>
 </body>

 </html>