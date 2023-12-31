<?php
$url = explode("/", $_SERVER["QUERY_STRING"]);
$path = $_SERVER["QUERY_STRING"];
$GLOBALS['url_last_param'] = end($url);
$GLOBALS['url_2nd_last_param'] = prev($url);
$plugin_dir = "packages";
import("apps/plugins/{$plugin_dir}/function.php");

if ("{$url[0]}/{$url[1]}" == "admin/$plugin_dir") {
switch ($path) {
    case "admin/$plugin_dir":
        if (isset($_POST['add_new_content'])) {
            $pageid = addContent($type="package");
            if($pageid == false){
                echo js_alert("Duplicate slug, Change slug");
            }
        }
        import("apps/plugins/{$plugin_dir}/show_contents.php");
        break;
    // case "{$plugin_dir}/post":
    //     if (isset($_POST['add_new_content'])) {
    //         $pageid = addContent($type="post");
    //         if($pageid != false){
    //             echo js_alert("Success");
    //         }
    //     }
    //     import("apps/plugins/{$plugin_dir}/show_contents.php");
    //     break;
    // case "{$plugin_dir}/slider":
    //     if (isset($_POST['add_new_content'])) {
    //         $pageid = addContent($type="slider");
    //         if($pageid != false){
    //             echo js_alert("Success");
    //         }
    //     }
    //     import("apps/plugins/{$plugin_dir}/show_contents.php");
    //     break;
    // case "{$plugin_dir}/service":
    //     if (isset($_POST['add_new_content'])) {
    //         $pageid = addContent($type="service");
    //         if($pageid != false){
    //             echo js_alert("Success");
    //         }
    //     }
    //     import("apps/plugins/{$plugin_dir}/show_contents.php");
    //     break;
    case "admin/{$plugin_dir}/edit/{$GLOBALS['url_last_param']}":
        if (isset($_FILES['banner']) && isset($_POST['update_banner'])) {
            $banner_name = time()."_".$_SESSION['user_id'];
            uploadBanner($banner_name);
        }
        import("apps/plugins/{$plugin_dir}/edit_content.php");
        break;
    case "admin/{$plugin_dir}/edit/{$GLOBALS['url_2nd_last_param']}/update":
        if (isset($_POST['page_id']) && isset($_POST['update_page'])) {
            if(updatePage() === true){
                echo js_alert("Update");
                echo js("location.reload();");
            }
        }
        break;
    case "admin/{$plugin_dir}/delete/{$GLOBALS['url_last_param']}":
        if (is_superuser()===false) {
            header("Location:/".home);
          }
          else{
            if(delContent($id=$GLOBALS['url_last_param']) != false){
                echo js_alert("Deleted Successfully");
                header("Location:/".home."/admin/{$plugin_dir}");
            }
            else{
                echo js_alert("Invalid activity");
                header("Location:/".home."/admin/{$plugin_dir}");
            }
          }
        break;
    default:
        // if ($url[1]=='delete') {
        //     if (is_superuser()===false) {
        //         header("Location:/".home);
        //       }
        //       else{
        //         if(delContent($id=$GLOBALS['url_last_param']) != false){
        //             // echo js_alert("Deleted Successfully");
        //             if ($GLOBALS['url_2nd_last_param']!='page') {
        //                 header("Location:/".home."/{$plugin_dir}/{$GLOBALS['url_2nd_last_param']}");
        //                 // echo js('location.href=/'.home.'/'.$GLOBALS['url_2nd_last_param']);
        //             }
        //             else{
        //                 header("Location:/".home."/{$plugin_dir}");
        //             }
                    
        //         }
        //         else{
        //             echo js_alert("Invalid activity");
        //             header("Location:/".home."/{$plugin_dir}");
        //         }
        //       }
        //     break;
        // }
        if (count($url)>=3) {
        if ("{$url[1]}/{$url['2']}"=="{$plugin_dir}/add-more-img") {
            if (isset($_FILES['add_more_img']) && $_FILES['add_more_img']['name']!="") {
                import("apps/controllers/ContentDetailsCtrl.php");
                $listObj = new ContentDetailsCtrl;
                if($listObj->add_more_img()==true){
                    echo js('location.reload();');
                }
                else{
                    echo js_alert('Not added');
                }
                msg_ssn("msg");
                return;
            }
            break;
        }
        if ("{$url[1]}/{$url['2']}"=="{$plugin_dir}/add-more-detail") {
            if (isset($_POST['add_more_detail']) && isset($_POST['add_more_heading']) && isset($_POST['content_id']) && isset($_POST['content_group'])) {
                import("apps/controllers/ContentDetailsCtrl.php");
                $listObj = new ContentDetailsCtrl;
                if($listObj->add_more_detail()==true){
                    echo js_alert('Added');
                    echo js('location.reload();');
                    return;
                }
                else{
                    echo js_alert('Not updated');
                    return;
                }
                msg_ssn("msg");
                return;
            }
            break;
        }
        if ("{$url[1]}/{$url['2']}"=="{$plugin_dir}/delete-content-details") {
            if (isset($_POST['content_details_delete_id'])) {
                import("apps/controllers/ContentDetailsCtrl.php");
                $listObj = new ContentDetailsCtrl;
                if($listObj->destroy($_POST['content_details_delete_id'])==true){
                    echo js('location.reload();');
                }
                else{
                    echo js_alert('Not Deleted');
                }
                msg_ssn("msg");
                return;
            }
            break;
        }
    }
          import("apps/view/404.php");
          break;
    }
}

