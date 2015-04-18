<h2>Reviews</h2>
<br/>
<br/>

<table class="table-bordered table">
<tr>
<th >S.N</th>
<th >Review</th>
<th >Actions</th>
</tr>
<?php $i=1; foreach ($reviews as $key => $value) { ?>
<tr>

<td><?php echo $i; ?></td>

<td> <?php echo $value['Review']['comments']; ?></td>

<td><?php echo $this->Form->postLink('Delete', array('action' => 'review_delete', $value['Review']['id']), array('class' => 'btn btn-danger btn-xs'), __('Are you sure you want to delete  %s?', $value['Review']['id'])); ?></td>
</tr>
<?php $i++;} ?>
</table>


<br />

<?php //echo $this->element('pagination-counter'); ?>

<?php echo $this->element('pagination'); ?>

<br />
<br />
