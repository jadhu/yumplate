<h2>Stories</h2>

<br />

<?php echo $this->Html->link('Add New Story', array('action' => 'add_story'), array('class' => 'btn btn-default')); ?>

<br />
<br />


<!--div class="row">

    <?php echo $this->Form->create('Story', array('action'=>'stories')); ?>
 
<div class="col-lg-1">
        <?php 
        echo $this->Form->input('active', array('label' => false, 'class' => 'form-control', 'empty' => 'All Status', 'options' => array(1 => 'Active', 0 => 'Not Active'), 'value' =>@$this->params->params['named']['active'])); ?>
    </div>

    <!--<div class="col-lg-1">
        <?php //echo $this->Form->input('brand_id', array('label' => false, 'class' => 'form-control', 'empty' => 'Brand', 'selected' => $all['brand_id'])); ?>
    </div> -->

    <!--div class="col-lg-1">
        <?php echo $this->Form->input('filter', array(
            'label' => false,
            'class' => 'form-control',
            'options' => array(
                'name' => 'Name',
                'description' => 'Description',
                'price' => 'Price',
                'created' => 'Created',
            ),
            'selected' => $all['filter']
        )); ?>

    </div>

    <div class="col-lg-2">
        <?php //echo $this->Form->input('name', array('label' => false, 'id' => false, 'class' => 'form-control', 'value' => '')); ?>

    </div

    <div class="col-lg-4">
        <?php echo $this->Form->button('Search', array('class' => 'btn btn-default')); ?>
        &nbsp; &nbsp;
        <?php echo $this->Html->link('Reset Search', array('controller' => 'stories', 'action' => 'index', 'admin' => true), array('class' => 'btn btn-danger')); ?>

    </div>

    <?php echo $this->Form->end(); ?>

</div-->

<?php //echo $this->element('pagination-counter'); ?>

<?php //echo $this->element('pagination'); ?>

<br />
<div class="table-responsive">
<table class="table  table-bordered">
    <tr>
        <th>SL. N.</th>
        <th> Story Title<?php //echo $this->Paginator->sort('id'); ?></th>
        <th>Story<?php //echo $this->Paginator->sort('name'); ?></th>
        <th>Status<?php //echo $this->Paginator->sort('name'); ?></th>
        <th>Created<?php //echo $this->Paginator->sort('created'); ?></th>
        <th>Modified<?php //echo $this->Paginator->sort('modified'); ?></th>
        <th class="actions">Actions</th>
    </tr>
    <?php $i=1;foreach ($stories as $story): ?>
    <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $story['Story']['title']; ?></td>
        <td><?php echo $story['Story']['story']; ?></td>
        <td><?php  if($story['Story']['active']==1){echo 'Acive';}else{echo 'Inacive';} ?></td>
        <td><?php echo $story['Story']['created']; ?></td>
        <td><?php echo $story['Story']['modified']; ?></td>
        <td class="actions">
           
            <?php 
            echo $this->Html->link('View', array('action' => 'view', $story['Story']['id']), array('class' => 'btn btn-default btn-xs'));  

            echo $this->Html->link('Edit', array('action' => 'add_story', $story['Story']['id']), array('class' => 'btn btn-default btn-xs')); 
            if($story['Story']['active']==1){
               echo $this->Form->postLink('makeInactive', array('action' => 'makestatus',$story['Story']['id'],0), array('class' => 'btn btn-danger btn-xs'));
            }else{
              echo $this->Form->postLink('makeActive', array('action' => 'makestatus', $story['Story']['id'],1), array('class' => 'btn btn-success btn-xs'));
            }
           
            echo $this->Form->postLink('Delete', array('action' => 'delete', $story['Story']['id']), array('class' => 'btn btn-danger btn-xs'), __('Are you sure you want to delete # %s?', $story['Story']['id'])); 
            ?>
        </td>
    </tr>
    <?php $i++;endforeach; ?>
</table>
</div>
<br />

<?php //echo $this->element('pagination-counter'); ?>

<?php //echo $this->element('pagination'); ?>

<br />
<br />
<script>
$(document).ready(function(){


});
</script>