<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo $title_for_layout; ?></title>
    <?php 
    echo $this->Html->meta('icon');
    echo $this->Html->css(array('bootstrap.css', '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css', 'admin.css')); ?>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

    <?php echo $this->Html->script(array('bootstrap.min.js', 'admin.js')); ?>

    <?php echo $this->App->js(); ?>

    <?php echo $this->fetch('css'); ?>
    <?php echo $this->fetch('script'); ?>
</head>
<body>

    <div class="navbar navbar-inverse navbar-static-top" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        <?php echo $this->Html->link($this->Html->image('/images/YumPlate-Beta.png'),'/customer',array('class'=>'navbar-brand','escape'=>false)); ?>
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                
                <li><?php //echo $this->Html->link('Profile', array('controller' => 'users', 'action' => 'view', 'customer' => true)); ?></li>
                <li><?php echo $this->Html->link('Change Password', array('controller' => 'users', 'action' => 'customer_change_password', 'customer' => true)); ?></li>
                
                <li><?php echo $this->Html->link('View Site', array('controller' => 'products', 'action' => 'index', 'admin' => false),array('target'=>'_blank')); ?></li>
                <li><?php 
                echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout', 'admin' => false)); ?></li>
            </ul>
        </div>
    </div>

    <div class="content">

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->fetch('content'); ?>
        <?php echo $this->element('sql_dump'); ?>

        <br />
        <br />

        <!--div class="footetr">
            <p>&copy; <?php echo date('Y'); ?> <?php echo env('HTTP_HOST'); ?></p>
        </div-->

    </div>

</body>
</html>
