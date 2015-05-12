<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
class UsersController extends AppController {

////////////////////////////////////////////////////////////
	public $components=array('Paypal');

    public function beforeFilter() {
        //echo "call";die;
        parent::beforeFilter();
        $this->Auth->allow(array('sendQuery','login','profile','SocialRegister','contact','admin_stories','forgetPassword','paypal','review','updatePassword'));

    }
    
//////////////////////////////////////////////////////////////////////

public function sendQuery(){

  $this->layout=false;
  $this->autoRender=false;
  $this->loadModel('User');
  $this->loadModel('Product');
  if($this->request->is('post')){
    $cookdata=$this->Product->find('first',array(
                                   'conditions'=>array(
                                     'Product.id'=>$this->request->data['productId']
                                    ),
                                   
                                'contain'=>array('User'=>array('fields'=>array('email','first_name')))
                                ));
   
    if($this->User->SendQueryMail($this->request->data,$cookdata)){
      echo json_encode(array('type'=>'success','msg'=>'Thanks for your query.We will get back to you soon.'));die;
    }else{
      echo json_encode(array('type'=>'success','msg'=>'There is network problem .Please try After some time'));die;
    }

    
  }
}
////////////////////////////////////////////////////////////

    function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
//////////////////////////////////////////
    public function login() {
         // $this->layout='front';
    //echo AuthComponent::password('admin@12345');die;

        if ($this->request->is('post')) {
            
            if($this->Auth->login()) {
               
                    $this->User->id = $this->Auth->user('id');
                    // $data['last_login']=date('Y-m-d H:i:s');
                    //$data['ip_address']=$this->get_client_ip();
                    $this->User->saveField('last_login',date('Y-m-d H:i:s'));
                    $this->User->saveField('ip_address',$this->get_client_ip());
               //  $this->User->save($data);
              
                if ($this->Auth->user('role') == 'customer' || $this->Auth->user('role') == 'cook' ) {
                      //echo $this->Auth->user('role');die;
                            if($this->referer()==SITE_URL.'users/login'){
                                $this->redirect('/');
                            }else{
                                return $this->redirect($this->referer());
                            }
                } elseif ($this->Auth->user('role') == 'admin') {
                    $uploadURL = Router::url('/') . 'app/webroot/upload';
                    $_SESSION['KCFINDER'] = array(
                        'disabled' => false,
                        'uploadURL' => $uploadURL,
                        'uploadDir' => ''
                    );
                    return $this->redirect(array(
                        'controller' => 'orders',
                        'action' => 'index',
                        'manager' => false,
                        'admin' => true
                    ));
                } else {
                    $this->Session->setFlash('Login is incorrect','default',array('class'=>'alert alert-danger'));
                }
            } else {
                $this->Session->setFlash('Login is incorrect','default',array('class'=>'alert alert-danger'));
            }
        }
    }

////////////////////////////////////////////////////////////

    public function logout() {
        $this->Session->setFlash('You have successfully logged out','default',array('class'=>'alert alert-success'));
        $_SESSION['KCEDITOR']['disabled'] = true;
        unset($_SESSION['KCEDITOR']);
        $this->Session->delete('authorized');
        return $this->redirect($this->Auth->logout());
    }

     public function profile($id = null) {
        //
        //echo $id; die;
        $this->layout = 'front';
       // echo $this->layout;
       $this->loadModel('Product');
       $this->loadModel('Cart');
      
       $product = $this->User->find('first', array(
        'recursive' => -1,
         'contain'=>array('Product'=>array('fields'=>'id'),'Review'=>array('fields'=>array('Count(Review.id) as count'))),
         'conditions' => array(
        // 'Brand.active' => 1,
        'User.active' => 1,
        'User.username' => $id
        ),
        'fields'    => array( 
        'SUM( User.reviews_avg_val_rating+User.reviews_avg_ontime_rating+User.reviews_avg_easyfind_rating ) AS sum','User.*'
        // +whatever else you need
        )
        ));
        if(empty($product['User']['id'])){
         $this->Session->setFlash('There is no user','default',array('class'=>'alert alert-danger'));
         return $this->redirect('/products');
        }
        $productIds=array();
        foreach ($product['Product'] as $key => $value) {
           $productIds[$key]=$value['id'];
        }
        $this->set('productIds',implode(',',$productIds));
        $this->set('count',$this->Cart->find('count',array('conditions'=>array('Cart.user_id'=>$this->Session->read('Auth.User.id')))));
        $this->set(compact('product'));

       
    }

////////////////////////////////////////////////////////////

    public function customer_dashboard() {
    	 $this->loadModel('Order');
    	 
    	
         
          $this->Paginator = $this->Components->load('Paginator');

        $this->Paginator->settings = array(
            'Order' => array(
                'recursive' => -1,
                'contain' => array(
                 
                ),
                'conditions' => array(
                	'Order.user_id'=>$this->Auth->user('id')
                ),
                'order' => array(
                    'Order.created' => 'DESC'
                ),
                'limit' => 20,
                'paramType' => 'querystring',
            )
        );
        $orders = $this->Paginator->paginate('Order');
        //pr($orders);
        $this->set(compact('orders'));

    }


///////////////////////////////////////////////
    //for customer and chef profile
    public function customer_order_view($id=null) {
      $this->loadModel('Order');
      $this->Order->id = $id;
        if (!$this->Order->exists()) {
            throw new NotFoundException('Invalid order');
        }
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

///////////////////////////////////////////////
    //for customer and chef profile
    public function customer_view() {
        $this->User->id = $this->Session->read('Auth.User.id');
        if (!$this->User->exists()) {
            throw new NotFoundException('Invalid user');
        }
        $this->set('user', $this->User->read(null, $this->Session->read('Auth.User.id')));


    }


//////////////////////////////////////////////////////////
    public function customer_change_password(){
         if($this->request->is('post')){
            //pr($this->request->data);die;
               if($this->User->save($this->request->data)){
                $this->Session->setFlash('Password changed successfully','default',array('class'=>'alert alert-success'));
                return $this->redirect('/customer');
               }
         }
    }


//////////////////////////////////////////////////////////


    public function customer_edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException('Invalid user');
        }
        if ($this->request->is('post') || $this->request->is('put') ) {
            $UploadImg=WWW_ROOT.'images/UserImg/';
            if(!empty($this->request->data['User']['image']['name'])){
             move_uploaded_file($this->request->data['User']['image']['tmp_name'], $UploadImg.$this->request->data['User']['image']['name']);
            $this->request->data['User']['image']=$this->request->data['User']['image']['name'];
            }else{
            $this->request->data['User']['image']=$this->request->data['User']['image_name'];
            }
           //pr($this->request->data);die;
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('The user has been saved','default',array('class'=>'alert alert-success'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The user could not be saved. Please, try again.','default',array('class'=>'alert alert-danger'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
        }
    }
////////////////////////////////////////////////////////////

    public function admin_dashboard() {
    }


   ////////////////////////////////////////////////////////////

    /*
    function redirect url for searching category 

    */
        public function admin_searchRedirect(){
            if($this->request->is('post')){
              
            $this->redirect(
                array(
                'controller'=>'users',
                'action'=>'index',
                'type'=>!empty($this->request->data['User']['type'])?$this->request->data['User']['type']:'',
               
               ));
           }
        }

////////////////////////////////////////////////////////////



    public function admin_index() {

        $this->Paginator = $this->Components->load('Paginator');

           //$condition=array();
           if(!empty($this->params->params['named']['type'])){

                    $this->Paginator->settings = array(
                    'User' => array(
                        'recursive' => -1,
                        'contain' => array(
                        ),
                        'conditions' => array(
                            'User.role'=>$this->params->params['named']['type']
                        ),
                        'order' => array(
                            'User.last_login' => 'DESC'
                        ),
                        'limit' => 20,
                        'paramType' => 'querystring',
                    )
                 );

           }else{
                    $this->Paginator->settings = array(
                    'User' => array(
                        'recursive' => -1,
                        'contain' => array(
                        ),
                        'conditions' => array(
                        ),
                        'order' => array(
                            'User.last_login' => 'DESC'
                        ),
                        'limit' => 20,
                        'paramType' => 'querystring',
                    )
                 );
           }
        
        $users = $this->Paginator->paginate();
        ///pr($users);
        $this->set(compact('users'));
    }

////////////////////////////////////////////////////////////

    public function admin_view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException('Invalid user');
        }
        $this->set('user', $this->User->read(null, $id));
    }



////////////////////////////////////////////////////////////

    public function admin_add() {
        if ($this->request->is('post')) {

            $UploadImg=WWW_ROOT.'images/UserImg';
            if(!dir($UploadImg)){
                @mkdir($UploadImg,true,0777);

            }
           
            if(!empty($this->request->data['User']['image']['name'])){
             move_uploaded_file($this->request->data['User']['image']['tmp_name'], $UploadImg.'/'.$this->request->data['User']['image']['name']);
            $this->request->data['User']['image']=$this->request->data['User']['image']['name'];
            }else{
            $this->request->data['User']['image']='';
            }
            
              $this->User->create();
              $this->User->validator()->remove('oldpassword');
              //$this->request->data['User']['city']=strtolower($this->request->data['User']['city']);
              //$this->request->data['User']['country']=strtolower($this->request->data['User']['country']);
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('The user has been saved','default',array('class'=>'alert alert-success'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The user could not be saved. Please, try again.','default',array('class'=>'alert alert-danger'));
            }
        }
    }

////////////////////////////////////////////////////////////

    public function admin_edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException('Invalid user');
        }
        if ($this->request->is('post') || $this->request->is('put') ) {
            $UploadImg=WWW_ROOT.'images/UserImg/';
            if(!empty($this->request->data['User']['image']['name'])){
             move_uploaded_file($this->request->data['User']['image']['tmp_name'], $UploadImg.$this->request->data['User']['image']['name']);
            $this->request->data['User']['image']=$this->request->data['User']['image']['name'];
            }else{
            $this->request->data['User']['image']=$this->request->data['User']['image_name'];
            }
           //pr($this->request->data);die;
             $this->User->validator()->remove('oldpassword');
             //$this->request->data['User']['city']=strtolower($this->request->data['User']['city']);
             //$this->request->data['User']['country']=strtolower($this->request->data['User']['country']);
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('The user has been saved','default',array('class'=>'alert alert-success'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The user could not be saved. Please, try again.','default',array('class'=>'alert alert-danger'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
        }
    }

////////////////////////////////////////////////////////////

    public function admin_password($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException('Invalid user');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
             $this->User->validator()->remove('oldpassword');
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('The user has been saved','default',array('class'=>'alert alert-success'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The user could not be saved. Please, try again.','default',array('class'=>'alert alert-danger'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
        }
    }

////////////////////////////////////////////////////////////

    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException('Invalid user');
        }
        if ($this->User->delete()) {
            $this->Session->setFlash('User deleted','default',array('class'=>'alert alert-success'));
            return $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash('User was not deleted','default',array('class'=>'alert alert-danger'));
        return $this->redirect(array('action' => 'index'));
    }




    public function admin_setting_editable(){
    	$this->loadModel('Setting');


        $model ='Setting';
    
        $id = trim($this->request->data['pk']);
        $field = trim($this->request->data['name']);
        $value = trim($this->request->data['value']);

        $data[$model]['id'] = $id;
        $data[$model][$field] = $value;
        $this->$model->save($data, false);

        $this->autoRender = false;

}

/////////////////////////////////////////////////////////////
public function order_confirm() {
	$userId = $this->Auth->user('id');
              if(!$userId){
                $this->Session->setFlash('Please login ','default',array('class'=>'alert alert-danger'));
                return $this->redirect('/');
              }

}
////////////////////////////////////////////////////////////

	public function paypal(){
         $this->layout='front';
         $this->autoRender=false;
         if($this->request->is('post')){
            
              $userId = $this->Auth->user('id');
              if(!$userId){
                $this->Session->setFlash('Please login again !','default',array('class'=>'alert alert-danger'));
                return $this->redirect('/');
              }
              
              $this->Session->write('Shop',$this->request->data);
              $this->loadModel('Cart');
              $Data=$this->Cart->find('all',array(
                                         'conditions'=>array(
                                             'Cart.user_id'=>$userId
                                             ),
                                        'contain'=>array(
                                            'Product'=>array('fields'=>array('id','name','image','slug','pick_time_to','price','pick_time_from','day')),
                                            'User'=>array('fields'=>array('id','first_name','email','username','last_name','city','country','reviews_avg_val_rating','reviews_avg_ontime_rating','reviews_avg_easyfind_rating' )),
                                            
                                        )
                                   ));
              // return $this->redirect('/');
             
              $paymentAmount =$this->priceGet($Data);
            
			  
			if(!$paymentAmount) {
			 return $this->redirect('/');
			}
		   $this->Session->write('Shop.Order.order_type', 'paypal');

           $this->Paypal->step1($paymentAmount);
         }else{
         	$this->Session->setFlash('Please fill the all informtaion','default',array('class'=>'alert alert-danger'));
         	return $this->redirect('/order_confirm');
         }
         
	}

///////////////////////////////////////////////////////////////////

	//function for get price
  public function priceGet($cartData){
  	$this->loadModel('Setting');
  	$this->loadModel('Product');
     
  	$setting=$this->Setting->find('first');
  	$hst=$setting['Setting']['hst'];
 
    

   
          $cost=0;
          $total_quantity=0;
          $orderData=array();
          $discount=0;
          $emailArr=array();
        //pr($cartData);die;

          foreach ($cartData as $key => $value) {
				$orderData[$key]['Product']['image']=$value['Product']['image'];
				$orderData[$key]['name']=$value['Product']['name'];
				$orderData[$key]['price']=$value['Product']['price'];
				$orderData[$key]['quantity']=$value['Cart']['quantity'];
				$orderData[$key]['discount']=$value['Cart']['discount'];
                $orderData[$key]['comment']=$value['Cart']['comment'];
				$orderData[$key]['product_id']=$value['Product']['id'];
                $orderData[$key]['pick_time_to']=$value['Product']['pick_time_to'];
                $orderData[$key]['pick_time_from']=$value['Product']['pick_time_from'];
                $orderData[$key]['pick_up_day']=$value['Cart']['pick_up_day'];
                $orderData[$key]['order_date']=$value['Cart']['order_date'];
				$orderData[$key]['cook_name']=$value['User']['first_name'].' '.$value['User']['last_name'];

				$orderData[$key]['username']=$value['User']['username'];
                $orderData[$key]['cook_rating']=ceil(($value['User']['reviews_avg_val_rating']+$value['User']['reviews_avg_ontime_rating']+$value['User']['reviews_avg_easyfind_rating'])/3);
				$orderData[$key]['chef_id']=$value['User']['id'];
				$orderData[$key]['subtotal']=$value['Cart']['quantity']*$value['Product']['price']-$value['Cart']['discount'];
                if(!in_array($value['User']['email'], $emailArr)){
                     $emailArr[$key]=$value['User']['email'];
                }
				$discount=$discount+$value['Cart']['discount'];
				$price=$value['Product']['price']*$value['Cart']['quantity'];
				$cost=$cost+($price-$value['Cart']['discount']);
				$total_quantity=$total_quantity+$value['Cart']['quantity'];
				

          }
          
    

       
      //echo $cost;die;
      $subTotal=($cost*$hst)/100;
      $totalPrice=$subTotal+$cost;
        
      $this->Session->write('Shop.Order.discount',$discount);
      $this->Session->write('Shop.Order.user_Email',$emailArr);
      $this->Session->write('Shop.Order.order_item_count',$total_quantity);
      $this->Session->write('Shop.Order.total',round($totalPrice,2));
      $this->Session->write('Shop.Order.subtotal',round($subTotal,2));
      $this->Session->write('Shop.OrderItem',$orderData);
      return round($totalPrice,2);

  }



///////////////////////////////////////////////////////////// 

	public function step2() {
        $this->loadModel('Order');
        $this->Session->delete('Error');
        $token = $this->request->query['token'];
        $paypal = $this->Paypal->GetShippingDetails($token);
       
        $ack = strtoupper($paypal['ACK']);

        if($ack == 'SUCCESS' || $ack == 'SUCESSWITHWARNING') {
            $this->Session->write('Shop.Paypal.Details', $paypal);
            $shop = $this->Session->read('Shop');
          
            if(($shop['Order']['order_type'] == 'paypal') && !empty($shop['Paypal']['Details'])) {
		        	$shop['Order']['user_id'] = $this->Session->read('Auth.User.id');
		            $shop['Order']['first_name'] = $shop['Paypal']['Details']['FIRSTNAME'];
		            $shop['Order']['last_name'] = $shop['Paypal']['Details']['LASTNAME'];
		            $shop['Order']['email'] = $shop['Paypal']['Details']['EMAIL'];
		            $shop['Order']['phone'] = '888-888-8888';
		            $shop['Order']['billing_address'] = $shop['Paypal']['Details']['SHIPTOSTREET'];
		            $shop['Order']['billing_address2'] = '';
		            $shop['Order']['billing_city'] = $shop['Paypal']['Details']['SHIPTOCITY'];
		            $shop['Order']['billing_zip'] = $shop['Paypal']['Details']['SHIPTOZIP'];
		            $shop['Order']['billing_state'] = $shop['Paypal']['Details']['SHIPTOSTATE'];
		            $shop['Order']['billing_country'] = $shop['Paypal']['Details']['SHIPTOCOUNTRYNAME'];

		            $shop['Order']['shipping_address'] = $shop['Paypal']['Details']['SHIPTOSTREET'];
		            $shop['Order']['shipping_address2'] = '';
		            $shop['Order']['shipping_city'] = $shop['Paypal']['Details']['SHIPTOCITY'];
		            $shop['Order']['shipping_zip'] = $shop['Paypal']['Details']['SHIPTOZIP'];
		            $shop['Order']['shipping_state'] = $shop['Paypal']['Details']['SHIPTOSTATE'];
		            $shop['Order']['shipping_country'] = $shop['Paypal']['Details']['SHIPTOCOUNTRYNAME'];

		            $shop['Order']['order_type'] = 'paypal';

		            $this->Session->write('Shop.Order', $shop['Order']);
            }

             
             $order = $shop;
             $order['Order']['status'] = 1;

	          if($shop['Order']['order_type'] == 'paypal') {
                        
	                $paypal = $this->Paypal->ConfirmPayment($order['Order']['total']);
	                //debug($resArray);
	                $ack = strtoupper($paypal['ACK']);
	                if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING') {
	                    $order['Order']['status'] = 2;
	                }
	                $order['Order']['authorization'] = $paypal['ACK'];
	                //$order['Order']['transaction'] = $paypal['PAYMENTINFO_0_TRANSACTIONID'];
	            }
               
                 $save = $this->Order->saveAll($order, array('validate' => 'first'));
                 $orderId=$this->Order->getLastInsertID();
                 
                
               if(empty($this->Order->validationErrors)){
                $chef_email=$this->Session->read('Shop.Order.user_Email');
                array_push($chef_email,$this->Auth->user('email'),$shop['OrderInfo']['email']);

                if($save) {
                    $shop['Order']['id']=$orderId;
                    $save_data=$this->Order->findById($orderId);
                    $shop['Order']['created']=$save_data['Order']['created'];
                    $email = new CakeEmail('smtp');

                    $email->from(Configure::read('Settings.SUPPORT_EMAIL'))
                            ->cc(Configure::read('Settings.SUPPORT_EMAIL'))
                            ->to($chef_email)
                            ->subject('YumPlate Order information')
                            ->template('order')
                            ->emailFormat('html')
                            ->viewVars(array('shop' => $shop))
                            ->send();
                    $this->Session->setFlash('Thank You for Your Order !','default',array('class'=>'alert alert-success'));
                   return $this->redirect(array('action' => 'success'));

                }
            }else{
                
                $this->Session->write('Error',$this->Order->validationErrors);
                return $this->redirect(array('action' => 'order_confirm'));
            }
            //return $this->redirect(array('action' => 'review'));
        } else {
            $ErrorCode = urldecode($paypal['L_ERRORCODE0']);
            $ErrorShortMsg = urldecode($paypal['L_SHORTMESSAGE0']);
            $ErrorLongMsg = urldecode($paypal['L_LONGMESSAGE0']);
            $ErrorSeverityCode = urldecode($paypal['L_SEVERITYCODE0']);
            echo 'GetExpressCheckoutDetails API call failed. ';
            echo 'Detailed Error Message: ' . $ErrorLongMsg;
            echo 'Short Error Message: ' . $ErrorShortMsg;
            echo 'Error Code: ' . $ErrorCode;
            echo 'Error Severity Code: ' . $ErrorSeverityCode;
            die();
        }

    }


//////////////////////////////////////////////////////
    
    public function success() {
       $this->layout='front';
        $shop = $this->Session->read('Shop');
        $this->loadModel('OrderInfo');
        $this->loadModel('Order');
        $this->loadModel('Cart');
       
       if(empty($shop)) {
            return $this->redirect('/');
        }
         
     if(!empty($shop)){
            $this->Cart->deleteAll(array('Cart.user_id'=>$this->Auth->user('id')));
            $this->Session->delete('Shop');
            }
         

    }
    
 /////////////////////////////////////////////////////

    public function Register(){
        $this->layout='front';
        if($this->request->is('post')){
           
            $this->request->data['User']['username']=$this->request->data['User']['email'];
            
       
                $this->User->validator()->remove('oldpassword');
                if($this->User->save($this->request->data)){
                $last = $this->User->findById($this->User->id);
                $this->User->SendRegisterMail($last);
                $this->User->id = $last['User']['id'];
                $this->User->saveField('last_login',date('Y-m-d H:i:s'));
                $this->User->saveField('ip_address',$this->get_client_ip());
                $this->Session->write('Auth',$last); 
                $this->Session->setFlash('Sucessfully Registered','default',array('class'=>'alert alert-success')); 
                $this->redirect(array('controller'=>'products','action'=>'index'));
                }
           
            
        }
        
        
    }
    
    public function SocialRegister(){
         
        $this->autoRender=false;
        if($this->request->is('post')){
        
          $data=array();
          $data['User']['first_name']=$this->request->data['first_name'];
          $data['User']['last_name']=$this->request->data['last_name'];
          $data['User']['email']=base64_decode($this->request->data['email']);
          $data['User']['social_login']=1;
          $data['User']['role']='customer';
           $data['User']['image_link']='http://graph.facebook.com/'.$this->request->data['id'].'/picture?type=large';
          $data['User']['username']=base64_decode($this->request->data['email']);
           
         //if($this->User->SendSocialRegisterMail($data)){
          $userData=$this->User->find('first',array('conditions'=>array('User.email'=>base64_decode($this->request->data['email']))));
          if(empty($userData)){
            $this->User->validator()->remove('oldpassword');
                if($savedData=$this->User->save($data)){
                    $this->User->SendSocialRegisterMail($savedData);
                    $this->Session->write('Auth',$savedData);
                    $this->User->id = $savedData['User']['id'];
                    $this->User->saveField('last_login',date('Y-m-d H:i:s'));
                    $this->User->saveField('ip_address',$this->get_client_ip());
                    echo json_encode(array('type'=>'success'));die;
                }else{
                    echo json_encode(array('type'=>'error','msg'=>'Does Not saved'));die;
                }
             }else{
                $this->User->id = $userData['User']['id'];
                $data['last_login']=date('Y-m-d H:i:s');
                $this->User->saveField('last_login', $data['last_login'], false);
                $this->User->saveField('ip_address',$this->get_client_ip());
                  if(empty($userData['User']['image_link'])){
                    $user_data['image_link']=$data['User']['image_link'];
                    $this->User->id=$userData['User']['id'];
                    $this->User->save($user_data);
                  }
                 $this->Session->write('Auth', $userData);
                  echo json_encode(array('type'=>'exists'));die;
             }
        }
        
        
    }


    ////////////////////////////////////////////////////////////
  //function for send mail to admin
    public function makestatus() {
        $this->autoRender=false;

      if($this->request->is('post')){
        //pr($this->request->data);die;
         if($this->User->SendAdminMail($this->request->data)){
                  echo json_encode(array('type'=>'success'));die;
                }else{
                    echo json_encode(array('type'=>'failure'));die; 
                }
      }
       
    }


  ////////////////////////////////////////////////////////////
  //function for send mail to admin
    public function forgetPassword() {
    	$this->autoRender=false;
       if($this->request->is('post')){
                   //pr($this->data);die;
                $this->User->recursive = 0;
                $user = $this->User->find('first',array('fields' => array('User.id', 'User.username','User.first_name','User.last_name'), 'conditions'=>array('email ='=>$this->data['User']['email'])));
                //pr($user);die;
                
                if(!empty($user))
                {

                $userId = $user['User']['id'];
                $userName = $user['User']['username'];
                $fullName = $user['User']['first_name']." ".$user['User']['last_name'];
               
                if($this->User->sendForgetPassMail($this->data['User']['email'],$userName,$userId,$fullName))
                {
				$this->Session->setFlash('An email has been sent to you. Please check your inbox!','default',array('class'=>'alert alert-success'));
				$this->redirect('/users/register');
                }else{
                	echo "email not send";die;
                }
               
                }else{
                $this->Session->setFlash('Unautharised User !','default',array('class'=>'alert alert-success'));
                $this->redirect('/users/register');
                }

        } 
       
    }


 ///////////////////////////////////////////////////////////////////////

    function updatePassword(){
         $this->layout='front';


        $token=base64_decode($this->params->params['pass'][0]);
        $time=base64_decode($this->params['params']);
        $userdata=$this->User->find('first',array('conditions'=>array('User.email'=>$token)));
        $forget_time=strtotime(date($userdata['User']['forget_link_time']));
        $forget_time_after = strtotime('+ 60 minutes',strtotime($userdata['User']['forget_link_time']));
       	//echo date('Y-m-d h:i:s',$forget_time_after); die;

        $current_time=strtotime(date('Y-m-d h:i:s'));
        //echo $userdata['User']['forget_link_time'];die;
        if($forget_time<=$current_time && $current_time <=$forget_time_after){
        	 if($this->request->is('post')){
               $this->User->id=$userdata['User']['id'];
               $this->User->validator()->remove('oldpassword');
               if( $this->User->save($this->request->data)){
				$this->Session->setFlash('Successfully updated your password','default',array('class'=>'alert alert-success'));
				$this->redirect('/');
               }
        	}
        }else{
		$this->Session->setFlash('Your link has been expired !','default',array('class'=>'alert alert-danger'));
		$this->redirect('/');
        }
     


    }

//////////////////////////////////////////////////////////////////
    public function generatePassword ($length = 8){

        $password = "";
       // define possible characters
        $possible = "0123456789abcdefghjkmnpqrstvwxyz";
        // set up a counter
        $i = 0;
        // add random characters to $password until $length is reached
        while ($i < $length) 
        {
            // pick a random character from the possible ones
            $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
            // we don't want this character if it's already in the password
            if (!strstr($password, $char)) 
            {
              $password .= $char;
              $i++;
            }

        }
        return $password;

  }
  

 

//////////////////////////////////////////////////////////////

    public function contact(){
      $this->autoRender=false;
        
      if($this->request->is('post')){
       //pr($this->data);die;
         
          $email = new CakeEmail('smtp');
          $email->from($this->request->data['email']);
          $email->to('pravendra.kumar@webenturetech.com');
          //$email->to('pravendra.kumar@webenturetech.com');
          $email->emailFormat('html');
          if($this->request->data['type']=='contact'){
            $email->subject('Contact Us');
          }else{
             $email->subject('Become a YUMcook');
          }
         
          $body =" ";

          $body .=" Full Name : ".$this->request->data['name'].'<br/>'.' Email : '.$this->request->data['email'].'<br/> message : '.$this->request->data['message'].'<br />';

          try{
          $result = $email->send($body);
          } catch (Exception $ex){
          // we could not send the email, ignore it
           // pr($ex);
          echo json_encode(array('type'=>'failure','msg'=>'There is problem in email network .Please try again after some time.'));die;
          }
          echo json_encode(array('type'=>'success'));die;
          } 

    }

///////////////////////////////////////////////////////////////

    public function admin_setting(){
         $this->loadModel('Setting');
         $this->loadModel('Coupon');
         $setting=$this->Setting->find('first');
         $this->set(compact('setting'));

         $coupons=$this->Coupon->find('all');
         $this->set(compact('coupons'));

    }


//////////////////////////////////////////////////funtcions for Coupons/////////////////////////////////


public function admin_add_coupon($id=null){
    $this->loadModel('Coupon');
    $this->User->virtualFields=array(
        'name' => 'CONCAT(User.first_name," ", User.last_name)'
        );
    $users=$this->User->find('list',array(
                'fields'=>array('id','name'),
                'conditions'=>array('User.role'=>'cook')
                ));
    $this->set(compact('users'));

    if($this->request->is('post')||$this->request->is('put')){
        //pr($this->request->data);die;
      if($this->Coupon->save($this->request->data)){
            if($this->request->data['Coupon']['id']){
               $this->Session->setFlash('Coupon updated successfully','default',array('class'=>'alert alert-success')); 
            }else{
              $this->Session->setFlash('Coupon saved successfully','default',array('class'=>'alert alert-success'));
            }
        
             $this->redirect('/admin/users/setting');
      }else{
            $this->Session->setFlash('Coupon not saved!','default',array('class'=>'alert alert-danger'));
            $this->redirect('/admin/users/setting');
      }
    }
    
    if($id){
        $this->Coupon->id = $id;
        if (!$this->Coupon->exists()) {
        throw new NotFoundException('Invalid Coupon');
        }
       
       $coupon=$this->Coupon->find('first',array('conditions'=>array('Coupon.id'=>$id,'Coupon.active'=>1)));
       $this->set(compact('coupon'));
    }

}



public function admin_coupon_delete($id=null){
         $this->loadModel('Coupon');
         $this->Coupon->id = $id;
        if (!$this->Coupon->exists()) {
            throw new NotFoundException('Invalid Coupon');
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Coupon->delete()) {
            $this->Session->setFlash('Coupon deleted successfully','default',array('class'=>'alert alert-success'));
            return$this->redirect('/admin/users/setting');
        }else{
        $this->Session->setFlash('Coupon was not deleted','default',array('class'=>'alert alert-success'));
        return $this->redirect('/admin/users/setting');
       } 
}

public function admin_change_coupon_status($id,$status){
         $this->loadModel('Coupon');
         $this->Coupon->id = $id;
        if (!$this->Coupon->exists()) {
            throw new NotFoundException('Invalid Coupon');
        }
 
        if ($this->Coupon->saveField('active',$status)) {
            $this->Session->setFlash('Successfully status changed ','default',array('class'=>'alert alert-success'));
            return$this->redirect('/admin/users/setting');
        }else{
        $this->Session->setFlash('Status not changed','default',array('class'=>'alert alert-danger'));
        return $this->redirect('/admin/users/setting');
       }
}
//////////////////////////////////////////////////funtcions for Coupons ends here /////////////////////////////////


///////////////////////////////////////////////funtcions for Meta keywords, description ,name/////////////////////////////////


public function admin_meta_setting(){
    $this->loadModel('MetaSetting');
    $meta_settings=$this->MetaSetting->find('first');
    $this->set(compact('meta_settings'));

}

///////////////////////////////////////////////////////////

public function admin_meta_setting_editable(){
        $this->loadModel('MetaSetting');
        $model ='MetaSetting';
    
        $id = trim($this->request->data['pk']);
        $field = trim($this->request->data['name']);
        $value = trim($this->request->data['value']);

        $data[$model]['id'] = $id;
        $data[$model][$field] = $value;
        $this->$model->save($data, false);

        $this->autoRender = false;

}
///////////////////////////////////////////////funtcions for Meta keywords, description ,name ends here/////////////////////////////////

///////////////////////////////////////////////funtcions for Reviews setting/////////////////////////////////


public function admin_review_setting(){
    $this->loadModel('Review');
    $this->Paginator = $this->Components->load('Paginator');
    $this->Paginator->settings = array(
                    'User' => array(
                        'recursive' => -1,
                        'contain' => array(
                        ),
                        'conditions' => array(
                        ),
                        'order' => array(
                            'Review.created' => 'DESC'
                        ),
                        'limit' => 20,
                        'paramType' => 'querystring',
                    )
                 );
     $reviews = $this->Paginator->paginate('Review');
    // pr($reviews);
     $this->set(compact('reviews'));

}

///////////////////////////////////////////////////////////

public function admin_review_delete($id = null){
        $this->loadModel('Review');

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        unset($this->Review->actsAs['AggregateCache']);
        unset($this->Review->actsAs['Containable']);
        $this->Review->Behaviors->detach('AggregateCache');
        //pr($this->Review);die;
        $this->Review->id = $id;
        if (!$this->Review->exists()) {
            throw new NotFoundException('Invalid Review');
        }
       
        if ($this->Review->delete()) {
            $this->Session->setFlash('Review successfully deleted','default',array('class'=>'alert alert-success'));
            return $this->redirect(array('action'=>'review_setting'));
        }
        $this->Session->setFlash('Review was not deleted','default',array('class'=>'alert alert-danger'));
        return $this->redirect(array('action' => 'review_setting'));

}
///////////////////////////////////////////////funtcions for  Reviews setting ends here/////////////////////////////////
}
