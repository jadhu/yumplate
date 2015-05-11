<?php 
//echo $this->request->data['Product']['order_duration'];
  echo $this->Html->script(array('jquery-timepicker','bootstrap-datepicker'),array('inline'=>false));
  echo $this->Html->css(array('jquery-timepicker','bootstrap-datepicker'),array('inline'=>false));
?>
<h2>Admin Edit Recipe</h2>

<br />

<br />
<script>
function goBack() {
    window.history.back()
}


$(document).ready(function(){

$('#ProductPickTimeFrom').timepicker();
$('#ProductPickTimeTo').timepicker();
$('#ProductOrderTime').timepicker();


});
</script>
<button onclick="goBack()" class="btn btn-primary">Back</button>
<br/>

<div class="row">
    <div class="col-sm-12">

        <?php echo $this->Form->create('Product',array('enctype'=>'multipart/form-data')); 
             echo $this->Form->input('image_name', array('type' => 'hidden','value' => $product['Product']['image']));
         echo $this->Form->input('id'); 
         ?>
        <br />
		<div class="row">
			<div class="col-sm-4">
				<?php echo $this->Form->input('category_id', array('class' => 'form-control')); ?>
			</div>
		
        
		<div class="col-sm-4">
			<?php echo $this->Form->input('user_id',array('class' => 'form-control','label'=>'Chef Name','empty'=>'Select Chef')); ?>
	   </div>
        
		<div class="col-sm-4">
			<?php echo $this->Form->input('name', array('class' => 'form-control','label'=>'Recipe Name')); ?>
		</div>
		</div>
        <br />
        
        <?php echo $this->Form->input('story', array('class' => 'form-control ckeditor')); ?>
        <br />
		<div class="row">
			<div class="col-sm-4">
				<?php echo $this->Form->input('ingredients', array('class' => 'form-control')); ?>
			</div>
			<div class="col-sm-4">
				 <?php echo $this->Form->input('contains', array('class' => 'form-control','label'=>'Recommended')); ?>
			</div>
			<div class="col-sm-4">	
				 <?php echo $this->Form->input('serving', array('class' => 'form-control')); ?>
			</div>
		</div>
				<br />
		<div class="row">
		<div class="col-sm-4">
       <?php echo $this->Html->Image('/images/small/' . $product['Product']['image'], array('alt' => $product['Product']['name'], 'class' => 'image')); ?>
        </div>
        <div class="col-sm-4">
        <?php //echo $this->Form->input('image', array('type' => 'file' , 'class' => 'form-control')); ?>
        <div class="input file"><label for="ProductImage">Image</label><input type="file" id="ProductImage" class="form-control" name="data[Product][image]" style="font-size: 13px;">
        <span style="color:#ff5a00">Image  size  should be 740x510 </span>
        </div>
        </div>
        </div>
		<br />
		<div class="row">
			<div class="col-sm-3">
				<?php echo $this->Form->input('price', array('class' => 'form-control')); ?>
			</div>
			<div class="col-sm-3">
				<label for="Pick Time from">Pick Time From:</label>
				<?php echo $this->Form->input('pick_time_from', array('class' => 'form-control','type'=>'text','autocomplete'=>'off','label'=>false,'div'=>false)); ?>
			</div>       
			<div class="col-sm-3">
				<label for="Pick Time to">Pick Time to:</label>
				<?php echo $this->Form->input('pick_time_to', array('class' => 'form-control','type'=>'text','autocomplete'=>'off','label'=>false,'div'=>false)); ?>
			</div>
      <div class="col-sm-3">
                <?php echo $this->Form->input('order_duration', array('class' => 'form-control','empty'=>'Select Day','class' => 'form-control', 'options' => array('1' => '1 day', '2'=>'2 days','3' => '3 days'))); ?>
            </div>
			<div class="col-sm-3">

				<?php echo $this->Form->input('order_time', array('type'=>'text','class' => 'form-control')); ?>
			</div>
		</div>
        <br />
		<div class="row">
		<div class="col-sm-1">
        <?php echo $this->Form->input('active', array('type' => 'checkbox')); ?>
		</div>
       
		<div class="col-sm-2">
         <?php echo $this->Form->input('featured', array('type' => 'checkbox')); ?>
		 </div>
        
		
		<div class="col-sm-3">
         <?php echo $this->Form->input('day', array('label'=>'Select Day','class' => 'form-control', 'options' => array('sunday' => 'sunday', 'monday'=>'monday','tuesday' => 'tuesday','wednesday' => 'wednesday','thursday' => 'thursday','friday' => 'friday','saturday' => 'saturday'),'multiple'=>!empty($this->request->data['Product']['avail_multiple_day'])?true:false)); ?>
		 </div>
         <div class="col-sm-3">
         <?php echo $this->Form->input('avail_multiple_day', array('type' => 'checkbox','label'=>'Available multiple days')); ?>
         </div>
		 </div>
         
         <br />
        <?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
        <?php echo $this->Form->end(); ?>

        <br />
        <br />

    </div>
</div>

<?php echo $this->Html->script('ckeditor/ckeditor', array('inline' => false)); ?>

<script type="text/javascript">

    var basePath = "<?php echo Router::url('/'); ?>";

    CKEDITOR.replace('ProductStory', {
        filebrowserBrowseUrl : basePath + 'js/kcfinder/browse.php?type=files',
        filebrowserImageBrowseUrl : basePath + 'js/kcfinder/browse.php?type=images',
        filebrowserFlashBrowseUrl : basePath + 'js/kcfinder/browse.php?type=flash',
        filebrowserUploadUrl : basePath + 'js/kcfinder/upload.php?type=files',
        filebrowserImageUploadUrl : basePath + 'js/kcfinder/upload.php?type=images',
        filebrowserFlashUploadUrl : basePath + 'js/kcfinder/upload.php?type=flash'
    });


$(document).ready(function(){
  $('#ProductAvailMultipleDay').click(function(){
        if($(this).is(':checked')){
          $('#ProductDay').attr('multiple',true);
          $('#ProductDay').attr('name','data[Product][day][]');
        }else{
          $('#ProductDay').attr('multiple',false);
          $('#ProductDay').attr('name','data[Product][day]');
        }
  });
});

</script>


<br />
<br />
<!--
<h4>Product Modification:</h4>

<?php echo $this->Html->link('Add new Productmods', array('controller' => 'productmods', 'action' => 'add', $product['Product']['id']), array('class' => 'btn btn-default')); ?>

<?php if(!empty($productmods)): ?>

<table class="table-striped table-bordered table-condensed table-hover">
    <tr>
        <th>id</th>
        <th>product_id</th>
        <th>sku</th>
        <th>name</th>
        <th>change</th>
        <th>active</th>
        <th>created</th>
        <th>modified</th>
        <th>action</th>
    </tr>
    <?php foreach ($productmods as $productmod): ?>
    <tr>
        <td><?php echo h($productmod['Productmod']['id']); ?></td>
        <td><?php echo h($productmod['Productmod']['product_id']); ?></td>
        <td><?php echo h($productmod['Productmod']['sku']); ?></td>
        <td><?php echo h($productmod['Productmod']['name']); ?></td>
        <td><?php echo h($productmod['Productmod']['price']); ?></td>
        <td><?php echo h($productmod['Productmod']['active']); ?></td>
        <td><?php echo h($productmod['Productmod']['created']); ?></td>
        <td><?php echo h($productmod['Productmod']['modified']); ?></td>
        <td class="actions">
            <?php echo $this->Html->link('View', array('controller' => 'productmods', 'action' => 'view', $productmod['Productmod']['id']), array('class' => 'btn btn-default btn-xs')); ?>
            <?php echo $this->Html->link('Edit', array('controller' => 'productmods', 'action' => 'edit', $productmod['Productmod']['id']), array('class' => 'btn btn-default btn-xs')); ?>
            <?php echo $this->Form->postLink('Delete', array('controller' => 'productmods', 'action' => 'delete', $productmod['Productmod']['id']), array('class' => 'btn btn-danger btn-xs'), __('Are you sure you want to delete # %s?', $productmod['Productmod']['id'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php endif; ?>
-->

<br />
<br />