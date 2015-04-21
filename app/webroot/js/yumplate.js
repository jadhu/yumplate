counter=0;
$(document).ready(function(){
    
//for session message to hide

if($('#flashMessage').length==1){
   $('#flashMessage').fadeOut( 5000 );
}

// for fotgot password
$('#forget_pass').click(function(){
  
if($('#registerForm').length==1){
$('#registerForm').removeClass('likePopup'); 
}

$("#ForgetPassModal").modal('show');
});

if($('.com-thumb').length){

  $(".com-thumb").on({
        mouseenter: function() {
           $(this).addClass('yum-story');
        },
        mouseleave: function() {
            $(this).removeClass('yum-story');
        }
    });

}

//for redirect ot the cooks profile page
$('.user-profile').click(function(){
  console.log($(this).data('product'));
   if($(this).data('product')){
    window.location.href =$('#page_url').val()+'u/'+$(this).attr('data-user-id')+'?recipe='+$(this).data('product');
   }else{
    window.location.href =$('#page_url').val()+'u/'+$(this).attr('data-user-id');
   }
 
});


if($('#page').length){
  user_id=$('#cook_id').val();
checkQuery(user_id);
UserProducts(user_id, counter);
UserProductsTomorrow(user_id, counter+1);
UserReview();


}



// for sign up through facebook

$('.facebook-login').click(function(){
 OAuth.initialize('zocu4LB4gDjGsFsJBqjHRhmIlkc'); 
    var provider='facebook';
	//alert('sdff');
OAuth.popup(provider)
.done(function(result) {
    result.get('/me')
    .done(function (response) {
	//alert('sdf');
    	//console.log(response); return  false;
		$(".full_load").remove()
		$("body").prepend('<div class="full_load"><div id="load"></div></div>');
       SocialRegister(JSON.stringify(response));
    })
    .fail(function (err) {
        console.log(err);
    });
},{ scope: 'email,public_profile' })
.fail(function (err) {
    console.log(err);
    //handle error with err
});
   
    
});



// for login modal pop up
$('#user_login').click(function(){
$('#exampleModal').modal('show') ;
});



// for story view
$('.story-yum').click(function(){

  //alert($(this).data('id'));
  var url = SITE_URL+'stories/view?tag='+$(this).data('id');
  
  location.href = url;
// window.location.href =$('#page_url').val()+'stories/view?tag='+$(this).attr('data-id');\
  
});




  //for view story focused
  var storyId=$('#story_id').val();
  if(storyId !='' && storyId!=null){
  $('#'+storyId).children().addClass('yum-story');
  $('#'+storyId).focus(); 
  
  }



// for add meal in  cart
$(document).on('click','.add_meal_cart',function(){

 var loginUser=$('#loggeduserId').val();

 if(loginUser=='' || loginUser==null){
     $('#user_login').trigger('click');
      return false;
 }

 var cookId=$('#cook_id').val();
 var comment='';
 if($('.special_comment').length){
   comment=$('.special_comment').val();
 }
  var mealId='';
  if($('#product_id').length){
    mealId=$('#product_id').val();
  }else{
    mealId=$(this).attr('data-meal-id');
  }
  day =$(this).attr('data-order-day');
  var order_date=$(this).attr('data-order-date');
  var page_url=$('#page_url').val();
  var html='';
    $.ajax({

            'url':page_url+'ajax/addCart/',
            'type':'POST',
            'async': false,
            'data':{'cookId':cookId,'mealId':mealId,'userId':loginUser,'comment':comment,'day':day,'order_date':order_date},
            'dataType': "json",
            'success':function(data){
               $('#message').show(); 
               console.log('call');
                if(data.type=='success'){

                  $('.cart-btn').text(data.count);

                  html +='<div class="alert alert-success">'+data.msg+' for '+data.order_day+' pickup.For any other day, scroll down to pick from the menu.';
                  
                  $('#message').html(html).fadeOut( 10000 );
                  
                  
                }else{
                  $('.cart-btn').text(data.count);
                 
                  $('#message').html('<div class="alert alert-danger">'+data.msg+'</div>').fadeOut( 5000 );
                  
                }

            } 
    });

});


// function for remove from cart table 

$('.remove-add-cart').click(function(){
   
    show_success_flash('Are you sure you want to delete this?', "deleteCart("+$(this).attr('data-cart-id')+")");
    
});


  //for get price on unit  change 
    $('.meal-unit').on('change',function(){
       var cartId=$(this).closest('tr').attr('id');
       var quantity=$(this).val();
       var productId=$(this).closest('tr').attr('data-product-id');
       updateCart(cartId,quantity,productId);
        //getPrice();
    });
    // on page load
   //getPrice();



//for read more and read less for user content


if($('.readMore').length!=0){

  $('.readMore').click(function(){
    $('.less').hide();
    $('.more').show();

  });
  
  $('.readless').click(function(){
    $('.less').show();
    $('.more').hide();

  });
}


//function  for autocomplete for explore yum search

  if($('#ProductKeywords').length){
   page_url=$('#page_url').val();
  $( "#ProductKeywords" ).autocomplete({
      source: function( request, response ) {

        $.ajax({
            dataType: "json",
            type : 'Get',
            data:{'query':request.term},
            url:page_url+'ajax/searchMeal',
            success: function(data) {
              $('input.suggest-user').removeClass('ui-autocomplete-loading');  // hide loading image

            response( $.map( data, function(item) {
                // your operation on data
               // console.log(item);
                return {label: item.name }
            }));
          },
          error: function(data) {
              $('input.suggest-user').removeClass('ui-autocomplete-loading');  
          }
        });
      },
      minLength: 2,
     select: function( event, ui ) {
       
              var itemval = ui.item.value;
               // here you can access selected result `itemval`
               $('#ProductKeywords').val(itemval);
                return false;
      }
    });


}






//function for add comment 

if($('#cook_id').length!=0){
 $(document).on('click','#addcoment',function(){

    if($('.reviewLine li:last-child').text().trim()=='No more comments'){
        return false;
    }
  var count=$(this).attr('data-limit');

  page_url=$('#page_url').val();
  userIds=$('#productIds').val();
  $.ajax({

      'url':page_url+'ajax/addComment/',
      'type':'POST',
      'async': false,
      'data':{'userIds':userIds,'count':count},
      'dataType': "html",
      'success':function(data){
        
         $('.reviewLine').append(data);
         $('#addcoment').attr('data-limit',$('.reviewLine').children().length);
      }   
  });

 });
 //AddComment();
}


// for view the comments per meal
$(document).on('click','.review-comment',function(){
  var productId=$(this).attr('data-product-id');
  var page_url=$('#page_url').val();
  $.ajax({
        'url':page_url+'ajax/showComment/',
         'type':'POST',
         'data':{'productId':productId},
         'dataType': "html",
          beforeSend:function(){
             // $("#loader_div").show();
             },
         'success':function(data){
             $('#ReviewModal').modal('show');
             $('#comment_section').html(data);
               
         } 
    });
});

//ends here

});


//function for update cart for discount,quantity , price
function updateCart(cartId,quantity,productId){
  var page_url=$('#page_url').val();
  $.ajax({
        'url':page_url+'ajax/updateCart/',
         'type':'POST',
         'async': false,
         'data':{'cartId':cartId,'quantity':quantity,'productId':productId},
         'dataType': "json",
         beforeSend:function(){
             // $("#loader_div").show();
             },
         'success':function(data){
             window.location.href=page_url+'carts';
               
         } 
    });
}


//function for calculate price 

function getPrice(){
    var mealHst=$('.meal-hst').data('hst');
    var ProductItems=new Array();
    var totalPrice=0;
    var hst=0;
    var subTotal=0;
    var Items=0;
      $(".meal-unit option:selected").each(function(){
        var unit=$(this).text();
        var price=$(this).parent().parent().siblings('.meal-price').data('price');

        var total =unit*price;
         Items=parseInt(Items)+parseInt(unit);
        
         $(this).parent().parent().siblings('.total-price').text('$'+total);
          subTotal=parseInt(subTotal)+ parseInt(total);
          ProductItems.push(unit+'~'+$(this).parent().parent().siblings('.product-ids').attr('data-product-id'));
       });

   
    var productIds=ProductItems.join('|');
    hst =(subTotal*mealHst)/100;
    totalPrice=hst+subTotal;
    var totalP =totalPrice.toFixed(2);
    var hstP =hst.toFixed(2);

   

    $('.hst-val').text('$'+hstP);
    $('#meal-subtotal').text('$'+subTotal);
    $('#meal-total').text('$'+totalP);
    $('#meal-total').attr('data-total',totalP);

    $('#meal-items').text(Items);
    $('#ProductItems').val(Items);
    $('#ProductProductId').val(productIds);

 
}
//function for delete from cart
function deleteCart(id){
    var cartId=id; 

  var page_url=$('#page_url').val();
  $.ajax({
        'url':page_url+'ajax/deleteCart/',
         'type':'POST',
         'async': false,
         'data':{'cartId':cartId},
         'dataType': "json",
         'success':function(data){
               if(data.type=='success'){
                   $('#'+id).remove();
                  window.location.href=page_url+'carts';
               }

         } 
    }); 
    
}

/*
 * a for string
 * b for callback function for link
 */
function show_success_flash(a, b)
{
    if (a == undefined)
    {
        alert('show_success_flash requiored a parameter');
        return false;
    }

    $("#show_success_flash").modal('hide');
    $("#show_success_flash").remove();
    var str = '<div class="modal fade" id="show_success_flash" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
    str += '<div class="modal-dialog">';
    
    str += '<div class="delete-popup-main" style="overflow:hidden;" role="alert">';
	
	str += '<h3 class="modal-title">Delete Meal</h3> <br/>' + a + '<span style="float:right"><br/><br/>';
    str += '<button data-dismiss="modal" class="btn btn-primary btn-sm" type="button">Cancel</button> &nbsp;';
     str += '<a href="javascript:void(0)" onclick="'+b+'" ><button type="button" data-dismiss="modal" class="btn btn-primary btn-sm">Delete Meal</button></a>';
 


    str += '</span></div></div></div>';



    // alert(str);
    $('body').append(str);
    if (b)
    {

        $("#show_success_flash").modal({backdrop: 'static', keyboard: false});
    } else
    {
        $("#show_success_flash").modal('show');
    }


}

//function for check query parmeter

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}


function checkQuery(user_id){
 var product=getParameterByName('recipe');
 var page_url=$('#page_url').val();
 if(!product){
  return false;
 }
$.ajax({
      'url':page_url+'ajax/querySearchMeal/',
      'type':'GET',
      'async': false,
      'data':{'recipe':product,'userId':user_id},
      'dataType': "html",
      'success':function(data){
         
         if(data!='<span>Sorry, we have no more meals available for today</span>'){
          $("#today_div").before('<div>'+data+'<div>'); 
         }


      }   
  });
}

//ends here



//function for user revie and comment load

function UserReview(){

  page_url=$('#page_url').val();
  userIds=$('#productIds').val();
  cookId=$('#cook_id').val();
  $.ajax({

      'url':page_url+'ajax/profileReview/',
      'type':'POST',
      'async': false,
      'data':{'userIds':userIds,'cookId':cookId},
      'dataType': "html",
      'success':function(data){
         $('.feedback-review').html(data);


      }   
  });
 $('#addcoment').attr('data-limit',$('.reviewLine').children().length);
}





function UserProducts(userId, counter){
    page_url=$('#page_url').val();
    
     $.ajax({

            'url':page_url+'ajax/ajax_profile/',
            'type':'GET',
            'data':{'userId':userId,'counter':counter},
            'dataType': "html",
             beforeSend:function(){
              $("#loader_div").show();
             },
            'success':function(data){
                 $("#loader_div").hide();
                if(counter<7) {
                    if(data.trim()=='Sorry, we have no more meals available for today') {
                         counter=counter+1;
                         UserProducts(user_id, counter);
                    } else {
                       
                       $("#today_div").append(data); 
                       
                    }
                }
                 

            }	
    });
}

function UserProductsTomorrow(userId, counter){
    page_url=$('#page_url').val();
    
     $.ajax({

            'url':page_url+'ajax/ajax_profile/',
            'type':'GET',
            'data':{'userId':userId,'counter':counter},
            'dataType': "html",
            beforeSend:function(){
              $("#loader_div_second").show();
             },
            'success':function(data){
                 $("#loader_div_second").hide();
                 
                  if(counter<7) {
                      
                     $(data).appendTo("#tomorrow_div");
                     counter=counter+1;
                     UserProductsTomorrow(user_id, counter);

                       
                    }
                }

    });
}
var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

function SocialRegister(userJSON){
    page_url=$('#page_url').val();
    var userOBJ = $.parseJSON(userJSON);
   // var fname=
    console.log(userOBJ.email);
    $.ajax({
            'url':page_url+'SocialRegister',
            'type':'post',
            //'async': false,
            'data':{'id':userOBJ.id,'first_name':userOBJ.first_name,'last_name':userOBJ.last_name,'email':Base64.encode(userOBJ.email)},
            'dataType': "json",
             beforeSend:function() { 
                   //$('#loader').html('<div class="loader"><img src="'+SITE_URL+'img/loading.gif" ></div>');
                },
            'success':function(data){
                if(data.type=='success'){
                     console.log('call');
                     window.location.href=page_url;
                }
                if(data.type=='exists'){
                  console.log('call1');
                  window.location.href=page_url;
                }
               
            }
        
    });
    
    
}



  // for google map
  //alert($('#user_address').length);

