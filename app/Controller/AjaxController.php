<?php
App::uses('AppController', 'Controller');
class AjaxController extends AppController {
   
     public function ajax_profile() {
       
      $this->layout = 'ajax';
      $this->loadModel('Product');
      $this->loadModel('User');
      $counter=$this->params->query['counter'];
      $id=$this->params->query['userId'];

      $day='';
      $day=($counter==0)?date("l"):date('l', strtotime('+'.$counter.' day', strtotime(date('Y-m-d'))));
      $date=($counter==0)?date("Y-m-d"):date("Y-m-d", strtotime('+'.$counter.' day', strtotime(date('Y-m-d'))));
       //pr($date);die;
      $product = $this->Product->find('all', array(
      'recursive' => -1,
      'contain' => array(
      'Review'=>array('id')
      ),
      'conditions' => array(
      'Product.active' => 1,
      'Product.user_id' => $id,
      'MATCH(Product.day) AGAINST(? IN BOOLEAN MODE)' => $day
      )
      ));
      //pr($product);die;

      $this->set(compact('product'));
      $this->set('day',$day);
      $this->set('date',$date);
      $this->set('counter',$counter);
     

    }

  ///////////////////////////////////////////////////////////////////
   public function editable(){
      $this->loadModel('Cart');


        $model ='Cart';
    
        $id = trim($this->request->data['pk']);
        $field = trim($this->request->data['name']);
        $value = trim($this->request->data['value']);

        $data[$model]['id'] = $id;
        $data[$model][$field] = $value;
        $this->$model->save($data, false);

        $this->autoRender = false;

}  

////////////////////////////////////////////////////////////


  public function addCart() {
    $this->autoRender=false;
    $this->layout = 'ajax';
    $this->loadModel('Cart');
    $this->loadModel('Product');
   
   
    //setting the timezone for all dates using TimeHelper
    Configure::write('Config.timezone','America/New York');
    $data=array();
    if($this->request->is('post') && $this->request->is('ajax')){
      //for current day check to order time is passed or not
       $today=strtolower(date("l"));
       $current_time=date('h:i:s a', strtotime(date('Y-m-d H:i:s')));
     //pr($current_time);die;
       if($today==$this->request->data['day']){
         if(!$this->Product->canAddCart($this->request->data['mealId'],$current_time)){
          echo json_encode(array('type'=>'failure','msg'=>'Sorry! The order cutoff time has passed. Please add a different meal'));die;
         }
       }
      //
      $count=$this->Cart->find('count',array(
                                'conditions'=>array(
                                  'Cart.user_id'=>$this->request->data['userId'],
                                  'Cart.product_id'=>$this->request->data['mealId'],
                                  'Cart.pick_up_day'=>$this->request->data['day']
                                    )));


      if($count==0){
          $data['Cart']['user_id']=$this->request->data['userId'];
          $data['Cart']['product_id']=$this->request->data['mealId'];
          $data['Cart']['cook_id']=$this->request->data['cookId'];
          $data['Cart']['comment']=$this->request->data['comment'];
          $data['Cart']['pick_up_day']=$this->request->data['day'];
          //$data['Cart']['order_date']=$this->request->data['order_date'];
          $this->Cart->save($data);
          $id=$this->Cart->getLastInsertID();
          $saved_data=$this->Cart->findById($id);
          
          $cart_product=$this->Cart->find('count',array(
                                'conditions'=>array(
                                  'Cart.user_id'=>$this->request->data['userId'],
                                   )));

          echo json_encode(array('type'=>'success','count'=>$cart_product,'msg'=>'Successfully added to Cart','order_date'=>$saved_data['Cart']['order_date'],'order_day'=>ucfirst($this->request->data['day'])));die;

      }else{
        $cart_product=$this->Cart->find('count',array(
                                'conditions'=>array(
                                  'Cart.user_id'=>$this->request->data['userId'],
                                   )));

          echo json_encode(array('type'=>'failure','count'=>$cart_product,'msg'=>'Already added in Cart'));die;

      }
      

    }else{
       echo json_encode(array('type'=>'failure','count'=>$cart_product,'msg'=>'Bad request'));die;
    }
    
}
/////////////////////////////////////////////////////////////////////////////

public function updateCart(){
        $this->autoRender=false;
        $this->loadModel('Cart');
        $this->loadModel('Product');
        $this->loadModel('Coupon');
        $cartData=array();
     if($this->request->is('post') && $this->request->is('ajax')){
          $quantity=$this->request->data['quantity'];
          $cartId=$this->request->data['cartId'];
          $cost=0;
          $products=$this->Product->find('first',array(
                                          'conditions'=>array(
                                                'Product.id'=>$this->request->data['productId']
                                            ),
                                          'fields'=>array('id','price','order_time'),
                                          'contain'=>array(
                                                 'User'=>array('fields'=>array('id','first_name','role'))
                                           )
                    ));

           $discountData=$this->Coupon->find('first',array(
                                                 'conditions'=>array(
                                                      'Coupon.user_id'=>$products['User']['id'],
                                                      'Coupon.active'=>1
                                                  )
                     ));

             $price=$quantity*$products['Product']['price'];
             $discount=0;
            if(!empty($discountData)){
                    $today_timestamp=strtotime(date("Y-m-d"));
                    $start_date_timestamp=strtotime($discountData['Coupon']['start_date']);
                    $end_date_timestamp=strtotime($discountData['Coupon']['end_date']);

                    if($today_timestamp>=$start_date_timestamp && $today_timestamp<=$end_date_timestamp){
                            if($price>=$discountData['Coupon']['discount_limit']){
                                $discount=($price*$discountData['Coupon']['discount'])/100;
                            }
                    }
            }
        
      
         $this->Cart->id=$cartId;
         $this->Cart->saveField('discount',round($discount,2));
         $this->Cart->saveField('quantity',$quantity);
         echo json_encode(array('type'=>'success','Successfully deleted from cart'));
     }else{
         echo json_encode(array('type'=>'failure','Bad request'));
     }
}

/////////////////////////////////////////////////////////////////////////////

public function deleteCart(){
    $this->autoRender=false;
     $this->loadModel('Cart');
     if($this->request->is('post')){
         $id=$this->request->data['cartId'];
         if($this->Cart->delete($id)){
            echo json_encode(array('type'=>'success','Successfully deleted from cart'));
         }else{
            echo json_encode(array('type'=>'failure','Not delete from cart'));  
         }
         
     }
}
  



public function addReview(){
        $this->autoRender=false;
        $this->loadModel('Review');
       
        $data=array();
       if($this->request->is('post')){
          $data['user_id']=$this->request->data['userId'];
          $data['product_id']=$this->request->data['productId'];
          $data['cook_id']=$this->request->data['cookId'];
          $data['comments']=$this->request->data['comment'];
         
          $data['val_rating']=$this->request->data['val_rating'];
          $data['ontime_rating']=$this->request->data['ontime_rating'];
          $data['easyfind_rating']=$this->request->data['easyfind_rating'];
           if($this->Review->save($data)){
            
             echo json_encode(array('type'=>'success','msg'=>'Successfully comment added'));
           }else{
            echo json_encode(array('type'=>'failure',));
           }
           
      }
       
}


//function for reviews
public function profileReview(){
       //$this->autoRender=false;
        $this->layout = 'ajax';
        $limit=3;
        $this->loadModel('Review');
        $this->loadModel('User');
        if($this->request->is('post')){
          $ids=explode(',',$this->request->data['userIds']);
          
          $review=$this->Review->find('all',array(
                             'conditions'=>array('Review.product_id'=>$ids),
                             'order'=>array('Review.created desc'),
                             'contain'=>array('User'=>array('foreignKey'=>'user_id')),
                             'limit'=>$limit
            ));
          $profie_review=$this->User->find('first',array(
                             'conditions'=>array('User.id'=>$this->request->data['cookId']),
                             
            ));

          //pr($profie_review);die;
           $this->set(compact('review'));
           $this->set(compact('profie_review'));
           $this->set('count',count($review));
        }
      
       
}



//function for reviews
public function addComment(){
       //$this->autoRender=false;
        $this->layout = 'ajax';
        $limit=3;
        $this->loadModel('Review');
        if($this->request->is('post')){
          $ids=explode(',',$this->request->data['userIds']);
          $count=$this->request->data['count'];
          $review=$this->Review->find('all',array(
                             'conditions'=>array('Review.product_id'=>$ids),
                             'order'=>array('Review.created desc'),
                             'contain'=>array('User'),
                             'offset'=>$count,
                             'limit'=>$limit
            ));
          //pr($review);die;
           $this->set(compact('review'));
           $this->set('count',count($review));
        }
      //$this->render('profileReview');
       
}

//function for search meals name for autocomplete search

public function searchMeal(){
  $this->autoRender=false;
  $list=array();
  $this->loadModel('Product');
 $search=!empty($this->params->query['query'])?$this->params->query['query']:'';
 $products=$this->Product->find('all',array('conditions'=>array('OR'=>array(
                          'Product.name LIKE ' => '%'.$search.'%',
                          'Product.slug LIKE ' => '%'.$search.'%'
                      )),
                   'fields'=>array('id','name')
         ));
   
   if(!empty($products)){
       foreach ($products as $key => $value) {
        $list[$key]['name']=$value['Product']['name'];
       }

       echo json_encode($list);die;
   }
  
}


//function for searching products listing if they are not avail today/tommorow

 public function querySearchMeal(){
      $this->layout = 'ajax';
      $this->loadModel('Product');
      $this->loadModel('User');
      $this->loadModel('Cart');
      $query=strtolower(trim($this->params->query['recipe']));
      $id=$this->params->query['userId'];

     
       $day=strtolower(date("l"));
     
      $product = $this->Product->find('first', array(
      'recursive' => -1,
      'contain' => array(
      'Review'=>array('id')
      ),
      'conditions' => array(
        'OR'=>array(
           'Product.name' => $query,
           'Product.slug' => $query,
           ),
        'Product.active' => 1,
        'Product.user_id' => $id,
        'Product.day !=' => $day,
        
     
      )
      ));
         //pr($product);die;
      if(empty($product)){
        $this->autoRender=false;
        return ;die;
      }
      $today=date('Y-m-d');

      if(in_array($day,explode(',',$product['Product']['day']))){
          //pr(explode(',',$product['Product']['day']));die;
        $this->set('meal_day',$day);
      }else{
        for($i=1;$i<=6;$i++){
          $closest_day=strtolower(date('l', strtotime('+'.$i.' day', strtotime(date('Y-m-d')))));
          
          if(in_array($closest_day,explode(',',$product['Product']['day']))){
             $date=$this->Cart->closestDate($closest_day);
             $close_day=date('l',strtotime($date));
            
            break;
          }
        }
       
        $this->set('meal_day',strtolower($close_day));
      }
      
      $this->set(compact('product'));
     
      //$this->set('day',$day);
  
}


//////////////////////////////////////////////////////////////////////

public function showComment(){
      $this->layout = 'ajax';
      $this->loadModel('Product');
        if($this->request->is('post')){
           $product=$this->Product->find('first',array(
                          'conditions'=>array(
                               'Product.id'=>$this->request->data['productId']
                               ),
                          'contain'=>array(
                              
                              'Review.User'=>array('fields'=>array('id','first_name','last_name','image'))
                              ),
                          'fields'=>array('id','image','name','price')
                        ));
           //pr($product);die;
           $this->set(compact('product'));
        }
}


}
