<h2>Admin Edit Category</h2>
<br />
<script>
function goBack() {
    window.history.back()
}
</script>
<button onclick="goBack()" class="btn btn-primary">Back</button>
<br />
<div class="row">

    <div class="col col-lg-3">

        <?php echo $this->Form->create('Category'); ?>
        <?php echo $this->Form->input('id'); ?>
        
        <?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
        
        <?php //echo $this->Form->input('slug', array('class' => 'form-control')); ?>
        
        <?php echo $this->Form->input('description', array('class' => 'form-control')); ?>
        
        <?php echo $this->Form->input('active', array('type' => 'checkbox')); ?>
        
        <?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
        <?php echo $this->Form->end(); ?>

    </div>

</div>


<!--h3>Actions</h3>

<?php echo $this->Form->postLink('Delete', array('action' => 'delete', $this->Form->value('Category.id')), array('class' => 'btn btn-danger'), __('Are you sure you want to delete # %s?', $this->Form->value('Category.id'))); ?>

<br />
<br />
