<?php
App::uses('AppModel', 'Model');
App::uses('CakeEmail', 'Network/Email');
class User extends AppModel {

////////////////////////////////////////////////////////////
    public $hasMany=array('Product','Review'=>array('foreignKey'=>'cook_id'));
    public $validate = array(
        'name' => array(
            'rule1' => array(
                'rule' => array('notempty'),
                'message' => 'mame is required',
                //'allowEmpty' => false,
                //'required' => false,
            ),
        ),
        'username' => array(
            'rule1' => array(
                'rule' => array('between', 3, 60),
                'message' => 'username is required',
                'allowEmpty' => false,
                'required' => false,
            ),
            'rule2' => array(
                'rule' => array('isUnique'),
                'message' => 'username already exists',
                'allowEmpty' => false,
                'required' => false,
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
        $email->from(array('me@example.com' => 'My Site'));
        $email->sender('contact@yumadmin.com');
        $email->to($userData['User']['email']);
        $email->emailFormat('html');
        $email->subject('Registration mail');
        $body="Registration process is succcess";

        try{
            $result = $email->send($body);
        } catch (Exception $ex){
            // we could not send the email, ignore it
           return false;
        }
         return true;
    }


    public function SendAdminMail($userData){
        $email = new CakeEmail('smtp');
        $email->from(array('me@example.com' => 'Query from User'));
        $email->sender($userData['email']);
        $email->to('pravendra.kumar@webenturetech.com');
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
    
    public function sendForgetPassMail($useremail,$userName,$userId,$fullName,$pass){

        $email = new CakeEmail('smtp');
        $email->sender('admin@yumplate.com');
        $email->to($useremail);
        $email->emailFormat('html');
        $email->subject('Forget Password Mail');
        $body =" ";

        $body .=" Full Name : ".$fullName.'<br/>'.' Email : '.$userName.'<br/> Password : '.$pass.'<br />';

        $body .="Please Click on  following link to login <br />";
        $body .='<a href="http://projects.udaantechnologies.com/yumplate/">Login link</a>';

        try{
            $result = $email->send($body);
        } catch (Exception $ex){
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
