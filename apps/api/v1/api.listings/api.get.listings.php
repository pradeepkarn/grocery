<?php 
import('apps/api/v1/api.listings/fn.relprods.php');
if(isset($_POST['listing_id'])){
    if (filter_input(INPUT_POST, "listing_id", FILTER_VALIDATE_INT)) {
        $id = $_POST['listing_id'];
        $db = new Model('content');
        $arr['id'] = $id;
        $arr['content_group'] = "product";
        $listings = $db->filter_index($arr);
        if ($listings==false) {
            $data['msg'] = "Not found";
            $data['data'] = null;
            echo json_encode($data);
            die();
        }
        $relt_prods = array();
        if ($listings[0]['json_obj']!=null) {
            $jsnobj = json_decode($listings[0]['json_obj']);
            if (isset($jsnobj->related_products)) {
                $relt_prods = rel_prods($jsnobj->related_products) ;
            }
        }  
        // $colorObj = new Model('content');
        // $cv = array();
        // $colorObj = $colorObj->show_unique_whr('color',array('grouped_content'=>$listings[0]['grouped_content'],'content_group'=>'product'));
        
        // foreach ($colorObj as $key => $cvv) {
        //     if ($cvv['color']!="") {
        //         $cv[] = $cvv['color'];
        //     }
        // }   
        $listing_data['id'] = $listings[0]['id'];
        $listing_data['title'] = $listings[0]['title'];
        // $listing_data['currency'] = $listings[0]['currency'];
        $listing_data['price'] = $listings[0]['price'];
        $listing_data['tax'] = $listings[0]['tax'];
        $listing_data['brand'] = $listings[0]['brand'];
        // $listing_data['color'] = $listings[0]['color'];
        $listing_data['color_list'] = json_decode($listings[0]['color_list']);
        $listing_data['bulk_qty'] = $listings[0]['bulk_qty'];
        $listing_data['stock_qty'] = $listings[0]['qty'];
        // $listing_data['info'] = $listings[0]['content_info'];
        $listing_data['description'] = $listings[0]['content'];
        $listing_data['image'] = "/media/images/pages/".$listings[0]['banner'];
        // $listing_data['category_id']  = $listings[0]['parent_id'];
        // $listing_data['category']  = ($listings[0]['parent_id']==0)?'Uncategoriesed':getData('content',$listings[0]['parent_id'])['title'];
        $listing_data['rel_prods'] = $relt_prods;
        // $listing_data['product_group'] = getData('grouped_content',$listings[0]['grouped_content'])?getData('grouped_content',$listings[0]['grouped_content']):null;
        // $listing_data['product_color_group'] = $cv;
        // $listing_data['status'] = $listings[0]['status'];
        $moreobj = new Model('content_details');
        $moreimg = $moreobj->filter_index(array('content_id'=>$listings[0]['id'],'content_group'=>'product_more_img'));
        $moreimg = $moreimg==false?array():$moreimg;
            if (count($moreimg)==0) {
                $listing_data['more_img'][] = "/media/images/pages/{$listings[0]['banner']}";
            }
            else{
                foreach ($moreimg as $key => $fvl):
                    $listing_data['more_img'][] = "/media/images/pages/{$fvl['content']}";
                endforeach;
            }
        // $moredetail = $moreobj->filter_index(array('content_id'=>$listings[0]['id'],'content_group'=>'product_more_detail'));
        // $moredetail = $moredetail==false?array():$moredetail;
        // $listing_data['more_detail'][] = $moredetail;
        $data['msg'] = "success";
        // $data['listed_by'] = $listings[0]['created_by'];
        $user = getData('pk_user',$listings[0]['created_by']);
        // $data['user_membership'] = $user['user_group'];
        // $data['full_name'] = $user['name'];
        // $data['username'] = $user['username'];
        $data['data'] = $listing_data;
        echo json_encode($data);
        return;
    }
    else{
        $data['msg'] = "Invalid Id";
        $data['data'] = null;
        echo json_encode($data);
        die();
    }
}

else{
    $db = new Model('content');
    $listings = $db->filter_index(array('content_group'=>'product'),$ord="DESC",$limit="1000",$change_order_by_col="id");
    if ($listings==false) {
        $data['msg'] = "No Listing";
        $data['data'] = null;
        echo json_encode($data);
        die();
    }
    else{
        foreach ($listings as $key => $uv) {
            $rel_prods = array();
            
            // $rel_prods = array();
            $user = getData('pk_user',$uv['created_by']);  
            $moreobj = new Model('content_details');
            $moreimg = $moreobj->filter_index(array('content_id'=>$uv['id'],'content_group'=>'product_more_img'));
            $moreimg = $moreimg==false?array():$moreimg;
            $moredetail = $moreobj->filter_index(array('content_id'=>$uv['id'],'content_group'=>'product_more_detail'));
            $moredetail = $moredetail==false?array():$moredetail;
            $colorObj = new Model('content');
            $cv = array();
            $colorObj = $colorObj->show_unique_whr('color',array('grouped_content'=>$uv['grouped_content'],'content_group'=>'product'));
            
            foreach ($colorObj as $key => $cvv) {
                if ($cvv['color']!="") {
                    $cv[] = $cvv['color'];
                }
            }
            // $cv = array_filter($cv);
            if (count($moreimg)==0) {
                $mor_imgs = array();
                $mor_imgs[] = "/media/images/pages/{$uv['banner']}";
            }
            else{
                foreach ($moreimg as $key => $fvl):
                $mor_imgs[] = "/media/images/pages/{$fvl['content']}";
                endforeach;
            }   
            if ($uv['json_obj']!=null) {
                $jsn = json_decode($uv['json_obj']);
                if (isset($jsn->related_products)) {
                    $rel_prods = rel_prods($jsn->related_products) ;
                }
            }      
            $listing_data[] = array(
                'id'=>$uv['id'],
                'title'=>$uv['title'],
                'currency'=>$uv['currency'],
                'price'=>$uv['price'],
                'tax'=>$uv['tax'],
                'qty_to_sell'=>$uv['bulk_qty'],
                'stock_qty'=>$uv['qty'],
                'brand'=>$uv['brand'],
                // 'color'=>$uv['color'],
                'color_list'=>json_decode($uv['color_list'],true),
                'info'=>$uv['content_info'],
                'description'=>pk_excerpt(sanitize_remove_tags($uv['content'])),
                'image' => "/media/images/pages/".$uv['banner'],
                // 'category_id' => $uv['parent_id'],
                // 'category' => ($uv['parent_id']==0)?'Uncategoriesed':getData('content',$uv['parent_id'])['title'],
                'rel_prods' => $rel_prods,
                // 'product_group' => getData('grouped_content',$uv['grouped_content'])?getData('grouped_content',$uv['grouped_content']):null,
                // 'product_color_group' => $cv,
                'status' => $uv['status'],
                'more_img' => $mor_imgs,
                // 'more_detail' => $moredetail,
                'listed_by' => $uv['created_by']
                // 'user_membership' => $user['user_group'],
                // 'full_name' => $user['name'],
                // 'username' => $user['username'],
            );
            $mor_imgs = null;
        }
        $data['msg'] = "success";
        $data['data'] = $listing_data;
        echo json_encode($data);
        return;
    }
}