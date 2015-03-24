<h2>Story</h2>

<br />
<script>
function goBack() {
    window.history.back()
}
</script>
<button onclick="goBack()" class="btn btn-primary">Back</button>

<br />

<table class="table table-striped table-bordered table-condensed table-hover">
    <tr>
        <td>Id</td>
        <td><?php echo h($story['Story']['id']); ?></td>
    </tr>
    <tr>
        <td>Title</td>
        <td><?php echo h($story['Story']['title']); ?></td>
    </tr>
    <tr>
        <td>Story</td>
        <td><?php echo $story['Story']['story']; ?></td>
    </tr>
    <tr>
        <td>image</td>
        <td><?php 
         if(!empty($story['Story']['image'])){
           echo $this->Html->image('/images/story/'.$story['Story']['image'], array('alt'=>'','class' => ''));  
         }
         ?></td>
    </tr>
    <tr>
        <td>Created</td>
        <td><?php echo h($story['Story']['created']); ?></td>
    </tr>
    <tr>
        <td>Modified</td>
        <td><?php echo h($story['Story']['modified']); ?></td>
    </tr>
</table>

<br />
<br />