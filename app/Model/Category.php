<?php
App::uses('AppModel', 'Model');
class Category extends AppModel {

////////////////////////////////////////////////////////////

    public $validate = array(
        'name' => array(
            'rule1' => array(
                'rule' => array('notempty'),
                'message' => 'Name is invalid',
                //'allowEmpty' => false,
                //'required' => true,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'rule2' => array(
                'rule' => array('isUnique'),
                'message' => 'Name is not uniqie',
                //'allowEmpty' => false,
                //'required' => true,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'slug' => array(
            'rule1' => array(
                'rule' => array('between', 3, 50),
                'message' => 'Slug is required',
                'allowEmpty' => false,
                'required' => false,
            ),
            'rule2' => array(
                'rule' => '/^[a-z\-]{3,50}$/',
                'message' => 'Only lowercase letters and dashes, between 3-50 characters',
                'allowEmpty' => false,
                'required' => false,
            ),
            'rule3' => array(
                'rule' => array('isUnique'),
                'message' => 'Slug already exists',
                'allowEmpty' => false,
                'required' => false,
            ),
        ),
    );

////////////////////////////////////////////////////////////

    public $actsAs = array(
        'Tree'
    );

////////////////////////////////////////////////////////////

    public $belongsTo = array(
        'ParentCategory' => array(
            'className' => 'Category',
            'foreignKey' => 'parent_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

////////////////////////////////////////////////////////////

    public $hasMany = array(
        'ChildCategory' => array(
            'className' => 'Category',
            'foreignKey' => 'parent_id',
            'dependent' => false
        ),
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'category_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

////////////////////////////////////////////////////////////

    public function generateSlug($name)
        {
           if(!$name)
           {
               return false;
           }
            $split_name = str_replace(" ", "-", $name);
            $split_name = preg_replace('!\s+!', '', trim($split_name));
            //$split_name = trim($name);
            $count = $this->find('count',array(
                    'conditions' => array(
                           // 'User.username' => $split_name,
                            'Category.slug like' => $split_name.'%'
                    )
            ));
          
            if($count > 0)
            {
               
                
                return $this->check_slug_exist($split_name,$count);
            }else
            {
                return $split_name;
            }
        }
        
       public function check_slug_exist($uname,$count)
       {
            $user_name = $uname."_".$count;
                   
            $result = $this->find('count',array(
                'conditions' => array(
                        'Category.slug' => $user_name
                        )
                )
            );  
           if($result > 0)
           {
             
              return $this->check_slug_exist($uname,++$count);
           }else
           {
               return $user_name;
           }
        }

}
