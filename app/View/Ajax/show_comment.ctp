 <div class="row meals-para">
 <?php if(!empty($product)) {
           ?>
              <div class="col-sm-12">
                        <div class="productReview mr15" >
                            <h5><?php echo $product['Product']['name'] ; ?> <span class="pull-right">$ <?php echo $product['Product']['price'] ; ?></span></h5>
                          
                            <figure>
                            <?php 
                            echo $this->Html->image('/images/original/'.$product['Product']['image'], array('alt' => ''));
                            ?>
             
                            </figure>
                        </div>
                        <div class="product-comment">
                                    <ul class="reviewLine">
                                <?php 
                                    foreach ($product['Review'] as $key => $value) {
                                   ?>

                                <li id="<?php echo $value['id'];?>">
                                    <figure>
                                    <?php 
                                    if(!empty($value['User']['image'])){
                                      echo $this->Html->image('/images/UserImg/'.$value['User']['image'], array('alt' => '','height'=>'65px','width'=>'65px'));
                                    }elseif(!empty($value['User']['image_link'])){
                                        echo $this->Html->image($value['User']['image_link'], array('alt' => '','height'=>'65px','width'=>'65px'));
                                    }else{
                                        echo $this->Html->image('/images/UserImg/user1.png', array('alt' => '','height'=>'65px','width'=>'65px'));
                                    }
                                    
                                    ?>
                                    </figure>
                                    <article>
                                        <h4><?php echo $value['User']['first_name'];?></h4>  
                                        <p><?php echo $value['comments'];?></p>
                                    </article>
                                </li>
                                 
                                <?php }?>
                                
                            </ul>
                               </div>
                    </div>
                    <?php }?>

 </div>