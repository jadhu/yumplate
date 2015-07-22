<div class="outer overlay">
  <div class="layout">
<!-- Start Header Here -->
 <header class="header">
   <img src="/images/yumplate-beta-password.png" alt="" />
<!--start social-->
<ul class="social text-center pull-right">
          
          <li><a href="https://www.facebook.com/pages/Yumplate/346586222196988" target="_blank"><i class="fa fa-facebook"></i></a></li>
  <li><a href="https://instagram.com/yumplate" target="_blank"><i class="fa fa-instagram"></i></a></li>
          <li><a href="https://twitter.com/yum_plate" target="_blank"><i class="fa fa-twitter"></i></a></li>
        </ul>
<!--end social-->
 </header>

  <div class="content">
  <div class="early-access">
    <?php echo $this->Session->flash();?>
   <h1><span>Get</span> Early Access</h1>
   <span>I am an early Yummer</span>
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
