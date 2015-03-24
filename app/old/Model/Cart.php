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

}
