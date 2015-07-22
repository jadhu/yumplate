<?php
App::uses('AppModel', 'Model');
class Cart extends AppModel {
	//var $hasOne=array('User','Product');

////////////////////////////////////////////////////////////

 public $belongsTo = array(
     'Product' => array(
          'className' => 'Product',
           'foreignKey' => 'product_id',
           'group'=>'day'
          
      ),
      'User' => array(
          'className' => 'User',
           'foreignKey' => 'cook_id',
          
      )
 );

////////////////////////////////////////////////////////////


function afterSave($created,$options=array()) {
    if($created) {
       
        $created_day=strtolower(date('l',strtotime($this->data['Cart']['created'])));
        $pick_day=date('l',strtotime($this->data['Cart']['pick_up_day']));
        $this->id=$this->data['Cart']['id'];
        if($created_day==$pick_day){
         $this->saveField('order_date',date('Y-m-d',strtotime($this->data['Cart']['created'])));
        }else{
          $order_date=$this->closestDate($pick_day);
          $this->saveField('order_date',$order_date);
        }
    }
}

function closestDate($day){

    $day = ucfirst($day);
    if(date('l', time()) == $day)
        return date("Y-m-d", time());
    else if(abs(time()-strtotime('next '.$day)) < abs(time()-strtotime('last '.$day)))
        return date("Y-m-d", strtotime('next '.$day));
    else
        return date("Y-m-d", strtotime('last '.$day));

}



}
