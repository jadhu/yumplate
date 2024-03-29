<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

//$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
//$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<?php echo $this->Html->charset(); ?>
	<title><?php echo Configure::read('Settings.SHOP_TITLE'); ?></title>
  <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
 
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css(array('bootstrap','check','fonts'));
  	echo $this->Html->script(array('jquery-1.11.2.min','bootstrap','modernizr','polyfiller'));
    

		echo $this->fetch('meta');
		echo $this->fetch('css');
    echo $this->fetch('script');
		
	?>
<script type="text/javascript">
var SITE_URL = '<?php echo SITE_URL; ?>';
</script>
</head>
<body>
 <?php echo $this->fetch('content'); ?>

<script>
  //google analytics 

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-61437605-1', 'auto');
  ga('send', 'pageview');





  $(document).ready(function(){
    
    webshims.setOptions({
    waitReady: false
    });
    $.webshims.polyfill('forms forms-ext');
    
    $('.insert-anchor').wrap('<li>');
  });

</script>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
