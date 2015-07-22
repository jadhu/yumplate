<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Page');
     

/**
 * Displays a view
 *
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function beforeFilter() {
            parent::beforeFilter();
            $this->layout='admin';
             $this->Auth->allow(array('index'));
		
	}
        
        public function admin_index() {
        $this->loadModel('Page');

                if($this->request->is('post')) {

                        if($this->Page->save($this->data['Page'])){
                        $this->Session->setFlash('Saved successfully!','default',array('class'=>'alert alert-success'));
                        $this->redirect('/pages/index');
                }else{
                        $this->Session->setFlash('Not saved!','default',array('class'=>'alert alert-danger'));
                        $this->redirect('/pages/index');
                }

                }else{
                        if(isset($this->params->params['pass'][0]) && $this->params->params['pass'][0]!=''){
                                $pageTitle = $this->params->params['pass'][0];
                                $this->set('pageDetail',$this->Page->find('first',array('conditions'=>array('Page.page_name'=>$pageTitle))));
                                $this->set('page_title',$this->params->params['pass'][0]);
                        }else{
                                $this->set('page_title','');
                        }

                }

	}
        
        /**
     * Method to add new page 
     * 
     * @param form submitted data
     * @return true on success false on faliure
     */
     
     
   
   public function admin_add_page() {
       $this->loadModel('Page'); 
       
       if($this->request->is('post')){ 
		
                if($this->Page->save($this->request->data['Page'])){
                  $this->Session->setFlash('Saved successfully!','default',array('class'=>'alert alert-success')); 
                }else{ 
                  $this->Session->setFlash('Not saved!','default',array('class'=>'alert alert-danger')); 
                }
        }
		
      $this->redirect('/admin/pages/index'); 		
  }
}
