<div id="testDivId_<?php echo $counter;?>">
<div class="page-title">
<h4> <?php 
$day_data=(date("l"))==$day?"Today's":$day.'\'s';
echo $day_data;

?> menu</h4>
<div class="clear"></div> 
</div>
 <div class="row meals-para">
 <?php if(!empty($product)) {foreach ($product as $key => $value) {
           ?>
              <div class="col-sm-6">
                        <div class="mealThumb mr15" >
                            <h5><?php echo $value['Product']['name'] ; ?> <span class="pull-right">$ <?php echo $value['Product']['price'] ; ?></span></h5>
							<h5 class="product-details"><b>PICKUP BY : </b><?php echo $day;?>,<?php  echo date('h:i A', strtotime($value['Product']['pick_time_from'])).'-'.date('h:i A', strtotime($value['Product']['pick_time_to']));?> <span class="pull-right"><b>ORDER BY : </b><?php echo $day;?>,<?php  echo date('h:i A', strtotime($value['Product']['order_time']));?></span></h5>
                            <figure>
                            <?php 
                            echo $this->Html->image('/images/original/'.$value['Product']['image'], array('alt' => ''));
                            ?>

                            </figure>
                            <article>
				          <button class="pull-right btn become-btn add_meal_cart" data-meal-id="<?php echo $value['Product']['id'] ; ?>" >
                                    + Add to Cart
                                </button>
                            <?php 
                            echo $this->Html->link('Add your review',array('controller'=>'products','action'=>'view','slug'=>$value['Product']['slug']),array('class'=>'pull-right btn become-btn add-review'));
                            ?>
                                
                               <?php if(!empty($value['Product']['rating'])) { ?>
                                <div class="rating-wrap">
                                <div class="rating-line">
                                    <?php for($i=1;$i<=$value['Product']['rating'];$i++) {
                                       
                                         echo '<span class="glyphicon glyphicon-star"></span>';
                                        
                                        }
                                     ?>
                                    
                                     </div>
                                    (<?php echo count($value['Review']); ?>  reviews)
                                    </div>
                                    <?php }else{?>
                                     <div class="ratings">
                                    <ul>
                                    <?php for($i=1;$i<=5;$i++) {
                                        if($i<=$value['Product']['rating']){
                                         echo '<span class="glyphicon glyphicon-star active"></span>';
                                        }else{
                                             echo '<li class="glyphicon glyphicon-star"></li>';
                                        }
                                       
                                    }?>
                                    </ul>
                                    (<?php echo count($value['Review']); ?>  reviews)
                                    </div>
                                    <?php } ?>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                            <a href="#story_<?php echo $value['Product']['id']; ?>" aria-controls="story" role="tab" data-toggle="tab">Story</a>
                            </li>
                            <li role="presentation">
                            <a href="#ingredients_<?php echo $value['Product']['id']; ?>" aria-controls="ingredients" role="tab" data-toggle="tab">Ingredients</a>
                            </li>
                            <li role="presentation">
                            <a href="#contains_<?php echo $value['Product']['id']; ?>" aria-controls="contains" role="tab" data-toggle="tab">Recommended for</a>
                            </li>
                            <li role="presentation">
                            <a href="#serving_<?php echo $value['Product']['id']; ?>" aria-controls="serving" role="tab" data-toggle="tab">Serving</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="story_<?php echo $value['Product']['id']; ?>">
                            <?php echo $value['Product']['story'];?></div>
                            <div role="tabpanel" class="tab-pane" id="ingredients_<?php echo $value['Product']['id']; ?>">
                             <?php echo $value['Product']['ingredients'];?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="contains_<?php echo $value['Product']['id']; ?>">
                            <?php echo $value['Product']['contains'];?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="serving_<?php echo $value['Product']['id']; ?>">
                            <?php echo $value['Product']['serving'];?>
                            </div>
                           </div>
                       </article>
                        </div>
                    </div>
                    <?php }
                    
 }
 else{
                        
                        echo trim('<span>Sorry, we have no more meals available for today</span>');
                    } ?>

 </div>
          


  </div>               
                  
             