<?php echo $this->Html->css(array('bootstrap-editable.css', '/select2/select2.css'), 'stylesheet', array('inline' => false)); ?>
<?php echo $this->Html->script(array('bootstrap-editable.js', '/select2/select2.js'), array('inline' => false)); ?>
<h2>Meta  Settings </h2>
<script>

$(document).ready(function() {

    $('.name').editable({
        name: 'name',
        url: '<?php echo $this->webroot; ?>admin/users/meta_setting_editable',
        title: 'Setting',
        title: 'name',
        placement: 'right',
    });

    $('.keywords').editable({
        name: 'keywords',
        url: '<?php echo $this->webroot; ?>admin/users/meta_setting_editable',
        title: 'Setting',
        title: 'support_mail',
        placement: 'right',
    });

    $('.description').editable({
        name: 'description',
        url: '<?php echo $this->webroot; ?>admin/users/meta_setting_editable',
        title: 'Setting',
        title: 'description',
        placement: 'right',
    });
});
    </script>


    <br/>
     <br/>

<table class="table-bordered table">
<tr>
<th width="350px;">Meta name</th>
<th width="350px;">Meta keywords</th>
<th width="350px;">Meta description</th>
</tr>
<tr>

<td><span class="name" data-value="<?php echo $meta_settings['MetaSetting']['name']; ?>" data-pk="<?php echo $meta_settings['MetaSetting']['id']; ?>"> <?php echo $meta_settings['MetaSetting']['name']; ?></span></td><br />

<td><span class="keywords" data-value="<?php echo $meta_settings['MetaSetting']['keywords']; ?>" data-pk="<?php echo $meta_settings['MetaSetting']['id']; ?>"> <?php echo $meta_settings['MetaSetting']['keywords']; ?></span></td>

<td><span class="description" data-value="<?php echo $meta_settings['MetaSetting']['description']; ?>" data-pk="<?php echo $meta_settings['MetaSetting']['id']; ?>"> <?php echo $meta_settings['MetaSetting']['description']; ?></span></td>
</tr>
</table>


<br />

<?php //echo $this->element('pagination-counter'); ?>

<?php //echo $this->element('pagination'); ?>

<br />
<br />
