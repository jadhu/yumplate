<?php
App::uses('AppModel', 'Model');
App::uses('CakeEmail', 'Network/Email');
class User extends AppModel {

////////////////////////////////////////////////////////////
    public $hasMany=array('Product','Review'=>array('foreignKey'=>'cook_id','dependent'=>true));
    public $hasOne=array('Coupon');
    public $validate = array(
        'first_name' => array(
            'rule1' => array(
                'rule' => array('notempty'),
                'message' => 'First name is required',
                //'allowEmpty' => false,
                //'required' => false,
            ),
        ),
        'last_name' => array(
            'rule1' => array(
                'rule' => array('notempty'),
                'message' => 'Last name is required',
               
            ),
        ),
        'username' => array(
            'rule1' => array(
                'rule' => array('between', 3, 60),
                'message' => 'username is required',
                'allowEmpty' => false,
                
            ),
            'rule2' => array(
                'rule' => array('isUnique'),
                'message' => 'username already exists',
                'allowEmpty' => false,
               
            ),
        ),
        'email' => array(
           'rule1' => array(
                'rule' => array('isUnique'),
                'message' => 'Email already exists',
                
            ),
           'rule2' => array(
                'rule' => array('notempty'),
                'message' => 'Email field should not be empty',
                
            ),
        ),
        'oldpassword' => array(
                        array(
                        'rule' => 'notEmpty',
                        'required' => true,
                        'message' => 'Please Enter Current password'
                        ),
                        array(
                        'rule' =>'checkcurrentpasswords',
                        'message' => 'Current Password does not match'
                        )
                ),
        'password' => array(
            'rule1' => array(
                'rule' => array('minLength','8'),
                'message' => 'Password must be at least 8 characters long',
                
             ),
            'rule2' => array(
               'rule' =>  '/^(?=.*\d.*\d).*$/',
                'message' => 'Password must have atleast 2 numbers',
                
             ),
          
            'mustMatch'=>array(
                        'rule' => array('verifies'),
                        'message' => 'Both passwords must match')
        ),


    );
//////////////////////////////////////////////////////////////
  function checkcurrentpasswords()   // to check current password 
    {
        $this->id = $this->data['User']['id'];
        $user_data = $this->field('password');       
        //print_r(Security::hash($this->data['Adminpassword']['oldpassword'], 'sha1', true));
        if ($user_data == AuthComponent::password($this->data[$this->alias]['oldpassword']))
        { 
             return true;
        }
        else
        {
         return false;
        }
    } 
///////////////////////////////////////////////////////
    public function verifies() {
    return (@$this->data['User']['password']===@$this->data['User']['cpassword']);
    }

////////////////////////////////////////////////////////////

    public function beforeSave($options = array()) {
        if(isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }

////////////////////////////////////////////////////////////

    public function SendRegisterMail($userData){
        $email = new CakeEmail('smtp');
        $email->from(array('support@yumplate.com' => 'YumPlate Support'));
        $email->sender('contact@yumadmin.com');
        $email->to($userData['User']['email']);
        $email->emailFormat('html');
        $email->subject('Registration mail');
        $body =" ";
        $fName=$userData['User']['first_name'];
        $lName=$userData['User']['last_name'];
        $message= <<<"FOOBAR"


<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">             
    </head>
<body >
<div style="background-color: #f5f5f5; width: 100%; -webkit-text-size-adjust: none !important; margin: 0; padding: 0px 0 0px 0;"> 

<table cellspacing="0" cellpadding="0" border="0" style="width: 100%;"> 
    <tbody> 
    <tr> 
<td align="center" valign="top" xml="lang" style="text-align: left;"> 
 <div id="template_header_image">&nbsp;</div> 
 <table cellspacing="0" cellpadding="0" border="0" id="template_container" style="box-shadow: 0px 0px 0px 3px rgba(0, 0, 0, 0.024) ! important; background-color: #fdfdfd; border: 1px solid #dcdcdc; border-radius: 6px ! important; width: 800px; margin:0 auto;"> 
 <tbody> 
 <tr> 
 <td align="center" valign="top" xml="lang"> 
 </td> 
 </tr>

  <tr> 
  <td align="center" valign="top" xml="lang"> <table cellspacing="0" cellpadding="0" border="0" id="template_body" style="width: 600px;"> 
  <tbody> 
  <tr> 
  <td valign="top" style="background-color: #fdfdfd; border-radius: 6px !important; padding-top: 35px;" xml="lang"> 
  <table cellspacing="0" cellpadding="20" border="0" style="width: 100%;"> 
  <tbody> 
 <tr> 
      <p style="font-size:14px">Hi $fName $lName, </p>

      <p style="font-size:14px">Thank you for registering with YumPlate.com  and welcome!</p>

      <p style="font-size:14px">You are just the adventurous Yummer we have been looking for.a member of the YumPlate community, we invite you to sample any one of our amazing meals from our various featured cooks.</p>

      <p style="font-size:14px">Please help us spread the word about YumPlate and help us grow! </p> 
      <span style="font-size:14px"> Like us on Facebook</span> <a style="font-size:14px" target="_blank" href="https://www.facebook.com/pages/Yumplate/346586222196988"><img src="http://beta.yumplate.com/images/fb_color.png" style="width:20px;" /></a> &nbsp;&nbsp;  and
      <span style="font-size:14px">Instagram</span> <a style="font-size:14px" target="_blank" href="https://instagram.com/yumplate"><img src="http://beta.yumplate.com/images/insta_color.png" style="width:20px;"/></a> &nbsp; &nbsp;  and
      <span style="font-size:14px">follow us on Twitter</span> <a style="font-size:14px" target="_blank" href="https://twitter.com/yum_plate"><img src="http://beta.yumplate.com/images/twitter_color.png" style="width:20px;"/></a>
      

      <p style="font-size:14px">Happy eating!</p> 

      <p style="font-size:14px">From your YumPlate team</p> 

      <a style="font-size:14px" target="_blank" href="http://beta.yumplate.com">www.yumplate.com</a>
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
     <p>YumPlate</p> </td> </tr> 
     </tbody> </table> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> </td> </tr> </tbody> 
     </table> </div>  
</body>
</html>
FOOBAR;
        try{
            $result = $email->send($message);
        } catch (Exception $ex){
            // we could not send the email, ignore it
           return false;
        }
         return true;
    }

//function for send mail after social registration
public function SendQueryMail($userData,$productData){
        $sendmail=array($productData['User']['email'],base64_decode($userData['email']));
        $email = new CakeEmail('smtp');
        $email->from(array('support@yumplate.com' => 'YumPlate Support'));
        $email->sender('contact@yumadmin.com');
        $email->cc(Configure::read('Settings.SUPPORT_EMAIL'));
        $email->to($sendmail);
        //$email->to('pravendra.kumar@webenturetech.com');
        $email->emailFormat('html');
        $email->subject('Ask the Cook');
        $body =" ";
        
        $Name=$userData['name'];
        $chef=$productData['User']['first_name'];
        $phone=$userData['phone'];
        $query=$userData['query'];
        $useremail=base64_decode($userData['email']);
        $queryfor=$userData['queryfor'];
        $product=$productData['Product']['name'];
        $price=$productData['Product']['price'];
        $orderby= $userData['orderBy'];
        $pick=$userData['pickupBy'];
        $message= <<<"FOOBAR"

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" data-ember-extension="1">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<meta content="width=device-width" name="viewport">
<style>#outlook a{padding:0;}body{width:100%!important;min-width:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;margin:0;padding:0;}.ExternalClass{width:100%;}.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%;}#backgroundTable{margin:0;padding:0;width:100%!important;line-height:100%!important;}img{outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;width:auto;max-width:100%;float:left;clear:both;display:block;}center{width:100%;min-width:580px;}a img{border:none;}p{margin:0 0 0 10px;}table{border-spacing:0;border-collapse:collapse;}td{word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;}table,tr,td{padding:0;vertical-align:top;text-align:left;}hr{color:#d9d9d9;background-color:#d9d9d9;height:1px;border:none;}table.body{height:100%;width:100%;}table.container{width:580px;margin:0 auto;text-align:inherit;}table.row{padding:0px;width:100%;position:relative;}table.container table.row{display:block;}td.wrapper{padding:10px 20px 0px 0px;position:relative;}table.columns,table.column{margin:0 auto;}table.columns td,table.column td{padding:0px 0px 10px;}table.columns td.sub-columns,table.column td.sub-columns,table.columns td.sub-column,table.column td.sub-column{padding-right:10px;}td.sub-column,td.sub-columns{min-width:0px;}table.row td.last,table.container td.last{padding-right:0px;}table.one{width:30px;}table.two{width:80px;}table.three{width:130px;}table.four{width:180px;}table.five{width:230px;}table.six{width:280px;}table.seven{width:330px;}table.eight{width:380px;}table.nine{width:430px;}table.ten{width:480px;}table.eleven{width:530px;}table.twelve{width:580px;}table.one center{min-width:30px;}table.two center{min-width:80px;}table.three center{min-width:130px;}table.four center{min-width:180px;}table.five center{min-width:230px;}table.six center{min-width:280px;}table.seven center{min-width:330px;}table.eight center{min-width:380px;}table.nine center{min-width:430px;}table.ten center{min-width:480px;}table.eleven center{min-width:530px;}table.twelve center{min-width:580px;}table.one .panel center{min-width:10px;}table.two .panel center{min-width:60px;}table.three .panel center{min-width:110px;}table.four .panel center{min-width:160px;}table.five .panel center{min-width:210px;}table.six .panel center{min-width:260px;}table.seven .panel center{min-width:310px;}table.eight .panel center{min-width:360px;}table.nine .panel center{min-width:410px;}table.ten .panel center{min-width:460px;}table.eleven .panel center{min-width:510px;}table.twelve .panel center{min-width:560px;}.body .columns td.one,.body .column td.one{width:8.333333%;}.body .columns td.two,.body .column td.two{width:16.666666%;}.body .columns td.three,.body .column td.three{width:25%;}.body .columns td.four,.body .column td.four{width:33.333333%;}.body .columns td.five,.body .column td.five{width:41.666666%;}.body .columns td.six,.body .column td.six{width:50%;}.body .columns td.seven,.body .column td.seven{width:58.333333%;}.body .columns td.eight,.body .column td.eight{width:66.666666%;}.body .columns td.nine,.body .column td.nine{width:75%;}.body .columns td.ten,.body .column td.ten{width:83.333333%;}.body .columns td.eleven,.body .column td.eleven{width:91.666666%;}.body .columns td.twelve,.body .column td.twelve{width:100%;}td.offset-by-one{padding-left:50px;}td.offset-by-two{padding-left:100px;}td.offset-by-three{padding-left:150px;}td.offset-by-four{padding-left:200px;}td.offset-by-five{padding-left:250px;}td.offset-by-six{padding-left:300px;}td.offset-by-seven{padding-left:350px;}td.offset-by-eight{padding-left:400px;}td.offset-by-nine{padding-left:450px;}td.offset-by-ten{padding-left:500px;}td.offset-by-eleven{padding-left:550px;}td.expander{visibility:hidden;width:0px;padding:0!important;}table.columns .text-pad,table.column .text-pad{padding-left:10px;padding-right:10px;}table.columns .left-text-pad,table.columns .text-pad-left,table.column .left-text-pad,table.column .text-pad-left{padding-left:10px;}table.columns .right-text-pad,table.columns .text-pad-right,table.column .right-text-pad,table.column .text-pad-right{padding-right:10px;}.block-grid{width:100%;max-width:580px;}.block-grid td{display:inline-block;padding:10px;}.two-up td{width:270px;}.three-up td{width:173px;}.four-up td{width:125px;}.five-up td{width:96px;}.six-up td{width:76px;}.seven-up td{width:62px;}.eight-up td{width:52px;}table.center,td.center{text-align:center;}h1.center,h2.center,h3.center,h4.center,h5.center,h6.center{text-align:center;}span.center{display:block;width:100%;text-align:center;}img.center{margin:0 auto;float:none;}.show-for-small,.hide-for-desktop{display:none;}body,table.body,h1,h2,h3,h4,h5,h6,p,td{color:#222222;font-family:"Helvetica","Arial",sans-serif;font-weight:normal;padding:0;margin:0;text-align:left;line-height:1.3;}h1,h2,h3,h4,h5,h6{word-break:normal;}h1{font-size:40px;}h2{font-size:36px;}h3{font-size:32px;}h4{font-size:28px;}h5{font-size:24px;}h6{font-size:20px;}body,table.body,p,td{font-size:14px;line-height:19px;}p.lead,p.lede,p.leed{font-size:18px;line-height:21px;}p{margin-bottom:10px;}small{font-size:10px;}a{color:#2ba6cb;text-decoration:none;}a:hover{color:#2795b6!important;}a:active{color:#2795b6!important;}a:visited{color:#2ba6cb!important;}h1 a,h2 a,h3 a,h4 a,h5 a,h6 a{color:#2ba6cb;}h1 a:active,h2 a:active,h3 a:active,h4 a:active,h5 a:active,h6 a:active{color:#2ba6cb!important;}h1 a:visited,h2 a:visited,h3 a:visited,h4 a:visited,h5 a:visited,h6 a:visited{color:#2ba6cb!important;}.panel{background:#f2f2f2;border:1px solid #d9d9d9;padding:10px!important;}.sub-grid table{width:100%;}.sub-grid td.sub-columns{padding-bottom:0;}table.button,table.tiny-button,table.small-button,table.medium-button,table.large-button{width:100%;overflow:hidden;}table.button td,table.tiny-button td,table.small-button td,table.medium-button td,table.large-button td{display:block;width:auto!important;text-align:center;background:#2ba6cb;border:1px solid #2284a1;color:#ffffff;padding:8px 0;}table.tiny-button td{padding:5px 0 4px;}table.small-button td{padding:8px 0 7px;}table.medium-button td{padding:12px 0 10px;}table.large-button td{padding:21px 0 18px;}table.button td a,table.tiny-button td a,table.small-button td a,table.medium-button td a,table.large-button td a{font-weight:bold;text-decoration:none;font-family:Helvetica,Arial,sans-serif;color:#ffffff;font-size:16px;}table.tiny-button td a{font-size:12px;font-weight:normal;}table.small-button td a{font-size:16px;}table.medium-button td a{font-size:20px;}table.large-button td a{font-size:24px;}table.button:hover td,table.button:visited td,table.button:active td{background:#2795b6!important;}table.button:hover td a,table.button:visited td a,table.button:active td a{color:#fff!important;}table.button:hover td,table.tiny-button:hover td,table.small-button:hover td,table.medium-button:hover td,table.large-button:hover td{background:#2795b6!important;}table.button:hover td a,table.button:active td a,table.button td a:visited,table.tiny-button:hover td a,table.tiny-button:active td a,table.tiny-button td a:visited,table.small-button:hover td a,table.small-button:active td a,table.small-button td a:visited,table.medium-button:hover td a,table.medium-button:active td a,table.medium-button td a:visited,table.large-button:hover td a,table.large-button:active td a,table.large-button td a:visited{color:#ffffff!important;}table.secondary td{background:#e9e9e9;border-color:#d0d0d0;color:#555;}table.secondary td a{color:#555;}table.secondary:hover td{background:#d0d0d0!important;color:#555;}table.secondary:hover td a,table.secondary td a:visited,table.secondary:active td a{color:#555!important;}table.success td{background:#5da423;border-color:#457a1a;}table.success:hover td{background:#457a1a!important;}table.alert td{background:#c60f13;border-color:#970b0e;}table.alert:hover td{background:#970b0e!important;}table.radius td{-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;}table.round td{-webkit-border-radius:500px;-moz-border-radius:500px;border-radius:500px;}body.outlook p{display:inline!important;}@media only screen and (max-width: 600px) {table[class="body"] img{width:auto!important;height:auto!important;}table[class="body"] center{min-width:0!important;}table[class="body"] .container{width:95%!important;}table[class="body"] .row{width:100%!important;display:block!important;}table[class="body"] .wrapper{display:block!important;padding-right:0!important;}table[class="body"] .columns,table[class="body"] .column{table-layout:fixed!important;float:none!important;width:100%!important;padding-right:0px!important;padding-left:0px!important;display:block!important;}table[class="body"] .wrapper.first .columns,table[class="body"] .wrapper.first .column{display:table!important;}table[class="body"] table.columns td,table[class="body"] table.column td{width:100%!important;}table[class="body"] .columns td.one,table[class="body"] .column td.one{width:8.333333%!important;}table[class="body"] .columns td.two,table[class="body"] .column td.two{width:16.666666%!important;}table[class="body"] .columns td.three,table[class="body"] .column td.three{width:25%!important;}table[class="body"] .columns td.four,table[class="body"] .column td.four{width:33.333333%!important;}table[class="body"] .columns td.five,table[class="body"] .column td.five{width:41.666666%!important;}table[class="body"] .columns td.six,table[class="body"] .column td.six{width:50%!important;}table[class="body"] .columns td.seven,table[class="body"] .column td.seven{width:58.333333%!important;}table[class="body"] .columns td.eight,table[class="body"] .column td.eight{width:66.666666%!important;}table[class="body"] .columns td.nine,table[class="body"] .column td.nine{width:75%!important;}table[class="body"] .columns td.ten,table[class="body"] .column td.ten{width:83.333333%!important;}table[class="body"] .columns td.eleven,table[class="body"] .column td.eleven{width:91.666666%!important;}table[class="body"] .columns td.twelve,table[class="body"] .column td.twelve{width:100%!important;}table[class="body"] td.offset-by-one,table[class="body"] td.offset-by-two,table[class="body"] td.offset-by-three,table[class="body"] td.offset-by-four,table[class="body"] td.offset-by-five,table[class="body"] td.offset-by-six,table[class="body"] td.offset-by-seven,table[class="body"] td.offset-by-eight,table[class="body"] td.offset-by-nine,table[class="body"] td.offset-by-ten,table[class="body"] td.offset-by-eleven{padding-left:0!important;}table[class="body"] table.columns td.expander{width:1px!important;}table[class="body"] .right-text-pad,table[class="body"] .text-pad-right{padding-left:10px!important;}table[class="body"] .left-text-pad,table[class="body"] .text-pad-left{padding-right:10px!important;}table[class="body"] .hide-for-small,table[class="body"] .show-for-desktop{display:none!important;}table[class="body"] .show-for-small,table[class="body"] .hide-for-desktop{display:inherit!important;}}.sleft{float:left; width:48%; font-weight:bold; font-size:13px;}
.sright{float:left; width:48%;}</style>
<style>table.facebook td{background:#3b5998;border-color:#2d4473;}table.facebook:hover td{background:#2d4473!important;}table.twitter td{background:#00acee;border-color:#0087bb;}table.twitter:hover td{background:#0087bb!important;}table.google-plus td{background-color:#DB4A39;border-color:#CC0000;}table.google-plus:hover td{background:#CC0000!important;}.template-label{color:#ffffff;font-weight:bold;font-size:11px;}.callout .wrapper{padding-bottom:20px;}.callout .panel{background:#ECF8FF;border-color:#b9e5ff;}.header{background:#999999;}.footer .wrapper{background:#ebebeb;}.footer h5{padding-bottom:10px;}table.columns .text-pad{padding-left:10px;padding-right:10px;}table.columns .left-text-pad{padding-left:10px;}table.columns .right-text-pad{padding-right:10px;}@media only screen and (max-width: 600px) {table[class="body"] .right-text-pad{padding-left:10px!important;}table[class="body"] .left-text-pad{padding-right:10px!important;}}</style>
</head>
<body>
<table class="body">
<tbody><tr>
<td valign="top" align="center" class="center">
<center>
<table class="row header">
<tbody><tr>
<td align="center" class="center">
<center>
<table class="container">
<tbody><tr>
<td class="wrapper last">
<table class="twelve columns">
<tbody><tr>
<td class="six sub-columns">
<a href="http://beta.yumplate.com/" target="_blank">
<img  width="67px;" height="104px;" src="http://beta.yumplate.com/images/yumplate_logo2.jpg">
</a>
</td>
<td style="text-align:right; vertical-align:middle;" class="six sub-columns last">
<span class="template-label"></span>
</td>
<td class="expander"></td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</center>
</td>
</tr>
</tbody></table>
<table class="container">
<tbody><tr>
<td>
<table class="row">
<tbody><tr>
<td class="wrapper last">
<table class="twelve columns">
<tbody><tr>
<td>
<h1>Hi, $Name</h1>
<p class="lead">Thank you for contacting us . A YumPlate staff will get back to you shortly.</p>
<p><span class="sleft"> Meal Name :</span><span class="sright">$product.</span></p>
<p><span class="sleft">Cook :</span><span class="sright">$chef.</span></p>
<p><span class="sleft">Order By:</span><span class="sright">$orderby.</span></p>
<p><span class="sleft">Pickup By:</span><span class="sright">$pick.</span></p>
<p><span class="sleft">About :</span><span class="sright">$queryfor.</span></p>
<p> <span class="sleft">Question :</span><span class="sright">$query.</span></p>
<p><span class="sleft"> Phone :</span><span class="sright">$phone.</span> </p></td>
<td class="expander"></td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>

</td>
</tr>
</tbody></table>
<table class="row footer twelve columns">
<tbody><tr>
<td class="wrapper">
<table class="six columns">
<tbody><tr>
<td class="">
<h5>Connect With Us:</h5>
<table class="tiny-button facebook">
<tbody><tr>
<td>
<a href="https://www.facebook.com/pages/Yumplate/346586222196988">Facebook</a>
</td>
</tr>
</tbody></table>
<br>
<table class="tiny-button twitter">
<tbody><tr>
<td>
<a href="https://twitter.com/yum_plate">Twitter</a>
</td>
</tr>
</tbody></table>
<br>
<table class="tiny-button google-plus">
<tbody><tr>
<td>
<a href="https://instagram.com/yumplate">Instagram</a>
</td>
</tr>
</tbody></table>
</td>
<td class="expander"></td>
</tr>
</tbody></table>
</td>
<td class="wrapper last">
<table class="six columns">
<tbody><tr>
<td class="last right-text-pad">
<h5>Contact Info:</h5>
<p>Phone: 647-607-0906</p>
<p>Email: <a href="mailto:info@yumplate.com">info@yumplate.com</a></p>
</td>
<td class="expander"></td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
<table class="row">
<tbody><tr>
<td class="wrapper last">
<table class="twelve columns">
<tbody><tr>
<td align="center">
<center>
<p style="text-align:center;"><a href="http://beta.yumplate.com/privacypolicy">Terms</a> | <a href="http://beta.yumplate.com/term_and_conditions">Privacy</a> </p>
</center>
</td>
<td class="expander"></td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
 
</td>
</tr>
</tbody></table>
</center>
</td>
</tr>
</tbody></table>


</body></html>
FOOBAR;
        try{
            $result = $email->send($message);
        } catch (Exception $ex){
          //pr($ex);die;
            // we could not send the email, ignore it
           return false;
        }
         return true;
}


//function for send mail after social registration
public function SendSocialRegisterMail($userData){
        $email = new CakeEmail('smtp');
        $email->from(array('support@yumplate.com' => 'YumPlate Support'));
        $email->sender('contact@yumadmin.com');
        $email->to($userData['User']['email']);
        $email->emailFormat('html');
        $email->subject('Registration mail');
        $body =" ";
        $fName=$userData['User']['first_name'];
        $lName=$userData['User']['last_name'];
        $message= <<<"FOOBAR"


<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">             
    </head>
<body >
<div style="background-color: #f5f5f5; width: 100%; -webkit-text-size-adjust: none !important; margin: 0; padding: 0px 0 0px 0;"> 

<table cellspacing="0" cellpadding="0" border="0" style="width: 100%;"> 
    <tbody> 
    <tr> 
<td align="center" valign="top" xml="lang" style="text-align: left;"> 
 <div id="template_header_image">&nbsp;</div> 
 <table cellspacing="0" cellpadding="0" border="0" id="template_container" style="box-shadow: 0px 0px 0px 3px rgba(0, 0, 0, 0.024) ! important; background-color: #fdfdfd; border: 1px solid #dcdcdc; border-radius: 6px ! important; width: 800px; margin:0 auto;"> 
 <tbody> 
 <tr> 
 <td align="center" valign="top" xml="lang"> 
 </td> 
 </tr>

  <tr> 
  <td align="center" valign="top" xml="lang"> <table cellspacing="0" cellpadding="0" border="0" id="template_body" style="width: 600px;"> 
  <tbody> 
  <tr> 
  <td valign="top" style="background-color: #fdfdfd; border-radius: 6px !important; padding-top: 35px;" xml="lang"> 
  <table cellspacing="0" cellpadding="20" border="0" style="width: 100%;"> 
  <tbody> 
 <tr> 
      <p style="font-size:14px">Hi $fName $lName, </p>

      <p style="font-size:14px">Thank you for registering with YumPlate.com  and welcome!</p>

      <p style="font-size:14px">You are just the adventurous Yummer we have been looking for.a member of the YumPlate community, we invite you to sample any one of our amazing meals from our various featured cooks.</p>

      <p style="font-size:14px">Please help us spread the word about YumPlate and help us grow! </p> 
      <span style="font-size:14px"> Like us on Facebook</span> <a style="font-size:14px" target="_blank" href="https://www.facebook.com/pages/Yumplate/346586222196988"><img src="http://beta.yumplate.com/images/fb_color.png" style="width:20px;" /></a> &nbsp;&nbsp;  and
      <span style="font-size:14px">Instagram</span> <a style="font-size:14px" target="_blank" href="https://instagram.com/yumplate"><img src="http://beta.yumplate.com/images/insta_color.png" style="width:20px;"/></a> &nbsp; &nbsp;  and
      <span style="font-size:14px">follow us on Twitter</span> <a style="font-size:14px" target="_blank" href="https://twitter.com/yum_plate"><img src="http://beta.yumplate.com/images/twitter_color.png" style="width:20px;"/></a>
      

      <p style="font-size:14px">Happy eating!</p> 

      <p style="font-size:14px">From your YumPlate team</p> 

      <a style="font-size:14px" target="_blank" href="http://beta.yumplate.com">www.yumplate.com</a>
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
     <p>YumPlate</p> </td> </tr> 
     </tbody> </table> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> </td> </tr> </tbody> 
     </table> </div>  
</body>
</html>
FOOBAR;
        try{
            $result = $email->send($message);
        } catch (Exception $ex){
            // we could not send the email, ignore it
           return false;
        }
         return true;
    }


public function SendAdminMail($userData){
        $email = new CakeEmail('smtp');
        $email->from(array('support@yumplate.com' => 'YumPlate Support'));
        $email->sender($userData['email']);
        $email->to(Configure::read('Settings.SUPPORT_EMAIL'));
        $email->emailFormat('html');
        $email->subject('Query mail');
        $body ="Query from User :".$userData['name'].'<br/>'.' email:'.$userData['email'].'<br/> query:'.$userData['message'];

        try{
            $result = $email->send($body);
        } catch (Exception $ex){
            // we could not send the email, ignore it
           return false;
        }
         return true;
    }
    
    public function sendForgetPassMail($useremail,$userName,$userId,$fullName){

        $email = new CakeEmail('smtp');
        $email->from(array('support@yumplate.com' => 'YumPlate Support'));
       // $email->sender('support@yumplate.com');
        $email->to($useremail);
        $email->emailFormat('html');
        $email->subject('Forget Password Mail');
        $body =" ";
        
        $body .=" Full Name : ".$fullName.'<br/>'.' Email : '.$useremail.'<br/><br />';
        $current_time=date('Y-m-d h:i:s');
        $token=base64_encode($useremail);
        $body .="Please Click on  following link to update Password.This link will be expired after 1 hour ! <br />";
        $body .='<a href="http://beta.yumplate.com/updatePassword/'.$token.'?t='.base64_encode($current_time).'">Change Password</a>';

        try{
            $result = $email->send($body);
            
            $this->id=$userId;
            $this->saveField('forget_link_time',$current_time);
        } catch (Exception $ex){
           // pr($ex);die;
            // we could not send the email, ignore it
           return false;
        }
         return true;
    }

    function  updatePassword($userId,$pass)
    {
    
        $sql = "UPDATE users SET password = '$pass' WHERE id = '$userId'";
       if(!$this->query($sql)){
            return true;
        }else{
            return false;
        }
    
   }

}
