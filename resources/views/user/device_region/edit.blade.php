 <!DOCTYPE html>
 <html>

 <head>
     @include('user.public.include_head')
 </head>

 <body>
    <div class="layui-container" style="padding:15px">
        <form class="layui-form layui-form-pane" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">区域名称</label>
                <div class="layui-input-block">
                    <input type="text" class="layui-input" name="name" lay-verify="required" autocomplete="off" placeholder="区域名称" disabled>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">省-市-县</label>
                <div class="layui-inline">
                    <select name="province" id="province" lay-filter="province">
                        <option value="">请选择省</option>
                    </select>
                </div>
                <div class="layui-inline">
                    <select name="city" id="city" lay-filter="city">
                        <option value="">请先选择省</option>
                    </select>
                </div>
                <div class="layui-inline">
                    <select name="area" id="area" lay-filter="area">
                        <option value="">请先选择市</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="submit" id="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">提交</button>
                    <button type="reset" id="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
     @include('user.public.include_js')
    <script src="{{asset('/js/region_data.js')}}" charset="utf-8"></script>
    <script>
        //  获取父页面传过来的值
        var device_region_info =  window.parent.edit_device_region_info;
        //  初始化input
        $("input[name='name']").val(device_region_info.name);
    </script>
    <script>
        var Province = $("#province"), City = $("#city"), Area = $("#area");
        // 初始化
        (function(){
            // 设置省
            getProvince(function(data){
                var html = "";
                data.forEach(function(index){
                    if(index.provinceCode == device_region_info.province){
                        html += "<option value='"+index.provinceCode+"' selected>"+index.provinceName+"</option>";
                    }else{
                        html += "<option value='"+index.provinceCode+"'>"+index.provinceName+"</option>";
                    }
                });
                Province.html(html);
            });
            // 设置市
            getCity(device_region_info.province, function(data){
                var html = "";
                data.forEach(function(index){
                    if(index.cityCode == device_region_info.city){
                        html += "<option value='"+index.cityCode+"' selected>"+index.cityName+"</option>";
                    }else{
                        html += "<option value='"+index.cityCode+"'>"+index.cityName+"</option>";
                    }
                });
                City.html(html);
            });
            // 设置县
            getArea(device_region_info.province, device_region_info.city, function(data){
                var html = "";
                data.forEach(function(index){
                    if(index.areaCode == device_region_info.area){
                        html += "<option value='"+index.areaCode+"' selected>"+index.areaName+"</option>";
                    }else{
                        html += "<option value='"+index.areaCode+"'>"+index.areaName+"</option>";
                    }
                });
                Area.html(html);
            });
            updateName();
            form.render('select');
        })()
        // 监听省切换
        form.on('select(province)', function(data){
            cityLinkage(data.value);
            updateName();
            form.render('select');
        });
        // 监听市切换
        form.on('select(city)', function(data){
            areaLinkage(Province.val(), data.value);
            updateName();
            form.render('select');
        });
        // 监听县切换
        form.on('select(area)', function(){
            updateName();
        });
        // 市联动
        function cityLinkage(provinceCode){
            getCity(provinceCode, function(data){
                var cityHtml = "";
                data.forEach(function(index){
                    cityHtml += "<option value='"+index.cityCode+"'>"+index.cityName+"</option>";
                });
                City.html(cityHtml);
                var cityCode = data[0].cityCode;
                // 县联动
                areaLinkage(provinceCode, cityCode);
            });
        }
        // 县联动
        function areaLinkage(provinceCode, cityCode){
            getArea(provinceCode, cityCode, function(data){
                var areaHtml = "";
                data.forEach(function(index){
                    areaHtml += "<option value='"+index.areaCode+"'>"+index.areaName+"</option>";
                });
                Area.html(areaHtml);
            });
        }
        // 更新text
        function updateName(){
            $("input[name='name']").val(
                $("#province").find("option:selected").text() +"-"+
                $("#city").find("option:selected").text() +"-"+
                $("#area").find("option:selected").text()
            );
        }
        // 获取省
        // fun 回调函数
        function getProvince(callback){
            var province = [];
            region.forEach(function(index){
                var row = {};
                row.provinceCode = index.provinceCode;
                row.provinceName = index.provinceName;
                province.push(row);
            });
            // 如果有回调函数
            if(typeof callback === "function"){
                callback(province);
            }
        }
        // 获取市
        // code 省代码
        // fun 回调函数
        function getCity(code, callback){
            var city = [];
            region.forEach(function(index){
                if(index.provinceCode == code){
                    var province = index.mallCityList;
                    province.forEach(function(child){
                        var row = {};
                        row.cityCode = child.cityCode;
                        row.cityName = child.cityName;
                        city.push(row);
                    });
                }
            });
            // 如果有回调函数
            if(typeof callback === "function"){
                callback(city);
            }
        }
        // 获取县
        // provinceCode 省代码
        // cityCode 市代码
        // fun 回调函数
        function getArea(provinceCode, cityCode, callback){
            var area = [];
            region.forEach(function(index){
                if(index.provinceCode == provinceCode){
                    var province = index.mallCityList;
                    province.forEach(function(child){
                        if(child.cityCode == cityCode){
                            var city = child.mallAreaList;
                            city.forEach(function(sun){
                                var row = {};
                                row.areaCode = sun.areaCode;
                                row.areaName = sun.areaName;
                                area.push(row);                           
                            });
                        }
                    });
                }
            });
            // 如果有回调函数
            if(typeof callback === "function"){
                callback(area);
            }
        }
    </script>
     <script>
         //监听提交
         form.on('submit(formSubmit)', function(data) {
             formLoad = layer.load(1, {
                 shade: [0.8, '#393D49']
             });
             $.ajax({ 
                type: "PUT",
                url: '{{url("api/user/device_region")}}/' + device_region_info.id,
                data: {
                    'name': data.field.name,
                    'province': data.field.province,
                    'city': data.field.city,
                    'area': data.field.area,
                },
                success: function(result){
                    layer.close(formLoad);
                    if (result.code > 0) {
                        layer.msg(result.msg);
                    } else {
                        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                        parent.layer.close(index); //再执行关闭   
                    }
                }
            });
             return false;
         });
     </script>
 </body>

 </html>