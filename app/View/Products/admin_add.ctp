<?php 
  echo $this->Html->script(array('jquery-timepicker','bootstrap-datepicker'),array('inline'=>false));
  echo $this->Html->css(array('jquery-timepicker','bootstrap-datepicker'),array('inline'=>false));
?>
<h2>Admin Add Recipe</h2>

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
    

        <?php echo $this->Form->create('Product',array('enctype'=>'multipart/form-data')); ?>
    
    <div class="col-sm-4">
        <?php echo $this->Form->input('category_id', array('class' => 'form-control')); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $this->Form->input('user_id',array('class' => 'form-control','label'=>'Cook Name','empty'=>'Select Cook')); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $this->Form->input('name', array('class' => 'form-control','label'=>'Recipe Name')); ?>
       
    </div>
    <div class="col-sm-4">
        <?php echo $this->Form->input('story', array('class' => 'form-control')); ?>
    </div>
    <div class="col-sm-4">
         <?php echo $this->Form->input('ingredients', array('class' => 'form-control')); ?>
    </div>
    <div class="col-sm-4">
         <?php echo $this->Form->input('contains', array('class' => 'form-control')); ?>
    </div>
    <div class="col-sm-12">
         <?php echo $this->Form->input('serving', array('class' => 'form-control')); ?>
    </div>
    <div class="col-sm-4">
        <?php //echo $this->Form->input('image', array('class' => 'form-control','type'=>'file')); ?>
        <div class="input file"><label for="ProductImage">Image</label><input type="file" id="ProductImage" class="form-control" name="data[Product][image]" style="font-size: 13px;">
        <span style="color:#ff5a00">Image  size  should be 740x510 </span>
        </div>
    </div>
    <div class="col-sm-4">
        <?php echo $this->Form->input('price', array('class' => 'form-control')); ?>
    </div>
    <div class="col-sm-4">
        <div class="input number required">
        <label for="ProductPrice">Pick Time From:</label>
      <?php echo $this->Form->input('pick_time_from', array('class' => 'form-control','type'=>'text','autocomplete'=>'off','label'=>false,'div'=>false)); ?>
        </div>
    </div>
    <div class="col-sm-4">
            <div class="input number required">
                <label for="Pick Time to">Pick Time to:</label>
                <?php echo $this->Form->input('pick_time_to', array('class' => 'form-control','type'=>'text','autocomplete'=>'off','label'=>false,'div'=>false)); ?>
            </div>
    </div>
    <div class="col-sm-4">
            <div class="input number required">
                <?php echo $this->Form->input('order_time', array('type'=>'text','class' => 'form-control')); ?>
            </div>
      
        <?php //echo $this->Form->input('weight', array('class' => 'form-control')); ?>
    </div>
    <div class="col-sm-2">
        <?php echo $this->Form->input('active', array('type' => 'checkbox')); ?>
    </div>
    <div class="col-sm-2">
        <?php echo $this->Form->input('featured', array('type' => 'checkbox')); ?>
    </div>
    <div class="col-sm-4">
         <?php echo $this->Form->input('day', array('label'=>'Select Day','class' => 'form-control', 'options' => array('sunday' => 'sunday', 'monday'=>'monday','tuesday' => 'tuesday','wednesday' => 'wednesday','thursday' => 'thursday','friday' => 'friday','saturday' => 'saturday'))); ?>
    </div>
    <div class="col-sm-2">
         <?php echo $this->Form->input('avail_multiple_day', array('type' => 'checkbox','label'=>'Available multiple days')); ?>
         </div>
    <div class="col-sm-12">
        <?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
        <?php echo $this->Form->end(); ?>

        <br />
        <br />

    </div>
</div>
<script type="text/javascript">

   /* var basePath = "<?php echo Router::url('/'); ?>";

    CKEDITOR.replace('ProductDescription', {
        filebrowserBrowseUrl : basePath + 'js/kcfinder/browse.php?type=files',
        filebrowserImageBrowseUrl : basePath + 'js/kcfinder/browse.php?type=images',
        filebrowserFlashBrowseUrl : basePath + 'js/kcfinder/browse.php?type=flash',
        filebrowserUploadUrl : basePath + 'js/kcfinder/upload.php?type=files',
        filebrowserImageUploadUrl : basePath + 'js/kcfinder/upload.php?type=images',
        filebrowserFlashUploadUrl : basePath + 'js/kcfinder/upload.php?type=flash'
    });*/


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
