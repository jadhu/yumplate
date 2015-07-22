<?php echo $this->Html->css(array('bootstrap-editable.css', '/select2/select2.css'), 'stylesheet', array('inline' => false)); ?>
<?php echo $this->Html->script(array('bootstrap-editable.js', '/select2/select2.js'), array('inline' => false)); 

//pr($cart_meals);
?>
<script >
    $(document).ready(function(){
      $('.comment').editable({
        type: 'textarea',
        name: 'comment',
        url: '<?php echo $this->webroot; ?>ajax/editable',
        title: 'comment',
        placement: 'right',
    });
    });
</script>
<div class="main">
<div class="main-order " style=" min-height: 433px;">

         <div class="chef-discount-data">
           <?php 
           $totalItem=0;
           $subTotal=0;
           $total;
           ?>

             <?php foreach ($dicountArr as $key => $value) {?>
            
            <input type="hidden" value="<?php echo $value['discount']; ?>" id="discount_<?php echo $value['chef_id'];?>">
            <input type="hidden" value="<?php echo $value['limit']; ?>" id="discount_limit_<?php echo $value['chef_id'];?>">
            
             <?php } ?>
         </div>
        <h2 class="order-heading ">Review Order</h2>
		<div class="row">
         <?php if(!empty($cart_meals)){ ?>
        <div class="col-sm-8">
            <?php foreach ($cart_meals as $key => $value) {?>
        <div class="col-sm-12 no-padding">
            <h4>Pick up on: <?php echo ucfirst($key);?> </h4>
	    <div class="table-responsive">
            <table class="table table-bordered order-table">
                <tr>
                    <th colspan="2">Meal</th>
                    <th width="16%">comment</th>
                    <th width="16%">Price</th>
                    <th width="16%">Unit</th>
                    <th width="16%">Total</th>
                </tr>
				<?php foreach ($value as $key1 => $value1) { ?>
                <tr id="<?php echo $value1['Cart']['id'];?>"  data-product-id="<?php echo $value1['Product']['id'];?>" >
                    <td style="width:80px;" class="product-ids" data-product-id="<?php echo $value1['Product']['id'];?>" >
					<?php 
                    echo $this->Html->image('/images/small/'.$value1['Product']['image'],array('alt'=>'','class'=>'order-img','url'=>array('controller'=>'products','action'=>'view','slug'=>$value1['Product']['slug'])));
                    ?>

                    <td style="width: 243px;" class="chef-info" data-chef-id="<?php echo $value1['User']['id'];?>" > 
                    <span>Chef: </span><?php echo $value1['User']['first_name'];?><br />
                    <span>Location: </span><?php echo $value1['User']['city'].' , '.$value1['User']['country'];?><br />
                    <?php echo $value1['Product']['name'];?> <br />
                    <span>Time of pick up: </span>between <?php  echo date('h:i A', strtotime($value1['Product']['pick_time_from'])).'-'.date('h:i A', strtotime($value1['Product']['pick_time_to']));?>
                    <br/>
                        <a href="javascript:void(0);" class="remove-add-cart" data-cart-id="<?php echo $value1['Cart']['id'];?>">Remove</a>
                    </td>
                    <td style="width: 243px;" class="comment" data-value="<?php echo $value1['Cart']['comment']; ?>" data-pk="<?php echo $value1['Cart']['id']; ?>" ><?php echo $value1['Cart']['comment'];?></td>
                 <td class="meal-price" data-price="<?php echo $value1['Product']['price'];?>">$<?php echo $value1['Product']['price'];
                 if(!empty($value1['Cart']['discount'])){
                   
                     echo '<br /><br /><span>Discount '.$value1['User']['Coupon']['discount'].'% ($'.round($value1['Cart']['discount'],2).')</span>';

                        }
                     ?>
                       

                    </td>
                    <td><select class="form-control meal-unit">
                          <?php 
                            for ($i=1;$i<=8;$i++){
                                  if($i==$value1['Cart']['quantity']){
                                    echo '<option value="'.$i.'" selected>'.$i.'</option>';
                                  }else{
                                    echo '<option value="'.$i.'" >'.$i.'</option>';
                                  }
                            }
  
                          ?>
                           
                        </select></td>
                    <td class="total-price">
                    $<?php 
                    $total_price=$value1['Product']['price'] *$value1['Cart']['quantity'];
                    if(!empty($value1['Cart']['discount'])){
                      echo $total_price=$total_price-$value1['Cart']['discount'];
                    }else{
                        echo $total_price;
                    }
                    $totalItem=$totalItem+$value1['Cart']['quantity'];
                    $subTotal=$subTotal+$total_price;

                
                     ?>
                    </td>				
                </tr>
				<?php } ?>

            </table>
	    </div>
        </div>
	<?php }?>
        </div>
        <div class="col-sm-4">
        <h4 style="visibility: hidden">Fix Table </h4>
	<div class="table-responsive">
        <table class="table table-bordered order-summary-table">
            <tr>
                <th colspan="2" class="text-center"><span >Order Summary</span></th>
            </tr>
            <tr>
                <td width="70%">Total items</td>
                <td width="30%" id="meal-items"><?php echo $totalItem;?></td>
            </tr>
            <tr>
                <td width="70%">Subtotal</td>
                <td width="30%" id="meal-subtotal">$<?php echo $subTotal;?></td>
            </tr>
            <tr>
                <td class="meal-hst" data-hst="<?php echo $setting['Setting']['hst'];?>">HST (<?php echo $setting['Setting']['hst'];?>%)</td>
                <td class="hst-val">$<?php 
                 $hst=($subTotal*$setting['Setting']['hst'])/100;
                 echo round($hst,2);
                 ?>
      </td>
            </tr>
            <tr>
                <td><b>Total</b></td>
                <td id="meal-total" data-total="" ><b>$<?php echo round($hst+$subTotal,2);?></b></td>
            </tr>
            <tr>
                <td class="text-center" colspan="2">
                <?php 
                echo $this->Form->create('Product',array('url'=>array('action'=>'order_confirm','controller'=>'users')));
                echo $this->Form->input('items',array('type'=>'hidden','value'=>@$totalItem));
                echo $this->Form->input('productId',array('type'=>'hidden','value'=>''));

                ?>
               <button  class="button btn-cart" id="Proceed_to_Checkout" title="Proceed to Checkout" type="submit"><span><span>Proceed to Checkout</span></span></button></td>
                <?php echo $this->Form->end();?>
            </tr>
        </table>
	</div>
    </div>
      <?php }else{
        echo '<div class="col-sm-12">No Meal in Carts</div>';
        }?>   
        
    	
 </div>
</div>


<div class="text-center">All sales are final upon checkout</div>
</div>
<!--td>
<span class="comment" data-value="<?php echo !empty($value1['comment'])?$value1['comment']:'No comment'; ?>" data-pk="<?php echo $value1['cart_id']; ?>"><?php echo !empty($value1['comment'])?$value1['comment']:'No comment'; ?></span>
</td-->