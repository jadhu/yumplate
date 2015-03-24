<h2>Orders</h2>

<div class="table-responsive tables-order">
    <table class="table  table-bordered ">
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
        <th><?php echo $this->Paginator->sort('weight'); ?></th-->
        <th><?php echo $this->Paginator->sort('subtotal','Hst'); ?></t>
        <!--th><?php echo $this->Paginator->sort('tax'); ?></th>
        <th><?php echo $this->Paginator->sort('shipping'); ?></th-->
        <th><?php echo $this->Paginator->sort('discount'); ?>
        <th><?php echo $this->Paginator->sort('total'); ?></th>
        <th><?php echo $this->Paginator->sort('status'); ?></th>
        <th><?php echo $this->Paginator->sort('order_status'); ?></th>
        <th><?php echo $this->Paginator->sort('created','Order Date'); ?></th>
        <th>Actions</th>
    </tr>
    <?php if(!empty($orders)){foreach ($orders as $order): ?>
    <tr>
        <td><?php echo h($order['Order']['first_name']); ?></td>
        <!--td><?php echo h($order['Order']['last_name']); ?></td-->
        <td><?php echo h($order['OrderInfo']['email']); ?></td>
        <td><?php echo h($order['OrderInfo']['phone']); ?></td>
        <td><?php echo  h($order['Order']['billing_city']).' '.h($order['Order']['billing_state']).' '.h($order['Order']['billing_country']).' '.h($order['Order']['billing_zip']); ?></td>
        <!--td><?php echo h($order['Order']['billing_zip']); ?></td>
        <td><?php echo h($order['Order']['billing_state']); ?></td>
        <td><?php echo h($order['Order']['billing_country']); ?></td-->
        <td><?php echo h($order['Order']['shipping_city']).' '.h($order['Order']['shipping_state']).' '.h($order['Order']['shipping_country']).' '.h($order['Order']['shipping_zip']); ?></td>
        <!--td><?php echo h($order['Order']['shipping_zip']); ?></td>
        <td><?php echo h($order['Order']['shipping_state']); ?></td>
        <td><?php echo h($order['Order']['shipping_country']); ?></td>
        <td><?php echo h($order['Order']['weight']); ?></td-->
        <td><?php echo '$'.h($order['Order']['subtotal']); ?></td>
        <!--td><?php echo h($order['Order']['tax']); ?></td>
        <td><?php echo h($order['Order']['shipping']); ?></td-->
         <td>
         <?php 
        if(!empty($order['Order']['discount'])){
            echo '$'.$order['Order']['discount'];
         }else{
            echo '';
         }
         ?></td>
        <td><?php echo '$'.h($order['Order']['total']); ?></td>
        <td><?php echo h($order['Order']['authorization']); ?></td>

        <td><?php  if($order['Order']['order_status']==1){echo "Delivered"; $od_status=0;}else{echo "Not delivered";$od_status=1;}; ?></td>

        <td><?php echo h($order['Order']['created']); ?></td>
        <td class="actions">
            <?php echo $this->Html->link('View', array('action' => 'view', $order['Order']['id']), array('class' => 'btn btn-default btn-xs')); ?>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $order['Order']['id']), array('class' => 'btn btn-default btn-xs')); ?>
            <?php echo $this->Html->link('Change order status', array('action' => 'change_order_status/'.$order['Order']['id'].'/'.$od_status), array('class' => 'btn btn-default btn-xs')); ?>
            <?php echo $this->Form->postLink('Delete', array('action' => 'delete', $order['Order']['id']), array('class' => 'btn btn-default btn-danger btn-xs'), __('Are you sure you want to delete # %s?', $order['Order']['id'])); ?>

        </td>
    </tr>
    <?php endforeach; }else{echo "<tr><td colspan=12>There is no order</td></tr>";}?>
</table>
</div>

<br />

<?php //echo $this->element('pagination-counter'); ?>

<?php echo $this->element('pagination'); ?>

<br />
<br />
