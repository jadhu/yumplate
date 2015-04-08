<?php
App::uses('AppController', 'Controller');
class ProductsController extends AppController {

////////////////////////////////////////////////////////////

    public $components = array(
        'RequestHandler',
    );
    //public $uses=array('Page');
////////////////////////////////////////////////////////////

    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout='admin';
        $this->loadModel('Cart');
        $this->Auth->allow(array('ExploreYum','RedirectUrl','admin_searchRedirect'));
        $this->set('count',$this->Cart->find('count',array('conditions'=>array('Cart.user_id'=>$this->Session->read('Auth.User.id')))));
    
       
    }

////////////////////////////////////////////////////////////

    public function index() {
      $this->layout='front';
      $this->loadModel('Story');
        
        $products = $this->Product->find('all', array(
            'recursive' => -1,
            'contain' => array('User','Review'),
            'limit' => 20,
            'conditions' => array(
                'Product.active' => 1,
                'Product.featured' => 1,
                'MATCH(Product.day) AGAINST(? IN BOOLEAN MODE)'=>strtolower(date("l"))
            ),
            'order' => array(
                'Product.views' => 'ASC'
            )
        ));

         $stories = $this->Story->find('all', array(
            'recursive' => -1,
            //'contain' => array('User'),
            'limit' => 5,
            'conditions' => array(
                //'Story.active' => 1,
                'Story.featured' => 1
            ),
            'order' => array(
                'Story.created' => 'ASC'
            )
        ));
        //pr($products);
        $this->set(compact('products'));
        $this->set(compact('stories'));
        
        $this->Product->updateViews($products);

        $this->set('title_for_layout', Configure::read('Settings.SHOP_TITLE'));
    }

////////////////////////////////////////////////////////////

    public function products() {
        $this->layout='front';
        $this->Paginator = $this->Components->load('Paginator');

        $this->Paginator->settings = array(
            'Product' => array(
                'recursive' => -1,
                'contain' => array(
                    'Brand'
                ),
                'limit' => 20,
                'conditions' => array(
                    'Product.active' => 1,
                    'Brand.active' => 1
                ),
                'order' => array(
                    'Product.name' => 'ASC'
                ),
                'paramType' => 'querystring',
            )
        );
        $products = $this->Paginator->paginate();
        $this->set(compact('products'));

        $this->set('title_for_layout', 'All Products - ' . Configure::read('Settings.SHOP_TITLE'));

    }

////////////////////////////////////////////////////////////

    public function view($id = null) {
              if($this->Session->read('Auth.User.role')!='admin'){
               $this->layout='front';
              }
            $product = $this->Product->find('first', array(
                'recursive' => -1,
                'contain' => array(
                'Category',
                // 'Brand'
                ),
                'conditions' => array(
                //'Brand.active' => 1,
                'Product.active' => 1,
                'Product.slug' => $id
                )
            ));
        
        if (empty($product)) {
            return $this->redirect(array('action' => 'index'), 301);
        }

        $this->Product->updateViews($product);

        $this->set(compact('product'));

       // $productmods = $this->Product->Productmod->getAllProductMods($product['Product']['id'], $product['Product']['price']);
        //$this->set('productmodshtml', $productmods['productmodshtml']);

        $this->set('title_for_layout', $product['Product']['name'] . ' ' . Configure::read('Settings.SHOP_TITLE'));
        $product_day=explode(',',$product['Product']['day']);
       if(count($product_day)>1){
            $today=date('Y-m-d');
            if(in_array($today,explode(',',$product['Product']['day']))){

            $this->set('meal_day',$today);
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
        }
       
    }

////////////////////////////////////////////////////////////

    public function search() {

        $search = null;
        if(!empty($this->request->query['search']) || !empty($this->request->data['name'])) {
            $search = empty($this->request->query['search']) ? $this->request->data['name'] : $this->request->query['search'];
            $search = preg_replace('/[^a-zA-Z0-9 ]/', '', $search);
            $terms = explode(' ', trim($search));
            $terms = array_diff($terms, array(''));
            $conditions = array(
                'Brand.active' => 1,
                'Product.active' => 1,
            );
            foreach($terms as $term) {
                $terms1[] = preg_replace('/[^a-zA-Z0-9]/', '', $term);
                $conditions[] = array('Product.name LIKE' => '%' . $term . '%');
            }
            $products = $this->Product->find('all', array(
                'recursive' => -1,
                'contain' => array(
                    'Brand'
                ),
                'conditions' => $conditions,
                'limit' => 200,
            ));
            if(count($products) == 1) {
                return $this->redirect(array('controller' => 'products', 'action' => 'view', 'slug' => $products[0]['Product']['slug']));
            }
            $terms1 = array_diff($terms1, array(''));
            $this->set(compact('products', 'terms1'));
        }
        $this->set(compact('search'));

        if ($this->request->is('ajax')) {
            $this->layout = false;
            $this->set('ajax', 1);
        } else {
            $this->set('ajax', 0);
        }

        $this->set('title_for_layout', 'Search');

        $description = 'Search';
        $this->set(compact('description'));

        $keywords = 'search';
        $this->set(compact('keywords'));
    }

////////////////////////////////////////////////////////////

    public function searchjson() {

        $term = null;
        if(!empty($this->request->query['term'])) {
            $term = $this->request->query['term'];
            $terms = explode(' ', trim($term));
            $terms = array_diff($terms, array(''));
            $conditions = array(
                // 'Brand.active' => 1,
                'Product.active' => 1
            );
            foreach($terms as $term) {
                $conditions[] = array('Product.name LIKE' => '%' . $term . '%');
            }
            $products = $this->Product->find('all', array(
                'recursive' => -1,
                'contain' => array(
                    // 'Brand'
                ),
                'fields' => array(
                    'Product.id',
                    'Product.name',
                    'Product.image'
                ),
                'conditions' => $conditions,
                'limit' => 20,
            ));
        }
        // $products = Hash::extract($products, '{n}.Product.name');
        echo json_encode($products);
        $this->autoRender = false;

    }

////////////////////////////////////////////////////////////

    public function sitemap() {
        $products = $this->Product->find('all', array(
            'recursive' => -1,
            'contain' => array(
                'Brand' 
            ),
            'fields' => array(
                'Product.slug'
            ),
            'conditions' => array(
                'Brand.active' => 1,
                'Product.active' => 1
            ),
            'order' => array(
                'Product.created' => 'DESC'
            ),
        ));
        $this->set(compact('products'));

        $website = Configure::read('Settings.WEBSITE');
        $this->set(compact('website'));

        $this->layout = 'xml';
        $this->response->type('xml');
    }

////////////////////////////////////////////////////////////

    public function admin_reset() {
        $this->Session->delete('Product');
        return $this->redirect(array('action' => 'index'));
    }


    ////////////////////////////////////////////////////////////

    /*
    function redirect url for searching category 

    */
        public function admin_searchRedirect(){
            if($this->request->is('post')){
              //pr($this->request->data);die;
            $this->redirect(
                array(
                'controller'=>'products',
                'action'=>'index',
                'status'=>isset($this->request->data['Product']['active'])?$this->request->data['Product']['active']:'',
                'recipe'=>!empty($this->request->data['Product']['recipe_name'])?$this->request->data['Product']['recipe_name']:'',
                'cook'=>!empty($this->request->data['Product']['cook_name'])?$this->request->data['Product']['cook_name']:'',
                'location'=>!empty($this->request->data['Product']['location'])?$this->request->data['Product']['location']:'',
                'admin'=>true
               ));
           }
        }

////////////////////////////////////////////////////////////

    public function admin_index() {
            $this->layout='admin';

            $this->Paginator = $this->Components->load('Paginator');

            $condition=array();
            $joins=array();
      

        if(isset($this->params->params['named']['status'])||isset($this->params->params['named']['recipe'])||isset($this->params->params['named']['cook'])||isset($this->params->params['named']['location'] )){
         
              if(isset($this->params->params['named']['status'])&& $this->params->params['named']['status']!='' ){
                  $condition['AND'][]=array('Product.active'=>$this->params->params['named']['status']);
              }

              if(!empty($this->params->params['named']['recipe'])){
                  $condition['AND'][]['OR']=array(
                             'Product.name LIKE '=> '%'.$this->params->params['named']['recipe'].'%',
                             'Product.slug LIKE '=> '%'.$this->params->params['named']['recipe'].'%'
                             );
              }

              if(!empty($this->params->params['named']['cook'])){
                  $condition['AND'][]['OR']=array(
                             'UserJoin.first_name LIKE '=> '%'.$this->params->params['named']['cook'].'%',
                             'UserJoin.last_name LIKE '=> '%'.$this->params->params['named']['cook'].'%'
                          );
              }

              if(!empty($this->params->params['named']['location'])){
                  $condition['AND'][]['OR']=array(
                              'UserJoin.city'=>$this->params->params['named']['location'],
                              'UserJoin.country'=>$this->params->params['named']['location'],
                             );
              }

             if(!empty($this->params->params['named']['cook']) || !empty($this->params->params['named']['location'])){
                $joins[]=array(
                        'table' => 'users',
                        'alias' => 'UserJoin',
                        'type' => 'INNER',
                        'conditions' => array(
                        'UserJoin.id = Product.user_id'
                        )
                    );
                
            }
           
            if(!empty($joins)){
                  $this->Paginator->settings = array(
                    'Product' => array(
                        'contain' => array(
                            'Category'=>array('fields'=>array('Category.id','Category.name')),
                            'User'=>array('fields'=>array('User.first_name','User.last_name','User.city','User.country'))
                         ),
                        'recursive' => -1,
                        'limit' => 20,
                        'conditions' => $condition,
                        'joins'=>$joins,
                        'order' => array(
                            'Product.modified' => 'DESC'
                        ),
                       
                    )
                );
           }else{
                $this->Paginator->settings = array(
                    'Product' => array(
                        'contain' => array(
                            'Category'=>array('fields'=>array('Category.name','Category.id')),
                            'User'=>array('fields'=>array('User.first_name','User.last_name','User.city','User.country'))
                         ),
                        'recursive' => -1,
                        'limit' => 20,
                        'conditions' => $condition,
                        'order' => array(
                           'Product.modified' => 'DESC'
                        ),
                       
                     )
               );
           }
       
         
        }else{
         $this->Paginator->settings = array(
            'Product' => array(
                'contain' => array(
                            'Category'=>array('fields'=>array('Category.name','Category.id')),
                            'User'=>array('fields'=>array('User.first_name','User.last_name','User.city','User.country'))
                         ),
                'recursive' => -1,
                'limit' => 20,
                'order' => array(
                    'Product.modified' => 'DESC'
                ),
               
            )
        );
        
       }



        
        $products = $this->Paginator->paginate();

        $brands = $this->Product->Brand->findList();

        $brandseditable = array();
        foreach ($brands as $key => $value) {
            $brandseditable[] = array(
                'value' => $key,
                'text' => $value,
            );
        }

        // $categories= $this->Product->Category->find('list', array(
        //  'recursive' => -1,
        //  'order' => array(
        //      'Category.name' => 'ASC'
        //  )
        // ));

        $categories = $this->Product->Category->generateTreeList(null, null, null, '--');

        $categorieseditable = array();
        foreach ($categories as $key => $value) {
            $categorieseditable[] = array(
                'value' => $key,
                'text' => $value,
            );
        }

        $tags = ClassRegistry::init('Tag')->find('all', array(
            'order' => array(
                'Tag.name' => 'ASC'
            ),
        ));

        $this->set(compact('products', 'brands', 'brandseditable', 'categorieseditable', 'tags'));

    }

////////////////////////////////////////////////////////////

    public function admin_view($id = null) {

        $this->loadModel('Cart');
         
        if (!$this->Product->exists($id)) {
            throw new NotFoundException('Invalid product');
        }

        $product = $this->Product->find('first', array(
            'recursive' => -1,
            'contain' => array(
                'Category',
                'Brand',
                'User'
            ),
            'conditions' => array(
                'Product.id' => $id
            )
        ));

        $this->set(compact('product'));
    }


///////////////////////////////////////////////////////////
    public function admin_add() {
        
        
        
        if (($this->request->is('post') || $this->request->is('put')) /*&& !empty($this->request->data['Product']['image']['name'])*/) {
           

            list($width, $height) = getimagesize($this->request->data['Product']['image']['tmp_name']);
            // pr($width);die;
                if($width!='740' && $height!='510'){
               $this->Session->setFlash('Image  size  should be 740x510','default',array('class'=>'alert alert-danger'));
               $this->redirect($this->referer());
             }
            App::import('Vendor', 'ResizeImage', array('file' => 'thumbnail' . DS . 'ThumbLib.inc.php'));
            $this->Img = $this->Components->load('Img');

            $this->request->data['Product']['slug']= $this->Product->generateSlug($this->request->data['Product']['name']);

            $ext = $this->Img->ext($this->request->data['Product']['image']['name']);

            $origFile ='meal'.time(). '.' . $ext;
            

            $targetdir = WWW_ROOT . 'images/original';

            $upload = $this->Img->upload($this->request->data['Product']['image']['tmp_name'], $targetdir, $origFile);

            if($upload == 'Success') {
                $resize = new ResizeImage($targetdir . DS . $origFile);
                $resize->resizeTo(510, 510, 'maxHeight');
                $resize->saveImage(WWW_ROOT . 'images/small/'.$origFile);

                $resize->resizeTo(368, 328, 'exact');
                $resize->saveImage(WWW_ROOT . 'images/large/'.$origFile);

                $this->request->data['Product']['image'] = $origFile;
            } else {
                $this->request->data['Product']['image'] = '';
            }
             
            $this->request->data['Product']['pick_time_from']=date("H:i", strtotime($this->request->data['Product']['pick_time_from']));
            $this->request->data['Product']['pick_time_to']=date("H:i", strtotime($this->request->data['Product']['pick_time_to']));
            $this->request->data['Product']['order_time']=date("H:i", strtotime($this->request->data['Product']['order_time']));
            
            if(!empty($this->request->data['Product']['avail_multiple_day'])){
            $this->request->data['Product']['day']=implode(",", $this->request->data['Product']['day']);
            }
            if ($this->Product->save($this->request->data)) {
               $this->Session->setFlash('Recipe has been added successfully.','default',array('class'=>'alert alert-success'));
                //return $this->redirect($this->referer());
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The Product could not be saved. Please, try again.','default',array('class'=>'alert alert-danger'));
            }
        }
        
        $users = $this->Product->User->find('list',array('fields'=>array('id','first_name'),'conditions'=>array('role'=>'cook')));
       // pr($users);
        $this->set(compact('users'));
        
        
        //$brands = $this->Product->Brand->find('list');
        //$this->set(compact('brands'));

        $categories = $this->Product->Category->generateTreeList(null, null, null, '--');
        $this->set(compact('categories'));
        # return $this->redirect(array('action' => 'index'));
    }

////////////////////////////////////////////////////////////

    public function admin_edit($id = null) {
        
         
        if (!$this->Product->exists($id)) {
            throw new NotFoundException('Invalid product');
        }

        
        if ($this->request->is('post') || $this->request->is('put')) {
            
         // pr($this->request->data);die;
            App::import('Vendor', 'ResizeImage', array('file' => 'thumbnail' . DS . 'ThumbLib.inc.php'));
            $this->Img = $this->Components->load('Img');
            $targetdir = WWW_ROOT . 'images/original';
             
              if(!empty($this->request->data['Product']['image']['name'])){
                list($width, $height) = getimagesize($this->request->data['Product']['image']['tmp_name']);
                if($width!='740' && $height!='510'){
                $this->Session->setFlash('Image  size  should be 740x510 ','default',array('class'=>'alert alert-danger'));
                $this->redirect($this->referer());
                }
                $ext = $this->Img->ext($this->request->data['Product']['image']['name']);

                $origFile = 'meal'.time(). '.' . $ext;
            
                if(file_exists($targetdir.$this->request->data['Product']['image_name'])){
                     @unlink($targetdir.$this->request->data['Product']['image_name']);
                }

                if(file_exists(WWW_ROOT . 'images/large/'.$this->request->data['Product']['image_name'])){
                     @unlink(WWW_ROOT . 'images/large/'.$this->request->data['Product']['image_name']);
                }

                if(file_exists(WWW_ROOT . 'images/small/'.$this->request->data['Product']['image_name'])){
                     @unlink(WWW_ROOT . 'images/small/'.$this->request->data['Product']['image_name']);
                }

                $upload = $this->Img->upload($this->request->data['Product']['image']['tmp_name'], $targetdir, $origFile);

                if($upload == 'Success') {

                    //$this->Img->resampleGD($targetdir . DS . $origFile, WWW_ROOT . 'images/large/', $origFile, 368, 328, 1, 0);
                   // $this->Img->resampleGD($targetdir . DS . $origFile, WWW_ROOT . 'images/small/', $origFile, 295, 295, 1, 0);
                    $resize = new ResizeImage($targetdir . DS . $origFile);
                    $resize->resizeTo(304, 209, 'maxWidth');
                    $resize->saveImage(WWW_ROOT . 'images/small/'.$origFile);

                    $resize->resizeTo(368, 328, 'exact');
                    $resize->saveImage(WWW_ROOT . 'images/large/'.$origFile);

                    $this->request->data['Product']['image'] = $origFile;
                }


            }else{
                $this->request->data['Product']['image'] =$this->request->data['Product']['image_name'];
            }
              $this->request->data['Product']['pick_time_from']=date("H:i", strtotime($this->request->data['Product']['pick_time_from']));
              $this->request->data['Product']['pick_time_to']=date("H:i", strtotime($this->request->data['Product']['pick_time_to']));
              $this->request->data['Product']['order_time']=date("H:i", strtotime($this->request->data['Product']['order_time']));
            
              if(!empty($this->request->data['Product']['avail_multiple_day'])){
               $this->request->data['Product']['day']=implode(",", $this->request->data['Product']['day']);
               }
              //pr($this->request->data);die;
            if ($this->Product->save($this->request->data)) {
               $this->Session->setFlash('The Recipe updated successfully.','default',array('class'=>'alert alert-success'));
                return $this->redirect(array('controller'=>'products','action'=>'index','admin'=>true));
            } else {
               $this->Session->setFlash('The Product could not be saved. Please, try again.','default',array('class'=>'alert alert-danger'));
            }



        }else{
            $product = $this->Product->find('first', array(
                'conditions' => array(
                    'Product.id' => $id
                )
            ));
            //pr($product);
             if(!empty($product['Product']['avail_multiple_day'])){

             $product['Product']['day']=explode(',', $product['Product']['day']);
            }
            $this->request->data = $product;
        }

        $this->set(compact('product'));

        $brands = $this->Product->Brand->find('list');
        $this->set(compact('brands'));

        $categories = $this->Product->Category->generateTreeList(null, null, null, '--');
        $this->set(compact('categories'));

       /*$productmods = $this->Product->Productmod->find('all', array(
            'conditions' => array(
                'Productmod.product_id' => $product['Product']['id']
            )
        ));
        $this->set(compact('productmods'));*/

        $users = $this->Product->User->find('list',array(
                      'conditions'=>array('User.role'=>'cook'),
                      'fields'=>array('id','first_name')
                      ));
        
        $this->set(compact('users'));

    }

////////////////////////////////////////////////////////////

    public function admin_tags($id = null) {

        $tags = ClassRegistry::init('Tag')->find('all', array(
            'recursive' => -1,
            'fields' => array(
                'Tag.name'
            ),
            'order' => array(
                'Tag.name' => 'ASC'
            ),
        ));
        $tags = Hash::combine($tags, '{n}.Tag.name', '{n}.Tag.name');
        $this->set(compact('tags'));

        if ($this->request->is('post') || $this->request->is('put')) {

            $tagstring = '';

            foreach($this->request->data['Product']['tags'] as $tag) {
                $tagstring .= $tag . ', ';
            }

            $tagstring = trim($tagstring);
            $tagstring = rtrim($tagstring, ',');

            $this->request->data['Product']['tags'] = $tagstring;

            $this->Product->save($this->request->data, false);

            return $this->redirect(array('action' => 'tags', $this->request->data['Product']['id']));

        }

        $product = $this->Product->find('first', array(
            'conditions' => array(
                'Product.id' => $id
            )
        ));
        if (empty($product)) {
            throw new NotFoundException('Invalid product');
        }
        $this->set(compact('product'));

        $selectedTags = explode(',', $product['Product']['tags']);
        $selectedTags = array_map('trim', $selectedTags);
        $this->set(compact('selectedTags'));

        $neighbors = $this->Product->find('neighbors', array('field' => 'id', 'value' => $id));
        $this->set(compact('neighbors'));

    }

////////////////////////////////////////////////////////////

    public function admin_csv() {
        $products = $this->Product->find('all', array(
            'recursive' => -1,
        ));
        $this->set(compact('products'));
        $this->layout = false;
    }

////////////////////////////////////////////////////////////

    public function admin_delete($id = null) {
        $this->Product->id = $id;
        if (!$this->Product->exists()) {
            throw new NotFoundException('Invalid product');
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Product->delete()) {
            $this->Session->setFlash('Product deleted');
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Product was not deleted');
        return $this->redirect(array('action' => 'index'));
    }

////////////////////////////////////////////////////////////
    
    
    
    /*
*function for how it works 

*/
public function howitworks() {
    $this->loadModel('Page');
    $this->layout='front';
$this->set('Pagecontent',$this->Page->find('first',array('conditions'=>array('Page.page_name'=>@$this->params->params['action']))));	
}
/*
*function for ourstory

*/
public function ourstory() {
    $this->layout='front';
    $this->loadModel('Page');
   $this->set('Pagecontent',$this->Page->find('first',array('conditions'=>array('Page.page_name'=>@$this->params->params['action']))));	
	

}
/*
*function for contact

*/
public function contact() {
    $this->layout='front';
    $this->loadModel('Page');
$this->set('Pagecontent',$this->Page->find('first',array('conditions'=>array('Page.page_name'=>@$this->params->params['action']))));	

}
/*
*function for help

*/
public function help() {
    $this->layout='front';
    $this->loadModel('Page');
  $this->set('Pagecontent',$this->Page->find('first',array('conditions'=>array('Page.page_name'=>@$this->params->params['action']))));	
	

}
/*
*function for privacy policies

*/
public function privacypolicy() {
    $this->layout='front';
    $this->loadModel('Page');
$this->set('Pagecontent',$this->Page->find('first',array('conditions'=>array('Page.page_name'=>@$this->params->params['action']))));	
	

}
/*
*function for term and conditions

*/
public function term() {
    $this->layout='front';
    $this->loadModel('Page');
$this->set('Pagecontent',$this->Page->find('first',array('conditions'=>array('Page.page_name'=>@$this->params->params['action']))));	
	

}

/*
*function for instructions

*/
public function instruction() {
    $this->layout='front';
    $this->loadModel('Page');
  $this->set('Pagecontent',$this->Page->find('first',array('conditions'=>array('Page.page_name'=>@$this->params->params['action']))));	
	

}

/*
*function for making url for Explore meals

*/
public function RedirectUrl(){
    $this->autoRender=false;
    if($this->request->is('post')){
        $key=!empty($this->request->data['Product']['keywords'])?$this->request->data['Product']['keywords']:'';
        $this->redirect('/products/ExploreYum?keywords='.$key);
      
        
    }
    
}

/*
*function for searching meals

*/
public function ExploreYum() {
    $this->layout='front';
    $this->Paginator = $this->Components->load('Paginator');
    $search=!empty($this->params->query['keywords'])?$this->params->query['keywords']:'';
    
    if(!empty($this->params->query['keywords'])){
            $search=$this->params->query['keywords'];
            $this->Paginator->settings = array(
                    'Product' => array(
                        'contain'=>array(
                           'User'=>array('fields'=>array('city','country','first_name','username','last_name'))
                        ),
                        'recursive' => -1,
                        'limit' => 10,
                        'conditions'=>array(
                            'OR'=>array(
                                'Product.name LIKE ' => '%'.$search.'%',
                                'Product.slug LIKE ' => '%'.$search.'%',
                                'Product.tags LIKE ' => '%'.$search.'%',
                                'UserJoin.first_name LIKE ' => '%'.$search.'%',
                                'UserJoin.last_name LIKE ' => '%'.$search.'%',
                                'UserJoin.username LIKE ' => '%'.$search.'%'
                            )
                        ),
                        'joins'=>array(array(
                            'table' => 'users',
                            'alias' => 'UserJoin',
                            //'type' => 'INNER',
                            'conditions' => array(
                            'UserJoin.id = Product.user_id'
                            ))
                        ),
                        'order' => array(
                            'Product.modified' => 'DESC'
                        ),
                       
                     )
               );

    }else{
       $this->Paginator->settings = array(
                    'Product' => array(
                        'contain'=>array(
                           'User'=>array('fields'=>array('city','country','first_name','username','last_name'))
                        ),
                        'recursive' => -1,
                        'limit' => 10,
                        'order' => array(
                            'Product.modified' => 'DESC'
                        ),
                       
                    )
       );
    }
        $products = $this->Paginator->paginate();
        $this->set(compact('products'));
     

}

}
