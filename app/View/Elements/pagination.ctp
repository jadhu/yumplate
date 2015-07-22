
<!--div class="paging">

    <?php echo $this->Paginator->first('<< first', array(), null, array('class' => 'first disabled')); ?>

    <?php echo $this->Paginator->prev('< previous', array(), null, array('class' => 'prev disabled')); ?>

    <?php echo $this->Paginator->numbers(array('separator' => ' ')); ?>

    <?php echo $this->Paginator->next('next >', array(), null, array('class' => 'next disabled')); ?>

    <?php echo $this->Paginator->last('last >>', array(), null, array('class' => 'last disabled')); ?>

</div-->
<?php 
$model='';
  if(!empty($this->paginator->request->params['paging'])){
  	 foreach ($this->paginator->request->params['paging'] as $key => $value) {
  	   $model=$key;
  	 }
  }

if($this->paginator->request->params['paging'][$model]['pageCount']>1){?>
			<div id="paginationDiv" class="col-md-6 pull-right">
			<ul class=" pagination pull-right">
			<?php
			echo $this->Paginator->prev('Prev', array(
			'tag' => 'li', 'label' => false),null, array( 'class' => 'disabled insert-anchor', 'tag' => 'a'));
			?>
			<?php
			echo $this->Paginator->numbers(array(
			'tag' => "li",'separator' => null,'currentClass' => 'active', 'currentTag' => 'a' ));
			?>
			<?php
			echo $this->Paginator->next(__('Next'), array(
			'tag' => 'li','label' => false,'class' => null), null, array( 'class' => 'disabled 	insert-anchor', 'tag' => 'a' ));
			?>
			</ul>
			</div>
			<?php }?>

