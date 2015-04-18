<script src="https://maps.googleapis.com/maps/api/js"></script>
<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&appId=330457023826586&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));



window.twttr=(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};if(d.getElementById(id))return;js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);t._e=[];t.ready=function(f){t._e.push(f);};return t;}(document,"script","twitter-wjs"));
 /*!function(d,s,id){
 
  var js,fjs=d.getElementsByTagName(s)[0];
  if(!d.getElementById(id)){
    js=d.createElement(s);js.id=id;
    js.src="//platform.twitter.com/widgets.js";
    fjs.parentNode.insertBefore(js,fjs); alert('call');
   }
 }(document,"script","twitter-wjs");*/
 </script>

<div class="main">
<input type="hidden" id="cook_id" value="<?php echo $product['User']['id']?>">
<input type="hidden" id="page" value="profile">
<input type="hidden" id="loggeduserId" value="<?php echo $this->Session->read('Auth.User.id');?>">
<input type="hidden" id="productIds" value="<?php echo $productIds;?>">
<input type="hidden" id="user_address" value="<?php $city=!empty($product['User']['city'])?$product['User']['city']:'';
      $country=!empty($product['User']['country'])?$product['User']['country']:'' ;
      echo $city.' , '.$country;
?>">
<div class="firstInfo"  >
                    <figure class="yum-go-profile" style="cursor:pointer;">
                    <?php echo $this->Html->image('/images/UserImg/'.$product['User']['image'], array('alt' => '','height'=>'65px','width'=>'65px'));?>
                       
                    </figure>
                    <article>
                        <h4 class="yum-go-profile" style="cursor:pointer;">By <?php echo $product['User']['first_name'];?></h4>
                        <ul>
                            <li class="yum-go-profile" style="cursor:pointer;">
                            <i class="loaction-icon"></i><strong>Location :</strong> 
                            <?php echo !empty($product['User']['city'])?$product['User']['city']:'No City';?>,<?php echo !empty($product['User']['country'])?$product['User']['country']:'No City';?>
                            </li>
                            <li><i class="delivery-icon"></i><strong>Delivery :</strong> <span class="uppercase">No</span></li>
                            <li><i class="avrage-icon"></i><strong>Average rating:</strong> 

                               <?php //echo $product[0]['sum'];
                               $average=ceil($product[0]['sum']/3);?>
                                <div class="rating-line">
                                <?php for($i=1;$i<=$average;$i++){
                                      echo '<span class="glyphicon glyphicon-star" aria-hidden=""></span>';
                                    }
                                  ?>
                                 </div>
								 <span class="profile-top-review" >
                                (<?php echo !empty($product['Review'][0]['Review'][0]['count'])?$product['Review'][0]['Review'][0]['count'].' <a id="review_section" style="cursor:pointer;" href="javascript:void(0)">Reviews</a>':'No Reviews';?>)</span></li><br />

                     
                        </ul>
                    </article>
                </div>
                
                <div id="today_div">
                    <div id="loader_div" style="text-align: center;display:none;"><?php echo $this->Html->image('/images/loading.gif', array('alt' => ''));?></div>
                </div>
                <div id="tomorrow_div">
                    <div id="loader_div_second" style="text-align: center;display:none;"><?php echo $this->Html->image('/images/loading.gif', array('alt' => ''));?></div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="yamplate-review mr15 feedback-review">
                          
                        </div> 
                               <a href="javascript:void(0)" class="user-comment" id="addcoment" data-limit="" > Read more comments</a>
                                   
                    </div>
                    <div class="col-sm-6">
                        <div class="yamplate-review ml15" >
                            <h4>YumChef <?php echo $product['User']['first_name'];?></h4>                          
                            <div class="chef-article">
                                <figure>
                                
                                 <?php echo $this->Html->image('/images/UserImg/'.$product['User']['image'], array('alt' => ''));?>
                                </figure>
                                <div class="less">
                                <?php echo substr($product['User']['description'],0,300)?>... <br/> <br/> 
                                <a class="readMore" href="javascript:void(0)"> More</a>
                                </div>
                                <div class="more" style="display:none;">
                               <?php echo $product['User']['description'];?> 
                                <a class="readless" href="javascript:void(0)"> Less</a></div>
                                <br/> <br/> 
                                <div class="social-icons social-tab">
                                    <ul>
                                        <li>
                                         

                                        <a href="https://www.pinterest.com/pin/create/button/
                                        ?url=<?php echo SITE_URL; ?>u/<?php echo $product['User']['username'];?>"
                                        data-pin-do="buttonPin"
                                        data-pin-config="above">
                                        <img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" />
                                        </a>
                                        </li>
                                        <li>
                                            <a href="https://twitter.com/share" style="margin-top:0px !important;" class="twitter-share-button"   data-url="<?php echo SITE_URL; ?>u/<?php echo $product['User']['username'];?>">Tweet</a>
                                        </li>
                                        
                                        <li>
                                        <div class="fb-share-button" title="Share" data-href="<?php echo SITE_URL; ?>u/<?php echo $product['User']['username'];?>"  data-layout="button_count"></div>

                                         
                                        </li>
                                    </ul>
                                </div>
                                <div class="clear"></div>
                            </div>
                            
                            <h4>Logistics</h4>
                            <ul class="logistiecs">
                                <li>
                                    <i class="loaction-icon"></i>
                                    Location................
                                    <span class="text-right1"><?php echo !empty($product['User']['city'])?$product['User']['city']:'No City';?>,<?php echo !empty($product['User']['country'])?$product['User']['country']:'No country';?> </span>
                                    <figure class="map text-right">
                                     <div id="map_canvas" style="width:500px;height:220px;"></div>                      
						             
                                      <?php //echo $this->Html->image('/images/map.png', array('alt' => ''));?>
                                        
                                    </figure>
                                </li>
                                <li>
                                    <i class="home-icon"></i>
                                Address Type...................  <span class="text-right1">
                                <?php echo !empty($product['User']['address_type'])?$product['User']['address_type']:'No address type';?></span>
                                </li>
                                <li>
                                    <i class="parking-icon"></i> 
									Parking........................ <span class="text-right1 "><?php echo !empty($product['User']['parking'])?ucfirst($product['User']['parking']):'Not Assigned';?></span>
                                </li>
                                <li>
                                    <i class="delivery-icon"></i>
                                    Delivery........................ <span class="text-right1 "><?php echo !empty($product['User']['delivery'])?ucfirst($product['User']['delivery']):'Not Assigned';?></span>
                                </li>
                            </ul>
                        </div>  
                    </div>
                </div>
		</div>

    <script >
    var address =$('#user_address').val().trim();
 
  if(address!=null ||address!=''){
  var geocoder;
  var map;


function initialize() {

  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(-34.397, 150.644);
  var myOptions = {
    zoom: 8,
    center: latlng,
    mapTypeControl: true,
    mapTypeControlOptions: {
      style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
    },
    navigationControl: true,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
  if (geocoder) {
    geocoder.geocode({
      'address': address
    }, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
          map.setCenter(results[0].geometry.location);

          var infowindow = new google.maps.InfoWindow({
            content: '<b>' + address + '</b>',
            size: new google.maps.Size(150, 50)
          });

          var marker = new google.maps.Marker({
            position: results[0].geometry.location,
            map: map,
            title: address
          });
          google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map, marker);
          });

        } else {
          alert("No results found");
        }
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }
}
google.maps.event.addDomListener(window, 'load', initialize);
}


// function for share profile on fb,twitter,pininterest



$(function(){

$('#review_section').click(function(){
//alert('call');
$('html, body').animate({ scrollTop: $('.reviewLine').offset().top - 100 }, 'slow');
});

//for image ,name ,location to link lower profile

$('.yum-go-profile').click(function(){
//alert('call');
$('html, body').animate({ scrollTop: $('.yamplate-review').offset().top - 100 }, 'slow');
});
  
});
                   

    </script>