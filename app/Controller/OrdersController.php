<?php
App::uses('AppController', 'Controller');
class OrdersController extends AppController {




	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow(array('orders'));
	}

////////////////////////////////////////////////////////////

    public function admin_index() {

        $this->Paginator = $this->Components->load('Paginator');

        $this->Paginator->settings = array(
            'Order' => array(
                'recursive' => -1,
                'contain' => array(
                    'OrderItem'
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
        }
        $this->Session->setFlash('Order was not deleted','default',array('class'=>'alert alert-danger'));
        return $this->redirect(array('action' => 'index'));
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
                     'contain'=>array('Product','User')
              ));

         $ChefArr=array();
         $cartArr=array();
         foreach ($carts as $key => $value) {

            $cartArr[$value['Product']['day']][$key]['Product']=$value['Product'];
            $cartArr[$value['Product']['day']][$key]['User']=$value['User'];
            $cartArr[$value['Product']['day']][$key]['cart_id']=$value['Cart']['id'];
            $cartArr[$value['Product']['day']][$key]['comment']=$value['Cart']['comment'];
             if(!in_array($value['Cart']['cook_id'], $ChefArr)){
                $ChefArr[]=$value['Cart']['cook_id'];
             }
            
         }
        
      // for discount 
         $dicountArr=$this->Coupon->find('all',array(
                               'conditions'=>array(
                                    'Coupon.user_id'=>$ChefArr,
                                    'Coupon.active'=>1
                                )
                        ));

       // pr($dicountArr);
        $this->set('cart_meals',$cartArr);
        $this->set('setting',$this->Setting->find('first'));
     
    }

}
