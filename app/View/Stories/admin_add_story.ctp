 <?php echo $this->Html->script('ckeditor/ckeditor');?>
<h2>Add Story</h2>
<br />
<script>
function goBack() {
    window.history.back()
}
</script>
<button onclick="goBack()" class="btn btn-primary">Back</button>
<br/>

<br />
<div class="row">
    <div class="col-sm-12">

        <?php 
        
        echo $this->Form->create('Story',array('enctype'=>'multipart/form-data'));
        echo $this->Form->input('image_name', array('type'=>'hidden','class' => 'form-control'));
         echo $this->Form->input('id', array('type'=>'hidden','class' => 'form-control'));

        ?>
	<div class="row">
    <div class="col-sm-4">
        <?php 
        echo $this->Form->input('title', array('class' => 'form-control'));
        
        ?>
		</div>
		</div>
        <br/>
        <?php echo $this->Form->input('story', array('class' => 'form-control','rows'=>'70','cols'=>'60')); ?>
       
        <br/>
		<div class="row">
			<div class="col-sm-4">
				<?php 
				 if(!empty($this->request->data['Story']['image_name'])){
				   echo $this->Html->image('/images/story/'.$this->request->data['Story']['image_name'], array('alt'=>'','class' => ''));  
				 }
				 ?>
			 </div>
		 </div>
		 <br />
		 <div class="row">
			<div class="col-sm-4">
				<?php echo $this->Form->input('image', array('type'=>'file','class' => 'form-control')); ?>
			</div>
		 </div>        
        <?php echo $this->Form->input('active', array('type' => 'checkbox')); ?>
	<?php echo $this->Form->input('featured', array('type' => 'checkbox')); ?>
       

        <?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
        <?php echo $this->Form->end(); ?>

    </div>
</div>

<br />
<br />
<script type="text/javascript">
var CustomHTML = CKEDITOR.replace('StoryStory',
        {filebrowserBrowseUrl : '/js/ckfinder/ckfinder.html',
         filebrowserWindowWidth : '1000',
         filebrowserWindowHeight : '700'}
);
</script>