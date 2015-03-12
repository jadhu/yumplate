<?php
App::uses('AppController', 'Controller');
class CategoriesController extends AppController {


     public function beforeFilter() {
        parent::beforeFilter();
        //$this->layout='admin';
        $this->Auth->allow(array('admin_searchRedirect'));
    }

////////////////////////////////////////////////////////////

    public function index() {
        $this->helpers[] = 'Tree';
        $categories = $this->Category->find('all', array(
            'recursive' => -1,
            'order' => array(
                'Category.lft' => 'ASC'
            ),
            'conditions' => array(
            ),
        ));
        $this->set(compact('categories'));
    }

////////////////////////////////////////////////////////////

    public function view($slug = null) {
        $this->layout='admin';
        $category = $this->Category->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'Category.slug' => $slug
            )
        ));
        if(empty($category)) {
            return $this->redirect(array('action' => 'index'));
        }
        $this->set(compact('category'));

        // $parent = $this->Category->getParentNode($category['Category']['id']);
        // debug($parent);

        $parents = $this->Category->getPath($category['Category']['id']);
        // debug($parents);
        $this->set(compact('parents'));

         // $totalChildren = $this->Category->childCount($category['Category']['id']);
         // debug($totalChildren);

        $directChildren = $this->Category->children($category['Category']['id']);
        // debug($directChildren);

        $directChildrenIds = Hash::extract($directChildren, '{n}.Category.id');
        array_push($directChildrenIds, $category['Category']['id']);

        //debug($parents);

        $products = $this->Category->Product->find('all', array(
            'recursive' => -1,
            'conditions' => array(
                'Product.category_id' => $directChildrenIds
            ),
            'order' => array(
                'Product.name' => 'ASC'
            ),
            'limit' => 50
        ));
        $this->set(compact('products'));
    }

////////////////////////////////////////////////////////////

/*
function redirect url for searching category 

*/
    public function admin_searchRedirect(){
        if($this->request->is('post')){
          
        $this->redirect(
            array(
                'controller'=>'categories',
                'action'=>'index',
               'status'=>isset($this->request->data['Category']['active'])?$this->request->data['Category']['active']:'',
               'category'=>!empty($this->request->data['Category']['category_name'])?$this->request->data['Category']['category_name']:'',
               'cook'=>!empty($this->request->data['Category']['cook_name'])?$this->request->data['Category']['cook_name']:'',
           ));
       }
    }

////////////////////////////////////////////////////////////    

    public function admin_index() {
        $this->Paginator = $this->Components->load('Paginator');
        $condition=array();
        $joins=array();
      

        if(isset($this->params->params['named']['status'])||isset($this->params->params['named']['category'])||isset($this->params->params['named']['cook'])){
         
              if(isset($this->params->params['named']['status'])&& $this->params->params['named']['status']!=''){
                  $condition['AND'][]=array('Category.active'=>$this->params->params['named']['status']);
              }

              if(!empty($this->params->params['named']['category'])){
                  $condition['AND'][]['OR']=array(
                               'Category.name LIKE '=> '%'.$this->params->params['named']['category'].'%',
                               'Category.slug LIKE '=> '%'.$this->params->params['named']['category'].'%'
                               );
              }
            
              if(!empty($this->params->params['named']['cook'])){
                  $condition['AND'][]['OR']=array(
                               'UserJoin.first_name LIKE'=>'%'.$this->params->params['named']['cook'].'%',
                               'UserJoin.last_name LIKE'=>'%'.$this->params->params['named']['cook'].'%'
                               );
              }
              //pr($condition);die;
             if(!empty($this->params->params['named']['cook'])){
                $joins[]=array(
                        'table' => 'products',
                        'alias' => 'PoductJoin',
                        'type' => 'INNER',
                        'conditions' => array(
                        'PoductJoin.category_id = Category.id'
                        )
                    );
                $joins[]=array(
                        'table' => 'users',
                        'alias' => 'UserJoin',
                        'type' => 'INNER',
                        'conditions' => array(
                        'UserJoin.id = PoductJoin.user_id'
                        )
                    );
                
            }
           
            if(!empty($joins)){
            $this->Paginator->settings = array(
                'Category' => array(
                    'recursive' => 0,
                    'conditions'=>$condition,
                    'joins'=>$joins,
                    'fields'=>array('DISTINCT Category.id','Category.*'),
                ),
                
               );
           }else{

            $this->Paginator->settings = array(
                'Category' => array(
                    'recursive' => 0,
                    'conditions'=>$condition,
                 ),
                
               );
           }
       
         
        }else{
         $this->Paginator->settings = array(
            'Category' => array(
                'recursive' => 0,

            )
        );
        
       }
        
       $this->set('categories', $this->Paginator->paginate());

        $this->helpers[] = 'Tree';
        $categoriestree = $this->Category->find('all', array(
            'recursive' => -1,
            'order' => array(
                'Category.lft' => 'ASC'
            ),
            'conditions' => array(
            ),
        ));
        $this->set(compact('categoriestree'));
    
   }

////////////////////////////////////////////////////////////

    public function admin_view($id = null) {
        if (!$this->Category->exists($id)) {
            throw new NotFoundException('Invalid category');
        }
        $category = $this->Category->find('first', array(
            'contain' => array(
                'ParentCategory'
            ),
            'conditions' => array(
                'Category.id' => $id
            )
        ));
        $this->set(compact('category'));
    }

////////////////////////////////////////////////////////////

    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Category->create();
            $this->request->data['Category']['slug']=$this->Category->generateSlug(strtolower($this->request->data['Category']['name']));
           
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash('The category has been saved');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The category could not be saved. Please, try again.');
            }
        }

        $parents = $this->Category->generateTreeList(null, null, null, ' -- ');
        $this->set(compact('parents'));
    }

////////////////////////////////////////////////////////////

    public function admin_edit($id = null) {
        if (!$this->Category->exists($id)) {
            throw new NotFoundException('Invalid category');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash('The category has been saved');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The category could not be saved. Please, try again.');
            }
        } else {
            $this->request->data = $this->Category->find('first', array('conditions' => array('Category.id' => $id)));
        }

        $parents = $this->Category->generateTreeList(null, null, null, ' -- ');
        $this->set(compact('parents'));
    }

////////////////////////////////////////////////////////////

    public function admin_delete($id = null) {
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException('Invalid category');
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Category->delete()) {
            $this->Session->setFlash('Category deleted');
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Category was not deleted');
        return $this->redirect(array('action' => 'index'));
    }

////////////////////////////////////////////////////////////

}
