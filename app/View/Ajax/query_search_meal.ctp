<div class="page-title">
<h4> <?php 
//$day_data=(date("l"))==$day?"Today's":$day.'\'s';
echo "This meal is available on ".$day=$product['Product']['day'];

?></h4>
<div class="clear"></div> 
</div>
 <div class="row meals-para">
 <?php if(!empty($product)) {
           ?>
              <div class="col-sm-6">
                        <div class="mealThumb mr15" data-meal-id="<?php echo $product['Product']['id'] ; ?>">
                            <h5><?php echo $product['Product']['name'] ; ?> <span class="pull-right">$ <?php echo $product['Product']['price'] ; ?></span></h5>
							<h5 class="product-details">PICKUD BY :<?php echo $day;?>,<?php  echo date('h:i A', strtotime($product['Product']['pick_time_from'])).'-'.date('h:i A', strtotime($product['Product']['pick_time_to']));?><br/> <span class="">ORDER BY : <?php echo $day;?>,<?php  echo date('h:i A', strtotime($product['Product']['order_time']));?></span></h5>
                            <figure>
                            <?php 
                            echo $this->Html->image('/images/original/'.$product['Product']['image'], array('alt' => ''));
                            ?>

                            </figure>
                            <article>
                                 <?php if(!empty($meal_day) ){ ?>
                                <button class="pull-right btn become-btn add_meal_cart" data-meal-id="<?php echo $product['Product']['id'] ; ?>" data-order-day="<?php echo strtolower($meal_day);?>">
                                    + Add to Cart
                                </button>
                                 <?php } ?>
                                <?php 
                            echo $this->Html->link('Add your review',array('controller'=>'products','action'=>'view','slug'=>$product['Product']['slug']),array('class'=>'pull-right btn become-btn add-review'));
                            ?>
                               <?php if(!empty($product['Product']['rating'])) { ?>
                                <div class="rating-wrap">
                                <div class="rating-line">
                                    <?php for($i=1;$i<=$product['Product']['rating'];$i++) {
                                       
                                         echo '<span class="glyphicon glyphicon-star"></span>';
                                        
                                        }
                                     ?>
                                    
                                     </div>
                                    (<?php echo count($product['Review']); ?> <span data-product-id="<?php echo $product['Product']['id']; ?>" class="review-comment" style="cursor:pointer;">reviews</span>)
                                    </div>
                                    <?php }else{?>
                                     <div class="ratings">
                                    <ul>
                                    <?php for($i=1;$i<=5;$i++) {
                                        if($i<=$product['Product']['rating']){
                                         echo '<span class="glyphicon glyphicon-star active"></span>';
                                        }else{
                                             echo '<li class="glyphicon glyphicon-star"></li>';
                                        }
                                       
                                    }?>
                                    </ul>
                                    (<?php echo count($product['Review']); ?> reviews)
                                    </div>
                                    <?php } ?>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                            <a href="#story" aria-controls="story" role="tab" data-toggle="tab">Story</a>
                            </li>
                            <li role="presentation">
                            <a href="#ingredients" aria-controls="ingredients" role="tab" data-toggle="tab">Ingredients</a>
                            </li>
                            <li role="presentation">
                            <a href="#contains" aria-controls="contains" role="tab" data-toggle="tab">Contains</a>
                            </li>
                            <li role="presentation">
                            <a href="#serving" aria-controls="serving" role="tab" data-toggle="tab">Serving</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="story">
                            <?php echo $product['Product']['story'];?></div>
                            <div role="tabpanel" class="tab-pane" id="ingredients">
                             <?php echo $product['Product']['ingredients'];?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="contains">
                            <?php echo $product['Product']['contains'];?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="serving">
                            <?php echo $product['Product']['serving'];?>
                            </div>
                           </div>
                       </article>
                        </div>
                    </div>
                    <?php }else{
                        echo trim('<span>There is no meal for this day</span>');
                    } ?>

 </div>
                   
                  
             