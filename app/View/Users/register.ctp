<div class="main">
<h2>Registration</h2>

<br />
<?php  //echo $this->Html->script(array('oauth'));?>

<div class="signup-main">
<h3 class="text-center">Sign up</h3>
<h5 class="text-center">Already a Yumplater? Sign in</h5>
<div id="socialConnect" >
	<div class="sign-social">
		<div class="row social-container signup">			
			<?php  echo $this->Html->image('/images/facebook-signup.png',array('data-provider'=>'facebook', 'data-original-title'=>'Facebook','class'=>'img-responsive img-rounded facebook-login','style'=>'cursor:pointer;')); ?>		
		</div>			   
	</div>
</div>
 <div class="row">
    <div class="col-sm-12">
		
        <?php echo $this->Form->create('User',array('enctype'=>'multipart/form-data'));?>
        <?php echo $this->Form->input('role', array('class' => 'form-control','type'=>'hidden', 'value' =>'customer')); ?>
		
        <?php echo $this->Form->input('first_name', array('class' => 'form-control' , 'placeholder' => 'First Name','label'=>false ,'required'=>true)); ?>
       
         <?php echo $this->Form->input('last_name', array('class' => 'form-control' , 'placeholder' => 'Last Name','label'=>false ,'required'=>true)); ?>
       
        <?php echo $this->Form->input('email', array('class' => 'form-control' , 'placeholder' => 'Email','label'=>false ,'required'=>true)); ?>
        
        <?php //echo $this->Form->input('username', array('class' => 'form-control')); ?>
        <!--br />
       
        <?php //echo $this->Form->input('city', array('class' => 'form-control')); ?>
         <br />
        <?php //echo $this->Form->input('country', array('class' => 'form-control')); ?>
        <br /-->
        <?php //echo $this->Form->input('image', array('class' => 'form-control','type'=>'file')); ?>
        
         <?php echo $this->Form->input('password', array('class' => 'form-control','placeholder'=>'Password','label'=>false )); ?>
         
        <div class="input password">
      
        <?php echo $this->Form->input('cpassword', array('class' => 'form-control', 'placeholder' => 'Confirm Password' ,'type'=>'password','div'=>false,'label'=>false)); ?>
        </div>
         <?php echo $this->Form->input('term', array('type'=>'checkbox','required' => true,'label'=>false,'div'=>false ));?>
		 <a href="<?php echo $this->Html->url('/products/term_and_conditions',true);?>" class="forget-link">By creating an account you confirm that you accept our Terms and Conditions</a>
         <br />
		<h4 class="text-center"> 
        <?php echo $this->Form->button('Sign Up', array('class' => 'btn become-btn')); ?>
        <?php echo $this->Form->end(); ?> <br />
         
		</h4>
       <a id="forget_pass" class="forget-link" href="javascript:void(0)">Forget Password</a>
    </div>

	</div>
	</div>
	
	
