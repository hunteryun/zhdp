<!DOCTYPE html>
<html>

<head>
	@include('public.include_head')
	<style>
		body {
			overflow: hidden;
		}
		.login {
			height: 260px;
			width: 260px;
			/* padding: 20px; */
			border-radius: 4px;
			position: absolute;
			left: 50%;
			top: 30%;
			margin: -150px 0 0 -150px;
			z-index: 99;
		}
	</style>
</head>

<body>
	<div class="fly-none login">
		<h2><i class="iconfont icon-404"></i></h2>
	</div>
	@include('public.include_js')
</body>

</html>

