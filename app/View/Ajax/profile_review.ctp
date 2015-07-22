                          <?php //pr($review);die;?>


                            <h4>Yumplate Reviews</h4>
                            <h5 class="text-right">
                                <!--a href="#"  class="like-btn"><i class="like-thumb"></i>Add Your review</a-->
                            </h5>
                            <ul class="total-rates">
                                <li>
                                    <strong>Overall:</strong>
                                    <div class="rating-line pull-right">
                                      <?php $average=ceil(($profie_review['User']['reviews_avg_val_rating']+$profie_review['User']['reviews_avg_ontime_rating']+$profie_review['User']['reviews_avg_easyfind_rating'])/3);
                                      for($i=1;$i<=$average;$i++){
                                      echo '<span class="glyphicon glyphicon-star" aria-hidden=""></span>';
                                    }
                                  ?>
                                    </div>
                                </li>
                                <li>
                                    <strong>Value:</strong>
                                    <div class="rating-line pull-right">
                                       <?php for($i=1;$i<=$profie_review['User']['reviews_avg_val_rating'];$i++){
                                      echo '<span class="glyphicon glyphicon-star" aria-hidden=""></span>';
                                    }
                                  ?>
                                    </div>
                                </li>
                                 <li>
                                    <strong>On time:</strong>
                                    <div class="rating-line pull-right">
                                       <?php for($i=1;$i<=$profie_review['User']['reviews_avg_ontime_rating'];$i++){
                                      echo '<span class="glyphicon glyphicon-star" aria-hidden=""></span>';
                                    }
                                  ?>
                                    </div>
                                    </li>
                                <li>
                                    <strong>Easy to find:</strong>
                                    <div class="rating-line pull-right">
                                       <?php for($i=1;$i<=$profie_review['User']['reviews_avg_easyfind_rating'];$i++){
                                      echo '<span class="glyphicon glyphicon-star" aria-hidden=""></span>';
                                    }
                                  ?>
                                    </div>
                                </li>
                            </ul>
                            <ul class="reviewLine">
                                <?php if(!empty($review)){ 
                                    foreach ($review as $key => $value) {
                                   ?>

                                <li id="<?php echo $value['Review']['id'];?>">
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
                                        <p><?php echo $value['Review']['comments'];?></p>
                                    </article>
                                </li>
                                 
                                <?php }}else{
                                     echo "There is no comments";
                                    }?>
                                
                            </ul>