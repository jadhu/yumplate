<?php 
//pr($meal_day);
 //echo $this->Html->script(array('social_plus.gs'), array('inline' => false)); 
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
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.3&appId=330457023826586";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


function goBack() {
    window.history.back()
}
</script>
<div class="main landing-page">
<button onclick="goBack()" class="btn btn-primary">Back</button>
<br/>

<h1 class="product_name"><?php echo $product['Product']['name']; ?></h1>

<div class="row">

    <div class="landing-page-img col-sm-4">  
    <?php echo $this->Html->Image('/images/original/' . $product['Product']['image'], array('alt' => $product['Product']['name'], 'class' => 'landing-img img-thumbnail img-responsive')); ?>
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
        
         

      <p class="product_story">
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
       
         <input type="hidden" id="product_story" value="<?php echo strip_tags(@$product['Product']['story']);?>">
         <input type="hidden" id="image_name" value="<?php echo @$product['Product']['image'];?>">
	  <div class="add-section">
      <!--textarea placeholder="Special comment for meal" class="special_comment" ></textarea--> 
    <button class="pull-right btn become-btn add_meal_cart" data-order-day="<?php echo !empty($meal_day)?$meal_day:$product['Product']['day'];?>"  >
        + Add to Cart
        </button> 
     <div class="adright"> 

      <?php  
      $u_agent = $_SERVER['HTTP_USER_AGENT'];
      if(preg_match('/MSIE/i',$u_agent))
      { ?>
      <fb:share-button type="button"  class="front" href="<?php echo SITE_URL; ?>product/<?php echo $product['Product']['slug'];?>"></fb:share-button>
      <?php } else{ ?>
     <div class="fb-share-button front" title="Share" data-href="<?php echo SITE_URL; ?>product/<?php echo $product['Product']['slug'];?>"  data-layout="button_count"></div>
     <?php } ?>

      <a href="#" class="tw-share"><?php echo $this->Html->image('/images/imgotweet1.jpg',array('class'=>'icon1'));?></a>
      </div>
       
      <!--a href="#" class="fb-share"><?php echo $this->Html->image('/images/imgoface1.jpg',array('class'=>'icon1'));?></a--> 
         

      
    </div>
	<div class="frst-comnt-usr-box" id="content"> 
         <h3 class="heading-mini-sm">Add Review and Comments </h3>
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
        <input type="button" value="Submit" id="sub_comment" class="btn btn-danger pull-right submit-btn" data-loading-text="Wait..." >
        </div>
        </div>   
    </div>
 
 
</div>
</div>
<br />
<br />

<?php 

echo $this->Form->create(null,array('action'=>''));
echo $this->Form->input('imageUrl',array('type'=>'hidden','id'=>'image_url','value'=>''));
echo $this->Form->input('pageLink',array('type'=>'hidden','id'=>'page_link','value'=>SITE_URL.'u/'.$product['User']['username']));
echo $this->Form->input('image_name',array('type'=>'hidden','id'=>'image_nam','value'=>''));
echo $this->Form->input('price',array('type'=>'hidden','id'=>'prod_price','value'=>''));
echo $this->Form->input('tweetText',array('type'=>'hidden','id'=>'tweet_text','value'=>''));
echo $this->Form->end();
?>
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
  //comment=''
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


//for facebook and twitter share 



 window.fbAsyncInit = function() {
    FB.init({
      appId      : '812553815506934',
      xfbml      : true,
      version    : 'v2.3'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));


$(document).ready(function() {
    var pageUrl=$('#page_url').val();
    $('.fb-share').click(function() {
     
      var price='$ '+$('#productprice').text();
      var name=$('.product_name').html()+' Price: '+price;
      var story=$('#product_story').val();
      
      var image='http://beta.yumplate.com/images/original/<?php echo $product['Product']['image'];?>';

        FB.ui({
            method: 'feed',
            name: name,
            link: $('#page_link').val(),
            picture: image,
            description:story
        });
    });

 $('.tw-share').click(function() {
     
      var price=$('#productprice').text();
      var name=$('.product_name').html();
      var story=$('#product_story').val()+'<p> Price:</p>'+price;

      var imageUrl='http://beta.yumplate.com/images/original/'+$('#image_name').val();

      var tweetText = story;
      $('#image_url').val(imageUrl);
      $('#image_nam').val(name);
      $('#prod_price').val(price);
      $('#tweet_text').val(tweetText);
      $('#ProductForm').attr('action',pageUrl+'products/image_upload')
      $('#ProductForm').submit();

      
    });

});
    


</script>