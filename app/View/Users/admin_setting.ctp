<?php echo $this->Html->css(array('bootstrap-editable.css', '/select2/select2.css'), 'stylesheet', array('inline' => false)); ?>
<?php echo $this->Html->script(array('bootstrap-editable.js', '/select2/select2.js'), array('inline' => false)); ?>
<h2>Admin  Settings </h2>
<script>

$(document).ready(function() {

    $('.hst').editable({
       name: 'hst',
        url: '<?php echo $this->webroot; ?>admin/users/setting_editable',
        title: 'Setting',
        title: 'hst',
        placement: 'right',
    });
});
    </script>


    <br/>
     <br/>

<table class="table-bordered table">
<td>Recipe HST %</td>
<td><span class="hst" data-value="<?php echo $setting['Setting']['hst']; ?>" data-pk="<?php echo $setting['Setting']['id']; ?>"> <?php echo $setting['Setting']['hst']; ?></span></td>
</table>

<h2>Discount Setting</h2>
<div class="table-responsive tables-user">
<a href="<?php echo $this->Html->url('/admin/users/add_coupon',true);?>" class="btn btn-primary">Add Discount</a>
<br/>
<table class="table  table-bordered">
    <tr>

        <th> S.N.<?php //echo $this->Paginator->sort('role');?></th>
        <th> Name <?php //echo $this->Paginator->sort('first_name','Name');?></th>
        <th>Discount(%)<?php //echo $this->Paginator->sort('email');?></th>
        <th>Start Date<?php //echo $this->Paginator->sort('email');?></th>
        <th>Expiry date<?php //echo $this->Paginator->sort('email');?></th>
        <th>Status<?php //echo $this->Paginator->sort('email');?></th>
        <th>Created<?php //echo $this->Paginator->sort('created');?></th>
        <th>Modified<?php //echo $this->Paginator->sort('modified');?></th>
        <th class="actions">Actions</th>
    </tr>
    <?php if(!empty($coupons)){$i=1;foreach ($coupons as $coupon){ ?>
    <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo h($coupon['Coupon']['name']); ?></td>
        <td><?php echo h($coupon['Coupon']['discount']); ?></td>
        <td><?php echo h($coupon['Coupon']['start_date']); ?></td>
        <td>
        <?php 
         if($coupon['Coupon']['active']==1){ $active=0; echo 'Active';}else{$active=1; echo 'Nonactive';}?>
        </td>
        <td><?php echo h($coupon['Coupon']['end_date']); ?></td>
       
        <td> <?php echo h($coupon['Coupon']['created']); ?></td>
        <td><?php echo h($coupon['Coupon']['modified']); ?></td>
        <td class="actions">
            <?php echo $this->Html->link('Change Status', array('action' => 'change_coupon_status/'.$coupon['Coupon']['id'].'/'.$active), array('class' => 'btn btn-default btn-xs')); ?>
            <?php echo $this->Html->link('Edit', array('action' => 'add_coupon', $coupon['Coupon']['id']), array('class' => 'btn btn-default btn-xs')); ?>
            <?php echo $this->Form->postLink('Delete', array('action' => 'coupon_delete', $coupon['Coupon']['id']), array('class' => 'btn btn-danger btn-xs'), __('Are you sure you want to delete  %s?', $coupon['Coupon']['name'])); ?>
        </td>
    </tr>
    <?php $i++;}}else{echo '<tr><td colspan=8>No coupons added</td></tr>';} ?>
</table>
</div>
<br />

<?php //echo $this->element('pagination-counter'); ?>

<?php //echo $this->element('pagination'); ?>

<br />
<br />
