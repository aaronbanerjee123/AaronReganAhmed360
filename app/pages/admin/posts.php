<?php 
 $section = $_GET['section'] ?? 'dashboard';

 $action = $_GET['action'] ?? 'view';//add

 $id = $_GET['id'] ?? '0';
?>

<?php if($action == 'add'):?>
          <div class="col-md-6 mx-auto">
          <form method="post" enctype="multipart/form-data">
          
        
          <h1 class="h3 mb-3 fw-normal text-center">Create Post</h1>

        <?php if(!empty($errors)){ ?>
          <div class="alert alert-danger">
            Please fix the errors below
          </div>
        <?php  }?>

          <div class="my-2 text-center">
                Featured Image: <br>
                  <label class="d-block">
                    <img class="mx-auto d-block image-preview-edit" src="<?=get_image($row['image'])?>" style="cursor:pointer;width:150px;height:150px;object-fit:cover; border: 5px solid lightgray; border-radius: 10px;">
                  </div>
                  <input onchange="display_image_edit(this.files[0])" type="file" name="image" class=" m-4">
                 </label>

             
                
                  <script>
                      function display_image_edit(file){
                        document.querySelector(".image-preview-edit").src=URL.createObjectURL(file); 
                      }

                  </script>
            </div>

            <div class="form-floating">
                    <input value="<?php echo old_value('title')?>" name="title" type="text" class="form-control mb-2" id="floatingInput" placeholder="title">
                    <label for="floatingInput">title</label>
                  </div>

                  <?php if(!empty($errors['title'])){ ?>
                    <div class="text-danger">
                        <?php echo $errors['title'];?>
                    </div>
                    <?php }?>
        


                  <div>
                    <textarea rows="4" name="content" value="<?=old_value('content')?>" id="floatingInput" placeholder="content" style="width:100%;" class="form-control mb-2"></textarea>
                  </div>

                  <?php if(!empty($errors['content'])){ ?>
                    <div class="text-danger">
                        <?php echo $errors['content'];?>
                    </div>
                    <?php }?>

                    

                  <?php
                    $query = "select * from categories order by id desc";
                    $categories = query($query);


                  ?>

                  <div class="form-floating my-3">
                    <select name="category_id" class="form-select">                    
                    <?php if(!empty($categories)):?>
                        <?php foreach($categories as $category) :?>
                            <option value="<?=old_value('category_id', $category['id'])?>"><?=$category["category"]?></option>
                            <?php endforeach;?>
                        <?php endif;?>
                        </select>
                        <label for="form-floating">Category</label>
                      </div>

    

                  
                  <button class="mt-4 w-30 btn btn-lg btn-success float-end" type="submit">Save</button>
                  <a href = "<?=ROOT?>/admin/posts/"><button class="mt-4 w-30 btn btn-lg btn-dark " type="button">back</button>
              </a>
                  </form>
        </div>


<?php elseif($action == 'edit'):?>

                  <div class="col-md-6 mx-auto">
                  <form method="post" enctype="multipart/form-data my-4">
                  
                
                  <h1 class="h3 mb-3 fw-normal text-center my-4">Edit Post</h1>

              <?php if(!empty($row)):?>

                <?php if(!empty($errors)){ ?>
                  <div class="alert alert-danger">
                    Please fix the errors below
                  </div>
                <?php  }?>
                    

                <div class="my-2">
                  <label class="d-block">
                    <img class="mx-auto d-block image-preview-edit" src="<?=get_image($row['image'])?>" style="cursor:pointer;width:150px;height:150px;object-fit:cover; border: 5px solid lightgray; border-radius: 10px;">
                    <input type="file" name="image" onchange="display_image_edit(this.files[0])" class= "my-4">
                  </label>
                
                  <script>
                      function display_image_edit(file){
                        document.querySelector(".image-preview-edit").src=URL.createObjectURL(file); 
                      }
                  </script>
                </div>

                  <div class="form-floating">
                    <input value="<?php echo old_value('title',$row['title'])?>" name="title" type="text" class="form-control mb-2" id="floatingInput" placeholder="title">
                    <label for="floatingInput">title</label>
                  </div>

                  <?php if(!empty($errors['title'])){ ?>
                    <div class="text-danger">
                        <?php echo $errors['title'];?>
                    </div>
                    <?php }?>
        


                  <div class="form-floating">
                    <input value="<?php echo old_value('content',$row['content'])?>" name="content" type="content" class="form-control" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">content</label>
                  </div>


                  <?php if(!empty($errors['content'])){ ?>
                    <div class="text-danger">
                        <?php echo $errors['content'];?>
                    </div>
                    <?php }?>

                           

                  <?php
                    $query = "select * from categories order by id desc";
                    $categories = query($query);


                  ?>
                    

                    <div class="form-floating my-3">
                    <select name="category_id" class="form-select">


                    <?php if(!empty($categories)):?>
                        <?php foreach($categories as $category) :?>
                            <option value="<?=old_value('category_id', $category['id'])?>"><?=$category["category"]?></option>
                            <?php endforeach;?>
                        <?php endif;?>
                        </select>
                        <label for="form-floating">Category</label>
                      </div>


                  
                  <button class="mt-4 w-30 btn btn-lg btn-success float-end" type="submit">Save</button>
                  <a href = "<?=ROOT?>/admin/posts/"><button class="mt-4 w-30 btn btn-lg btn-dark" type="button">back</button>
              </a>

              <?php endif;?>
              </form>
              </div>


<?php elseif($action == 'delete'):?>
              <div class="col-md-6 mx-auto">
              <form method="post">
              
            
              <h1 class="h3 mb-3 fw-normal text-center my-4">Delete Post</h1>

          <?php if(!empty($row)):?>

            <?php if(!empty($errors)){ ?>
              <div class="alert alert-danger">
                Please fix the errors below
              </div>
            <?php  }?>

            <div class="form-floating">
                <div class="form-control mx-auto mb-2 text-center" style="max-width: 200px;"> <!-- Adjust the max-width as needed -->
                    <?=old_value('title',$row['title'])?>
                </div>
            </div>

              
              </div>

              <?php if(!empty($errors['title'])){ ?>
                <div class="text-danger">
                    <?php echo $errors['title'];?>
                </div>
                <?php }?>



              <!-- <div class="form-floating">
                <div class="form-control mb-2">
                <?=old_value('slug',$row['slug'])?>
              </div>
            </div> -->

              <?php if(!empty($errors['slug'])){ ?>
                <div class="text-danger">
                    <?php echo $errors['slug'];?>
                </div>
                <?php }?>


              
                <div class="mt-4 text-center">
                    <a href="<?=ROOT?>/admin/posts/">
                        <button class="btn btn-lg btn-dark me-2" type="button">Back</button>
                    </a> <!-- Added margin to the right -->
                    <button class="btn btn-lg btn-danger" type="submit" value="delete" name="deleteBtn">Delete</button>
                </div>



          </form>
          <?php endif;?>
      </div>


<?php else:?>


<h1>Posts page
<button class="btn btn-success"><a class="text-white" href="<?=ROOT?>pages/admin.php?section=posts&action=add">Add New</a></button>
</h1>


<div class="table-responsive">
<table class="table">
    <tr>
        <th>#</th>
        <th>Title</th>
        <th>Slug</th>
        <th>Image</th>
        <th>Date</th>
        <th>Action</th>
    </tr>


    <?php 
       
        // $limit = 10;  
        // $offset = ($PAGE['page_number'] - 1)*$limit;

        $query = "select * from posts order by id desc";
        $rows = query($query); //confused how we have access to query here
    ?>

    <?php if(!empty($rows)) { ?>
        <?php foreach($rows as $row){ ?>
    <tr>
        <td><?=$row['id']?></td>
        <td><?=esc($row['title'])?></td>
        <td><?=$row['slug']?></td>

        <td>
  
          <img src="<?=ROOT?>pages/<?=$row['image']?>" style="width:100px;height:100px;object-fit:cover;">
        </td>

        <td><?=$row['date']?></td>
     
        <td><a class="text-white" href="<?=ROOT?>pages/admin.php?section=posts&action=edit&id=<?=$row['id']?>"><button class="btn btn-warning text-white btn-sm">Edit</i></button></a></td>
        
<!--            
        <a class="text-white" href="<?=ROOT?>/admin/posts/edit/<?=$row['id']?>">Add New</a>
        <td><button class="btn btn-danger text-white btn-sm"><i class="bi bi-trash-fill"></i></button></td>
     -->
    
        <td><a class="text-white" href="<?=ROOT?>pages/admin.php?section=posts&action=delete&id=<?=$row['id']?>"><button class="btn btn-danger text-white btn-sm">Delete</i></button></a></td>

    
    </tr>

        <?php } ?>
    <?php } ?>
</table>



</div>

<?php endif;?>

