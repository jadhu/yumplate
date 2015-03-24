<?php
App::uses('AppModel', 'Model');
class Product extends AppModel {

////////////////////////////////////////////////////////////

    public $validate = array(
        'name' => array(
            'rule1' => array(
                'rule' => array('between', 3, 60),
                'message' => 'Name is required',
                'allowEmpty' => false,
                'required' => false,
            ),
            'rule2' => array(
                'rule' => array('isUnique'),
                'message' => 'Name already exists',
                'allowEmpty' => false,
                'required' => false,
            ),
        ),
        /*'slug' => array(
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
        ),*/
        'price' => array(
            'notempty' => array(
                'rule' => array('decimal'),
                'message' => 'Price is invalid',
                //'allowEmpty' => false,
                //'required' => true,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'weight' => array(
            'notempty' => array(
                'rule' => array('decimal'),
                'message' => 'Weight is invalid',
                //'allowEmpty' => false,
                //'required' => true,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

////////////////////////////////////////////////////////////

    public $belongsTo = array(
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ),
        'Brand' => array(
            'className' => 'Brand',
            'foreignKey' => 'brand_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ),
         'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ),
        
    );

////////////////////////////////////////////////////////////

    public $hasMany = array(
        'Productmod',
        'Review'
    );

////////////////////////////////////////////////////////////

    public function updateViews($products) {

        if(!isset($products[0])) {
            $a = $products;
            unset($products);
            $products[0] = $a;
        }

        $this->unbindModel(
            array('belongsTo' => array('Category', 'Brand'))
        );

        $productIds = Set::extract('/Product/id', $products);

        $this->updateAll(
            array(
                'Product.views' => 'Product.views + 1',
            ),
            array('Product.id' => $productIds)
        );


    }
    
    public function generateRandomString() {
        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
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
                            'Product.slug like' => $split_name.'%'
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
						'Product.slug' => $user_name
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

////////////////////////////////////////////////////////////

}