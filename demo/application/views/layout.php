<html>
<head>
    <title>ExtJS Bundle for Laravel</title>

    <?php echo HTML::style('ext-4/resources/css/ext-all.css'); ?>
    <?php echo HTML::style('css/style.css'); ?>

    <?php echo HTML::script('ext-4/ext-all.js'); ?>
	
</head>
<body>
    <ul>
        <li>
            <?php echo HTML::link_to_route('grid', 'Grid' ); ?>
        </li>
        <li>
            <?php echo HTML::link_to_route('form', 'Form' ); ?>
        </li>
        <li>
            <?php echo HTML::link_to_route('tree', 'Tree' ); ?>
        </li>
    </ul>
    
    <?php echo $content ?>
</body>
</html>