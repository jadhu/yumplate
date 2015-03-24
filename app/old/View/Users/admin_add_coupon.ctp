<h2>Add Discount</h2>

<br />
<script>
function goBack() {
    window.history.back()
}
$(document).ready(function(){
    $('#CouponStartDate').datepicker({
        minDate: 0,
        dateFormat: 'yy-mm-dd'
    });
    $('#CouponEndDate').datepicker({
        minDate: 0,
        dateFormat: 'yy-mm-dd'
    });
});
</script>
<button onclick="goBack()" class="btn btn-primary">Back</button>
<br />
<br />
<div class="row">
    <div class="col-sm-4">	
        <?php 
        echo $this->Form->create('User',array('enctype'=>'multipart/form-data'));
        echo $this->Form->input('Coupon.id', array('class' => 'form-control','type'=>'hidden','value'=>!empty($coupon['Coupon']['id'])?$coupon['Coupon']['id']:''));
        ?>
        <?php echo $this->Form->input('Coupon.user_id', array('class' => 'form-control', 'options' =>$users,'empty'=>'Select Chef','value'=>!empty($coupon['Coupon']['user_id'])?$coupon['Coupon']['user_id']:'')); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $this->Form->input('Coupon.name', array('class' => 'form-control','placeholder'=>'Coupon name','value'=>!empty($coupon['Coupon']['name'])?$coupon['Coupon']['name']:'')); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $this->Form->input('Coupon.discount', array('class' => 'form-control','placeholder'=>'Discount in %','value'=>!empty($coupon['Coupon']['discount'])?$coupon['Coupon']['discount']:'')); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $this->Form->input('Coupon.discount_limit', array('class' => 'form-control','placeholder'=>'Discount started at amount','value'=>!empty($coupon['Coupon']['discount_limit'])?$coupon['Coupon']['discount_limit']:'')); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $this->Form->input('Coupon.start_date', array('class' => 'form-control','placeholder'=>'Discount start date','type'=>'text','value'=>!empty($coupon['Coupon']['start_date'])?$coupon['Coupon']['start_date']:'')); ?>
    </div>
    <div class="col-sm-4">
         <?php echo $this->Form->input('Coupon.end_date', array('class' => 'form-control','placeholder'=>'Discount expiry date','type'=>'text','value'=>!empty($coupon['Coupon']['end_date'])?$coupon['Coupon']['end_date']:'')); ?>
    </div>
    <div class="col-sm-4">    
        <?php echo $this->Form->input('Coupon.active', array('type' => 'checkbox','checked'=>!empty($coupon['Coupon']['active'])?true:false)); ?>
    <br/>
        <?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
        <?php echo $this->Form->end(); ?>

    </div>
</div>