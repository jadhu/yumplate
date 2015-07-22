<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
    </head>

    <body style="margin: 0; padding: 0;">
        <table width="100%" align="center" cellspacing="0" cellpadding="0" >
            <tr>
                <td valign="top" align="left" style=" padding-top:15px; padding-bottom:15px">
                    <table width="600" align="center" cellspacing="0" cellpadding="0" >
                        <tr>                        
                            <td valign="top" align="center" width="50%">
							<a href="http://beta.yumplate.com/" target="_blank" style="color: #2ba6cb; text-decoration: none;">
							<img  style="clear: both; display: block;  float: left;  width: 270px;  outline: medium none;  text-decoration: none; width: auto;" width="270;" height="104;" src="http://beta.yumplate.com/images/yumplate_logo2.jpg" />
							</a>
                            </td>
                            <td valign="middle" align="right" width="50%" style="font-family: arial; color: #000000; font-size: 15px;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td valign="top" align="left">
                    <table width="600" align="center" cellspacing="0" cellpadding="0" >
                        <tr>
                            <td valign="top" align="left" style="font-family: arial; font-size: 28px; padding-bottom: 10px ;padding-top: 30px">
                                Hi, <?php echo $sendArr['Name'];?>
                            </td>
                        </tr>
                    </table>
                </td> 
            </tr>
            <tr>
                <td valign="top" align="left">
                    <table width="600" align="center" cellspacing="0" cellpadding="0" >
                        <tr>
                            <td valign="top" align="left" style="font-family: arial; font-size: 18px; padding-bottom: 10px ;padding-top: 0px">
                               
                                <table width="600" align="center" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td style="font-family: arial; font-size: 18px; padding-bottom: 15px ;">
                                  Thank you for contacting us. A YumPlate staff will get back to you shortly.
                                  </td>
                                </tr>
                                </table>
                               <table width="600" align="center" cellspacing="0" cellpadding="0" >
                               		<tr>
                               			<td aling="left" width="20%" style="font-family: arial; color: #000; font-size: 14px; line-height:20px;">Meal Name</td>
                               			<td aling="left" width="10%" style="font-family: arial; color: #000; font-size: 14px; line-height:20px;">:</td>
                               			<td aling="left" width="70%" style="font-family: arial; color: #000; font-size: 14px; line-height:20px;"><?php echo $sendArr['product'];?></td>
                               		</tr>
                               		<tr>
                               			<td aling="left" width="20%" style="font-family: arial; color: #000; font-size: 14px; line-height:20px;">Cook</td>
                               			<td aling="left" width="10%" style="font-family: arial; color: #000; font-size: 14px; line-height:20px;">:</td>
                               			<td aling="left" width="70%" style="font-family: arial; color: #000; font-size: 14px; line-height:20px;"><?php echo $sendArr['chef'];?></td>
                               		</tr>
                               		<tr>
                               			<td aling="left" width="20%" style="font-family: arial; color: #000; font-size: 14px; line-height:20px;">Order By</td>
                               			<td aling="left" width="10%" style="font-family: arial; color: #000; font-size: 14px; line-height:20px;">:</td>
                               			<td aling="left" width="70%" style="font-family: arial; color: #000; font-size: 14px; line-height:20px;"><?php echo $sendArr['orderby'];?></td>
                               		</tr>
                               		<tr>
                               			<td aling="left" width="20%" style="font-family: arial; color: #000; font-size: 14px; line-height:20px;">Pickup By</td>
                               			<td aling="left" width="10%" style="font-family: arial; color: #000; font-size: 14px; line-height:20px;">:</td>
                               			<td aling="left" width="70%" style="font-family: arial; color: #000; font-size: 14px; line-height:20px;"><?php echo $sendArr['pick'];?></td>
                               		</tr>
                               		<tr>
                               			<td aling="left" width="20%" style="font-family: arial; color: #000; font-size: 14px; line-height:20px;">About</td>
                               			<td aling="left" width="10%" style="font-family: arial; color: #000; font-size: 14px; line-height:20px;">:</td>
                               			<td aling="left" width="70%" style="font-family: arial; color: #000; font-size: 14px; line-height:20px;"><?php echo $sendArr['queryfor'];?></td>
                               		</tr>
                               		<tr>
                               			<td aling="left" width="20%" style="font-family: arial; color: #000; font-size: 14px; line-height:20px;">Question</td>
                               			<td aling="left" width="10%" style="font-family: arial; color: #000; font-size: 14px; line-height:20px;">:</td>
                               			<td aling="left" width="70%" style="font-family: arial; color: #000; font-size: 14px; line-height:20px;"><?php echo $sendArr['query'] ;?></td>
                               		</tr>
                               		<tr>
                               			<td aling="left" width="20%" style="font-family: arial; color: #000; font-size: 14px; line-height:20px;">Phone</td>
                               			<td aling="left" width="10%" style="font-family: arial; color: #000; font-size: 14px; line-height:20px;">:</td>
                               			<td aling="left" width="70%" style="font-family: arial; color: #000; font-size: 14px; line-height:20px;"><?php echo $sendArr['phone'];?></td>
                               		</tr>
                               </table>
								
                            </td>
                        </tr>
                    </table>
                </td> 
            </tr>

            <tr>
                <td valign="top" align="left" >
                    <table width="600" align="center" cellspacing="0" cellpadding="0">
                        <tr>
                            <td  valign="top" align="left">                                
                                <table width="100%" align="center" cellspacing="0" cellpadding="0" style="background: #EBEBEB; padding-top: 15px; padding-right: 15px; padding-left: 15px; padding-bottom: 15px;">
                                    <tr>
                                        <td valign="top" align="left" width="50%" style="font-family: arial; font-size: 14px; padding-bottom: 10px ;padding-right: 10px">                                           
                                            <table width="100%" align="center" cellspacing="0" cellpadding="0">                                            	<tr>
                                            		<td style="font-size: 20px; color: #000; font-family: arial; padding-bottom: 10px; display: inline-block; ">Connect With Us:</td>
                                            	</tr>
                                            </table>
                                            <br/>
                                            <table width="100%" align="center" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td align="center" style="background: #3b5998; padding-left: 10px; padding-right: 10px; padding-top: 10px; padding-bottom: 10px; border: 1px solid #2d4473; font-size: 14px; font-family: arial; color: #fff;">
														<a href="https://www.facebook.com/pages/Yumplate/346586222196988" style="font-size: 14px; font-family: arial; color: #fff; display: block; text-decoration: none;" >Facebook</a></td>
                                                </tr>
                                            </table>
                                            <br/>
                                            <table width="100%" align="center" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td align="center" style="background: #00acee; padding-left: 10px; padding-right: 10px; padding-top: 10px; padding-bottom: 10px; border: 1px solid #0087bb; font-size: 14px; font-family: arial; color: #fff;">
														<a href="https://twitter.com/yum_plate" style="font-size: 14px; font-family: arial; color: #fff; display: block;  text-decoration: none;" >Twitter</a></td>
                                                </tr>
                                            </table>
                                            <br/>
                                            <table width="100%" align="center" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td align="center" style="background: #db4a39; padding-left: 10px; padding-right: 10px; padding-top: 10px; padding-bottom: 10px; border: 1px solid #cc0000; font-size: 14px; font-family: arial; color: #fff;">
														<a href="https://instagram.com/yumplate" style="font-size: 14px; font-family: arial; color: #fff; display: block;  text-decoration: none;" >Instagram</a></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td valign="top" width="50%" align="left" style="font-family: arial; font-size: 14px; padding-bottom: 10px ;padding-left: 10px">                                            
                                            <table width="100%" align="center" cellspacing="0" cellpadding="0">                                            	<tr>
                                            		<td style="font-size: 20px; color: #000; font-family: arial; padding-bottom: 10px; display: inline-block; ">Contact Info:</td>
                                            	</tr>
                                            </table>
                                            <br/>
                                            <table width="100%" align="left" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td align="left" style="font-size: 14px; color:#000; font-family: arial; padding-bottom: 15px;">Phone : 647-607-0986</td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-size: 14px; color:#000; font-family: arial;">Email : <a href="mailto:info@yumplate.com" style="color:#2ba6cb; text-decoration: none;">info@yumplate.com</a></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>                   
                </td> 
            </tr>            
            <tr>
                <td align="center" valign="middle" style="padding-top:10px; padding-bottom:10px;">
                    <a href="http://beta.yumplate.com/privacypolicy" style="font-size: 14px;  color: #2ba6cb; line-height: 19px; font-family: arial; text-decoration: none;">Terms</a> | <a href="http://beta.yumplate.com/term_and_conditions" style=" color: #2ba6cb;font-size: 14px; line-height: 19px; font-family: arial; text-decoration: none;">Privacy</a> 
                </td>
            </tr>
        </table>
    </body>
</html>
