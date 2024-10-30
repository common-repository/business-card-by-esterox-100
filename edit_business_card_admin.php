<?php
global $wpdb;		
$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix ."es_bcard where id=%d",sanitize_text_field( $_GET['edit'] )),"ARRAY_A");
$ob=base64_decode($result[0]['file_text']);
//$ob=json_decode($result[0]['file_text']);
//$ob=unserialize ($result[0]['file_text']);
//var_dump($result[0]['file_text']);

//test
?>
<div class="site_container" style="overflow:visible;background: #fff;   padding-bottom: 50px;">
	<div class="inner_container">
		<div class="">
		<div class="print_forms_top">
		<div class="left_cont_head">
		 <h3  style="text-align: center;">Enter your information</h3>
		</div>
		  
				<div class="custom_editor">
				 <h3>Edit the template - and create your own business card!</h3>
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
					   <p title="Align left"><img src="<?php echo esc_url( plugins_url('img/AlignTextLeft.png', __FILE__ ) ); ?>"></p>
					</div>
					<div class="text_align_center">
						<p title="Align center"><img src="<?php echo esc_url( plugins_url('img/AlignTextCenter.png', __FILE__ ) ); ?>"></p>
					</div>
					<div class="text_align_right">
						<p title="Align right"><img src="<?php echo esc_url( plugins_url('img/AlignTextRight.png', __FILE__ ) ); ?>"></p>
					</div>
					<div class="select_color">
						<!--<button class="select_color_imput">df</button>-->
						<input title="Text color" type="color" value="#fff000" class="select_color_input" style="width:22px;height:22px;">
					</div>
					<div class="save_canvas" style="display:none;">
						<p title="Save changes"><img src="<?php echo esc_url( plugins_url('img/Save-as-icon.png', __FILE__ ) );?>"></p>
					</div>
					
				</div>
		</div>
				<div class="print_forms_right">
				
				<div class="canvas1_container" style="display: block;">			
					<canvas id="myCanvas"  width="550" height="300" class="lower-canvas" style="position: absolute; width: 550px; height: 300px; left: 0px; top: 0px; -webkit-user-select: none;"></canvas>					
				</div>
				<div class="canvas2_container" style="display: none;">			
					<canvas id="revers_myCanvas" style="position: absolute; width: 550px; height: 300px; left: 0px; top: 0px; -webkit-user-select: none;" width="550" height="300" class="lower-canvas"></canvas>			
				</div>
				
						
				<div class="save_butt">
					<form id="image_data_form" action="" method="post">
						<input type="hidden" class="img_data" name="img_data" value=''>
						
						<input type="submit" name="edit" id="edit" class="button button-primary" value="Save changes">				
					</form>					
				</div>
				<p> 
				 <a class="back_butt" href="<?php echo esc_url( $_SERVER['REQUEST_URI'].'-' );?>" class="btn btn-primary">Back</a>
				</p>				
			</div>
		<div class="print_forms_left">

					<div class="print_forms_left_head"><h3>Enter your information</h3></div>
					<div class="print_forms_left_body">
						<span class="pr print_text_wrapper">
							<textarea placeholder="Company name" class="text1 h30"></textarea>
							<span key="text1" class="remove_text"></span>
						</span>
						<span class="pr print_text_wrapper">
							<textarea placeholder="Address" class="text2 h30"></textarea>
							<span key="text2" class="remove_text"></span>
						</span>
						<span class="pr print_text_wrapper">
							<textarea placeholder="Website name" class="text3 h30" style="max-width"></textarea>
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
				</div>	
	
			
			
			

		</div>
		<script type="text/javascript"> 
			window.item_id_ = <?php echo $_GET['edit'];?>;
			window.base_url = "<?php echo plugins_url( '', __FILE__ );?>";
			
			var cards = {
		<?php echo $result[0]['id'];?>:{
						big_img: "/img/<?php echo $result[0]['file_name'];?>",				
						small_img: "",				
						<?php  echo $ob;?>						
					}					
				}
				
		</script>
	</div>
</div>