<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP StoriesController
 * @author desktop-13
 */
class StoriesController extends AppController {
    public $components = array('Paginator');
    
      public function beforeFilter() {
        parent::beforeFilter();
        $this->layout='admin';
        $this->Auth->allow(array('ExploreYum','RedirectUrl','view','admin_makestatus'));

        $this->loadModel('MetaSetting');
        $meta_settings=$this->MetaSetting->find('first');
        $this->set(compact('meta_settings'));
    }

    public function admin_stories() {
    
      if($this->request->is('post')){
           $this->redirect(array('controller'=>'stories','action'=>'admin_index','active'=>isset($this->request->data['Story']['active'])?$this->request->data['Story']['active']:''));
      }

    }


    public function admin_index() {
         $this->loadModel('Story');
         //pr($this->params->params);
         if(!empty($this->params->params['named']['active'])){
          $this->Paginator->settings = array(
            'recursive' => -1,
            'conditions'=>array('Story.active'=>$this->params->params['named']['active']),
            'order' => array(
                'Story.name' => 'ASC'
            ),
            'limit' => 30,
        );
         }else{
         $this->Paginator->settings = array(
            'recursive' => -1,
            'order' => array(
                'Story.name' => 'ASC'
            ),
            'limit' => 30,
        );
       }
        $this->set('stories', $this->Paginator->paginate('Story'));
        
        
    }
    
    public function view() {
        $this->layout='front';
        $this->loadModel('Story');
         $this->Paginator->settings = array(
            'recursive' => -1,
            'conditions'=>array('Story.active'=>1),
            'order' => array(
                'Story.name' => 'ASC'
            ),
            'limit' => 30,
        );

        $this->set('stories', $this->Paginator->paginate('Story'));
        
        
    }
      public function admin_add_story($id=null) {
          $this->loadModel('Story');
          if ($this->request->is('post')||$this->request->is('put')) {
              $uploadImgDir=WWW_ROOT.'images/story';
              
              if(!is_dir($uploadImgDir)){
                  mkdir($uploadImgDir,0777,true);
              }
             //pr($this->request->data);die;
              if(!empty($this->request->data['Story']['image']['name'])){
                
                   $dst =time().'_'.$this->request->data['Story']['image']['name'];
                  if(file_exists($uploadImgDir.'/'.$this->request->data['Story']['image_name'])){
                          @unlink($uploadImgDir.'/'.$this->request->data['Story']['image_name']);
                        }
                        
                move_uploaded_file($this->request->data['Story']['image']['tmp_name'], $uploadImgDir.'/'.$dst);
                  $this->request->data['Story']['image']=$dst;
              }else{
                  $this->request->data['Story']['image']=$this->request->data['Story']['image_name'];
              }
           // 
              if ($this->Story->save($this->request->data)) {
                $this->Session->setFlash('The story has been saved.');
                //return $this->redirect($this->referer());
                 return $this->redirect(array('controller'=>'stories','action' => 'index','admin'=>true));
            } else {
                return $this->redirect(array('controller'=>'stories','action' => 'index','admin'=>true));
                $this->Session->setFlash('The story could not be saved. Please, try again.');
            }
        
           
        }
        if($id){
            $story=$this->Story->find('first',array('conditions'=>array('Story.id'=>$id)));
            $this->request->data['Story']['id']=$story['Story']['id'];
            $this->request->data['Story']['title']=$story['Story']['title'];
            $this->request->data['Story']['story']=$story['Story']['story'];
            $this->request->data['Story']['active']=$story['Story']['active'];
            $this->request->data['Story']['featured']=$story['Story']['featured'];
            $this->request->data['Story']['image_name']=$story['Story']['image'];
            
            
            //$this->set(compact('story'));
        }
    }
    
    
    
     public function admin_view($id = null) {
         $this->loadModel('Story');
         
        if (!$this->Story->exists($id)) {
            throw new NotFoundException('Invalid story');
        }
        $options = array('conditions' => array('Story.id' => $id));
        $this->set('story', $this->Story->find('first', $options));
    }
  
    
     public function admin_delete($id = null) {
            $this->loadModel('Story');
            $uploadImgDir=WWW_ROOT.'images/story/';
            $this->Story->id = $id;
            if (!$this->Story->exists()) {
                throw new NotFoundException('Invalid story');
            }
            $this->request->onlyAllow('post', 'delete');
                 $options = array('conditions' => array('Story.id' => $id));
                 $story= $this->Story->find('first', $options);
                 if(file_exists($uploadImgDir.$story['Story']['image'])){
                     unlink($uploadImgDir.$story['Story']['image']);
                 }
            if ($this->Story->delete()) {
                
                $this->Session->setFlash('The story has been deleted.');
            } else {
                $this->Session->setFlash('The tag could not be deleted. Please, try again.');
            }
            return $this->redirect(array('controller'=>'stories','action' => 'index','admin'=>true));
    }


    //function for send mail to admin
    
    public function admin_makestatus() {
         $this->autoRender=false;
         $this->loadModel('Story');
          $data=array();
         //pr($this->params->params['pass']);die;
         if($this->request->is('post')){
          $this->Story->id=$this->params->params['pass'][0];
          $data['active']=$this->params->params['pass'][1];
          $this->Story->save($data);
          $this->Session->setFlash('Successfully updated story status','default',array('class'=>'alert alert-success'));

         }else{
          $this->Session->setFlash('The story could not be updated. Please, try again.','default',array('class'=>'alert alert-danger'));
         }
        return $this->redirect(array('controller'=>'stories','action' => 'index','admin'=>true));
    }
}
