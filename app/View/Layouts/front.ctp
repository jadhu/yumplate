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
	<?php echo $this->Html->charset(); ?>
	<title><?php echo Configure::read('Settings.SHOP_TITLE'); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php
//echo $this->Html->meta('viewport','width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1');
if($this->params->params['controller']=='products' && $this->params->params['action']=='view' ){ ?>
<meta name="description" content="<?php echo !empty($product['Product']['story'])?$product['Product']['story']:'';?>">
<!--meta name="keywords" content="HTML,CSS,XML,JavaScript"-->
<meta name="meal" content="<?php echo $product['Product']['name'];?>">

<?php } ?>

<!--- Meta tags for stories profile-->

<?php
if($this->params->params['controller']=='stories' && $this->params->params['action']=='view' ){ ?>

<meta name="description" content="<?php echo !empty($meta_settings['MetaSetting']['description'])?$meta_settings['MetaSetting']['description']:'';?>">
<meta name="keywords" content="<?php echo $meta_settings['MetaSetting']['keywords'];?>">
<meta name="name" content="<?php echo $meta_settings['MetaSetting']['name'];?>">
<?php } ?>
 <!--- Meta tags for stories ends here-->


<?php

if($this->params->params['controller']=='users' && $this->params->params['action']=='profile' ){ ?>
<!--- Meta tags for cooks profile-->
<meta name="description" content="<?php echo !empty($product['User']['description'])?$product['User']['description']:'';?>">
<!--meta name="keywords" content="HTML,CSS,XML,JavaScript"-->
<meta name="chef" content="<?php echo $product['User']['first_name'].' '.$product['User']['last_name'];?>">

<!--- Meta tags for cooks profile ends here-->

 
<!-- Open Graph data -->
<meta property="og:title" content="Yumplate" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo SITE_URL.'u/'.$product['User']['username'];?>" />
<meta property="og:image" content="<?php echo SITE_URL;?>images/UserImg/<?php echo !empty($product['User']['image'])?$product['User']['image']:''?>" />
<meta property="og:description" content="<?php echo !empty($product['User']['description'])?$product['User']['description']:'';?>" />


<!-- Twitter Card data -->

<meta name="twitter:title" content="Yumplate">
<meta name="twitter:description" content="<?php echo !empty($product['User']['description'])?$product['User']['description']:'';?>">
<!-- Twitter summary card with large image must be at least 280x150px -->
<meta name="twitter:image" content="<?php echo Router::url('/');?>images/UserImg/<?php echo !empty($product['User']['image'])?$product['User']['image']:''?>"> 

 <?php } ?>

	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css(array('bootstrap','fonts','style','animate.min','responsive','toolitup-jrate'));
  	echo $this->Html->script(array('jquery-1.11.2.min','jquery-validation','bootstrap','oauth','modernizr','polyfiller','yumplate'));
    

		echo $this->fetch('meta');
		echo $this->fetch('css');
    echo $this->fetch('script');
		
	?>
<script type="text/javascript">
var SITE_URL = '<?php echo SITE_URL; ?>';
</script>
</head>
<body>
  <!-- HEADER -->
        <header class="header">
       
            <nav class="navbar navbar-default navbar-fixed-top">
                <div class="container">

                <?php echo $this->element('front_header');?>
			      </div>
            </nav>
        </header>
          <!-- HEADER --> 
           <?php echo $this->Session->flash(); ?>
          <?php if($this->params->params['action']=='index'){ ?>
          <section class="slider">
            <div class="home-slider">
                <div class="caption">
                    <h1>Order authentic meals<br/>made in your neighbour's kitchen</h1>
                    <div class="btn-row">
                      
                <?php 
               echo $this->Form->create('Product',array('action'=>'RedirectUrl'));
               echo $this->Form->input('keywords',array('type'=>'text','placeholder'=>'Search meals','div'=>false,'label'=>false));
                ?>
                 <button type="submit" class="btn btn-primary">ExploreYum</button>

               <?php echo $this->Form->end();
                echo $this->Html->link('How it Works',
                array(
                'controller' => 'products',
                'action' => 'howitworks',
                'full_base' => true
                ),
                array('class'=>'btn btn-h-works')
                );
                ?>
                    </div>
                </div>
            </div>
          </section>

          <?php  } ?>

        <!-- BODY SECTION -->
        <section class="<?php if($this->params->params['action']=='meal'){ echo 'bodySec';}else{echo 'feature-products';} ?>">
       <div class="<?php if($this->params->params['action']=='meal'){ echo 'meals-container';}else{echo 'container';} ?>">
      <div class="pop-up" >
      <div class="col-sm-12">
      <div id="message" >

      </div>
      </div>
      </div>
         <?php echo $this->fetch('content'); ?>
		</div>
		 </section>
         <?php if($this->params->params['action']=='index'){ 
            echo $this->element('community');
           } ?>
        
            
		<div class="footer">
	    <?php 

		echo $this->element('front_footer');
    echo $this->Form->input('page_url',array('type'=>'hidden','value'=>$this->Html->url('/',true)));

       ?>
		</div>

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
