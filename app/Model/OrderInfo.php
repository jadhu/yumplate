<?php
App::uses('AppModel', 'Model');
class OrderInfo extends AppModel {


   /*  public $belongsTo = array(
        'Order' => array(
            'className' => 'Order',
            'foreignKey' => 'order_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,
            'counterScope' => array(),
        )
    );*/

////////////////////////////////////////////////////////////

    public $validate = array(
        'phone' => array(
           /* 'rule1' => array(
                'rule' => array('isValidUSPhoneFormat'),
            )*/

        'rule' => 'numeric',
        'allowEmpty' => false, //validate only if not empty
        'message'=>'Phone number should be numeric'
        ),
    

        'email' => array('email'),
    );



 /*isValidUSPhoneFormat() - Custom method to validate US Phone Number
 * @params Int $phone
 */
 function isValidUSPhoneFormat($phone){

 $phone_no=$phone['phone'];
 $errors = array();
    if(empty($phone_no)) {
        $errors [] = "Please enter Phone Number";
    }
    else if (!preg_match('/^[(]{0,1}[0-9]{3}[)]{0,1}[-\s.]{0,1}[0-9]{3}[-\s.]{0,1}[0-9]{4}$/', $phone_no)) {
        $errors [] = "Please enter valid Phone Number";
    } 

    if (!empty($errors))
    return implode("\n", $errors);

    return true;
}

}