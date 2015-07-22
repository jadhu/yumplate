<div class="login-main">
<h3>Login</h3>
<?php //echo $this->layout;?>
<div class="row">
    <div class="col-sm-12">

        <?php echo $this->Form->create('User', array('action' => 'login')); ?>
        <?php echo $this->Form->input('email', array('type'=>'text','placeholder'=>'Email','class' => 'form-control', 'autofocus' => 'autofocus')); ?>
        <br />
        <?php echo $this->Form->input('password', array('placeholder'=>'Password', 'class' => 'form-control')); ?>
        <br />
       
        <h4 class="text-center"><?php echo $this->Form->button('Login', array('class' => 'btn become-btn')); ?></h4>

        <?php echo $this->Form->end(); ?>
        <br />
         <a id="forget_pass" class="forget-link" href="javascript:void(0)">Forget Your Password ?</a>
        <br />
        <br />

    </div>
</div> 
</div>