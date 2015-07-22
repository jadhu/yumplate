<br />


<h2>Orders</h2>
<div class="table-responsive tables-order">
<table class="table-bordered table ">
    <tr>
        <th><?php echo $this->Paginator->sort('first_name','Name'); ?></th>
        <!--th><?php echo $this->Paginator->sort('last_name'); ?></th-->
        <th><?php echo $this->Paginator->sort('email'); ?></th>
        <th><?php echo $this->Paginator->sort('phone'); ?></th>
        <th> Billing Address<?php //echo $this->Paginator->sort('billing_city'); ?></th>
        <!--th><?php echo $this->Paginator->sort('billing_zip'); ?></th>
        <th><?php echo $this->Paginator->sort('billing_state'); ?></th>
        <th><?php echo $this->Paginator->sort('billing_country'); ?></th-->
        <th>Shipping Address<?php //echo $this->Paginator->sort('shipping_city'); ?></th>
        <!--th><?php echo $this->Paginator->sort('shipping_zip'); ?></th>
        <th><?php echo $this->Paginator->sort('shipping_state'); ?></th>
        <th><?php echo $this->Paginator->sort('shipping_country'); ?></th>
        <th><?php echo $this->Paginator->sort('weight'); ?></th>
       
        <th><?php echo $this->Paginator->sort('tax'); ?></th>
        <th><?php echo $this->Paginator->sort('shipping'); ?></th-->
         <th><?php echo $this->Paginator->sort('subtotal','Hst'); ?></th>
        <th><?php echo $this->Paginator->sort('discount'); ?>
        <th><?php echo $this->Paginator->sort('total'); ?></th>
        <th><?php echo $this->Paginator->sort('status'); ?></th>
        <th><?php echo $this->Paginator->sort('order_status'); ?></th>
        <th><?php echo $this->Paginator->sort('created','Order Date'); ?></th>
        <th>Action</th>
       
    </tr>
    <?php  if(!empty($orders)){foreach ($orders as $order): ?>
    <tr>
        <td><?php echo h($order['Order']['first_name']); ?></td>
        <!--td><?php echo h($order['Order']['last_name']); ?></td-->
        <td><?php echo h($order['Order']['email']); ?></td>
        <td><?php echo h($order['Order']['phone']); ?></td>
        <td><?php echo h($order['Order']['billing_city']).' '.h($order['Order']['billing_state']).' '.h($order['Order']['billing_country']).' '.h($order['Order']['billing_zip']); ?></td>
        <!--td><?php echo h($order['Order']['billing_zip']); ?></td>
        <td><?php echo h($order['Order']['billing_state']); ?></td>
        <td><?php echo h($order['Order']['billing_country']); ?></td-->
        <td><?php echo h($order['Order']['shipping_city']).' '.h($order['Order']['shipping_state']).' '.h($order['Order']['shipping_country']).' '.h($order['Order']['shipping_zip']); ?></td>
        <!--td><?php echo h($order['Order']['shipping_zip']); ?></td>
        <td><?php echo h($order['Order']['shipping_state']); ?></td>
        <td><?php echo h($order['Order']['shipping_country']); ?></td>
        <td><?php echo h($order['Order']['weight']); ?></td>
       
        <td><?php echo h($order['Order']['tax']); ?></td>
        <td><?php echo h($order['Order']['shipping']); ?></td-->
         <td><?php echo h($order['Order']['subtotal']); ?></td>
         <td>
         <?php 
         if(!empty($order['Order']['discount'])){
            echo '$'.$order['Order']['discount'];
         }else{
            echo 0;
         }
       
         ?></td>
        <td><?php echo h($order['Order']['total']); ?></td>
        <td><?php echo h($order['Order']['authorization']); ?></td>
        <td><?php  if($order['Order']['order_status']==1){echo "Delivered"; $od_status=0;}else{echo "Not delivered";$od_status=1;}; ?></td>
        <td><?php echo h($order['Order']['created']); ?></td>
        <td class="actions">
            <?php echo $this->Html->link('View', array('action' => 'order_view', $order['Order']['id']), array('class' => 'btn btn-default btn-xs')); ?>
            <?php //echo $this->Html->link('Edit', array('action' => 'edit', $order['Order']['id']), array('class' => 'btn btn-default btn-xs')); ?>
        </td>
    </tr>
    <?php endforeach; }?>
</table>
</div>
<?php if(empty($orders)) {?>
<p class="yum-meals">Our YumPlate chefs are anxiously waiting for you to try their food. Don't be shy, it only takes 3 easy steps to enjoy lovely homemade meals!</p>
<?php } ?>
<br />

<?php //echo $this->element('pagination-counter'); ?>

<?php echo $this->element('pagination'); ?>

<br />
<br />



<br />
<br />
<br />
<br />