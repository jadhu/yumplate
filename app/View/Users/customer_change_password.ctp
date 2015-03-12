<h2>Change Password</h2>
<div class="row" >
 <div class="col-sm-4">
<?php 

echo $this->Form->create('User',array('action'=>'/change_password'));
echo $this->Form->input('id',array('type'=>'hidden','value'=>$this->Session->read('Auth.User.id')));
?>
      <div class="modal-body">
        <div class="form-group">
            <label for="recipient-name" class="control-label">Old password:</label>
            <?php echo $this->Form->input('oldpassword',array('type'=>'password','placeholder'=>'Enter old password ','div'=>false,'label'=>false,'class'=>'form-control'));?>
           
          </div>
       
          <div class="form-group">
            <label for="recipient-name" class="control-label">New password:</label>
            <?php echo $this->Form->input('password',array('type'=>'password','placeholder'=>'Enter new password ','div'=>false,'label'=>false,'class'=>'form-control'));?>
           
          </div>
           <div class="form-group">
            <label for="recipient-name" class="control-label">Confirm password:</label>
            <?php echo $this->Form->input('cpassword',array('type'=>'password','placeholder'=>'Connfirm password','div'=>false,'label'=>false,'class'=>'form-control'));?>
           
          </div>
        </div>
      <div class="modal-footer">
       <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      <?php echo $this->Form->end();?>
      </div>
      </div>