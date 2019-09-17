<!DOCTYPE html>
<html>

<head>
	@include('public.include_head')
</head>
<style>
	body {
		overflow: hidden;
	}

	.login {
		height: 260px;
		width: 260px;
		padding: 20px;
		border-radius: 4px;
		position: absolute;
		left: 50%;
		top: 50%;
		margin: -150px 0 0 -150px;
		z-index: 99;
	}

	.login h1 {
		text-align: center;
		color: black;
		font-size: 24px;
		margin-bottom: 20px;
	}

	.form_code {
		position: relative;
	}

	.form_code .code {
		position: absolute;
		right: 0;
		top: 1px;
		cursor: pointer;
	}

	.login_btn {
		width: 100%;
	}
</style>

<body>
	<div class="login">
		<h1>云蛙-用户注册</h1>
		<form class="layui-form">
			<div class="layui-form-item">
				<input class="layui-input" name="name" placeholder="用户名" lay-verify="required" type="text" autocomplete="off">
			</div>
			<div class="layui-form-item">
				<input class="layui-input" name="password" placeholder="密码" lay-verify="required" type="password" autocomplete="off">
			</div>
			<div class="layui-form-item">
				<div class="" style="float:right">
					<a href="{{url('user/login')}}" style="color:#009688">已有帐号？点击登录</a>
				</div>
			</div>
			<button class="layui-btn login_btn" lay-submit="" lay-filter="formSubmit">注册</button>
		</form>
	</div>
	@include('public.include_js')
	<script>
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
				success: function(result) {
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