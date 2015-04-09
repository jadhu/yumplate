<?php
App::uses('AppModel', 'Model');
App::uses('CakeEmail', 'Network/Email');
class User extends AppModel {

////////////////////////////////////////////////////////////
    public $hasMany=array('Product','Review'=>array('foreignKey'=>'cook_id'));
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
        $email->from(array('support@yumplate.com' => 'YUMplate Support'));
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
      <p style="font-size:16px">Hi $fName $lName, </p>

      <p style="font-size:14px">Thank you for registering with YUMplate.com  and welcome!</p>

      <p style="font-size:14px">You are just the adventurous YUMplater we have been looking for. As a member of the YUMplate community, we invite you to sample any one of our amazing meals from our various featured cooks.</p>

      <p style="font-size:14px">Please help us spread the word about YUMplate and help us grow! </p> 
      <a style="font-size:14px" target="_blank" href="https://www.facebook.com/pages/Yumplate/346586222196988">Like us on Facebook</a> <br/>  
      <a style="font-size:14px" target="_blank" href="https://instagram.com/yumplate">Instagram</a> <br/>  
      <a style="font-size:14px" target="_blank" href="https://twitter.com/yum_plate">follow us on Twitter</a>
      

      <p style="font-size:14px">Happy eating!</p> 

      <p style="font-size:14px">From your YUMplate team</p> 

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
     <p>YUMplate</p> </td> </tr> 
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
        $email->from(array('support@yumplate.com' => 'YUMplate Support'));
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
        $email->from(array('support@yumplate.com' => 'YUMplate Support'));
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
