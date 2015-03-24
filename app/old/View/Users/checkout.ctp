	<div class="bodySec">
	<div class="container">
	<div class="col-md-8 col-sm-offset-2">
	<?php 
	if(!empty($data)){?>
	<div class = "table-responsive">
		<table class="table table-bordered" cellspacing="0" cellpadding="0" width="100%" border="0" >
		<tbody>
	
		<tr>
		<td><strong><?php echo __('User name');?></strong></td>
		<td><?php echo h($data['User']['first_name'].' '.$data['User']['last_name'])?></td>
		</tr>

		<tr>
		<td><strong><?php echo __('Email');?></strong></td>
		<td><?php echo h($data['User']['email'])?></td>
		</tr>

		<tr>
		<td><strong><?php echo __('Total Price');?></strong></td>
		<td>$ <?php echo h($data['Payment']['amount'])?></td>
		</tr>


		<tr>
		<td><strong><?php echo __('Payment status');?></strong></td>
		<td><?php echo h($data['Payment']['status'])?></td>
		</tr>

		<tr>
		<td><strong><?php echo __('Payment date');?></strong></td>
		<td><?php echo h(date("jS F, Y", strtotime($data['Payment']['created'])))?></td>
		</tr>

		<tr>
		<td><strong><?php echo __('Transaction  id');?></strong></td>
		<td><?php echo h($data['Payment']['transaction_id'])?></td>
		</tr>

		</tbody>
		</table>
	</div>
	</div>
	<?php }else{

		echo 'you have not make any payment ';
		}?>

		</div>
		</div>