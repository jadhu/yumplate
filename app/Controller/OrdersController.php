<?php
App::uses('AppController', 'Controller');
class OrdersController extends AppController {




	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow(array('orders','admin_change_order_status'));
	}

////////////////////////////////////////////////////////////

    public function admin_index() {

        $this->Paginator = $this->Components->load('Paginator');

        $this->Paginator->settings = array(
            'Order' => array(
                'recursive' => -1,
                'contain' => array(
                    'OrderItem',
                    'OrderInfo',
                    // 'User'
                ),
                'conditions' => array(
                ),
                'order' => array(
                    'Order.created' => 'DESC'
                ),
                'limit' => 20,
                'paramType' => 'querystring',
            )
        );
        $orders = $this->Paginator->paginate();
        //pr($orders);
        $this->set(compact('orders'));
    }

////////////////////////////////////////////////////////////

    public function admin_view($id = null) {
        $order = $this->Order->find('first', array(
            'recursive' => 1,
            'conditions' => array(
                'Order.id' => $id
            )
        ));
       // pr( $order);
        if (empty($order)) {
            return $this->redirect(array('action'=>'index'));
        }
        $this->set(compact('order'));
    }

////////////////////////////////////////////////////////////

    public function admin_edit($id = null) {
        $this->Order->id = $id;
        if (!$this->Order->exists()) {
            throw new NotFoundException('Invalid order');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Order->save($this->request->data)) {
                $this->Session->setFlash('The order has been saved','default',array('class'=>'alert alert-success'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The order could not be saved. Please, try again.','default',array('class'=>'alert alert-danger'));
            }
        } else {
            $this->request->data = $this->Order->read(null, $id);
        }
    }

////////////////////////////////////////////////////////////

    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Order->id = $id;
        if (!$this->Order->exists()) {
            throw new NotFoundException('Invalid order');
        }
        if ($this->Order->delete()) {
            $this->Session->setFlash('Order deleted','default',array('class'=>'alert alert-success'));
            return $this->redirect(array('action'=>'index'));
        }else{
        $this->Session->setFlash('Order was not deleted','default',array('class'=>'alert alert-danger'));
        return $this->redirect(array('action' => 'index'));
      }
    }

////////////////////////////////////////////////////////////

    public function carts($id = null) {
    	 $this->layout='front';
         $this->loadModel('Cart');
         $this->loadModel('Setting');
         $this->loadModel('Coupon');
         if(!$this->Session->read('Auth.User.id')){
             //$this->Session->setFlash('Order was not deleted');
             $this->redirect(array('controller'=>'products','action'=>'index'));
         }
         $carts=$this->Cart->find('all',array(
                     'recursive' => -1,
                     'conditions'=>array(
                        'Cart.user_id'=>$this->Session->read('Auth.User.id')
                         ),
                     'contain'=>array(
                        'Product'=>array('fields'=>array('id','name','image','slug','pick_time_to','price','pick_time_from','day')),
                        'User'=>array('fields'=>array('id','first_name','last_name','city','country')),
                        'User.Coupon'=>array('fields'=>array('discount'))
                        )
              ));

         $ChefArr=array();
         $cartArr=array();
         $dicountArr=array();
         foreach ($carts as $key => $value) {

            $cartArr[$value['Cart']['pick_up_day']][$key]['Product']=$value['Product'];
            $cartArr[$value['Cart']['pick_up_day']][$key]['User']=$value['User'];
            $cartArr[$value['Cart']['pick_up_day']][$key]['Cart']=$value['Cart'];
           }
        
    
        
      // pr($dicountArr);
        $this->set(compact('dicountArr'));
       //pr($cartArr);
        $this->set('cart_meals',$cartArr);
        $this->set('setting',$this->Setting->find('first'));
     
    }

//////////////////////////////////////////////////////////////
 public function admin_change_order_status($id,$status) {
  $this->loadModel('Order');
  $this->Order->id = $id;
  if (!$this->Order->exists()) {
  throw new NotFoundException('Invalid order');
  }

  if($this->Order->saveField('order_status',$status)){
  $this->Session->setFlash('Order status changed successfully','default',array('class'=>'alert alert-success'));
  return $this->redirect(array('action'=>'index'));
  }else{
  $this->Session->setFlash('Order status not changed','default',array('class'=>'alert alert-danger'));
  return $this->redirect(array('action' => 'index'));
  }

 }

 //////////////////////////////////
}
