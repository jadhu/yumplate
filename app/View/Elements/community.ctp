<?php //pr($stories); ?>

 <section class="simpleSec">            
            <h3 class="title-name">It's simple</h3>
            <div class="steps">
                <?php 
                echo $this->Html->image('/images/its_simple.png',array('alt'=>''));
                ?>
               </div> 
        </section>
        <section class="yumCommunity">
            <div class="container">
                <h3 class="title-name">Yum community</h3>
                <div class="row">
                <?php if(!empty($stories)){
                         foreach ($stories as $key => $value) { ?>
                 <div class="col-sm-4">
                            <div class="com-thumb story-yum "  style="cursor:pointer;" data-id="<?php echo $value['Story']['id']?>">
                                <h5><?php echo $value['Story']['title']?>:</h5>
                                <figure class="pull-right community-img">
                        <?php  echo $this->Html->image('/images/story/'.$value['Story']['image'],array('alt'=>''));
                                ?>

                                </figure>
                                <div class="community-text">
                                <?php echo substr(strip_tags($value['Story']['story']),0,100).'...';?>
                                </div>
                             
                                </div>
                </div>
                <?php }}else{echo 'There is no story';}?>
                </div>
            </div>
        </section>