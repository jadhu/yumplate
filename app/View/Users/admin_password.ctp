<h2>Admin Edit User Password</h2>

<br />
<script>
function goBack() {
    window.history.back()
}
</script>
<button onclick="goBack()" class="btn btn-primary">Back</button>


<br />
<br />
<label>Username : </label>&nbsp;&nbsp;&nbsp;<label> <?php echo $this->Form->value('User.username') ; ?> </label>


<br />
<br />
<div class="row">
    <div class="col-sm-4">

        <?php echo $this->Form->create('User');?>
        <?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
        <?php echo $this->Form->input('password', array('class' => 'form-control','placeholder'=>'Enter new password ', 'value' => '')); ?>
      </div>    
	<div class="col-sm-4">
        <div class="form-group">
            <label for="recipient-name" class="control-label">Confirm Password</label>
            <?php echo $this->Form->input('cpassword',array('type'=>'password','placeholder'=>'Connfirm password','div'=>false,'label'=>false,'class'=>'form-control'));?>
           
          </div>
    </div>
	<br/>
	<div class="col-sm-12">
        <?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary'));?>
        <?php echo $this->Form->end();?>
	</div>
    
</div>