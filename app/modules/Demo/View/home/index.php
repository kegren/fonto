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
                <h2>Documentation</h2>
                <p>Welcome to Fontos home controller. This is right now set as the default controller.
                    You can of course change this behavior in the routes.php file.</p>
                <p>
                    Fonto is built as a PHP framework with flexibility in mind.
                    You, as an user, can easily decide what kind of packages you need by making use of composer and just download
                    them through the composer repository. Fonto is in no way meant to be competing with other
                    frameworks, it's just a little project that I made. As you will notice, Fonto, is a work in progress
                    and over time it will change dramatically. This is just a start and hopefully it can be 'fontozing'
                    in the future.
                </p>
                <h3>Enabled controllers and their methods</h3>
                <?php if(sizeof($controllers)) : ?>
                <ul>
                <?php foreach($controllers as $name => $methods) : ?>
                    <li><?php echo $this->createLink(array($name), $name); ?>
                        <ul>
                        <?php foreach($methods as $method) : ?>
                            <li><?php echo $this->createLink(array($name, $method), $method); ?></li>
                        <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </section>
            <section>
                <h3>Models</h3>
                <h4>Doctrine models: </h4>
                <?php if(empty($models)) : ?>
                <ul>
                    <?php foreach($models as $name => $methods) : ?>
                    <?php if($methods['type'] == 'FormModel') : ?>
                    <?php continue; ?>
                    <?php endif; ?>
                    <li>
                        <?php echo $name; ?>
                    <ul>
                        <?php foreach($methods as $method) : ?>
                        <li><?php echo $method; ?></li>
                        <?php endforeach; ?>
                    </ul>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else:  ?>
                <p>-</p>
                <?php endif; ?>
            </section>
            <section>
            <h4>Form models: </h4>
            <?php if(sizeof($models)) : ?>
            <ul>
                <?php foreach($models as $name => $methods) : ?>
                <?php if($methods['type'] == 'Entity') : ?>
                    <?php continue; ?>
                    <?php endif; ?>
                <li>
                    <?php echo $name; ?>
                    <ul>
                        <?php foreach($methods as $id => $method) : ?>
                        <?php if(!is_numeric($id)) continue; ?>
                        <li>
                            <?php echo $method; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            </section>
        </div>
        <div class="sidebar">
            <h2>Core services</h2>
            <ul>
                <?php foreach($services as $class => $args) : ?>
                <li>
                    <?php echo $this->createLink(array('home', 'documentation',  $args['id']), $class); ?>
                    <ul>
                        <?php foreach ($args as $name => $arg) : ?>
                        <?php if (is_numeric($name)) : ?>
                            <li><?php echo $arg; ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <?php endforeach; ?>
            </ul>
            <h2>Core objects</h2>
            <ul>
                <?php foreach ($objects as $class => $namespace) : ?>
                <li>
                    <?php echo $this->createLink(array('home', 'documentation',  $class), $namespace); ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="clear"></div>
		<footer>
            <address>
                Author: <a href="mailto:kennydamgren@gmail.com">Kenny Damgren</a>
            </address>
		</footer>
	</div>
</body>
</html>
