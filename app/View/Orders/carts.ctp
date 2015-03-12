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
<div class="main-order">
    
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
                    <!--th width="16%">comment</th-->
                    <th width="16%">Price</th>
                    <th width="16%">Unit</th>
                    <th width="16%">Total</th>
                </tr>
				<?php foreach ($value as $key1 => $value1) { ?>
                <tr id="<?php echo $value1['cart_id'];?>" >
                    <td style="width:80px;" class="product-ids" data-product-id="<?php echo $value1['Product']['id'];?>" >
					<?php 
                    echo $this->Html->image('/images/small/'.$value1['Product']['image'],array('alt'=>'','class'=>'order-img','url'=>array('controller'=>'products','action'=>'view','slug'=>$value1['Product']['slug'])));
                    ?>

                    <td style="width: 243px;"> 
                    <span>Chef: </span><?php echo $value1['User']['first_name'];?><br />
                    <span>Location: </span><?php echo $value1['User']['city'].' , '.$value1['User']['country'];?><br />
                    <?php echo $value1['Product']['name'];?> <br />
                    <span>Time of pick up: </span>between <?php  echo date('h:i A', strtotime($value1['Product']['pick_time_from'])).'-'.date('h:i A', strtotime($value1['Product']['pick_time_to']));?>
                    <br/>
                        <a href="javascript:void(0);" class="remove-add-cart" data-cart-id="<?php echo $value1['cart_id'];?>">Remove</a>
                    </td>
                    <!--td>
                     <span class="comment" data-value="<?php echo !empty($value1['comment'])?$value1['comment']:'No comment'; ?>" data-pk="<?php echo $value1['cart_id']; ?>"><?php echo !empty($value1['comment'])?$value1['comment']:'No comment'; ?></span>
                    </td-->
                    <td class="meal-price" data-price="<?php echo $value1['Product']['price'];?>">$<?php echo $value1['Product']['price'];?></td>
                    <td><select class="form-control meal-unit">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                        </select></td>
                    <td class="total-price">$<?php echo $value1['Product']['price'];?></td>				
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
                <td width="30%" id="meal-items"></td>
            </tr>
            <tr>
                <td width="70%">Subtotal</td>
                <td width="30%" id="meal-subtotal"></td>
            </tr>
            <tr>
                <td class="meal-hst" data-hst="<?php echo $setting['Setting']['hst'];?>">HST (<?php echo $setting['Setting']['hst'];?>%)</td>
                <td class="hst-val"></td>
            </tr>
            <tr>
                <td><b>Total</b></td>
                <td id="meal-total" data-total="" ><b></b></td>
            </tr>
            <tr>
                <td class="text-center" colspan="2">
                <?php 
                echo $this->Form->create('Product',array('url'=>array('action'=>'paypal','controller'=>'users')));
                echo $this->Form->input('items',array('type'=>'hidden','value'=>''));
                echo $this->Form->input('productId',array('type'=>'hidden','value'=>''));

                ?>
               <button  class="button btn-cart" id="Proceed_to_Checkout" title="Proceed to Checkout" type="submit"><span><span>Proceed to Checkout</span></span></button></td>
                <?php echo $this->Form->end();?>
            </tr>
        </table>
	</div>
    </div>
     <?php }else{
        echo "No Meal in Carts";
        }?>   

    	
 </div>
</div>


<div class="text-center">All sales are final upon checkout</div>