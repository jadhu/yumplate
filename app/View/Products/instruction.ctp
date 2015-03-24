<?php echo $this->Html->script(array('jquery-validation'),array('inline' => false));?>
<div class="main">

<?php echo $Pagecontent['Page']['page_content'];
?>
<div class="yum-contact-main">
<div class="col-sm-12 no-padding-right">                              
	<h3 class="text-default">Contact Us</h3>
	<div id="FSContact1">                                      
	    <form id="contact_form" class="contact-form">       
	        <div class="form-group field message_board">
             </div>                                
	                                                    
	        <div class="row">
				<div class="form-group">
					<div class="col-sm-6">
					<label for="inputEmail3">Name <span class="red">*</span></label>
					
					  <input type="text" class="form-control" placeholder="Your Name" name="name" id="username">
					</div>
				</div>
	            <div class="form-group">
				<div class="col-sm-6">
					<label for="inputEmail3" >Email address <span class="red">*</span></label>
					
					  <input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
					</div>
				</div>
			</div>  
	        <div class="row">
				<div class="form-group">
				<div class="col-sm-12">
					<label for="inputEmail3" >Message <span class="red">*</span></label>
					
					  <textarea class="form-control" name="message" id="message" rows="4" placeholder="Message"></textarea>
					</div>
				</div>
			</div>
			<br/>
	        <div class="pull-right">					
				<button class="btn btn-danger submit-btn" type="submit" data-loading-text="Wait..." >Submit</button>						
	        </div>  
			<br/><br/><br/>
	    </form>
	</div>                                        
	</div>
	</div>
</div>
<script type="text/javascript">

        jQuery(function () {
            jQuery("#username").validate({
                expression: "if (VAL !='NULL' && VAL) return true; else return false;",
                message: "Should be filled *"
            });
           
            jQuery("#email").validate({
                expression: "if (VAL.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/)) return true; else return false;",
                message: "Should be a valid Email id *"
            });

           
            jQuery("#message").validate({
                expression: "if (VAL !='NULL' && VAL) return true; else return false;",
                message: "Message not be empty *"
            });
           /*
            jQuery("#interested").validate({
                expression: "if (VAL !='NULL' && VAL) return true; else return false;",
                message: "Interested not be empty *"
            });
             jQuery("#phone").validate({
                expression: "if (VAL !='NULL' && VAL) return true; else return false;",
                message: "Phone not be empty *"
            }); */
            $("#contact_form").submit(function () {
                if ($(".ValidationErrors").length == 0) {
                    var data = $('#contact_form').serialize()+'&type=become_yumcook';
                    var page_url=$('#page_url').val();
                     $.ajax({
                        url: page_url+'users/contact',
                        type: 'POST',
                        dataType:'json',
                        data: data,
                        beforeSend: function () {
                            $('.submit-btn').button('loading');
                        },
                        success: function (data) {
                                 $('.message_board').show();

                            if (data.type== 'success') {
                                
                                $('.submit-btn').button('reset');
                                $("#username").val('');
                                $("#email").val('');
                                $("#message").val('');
                                $('.message_board').html('<div class="alert alert-success">Thanks for contacting us. We will get back to you shortly</div>');
                                $('.message_board').fadeOut( 10000 );
                            } else {
                                $('.submit-btn').button('reset');
                                $("#message").val('');
                                $("#username").val('');
                                $("#email").val('');
                                $('.message_board').html('<div class="alert alert-danger">'+data.msg+'</div>');
                                $('.message_board').fadeOut( 10000 );
                            }
                        }
                    });
                }
                return false;
            });
        });

    </script> 