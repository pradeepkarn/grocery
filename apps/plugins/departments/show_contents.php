<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); ?>
<?php $plugin_dir = "departments"; ?>
<style>
/* .list-none li{
    font-weight: bold;
} */
.menu-col{
    min-height: 300px !important;
}
</style>
<section>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div id="sidebar-col" class="col-md-2 <?php echo sidebar_bg; ?>">
                <?php import("apps/admin/inc/sidebar.php"); ?>
            </div>
            <!-- Main Area -->
            <div id="content-col" class="col-md-10">
            <?php import("apps/admin/pages/page-nav.php"); ?>
            <!-- Main -->
            <div class="row hide">
            <div class="col-md-6">
            <form action="" method="post">
            <div class="row">
                <div class="col-md-12">
                    <h4>Add New Category</h4>
                    <input type="text" onkeyup="createSlug('page_title', 'page_slug');" id="page_title" required name="page_title" placeholder="Category Name" class="form-control mb-2">
                    <input type="hidden" placeholder="url-slug" onblur="createSlug(this.id, this.id);" id="page_slug" required  name="slug" class="form-control">
                    <input type="hidden" name="add_new_content" value="add_new_content">
                </div>
                <div class="col-md-12">
                <div>
               <h5 class="hide">Choose Parent Category</h5>
               <?php
            $catData=multilevel_categories($parent_id=0,$radio=true); ?>
            <select required class="hide form-control" name="parent_id" id="cats">
                <option value="0" selected>Parent</option>
                <?php echo display_option($nested_categories=$catData,$mark=''); ?>
            </select>
               </div> 
                    <div class="d-grid">
                        <button type="submit" class="mt-2 btn btn-primary">Save Category <i class="fas fa-save"></i></button>
                    </div>
                </div>
            </div>
                
            </form>
            </div>
        <div class="col-md-6 hide">
            <div id="res"></div>
        <form method="post" action="" id="form-cat-delete-data">
             <div style="height: 200px; overflow-y:scroll;">
        <!--=====category subcategory list=====-->
                
             <?php
             csrf_token();
            $catData=multilevel_categories($parent_id=0,true);
             //   print_r($cats);
            foreach($catData as $cat){ ?>
            <ul class="list-none">
                <li class="text-bold"><?php if ($cat['radio']==true) {?>
                   <input type="radio" name="parent_id" value="<?php echo $cat['id'];?>">
                <?php } ?>
                <a class="text-deco-none" href="/<?php echo home; ?>/admin/<?php echo $plugin_dir; ?>/edit/<?php echo $cat['id']; ?>">
                    <?php echo $cat['category_name']; ?>
                </a> 
                    
                </li>
                <?php
                    if( ! empty($cat['nested_categories'])){
                        echo display_list($cat['nested_categories']);
                    }                                  
                ?>

            </ul>
            <!--======category subcategory list=====-->
                                                        
            <?php

                }
                
            ?>
            </div>
            <button type="submit" id="delete-cat" class="btn btn-sm btn-danger"> <i class="fas fa-trash"></i> Delete</button>
            <input type="hidden" name="delete_category" value="delete_category">
        </form>
         <?php // pkAjax("#delete-cat","/admin/<?php echo $plugin_dir; ?>/delete","#form-cat-delete-data","#res"); ?>

        </div>
    </div>
        <section>
            <div class="my-4 d-flex justify-content-end">
                    <a class="btn btn-primary" href="/<?php echo home; ?>/admin/<?php echo $plugin_dir; ?>/add-new-item">Add New Department</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3>All <?php echo $plugin_dir; ?></h3>
                <table  class="table-sm table table-bordered">
                <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Manager(HOD)</th>
                    <th>Edit</th>
                    <th>Trash</th>
                </thead>
                <tbody>
            <?php 
               
                $db = new Model('content');
                $pgqry['content_group'] = "department";
                $pgqry['parent_id'] = 0;
                $prods = $db->filter_index($pgqry,$ord = "DESC",$limit = 500);
                if ($prods!=false) {
                foreach ($prods as $pk => $pv) { 
                    $sale_price = $pv['sale_price']==""?0:$pv['sale_price'];
                    $is_sale = (($pv['sale_price'])!="" && ($pv['sale_price'])>0)?true:false;
                    $net_price = $pv['price']-$sale_price;

                    $subcat = new Model('content');
                    $sbcats = $subcat->filter_index(array('parent_id'=>$pv['id'],'content_group'=>'listing_category'));
                    if ($sbcats==false) {
                        $sbcats = array();
                    }
                    $manager = getData('pk_user',$pv['hod_id'])?getData('pk_user',$pv['hod_id'])['first_name']."{$pv['hod_id']}":null;
                    ?>
                <tr>
                    <td><?php echo $pv['id']; ?></td> 
                    
                    <td><?php echo $pv['title']; ?></td> 
                    <td><?php echo $manager; ?></td> 
                   
                    <td><a href="/<?php echo home; ?>/admin/<?php echo $plugin_dir; ?>/edit/<?php echo $pv['id']; ?>">Edit</a></td>
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
                            <form action="/<?php echo home; ?>/admin/<?php echo $plugin_dir; ?>" method="post">
                                <input type="hidden" name="delete_category" value="delete_category">
                                <input type="hidden" name="parent_id_del" value="<?php echo $pv['id'] ?>">
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        <a class="hide btn btn-danger" href="/<?php echo home; ?>/admin/<?php echo $plugin_dir; ?>/delete/<?php echo $pv['id']; ?>">Delete</a>
                        </div>
                        </div>
                    </div>
                    </div>
                </tr>
            <?php } }
                ?>
                </tbody>
            </table>
                </div>
            </div>
        </section>
    <!-- main end -->
            </div>
        </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>