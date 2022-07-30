<!DOCTYPE html>
<html lang="es">
<head>
  	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content ="{!!csrf_token()!!}" />
	<link rel="icon" type="image/png"   href="public/images/favicon.png">
	<title>Virtual Sex Shop Gdl Alcala</title>
	@include('shared.jsDir')
</head>
<body>

	<div id="app">
		<vue-topprogress ref="loadingBar" color="#974578" :height="2"></vue-topprogress>
		<my-header></my-header>
		<router-view></router-view>
		<my-footer></my-footer>
	</div>

	<script src="https://www.paypalobjects.com/api/checkout.js"></script>

	<link rel="stylesheet" type="text/css" href="public/css/app.css">
	{{-- <link rel="stylesheet" type="text/css" href="public/extras/css/font-awesome/css/fontawesome-all.min.css"> --}}
	<script type="text/javascript" src="public/js/app.js"></script>

	<!--Start of Tawk.to Script-->
	<script type="text/javascript">
	var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
	(function(){
	var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
	s1.async=true;
	s1.src='https://embed.tawk.to/6050df4bf7ce18270930b517/1f0tugfpa';
	s1.charset='UTF-8';
	s1.setAttribute('crossorigin','*');
	s0.parentNode.insertBefore(s1,s0);
	})();
	</script>
	<!--End of Tawk.to Script-->

</body>
</html>
