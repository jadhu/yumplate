<h2>Admin Edit User</h2>

<br />
<button onclick="goBack()" class="btn btn-primary">Back</button>
<div class="row">
    <div class="col-sm-4">

        <?php 
        echo $this->Form->create('User',array('enctype'=>'multipart/form-data'));
        echo $this->Form->input('id'); 
        echo $this->Form->input('image_name', array('class' => 'form-control','type'=>'hidden','value'=>!empty($this->request->data['User']['image'])?$this->request->data['User']['image']:''));
         ?>
        <?php echo $this->Form->input('role', array('class' => 'form-control', 'options' => array('admin' => 'admin', 'customer' => 'customer','cook'=>'cook'))); ?>
    </div>    
	<div class="col-sm-4">
        <?php echo $this->Form->input('first_name', array('class' => 'form-control')); ?>
    </div>    
	<div class="col-sm-4">
        <?php echo $this->Form->input('username', array('class' => 'form-control')); ?>
    </div>    
	<div class="col-sm-4">
        <?php echo $this->Form->input('active', array('type' => 'checkbox')); ?>
    </div>    
	<div class="col-sm-4">
        <?php echo $this->Form->input('email', array('class' => 'form-control')); ?>
    </div>    
	<div class="col-sm-12">
          <?php echo $this->Form->input('description', array('class' => 'form-control')); ?>
    </div>    
	<div class="col-sm-4">

        <?php echo $this->Form->input('city', array('class' => 'form-control')); ?>
    </div>    
	<div class="col-sm-4">

        <div class="input text">
        <label for="UserCountry">Province/State</label>
       <?php echo $this->Form->input('country', array('class' => 'form-control','div'=>false,'label'=>false)); ?>
        </div>
      
    </div>    
	<div class="col-sm-4">
         <?php echo $this->Form->input('address_type', array('class' => 'form-control')); ?>
    </div>    
	<div class="col-sm-4">
         <?php echo $this->Form->input('parking', array('class' => 'form-control')); ?>
    </div>    
	<div class="col-sm-4">
        <?php echo $this->Form->input('delivery', array('class' => 'form-control', 'options' => array('yes' => 'Yes', 'no'=>'No'))); ?>
    </div>    
	<div class="col-sm-4">
        <?php echo $this->Form->input('image', array('class' => 'form-control','type'=>'file')); ?>
    </div>    
	<div class="col-sm-4">


        <?php 
           if(!empty($this->request->data['User']['image'])){
            echo '<div class="profile-image">'.$this->Html->image('/images/UserImg/'.$this->request->data['User']['image'],array('alt'=>'','height'=>'65px','width'=>'65px')).'</div>';

           }?>
		<br/>
		<?php 
        echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
        <?php echo $this->Form->end(); ?>

    </div>
	
</div>
<script>
function goBack() {
    window.history.back()
}
</script>