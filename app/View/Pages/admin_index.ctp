 <?php //echo $this->Html->script('ckeditor/ckeditor');?>
 <?php //echo $this->Html->script('kcfinder/kcfinder');?>
 <script type="text/javascript" src="http://cdn.ckeditor.com/4.4.7/standard-all/ckeditor.js"></script>
<?php 
$msg1 = $this->Session->flash();
 	if($msg1 != '') 
 		{ 
  echo $msg1;
	 } ?>

	 <?php //pr($this->request);?>
<div class="main">
 <div class="row">
 <div class="col-md-12">

  <div >
      <!-- content starts -->
	
	   <!-- tile -->
                <section class="tile transparent">
				
				 <!-- tile header -->
                  <div class="tile-header transparent">
                    <h1>Page contents</h1>
                  </div>
                  <!-- /tile header -->
				  <div class="tile-body tile color transparent-black">
				  <div class="row">
        
          <div class="col-md-12">

              <?php echo $this->Form->create('Page',array('action'=>'add_page','class'=>'form-horizontal','enctype'=>'multipart/form-data'));?>
                    
            
              <div class="form-group">	
			  
			  <div class="col-md-6">

			  	<label class="control-label" for="typeahead">Title</label>
                <div class="controls">
                    <?php $page_title=!empty($this->params->params['pass'][0])?$this->params->params['pass'][0]:''; ?>
		<select name="data[Page][page_name]" id="selectTitle" class="form-control">
			<option value="">Select</option>
			<option class="controls" value="howitworks"<?php if(@$page_title=="howitworks"){?>selected="selected"<?php } ?>>How It Works</option>
			<option class="controls" value="contact"<?php if(@$page_title=="contact"){?>selected="selected"<?php } ?>>Contact</option>
			<option class="controls" value="help"<?php if(@$page_title=="help"){?>selected="selected"<?php } ?>>FAQ</option>
			<option class="controls" value="instruction"<?php if(@$page_title=="instruction"){?>selected="selected"<?php } ?>>Become a YumCook</option>
			<option class="controls" value="term"<?php if(@$page_title=="term"){?>selected="selected"<?php } ?>>Term</option>
			<option class="controls" value="ourstory"<?php if(@$page_title=="ourstory"){?>selected="selected"<?php } ?>>Our story</option>
			<option class="controls" value="privacypolicy"<?php if(@$page_title=="privacypolicy"){?>selected="selected"<?php } ?>>Privacy Policy</option>
		
			
	      </select>
                </div>
			  </div>
			
                  
                   

			</div>

                 
          <?php if($page_title!='homePage') {?>        
                    <div class="form-group">
                      
                        <div class="col-md-12">
                        <label class="control-label" for="textarea2">Page Contents</label>
                        <div class="controls"> 
                        <?php echo $this->Form->input('id',array('type'=>'hidden','value'=>@$pageDetail['Page']['id'],'label'=>false,'div'=>false));?>
                        <?php echo $this->Form->input('page_content',array('type'=>'textarea','value'=>@$pageDetail['Page']['page_content'],'label'=> false,'div'=>false,'id'=>'page_content','class'=>'ckeditor'));?>

                        </div>
                        </div>
                    </div>
			   
			   <script type="text/javascript">
					var CustomHTML = CKEDITOR.replace('page_content',
						{
						 filebrowserBrowseUrl :'/js/kcfinder/browse.php',
						 filebrowserWindowWidth : '500',
						 filebrowserWindowHeight : '700'}
					);
					
					CKEDITOR.instances.page_content.config.allowedContent=true;
				</script>
			   <?php } ?>   
			   
          
              <div class="form-actions">
              <?php //echo $this->Form->input('Submit',array('type'=>'submit','class'=>'btn btn-primary','label'=>false,'div'=>false));?>
			  <button class="btn btn-primary crick" type="submit">Submit</button>
              
              </div>
             
            <?php echo $this->Form->end();?> 

          </div>
      
      </div> 
     
   <input type="hidden" id="page_url" value="<?php echo $this->Html->url('/',true);?>admin/pages">
      </div>
	  </section>
	  </div> 
 
          
	  </div>
	  </div>
	  </div>
	  <script>
   $(document).ready(function(){
    
//for change pages url after select page
$('#selectTitle').change(function(){
window.location.href =$('#page_url').val()+'/index/'+$(this).val();
});  
    


});
	  </script>

