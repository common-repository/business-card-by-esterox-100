<?php
global $wpdb;
$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix ."es_bcard where chosen=1",array()),"ARRAY_A");
$ob2="";
foreach ($result as $value) {
	$ob=base64_decode ($value['file_text']);
	$ob2.=$value['id'].':{	
	big_img: "/img/'.$value['file_name'].'",	
	small_img: "",'.	
	$ob			
	.'},';	
}
$ob2=substr($ob2, 0, -1);//var_dump($ob2);
$href= esc_url( $_SERVER['REQUEST_URI'].'-' );

if(!empty($_GET['cat'])){
	$category_id=sanitize_text_field( $_GET['cat'] );
}

$result_popup = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix ."es_bcard where chosen=1 and category_id=%d",$category_id),"ARRAY_A");
$popup='<div  class="reverse_side_popup popup">			<span class="close_popup"></span>			<h2 style="text-align:center;">Reverse side</h2>			<div class="reverse_popup_middle">';foreach ($result_popup as $value) {		$popup .= ' <div class="card_block" item_id="'.$value["id"].'" big_img="img/'.$value['file_name'].'" small_img="" text1="Array" text2="Array" text3="Array" text4="Array" text5="Array" text6="Array">					<img class="add_reverse_side" src="'.esc_url( plugins_url( 'img/'.$value['file_name'], __FILE__ ) ).'" width="200">				</div> ';			}$popup.='</div>			</div>';
$html='<div  class="site_container" style="overflow:visible;background: #fff">
	<div class="im">
		 <h2 style="text-align: center;">Edit the template - and create your own business card!</h2>
		<div class="print_forms">
		<div class="print_forms_top">
		<div class="left_cont_head">
		 <h3 style="text-align: center;">Enter your information</h3>
		</div>
		
			<div class="custom_editor">
			    <h3>Text</h3> 
					<select class="fonts">
						<option></option>
						<option value="Arial,Arial,Helvetica,sans-serif">Arial</option>
						<option value="Arial Black,Arial Black,Gadget,sans-serif">Arial Black</option>
						<option value="Comic Sans MS,Comic Sans MS,cursive">Comic Sans MS</option>
						<option value="Courier New,Courier New,Courier,monospace">Courier New</option>
						<option value="Georgia,Georgia,serif">Georgia</option>			
						<option value="Impact,Charcoal,sans-serif">Impact</option>			
						<option value="Lucida Sans Unicode,Lucida Grande,sans-serif">Lucida Sans Unicode</option>
						<option value="Palatino Linotype,Book Antiqua,Palatino,serif">Palatino Linotype</option>
						<option value="Tahoma,Geneva,sans-serif">Tahoma</option>		
						<option value="Times New Roman,Times,serif">Times New Roman</option>										
						<option value="Trebuchet MS,Helvetica,sans-serif">Trebuchet MS</option>		
						<option value="Verdana,Geneva,sans-serif">Verdana</option>			
						<option value="Gill Sans,Geneva,sans-serif">Gill Sans</option>			
					</select>
					<select class="font_size">
						<option></option>
											<option value="8">8</option>
											<option value="10">10</option>
											<option value="12">12</option>
											<option value="14">14</option>
											<option value="16">16</option>
											<option value="18">18</option>
											<option value="20">20</option>
											<option value="22">22</option>
											<option value="24">24</option>
											<option value="26">26</option>
											<option value="28">28</option>
											<option value="30">30</option>
											<option value="32">32</option>
											<option value="34">34</option>
											<option value="36">36</option>
									</select>
					<div class="bold_block">
						<p title="Bold"><b>B</b></p>
					</div>
					<div class="italic_block">
						<p title="Italic"><b>I</b></p>
					</div>
					<div class="text_align_left">
						<p title="Align left"><img src="'. esc_url( plugins_url('img/AlignTextLeft.png', __FILE__ ) ).'"></p>
					</div>
					<div class="text_align_center">
						<p title="Align center"><img src="'. esc_url( plugins_url('img/AlignTextCenter.png', __FILE__ ) ).'"></p>
					</div>
					<div class="text_align_right">
						<p title="Align right"><img src="'. esc_url( plugins_url('img/AlignTextRight.png', __FILE__ ) ).'"></p>
					</div>
					<div class="select_color">
						<!--<button class="select_color_imput">df</button>-->
						<input type="color" value="#fff000" class="select_color_input">
					</div>
					<div class="select_bg_color">
						<input title="Add background color" type="color" value="#fff000" class="select_bg_color_input">
					</div>
					<div class="select_image">
						<p title="Add logo">
						<label for="select_canvas_image"><img src="'. esc_url( plugins_url('img/image_icon.gif', __FILE__ ) ) . '"/></label>
						</p>
						<input type="file" id="select_canvas_image" class="select_canvas_image" style="display:none;" name="select_canvas_image">
					</div>
					<div class="select_bg_image">
						<p title="Add background color">
						<label for="select_canvas_bg_image"><img src="'.esc_url( plugins_url('img/image_icon.gif', __FILE__ ) ) . '"/></label>
						</p>
						<input type="file" id="select_canvas_bg_image" class="select_canvas_bg_image" style="display:none;" name="select_canvas_bg_image">
					</div>
					<div class="save_canvas">
						<p title="Save Changes">
					<img src="'. esc_url( plugins_url('img/Save-as-icon.png', __FILE__ ) ) . '"/>
					
						</p>
					</div>
				</div>
				<div class="logo_block" ><h3>Logo</h3> </div>
				<div class="bg_block" ><h3>Background</h3> </div>
		</div>
		
		
		
	
		
				
			<div class="print_forms_right">
				

				<div class="canvas1_container" style="display: block;">			
					<canvas id="myCanvas"  width="550" height="300" class="lower-canvas" style="position: absolute; width: 550px; height: 300px; left: 0px; top: 0px; -webkit-user-select: none;"></canvas>					
				</div>
				<div class="canvas2_container" style="display: none;">			
					<canvas id="revers_myCanvas" style="position: absolute; width: 550px; height: 300px; left: 0px; top: 0px; -webkit-user-select: none;" width="550" height="300" class="lower-canvas"></canvas>			
				</div>
				
				
				
				<div class="ordered_images_block">
					<span style="display:inline-block; float:left;">
						<img style="max-width: 80px; heigt:42px; cursor: pointer;" class="image_1" src="">
						<span class="image_1_link" style="color: #666;font-size:14px;cursor:pointer; margin-top:14px; display:block; text-align:center;line-height: 13px;">Front side</span>
					</span>
					<span style="position:relative;display:none;margin-left:35px; float:left;">
						<img style="max-width: 80px; height:42px; display:none;cursor:pointer; " class="image_2">
						<span class="image_2_link" style="color: #666;font-size:14px;cursor:pointer; margin-top:22px; display:block; text-align:center;line-height: 13px;">Back side</span>
						<span class="remove_revers_img"></span>
					</span>

					<span class="add_reverse_side_block">
						<h3 class="add_edit_re_text" >Add back side</h3>
						
						<a style="" class="add_reverse_side_btn" href="">Back side</a>
					</span>

				</div>
				<div class="for_but">
				<a style="margin-top:20px; transition: background 0.3s;" href="'.$href.'" class=" btn-primary button-primary ">Back</a>				<a style="margin-top:20px; transition: background 0.3s;" href="" class=" btn-primary button-primary reset">Reset</a>
				<button style="margin:20px 0 0 20px;" class="btn-primary button-primary apply_print_forms_item">Download</button>
				</div>
							
			</div>	
			
			
			
			
					<div class="print_forms_left">
					<div class="print_forms_left_head"><h3>Enter your information</h3></div>
					<div class="inf_1 print_forms_left_body">
						<span class="pr print_text_wrapper">
							<textarea placeholder="Company name" class="text1 h30"></textarea>
							<span key="text1" class="remove_text"></span>
						</span>
						<span class="pr print_text_wrapper">
							<textarea placeholder="Address" class="text2 h30"></textarea>
							<span key="text2" class="remove_text"></span>
						</span>
						<span class="pr print_text_wrapper">
							<textarea placeholder="Website name" class="text3 h30"></textarea>
							<span key="text3" class="remove_text"></span>
						</span>
						<span class="pr print_text_wrapper">
							<textarea placeholder="Full Name" class="text4 h30"></textarea>
							<span key="text4" class="remove_text"></span>
						</span>
						<span class="pr print_text_wrapper">
							<textarea placeholder="Position" class="text5 h30"></textarea>
							<span key="text5" class="remove_text"></span>
						</span>
						<span class="pr print_text_wrapper">
							<textarea placeholder="Phone" class="text6 h30"></textarea>
							<span key="text6" class="remove_text"></span>
						</span>
					</div>
					<div class="inf_2" style="display:none;">
						<span class="pr print_text_wrapper">
							<textarea placeholder="Website name" class="text1_2 h30"></textarea>
							<span key="text1_2" class="remove_text"></span>
						</span>
						<span class="pr print_text_wrapper">
							<textarea placeholder="Address" class="text2_2 h30"></textarea>
							<span key="text2_2" class="remove_text"></span>
						</span>
						<span class="pr print_text_wrapper">
							<textarea placeholder="Website name" class="text3_2 h30"></textarea>
							<span key="text3_2" class="remove_text"></span>
						</span>
						<span class="pr print_text_wrapper">
							<textarea placeholder="Full Name" class="text4_2 h30"></textarea>
							<span key="text4_2" class="remove_text"></span>
						</span>
						<span class="pr print_text_wrapper">
							<textarea placeholder="Position" class="text5_2 h30"></textarea>
							<span key="text5_2" class="remove_text"></span>
						</span>
						<span class="pr print_text_wrapper">
							<textarea placeholder="Phone" class="text6_2 h30"></textarea>
							<span key="text6_2" class="remove_text"></span>
						</span>
					</div>
	
				</div>	
			
			<form id="image_data_form">
				<input type="hidden" class="img_data" name="img_data" value="">
			</form>

		</div>
		<script type="text/javascript">
			window.popup = \''.$popup.'\';						window.item_id_ = '.$_GET['id'].';
			window.base_url = "'.plugins_url( '', __FILE__ ).'";
			
			var cards = {'.
						$ob2
					.'}					
				
			
		</script>
	</div>
</div>';