
<!-- Post template -->
<!-- Post title -->
<div id="post" class="row">
<h3>
    <a href="?post_view&amp;post_id={$value['id']}"><?php echo $value['title']; ?></a>
</h3>

<!-- Show edit option only to users that are logged in and owners of the post-->
 
<?php echo (isset($_SESSION["bxtreme_user"]) && $_SESSION["bxtreme_user"] == $this->findUser($this->user_id) ?
    "<a alt=\"Edit\" href=\"?post_edit&post_id={$value['id']}\"><i class=\"step fi-page-edit size-24\"></i></a>"
    . "<a alt=\"Delete\" href=\"?post_delete&post_id={$value['id']}\"><i class=\"step fi-page-delete size-24\"></i></a>" : ''); ?>
<!-- Date posted -->                
<small>{$value['date']}</small>
<!-- Author -->
<p>Written by {$this->findUser($this->user_id)}</p>
<!-- Post content -->
<p>{$value['content']}</p>"
. "<!-- Category print :) -->"
. "<a href=\"?category={$value['category_id']}\"><i><small> {$this->category->getCategory($value['category_id'])}</small></i></a>"
</div><hr> 