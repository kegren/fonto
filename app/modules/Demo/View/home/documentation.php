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
            <h2>Documentation: <em><?php echo $classDoc['name']; ?></em></h2>
            <h3>Description</h3>
            <p><?php echo nl2br($classDoc['doc']); ?></p>
            <?php if (!empty($classDoc['publicMethods'])) : ?>
            <h3>Public methods</h3>
            <?php foreach ($methodsDoc as $method) : ?>
                <?php if ($method['isPublic']) : ?>
                    <h4><?php echo $method['name']; ?></h4>
                    <p><?php echo nl2br($method['doc']); ?></p>
                    <p>Between lines: <?php echo $method['startline']; ?>-<?php echo $method['endline']; ?></p>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if (!empty($classDoc['protectedMethods'])) : ?>
            <h3>Protected methods</h3>
            <?php foreach ($methodsDoc as $method) : ?>
                <?php if ($method['isProtected']) : ?>
                    <h4><?php echo $method['name']; ?></h4>
                    <p><?php echo nl2br($method['doc']); ?></p>
                    <p>Between lines: <?php echo $method['startline']; ?>-<?php echo $method['endline']; ?></p>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if (!empty($classDoc['privateMethods'])) : ?>
            <h3>Private methods</h3>
            <?php foreach ($methodsDoc as $method) : ?>
                <?php if ($method['isPrivate']) : ?>
                    <h4><?php echo $method['name']; ?></h4>
                    <p><?php echo nl2br($method['doc']); ?></p>
                    <p>Between lines: <?php echo $method['startline']; ?>-<?php echo $method['endline']; ?></p>
                    <?php endif; ?>
                <?php endforeach; ?>
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
