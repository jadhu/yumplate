<div class="main-explore exp-yum">
	<h2 class="order-heading">Explore Yumplate</h2>
	
	<h3 class="yumplate-header">Search results for <?php echo !empty($this->params->query['keywords'])?$this->params->query['keywords']:'';?></h3>
	<?php 
	if(!empty($products)){
		foreach ($products as $key => $value) {?>
    <div class="row">
		<div class="col-sm-4 explore-yum-img">
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
		<div class="col-sm-8">
			<h4><?php echo $value['Product']['name'];?></h4>
			<p><?php echo $value['Product']['story'];?></p>
			<p>
				Available On: <?php echo ucfirst($value['Product']['day']);?>
			</p>
			<p>
				Place : <?php echo $value['User']['city'];?>, <?php echo $value['User']['country'];?>
			</p>
		</div>
	</div>
	
	<hr/>
	
		<?php }
       echo $this->element('pagination'); 
	}else{  echo '<p class="note-msg"> Your search returns no results. <br /><br /><br /><a href="http://beta.yumplate.com/products/ExploreYum/keywords=" class="btn btn-primary">May be suggust</a> </p>';
			}?>
</div>