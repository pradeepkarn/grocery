<?php
$url = explode("/", $_SERVER["QUERY_STRING"]);
$path = $_SERVER["QUERY_STRING"];
$GLOBALS['url_last_param'] = end($url);
$GLOBALS['url_2nd_last_param'] = prev($url);
$plugin_dir = "departments"; 
import("apps/plugins/{$plugin_dir}/function.php");

if ("{$url[0]}/{$url[1]}" == "admin/$plugin_dir") {
switch ($path) {
    case "admin/$plugin_dir":
        if (isset($_POST['add_new_content'])) {
            $pageid = addContent($type="department");
            if($pageid == false){
                echo js_alert("Duplicate slug, Change slug");
            }
        }
        else if (isset($_POST['delete_category']) && isset($_POST['parent_id_del'])) {
            delContent($id=$_POST['parent_id_del']);
        }
        import("apps/plugins/{$plugin_dir}/show_contents.php");
        break;
    case "admin/{$plugin_dir}/get-employee-list-ajax":
                $userObj = new Model('pk_user');
                // $employees = $userObj->index();
                $search_data = sanitize_remove_tags($_POST['emp_keyword']);
                $arr['id'] = $search_data;
                $arr['username'] = $search_data;
                $arr['first_name'] = $search_data;
                $arr['last_name'] = $search_data;
                $arr['email'] = $search_data;
                $arr['mobile'] = $search_data;
                $employees = $userObj->search($arr);
                // $employees = $userObj->filter_index(array('user_group'=>'employee'));
                // print_r($genres);
                if ($employees==false) {
                    $employees = array();
                }
            ?>
            <?php foreach ($employees as $empk => $empv): ?>
                <li id="getEmpList<?php echo $empv['id']; ?>" class="py-1 pk-pointer">
                    <input <?php if(isset($_POST['old_manager_id']) && ($_POST['old_manager_id']==$empv['id'])){echo "checked"; } ?> onclick="setInSearch(`<?php echo $empv['first_name']; ?>`)" class="update_page" type="radio" name="manager_id" value="<?php echo $empv['id']; ?>"> 
                    <?php echo $empv['first_name'] ?? $empv['first_name'] ?? "Un named"; ?> ID: <?php echo $empv['id']; ?> 
                </li>
        <?php endforeach;
        break;
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
        // if (isset($_FILES['banner']) && isset($_POST['update_banner'])) {
        //     $banner_name = time()."_".$_SESSION['user_id'];
        //     uploadBanner($banner_name);
        // }
        if (isset($_POST['update_banner'])) {
            $contentid = $_POST['update_banner_page_id'];
            $banner=$_FILES['banner'];
            $banner_name = time().uniqid("_banner_").USER['id'];
            change_my_banner($contentid=$contentid,$banner=$banner,$banner_name=$banner_name);
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
    // case "admin/$plugin_dir/delete":
    //     if (isset($_POST['delete_category']) && isset($_POST['parent_id'])) {
    //         if(verify_csrf($_POST['csrf_token'])==false){
    //             echo js_alert("Invalid csrf token");
    //             echo js("location.reload();");
    //             return;
    //         }
    //         delContent($id=$_POST['parent_id']);
    //         echo js("location.reload();");
    //         return;
    //     }
    //     break;
    // case "admin/{$plugin_dir}/delete/{$GLOBALS['url_last_param']}":
    //     if (is_superuser()===false) {
    //         header("Location:/".home);
    //       }
    //       else{
    //         if(delContent($id=$GLOBALS['url_last_param']) != false){
    //             echo js_alert("Deleted Successfully");
    //             header("Location:/".home."/admin/{$plugin_dir}");
    //         }
    //         else{
    //             echo js_alert("Invalid activity");
    //             header("Location:/".home."/admin/{$plugin_dir}");
    //         }
    //       }
    //     break;
    default:
    if (count($url)>=3) {
        if ($url[1]=='delete') {
            if (is_superuser()===false) {
                header("Location:/".home);
              }
              else{
                if(delContent($id=$GLOBALS['url_last_param']) != false){
                    // echo js_alert("Deleted Successfully");
                    if ($GLOBALS['url_2nd_last_param']!='page') {
                        header("Location:/".home."/{$plugin_dir}/{$GLOBALS['url_2nd_last_param']}");
                        // echo js('location.href=/'.home.'/'.$GLOBALS['url_2nd_last_param']);
                    }
                    else{
                        header("Location:/".home."/{$plugin_dir}");
                    }
                    
                }
                else{
                    echo js_alert("Invalid activity");
                    header("Location:/".home."/{$plugin_dir}");
                }
              }
            break;
        }
        if ($url[2]=='add-new-item') {
            import("apps/plugins/{$plugin_dir}/add-new-item.php");
            return;
        }
        if ($url[2]=='add-new-cat-ajax') {
            if ($_POST['page_title']=="") {
                echo js_alert('Empty name is not allowed');
                return;
            }
            $pageid = addContent($type="department");
            
            if (isset($_FILES['banner']) && $_FILES['banner']["error"]==0 && filter_var($pageid,FILTER_VALIDATE_INT)) {
                $contentid = $pageid;
                $banner=$_FILES['banner'];
                $banner_name = time().uniqid("_banner_").USER['id'];
                change_my_banner($contentid=$contentid,$banner=$banner,$banner_name=$banner_name);
            }
            if (filter_var($pageid,FILTER_VALIDATE_INT)) {
                echo js_alert('added');
                $home = home;
                echo js("location.href='/$home/admin/$plugin_dir';");
            }
            return;
        }

        
    }
          import("apps/view/404.php");
          break;
    }
}

