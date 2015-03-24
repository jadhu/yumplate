<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Login</h4>
      </div>
      <?php echo $this->Form->create('User',array('action'=>'/login'));?>
      <div class="modal-body">
       
          <div class="form-group">
            <label for="recipient-name" class="control-label">Email:</label>
            <?php echo $this->Form->input('email',array('type'=>'text','placeholder'=>'Email','div'=>false,'label'=>false,'class'=>'form-control','required'=>true));?>
           
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">Password:</label>
            <?php echo $this->Form->input('password',array('type'=>'password','placeholder'=>'Password','div'=>false,'label'=>false,'class'=>'form-control'));?>
          </div>
        
      </div>
      <div class="modal-footer">
     
        <div class="login-facebook">
        <?php  echo $this->Html->image('facebook-sign.png',array('data-provider'=>'facebook', 'data-original-title'=>'Facebook','class'=>'img-responsive img-rounded facebook-login','style'=>'cursor:pointer;')); ?>

        </div>
        
        <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
        <button type="submit" class="btn btn-primary">Login</button>
      </div>
      <?php echo $this->Form->end();?>
    </div>
  </div>
</div>

<div class="modal fade" id="ForgetPassModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Forget Password</h4>
      </div>
      <?php echo $this->Form->create('User',array('action'=>'/forgetPassword'));?>
      <div class="modal-body">
       
          <div class="form-group">
            <label for="recipient-name" class="control-label">Email:</label>
            <?php echo $this->Form->input('email',array('type'=>'text','placeholder'=>'Enter e-mail here','div'=>false,'label'=>false,'class'=>'form-control'));?>
           
          </div>
        </div>
      <div class="modal-footer">
       <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      <?php echo $this->Form->end();?>
    </div>
  </div>
</div>


<div class="modal fade" id="ReviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">YUMPLATE REVIEWS</h4>
      </div>
     
      <div class="modal-body" id="comment_section">
       
      </div>
     </div>
  </div>
</div>

<div class="navbar-header">
<button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
    <?php 
   
echo $this->Html->link(
    $this->Html->image('/images/YumPlate-Beta.png'),
    '/',
    array('class' => 'navbar-brand','escape' => false)
);
?>

</div>

 <?php 
   $userLogin=$this->Session->read('Auth.User');

   $style='';
   if(!empty($userLogin)){
       $style='style="display:none;"';
   }

$controller=array('products','users');
$action=array('profile','index','ExploreYum','view');
if(in_array($this->params->params['controller'],$controller) && in_array($this->params->params['action'],$action)) { ?>
<div class="yumplate-cart">
<ul>

<li class="order" >
<?php 

if(!empty($userLogin)){
  echo $this->Html->link(
$count,
'/carts',
array('class'=>'cart-btn')
);
}
?>

</li>
</ul>
</div>
<?php } ?>
<div class="navbar-collapse collapse" id="navbar">                            
<ul class="nav navbar-nav navbar-right">
 
<?php if($this->params->params['controller']=='products' && $this->params->params['action']=='index') { ?>  
<li>
<a id="order_now" href="javascript:void(0)">Order Now</a>
</li>
<?php } ?>

    <li <?php echo $style;?>>

<?php 
echo $this->Html->link(
    'Sign Up',
     '/register'
    
);
?>
</li>
<li <?php echo $style;?>>
<a href="javascript:void(0);" id="user_login" class="">
Login
</a
<?php 
/*echo $this->Html->link(
    'Login',
    array(
        'controller' => 'users',
        'action' => 'login',
        'full_base' => true
    )
);*/
?>
</li>                                
<li>
<?php 
echo $this->Html->link(
    'How it Works',
   '/howitworks'
);
?>
</li>
<li>
<?php 
echo $this->Html->link(
  'Become a YumCook!',
   '/instruction',
   array('class'=>'become-btn')
);
?>  
 </li> 

<?php 
$controller=array('products','users');
$action=array('profile','index','ExploreYum','view');
if(in_array($this->params->params['controller'],$controller) && in_array($this->params->params['action'],$action)) { ?>
<li class="order desktop-cart" >

<?php 

if(!empty($userLogin)){
  echo $this->Html->link(
$count,
'/carts',
array('class'=>'cart-btn')
);
}
?>


</li>
<?php } ?>
<li <?php if(empty($userLogin)){echo 'style="display:none;"'; } ?> >
    <div class="btn-group profile-popup" role="group">
     <?php 
        if(!empty($userLogin)){ ?>
    <button type="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          <?php echo 'Hello '.$this->Session->read('Auth.User.first_name'); }  ?>
          <span class="caret"></span>
        </button>
        <?php if($this->Session->read('Auth.User.role')!='admin'){
            echo '<ul class="dropdown-menu" role="menu">';
            echo "<li>";

            echo $this->Html->link(
              'My Orders',
              array(
                  'controller' => 'users',
                  'action' => 'dashboard',
                  'customer'=>true,
                  'full_base' => true
              ),
              array('class'=>'text-center')
            );

           echo "</li>";
           echo "<li>";
           echo $this->Html->link(
            'Change Password',
            array(
                'controller' => 'users',
                'action' => 'change_password',
                'customer'=>true,
                'full_base' => true
             ),
             array('class'=>'text-center')
           );
           echo '</li><li>';
           echo $this->Html->link(
          'Logout',
           '/logout',
          array('class'=>'text-center')
        );
        
           echo "</li></ul>";
      }else{
        echo '<ul class="dropdown-menu" role="menu"> <li class="user-name">';
        echo $this->Html->link(
          'Dashboard',
          array(
              'controller' => 'users',
              'action' => 'dashboard',
              'admin'=>true,
              'full_base' => true
          ),
          array('class'=>'text-center')
        );
        echo '</li><li>';
        echo $this->Html->link(
          'Logout',
          array(
              'controller' => 'users',
              'action' => 'logout',
              'full_base' => true
          ),
          array('class'=>'text-center')
        );
        echo '</li></ul>';
      }
        ?>
          <?php 
        ?>


        
  </div>
</li>
</ul>

</div>
<!--/.nav-collapse -->
