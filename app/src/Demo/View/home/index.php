<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo $baseUrl ?>web/app/Demo/css/style.css">

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
	<div class="fontoContainer">
		<header>
			<h1><?php echo $title; ?></h1>
		</header>
		<section>
			<p><?php echo $this->purify($text); ?></p>
		</section>
		<footer>
			<p>
                <address>
                    <a href="mailto:kennydamgren@gmail.com">Kenny Damgren</a>
                </address>
			</p>
		</footer>
	</div>
</body>
</html>
