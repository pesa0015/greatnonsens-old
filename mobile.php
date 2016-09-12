<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Soon on mobile!</title>
	<link href="https://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet">
	<style>
	body {
		/*background: url(assets/images/g-mobile.png) top right no-repeat;*/
	}
	#bg {
	  	position: fixed; 
	  	top: 0; 
	  	left: 0; 
		z-index: -1;
	  	/* Preserve aspet ratio */
	  	min-width: 100%;
	  	min-height: 100%;
	}
	#logo {
		display: block;
		margin: 90px auto 0 auto;
		/*width: 100px;*/
		z-index: 1;
	}
	#message {
		font-family: 'Bree Serif', serif;
		color: #FFFFFF;
		text-align: center;
	    position: absolute;
	    bottom: 15%;
	    width: 100%;
	}
	#soon {
		font-size: 700%;
		/*font-size: 270%;*/
	}
	hr {
		background: #FFFFFF;
		width: 100px;
		height: 5px;
	}
	#gn {
		font-size: 400%;
		/*font-size: 150%;*/
	}
	</style>
</head>
<body>
	<img id="bg" src="assets/images/body9-mobile.png" alt="">
	<img id="logo" src="assets/images/g.png" alt="">
	<div id="message">
		<div id="soon">Soon on mobile</div>
		<hr />
		<div id="gn">Great nonsens</div>
	</div>	
</body>
</html>