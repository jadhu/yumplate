
<h2>Category</h2>

<br />
<script>
function goBack() {
    window.history.back()
}
</script>
<button onclick="goBack()" class="btn btn-primary">Back</button>
<br />
<br />
<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed table-hover">
    <tr>
        <td>Id</td>
        <td><?php echo h($category['Category']['id']); ?></td>
    </tr>
    <!--<tr>
        <td>Parent Category</td>
        <td><?php //echo $this->Html->link($category['ParentCategory']['name'], array('controller' => 'categories', 'action' => 'view', $category['ParentCategory']['id'])); ?></td>
    </tr> -->
    <tr>
        <td>Left</td>
        <td><?php echo h($category['Category']['lft']); ?></td>
    </tr>
    <tr>
        <td>Right</td>
        <td><?php echo h($category['Category']['rght']); ?></td>
    </tr>
    <tr>
        <td>Name</td>
        <td><?php echo h($category['Category']['name']); ?></td>
    </tr>
    <tr>
        <td>Slug</td>
        <td><?php echo h($category['Category']['slug']); ?></td>
    </tr>
    <tr>
        <td>Description</td>
        <td><?php echo h($category['Category']['description']); ?></td>
    </tr>
    <tr>
        <td>Created</td>
        <td><?php echo h($category['Category']['created']); ?></td>
    </tr>
    <tr>
        <td>Modified</td>
        <td><?php echo h($category['Category']['modified']); ?></td>
    </tr>
</table>
</div>

