<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo $title_for_layout; ?></title>
    <?php 
    echo $this->Html->meta('icon');
    echo $this->Html->css(array('bootstrap', 'jquery-ui', 'admin')); ?>
   <?php echo $this->Html->script(array('jquery-1.11.2.min','jquery-1.11.2-ui.min','bootstrap', 'admin','yumplate')); ?>

    <?php echo $this->App->js(); ?>

    <?php echo $this->fetch('css'); ?>
    <?php echo $this->fetch('script'); ?>
</head>
<body>

    <div class="navbar navbar-inverse navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php echo $this->Html->link($this->Html->image('/images/YumPlate-Beta.png'),'/admin',array('class'=>'navbar-brand','escape'=>false,'width'=> '300px;')); ?>
            
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav navbar-right nav-admin">
                <li><?php //echo $this->Html->link('Brands', array('controller' => 'brands', 'action' => 'index', 'admin' => true)); ?></li>
                <li><?php echo $this->Html->link('Categories', array('controller' => 'categories', 'action' => 'index', 'admin' => true)); ?></li>
                <li><?php echo $this->Html->link('Stories', array('controller' => 'stories', 'action' => 'index', 'admin' => true)); ?></li>
                <li><?php echo $this->Html->link('Recipes', array('controller' => 'products', 'action' => 'index', 'admin' => true)); ?></li>
                <li><?php echo $this->Html->link('Recipe Settings', array('controller' => 'users', 'action' => 'setting', 'admin' => true)); ?></li>
                <li><?php echo $this->Html->link('Orders', array('controller' => 'orders', 'action' => 'index', 'admin' => true)); ?></li>
                <li><?php //echo $this->Html->link('Orders Items', array('controller' => 'order_items', 'action' => 'index', 'admin' => true)); ?></li>
                <li><?php echo $this->Html->link('Pages', array('controller' => 'pages', 'action' => 'index', 'admin' => true)); ?></li>
                <li><?php //echo $this->Html->link('Shopping Carts', array('controller' => 'carts', 'action' => 'index', 'admin' => true)); ?></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Utils<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo $this->Html->link('Users', array('controller' => 'users', 'action' => 'index', 'admin' => true)); ?></li>
                        <li><?php echo $this->Html->link('User Add', array('controller' => 'users', 'action' => 'add', 'admin' => true)); ?></li>
                        <li><?php //echo $this->Html->link('Products CSV Export', array('controller' => 'products', 'action' => 'csv', 'admin' => true)); ?></li>
                    </ul>
                </li>
                <li><?php echo $this->Html->link('View Site', array('controller' => 'products', 'action' => 'index', 'admin' => false),array('target'=>'_blank')); ?></li>
                <li><?php 
                echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout', 'admin' => false)); ?></li>
            </ul>
        </div>
    </div>
</div>
    <div class="container content">
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->fetch('content'); ?>
    </div>

    <div class="footer">
    
        <!--p>&copy; <?php echo date('Y'); ?> <?php echo env('HTTP_HOST'); ?></p-->
    </div>

    <div class="sqldump">
        <?php echo $this->element('sql_dump'); ?>
    </div>

</body>
</html>

