<!DOCTYPE html>
<html>

<head>
	@include('public.include_head')
</head>

<body>
	@include('public.top')
	@include('public.menu')

	<div class="layui-container fly-marginTop">
		<div class="fly-panel fly-panel-user" pad20>
			<div class="layui-tab layui-tab-brief" lay-filter="user">
				<ul class="layui-tab-title">
					<li><a href="{{url('user/login')}}">登入</a></li>
					<li class="layui-this">注册</li>
				</ul>
				<div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
					<div class="layui-tab-item layui-show">
						<div class="layui-form layui-form-pane">
							<form method="post">
								<div class="layui-form-item">
									<label class="layui-form-label">昵称</label>
									<div class="layui-input-inline">
										<input type="text" id="name" name="name" required lay-verify="required" autocomplete="off" class="layui-input">
									</div>
								</div>
								<!-- <div class="layui-form-item">
									<label class="layui-form-label">手机号</label>
									<div class="layui-input-inline">
										<input type="text" id="phone" name="phone" required lay-verify="required|phone" autocomplete="off" class="layui-input">
									</div>
								</div> -->
								<div class="layui-form-item">
									<label class="layui-form-label">密码</label>
									<div class="layui-input-inline">
										<input type="password" id="password" name="password" required lay-verify="required" autocomplete="off" class="layui-input">
									</div>
								</div>
								<div class="layui-form-item">
									<button class="layui-btn" lay-filter="formSubmit" lay-submit>立即登录</button>
									<span style="padding-left:20px;">
										<a href="forget.html">忘记密码？</a>
									</span>
								</div>
								<div class="layui-form-item fly-form-app">
									<span>或者使用社交账号登入</span>
									<a href="" onclick="layer.msg('正在通过QQ登入', {icon:16, shade: 0.1, time:0})" class="iconfont icon-qq" title="QQ登入"></a>
									<a href="" onclick="layer.msg('正在通过微博登入', {icon:16, shade: 0.1, time:0})" class="iconfont icon-weibo" title="微博登入"></a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@include('public.foot')
	@include('public.include_js')
	<script>
		layui.cache.page = 'user';
		layui.cache.user = {
			username: '游客',
			uid: -1,
			avatar: '{{asset("/js/fly-v3.0/res/images/avatar/00.jpg")}}',
			experience: 83,
			sex: '男'
		};
		layui.config({
			open: '@{{',
			close: '}}',
			version: "3.0.0",
			base: '{{asset("/js/fly-v3.0/res/mods/")}}/'
		}).extend({
			fly: 'index'
		}).use('fly');
		// 
		//监听提交
		form.on('submit(formSubmit)', function(formoObj) {
			var field = formoObj.field;
			var formLoad = layer.load(1, {
				shade: [0.8, '#393D49']
			});
			console.log(field);
			$.ajax({ 
				type: "POST",
                url: "{{url('api/user/reg')}}",
				data: {
					name: field.name,
					password: field.password,
				},
				success: function(result){
					layer.close(formLoad);
					layer.msg(result.msg);
					if (result.code == 0) {
						layui.data('user_info', {
							key: 'token',
							value: result.token
						});
						window.location.href = "{{url('user/index')}}";
					}
		    	}
			});
			return false;
		});
	</script>
</body>

</html>