<?php echo $this->Html->css(array('bootstrap-editable.css', '/select2/select2.css'), 'stylesheet', array('inline' => false)); ?>
<?php echo $this->Html->script(array('bootstrap-editable.js', '/select2/select2.js'), array('inline' => false)); ?>

<script>

$(document).ready(function() {

    $('.category').editable({
        type: 'select',
        name: 'category_id',
        url: '<?php echo $this->webroot; ?>admin/products/editable',
        title: 'Category',
        source: <?php echo json_encode($categorieseditable); ?>,
        placement: 'right',
    });

    $('.brand').editable({
        type: 'select',
        name: 'brand_id',
        url: '<?php echo $this->webroot; ?>admin/products/editable',
        title: 'Brand',
        source: <?php echo json_encode($brandseditable); ?>,
        placement: 'right',
    });

    $('.name').editable({
        type: 'text',
        name: 'name',
        url: '<?php echo $this->webroot; ?>admin/products/editable',
        title: 'Name',
        placement: 'right',
    });

    $('.description').editable({
        type: 'textarea',
        name: 'description',
        url: '<?php echo $this->webroot; ?>admin/products/editable',
        title: 'Description',
        placement: 'right',
    });

    $('.price').editable({
        type: 'text',
        name: 'price',
        url: '<?php echo $this->webroot; ?>admin/products/editable',
        title: 'Price',
        placement: 'left',
    });

    $('.weight').editable({
        type: 'text',
        name: 'weight',
        url: '<?php echo $this->webroot; ?>admin/products/editable',
        title: 'Weight',
        placement: 'left',
    });

    $('.tags').editable({
        type: 'select2',
        name: 'tags',
        url: '<?php echo $this->webroot; ?>admin/products/tagschanger',
        title: 'Tags',
        placement: 'left',
        source: [
            <?php foreach ($tags as $tag): ?>
            {id: '<?php echo $tag["Tag"]["name"]; ?>', text: '<?php echo $tag["Tag"]["name"]; ?>'},
            <?php endforeach; ?>
        ],
        select2: {
            multiple: true,
            allowClear: true,
            width: 300
        }
    });

});
</script>
<h2>Recipes</h2>

<?php echo $this->Html->link('Add New Recipe', array('action' => 'add'), array('class' => 'btn btn-default')); ?>
<br />
<br />
<div class="row">

    <?php echo $this->Form->create('Product', array('action'=>'admin_searchRedirect')); ?>
    <?php echo $this->Form->hidden('search', array('value' => 1)); ?>

    <div class="col-lg-2 col-sm-3">
        <?php echo $this->Form->input('active', array('label' => false, 'class' => 'form-control', 'empty' => 'All Status', 'options' => array(1 => 'Active', 0 => 'Not Active'),'selected'=>isset($this->params->params['named']['status'])?$this->params->params['named']['status']:'')); ?>
    </div>
 <div class="col-lg-2 col-sm-3">
<?php echo $this->Form->input('recipe_name', array('label' => false, 'id' => false, 'class' => 'form-control', 'value' => !empty($this->params->params['named']['recipe'])?$this->params->params['named']['recipe']:'','placeholder'=>'Recipe name')); ?>

    </div>
     <div class="col-lg-2 col-sm-3">
<?php echo $this->Form->input('cook_name', array('label' => false, 'id' => false, 'class' => 'form-control', 'value' => !empty($this->params->params['named']['cook'])?$this->params->params['named']['cook']:'','placeholder'=>'Cook name')); ?>

    </div>
        <div class="col-lg-2 col-sm-3">
<?php echo $this->Form->input('location', array('label' => false, 'id' => false, 'class' => 'form-control', 'value' =>!empty($this->params->params['named']['location'])?$this->params->params['named']['location']:'','placeholder'=>'Location')); ?>

    </div>

    <div class="col-lg-4 col-sm-3">
        <?php echo $this->Form->button('Search', array('class' => 'btn btn-default')); ?>
        &nbsp; &nbsp;
<?php 
 if(isset($this->params->params['named']['status'])||isset($this->params->params['named']['recipe'])||isset($this->params->params['named']['cook'])||isset($this->params->params['named']['location'])){
 
        echo $this->Html->link('Reset Search', array('controller' => 'products', 'action' => 'index', 'admin' => true), array('class' => 'btn btn-danger'));
  }
        ?>

    </div>

    <?php echo $this->Form->end(); ?>

</div>

<br />

<?php //echo $this->element('pagination-counter'); ?>

<?php //echo $this->element('pagination'); ?>

<br />
<div class="table-responsive tabls">
<table class="table table-bordered">
    <tr>
        <th><?php echo $this->Paginator->sort('image'); ?></th>
        <th><?php echo $this->Paginator->sort('category_id'); ?></th>
        <th><?php echo $this->Paginator->sort('name'); ?></th>
        <!--th><?php echo $this->Paginator->sort('slug'); ?></th>
        <th><?php echo $this->Paginator->sort('description'); ?></th-->
        <!--th><?php echo $this->Paginator->sort('image'); ?></th-->
        <th><?php echo $this->Paginator->sort('price'); ?></th>
        <th><?php echo $this->Paginator->sort('tags'); ?></th>
        <th><?php echo $this->Paginator->sort('views'); ?></th>
        <th><?php echo $this->Paginator->sort('cook_name'); ?></th>
        <th><?php echo $this->Paginator->sort('active'); ?></th>
        <th><?php echo $this->Paginator->sort('featured'); ?></th>
        <th><?php echo $this->Paginator->sort('available'); ?></th>
        <th><?php echo $this->Paginator->sort('created'); ?></th>
        <th><?php echo $this->Paginator->sort('modified'); ?></th>
        <th class="actions">Actions</th>
    </tr>
    <?php  if(!empty($products)){foreach ($products as $product){ ?>
    <tr>
        <td><?php echo $this->Html->Image('/images/small/' . $product['Product']['image'], array('width' =>'90px;', 'height' =>'90px;', 'alt' => $product['Product']['image'], 'class' => 'image')); ?></td>
        <td><span class="category" data-value="<?php echo $product['Category']['id']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Category']['name']; ?></span></td>
        <td><span class="name" data-value="<?php echo $product['Product']['name']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['name']; ?></span></td>
        <!--td><?php echo h($product['Product']['slug']); ?></td>
        <td><span class="description" data-value="<?php echo $product['Product']['description']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['description']; ?></span></td>
        <td><?php echo h($product['Product']['image']); ?></td-->
        <td><span class="price" data-value="<?php echo $product['Product']['price']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['price']; ?></span></td>
        <td><span class="tags" data-value="<?php echo $product['Product']['tags']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['tags']; ?></span></td>
        <td><?php echo h($product['Product']['views']); ?></td>
        <td><?php echo h($product['User']['first_name']).h($product['User']['last_name']); ?></td>

        <td><?php echo $this->Html->link($this->Html->image('icon_' . $product['Product']['active'] . '.png'), array('controller' => 'products', 'action' => 'switch', 'active', $product['Product']['id']), array('class' => 'status', 'escape' => false)); ?></td>
        <td><?php echo $this->Html->image('icon_' . $product['Product']['featured'] . '.png'); ?></td>
        <td><?php echo h($product['Product']['day']); ?></td>
        <td><?php echo h($product['Product']['created']); ?></td>
        <td><?php echo h($product['Product']['modified']); ?></td>
        <td class="actions">
            <?php echo $this->Html->link('View', array('action' => 'view', $product['Product']['id']), array('class' => 'btn btn-default btn-xs')); ?>
            <?php echo $this->Html->link('Tags', array('action' => 'tags', $product['Product']['id']), array('class' => 'btn btn-default btn-xs')); ?>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $product['Product']['id']), array('class' => 'btn btn-default btn-xs')); ?>
            <?php echo $this->Form->postLink('Delete', array('action' => 'delete', $product['Product']['id']), array('class' => 'btn btn-danger btn-xs'), __('Are you sure you want to delete  %s?', $product['Product']['name'])); ?>
        </td>
    </tr>
    <?php }}else{
         echo '<tr><td class="text:center;">There is no results </td></tr>';
        } ?>
</table>
</div>
<br />

<?php //echo $this->element('pagination-counter'); ?>

<?php echo $this->element('pagination'); ?>

<br />
<br />
<script >
    $(document).ready(function(){

    $('#ProductActive').change(function(){
        $('#ProductAdminSearchRedirectForm').submit();
    });

    });

</script>



