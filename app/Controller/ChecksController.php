<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
class ChecksController extends AppController {
   public $uses=array();
   public $helper=array('Session');


public function beforeFilter() {
        //echo "call";die;
        //parent::beforeFilter();
        $this->Auth->allow();
        $this->layout='check';
       session_start();
}

public function index(){
	
 if($this->request->is('post')){

 	$password='SUMMER2015';
 	
 	if($this->request->data['password']==$password){
 		
      $this->Session->write('authorized','success');

      $this->redirect(array('controller'=>'products'));
 	}else{
 	  $this->Session->setFlash('You are not authorized !','default',array('class'=>'alert alert-danger'));
 	}
    
 }

}

}