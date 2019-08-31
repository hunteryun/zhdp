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
					<li><a href="{{url('login/user')}}">登入</a></li>
					<li class="layui-this">注册</li>
				</ul>
				<div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
					<div class="layui-tab-item layui-show">
						<div class="layui-form layui-form-pane">
							<form method="post">
								<div class="layui-form-item">
									<label for="L_email" class="layui-form-label">邮箱</label>
									<div class="layui-input-inline">
										<input type="text" id="L_email" name="email" required lay-verify="email" autocomplete="off" class="layui-input">
									</div>
									<div class="layui-form-mid layui-word-aux">将会成为您唯一的登入名</div>
								</div>
								<div class="layui-form-item">
									<label for="L_username" class="layui-form-label">昵称</label>
									<div class="layui-input-inline">
										<input type="text" id="L_username" name="username" required lay-verify="required" autocomplete="off" class="layui-input">
									</div>
								</div>
								<div class="layui-form-item">
									<label for="L_pass" class="layui-form-label">密码</label>
									<div class="layui-input-inline">
										<input type="password" id="L_pass" name="pass" required lay-verify="required" autocomplete="off" class="layui-input">
									</div>
									<div class="layui-form-mid layui-word-aux">6到16个字符</div>
								</div>
								<div class="layui-form-item">
									<label for="L_repass" class="layui-form-label">确认密码</label>
									<div class="layui-input-inline">
										<input type="password" id="L_repass" name="repass" required lay-verify="required" autocomplete="off" class="layui-input">
									</div>
								</div>
								<div class="layui-form-item">
									<label for="L_vercode" class="layui-form-label">人类验证</label>
									<div class="layui-input-inline">
										<input type="text" id="L_vercode" name="vercode" required lay-verify="required" placeholder="请回答后面的问题" autocomplete="off" class="layui-input">
									</div>
									<div class="layui-form-mid">
										<span style="color: #c00;">@{{d.vercode}}</span>
									</div>
								</div>
								<div class="layui-form-item">
									<button class="layui-btn" lay-filter="*" lay-submit>立即注册</button>
								</div>
								<div class="layui-form-item fly-form-app">
									<span>或者直接使用社交账号快捷注册</span>
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
	</script>
</body>

</html>