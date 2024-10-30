<?php
/*
Plugin Name: Business Card by Esterox
Author: Esterox
Description: Create your awesome Business Cards  with this simple plugin.
Version: 1.0.0
License: GPLv2 or later
Author URI: http://esterox.am/plugins/wp/business-card
*/

register_activation_hook( __FILE__, 'Es_create_table' );

remove_shortcode( 'BCard');
add_shortcode( 'BCard', 'Es_BCard' );

add_action( 'admin_menu', 'Es_options_page' );

add_action( 'wp_footer', 'esterox_register_styles_scripts' );
add_action( 'admin_footer', 'esterox_register_styles_scripts_admin' );

function esterox_register_styles_scripts_admin(){
	wp_register_script( 'esterox-admin-fabric-js', plugins_url( 'js/fabric.js', __FILE__ ), array('jquery') );
	wp_register_script( 'esterox-admin-scripts-js', plugins_url( 'js/esterox_admin_scripts.js', __FILE__ ) );
	wp_register_style( 'esterox-admin-css', plugins_url( 'css/esterox-admin-style.css', __FILE__ ) );
	
	wp_register_style( 'esterox-admin-related-css', plugins_url( 'css/esterox-style.css', __FILE__ ) );
	wp_enqueue_style( 'esterox-admin-related-css' );


	wp_enqueue_script('jquery');
	wp_enqueue_script( 'esterox-admin-fabric-js' );
	wp_enqueue_script( 'esterox-admin-scripts-js' );
	wp_enqueue_style( 'esterox-admin-css' );
}

function esterox_register_styles_scripts(){
	wp_register_script( 'esterox-fabric-js', plugins_url( 'js/fabric.js', __FILE__ ), array('jquery'));
	wp_register_script( 'esterox-scripts-js', plugins_url( 'js/esterox_scripts.js', __FILE__ ) );

	wp_register_style( 'esterox-related-css', plugins_url( 'css/esterox-style.css', __FILE__ ) );
	wp_register_style( 'esterox-style-css', plugins_url( 'css/style.css', __FILE__ ) );


	wp_enqueue_script( 'esterox-fabric-js' );

	wp_enqueue_script( 'esterox-scripts-js' );

	wp_enqueue_style( 'esterox-related-css' );
	wp_enqueue_style( 'esterox-style-css' );

}


function Es_create_table(){
	global $wpdb;	
	$query = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix ."es_bcard (
				id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
				file_name VARCHAR(255),
				file_text BLOB,
				chosen INT(1),
				category_id INT
			)";	
	$wpdb->query($wpdb->prepare($query,array()));
	
	$query = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix ."es_category (
				id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
				category VARCHAR(255),
				status INT(1),
				empty_card INT(1)
			)";	
	$wpdb->query($wpdb->prepare($query,array()));
	
	$count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM ".$wpdb->prefix ."es_category",array()));
	if($count==0){
		$query = "INSERT INTO ".$wpdb->prefix ."es_category (category,status,empty_card)
				  VALUES
				  ('Other','1','1'),
				  ('Animals','1','1'),
				  ('Beauty','1','1'),
				  ('Business','1','1'),
				  ('Sports','1','1'),
				  ('Doctors','1','1')";	
		$wpdb->query($wpdb->prepare($query,array()));
	}
	
	$count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM ".$wpdb->prefix ."es_bcard",array()));
	if($count==0){
	   $ob='text1:{
				fill       : "#8080ff",
				left       : 250,
				fontSize   : 30,
				fontFamily : "Courier New,Courier New,Courier,monospace",
				fontWeight : "normal",
				name       : "Company name",
				top        : 20,
				textAlign  : "right",
				fontStyle  : "italic",
				scaleX     : 1,
				scaleY     : 1,
				angle      : 0,
				width      : 400,
				height     : 500
			},
			text2:{
				fill       : "#8080ff",
				left       : 250,
				fontSize   : 18,
				fontFamily : "Courier New,Courier New,Courier,monospace",
				fontWeight : "normal",
				name       : "Address",
				top        : 60,
				textAlign  : "right",
				fontStyle  : "italic",
				scaleX     : 1,
				scaleY     : 1,
				angle      : 0,
				width      : 400,
				height     : 500
			},
			text3:{
				fill       : "#8080ff",
				left       : 250,
				fontSize   : 20,
				fontFamily : "Courier New,Courier New,Courier,monospace",
				fontWeight : "normal",
				name       : "Website name",
				top        : 100,
				textAlign  : "right",
				fontStyle  : "italic",
				scaleX     : 1,
				scaleY     : 1,
				angle      : 0,
				width      : 400,
				height     : 500
			},
			text4:{
				fill       : "#FF0000",
				left       : 100,
				fontSize   : 30,
				fontFamily : "Courier New,Courier New,Courier,monospace",
				fontWeight : "normal",
				name       : "Full Name",
				top        : 180,
				textAlign  : "right",
				fontStyle  : "italic",
				scaleX     : 1,
				scaleY     : 1,
				angle      : 0,
				width      : 400,
				height     : 500
			},
			text5:{
				fill       : "#FF0000",
				left       : 100,
				fontSize   : 20,
				fontFamily : "Courier New,Courier New,Courier,monospace",
				fontWeight : "normal",
				name       : "Position",
				top        : 220,
				textAlign  : "right",
				fontStyle  : "italic",
				scaleX     : 1,
				scaleY     : 1,
				angle      : 0,
				width      : 400,
				height     : 500
			},
			text6:{
				fill       : "#FF0000",
				left       : 100,
				fontSize   : 20,
				fontFamily : "Courier New,Courier New,Courier,monospace",
				fontWeight : "normal",
				name       : "Phone",
				top        : 260,
				textAlign  : "right",
				fontStyle  : "italic",
				scaleX     : 1,
				scaleY     : 1,
				angle      : 0,
				width      : 400,
				height     : 500
			}';
		
		//$file_text=serialize($ob);
		$file_text=base64_encode($ob);
		$query = "INSERT INTO ".$wpdb->prefix ."es_bcard (file_name,file_text,chosen,category_id)
				  VALUES
				  ('other_1.jpg','".$file_text."','1','1'),
				  ('other_2.jpg','".$file_text."','1','1'),
				  ('animals_1.jpg','".$file_text."','1','2'),
				  ('animals_2.jpg','".$file_text."','1','2'),
				  ('beauty_1.jpg','".$file_text."','1','3'),
				  ('beauty_2.jpg','".$file_text."','1','3'),
				  ('business_1.png','".$file_text."','1','4'),
				  ('business_2.png','".$file_text."','1','4'),
				  ('sports_1.jpg','".$file_text."','1','5'),
				  ('sports_2.png','".$file_text."','1','5'),
				  ('doctors_1.png','".$file_text."','1','6'),
				  ('doctors_2.png','".$file_text."','1','6')";	
		$wpdb->query($wpdb->prepare($query,array()));
	}
}

function pagination($count_pages,$start,$active,$count_show_pages,$url_page){
	if ($count_pages > 1) {
		$left = $active - 1;
		$right = $count_pages - $active;
		if ($left < floor($count_show_pages / 2)){
			$start = 1;
		}else{
			$start = $active - floor($count_show_pages / 2);
		} 
		$end = $start + $count_show_pages - 1;
		if ($end > $count_pages) {
		  $start -= ($end - $count_pages);
		  $end = $count_pages;
		  if ($start < 1) $start = 1;
		}
		
		$html ='<div id="pagination"> <ul>';
			 if ($active != 1) {
				$url_2 = $active == 2 ? $url_page : $url_page.($active - 1);
				$html .= '<li><a href="'.esc_url( $url_page ).'" title="First page">&lt;&lt;</a></li>
				<li><a href="'.esc_url( $url_2 ).'" title="First page">&lt;</a></li>';
			 } 
			 for ($i = $start; $i <= $end; $i++) { 
			   if ($i == $active) {
				$html .= '<li><span>'.$i.'</span></li>'; 
			   } else {
					$url_2 = $i == 1 ? $url_page : $url_page.$i;
					$html .= '<li><a href="'.esc_url( $url_2 ).'">'.$i.'</a></li>';
			   }
			 } 
			 if ($active != $count_pages) { 
			  $html .= '<li><a href="'.esc_url( $url_page.($active + 1) ).'" title="Next page">&gt;</a></li>
			  <li><a href="'.esc_url( $url_page.$count_pages ).'" title="Previous page">&gt;&gt;</a></li>';
			 } 
		$html .= '</ul></div>';				
		return $html;					
	}
	return '';
}

function Es_BCard($atts, $content){	
	global $wpdb;
	if(!empty($_GET['id']) && is_numeric($_GET['id'])){
		$get_id = sanitize_text_field( $_GET['id'] );
		//$result = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix ."es_bcard where id=".$get_id,"ARRAY_A");
		$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix ."es_bcard where id=%d",$get_id),"ARRAY_A");
	}
	
	if(!empty($_GET['id']) && !empty($result)){
		include(plugin_dir_path( __FILE__ ).'business_card_view.php');		
	}else{
		//$res = $wpdb->get_results("SELECT tbl2.* FROM ".$wpdb->prefix ."es_bcard as tbl1 JOIN ".$wpdb->prefix ."es_category as tbl2 ON tbl1.category_id=tbl2.id where tbl1.chosen=1 and tbl2.status=1 GROUP BY tbl2.category ORDER BY tbl2.category ","ARRAY_A");
		$res = $wpdb->get_results($wpdb->prepare("SELECT tbl2.* FROM ".$wpdb->prefix ."es_bcard as tbl1 JOIN ".$wpdb->prefix ."es_category as tbl2 ON tbl1.category_id=tbl2.id where tbl1.chosen=1 and tbl2.status=1 GROUP BY tbl2.category ORDER BY tbl2.category ",array()),"ARRAY_A");
		if(!empty($_GET['cat'])){
			$category_id=sanitize_text_field( $_GET['cat'] );
		}else{
			$category_id='all';
		}
		
		$html ='<div class="site_container">
			          <div class="card_block_head">
					  <h1>SELECT A BUSINESS CARD DESIGN</h1>
					  <p class="categ_block">
					  <label for="category">Card Category:</label>						
					  <select id="category" name="category">
						<option value="all">All</option>
					  </p>';
					  
		 foreach ($res as $value) { 
			$selected= $category_id==$value['id']   ? "selected" : "";			
			$html .= "<option ".$selected." value='".$value['id']."' >".$value['category']."</option>";
		 } 
		$html .=	'</select>					    
                </div>';
				
		if($category_id=='all'){
			//$count = $wpdb->get_results("SELECT count(*) as num FROM ".$wpdb->prefix ."es_bcard as tbl1 JOIN ".$wpdb->prefix ."es_category as tbl2 ON tbl1.category_id=tbl2.id where tbl1.chosen=1 and tbl2.status=1 GROUP BY tbl2.category ORDER BY tbl2.category","ARRAY_A");
			$count = $wpdb->get_results($wpdb->prepare("SELECT count(*) as num FROM ".$wpdb->prefix ."es_bcard as tbl1 JOIN ".$wpdb->prefix ."es_category as tbl2 ON tbl1.category_id=tbl2.id where tbl1.chosen=1 and tbl2.status=1 GROUP BY tbl2.category ORDER BY tbl2.category",array()),"ARRAY_A");
			$count=count($count);
			$limit=3;			
			$count_pages = ceil($count/$limit);
			$start=empty($_GET['pag']) || $_GET['pag']>$count_pages ? 0 : $limit*($_GET['pag']-1);
			//$result = $wpdb->get_results("SELECT tbl2.* FROM ".$wpdb->prefix ."es_bcard as tbl1 JOIN ".$wpdb->prefix ."es_category as tbl2 ON tbl1.category_id=tbl2.id where tbl1.chosen=1 and tbl2.status=1 GROUP BY tbl2.category ORDER BY tbl2.category LIMIT ".$start.",".$limit ,"ARRAY_A");
			$result = $wpdb->get_results($wpdb->prepare("SELECT tbl2.* FROM ".$wpdb->prefix ."es_bcard as tbl1 JOIN ".$wpdb->prefix ."es_category as tbl2 ON tbl1.category_id=tbl2.id where tbl1.chosen=1 and tbl2.status=1 GROUP BY tbl2.category ORDER BY tbl2.category LIMIT %d ,%d",$start,$limit) ,"ARRAY_A");

			$active = empty($_GET['pag']) || $_GET['pag']>$count_pages ? 1 : $_GET['pag'];
			$count_show_pages = 5;			
			$url_page = get_permalink( )."?cat=".$category_id."&pag=";
			
			$html.=pagination($count_pages,$start,$active,$count_show_pages,$url_page);
			
			foreach ($result as $key => $value) {
				$html .='<div class="panel">
							<div class="panel_head"><input type="hidden" name="category[]" id="" value="'.$value['id'].'">'.$value['category'].'</div>';

				//$res = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix ."es_bcard  where chosen=1 and category_id=".$value['id'] ,"ARRAY_A");
				$res = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix ."es_bcard  where chosen=1 and category_id=%d",$value['id']),"ARRAY_A");
				$i=0;
					$class_see_more = count($res)>3 ? "block_see_more" : "";
				foreach($res as $k => $v){
					$i++;
					
					$href=get_permalink( ).'?cat='.$v["category_id"].'&id='.$v["id"];
					$class_hide = $i>3 ? "block_hide" : "";
					if($i>3 && $i<5){
						$html .='<div class="see_more"><span><a href="#" >See more...</a></span></div>';
					}
					
					$html .= '  <div class="card_block '.esc_attr( $class_hide ).' '.esc_attr( $class_see_more ).'">
								<a class="" href="'.esc_url( $href ).'">
									<img src="'.esc_url( plugins_url( 'img/'.$v['file_name'], __FILE__ ) ).'">
								</a>
							</div>';			

				}
							
				$html.='</div>';			
			}
		
		
		}else{

			//$count = $wpdb->get_results("SELECT count(*) as num FROM ".$wpdb->prefix ."es_bcard as tbl1 JOIN ".$wpdb->prefix ."es_category as tbl2 ON tbl1.category_id=tbl2.id where tbl1.chosen=1 and tbl1.category_id=".$category_id,"ARRAY_A");
			$count = $wpdb->get_results($wpdb->prepare("SELECT count(*) as num FROM ".$wpdb->prefix ."es_bcard as tbl1 JOIN ".$wpdb->prefix ."es_category as tbl2 ON tbl1.category_id=tbl2.id where tbl1.chosen=1 and tbl1.category_id=%d",$category_id),"ARRAY_A");

			$limit=5;			
			$count_pages = ceil($count[0]['num']/$limit);
			$start=empty($_GET['pag']) || $_GET['pag']>$count_pages ? 0 : $limit*($_GET['pag']-1);
			//$result = $wpdb->get_results("SELECT tbl1.id as tbl1_id,tbl1.*,tbl2.* FROM ".$wpdb->prefix ."es_bcard as tbl1 JOIN ".$wpdb->prefix ."es_category as tbl2 ON tbl1.category_id=tbl2.id where tbl1.chosen=1 and tbl1.category_id=".$category_id." LIMIT ".$start.",".$limit ,"ARRAY_A");
			$result = $wpdb->get_results($wpdb->prepare("SELECT tbl1.id as tbl1_id,tbl1.*,tbl2.* FROM ".$wpdb->prefix ."es_bcard as tbl1 JOIN ".$wpdb->prefix ."es_category as tbl2 ON tbl1.category_id=tbl2.id where tbl1.chosen=1 and tbl1.category_id=%d LIMIT %d , %d",$category_id,$start,$limit) ,"ARRAY_A");

			$active = empty($_GET['pag']) || $_GET['pag']>$count_pages ? 1 : $_GET['pag'];
			$count_show_pages = 5;			
			$url_page = get_permalink( )."?cat=".$category_id."&pag=";
			
			$html.=pagination($count_pages,$start,$active,$count_show_pages,$url_page);
			
		
		

			foreach ($result as $key => $value) {
				if($key==0){
					$cat_id = $value['category_id'];
					$html .='<div class="panel">
							<div class="panel_head">'.$value['category'].'</div>';
				}
				
				if($cat_id!=$value['category_id']){
					$html.='</div>';
					$html .='<div class="panel">
							<div class="panel_head">'.$value['category'].'</div>';
				}
				
				$href=get_permalink( ).'?cat='.$category_id.'&id='.$value["tbl1_id"];
				$html .= '  <div class="card_block">
								<a class="" href="'.esc_url( $href ).'">
									<img src="'.esc_url( plugins_url( 'img/'.$value['file_name'], __FILE__ ) ).'">
								</a>
							</div>';				

				
				$cat_id = $value['category_id'];
			}
			$html.='</div>';
			// echo "<pre>";
			// print_r($result);
		
		}
		
		$html .='</div>
				<a href="'.get_permalink( ).'?cat=" class="change_category"></a>
				';
	}
	
	return $html;
}

function Es_options_page(){
	// $page_title, $menu_title, $capability, $menu_slug, $function
	//add_options_page( 'Опции визитки', 'Опции визитки', 'manage_options', 'esterox-visitka-options', 'esterox_option_page' );
	add_menu_page( 'Business Card', 'Business Card', 'manage_options', 'es-bcard-options', 'Es_option_page', plugins_url( 'img/bs_icon.png', __FILE__ ) );
	add_submenu_page( 'es-bcard-options', 'All cards', 'All cards', 'manage_options', 'es-bcard-options', 'Es_option_page' );	
	add_submenu_page( 'es-bcard-options', 'Categories', 'Categories', 'manage_options', 'es-bcard-category','Es_category_page' );	
}

function Es_category_page(){
	global $wpdb;
	include(plugin_dir_path( __FILE__ ).'admin_category_view.php');
}

function Es_option_page(){
	global $wpdb;
	
	if(!empty($_GET['edit']) && is_numeric($_GET['edit'])){
		//$result = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix ."es_bcard where id=".sanitize_text_field( $_GET['edit'] ),"ARRAY_A");
		$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix ."es_bcard where id=%d",sanitize_text_field( $_GET['edit'] )),"ARRAY_A");
		if(!empty($result)){
			
			if(isset($_POST['edit'])){				
				$json=stripcslashes ( $_POST['img_data']);
				$json=sanitize_text_field( $json );

				$json1=json_decode($json,true);
				$string="";
				//var_dump($json1);exit;
				foreach($json1 as $key =>$value){
					
					$key1=$key+1;
					$string.='text'.$key1.':{';				
					
					foreach($value as $k =>$v){						
						if($k=='text'){						
						$v=str_replace("\n", "\\n",$v);						
							$string.='name:"'.$v.'",';
						}
						if(is_string($v)){
							$string.=$k.':"'.$v.'",';
						}else if($v==null){
							$string.=$k.':null,';
						}else{
							$string.=$k.':'.$v.',';
						}											
					}
					$string=substr($string, 0, -1);
					
					$string.='},';					
				}
				$string=substr($string, 0, -1);
				//$string=serialize($string);				
				//$string=json_encode($string);				
				$string=base64_encode($string);				

				//$query = "UPDATE ".$wpdb->prefix ."es_bcard SET file_text='".$string."' WHERE id=".sanitize_text_field( $_GET['edit'] )."";
				$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix ."es_bcard SET file_text='%s' WHERE id=%d",$string,sanitize_text_field( $_GET['edit'] )));
				
			}
			include(plugin_dir_path( __FILE__ ).'edit_business_card_admin.php');
		}else{
			include(plugin_dir_path( __FILE__ ).'admin_view.php');
		}
		
	}else{
		include(plugin_dir_path( __FILE__ ).'admin_view.php');		
	}	
}