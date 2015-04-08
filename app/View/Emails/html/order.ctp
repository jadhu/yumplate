<div style="background-color: #f5f5f5; width: 100%; -webkit-text-size-adjust: none !important; margin: 0; padding: 70px 0 70px 0;"> 

<table cellspacing="0" cellpadding="0" border="0" style="width: 100%;"> 
	<tbody> 
	<tr> 
<td align="center" valign="top" xml="lang" style="text-align: left;"> 
 <div id="template_header_image">&nbsp;</div> 
 <table cellspacing="0" cellpadding="0" border="0" id="template_container" style="box-shadow: 0px 0px 0px 3px rgba(0, 0, 0, 0.024) ! important; background-color: #fdfdfd; border: 1px solid #dcdcdc; border-radius: 6px ! important; width: 900px;"> 
 <tbody> 
 <tr> 
 <td align="center" valign="top" xml="lang"> 
 <table cellspacing="0" cellpadding="0" border="0" bgcolor="#557da1" id="template_header" style="background-color: #557da1; color: #ffffff; border-top-left-radius: 6px ! important; border-top-right-radius: 6px ! important; border-bottom: 0px none; font-family: Arial; font-weight: bold; line-height: 100%; vertical-align: middle; width: 600px;"> 
 <tbody> 
 <tr> <td xml="lang" style="text-align:center;"> 
 <h1 style="color: #ffffff; margin: 0; padding: 28px 24px; text-shadow: 0 1px 0 #7797b4; display: block; font-family: Arial; font-size: 30px; font-weight: bold; text-align: center; line-height: 150%;">Thank you for your order</h1> </td> </tr> 
 </tbody> 
 </table> 
 </td> 
 </tr>

  <tr> 
  <td align="center" valign="top" xml="lang"> <table cellspacing="0" cellpadding="0" border="0" id="template_body" style="width: 600px;"> 
  <tbody> 
  <tr> 
  <td valign="top" style="background-color: #fdfdfd; border-radius: 6px !important;" xml="lang"> 
  <table cellspacing="0" cellpadding="20" border="0" style="width: 100%;"> 
  <tbody> 
  <tr> 
  <td valign="top" xml="lang"> <div style="color: #737373; font-family: Arial; font-size: 14px; line-height: 150%; text-align: left;"> 
  <p> Dear <?php echo $shop['Order']['first_name'].' '.$shop['Order']['last_name'];?>, Your order has been received and is now being processed. Your order details are shown below for your reference.One of our YUMplate staff will be contacting you shortly:</p> 
  <h2 style="color: #505050; display: block; font-family: Arial; font-size: 30px; font-weight: bold; margin-top: 10px; margin-right: 0; margin-bottom: 10px; margin-left: 0; text-align: left; line-height: 150%;">Order: #<?php echo $shop['Order']['id'];?></h2> 

  <table cellspacing="0" cellpadding="6" border="1" style="width: 100%; border: 1px solid #eee;"> <thead> 
  <tr>
  <th style="text-align: left; border: 1px solid #eee;" scope="col">Product</th>
  <th style="text-align: left; border: 1px solid #eee;" scope="col">Price</th>
  <th style="text-align: left; border: 1px solid #eee;" scope="col">Quantity</th>
  <th style="text-align: left; border: 1px solid #eee;" scope="col">Pickup Time</th>
  <th style="text-align: left; border: 1px solid #eee;" scope="col">Pickup Date</th>
  <th style="text-align: left; border: 1px solid #eee;" scope="col">Chef Name</th>
  <th style="text-align: left; border: 1px solid #eee;" scope="col">Special comment </th>
  <th style="text-align: left; border: 1px solid #eee;" scope="col">Chef Rating</th>

  <th style="text-align: left; border: 1px solid #eee;" scope="col">Discount</th>
  <th style="text-align: left; border: 1px solid #eee;" scope="col">Subtotal</th>
  </tr> </thead> 
  <tbody> 
  <?php foreach ($shop['OrderItem'] as $orderitem): ?>
   <tr> 
   <td style="text-align: left; vertical-align: middle; border: 1px solid #eee; word-wrap: break-word;" xml="lang">
   <?php echo $orderitem['name']; ?>

   </td>
   <td style="text-align: left; vertical-align: middle; border: 1px solid #eee;" xml="lang"><span class="amount">
   $<?php echo $orderitem['price']; ?></span>
   </td> 
   <td style="text-align: left; vertical-align: middle; border: 1px solid #eee;" xml="lang"><?php echo $orderitem['quantity']; ?>
   </td>
    <td style="text-align: left; vertical-align: middle; border: 1px solid #eee;" xml="lang"><?php echo date('h:i A', strtotime($orderitem['pick_time_from'])).'-'.date('h:i A', strtotime($orderitem['pick_time_to'])); ?>
   </td>  
   <td style="text-align: left; vertical-align: middle; border: 1px solid #eee;" xml="lang"><?php echo $orderitem['order_date']; ?>
   </td> 
   <td style="text-align: left; vertical-align: middle; border: 1px solid #eee;" xml="lang"><span class="name">
 <?php echo $orderitem['cook_name']; ?>	</span>
   </td> 
    <td style="text-align: left; vertical-align: middle; border: 1px solid #eee;" xml="lang"><span class="name">
    <?php echo $orderitem['comment']; ?> </span>
   </td> 
   <td style="text-align: left; vertical-align: middle; border: 1px solid #eee;" xml="lang">
   <a href="http://beta.yumplate.com/u/<?php echo $orderitem['username']; ?>" target="_blank">
   <img src="http://beta.yumplate.com/img/ReviewStar/<?php echo ($orderitem['cook_rating']>5)?5:$orderitem['cook_rating']; ?>_star.png"/></a>
   </td>
    <td style="text-align: left; vertical-align: middle; border: 1px solid #eee;" xml="lang"><span class="amount">
   <?php echo !empty($orderitem['discount'])?'$'.$orderitem['discount']:''; ?></span>
   </td>
   <td style="text-align: left; vertical-align: middle; border: 1px solid #eee;" xml="lang"><span class="amount">
   $<?php echo $orderitem['subtotal']; ?></span>
   </td> 
   </tr> 
   <?php endforeach; ?>
   </tbody> 
   <tfoot> 
    
    <tr>
    <th style="text-align: left; border: 1px solid #eee;" scope="row" colspan="2">Payment Method:</th> 
    <td colspan="5" style="text-align: left; border: 1px solid #eee;" xml="lang">Paypal</td> 
    </tr> 
    <tr><th style="text-align: left; border: 1px solid #eee;" scope="row" colspan="2">Hst:</th> 
    <td colspan="5" style="text-align: left; border: 1px solid #eee;" xml="lang"><span class="amount">$<?php echo $shop['Order']['subtotal'];?></span></td> 
    </tr> 
    <tr><th style="text-align: left; border: 1px solid #eee;" scope="row" colspan="2">Order Total:</th> 
    <td colspan="5" style="text-align: left; border: 1px solid #eee;" xml="lang"><span class="amount">$<?php echo $shop['Order']['total'];?></span></td> 
    </tr> 
    </tfoot> 
    </table> 
    <p><strong> Order Date: </strong> <?php echo date('Y-m-d',strtotime($shop['Order']['created']));?></p> 
   
     
    <!--h2 style="color: #505050; display: block; font-family: Arial; font-size: 30px; font-weight: bold; margin-top: 10px; margin-right: 0; margin-bottom: 10px; margin-left: 0; text-align: left; line-height: 150%;">Customer details</h2> 
    <p><strong>First Name:</strong> 
    <!--a target="_blank" onclick="top.Popup.composeWindow('pcompose.php?sendto=<?php echo $shop['Order']['email'];?>'); return false;" href="mailto:swetanka.jaiswal@webenturetech.com"><?php echo $shop['Order']['email'];?></a>
    <?php echo $shop['Order']['first_name'];//$this->Session->read('Auth.User.first_name');?>
    </p> 
    <p><strong>Last Name:</strong> <?php echo $shop['OrderItem']['last_name'];//$this->Session->read('Auth.User.last_name');?></p--> 
    <table cellspacing="0" cellpadding="0" border="0" style="width: 100%; vertical-align: top;"> 
    <tbody> 
     <tr> 
     <td width="50%" valign="top" xml="lang"> <h3 style="color: #505050; display: block; font-family: Arial; font-size: 26px; font-weight: bold; margin-top: 10px; margin-right: 0; margin-bottom: 10px; margin-left: 0; text-align: left; line-height: 150%;">Billing address</h3> 

     <p> <?php echo $shop['Order']['first_name'] .' '.$shop['Order']['last_name']; ?><br><?php echo $shop['Order']['billing_address'];?> ,<?php echo $shop['Order']['billing_city'];?>, <?php echo $shop['Order']['billing_state'];?> <?php echo $shop['Order']['billing_zip'];?> <br> </p> </td> 
     <td width="50%" valign="top" xml="lang"> 
     <h3 style="color: #505050; display: block; font-family: Arial; font-size: 26px; font-weight: bold; margin-top: 10px; margin-right: 0; margin-bottom: 10px; margin-left: 0; text-align: left; line-height: 150%;">Shipping address</h3> 
     <p><?php echo $shop['Order']['first_name'] .' '.$shop['Order']['last_name']; ?><br><?php echo $shop['Order']['billing_address'];?> , <?php echo $shop['Order']['shipping_city'];?><br><?php echo $shop['Order']['billing_state'];?>, <?php echo $shop['Order']['shipping_country'];?> <?php echo $shop['Order']['shipping_zip'];?></p> </td> 
     </tr> 
     </tbody> 
     </table> 
     <h3 style="color: #505050; display: block; font-family: Arial; font-size: 30px; font-weight: bold; margin-top: 10px; margin-right: 0; margin-bottom: 10px; margin-left: 0; text-align: left; line-height: 150%;">Contact Details</h3> 
     <p><strong>Email:</strong> 
    <a target="_blank" onclick="top.Popup.composeWindow('pcompose.php?sendto=<?php echo $shop['OrderInfo']['email'];?>'); return false;" href="mailto:swetanka.jaiswal@webenturetech.com"><?php echo $shop['OrderInfo']['email'];?></a>
    </p> 
    <p><strong>Tel:</strong> <?php echo $shop['OrderInfo']['phone'];?></p> 
     </div> 
     </td> 
     </tr> 
     </tbody> 
     </table> 
     </td> 
     </tr> 
     </tbody> 
     </table> 
     </td> </tr> 
     <tr> 
     <td align="center" valign="top" xml="lang"> 
     <table cellspacing="0" cellpadding="10" border="0" id="template_footer" style="border-top: 0px none; width: 600px;"> <tbody> <tr> <td valign="top" xml="lang"> 
     <table cellspacing="0" cellpadding="10" border="0" style="width: 100%;"> <tbody> <tr> <td valign="middle" id="credit" style="border: 0; color: #99b1c7; font-family: Arial; font-size: 12px; line-height: 125%; text-align: center;" xml="lang" colspan="2"> 
     <p>YUMplate</p> </td> </tr> 
     </tbody> </table> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> </td> </tr> </tbody> 
     </table> </div>


