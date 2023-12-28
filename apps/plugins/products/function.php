<?php 

function upload_base64($base64string='',$uploadpath = RPATH.'/media/images/pages/',$name="bnr") {
    $uploadpath   = $uploadpath;
    $parts        = explode(";base64,", $base64string);
    $imageparts   = explode("image/", @$parts[0]);
    $imagetype    = $imageparts[1];
    $imagebase64  = base64_decode($parts[1]);
    $file         = $uploadpath . $name . '.png';
    file_put_contents($file, $imagebase64);
    return $name.".png";
}
function uploadBanner($banner_name)
{
    if (isset($_FILES['banner']) && isset($_POST['update_banner'])) {
        $file = $_FILES['banner'];
        $media_folder = "images/pages";
        $imgname = $banner_name;
        $media = new Media();
        $page = new Dbobjects();
        $page->tableName = 'content';
        $page->pk($_POST['update_banner_page_id']);
        $file_ext = explode(".",$file["name"]);
        $ext = end($file_ext);
        $page->insertData['banner'] = $imgname.".".$ext;
        $page->update();
        $media->upload_media($file,$media_folder,$imgname,$file['type']);
    }
}

function updatePage()
{
    if (isset($_POST['page_id']) && isset($_POST['update_page'])) {
        $db = new Dbobjects();
        $db->tableName = "content";
        $cat = $db->pk($_POST['page_id']);
        $db->insertData['title'] = $_POST['page_title'];
        $db->insertData['content'] = $_POST['page_content'];
        if (isset($_POST['parent_id'])) {
            $db->insertData['parent_id'] = $_POST['parent_id'];
        }
        if (isset($_POST['page_content_category'])) {
            $db->insertData['category'] = sanitize_remove_tags($_POST['page_content_category']);
        }
        $db->insertData['status'] = $_POST['page_status'];
        $db->insertData['content_type'] = $_POST['page_content_type'];
        
        $db->insertData['banner'] = $_POST['page_banner'];
        $db->insertData['post_category'] = $_POST['post_category'];
        // if (isset($_POST['price'])) {
        //     $db->insertData['price'] = sanitize_remove_tags($_POST['price']);
        // }
        if (isset($_POST['price_bulk_qty']) && isset($_POST['bulk_qty']) && isset($_POST['discount_amt'])) {
            $blk_price = sanitize_remove_tags($_POST['price_bulk_qty']);
            $blk_qty = sanitize_remove_tags($_POST['bulk_qty']);
            $blk_dic = sanitize_remove_tags($_POST['discount_amt']);
            $price = $blk_price/$blk_qty;
            $dic = $blk_dic/$blk_qty;
            $db->insertData['price'] = $price;
            $db->insertData['bulk_qty'] = sanitize_remove_tags($_POST['bulk_qty']);
            $db->insertData['discount_amt'] = $dic;
        }else{
            $db->insertData['price'] = 1;
            $db->insertData['bulk_qty'] = 1;
            $db->insertData['discount_amt'] = 0;
        }
        // if (isset($_POST['discount_amt'])) {
        //     $db->insertData['discount_amt'] = sanitize_remove_tags($_POST['discount_amt']);
        // }
        if (isset($_POST['qty'])) {
            $db->insertData['qty'] = sanitize_remove_tags($_POST['qty']);
        }
        // if (isset($_POST['bulk_qty'])) {
        //     $db->insertData['bulk_qty'] = sanitize_remove_tags($_POST['bulk_qty']);
        //     if ($_POST['bulk_qty']==0 || $_POST['bulk_qty']==null) {
        //         $db->insertData['bulk_qty'] = 1;
        //     }
        // }else{
        //     $db->insertData['bulk_qty'] = 1;
        // }
        if (isset($_POST['brand'])) {
            $db->insertData['brand'] = sanitize_remove_tags($_POST['brand']);
        }
        if (isset($_POST['tax'])) {
            $db->insertData['tax'] = sanitize_remove_tags($_POST['tax']);
        }
        if (isset($_POST['color'])) {
            $color = sanitize_remove_tags($_POST['color']);
            $db->insertData['color'] =  $color;
            if ($color!="") {
                updateColorList($id=$cat['id'], $color=sanitize_remove_tags($_POST['color']));
            }
        }
        if (isset($_POST['related_product_id'])) {
            $db->insertData['json_obj'] = json_encode(array('related_products'=>$_POST['related_product_id']));
        }else{
            $db->insertData['json_obj'] = json_encode(array('related_products'=>array()));
        }
        if (isset($_POST['grouped_content'])) {
            $db->insertData['grouped_content'] = $_POST['grouped_content'];
        }
        // $db->insertData['content_info'] = $_POST['page_content_info'];
        $db->insertData['update_date'] = date("Y-m-d h:i:sa", time());
        $author = new Mydb('pk_user');
        // $auth_user = $author->pkData($_SESSION['user_id'])['id'];
        // $db->insertData['created_by'] = $auth_user;
        $db->insertData['author'] = $_POST['page_author'];;
        if (isset($_POST['page_show_title']) && $_POST['page_show_title']==="on") {
            $db->insertData['show_title'] = 1;
        }
        else{
            $db->insertData['show_title'] = 0;
        }
        if (check_slug_globally($_POST['slug'])==0) {
            $db->insertData['slug'] = $_POST['slug'];
        }
        if(isset($_POST['banner_base64']) && $_POST['banner_base64']!=""){
            $name = uniqid('banner_').time();
            $imgname = upload_base64($_POST['banner_base64'],RPATH.'/media/images/pages/',$name);
            $oldpath = RPATH.'/media/images/pages/'.$cat['banner'];
            if ($cat['banner']!="" && file_exists($oldpath)) {
                unlink($oldpath);
            }
            $db->insertData['banner'] = $imgname;
        }
        return $db->updateTransaction();
    }
}
function addContent($type="product")
{
    if (isset($_POST['add_new_content'])) {
        $db = new Dbobjects();
        $db->tableName = "content";
        $db->insertData['title'] = $_POST['page_title'];
        $db->insertData['content'] = 'Write your content here';
        if (isset($_POST['parent_id'])) {
            $db->insertData['parent_id'] = $_POST['parent_id'];
        }
        if (isset($_POST['status'])) {
            $db->insertData['status'] = $_POST['status'];
        }else{
            $db->insertData['status'] = 'draft';
        }
        // if (isset($_POST['price'])) {
        //     $db->insertData['price'] = sanitize_remove_tags($_POST['price']);
        // }
        if (isset($_POST['price_bulk_qty']) && isset($_POST['bulk_qty']) && isset($_POST['discount_amt'])) {
            $blk_price = sanitize_remove_tags($_POST['price_bulk_qty']);
            $blk_qty = sanitize_remove_tags($_POST['bulk_qty']);
            $blk_dic = sanitize_remove_tags($_POST['discount_amt']);
            $price = $blk_price/$blk_qty;
            $dic = $blk_dic/$blk_qty;
            $db->insertData['price'] = $price;
            $db->insertData['bulk_qty'] = sanitize_remove_tags($_POST['bulk_qty']);
            $db->insertData['discount_amt'] = $dic;
        }else{
            $db->insertData['price'] = 1;
            $db->insertData['bulk_qty'] = 1;
            $db->insertData['discount_amt'] = 0;
        }
        // if (isset($_POST['discount_amt'])) {
        //     $db->insertData['discount_amt'] = sanitize_remove_tags($_POST['discount_amt']);
        // }
        if (isset($_POST['qty'])) {
            $db->insertData['qty'] = sanitize_remove_tags($_POST['qty']);
        }
        // if (isset($_POST['bulk_qty'])) {
        //     $db->insertData['bulk_qty'] = sanitize_remove_tags($_POST['bulk_qty']);
        //     if ($_POST['bulk_qty']==0 || $_POST['bulk_qty']==null) {
        //         $db->insertData['bulk_qty'] = 1;
        //     }
        // }else{
        //     $db->insertData['bulk_qty'] = 1;
        // }
        if (isset($_POST['tax'])) {
            $db->insertData['tax'] = sanitize_remove_tags($_POST['tax']);
        }
        if (isset($_POST['brand'])) {
            $db->insertData['brand'] = sanitize_remove_tags($_POST['brand']);
        }
        if (isset($_POST['color'])) {
            $db->insertData['color_list'] = json_encode([$_POST['color']]);
            if ($_POST['color']=="") {
                $db->insertData['color_list'] = json_encode(['white']);
            }
        }
        if (isset($_POST['grouped_content'])) {
            $db->insertData['grouped_content'] = $_POST['grouped_content'];
        }
        if (isset($_POST['related_product_id'])) {
            $db->insertData['json_obj'] = json_encode(array('related_products'=>$_POST['related_product_id']));
        }
        else{
            $db->insertData['json_obj'] = json_encode(array('related_products'=>array()));
        }
        $db->insertData['slug'] = $_POST['slug'];
        $db->insertData['content_group'] = $type;
        $db->insertData['content_type'] = "product";
        $db->insertData['created_by'] = $_SESSION['user_id'];
        $slug = generate_slug($_POST['slug']);
        if (check_slug_globally($slug)==0) {
            $db->insertData['slug'] = $slug;
            return $db->create();
        }
        else{
            $_SESSION['msg'][] = "Please change slug";
            return false;
        }
    }
}
function delContent($id=null)
{
    if ($id > 0) {
        $db = new Dbobjects();
        $db->tableName = "content";
        $qry['id'] = $id;
        // $qry['status'] = 'trash';
        if(count($db->filter($qry))>0){
            $db->pk($id);
            return $db->delete();
        }
        else{
            return false;
        }
        
    }
    else{
        return false;
    }
}

function getCat($id=null)
{
    if ($id !=null) {
        $db = new Dbobjects();
        $db->tableName = "categories";
        $qry['id'] = $id;
        if(count($db->filter($qry))>0){
            return $db->pk($id)['name'];
        }
        else{
            return false;
        }
    }
    else{
        return false;
    }
}
function updateColorList($id,$color='mixed')
{
    $content = getData('content',$id);
    $color_list = json_decode($content['color_list'],true);
    if (in_array($color,$color_list)==false) {
        $color_list[]=$color;
    }
    $color_list_jsn=json_encode($color_list);
    try {
        (new Model('content'))->update($id,array('color_list'=>$color_list_jsn));
        return true;
    } catch (\Throwable $th) {
        return false;
    }
}
function removeColorList($id,$color)
{
    $content = getData('content',$id);
    $color_list = json_decode($content['color_list']);

    if (in_array($color,$color_list)==true) {
        try {
            $del_i =  array_search($color,$color_list);
            array_splice($color_list,$del_i,1);
            $color_list_jsn=json_encode($color_list);
            (new Model('content'))->update($id,array('color_list'=>$color_list_jsn));
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }else{
        return false;
    }
    
}

// updateColorList($id=323,$color="blue");
// removeColorList($id=323,$color="blue");