<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Latest compiled and minified Twitter bootstrap -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<div class="container">
        <header class="row">
            <div class="col-lg-12">
                <h1>
                   <?php echo $title ?> a PHP 5.3+ framework.
                </h1>
                <div class="alert">
                    <strong>Notice!</strong> this is a beta release.
                </div>
            </div>
        </header>
		<div class="row">
            <section class="col-lg-6">
                <h2>
                    Welcome to your home page.
                </h2>
                <p>You have successfully installed Fonto. You see this page
                because it's the root route. You can ofcourse change this anytime
                you will (and sure you will).</p>
            </section>
            <section class="col-lg-6">
                <h2>
                    What to do now?
                </h2>
                <p>Now it's time to build the next big thing right? Lets get starting
                by update your configuration settings in the config files.</p>
            </section>
        </div>
        <footer class="row">
            <div class="col-lg-12">
                <address>
                    Created by: <a href="http://kennydamgren.me">Kenny Damgren</a>
                </address>
            </div>
        </footer>
	</div>
</body>
</html>
