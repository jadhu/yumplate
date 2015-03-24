<div class="main-explore exp-yum">
	<h2 class="order-heading">Explore Yumplate</h2>
	
	<h3 class="yumplate-header">Search results for <?php echo !empty($this->params->query['keywords'])?$this->params->query['keywords']:'';?></h3>
	<?php 
	if(!empty($products)){
		foreach ($products as $key => $value) {?>
    <div class="row">
		<div class="col-sm-3">
		<?php 
		  echo $this->Html->image('/images/small/'.$value['Product']['image'],
									array(
									'alt'=>'',
									'class'=>'explore-img user-profile',
									'data-user-id'=>$value['User']['username'],'data-product'=>$value['Product']['name'],
									'style'=>'cursor:pointer;'
									));

		  ?>
			
		</div>
		<div class="col-sm-9">
			<h4><?php echo $value['Product']['name'];?></h4>
			<p><?php echo $value['Product']['story'];?></p>
			<p>
				Available: <?php echo $value['Product']['day'];?>
			</p>
			<p>
				<?php echo $value['User']['city'];?>, <?php echo $value['User']['country'];?>
			</p>
		</div>
	</div>
	
	<hr/>
	
		<?php }}else{
			echo '<p class="note-msg"> Your search returns no results. </p>';
			}?>
</div>