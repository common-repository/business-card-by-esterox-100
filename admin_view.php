<?php
if(isset($_POST['remove_key'])){
	$id=sanitize_text_field( $_POST['remove_key'] );
	$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix ."es_bcard where id=%d",$id),"ARRAY_A");
	$file_name = $result[0]['file_name'];
	$category_id = $result[0]['category_id'];
	$query ="DELETE FROM ".$wpdb->prefix ."es_bcard WHERE id = %d ";
	$wpdb->query($wpdb->prepare($query,$id));
	unlink(plugin_dir_path( __FILE__ ).'img/'.$file_name);
	//var_dump($category_id);
	$count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM ".$wpdb->prefix ."es_bcard where category_id=%d",$category_id));
	
	if($count==0){		
		$query = "UPDATE ".$wpdb->prefix ."es_category SET empty_card='0' WHERE id=%d";
		$wpdb->query($wpdb->prepare($query,$category_id));
	}
}

if(isset($_POST['submit'])){
	$cat_array_id = $_POST['category'] ;
	$cat_id = sanitize_text_field( $_GET['cat'] );
	if(empty($cat_id) || $cat_id=='all'){
		$query ="UPDATE ".$wpdb->prefix ."es_bcard SET chosen = '0' WHERE category_id IN (".implode(',',$cat_array_id).") ";
	}else{
		$query ="UPDATE ".$wpdb->prefix ."es_bcard SET chosen = '0' WHERE category_id=".$cat_id;
	}	
	$wpdb->query($wpdb->prepare($query,array()));
	//var_dump($cat_id,$cat_array_id);
	if(isset($_POST['chosen'])){
		$chosen =  $_POST['chosen'] ;

//var_dump($cat_id);
//var_dump($chosen);
		$query ="UPDATE ".$wpdb->prefix ."es_bcard SET chosen = '1' WHERE id IN (".implode(',',$chosen).") ";
		$wpdb->query($wpdb->prepare($query,array()));
	}
			
}

if(isset($_POST['esterox_visita_bg_add'])){
	if($_FILES['esterox_visita_bg']['error']===0){
		$cat_id = sanitize_text_field( $_POST['category'] );
		$string="0123456789abcdefghijklmnopqrstuvwxyz";	
		$str = "";	
		for($i = 0; $i < 10; $i++) {		
			$index = mt_rand(0, 35);	
			$str .= $string[$index];
		}
		$file_name=sanitize_file_name( $_FILES["esterox_visita_bg"]["name"] );
		$pos = strrpos($file_name, ".");
		$file_name=substr($file_name, $pos);
	
		$tmp_name = $_FILES["esterox_visita_bg"]["tmp_name"];
		$name = $str.$file_name;
		move_uploaded_file($tmp_name, plugin_dir_path( __FILE__ ).'img/'.$name);
		
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
		//$file_text=json_encode($ob);
		$file_text=base64_encode($ob);
		
		$query = "UPDATE ".$wpdb->prefix ."es_category SET empty_card='1' WHERE id=%d";
		$wpdb->query($wpdb->prepare($query,$cat_id));

		$query = "INSERT INTO ".$wpdb->prefix ."es_bcard (file_name,file_text,chosen,category_id)
				  VALUES  (%s,%s,'1',%d)";
		$wpdb->query($wpdb->prepare($query,$name,$file_text,$cat_id));
		//var_dump($cat_id,$name,$file_text);
		$lastid = $wpdb->insert_id;
		$href= $_SERVER['REQUEST_URI'].'&edit='.$lastid  ;
		header("location:".$href);
	}
	
}	
?>
<div class="wrap">
	<h2>Cards settings option</h2>
	<form action="" method="post" enctype="multipart/form-data">
		<div>
			<label for="esterox_visita_id">Download Image</label>
			<input type="file" name="esterox_visita_bg" id="esterox_visita_id">
			<input style="visibility: hidden;" type="submit" name="esterox_visita_bg_add" value="добавить фон" id="esterox_visita_bg_add">			<input type="checkbox" name="check_all" value="1" id="check_all">			
			<label for="check_all">select all</label>
			
			<label for="category">Card Category:</label>
			<?php $res = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix ."es_category where status=1 ORDER BY category",array()),"ARRAY_A"); ?>
			<select id="category" name="category">
				<option value="all">All</option>
				<?php foreach ($res as $value) { ?>
					<option <?php echo isset($_GET['cat']) && $_GET['cat']==$value['id']   ? 'selected' : ''; ?> value="<?php echo $value['id']; ?>"><?php echo $value['category']; ?></option>
				<?php } ?>
			</select>
			
		</div>		
		<?php 
		//var_dump($res[0]['id']);
		if(!empty($_GET['cat'])){
			$category_id=sanitize_text_field( $_GET['cat'] );
		}else{
			$category_id='all';
		}
		
		if($category_id=='all'){
			//$count = $wpdb->get_results("SELECT count(*) as num FROM ".$wpdb->prefix ."es_bcard as tbl1 right JOIN ".$wpdb->prefix ."es_category as tbl2 ON tbl1.category_id=tbl2.id where  tbl2.status=1 ORDER BY tbl2.category","ARRAY_A");		
			$count = $wpdb->get_results($wpdb->prepare("SELECT count(*) as num FROM ".$wpdb->prefix ."es_category  where  status=1 ",array()),"ARRAY_A");
			
			$limit=3;			
			$count_pages = ceil($count[0]['num']/$limit);
			$start=empty($_GET['pag']) || $_GET['pag']>$count_pages ? 0 : $limit*($_GET['pag']-1);
			//$result = $wpdb->get_results("SELECT tbl1.id as tbl1_id,tbl2.id as tbl2_id,tbl1.*,tbl2.* FROM ".$wpdb->prefix ."es_bcard as tbl1 right JOIN ".$wpdb->prefix ."es_category as tbl2 ON tbl1.category_id=tbl2.id where  tbl2.status=1 ORDER BY tbl2.category LIMIT ".$start.",".$limit ,"ARRAY_A");		
			$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix ."es_category  where  status=1 ORDER BY category LIMIT %d ,%d",$start,$limit ),"ARRAY_A");
						
			$active = empty($_GET['pag']) || $_GET['pag']>$count_pages ? 1 : $_GET['pag'];
			$count_show_pages = 5;			
			$url_page = get_permalink( )."?page=es-bcard-options&cat=".$category_id."&pag=";
			
			$html.=pagination($count_pages,$start,$active,$count_show_pages,$url_page);	
			
			foreach ($result as $key => $value) {
				$html .='<div class="panel">
							<div class="panel_head"><input type="hidden" name="category[]" id="" value="'.$value['id'].'">'.$value['category'].'</div>';
			
				$res = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix ."es_bcard  where  category_id=%d",$value['id'] ),"ARRAY_A");
				$i=0;
					$class_see_more = count($res)>4 ? "block_see_more" : "";
				foreach($res as $k => $v){
					$i++;
					$checked = $v['chosen']==1 ? 'checked' : '';					
					$href=esc_url( $_SERVER['REQUEST_URI'].'&edit='.$v["id"] );
					$class_hide = $i>4 ? "block_hide" : "";
					if($i>4 && $i<6){
						$html .='<div class="see_more"><span><a href="#" >See more...</a></span></div>';
									}
					$html .= '<div class="block pr print_text_wrapper '.esc_attr( $class_hide ).' '.esc_attr( $class_see_more ).'" style="">
								<label for="'.$v['id'].'"><img style="width:100%;height:100%;" src="'.esc_url( plugins_url( 'img/'.$v['file_name'], __FILE__ ) ).'" /></label>
								<span key="'.$v["id"].'" class="remove_fon" title="delete"></span>						
								<input type="checkbox" name="chosen[]" value="'.$v['id'].'" id="'.$v['id'].'" '.esc_attr( $checked ).'>
								<a class=" edit btn btn-primary " href="'.$href.'">Edit</a>
							  </div>';				

				}
							
				$html.='</div>';			
			}					
			
			echo $html;
			
		}else{
			$count = $wpdb->get_results($wpdb->prepare("SELECT count(*) as num FROM ".$wpdb->prefix ."es_bcard as tbl1 right JOIN ".$wpdb->prefix ."es_category as tbl2 ON tbl1.category_id=tbl2.id where  tbl2.id=%d",$category_id),"ARRAY_A");
			
			$limit=5;			
			$count_pages = ceil($count[0]['num']/$limit);
			$start=empty($_GET['pag']) || $_GET['pag']>$count_pages ? 0 : $limit*($_GET['pag']-1);
			$result = $wpdb->get_results($wpdb->prepare("SELECT tbl1.id as tbl1_id,tbl1.*,tbl2.* FROM ".$wpdb->prefix ."es_bcard as tbl1 right JOIN ".$wpdb->prefix ."es_category as tbl2 ON tbl1.category_id=tbl2.id where  tbl2.id=%d LIMIT %d ,%d ",$category_id,$start,$limit) ,"ARRAY_A");
						
			$active = empty($_GET['pag']) || $_GET['pag']>$count_pages ? 1 : $_GET['pag'];
			$count_show_pages = 5;			
			$url_page = esc_url( get_permalink( )."?page=es-bcard-options&cat=".$category_id."&pag=" );
			
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
				if(!empty($value["tbl1_id"])){
					$checked = $value['chosen']==1 ? 'checked' : '';
					//$href=get_permalink().'?edit='.$value["id"];
					$href=esc_url( $_SERVER['REQUEST_URI'].'&edit='.$value["tbl1_id"] );
					$html .= '<div class="block pr print_text_wrapper" style="">											
								<label for="'.$value['tbl1_id'].'"><img style="width:100%;height:100%;" src="'.esc_url( plugins_url( 'img/'.$value['file_name'], __FILE__ ) ).'" /></label>
								<span key="'.$value["tbl1_id"].'" class="remove_fon" title="delete"></span>						
								<input type="checkbox" name="chosen[]" value="'.$value['tbl1_id'].'" id="'.$value['tbl1_id'].'" '.esc_attr( $checked ).'>
								<a class=" edit btn btn-primary " href="'.$href.'">Edit</a>
							  </div>';				
				}
				$cat_id = $value['category_id'];
			}
			$html.='</div>';			
			
			echo $html;
		}
		?>
		<?php submit_button(); ?>
	</form>
	<form action="" method="post" class="remove_fon_form" >
		<input type="hidden" name="remove_key" id="remove_key" value="">
	</form>
	<a href="<?php echo esc_url( get_permalink( ) );?>?page=es-bcard-options&cat=" class="change_category"></a>
</div>
