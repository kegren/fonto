<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title; ?></title>

    <link href='http://fonts.googleapis.com/css?family=Stoke' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="<?php echo $baseUrl ?>web/app/Demo/css/reset.css">
    <link rel="stylesheet" href="<?php echo $baseUrl ?>web/app/Demo/css/style.css">

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
	<div class="fontoContainer">
		<header>
            <a href="<?php echo $baseUrl; ?>">
                <?php echo $this->createImgLink('web/app/Demo/img/fontoLogov1.png', 'Fonto logo'); ?>
            </a>
			<h1><?php echo $title; ?></h1>
		</header>
        <div class="main">
            <section>
                <h2>Hi</h2>
                <p>My name is Fonto. I do feeling a little bit confused about who I am.
                I mean, how would you feel if your name was 'Fonto'?
                </p>
            </section>
		<footer>
            <address>
                Author: <a href="mailto:kennydamgren@gmail.com">Kenny Damgren</a>
            </address>
		</footer>
	</div>
</body>
</html>
