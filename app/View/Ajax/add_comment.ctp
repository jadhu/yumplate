<?php if(!empty($review)){ 
                                    foreach ($review as $key => $value) {
                                   ?>

                                <li id="<?php echo $value['Review']['id'];?>">
                                    <figure>
                                    <?php 
                                    if(!empty($value['User']['image'])){
                                      echo $this->Html->image('/images/UserImg/'.$value['User']['image'], array('alt' => '','height'=>'65px','width'=>'65px'));
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
                                 
                                <?php }}else{echo "<li>No more comments</li>";}?>
                               