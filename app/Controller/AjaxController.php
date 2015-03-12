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
      // pr($day);
      $product = $this->Product->find('all', array(
      'recursive' => -1,
      'contain' => array(
      'Review'=>array('id')
      ),
      'conditions' => array(
      'Product.active' => 1,
      'Product.user_id' => $id,
      'Product.day' => $day
      )
      ));
      //pr($product);die;

      $this->set(compact('product'));
      $this->set('day',$day);
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
    $data=array();
    if($this->request->is('post')){

      $count=$this->Cart->find('count',array(
                                'conditions'=>array(
                                  'Cart.user_id'=>$this->request->data['userId'],
                                  'Cart.product_id'=>$this->request->data['mealId']
                                    )));


      if($count==0){
          $data['Cart']['user_id']=$this->request->data['userId'];
          $data['Cart']['product_id']=$this->request->data['mealId'];
          $data['Cart']['cook_id']=$this->request->data['cookId'];
          $data['Cart']['comment']=$this->request->data['comment'];
          $this->Cart->save($data);
          $cart_product=$this->Cart->find('count',array(
                                'conditions'=>array(
                                  'Cart.user_id'=>$this->request->data['userId'],
                                   )));

          echo json_encode(array('type'=>'success','count'=>$cart_product,'msg'=>'Successfully added in Cart'));die;

      }else{
        $cart_product=$this->Cart->find('count',array(
                                'conditions'=>array(
                                  'Cart.user_id'=>$this->request->data['userId'],
                                   )));

          echo json_encode(array('type'=>'failure','count'=>$cart_product,'msg'=>'Already added in Cart'));die;

      }
      

    }
    
}

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
      $query=strtolower(trim($this->params->query['recipe']));
      $id=$this->params->query['userId'];

     
       $day=date("l");
     
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

      if(empty($product)){
        $this->autoRender=false;
        return ;die;
      }

      $this->set(compact('product'));
      //$this->set('day',$day);
  
}

}
