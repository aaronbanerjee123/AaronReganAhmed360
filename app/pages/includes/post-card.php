<div class="col-md-6">
    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-primary"><?=$row['category']?></strong>
            <a href="<?=ROOT?>pages/post.php?slug=<?=$row['slug']?>" style="text-decoration: none; color: inherit;">
                <h3 class="mb-0"><?=$row['title']?></h3>
            </a>
            <div class="mb-1 text-muted"><?=date("Y-m-d",strtotime($row['date']))?></div>
            <!-- Truncated content -->
            <p class="card-text mb-auto" id="truncatedContent"><?=substr($row['content'],0,50)?></p>
            <!-- Read more button -->
           
            <!-- Full content (initially hidden) -->
       

            <div class="full-content" style="display: none;">
                <p><?= $row['content'] ?></p>
            </div>

            <?php if(strlen($row['content']) > 50) { ?>
                <?php if(strlen($row['content']) > 50) { ?>
                <a href="#" class="read-more" style="width:75px; display: inline-block; background-color: #007bff; color: #fff; border: none; padding: 8px 20px; text-align: center; text-decoration: none; border-radius: 4px; cursor: pointer; transition: background-color 0.3s ease;">Read more</a>
             <?php } ?>
            <?php } ?>

        <div class="col-lg-5 col-12 d-lg-block" style="max-height: 100px;">
            <img src="<?=ROOT?>pages/<?=$row['image']?>" class="bd-placeholder-img w-100" height="250" style="object-fit:cover;" />
        </div>

        </div>
       
        <!-- Edit Button -->
        <?php if($row['user_id'] == user('id')) { ?>
            <a href="<?=ROOT?>pages/edit.php?id=<?=$row['id']?>" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 mt-5" style="width:20%;">Edit</a>
        <?php } ?>
    </div>
</div>
