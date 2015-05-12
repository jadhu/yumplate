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
        $sendArr=array();
        $sendArr['fName']=$userData['User']['first_name'];
        $sendArr['lName']=$userData['User']['last_name'];
        $email = new CakeEmail('smtp');
        $email->from(array('support@yumplate.com' => 'YumPlate Support'));
        $email->sender('contact@yumadmin.com');
        $email->to($userData['User']['email']);
        $email->template('sendregister');
        $email->emailFormat('html');
        $email->viewVars(array('sendArr' => $sendArr));
        $email->subject('Registration mail');
        $body =" ";
        
  
        try{
            $result = $email->send();
        } catch (Exception $ex){
            // we could not send the email, ignore it
           return false;
        }
         return true;
    }

//function for send mail after social registration
public function SendQueryMail($userData,$productData){
        $sendArr=array();
        $sendArr['Name']=$userData['name'];
        $sendArr['chef']=$productData['User']['first_name'];
        $sendArr['phone']=$userData['phone'];
        $sendArr['query']=$userData['query'];
        $sendArr['useremail']=base64_decode($userData['email']);
        $sendArr['queryfor']=$userData['queryfor'];
        $sendArr['product']=$productData['Product']['name'];
        $sendArr['price']=$productData['Product']['price'];
        $sendArr['orderby']= $userData['orderBy'];
        $sendArr['pick']=$userData['pickupBy'];

        $sendmail=array($productData['User']['email'],base64_decode($userData['email']));
        $email = new CakeEmail('smtp');
        $email->from(array('support@yumplate.com' => 'YumPlate Support'));
        $email->sender('contact@yumadmin.com');
        $email->cc(Configure::read('Settings.SUPPORT_EMAIL'));
        $email->to($sendmail);
        //$email->to('prvndrkumar55@gmail.com');
        $email->template('askmail');
        $email->emailFormat('html');
        $email->viewVars(array('sendArr' => $sendArr));
        $email->subject('Ask the Cook');
        $body =" ";
        
 
        try{
            $result = $email->send();
        } catch (Exception $ex){
          //pr($ex);die;
            // we could not send the email, ignore it
           return false;
        }
         return true;
}


//function for send mail after social registration
public function SendSocialRegisterMail($userData){
        $sendArr['fName']=$userData['User']['first_name'];
        $sendArr['lName']=$userData['User']['last_name'];
        $email = new CakeEmail('smtp');
        $email->from(array('support@yumplate.com' => 'YumPlate Support'));
        $email->sender('contact@yumadmin.com');
        $email->to($userData['User']['email']);
        $email->template('sendregister');
        $email->emailFormat('html');
        $email->viewVars(array('sendArr' => $sendArr));
        $email->subject('Registration mail');
        $body =" ";
        
       
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
