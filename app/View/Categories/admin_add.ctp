<h2>Admin Add Category</h2>

<br />
<script>
function goBack() {
    window.history.back()
}
</script>
<button onclick="goBack()" class="btn btn-primary">Back</button>
<br />
<br />
<div class="row">

    <div class="col col-lg-3">

        <?php echo $this->Form->create('Category'); ?>
        
        <?php //echo $this->Form->input('parent_id', array('class' => 'form-control', 'empty' => true)); ?>
        <?php echo $this->Form->input('name', array('class' => 'form-control','label'=>'Category Name')); ?>
        
        <?php //echo $this->Form->input('slug', array('class' => 'form-control')); ?>
        
        <?php echo $this->Form->input('description', array('class' => 'form-control')); ?>
        
        <?php echo $this->Form->input('active', array('type' => 'checkbox')); ?>
        
        <?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
        <?php echo $this->Form->end(); ?>

    </div>

</div>