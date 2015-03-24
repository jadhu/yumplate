<?php
$this->Html->addCrumb('Categories', '/categories/');
foreach ($parents as $parent) {
    $this->Html->addCrumb($parent['Category']['name'], '/category/' . $parent['Category']['slug']);
}
?>


<br />
<script>
function goBack() {
    window.history.back()
}
</script>
<button onclick="goBack()" class="btn btn-primary">Back</button>
<br />
<br />
<h2><?php echo $category['Category']['name']; ?><small> Category</small></h2>

<?php if (!empty($products)): ?>

<?php echo $this->element('products'); ?>

<?php endif; ?>