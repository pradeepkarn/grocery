<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); ?>
<style>
.list-none li{
    font-weight: bold;
}
.menu-col{
    min-height: 300px !important;
}
</style>
<section>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div id="sidebar-col" class="col-md-2 bg-dark">
                <?php import("apps/admin/inc/sidebar.php"); ?>
            </div>
            <!-- Main Area -->
            <div id="content-col" class="col-md-10">
            <?php import("apps/admin/pages/page-nav.php"); ?>
            <div class="row">
        <div class="col-md-12">
            <form action="" method="post">
            <div class="row">
                <div class="col-md-8">
                    <input type="text" onkeyup="createSlug('page_title', 'page_slug');" id="page_title" required name="page_title" placeholder="Title" class="form-control mb-2">
                    <input type="text" placeholder="url-slug" onblur="createSlug(this.id, this.id);" id="page_slug" required  name="slug" class="form-control">
                    <input type="hidden" name="add_new_content" value="add_new_content">
                </div>
                <div class="col-md-4">
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Add New <span class="text-capt"> Item </span>  <i class="fas fa-level-down-alt"></i></button>
                    </div>
                </div>
            </div>
            </form>
            <table id="datatablesSimple" class="table-sm table table-bordered">
                <thead>
                    <th>Package ID</th>
                    <th class="text-center">Status</th>
                    <th>Thumbnail</th>
                    <th>Package Name</th>
                    <th class="text-end">Price</th>
                    <th>Category</th>
                    <th class="text-center">Package Type</th>
                    <th>View</th>
                    <th>Edit</th>
                    <th>Trash</th>
                </thead>
                <tbody>
            <?php 
               $content_group = "package";
                $db = new Model('content');
                $pgqry['content_group'] = $content_group;
                $prods = $db->filter_index($pgqry,$ord = "DESC",$limit = 500);
                if ($prods!=false) {
                foreach ($prods as $pk => $pv) { ?>
                <tr>
                    <td><?php echo $pv['id']; ?></td> 
                    <td><p class="text-center  text-capt px-1 pb-1 pk-round <?php echo ($pv['status']!="listed")?"text-dark bg-warning":"text-white bg-success"; ?>"><?php echo $pv['status']; ?></p></td> 
                    
                    <td><img style="height: 50px;" src="/<?php echo media_root; ?>/images/pages/<?php echo $pv['banner']; ?>"></td> 
                    <td><?php echo $pv['title']; ?></td> 
                    <td class="text-center"><?php echo $pv['price']; ?></td> 
                    <td><?php echo (getData("content",$pv['parent_id'])!=false)?getData("content",$pv['parent_id'])['title']:"NA"; ?></td> 
                    <td class="text-center"><span class="<?php echo ($pv['post_category']=="silver")?"p-1 bg-info text-dark":""; echo ($pv['post_category']=="gold")?"p-1 bg-warning text-dark":""; echo ($pv['post_category']=="platinum")?"p-1 bg-secondary text-white":""; ?>"><?php echo $pv['post_category']; ?></span></td> 
                    <td><a target="_blank" href='<?php echo "/".home."/item/?lid={$pv['id']}"; ?>'>View</a></td> 
                    <td><a href="/<?php echo home; ?>/admin/packages/edit/<?php echo $pv['id']; ?>">Edit</a></td>
                    <td><a data-bs-toggle="modal" data-bs-target="#deltModal<?php echo $pv['id']; ?>" href="javascript:void(0);" class="text-danger">Delete</a></td>
                    <div class="modal" id="deltModal<?php echo $pv['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel<?php echo $pv['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h3 class="bg-danger p-3 text-white">Be careful, this action can not be un done!</h3>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                        <div class="modal-footer">
                        <a class="btn btn-danger" href="/<?php echo home; ?>/admin/packages/delete/<?php echo $pv['id']; ?>">Delete</a>
                        </div>
                        </div>
                    </div>
                    </div>
                </tr>
            <?php } }
                ?>
                </tbody>
            </table>
            <a class="btn btn-success mt-2" href="/<?php echo home; ?>/admin/generate-csv/?report_obj=packages">Generate Report</a>
        </div>
    </div>
            </div>
        </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>