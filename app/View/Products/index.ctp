
<?php 
echo $this->Html->script(array('jquery-1.11.2-ui.min'),array('inline'=>false)); 
echo $this->Html->css(array('jquery-ui'),array('inline'=>false));
?>


                <h3 class="title-name">Featured Yum</h3>
                <div class="row">
                <?php if(!empty($products)){ 
                    foreach ($products as $key => $value) {
                 
                    ?>
                <div class="col-md-4 feature-yum">
                        <div class="pro-box user-profile" data-user-id="<?php echo $value['User']['username'];?>" style="cursor:pointer">
                         <?php echo $this->Html->image('/images/small/'.$value['Product']['image'], array('alt' => ''));?>
                          
                            <div class="imgCap">
                                <figure>
                            <?php echo $this->Html->image('/images/UserImg/'.$value['User']['image'], array('alt' => ''));?>
                                    
                                </figure>
                                <article>
                                <?php 
                                echo "<p>".$value['Product']['name']." by ".$value['User']['first_name']." <br/> ".$value['User']['city']. " , ".$value['User']['country']."</p>";?>
                                    <div class="ratings">
                                    <ul>
                                    <?php for($i=1;$i<=5;$i++) {
                                        if($i<=$value['Product']['rating']){
                                         echo '<li class="glyphicon glyphicon-star active"></li>';
                                        }else{
                                             echo '<li class="glyphicon glyphicon-star"></li>';
                                        }
                                       
                                    }?>
                                    
                                    </ul>
                                    <span>(<?php echo count($value['Review']); ?>  reviews)</span>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                <?php } }?>
<input type="hidden" id="user_address" value="">

                </div>
<script>

$(function(){

$('#order_now').click(function(){
//alert('call');
$('html, body').animate({ scrollTop: $('.feature-yum').offset().top - 100 }, 'slow');
});

});


</script>