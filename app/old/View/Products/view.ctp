<?php 
//pr($product);
 //echo $this->Html->script(array('addtocart.js'), array('inline' => false)); 
 //echo $this->Html->css(array('toolitup-jrate',), array('inline' => false));
?>

<?php
//$this->Html->addCrumb($product['Brand']['name'], array('controller' => 'brands', 'action' => 'view', 'slug' => $product['Brand']['slug']));
$this->Html->addCrumb($product['Category']['name'], array('controller' => 'categories', 'action' => 'view', 'slug' => $product['Category']['slug']));
$this->Html->addCrumb($product['Product']['name']);
?>



<script>
$(document).ready(function() {

    $('#modselector').change(function(){
        $('#productprice').html($(this).find(':selected').data('price'));
        $('#modselected').val($(this).find(':selected').val());
    });

});
</script>
<div class="main landing-page">
<script>
function goBack() {
    window.history.back()
}
</script>
<button onclick="goBack()" class="btn btn-primary">Back</button>
<br/>

<h1><?php echo $product['Product']['name']; ?></h1>

<div class="row">

    <div class="landing-page-img col-sm-4">  
    <?php echo $this->Html->Image('/images/large/' . $product['Product']['image'], array('alt' => $product['Product']['name'], 'class' => 'landing-img img-thumbnail img-responsive')); ?>
    </div>

    <div class="col col-sm-8 view-product">

        <h3><?php echo $product['Product']['name']; ?></h3>

       <h4> $ <span id="productprice"><?php echo $product['Product']['price']; ?></span> 
      </h4>

        

        <?php //echo $this->Form->create(NULL, array('url' => array('controller' => 'shop', 'action' => 'add'))); ?>
        <?php //echo $this->Form->input('id', array('type' => 'hidden', 'value' => $product['Product']['id'])); ?>

        <?php if(!empty($productmodshtml)):?>

            <div class="row">
            <div class="col-sm-5">
            <span style="font-weight:bold">Product Options:</span> <?php echo $productmodshtml;?>
            </div>
            </div>
            
            <input type="hidden" id="modselected" value="" />

        <?php endif;?>
        
         

      <p>
      <b>Story:</b>
      <?php echo !empty($product['Product']['story'])?$product['Product']['story']:'No story';?>
      </p>
       
      <p> 
      <b>Ingredients:</b>
      <?php echo !empty($product['Product']['ingredients'])?$product['Product']['ingredients']:'No ingredients';?>
      </p>
      <p> 
      <b>Conatins:</b>
      <?php echo !empty($product['Product']['contains'])?$product['Product']['contains']:'No contains';?>
      </p>
      <p> 
      <b>Serving:</b>
      <?php echo !empty($product['Product']['serving'])?$product['Product']['serving']:'No serving';?>
      </p

       <p> 
       <b>Tags:</b>
        <?php echo !empty($product['Product']['tags'])?$product['Product']['tags']:'No tags';?>
		    </p>
        
		<p>
        <b>Category:</b> <?php echo $product['Category']['name'];//$this->Html->link($product['Category']['name'], array('controller' => 'categories', 'action' => 'view', 'slug' => $product['Category']['slug']), array('class' => 'categories-link')); ?>
		</p>
       
	  <div class="add-section">
      <!--textarea placeholder="Special comment for meal" class="special_comment" ></textarea--> 
      <button class="pull-right btn become-btn add_meal_cart">
        + Add to Cart
        </button> 
    </div>
	<div class="frst-comnt-usr-box" id="content"> 
         <h3>Add Review and Comments </h3>
         <div class="msgbox">
         </div>

         <div class="meal-ratings">
		 <div class="row">
		 <div class="col-sm-6">
        <label><b>Value :</b></label>
          <div class="starRating pull-right">
          <div>
          <div>
          <div>
            <div>
              <input id="rating1" type="radio" name="val_rating" value="1">
              <label for="rating1"><span>1</span></label>
            </div>
            <input id="rating2" type="radio" name="val_rating" value="2">
            <label for="rating2"><span>2</span></label>
          </div>
          <input id="rating3" type="radio" name="val_rating" value="3">
          <label for="rating3"><span>3</span></label>
          </div>
          <input id="rating4" type="radio" name="val_rating" value="4">
          <label for="rating4"><span>4</span></label>
          </div>
          <input id="rating5" type="radio" name="val_rating" value="5">
          <label for="rating5"><span>5</span></label>
          </div>
		  <br/>
          <label><b>On time :</b></label>
          <div class="starRating pull-right">
          <div>
          <div>
          <div>
          <div>
            <input id="rating1" type="radio" name="ontime_rating" value="1">
            <label for="rating1"><span>1</span></label>
          </div>
          <input id="rating2" type="radio" name="ontime_rating" value="2">
          <label for="rating2"><span>2</span></label>
          </div>
          <input id="rating3" type="radio" name="ontime_rating" value="3">
          <label for="rating3"><span>3</span></label>
          </div>
          <input id="rating4" type="radio" name="ontime_rating" value="4">
          <label for="rating4"><span>4</span></label>
          </div>
          <input id="rating5" type="radio" name="ontime_rating" value="5">
          <label for="rating5"><span>5</span></label>
          </div>
		  </br/>
          <label><b>Easy to find :</b></label>
          <div class="starRating pull-right">
          <div>
          <div>
          <div>
          <div>
            <input id="rating1" type="radio" name="easyfind_rating" value="1">
            <label for="rating1"><span>1</span></label>
          </div>
          <input id="rating2" type="radio" name="easyfind_rating" value="2">
          <label for="rating2"><span>2</span></label>
          </div>
          <input id="rating3" type="radio" name="easyfind_rating" value="3">
          <label for="rating3"><span>3</span></label>
          </div>
          <input id="rating4" type="radio" name="easyfind_rating" value="4">
          <label for="rating4"><span>4</span></label>
          </div>
          <input id="rating5" type="radio" name="easyfind_rating" value="5">
          <label for="rating5"><span>5</span></label>
          </div>
		  </div>
		  </div>
         </div>
        <div class="txt-area">
        <input type="hidden" value="<?php echo $this->Html->url('/',true);?>" id="page_url">
        <input type="hidden" value="<?php echo $product['Product']['id']; ?>" id="product_id">
        <input type="hidden" value="<?php echo $product['Product']['user_id']; ?>" id="cook_id">
        <input type="hidden" value="<?php echo $this->Session->read('Auth.User.id'); ?>" id="loggeduserId">
        <textarea class="form-control comment_sec" rows="4"></textarea>
		<br/>
        <input type="button" value="Submit" id="sub_comment" class="btn btn-danger pull-right" data-loading-text="Wait...">
        </div>
        </div>   
    </div>
 
 
</div>
</div>
<br />
<br />
<div class="text-center">All sales are final upon checkout</div>
<script>

$(document).ready(function(){

$("input[name=val_rating][value=1]").attr('checked', 'checked'); 
$("input[name=ontime_rating][value=1]").attr('checked', 'checked'); 
$("input[name=easyfind_rating][value=1]").attr('checked', 'checked'); 




 $('#sub_comment').click(function(){
      var loginUser=$('#loggeduserId').val();
      var pageUrl=$('#page_url').val();
      var productId=$('#product_id').val();
      var cookId=$('#cook_id').val();
      var comment=$('.comment_sec').val();
    
      var val_rating;
      var ontime_rating;
      var easyfind_rating;


      if($("input:radio[name=val_rating]:checked").val()){
       val_rating=$("input:radio[name=val_rating]:checked").val();
      }else{
        val_rating=0;
      }

      if($("input:radio[name=ontime_rating]:checked").val()){
       ontime_rating=$("input:radio[name=ontime_rating]:checked").val();
      }else{
        ontime_rating=0;
      }

      if($("input:radio[name=easyfind_rating]:checked").val()){
       easyfind_rating=$("input:radio[name=easyfind_rating]:checked").val();
      }else{
        easyfind_rating=0;
      }
  
    if(loginUser=='' || loginUser==null){
    $('#user_login').trigger('click');
    return false;
    }

    if(comment=='' || comment==null){
            $('.msgbox').html('');
            $('.msgbox').show();
            $('.msgbox').html('<div class="alert alert-danger">Please write comment</div>').fadeOut( 3000);
        return false;
    }

 $.ajax({
      'url':pageUrl+'ajax/addReview',
      'type':'POST',
       'dataType':'json',
       'data':{'userId':loginUser,'productId':productId,'cookId':cookId,'comment':comment,'val_rating':val_rating,'ontime_rating':ontime_rating,'easyfind_rating':easyfind_rating},
       beforeSend:function(){
        $('.submit-btn').button('loading');
       },
       success:function(data){
        $('.msgbox').html('');
        $('.submit-btn').button('reset');
        $('.comment_sec').val('');
        $('.msgbox').show();
        if(data.type=='success'){
         $('.msgbox').html('<div class="alert alert-success">'+data.msg+'</div>').fadeOut( 3000);
        }else{
          $('.msgbox').html('<div class="alert alert-danger">Comment does not save</div>').fadeOut( 3000);  
        }
        

       },

 });

});

});




    
</script>