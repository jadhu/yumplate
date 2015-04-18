<div class="outer">
  <div class="layout">
<!-- Start Header Here -->
 <header class="header">
   <a href="#" class="logo"><img src="/images/check_logo.png" alt="" /></a>
   <ul class="social-icon">
   <li class="facebook"><a href="#" class="active">&nbsp;</a></li>
   <li class="gplus"><a href="#">&nbsp;</a></li>
   <li class="twiter"><a href="#">&nbsp;</a></li>
   </ul>
 </header>

  <div class="content">
  <div class="early-access">
    <?php echo $this->Session->flash();?>
   <h1><span>Get</span> Early Access</h1>
   <span>I am an early adopter</span>
   <?php 
    echo $this->Form->create();
   echo $this->Form->input('password',array('label'=>false,'type'=>'text','class'=>'code-txt','placeholder'=>'Enter beta code','required'=>true));?>
   <button type="submit">GET ACCESS</button>

 <?php  echo $this->Form->end();
   ?>

  </div>

  </div>
  </div>
 </div>
