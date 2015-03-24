<h2>Stories</h2>

<div class="row">
     <?php if(!empty($stories)){ foreach ($stories as $story){ ?>
<div class="col-sm-12" id="<?php echo $story['Story']['id']; ?>">
<div class="com-thumb">
<h5><?php echo $story['Story']['title']; ?>:</h5>
<figure class="pull-right story-img-small">
<?php 
echo $this->Html->image('/images/story/'.$story['Story']['image'],array('alt'=>''));
?>

</figure>

<div class="story-para"><?php echo $story['Story']['story']; ?></div>

</div>
</div>
     <?php }} ?>
</div>
<input type="hidden" id="story_id" value="<?php echo !empty($this->params->query['tag'])?$this->params->query['tag']:'';?>">
<input type="hidden" id="user_address" value="">

<script>
$(function(){
	var a = getParameterByName('tag');
	
	if(a)
	{
		$('html, body').animate({ scrollTop: $('#'+a).offset().top - 100 }, 'slow');
	}
	
});

</script>