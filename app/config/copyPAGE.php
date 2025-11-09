<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$head_id   = $_GET['ID'];
		
    //get data
	$sql = "SELECT * FROM index_head WHERE id = '" . $head_id . "' LIMIT 1";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    if (isset($data['id']) && $data['id'] != null) {

        //get next seq
        $sql3 = "SELECT IFNULL(MAX(menu_order),1) AS max_menu_order FROM index_head WHERE parent_id = '0' LIMIT 1";
        $result3 = mysqli_query($dw3_conn, $sql3);
        if ($result3->num_rows > 0) {
            $data3 = mysqli_fetch_assoc($result3);
            $menu_order = intval($data3['max_menu_order'])+1;
        } else {
            $menu_order = "1"; 
        }
        $sql2 = "INSERT INTO index_head (id,parent_id,title,title_display,url,font_family,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,opacity,background,foreground,max_width,border_radius,margin,boxShadow,html_fr,html_en,anim_class)
        VALUES(NULL,"."'0'"
        .",'copy of ".$data['title']."','"
        .$data['title_display']."','"
        .$data['url']."','"
        .$data['font_family']."','"
        .$data['target']."','"
        .$data['is_in_menu']."','"
        .$data['icon']."','"
        .$menu_order."','"
        .$data['cat_list']."','"
        .$data['img_url']."','"
        .$data['img_display']."','"
        .$data['opacity']."','"
        .$data['background']."','"
        .$data['foreground']."','"
        .$data['max_width']."','"
        .$data['border_radius']."','"
        .$data['margin']."','"
        .$data['boxShadow']."','"
        .mysqli_real_escape_string($dw3_conn,$data['html_fr'])."','"
        .mysqli_real_escape_string($dw3_conn,$data['html_en'])."','"
        .$data['anim_class']."');";
        if ($dw3_conn->query($sql2) === TRUE) {
            $new_page_id = $dw3_conn->insert_id;
            	$sql2 = "SELECT * FROM index_head WHERE parent_id = '" . $head_id . "';";
                $result2 = $dw3_conn->query($sql2);
                if ($result2->num_rows > 0) {		
                    while($row2 = $result2->fetch_assoc()) {
                        $sql1 = "INSERT INTO index_head (id,parent_id,title,title_display,url,font_family,target,is_in_menu,icon,menu_order,cat_list,img_url,img_display,opacity,background,foreground,max_width,border_radius,margin,boxShadow,html_fr,html_en,anim_class)
                        VALUES(NULL,'".$new_page_id
                        ."','copy of ".$row2['title']."','"
                        .$row2['title_display']."','"
                        .$row2['url']."','"
                        .$row2['font_family']."','"
                        .$row2['target']."','"
                        .$row2['is_in_menu']."','"
                        .$row2['icon']."','"
                        .$row2['menu_order']."','"
                        .$row2['cat_list']."','"
                        .$row2['img_url']."','"
                        .$row2['img_display']."','"
                        .$row2['opacity']."','"
                        .$row2['background']."','"
                        .$row2['foreground']."','"
                        .$row2['max_width']."','"
                        .$row2['border_radius']."','"
                        .$row2['margin']."','"
                        .$row2['boxShadow']."','"
                        .mysqli_real_escape_string($dw3_conn,$row2['html_fr'])."','"
                        .mysqli_real_escape_string($dw3_conn,$row2['html_en'])."','"
                        .$row2['anim_class']."');";
                        $dw3_conn->query($sql1);
                        $new_head = $dw3_conn->insert_id;
                        $sql3 = "INSERT INTO index_line (id,head_id,sort_order,title_fr,title_en,html_fr,html_en) 
                        SELECT NULL,'".$new_head."',sort_order,title_fr,title_en,html_fr,html_en FROM index_line WHERE head_id = '".$row2['id']."';";
                        $dw3_conn->query($sql3);
                        //slideshows
                        $sql3 = "INSERT INTO slideshow (id,index_id,sort_by,name_fr,name_en,media_type,media_link,media_url,description_fr,description_en) 
                        SELECT NULL,'".$new_head."',sort_by,name_fr,name_en,media_type,media_link,media_url,description_fr,description_en FROM slideshow WHERE index_id = '".$row2['id']."';";
                        $dw3_conn->query($sql3);
                    }
                }


            echo $menu_order;
        } else {
            echo $dw3_conn->error;
        }
    } else {
        echo $dw3_conn->error;  
    }
    //echo $sql;
$dw3_conn->close();
?>