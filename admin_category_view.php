<?php
if(isset($_POST['submit_cat'])){
	$category=sanitize_text_field( $_POST['add_cat'] );
	$query = "INSERT INTO ".$wpdb->prefix ."es_category (category,status,empty_card)
				  VALUES  (%s,'1','0')";
	$wpdb->query($wpdb->prepare($query,$category));
}

if(isset($_POST['edit_category'])){
	$id=sanitize_text_field( $_POST['edit_category'] );
	$index='edit_cat_'.$id;
	$category=sanitize_text_field( $_POST[$index] );
	$query = "UPDATE ".$wpdb->prefix ."es_category SET category='%s' WHERE id=%d";
	$wpdb->query($wpdb->prepare($query,$category,$id));
}

if(isset($_POST['dis_an_id'])){
	$id=sanitize_text_field( $_POST['dis_an_id'] );
	$status=sanitize_text_field( $_POST['dis_an_status'] );
	$query = "UPDATE ".$wpdb->prefix ."es_category SET status='%d' WHERE id=%d";
	$wpdb->query($wpdb->prepare($query,$status,$id));
}

if(isset($_POST['del_category'])){
	$id=sanitize_text_field( $_POST['del_category'] );
	$result = $wpdb->get_results($wpdb->prepare("SELECT file_name FROM ".$wpdb->prefix ."es_bcard where category_id=%d",$id),"ARRAY_A");
	if(!empty($result)){
		foreach($result as $key => $value){
			$file_name = $value['file_name'];					
			unlink(plugin_dir_path( __FILE__ ).'img/'.$file_name);
		}
	}
	$query ="DELETE FROM ".$wpdb->prefix ."es_bcard WHERE category_id = %d ";
	$wpdb->query($wpdb->prepare($query,$id));
	
	$query ="DELETE FROM ".$wpdb->prefix ."es_category WHERE id = %d ";
	$wpdb->query($wpdb->prepare($query,$id));
}

$res = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix ."es_category ORDER BY category",array()),"ARRAY_A");
?>

<div class="wrap">
	<h2>All categories</h2>
	<button id="new_cat">New category</button>
	<form action="" method="post" id="add" style="display:none;">
		<input type="text" name="add_cat" placeholder="category name" required />
		<span class="add_cat_button_wrap"><input class="add_cat_button" type="submit" name="submit_cat" value="add category" />	</span>
	</form>
	<form action="" method="post" id="edit" >
		<table>
			<tr>
				<th>Category name</th>
				<th>Action</th>
			</tr>
			<?php foreach ($res as $value) { ?>
			<tr>
				<td>
					<span id="old_cat_<?php echo $value['id'];?>" ><?php echo $value['category'];?></span>
					<input class="edit_cat" key="<?php echo $value['id'];?>" id="new_cat_<?php echo $value['id'];?>" type="text" name="edit_cat_<?php echo $value['id'];?>" style="display:none;" />					
				</td>
				<td>
					<input type="button" key="<?php echo $value['id'];?>" class="edit" value="Edit" />
					<input type="button" status="<?php echo $value['status'];?>" key="<?php echo $value['id'];?>" class="dis_an" value="" />
					<img key="<?php echo $value['id'];?>" class="del_img del_cat" src="<?php echo esc_url( plugins_url('img/delete-icon.png', __FILE__ ) ) ?>" alt="delete" >
				</td>
			</tr>
			<?php } ?>
		</table>
	</form>
	
</div>
