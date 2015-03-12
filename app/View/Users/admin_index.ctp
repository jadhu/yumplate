<h2>Users</h2>
<div class="table-responsive tables-user">
<table class="table  table-bordered">
    <tr>

        <th><?php echo $this->Paginator->sort('role');?></th>
        <th><?php echo $this->Paginator->sort('first_name','Name');?></th>
        <th><?php echo $this->Paginator->sort('email');?></th>
        <th><?php echo $this->Paginator->sort('active');?></th>
        <!--th><?php echo $this->Paginator->sort('city');?></th-->
        <th><?php echo $this->Paginator->sort('country','Province/ State');?></th>
        <th><?php echo $this->Paginator->sort('social_login','Login Type');?></th>
        <th><?php echo $this->Paginator->sort('last_login');?></th>
        <th><?php echo $this->Paginator->sort('created');?></th>
        <th><?php echo $this->Paginator->sort('modified');?></th>
        <th class="actions">Actions</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo h($user['User']['role']); ?></td>
        <td><?php echo h($user['User']['first_name']); ?></td>
        <td><?php echo h($user['User']['email']); ?></td>
        <td><?php echo ($user['User']['active']==1)?'Active':'Nonactive'; ?></td>
        <!--td><?php echo h($user['User']['city']); ?></td-->
        <td><?php echo h($user['User']['country']); ?></td>
        <td><?php echo ($user['User']['social_login']==1)?'Social login':'Site login'; ?>
        </td>
         <td><?php echo h($user['User']['last_login']); ?></td>
        <td>
        <?php 
       //$dt = new DateTime(strtotime($user['User']['created']));
        //$dt->setTimeZone(new DateTimeZone('EST'));
        //echo $dt->format('Y-m-d H:i:s');          

        echo h($user['User']['created']); ?></td>
        <td><?php echo h($user['User']['modified']); ?></td>
        <td class="actions">
            <?php echo $this->Html->link('View', array('action' => 'view', $user['User']['id']), array('class' => 'btn btn-default btn-xs')); ?>
            <?php echo $this->Html->link('Change Password', array('action' => 'password', $user['User']['id']), array('class' => 'btn btn-default btn-xs')); ?>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $user['User']['id']), array('class' => 'btn btn-default btn-xs')); ?>
            <?php echo $this->Form->postLink('Delete User', array('action' => 'delete', $user['User']['id']), array('class' => 'btn btn-danger btn-xs'), __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</div>
<br />

<?php echo $this->element('pagination-counter'); ?>

<?php echo $this->element('pagination'); ?>

<br />
<br />
