<h2>User</h2>

<script>
function goBack() {
    window.history.back()
}
</script>
<button onclick="goBack()" class="btn btn-primary">Back</button>
<br/>
<table class="table-striped table-bordered table-condensed table-hover table">
    <tr>
        <td>Id</td>
        <td><?php echo h($user['User']['id']); ?></td>
    </tr>
    <tr>
        <td>Role</td>
        <td><?php echo h($user['User']['role']); ?></td>
    </tr>
    <tr>
        <td>Username</td>
        <td><?php echo h($user['User']['username']); ?></td>
    </tr>
     <tr>
        <td>Last Login</td>
        <td><?php echo h($user['User']['last_login']); ?></td>
    </tr>
    <tr>
        <td>Description</td>
        <td><?php echo h(!empty($user['User']['description'])?$user['User']['description']:''); ?></td>
    </tr>
    <tr>
        <td>Password</td>
        <td><?php echo h($user['User']['password']); ?></td>
    </tr>
    <tr>
        <td>Active</td>
        <td><?php echo h($user['User']['active']); ?></td>
    </tr>
    <tr>
        <td>City</td>
        <td><?php echo h($user['User']['city']); ?></td>
    </tr>
    <tr>
        <td>Province/State</td>
        <td><?php echo h($user['User']['country']); ?></td>
    </tr>
    <tr>
        <td>Profile Image</td>
        <td><?php if(!empty($user['User']['image'])){
            echo $this->Html->image('/images/UserImg/'.$user['User']['image'],array('alt'=>''));

           } ?></td>
    </tr>
   
    <tr>
        <td>Modified</td>
        <td><?php echo h($user['User']['modified']); ?></td>
    </tr>
</table>

<br />
<br />

<h3>Actions</h3>

<br />

<?php echo $this->Html->link('Edit User', array('action' => 'edit', $user['User']['id']), array('class' => 'btn btn-default')); ?> </li>

<br />
<br />

<?php //echo $this->Form->postLink('Delete User', array('action' => 'delete', $user['User']['id']), array('class' => 'btn btn-danger'), __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>

<br />
<br />