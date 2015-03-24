<h2>Categories</h2>

<br />

<?php echo $this->Html->link('Add New Category', array('action' => 'add'), array('class' => 'btn btn-default')); ?>

<br />
<br />
<div class="row">

    <?php echo $this->Form->create('Category', array('action'=>'searchRedirect')); ?>
    <?php //echo $this->Form->hidden('search', array('value' => 1)); ?>

    <div class="col-lg-2 col-sm-3">
        <?php 
        echo $this->Form->input('active', array('label' => false, 'class' => 'form-control', 'empty' => 'All Status', 'options' => array(1 => 'Active', 0 => 'Not Active'),'selected'=>isset($this->params->params['named']['status'])?$this->params->params['named']['status']:'')); ?>
    </div>
    <div class="col-lg-2 col-sm-3">
        <?php echo $this->Form->input('category_name', array('label' => false, 'id' => false, 'class' => 'form-control','placeholder'=>'Category name','value'=>!empty($this->params->params['named']['category'])?$this->params->params['named']['category']:'')); ?>

    </div>
    <div class="col-lg-2 col-sm-3">
        <?php echo $this->Form->input('cook_name', array('label' => false, 'id' => false, 'class' => 'form-control','placeholder'=>'Cook name','value'=>!empty($this->params->params['named']['cook'])?$this->params->params['named']['cook']:'')); ?>

    </div>

    <div class="col-lg-4 col-sm-3">
        <?php echo $this->Form->button('Search', array('class' => 'btn btn-default')); ?>
        &nbsp; &nbsp;
        <?php 
        if(isset($this->params->params['named']['status'])||!empty($this->params->params['named']['cook'])||!empty($this->params->params['named']['category'])){
       echo $this->Html->link('Reset Search', array('controller' => 'categories', 'action' => 'index', 'admin' => true), array('class' => 'btn btn-danger')); 
       }
        ?>

    </div>

    <?php echo $this->Form->end(); ?>

</div>
<div class="table-responsive tables">
<table class="table  table-bordered">
    <tr>
        <th><?php echo $this->Paginator->sort('id'); ?></th>
        <th><?php echo $this->Paginator->sort('name'); ?></th>
        <th><?php echo $this->Paginator->sort('slug'); ?></th>
        <th><?php echo $this->Paginator->sort('description'); ?></th>
         <th><?php echo $this->Paginator->sort('active','Status'); ?></th>
        <th><?php echo $this->Paginator->sort('created'); ?></th>
        <th><?php echo $this->Paginator->sort('modified'); ?></th>
        <th class="actions">Actions</th>
    </tr>
    <?php foreach ($categories as $category): ?>
        <tr>
            <td><?php echo h($category['Category']['id']); ?></td>
            <!--<td>
                <?php //echo $this->Html->link($category['ParentCategory']['name'], array('controller' => 'categories', 'action' => 'view', $category['ParentCategory']['id'])); ?>
            </td>-->
            <td><?php echo h($category['Category']['name']); ?></td>
            <td><?php echo h($category['Category']['slug']); ?></td>
            <td><?php echo h($category['Category']['description']); ?></td>
            <td><?php echo ($category['Category']['active']==1)?'Acive':'Nonactive'; ?></td>
            <td><?php echo h($category['Category']['created']); ?></td>
            <td><?php echo h($category['Category']['modified']); ?></td>
            <td class="actions">
                <?php echo $this->Html->link('View', array('action' => 'view', $category['Category']['id']), array('class' => 'btn btn-default btn-xs')); ?>
                <?php echo $this->Html->link('Edit', array('action' => 'edit', $category['Category']['id']), array('class' => 'btn btn-default btn-xs')); ?>
                <?php echo $this->Form->postLink('Delete', array('action' => 'delete', $category['Category']['id']), array('class' => 'btn btn-danger'), __('Are you sure you want to delete # %s?', $category['Category']['id'])); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</div>

<br />

<?php echo $this->element('pagination-counter'); ?>

<?php echo $this->element('pagination'); ?>

<br />
<br />

<!--h3>Actions</h3-->



<?php //echo $this->Tree->generate($categoriestree, array('element' => 'categories/tree_item', 'class' => 'categorytree', 'id' => 'categorytree')); ?>

<br />
<br />

<script >
    $(document).ready(function(){

    $('#CategoryActive').change(function(){
        $('#CategorySearchRedirectForm').submit();
    });

    });

</script>