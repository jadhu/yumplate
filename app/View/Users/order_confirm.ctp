

      <div class="login-main">
<h3>Contact Details</h3>
<p>Prior to completing your transaction, please confirm your contact details</p>
<br />
<div class="row">
    <div class="col-sm-12">

        <?php echo $this->Form->create('User',array('action'=>'paypal','onsubmit'=>'return validatefunct();')); ?>
        <?php echo $this->Form->input('OrderInfo.phone',array('type'=>'text','placeholder'=>'Enter phone','class'=>'form-control','required'=>true));?>

        <?php if($this->Session->read('Error')){?>
        <div class="phone-errors">
         <?php echo $this->Session->read('Error.OrderInfo.phone.0'); ?>
        </div>
        <?php } ?>
        <br />
       <?php echo $this->Form->input('OrderInfo.email',array('type'=>'email','placeholder'=>'Please enter your email','class'=>'form-control','required'=>true));?>
       <div class="email-errors">
        </div>
        <br />
        <p><span class="admin-contact-check"><input type="checkbox" name="order" required ></span>
		<span class="admin-contact-text">By hitting Submit I acknowledge I have read and agree to the Terms and Conditions of YumPlate</span></p>
        <h4 class="text-center"><?php echo $this->Form->button('Submit', array('class' => 'btn become-btn')); ?></h4>
        
        <?php echo $this->Form->end(); ?>
        <br />
         
        <br />

    </div>
</div> 
</div>
<script >

    function validatefunct(){ 
         //var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/; 
         var phoneno = '/^\d{10}$/';  //for 10 digit
         var phone =$('#OrderInfoPhone').val();
         var email =$('#OrderInfoEmail').val();
         //match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/)
          $('.phone-errors').show();
          $('.email-errors').show();
         if(phone =='' || phone==null){

            $('.phone-errors').html('Phone number should not be empty').fadeOut( 3000 );
            return false;

         }

         if(email =='' || email==null){
             $('.email-errors').html('Email should not be empty').fadeOut( 3000 );
            return false;
         }
         /*if(!phone.match(phoneno)){
            $('.phone-errors').html('Phone number should be numeric').fadeOut( 3000 );
           return false;
         }
         if(!email.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/)){
           $('.phone-errors').html('Phone number should be numeric');
           return false;
         }*/
         return true;
    }


</script>