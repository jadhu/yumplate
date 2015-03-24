<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
class UsersController extends AppController {

////////////////////////////////////////////////////////////
	public $components=array('Paypal');

    public function beforeFilter() {

        parent::beforeFilter();
        $this->Auth->allow(array('login','profile','SocialRegister','contact','admin_stories','forgetPassword','paypal','review'));

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

    //echo $_SERVER['REMOTE_ADDR'] ;//AuthComponent::password('kumar@123');

        if ($this->request->is('post')) {
                    
            if($this->Auth->login()) {
               
                 $this->User->id = $this->Auth->user('id');
                 $data['last_login']=date('Y-m-d H:i:s');
                 $data['ip_address']=$this->get_client_ip();
                 $this->User->save($data);
              
                if ($this->Auth->user('role') == 'customer') {
                      //echo $this->Auth->user('role');die;
                            if($this->referer()=='http://projects.udaantechnologies.com/yumplate/users/login'){
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
                        'controller' => 'users',
                        'action' => 'dashboard',
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
        $this->Session->setFlash('Successfully logout','default',array('class'=>'alert alert-success'));
        $_SESSION['KCEDITOR']['disabled'] = true;
        unset($_SESSION['KCEDITOR']);
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
    	 $this->loadModel('Cart');
    	 $shop = $this->Session->read('Shop');
         if(!empty($shop)){
           $this->Cart->deleteAll(array('Cart.user_id'=>$this->Auth->user('id')));
           $this->Session->delete('Shop');
         }
    	
         
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
 

    public function admin_index() {

        $this->Paginator = $this->Components->load('Paginator');

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
////////////////////////////////////////////////////////////
	public function paypal(){
         $this->layout='front';
         if($this->request->is('post')){
              $userId = $this->Auth->user('id');
           
			$paymentAmount =$this->priceGet($this->request->data['Product']['productId']);
			if(!$paymentAmount) {
			 return $this->redirect('/');
			}
		   $this->Session->write('Shop.Order.order_type', 'paypal');
           $this->Paypal->step1($paymentAmount);
         }
         
	}

///////////////////////////////////////////////////////////////////

	//function for get price
  public function priceGet($items){
  	$this->loadModel('Setting');
  	$this->loadModel('Product');
    $this->loadModel('Coupon');
  	$setting=$this->Setting->find('first');
  	$hst=$setting['Setting']['hst'];
  	$pIds=array();
    $prductsItems=explode('|',$items);
      foreach ($prductsItems as $key => $value) {
      	$val=explode('~',$value);
      	$pIds['items'][$val[1]]=$val[0];
      	$pIds['Ids'][$key]=$val[1];
      }

      $data=$this->Product->find('all',array(
                 'conditions'=>array(
                     'Product.id'=>$pIds['Ids']
                 	),
                 'contain'=>array('User'=>array('fields'=>array('id','first_name','last_name')))
                 ));
          $cost=0;
          $total_quantity=0;
          $priceArr=array();
          $orderData=array();
          $discountArr=array();
          $discount=0;


       foreach ($data as $key => $value) {
      
            $orderData[$key]['Product']['image']=$value['Product']['image'];
            $orderData[$key]['name']=$value['Product']['name'];
            $orderData[$key]['price']=$value['Product']['price'];
            $orderData[$key]['quantity']=$pIds['items'][$value['Product']['id']];
            $orderData[$key]['product_id']=$value['Product']['id'];
            $orderData[$key]['cook_name']=$value['User']['first_name'].' '.$value['User']['last_name'];
            $orderData[$key]['chef_id']=$value['User']['id'];;
            $total_quantity=$total_quantity+$pIds['items'][$value['Product']['id']];
            $price=$pIds['items'][$value['Product']['id']]*$value['Product']['price'];
            $orderData[$key]['subtotal']=$price;

            if (array_key_exists($value['User']['id'],$priceArr)){
                  $priceArr[$value['User']['id']]['price']=$priceArr[$value['User']['id']]['price']+$price;

            }else{
                 $priceArr[$value['User']['id']]['price']=$price;
            }
        
     
       }
      
    
       foreach ($priceArr as $key => $value) {
           $discountData=$this->Coupon->find('first',array(
                                     'conditions'=>array(
                                            'Coupon.user_id'=>$key,
                                            'Coupon.active'=>1
                                            ),
                                     'contain'=>array('User'=>array('fields'=>array('id','first_name','last_name'))
                                            )));
          
           if(!empty($discountData)){
                 $today_timestamp=strtotime(date("Y-m-d"));
                 $start_date_timestamp=strtotime($discountData['Coupon']['start_date']);
                 $end_date_timestamp=strtotime($discountData['Coupon']['end_date']);
                 
                if($today_timestamp>=$start_date_timestamp && $today_timestamp<=$start_date_timestamp){

                    if($value>=$discountData['Coupon']['discount_limit']){
                        $discount=($value['price']*$discountData['Coupon']['discount'])/100;
                    }
                    $cost=$cost+($value['price']-$discount);
                    $discountArr[$key]['discount']=$discount;
                    $discountArr[$key]['total']=$value['price'];
                    $discountArr[$key]['chef']=$discountData['User']['first_name'].' '.$discountData['User']['last_name'];

               }else{
                    $cost=$cost+$value['price'];
                    $discountArr[$key]['discount']=0;
                    $discountArr[$key]['total']=$value['price'];

               }


           }else{
                $cost=$cost+$value['price'];
                $discountArr[$key]['discount']=0;
                $discountArr[$key]['total']=$value['price'];
               
          }
    
       }

      $subTotal=($cost*$hst)/100;
      $totalPrice=$subTotal+$cost;

      $this->Session->write('Shop.Order.discount',$discountArr);
      $this->Session->write('Shop.Order.order_item_count',$total_quantity);
      $this->Session->write('Shop.Order.total',round($totalPrice,2));
      $this->Session->write('Shop.Order.subtotal',round($subTotal,2));
      $this->Session->write('Shop.OrderItem',$orderData);
     return round($totalPrice,2);

  }


/////////////////////////////////////////////////////////////

	public function step2() {

        $token = $this->request->query['token'];
        $paypal = $this->Paypal->GetShippingDetails($token);

        $ack = strtoupper($paypal['ACK']);
        if($ack == 'SUCCESS' || $ack == 'SUCESSWITHWARNING') {
            $this->Session->write('Shop.Paypal.Details', $paypal);
            return $this->redirect(array('action' => 'review'));
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


//////////////////////////////////////////////////////////////   


//////////////////////////////////////////////////

    public function review() {

        $shop = $this->Session->read('Shop');
        $this->loadModel('Setting');
        $setting=$this->Setting->find('first');
        $hst=$setting['Setting']['hst'];
        $reviewArr=array();
         //pr($shop['OrderItem']);
         foreach ($shop['OrderItem'] as $key => $value) {
               $reviewArr[$value['chef_id']][]=$value;
            
         }

         foreach ($shop['Order']['discount'] as $key => $value) {
            if(array_key_exists($key, $reviewArr)){
             $reviewArr[$key]['discount']=$value;
           }
            
         }
        
         //pr($reviewArr);
  
        if(empty($shop)) {
            return $this->redirect('/');
        }

        if ($this->request->is('post')) {

            $this->loadModel('Order');

            $this->Order->set($this->request->data);
            if($this->Order->validates()) {
                $order = $shop;
                $order['Order']['discount']=json_encode($shop['Order']['discount']);
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

                if((Configure::read('Settings.AUTHORIZENET_ENABLED') == 1) && $shop['Order']['order_type'] == 'creditcard') {
                    $payment = array(
                        'creditcard_number' => $this->request->data['Order']['creditcard_number'],
                        'creditcard_month' => $this->request->data['Order']['creditcard_month'],
                        'creditcard_year' => $this->request->data['Order']['creditcard_year'],
                        'creditcard_code' => $this->request->data['Order']['creditcard_code'],
                    );
                    try {
                        $authorizeNet = $this->AuthorizeNet->charge($shop['Order'], $payment);
                    } catch(Exception $e) {
                        $this->Session->setFlash($e->getMessage());
                        return $this->redirect(array('action' => 'review'));
                    }
                    $order['Order']['authorization'] = $authorizeNet[4];
                    $order['Order']['transaction'] = $authorizeNet[6];
                }

                $save = $this->Order->saveAll($order, array('validate' => 'first'));
                if($save) {

                    $this->set(compact('shop'));

               //  App::uses('CakeEmail', 'Network/Email');
                  /*  $email = new CakeEmail('smtp');
                    $email->from(Configure::read('Settings.ADMIN_EMAIL'))
                           // ->cc(Configure::read('Settings.ADMIN_EMAIL'))
                            ->to('pravendra.kumar@webenturetech.com')
                            ->subject('Yumplate Order')
                            ->template('order')
                            ->emailFormat('html')
                            ->viewVars(array('shop' => $shop))
                            ->send();*/
                    $this->Session->setFlash('Thank You for Your Order !','default',array('class'=>'alert alert-success'));
                    if($this->Auth->user('role')=='admin'){
                        return $this->redirect(array('action' => 'dashboard','admin'=>true));
                    }else{
                        return $this->redirect(array('action' => 'dashboard','customer'=>true));
                    }
                    
                } else {
                    $errors = $this->Order->invalidFields();
                    $this->set(compact('errors'));
                }
            }
        }
        
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
        // pr($shop);
        $this->set(compact('reviewArr'));
        $this->set(compact('shop'));
        $this->set(compact('hst'));

    } 

    
    public function success() {
        $shop = $this->Session->read('Shop');
        $this->Cart->clear();
        if(empty($shop)) {
            return $this->redirect('/');
        }
        $this->set(compact('shop'));

    }
    
    public function Register(){
        $this->layout='front';
        if($this->request->is('post')){
           
            $this->request->data['User']['username']=$this->request->data['User']['first_name'];
            
       
                $this->User->validator()->remove('oldpassword');
                if($this->User->save($this->request->data)){
                $last = $this->User->findById($this->User->id);
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
          $data['User']['first_name']=$this->request->data['name'];
          $data['User']['last_name']=$this->request->data['last_name'];
          $data['User']['email']=$this->request->data['email'];
          $data['User']['social_login']=1;
          $data['User']['role']='customer';
           $data['User']['image_link']='http://graph.facebook.com/'.$this->request->data['id'].'/picture?type=large';
          $data['User']['username']=$this->request->data['name'];
           
         //if($this->User->SendSocialRegisterMail($data)){
          $userData=$this->User->find('first',array('conditions'=>array('User.email'=>$this->request->data['email'])));
          if(empty($userData)){
            $this->User->validator()->remove('oldpassword');
                if($this->User->save($data)){
                    $this->Session->write('Auth',$data);
                    echo json_encode(array('type'=>'success'));die;
                }else{
                    echo json_encode(array('type'=>'error','msg'=>'Does Not saved'));die;
                }
             }else{
                $this->User->id = $userData['User']['id'];
                $data['last_login']=date('Y-m-d H:i:s');
                $this->User->saveField('last_login', $data['last_login'], false);
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
                $newPassword = $this->generatePassword();
               
                $newPasswordMd5 =AuthComponent::password($newPassword);
                //pr( $newPasswordMd5); die;

                if($this->User->updatePassword($userId,$newPasswordMd5))
                 {
                $this->User->sendForgetPassMail($this->data['User']['email'],$userName,$userId,$fullName,$newPassword);
                $this->Session->setFlash('An email has been sent to you. Please check your inbox!','default',array('class'=>'alert alert-success'));
                $this->redirect('/users/register');
                }
                }else{
                $this->Session->setFlash('Unautharised User !','default',array('class'=>'alert alert-success'));
                $this->redirect('/users/register');
                }

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

  public function _sendNewUserMail($email,$userName,$userId,$fullName,$pass) 
   { 
        $setUrl = "";
        $this->__setSmtp();
        $this->SwiftMailer->sendAs = 'html';
        $this->SwiftMailer->from = SMTP_USER;
        $this->SwiftMailer->fromName = 'Administrator';
        //$this->SwiftMailer->cc = 'ritesh.satia@gmail.com';
        $this->SwiftMailer->to = trim($email);
        
        $setUrl =FULL_BASE_URL."/users/";
        //$this->set('setUrl',$setUrl);
        $fpStatus = 1;
        $this->Session->write('forgetpass.userName',$userName);
        $this->Session->write('forgetpass.fullName',$fullName);
        $this->Session->write('forgetpass.pass',$pass);
        $this->Session->write('forgetpass.setUrl',$setUrl);
        $this->Session->write('forgetpass.SITE_TITLE','Rug Studio Online');
        $this->User->updateForgotPassStatus($userId,$fpStatus);
        $this->SwiftMailer->send('forgot_password', 'Rug Studio Online Reset Password');
        $this->Session->delete('forgetpass');


  }


//////////////////////////////////////////////////////////////

    public function contact(){
      $this->autoRender=false;
      if($this->request->is('post')){
       //pr($this->data);die;
          $email = new CakeEmail('smtp');
          $email->sender($this->request->data['email']);
          $email->to(Configure::read('Settings.ADMIN_EMAIL'));
          $email->emailFormat('html');
          if($this->request->data['type']=='contact'){
            $email->subject('Query mail from contact page');
          }else{
             $email->subject('Query mail from become yumcook  page');
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
}
