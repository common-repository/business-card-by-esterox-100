jQuery(document).ready(function($){
		if(typeof item_id_ !== "undefined"){
			if(localStorage.getItem(item_id_ + '_curent1') != null){
				var current1_json = localStorage.getItem(item_id_ + '_curent1');
				window.canvas1.loadFromJSON(current1_json,window.canvas1.renderAll.bind(window.canvas1));
				for(var i in canvas1._objects){
					var index = parseInt(i) + 1;
					canvas1._objects[i].key = "text" + index;
					
					//console.log(i);
					var j=Number(i)+1;
					var currentText = 'text'+j;
					
					$('.inf_1 .'+currentText).val(localStorage.getItem(item_id_ + '_1_'+currentText));
					
				}
				
				var k=6-Object.keys(canvas1._objects).length;
				//console.log(k);
				
				for(var i=0;i<k;i++){
					var j=Object.keys(canvas1._objects).length+1+i;
					var currentText = 'text'+j;
					$('.inf_1 .'+currentText).parent().remove();
				}
				
			}
		}
		if($('.canvas2_container').is(':visible')){		
			if(localStorage.getItem(item_id_ + '_curent2') != null){
				var current2_json = localStorage.getItem(item_id_ + '_curent2');
				window.canvas2.loadFromJSON(current2_json,window.canvas2.renderAll.bind(window.canvas2));
				for(var i in canvas2._objects){
					var index = parseInt(i) + 1;
					canvas2._objects[i].key = "text" + index;
					
					//console.log(i);
					var j=Number(i)+1;
					var currentText = 'text'+j;
					$('.inf_2 .'+currentText).val(localStorage.getItem(item_id_ + '_2_'+currentText));
					
				}
				
				var k=6-Object.keys(canvas2._objects).length;
				//console.log(k);
				
				for(var i=0;i<k;i++){
					var j=Object.keys(canvas2._objects).length+1+i;
					var currentText = 'text'+j;
					$('.inf_2 .'+currentText).parent().remove();
				}
				
			}
		}
		setTimeout(function(){
			$('.save_canvas').click();
		}, 1000);
		
		$('.inf_1 .remove_text').click(function(){
			var ob=canvas1.getObjects();
			//console.log(ob);
			var text_key = $(this).attr('key');
			for(var i in ob){
				var key = ob[i].key;
				if(key == text_key){
					canvas1.remove(ob[i]);					
				}
			}
			canvas1.renderAll();
			//console.log(ob);
			$(this).parent().remove();
			//$('.save_canvas').click();
						
		});
		
		$('.inf_2 .remove_text').click(function(){
			var ob=canvas2.getObjects();
			var text_key = $(this).attr('key');
			for(var i in ob){
				var key = ob[i].key;
				if(key == text_key){					
					canvas2.remove(ob[i]);
				}
			}
			canvas2.renderAll();
			$(this).parent().remove();
				
		});
		
		$('.image_2_link').click(function(){
			$('.image_2').click();
		});
		$('.image_1_link').click(function(){
			$('.image_1').click();
		});
		
		$('.remove_revers_img').click(function(){
			localStorage.removeItem(item_id_ + '_2');
			localStorage.removeItem(item_id_ + '_reverse_id');
			localStorage.removeItem(item_id_ + '_curent2');
			$('.add_edit_img').attr('src', base_url + '/img/add_edit_img.png');
			$('.image_2').hide();
			$('.image_2').parent().hide();
			$('.canvas1_container').show();
			$('.inf_1').show();
			$('.canvas2_container').hide();
			$('.inf_2').hide();
			$('.add_reverse_side_block').show();
		});
		
		
		$('.apply_print_forms_item').on('click',function(event){
			//event.stopPropagation();
			$('.save_canvas').click();
			
			window.downloadFile = function(sUrl,name) {
				//Creating new link node.
				var link = document.createElement('a');
				link.href = sUrl;
		 
				if (link.download !== undefined){
					//Set HTML5 download attribute. This will prevent file from opening if supported.
					//var fileName = sUrl.substring(sUrl.lastIndexOf('/') + 1, sUrl.length);
					link.download = name;
				}
		 
				//Dispatching click event.
				if (document.createEvent) {
					var e = document.createEvent('MouseEvents');
					e.initEvent('click' ,true ,true);
					link.dispatchEvent(e);
					return true;
				}
				
			 
				// Force file download (whether supported by server).
				var query = '?download';
			 
				window.open(sUrl + query, '_self');
			} 
			
			if(localStorage.getItem(item_id_ + '_1') != null){ 
				var img_binar_data1 = localStorage.getItem(item_id_ + '_1');	

				window.downloadFile(img_binar_data1,'front_side.png');
			}
			
			if(localStorage.getItem(item_id_ + '_2') != null){ 
				var img_binar_data2 = localStorage.getItem(item_id_ + '_2');	

				window.downloadFile(img_binar_data2,'back_side.png');
			}
			
			
		});






	jQuery(document).on('click', '.add_reverse_side', function(){
			$('.save_canvas').click();
			var attrs_obj = $(this).parents('.card_block');
			var id = attrs_obj.attr('item_id');
			if(typeof canvas2 != "undefined"){
				canvas2.clear();
			}
			var obj = cards[id];
			//console.log(id,cards[id]);
			$('.add_edit_img').attr('src', base_url + obj.big_img);
			localStorage.setItem(item_id_ + '_reverse_id', id);
			build_canvas_obj2(id);
			tmp('_2');
			$('.close_popup').click();
			setTimeout(function(){
					$('.save_canvas').click();
					//location.reload();
					$('.image_2').click();
			}, 10);
			
			$('.add_reverse_side_block').hide();
		});		
		$(document).on('click','.close_popup', function(){	
			$(this).parents('.popup').remove();		
			$('.mask').remove();
		});
		$('.add_reverse_side_btn,.add_edit_re_text').click(function(){
			$(document).scrollTop(100);
			$('body').append('<div class="mask"></div>');
			$('body').append(popup);

			return false;
		});
		
		$('.reset').click(function(){				var myStr=item_id_+'_';			var regex = new RegExp('^'+myStr,'i');
			Object.keys(localStorage).forEach(function(key){			  				   if (regex.test(key)) {					   localStorage.removeItem(key);				   }			   });
		});
		
		if($('.image_2').is(':visible')){
			$('.add_reverse_side_block').hide();
		}
		
		
		
		if($('.site_container').width() < 940){
			$('.print_forms_left').addClass('print_forms_left_media');
			$('.print_forms_right').addClass('print_forms_right_media');
			$('.left_cont_head').hide();
			$('.print_forms_left_head h3').show();
			$('.custom_editor').css({"border": "none", "margin-left": "35px" }).addClass('hidden');
			$('.for_but').css({"float": "right", "margin": "75px 0 0 0" })
			$('.ordered_images_block').css({"float": "left"})
			
		}
		
		
		$(".see_more a").click(function(){
				var valu = $(".see_more").parent().children(".panel_head").children().val();
				$("#category").val(valu).change();
				
			});
		

		
	});

(function($){
	
	$(document).on('change','#category',function(){
		var category_key = $(this).val();
		var href = $(".change_category").attr('href');
		location.href=href+category_key;		
	});
	
	
	if(typeof item_id_ !== "undefined"){
			obj = cards[item_id_];
			//console.log(obj);
			for(var i=2; i<Object.keys(obj).length;i++){ 		
				//console.log(Object.keys(obj).length);
				var j=i-1;
				var currentText = 'text'+j;				
				$('.inf_1 .'+currentText).text(obj[currentText].name);
				//$('.'+currentText).attr('placeholder',obj[currentText].name);				
			}
			var k=6-Object.keys(obj).length+2;
			//console.log(k);
				
			for(var i=0;i<k;i++){
				var j=Object.keys(obj).length-1+i;
				var currentText = 'text'+j;
				$('.inf_1 .'+currentText).parent().remove();
			}
	}	
	
	
	
	
	$('.image_1').click(function(){
		$('.save_canvas').click();
		var current1_json = localStorage.getItem(item_id_ + '_curent1');
		window.canvas1.loadFromJSON(current1_json,window.canvas1.renderAll.bind(window.canvas1));
		
		$('.inf_1 .remove_text').each(function(){
			var text_key = $(this).attr('key');
			var ob=canvas1.getObjects();
			var t=false;
			
			for(var i in ob){
				var index = parseInt(i) + 1;
				var key = localStorage.getItem(item_id_ +'_key'+index+ '_curent1');
				ob[i].key = key;
				//console.log(ob[i]);
				//alert(key);
				if(key == text_key){
					$(this).prev().text(ob[i].text);
					t=true;
				}
			}
			
			if(!t){
				$(this).parent().remove();
			}
			
			
		});
		
		
		
		//console.log(canvas1.backgroundImage);alert(canvas1.backgroundColor);
		
		$('.canvas1_container').show();
		$('.inf_1').show();
		$('.canvas2_container').hide();
		$('.inf_2').hide();
		
		if(canvas1.backgroundColor!=''){
			//canvas1.backgroundImage = 0;
			canvas1.backgroundImage.visible = false;
		}
		
		
	});
	$('.image_2').click(function(){
		$('.save_canvas').click();
		var current2_json = localStorage.getItem(item_id_ + '_curent2');
		
		if(typeof canvas2 == "undefined"){
			canvas2 = new fabric.Canvas('revers_myCanvas');
		}
		window.canvas2.loadFromJSON(current2_json,window.canvas2.renderAll.bind(window.canvas2));
		
		$('.inf_2 .remove_text').each(function(){
			var text_key = $(this).attr('key');
			var ob=canvas2.getObjects();
			var t=false;
			
			for(var i in ob){
				var index = parseInt(i) + 1;				
				var key = localStorage.getItem(item_id_ +'_key'+index+ '_curent2');
				ob[i].key = key;
				//console.log(ob[i]);
				//alert(key);
				if(key == text_key){
					$(this).prev().text(ob[i].text);
					t=true;
				}
			}
			
			if(!t){
				$(this).parent().remove();
			}
			
			
		});
		
		
		
		$('.canvas1_container').hide();
		$('.inf_1').hide();		
		$('.canvas2_container').show();
		$('.inf_2').show();
		
		
		canvas2.on('object:moving',function(e){
			if(e.target.type == "image"){
				var activeObject = e.target;
				jQuery(".delete_canvas_img").remove(); 
				var btnLeft = activeObject.get('left');//e.target.oCoords.mt.x;
				var btnTop = activeObject.get('top') -35;//e.target.oCoords.mt.y - 25;
				var widthadjust=e.target.width/2;
				btnLeft=widthadjust+btnLeft+55;
				var delete_canvas_img = '<p" class="delete_canvas_img" style="color:white;position:absolute;top:'+btnTop+'px;left:'+btnLeft+'px;cursor:pointer;" title="Удалить"></p>';
				jQuery(".canvas2_container .canvas-container").append(delete_canvas_img);
			}
		});
		canvas2.on('selection:cleared',function(e){
			jQuery(".delete_canvas_img").remove(); 
		});
		canvas2.on('object:selected',function(e){
			if(e.target.type == "image"){
				jQuery(".delete_canvas_img").remove(); 
				var btnLeft = e.target.oCoords.mt.x;
				var btnTop = e.target.oCoords.mt.y - 25;
				var widthadjust=e.target.width/2;
				btnLeft=widthadjust+btnLeft+7;
				var delete_canvas_img = '<p" class="delete_canvas_img" style="color:white;position:absolute;top:'+btnTop+'px;left:'+btnLeft+'px;cursor:pointer;" title="Удалить"></p>';
				jQuery(".canvas2_container .canvas-container").append(delete_canvas_img);
			}
			
		});
		canvas2.on('mouse:down', function(options) { 
			if(options.target){
				// for(var i in canvas2._objects){
					// var index = parseInt(i) + 1;
					// canvas2._objects[i].key = "text" + index+"_2";
				// }				
				current_obj2 = options.target;				canvas2.bringToFront(current_obj2);
				var fontFamily = current_obj2.fontFamily;
				$('.fonts').val(fontFamily);
				var font_size = current_obj2.fontSize;
				$('.font_size').val(font_size);
				var color = current_obj2.fill; 
				$('.select_color_input').val(color);
				key = current_obj2.key;				
				setTimeout(function(){
					$('.' + key).focus();
				}, 0);
				window.img_binar_data = canvas2.toDataURL();
			}
		});
		var tmp = '_2';
		$('.custom_editor .text_align_left').click(function(){
			if(typeof current_obj2 != "undefined"){
				current_obj2.textAlign = 'left';
				canvas2.renderAll();
			}
		});
		$('.custom_editor .text_align_right').click(function(){
			if(typeof current_obj2 != "undefined"){
				current_obj2.textAlign = 'right';
				canvas2.renderAll();
			}
		});
		$('.custom_editor .text_align_center').click(function(){
			if(typeof current_obj2 != "undefined"){
				current_obj2.textAlign = 'center';
				canvas2.renderAll();
			}
		});
		/*$('.custom_editor .bold_block').click(function(){
			if(typeof current_obj2 != "undefined"){
				if(current_obj2.fontWeight == 'bold'){
					current_obj2.fontWeight = 'normal';
					canvas2.renderAll();
				}else{
					current_obj2.fontWeight = 'bold';
					canvas2.renderAll();
				}
			}
		});
		$(document).on('click', '.custom_editor .italic_block', function(){
			if(typeof current_obj2 != "undefined"){
				if(current_obj2.fontStyle == 'italic'){
					current_obj2.fontStyle = 'normal';
					canvas2.renderAll();
				}else{
					current_obj2.fontStyle = 'italic';
					canvas2.renderAll();
				}
			}
		});*/
		events2();

		$( ".h30" ).click(function() {
			var text_key = $(this).next().attr('key');
			var ob=canvas2.getObjects();

			for(var i in ob){
				var key = ob[i].key;
				if(key == text_key){
					canvas2.setActiveObject(ob[i]);
				}
			}

		});

		$( ".h30" ).keyup(function() {
			var current_text = $(this).val();	
			var text_key = $(this).next().attr('key');
			var ob=canvas2.getObjects();
			
			for(var i in ob){
				var key = ob[i].key;
				if(key == text_key){
					ob[i].text = current_text;					
				}
			}	

			canvas2.renderAll();
		});	
		
		
		$('.fonts').change(function(){
			var font = $(this).val();
			if(typeof current_obj2 != "undefined"){
				current_obj2.fontFamily = font;
				canvas2.renderAll();
			}
		});
		$('.font_size').change(function(){
			var font_size = $(this).val();
			if(typeof current_obj2 != "undefined"){
				current_obj2.fontSize = font_size;
				canvas2.renderAll();
			}
		});
		$('.select_color_input').change(function(){
			var color = $(this).val();
			if(typeof current_obj2 != "undefined"){
				current_obj2.fill = color;
				canvas2.renderAll();
			}
		});
		document.getElementById('select_canvas_image').onchange = function handleImage(e) {
			var reader = new FileReader();
			reader.onload = function (event) {
				var imgObj = new Image();
				imgObj.src = event.target.result;
				imgObj.onload = function () {
					var image = new fabric.Image(imgObj);
					image.set({
						left: 50,
						top: 50,
						width:100,
						height:100,
						//angle: 20,
						padding: 10,
						cornersize: 10
					});
					canvas2.add(image);
				}
			}
			reader.readAsDataURL(e.target.files[0]);
			canvas2.renderAll();
		}
		
		$('.select_bg_color_input').change(function(){
			var color = $(this).val();
			//canvas1.backgroundImage.visible = false;
			canvas2.backgroundImage = 0;
			//canvas1.setBackgroundImage("", canvas1.renderAll.bind(canvas1));
			//delete canvas1['backgroundImage'];
			canvas2.backgroundColor = color;
			canvas2.renderAll();
		});
		
		 
		
		
	});

	$('.save_canvas').bind("click", function(){
		
		if($('.canvas1_container').is(':visible')){
			var tmp = '_1';
			if(localStorage.getItem('bg_img_1') != null){
				localStorage.setItem('bg_image_1', 'yes');
			}			
		}else{
			var tmp = '_2';
			if(localStorage.getItem('bg_img_2') != null){
				localStorage.setItem('bg_image_2', 'yes');
			}
		}
		if($('.canvas1_container').is(':visible')){
			//alert(item_id_);
			$('.image' + tmp).attr('src', canvas1.toDataURL());
			$('.image' + tmp).show();
			window.current_state1 = JSON.stringify(canvas1);
			
			for(var i in canvas1._objects){
				var index = parseInt(i) + 1;
				//var  key=canvas1._objects[i].key;
				localStorage.setItem(item_id_ +'_key'+index+ '_curent1', canvas1._objects[i].key);
			}			
			
			//console.log(canvas1.toObject(),JSON.stringify(canvas1));
			localStorage.setItem(item_id_ + '_curent1', window.current_state1);
			localStorage.setItem(item_id_ + tmp, canvas1.toDataURL("image/jpeg", 1.0));
			
			var i=0;
			$('.inf_1 .h30').each(function(){
				i+=1;
				localStorage.setItem(item_id_ + tmp + '_text'+i, $(this).val());
			});
			
		}else{
			$('.image' + tmp).attr('src', canvas2.toDataURL());
			$('.image' + tmp).show();
			$('.image' + tmp).parent().show();
			window.current_state2 = JSON.stringify(canvas2);
			
			for(var i in canvas2._objects){
				var index = parseInt(i) + 1;
				//var  key=canvas1._objects[i].key;
				localStorage.setItem(item_id_ +'_key'+index+ '_curent2', canvas2._objects[i].key);
			}
			
			localStorage.setItem(item_id_ + '_curent2', window.current_state2);
			localStorage.setItem(item_id_ + tmp, canvas2.toDataURL("image/jpeg", 1.0));
			
			var i=0;
			$('.inf_2 .h30').each(function(){
				i+=1;
				localStorage.setItem(item_id_ + tmp + '_text'+i, $(this).val());
			});
		}	
		
    });	


if(typeof item_id_ !== "undefined"){
	
	function build_canvas_obj1(item_id){
		var canvas_id = 'myCanvas';
		obj = cards[item_id];
		$('.canvas1_container').show();
		$('.inf_1').show();
		$('.canvas2_container').hide();
		$('.inf_2').hide();
	    canvas1 = new fabric.Canvas('myCanvas');
		
		
		for(var i=2; i<Object.keys(obj).length;i++){ 		
				//console.log(Object.keys(obj).length);
				var j=i-1;
				var currentText = 'text'+j;
		
				currentText = new fabric.Text(obj[currentText].name, {
					top        : obj[currentText].top,
					left       : obj[currentText].left,
					fontSize   : obj[currentText].fontSize,
					fontFamily : obj[currentText].fontFamily,
					fontWeight : obj[currentText].fontWeight,
					fill       : obj[currentText].fill,			
					textAlign  : obj[currentText].textAlign,
					fontStyle  : obj[currentText].fontStyle,
					width      : obj[currentText].width,
					height     : obj[currentText].height
				});
				currentText.hasControls = true;
				currentText.key = "text"+j;
				canvas1.add(currentText);
		
		  
		}
		
		
			//canvas1.backgroundImage.visible = false;
			    
		console.log(canvas1.backgroundColor);
		
		var current1_json = localStorage.getItem(item_id_ + '_curent1');
		window.canvas1.loadFromJSON(current1_json,window.canvas1.renderAll.bind(window.canvas1));
		
		
		 
			
		if(canvas1.backgroundColor=='' && localStorage.getItem('bg_image_1') == null){	
			fabric.Image.fromURL(base_url + obj.big_img, function(img) {
				canvas1.setBackgroundImage(base_url + obj.big_img, canvas1.renderAll.bind(canvas1), {			   
					scaleY: canvas1.height/img.height,
					scaleX: canvas1.width/img.width,
			   });
			});
		}
		

		
		
		//canvas1.setBackgroundImage(base_url + obj.big_img, canvas1.renderAll.bind(canvas1));
		canvas1.renderAll();
		canvas1.on('object:moving',function(e){
			if(e.target.type == "image"){
				var activeObject = e.target;
				//console.log(activeObject.get('left'), activeObject.get('top'));
				jQuery(".delete_canvas_img").remove(); 
				var btnLeft = activeObject.get('left');//e.target.oCoords.mt.x;
				var btnTop = activeObject.get('top') -35;//e.target.oCoords.mt.y - 25;
				var widthadjust=e.target.width/2;
				btnLeft=widthadjust+btnLeft+55;
				var delete_canvas_img = '<p" class="delete_canvas_img" style="color:white;position:absolute;top:'+btnTop+'px;left:'+btnLeft+'px;cursor:pointer;" title="Удалить"></p>';
				jQuery(".canvas1_container .canvas-container").append(delete_canvas_img);
			}
		});
		canvas1.on('selection:cleared',function(e){
			jQuery(".delete_canvas_img").remove(); 
		});
		canvas1.on('object:selected',function(e){
			if(e.target.type == "image"){
				jQuery(".delete_canvas_img").remove(); 
				var btnLeft = e.target.oCoords.mt.x;
				var btnTop = e.target.oCoords.mt.y - 25;
				var widthadjust=e.target.width/2;
				btnLeft=widthadjust+btnLeft+7;
				var delete_canvas_img = '<p" class="delete_canvas_img" style="color:white;position:absolute;top:'+btnTop+'px;left:'+btnLeft+'px;cursor:pointer;" title="Удалить"></p>';
				jQuery(".canvas1_container .canvas-container").append(delete_canvas_img);
			}
			
		});
		canvas1.on('mouse:down', function(options) { 
			if(options.target){
				// for(var i in canvas1._objects){
					// var index = parseInt(i) + 1;
					// canvas1._objects[i].key = "text" + index;
				// }
				//console.log(options.target);
				current_obj1 = options.target;								canvas1.bringToFront(options.target);
				var fontFamily = current_obj1.fontFamily;
				$('.fonts').val(fontFamily);
				var font_size = current_obj1.fontSize;
				$('.font_size').val(font_size);
				var color = current_obj1.fill;
				$('.select_color_input').val(color);
				key = current_obj1.key;				
				setTimeout(function(){
					$('.' + key).focus();
				}, 0);
			}
		});
		var tmp = '_1';

		$('.custom_editor .text_align_left').click(function(){
			if(typeof current_obj1 != "undefined"){
				current_obj1.textAlign = 'left';
				canvas1.renderAll();
			}
		});
		$('.custom_editor .text_align_right').click(function(){
			if(typeof current_obj1 != "undefined"){
				current_obj1.textAlign = 'right';
				canvas1.renderAll();
			}
		});
		$('.custom_editor .text_align_center').click(function(){
			if(typeof current_obj1 != "undefined"){
				current_obj1.textAlign = 'center';
				canvas1.renderAll();
			}
		});
		$('.custom_editor .bold_block').click(function(){
			if(typeof current_obj1 != "undefined"){
				if(current_obj1.fontWeight == 'bold'){
					current_obj1.fontWeight = 'normal';
				}else{
					current_obj1.fontWeight = 'bold';
				}
				canvas1.renderAll();				
			}
			/*if(typeof current_obj1 != "undefined"){
				if($(this).hasClass('active')){
					$(this).removeClass('active');
					if(current_obj1){
						current_obj1.fontWeight = 'normal';
						canvas1.renderAll();
					}
				}else{
					$(this).addClass('active');
					if(current_obj1){
						current_obj1.fontWeight = 'bold';
						canvas1.renderAll();
					}
				}
			}*/
		});
		$('.custom_editor .italic_block').click(function(){
			if(typeof current_obj1 != "undefined"){
				if(current_obj1.fontStyle == 'italic'){
					current_obj1.fontStyle = 'normal';
				}else{
					current_obj1.fontStyle = 'italic';
				}
				canvas1.renderAll();				
			}
		});

		$( ".h30" ).click(function() {
			var text_key = $(this).next().attr('key');
			var ob=canvas1.getObjects();

			for(var i in ob){
				var key = ob[i].key;
				if(key == text_key){
					canvas1.setActiveObject(ob[i]);
				}
			}
		});


		$( ".h30" ).keyup(function() {
			var current_text = $(this).val();	
			var text_key = $(this).next().attr('key');
			var ob=canvas1.getObjects();
			
			for(var i in ob){
				var key = ob[i].key;
				if(key == text_key){
					ob[i].text = current_text;					
				}
			}	

			canvas1.renderAll();
		});	
		
		
		$('.fonts').change(function(){
			var font = $(this).val();
			//text1.set({ fontFamily: font });
			if(typeof current_obj1 != "undefined"){
				current_obj1.fontFamily = font;
				canvas1.renderAll();
			
			}
		});
		$('.font_size').change(function(){
			var font_size = $(this).val();
			//text1.set({ fontFamily: font });
			if(typeof current_obj1 != "undefined"){
				current_obj1.fontSize = font_size;
				canvas1.renderAll();
			}
		});
		$('.select_color_input').change(function(){
			var color = $(this).val();
			if(typeof current_obj1 != "undefined"){
				current_obj1.fill = color;
				canvas1.renderAll();
			}
		});
		$('.select_bg_color_input').change(function(){
			var color = $(this).val();
			//canvas1.backgroundImage.visible = false;
			canvas1.backgroundImage = 0;
			//canvas1.setBackgroundImage("", canvas1.renderAll.bind(canvas1));
			//delete canvas1['backgroundImage'];
			canvas1.backgroundColor = color;
			canvas1.renderAll();
		});
		$(document).on('click', '.delete_canvas_img', function(){
			canvas1.remove(canvas1.getActiveObject());
			if(typeof canvas2 != "undefined"){
				canvas2.remove(canvas2.getActiveObject());
			}
			$(this).remove();
		});
		document.getElementById('select_canvas_image').onchange = function handleImage(e) {
			
			var reader = new FileReader();
			reader.onload = function (event) { 
				var imgObj = new Image();
				imgObj.src = event.target.result;
				imgObj.onload = function () {
					var image = new fabric.Image(imgObj);
					image.set({
						left: 50,
						top: 50,
						width:100,
						height:100,
						//angle: 20,
						padding: 10,
						cornersize: 10
					});
					if($('.canvas1_container').is(':visible')){
						canvas1.add(image);						//canvas1.bringToFront(image);						//canvas1.bringForward(image);						 canvas1.sendToBack(image);						// canvas1.sendBackwards(image);
					}else{
						canvas2.add(image);
					}
				}
			}
			reader.readAsDataURL(e.target.files[0]);
			if($('.canvas1_container').is(':visible')){
				canvas1.renderAll();
			}else{
				canvas2.renderAll();
			}
			
		}	
		document.getElementById('select_canvas_bg_image').onchange = function handleImage(e) {
			var reader = new FileReader();
			reader.onload = function (event) { 
				var imgObj = new Image();
				imgObj.src = event.target.result;
				imgObj.onload = function () {
					var image = new fabric.Image(imgObj);
					/*image.set({
						left: 50,
						top: 50,
						width:100,
						height:100,
						
						padding: 10,
						cornersize: 10
					});*/
					if($('.canvas1_container').is(':visible')){
						//canvas1.add(image);
						// canvas1.setBackgroundImage(image, canvas1.renderAll.bind(canvas1);
						fabric.Image.fromURL(image._element.src, function(img) {
							canvas1.setBackgroundImage(image._element.src, canvas1.renderAll.bind(canvas1), {			   
								scaleY: canvas1.height/img.height,
								scaleX: canvas1.width/img.width,
						   });					   
						   
						});	
						localStorage.setItem('bg_img_1', 'yes');
					}else{
						fabric.Image.fromURL(image._element.src, function(img) {
							canvas2.setBackgroundImage(image._element.src, canvas2.renderAll.bind(canvas2), {			   
								scaleY: canvas2.height/img.height,
								scaleX: canvas2.width/img.width,
						   });					   
						   
						});
						localStorage.setItem('bg_img_2', 'yes');
					}
				}
			}
			reader.readAsDataURL(e.target.files[0]);
			if($('.canvas1_container').is(':visible')){
				canvas1.renderAll();
			}else{
				canvas2.renderAll();
			}
			
			
			
		}
		
	}



	function events2(){
		$('.custom_editor .bold_block').click(function(){
			if(typeof current_obj2 != "undefined"){
				if(current_obj2.fontWeight == 'bold'){
					current_obj2.fontWeight = 'normal';
					canvas2.renderAll();
				}else{
					current_obj2.fontWeight = 'bold';
					canvas2.renderAll();
				}
			}
		});
		$(document).on('click', '.custom_editor .italic_block', function(){
			if(typeof current_obj2 != "undefined"){
				if(current_obj2.fontStyle == 'italic'){
					current_obj2.fontStyle = 'normal';
					canvas2.renderAll();
				}else{
					current_obj2.fontStyle = 'italic';
					canvas2.renderAll();
				}
			}
		});
	}
	//if($('.canvas2_container').is(':visible')){
		//build_canvas_obj2(item_id_);
	//}
	build_canvas_obj1(item_id_);
	//localStorage.setItem(item_id_ + '_1', canvas1.toDataURL());
	//localStorage.setItem(item_id_ + '_2', canvas2.toDataURL());
	tmp('_1');
	//if($('.canvas2_container').is(':visible')){
	tmp('_2');
	//}
	
 }

})(jQuery);


function build_canvas_obj2(item_id){
	var canvas_id = 'revers_myCanvas';
	obj = cards[item_id];

	for(var i=2; i<Object.keys(obj).length;i++){
		//console.log(Object.keys(obj).length);
		var j=i-1;
		var currentText = 'text'+j;
		jQuery('.inf_2 .'+currentText).text(obj[currentText].name);
		//$('.'+currentText).attr('placeholder',obj[currentText].name);
	}
	var k=6-Object.keys(obj).length+2;
	//console.log(k);

	for(var i=0;i<k;i++){
		var j=Object.keys(obj).length-1+i;
		var currentText = 'text'+j;
		jQuery('.inf_2 .'+currentText).parent().remove();
	}


	jQuery('.canvas1_container').hide();
	jQuery('.inf_1').hide();
	jQuery('.canvas2_container').show();
	jQuery('.inf_2').show();
	if(typeof canvas2 == "undefined"){
		canvas2 = new fabric.Canvas('revers_myCanvas');
	}

	for(var i=2; i<Object.keys(obj).length;i++){
		//console.log(Object.keys(obj).length);
		var j=i-1;
		var currentText = 'text'+j;

		currentText = new fabric.Text(obj[currentText].name, {
			top        : obj[currentText].top,
			left       : obj[currentText].left,
			fontSize   : obj[currentText].fontSize,
			fontFamily : obj[currentText].fontFamily,
			fontWeight : obj[currentText].fontWeight,
			fill       : obj[currentText].fill,
			textAlign  : obj[currentText].textAlign,
			fontStyle  : obj[currentText].fontStyle,
			width      : obj[currentText].width,
			height     : obj[currentText].height
		});
		currentText.hasControls = true;
		currentText.key = "text"+j+"_2";
		canvas2.add(currentText);


	}




	fabric.Image.fromURL(base_url + obj.big_img, function(img) {
		canvas2.setBackgroundImage(base_url + obj.big_img, canvas2.renderAll.bind(canvas2), {
			scaleY: canvas2.height/img.height,
			scaleX: canvas2.width/img.width,
		});
	});
	//canvas2.setBackgroundImage(base_url + obj.big_img, canvas2.renderAll.bind(canvas2));
	canvas2.renderAll();


}

function tmp(tmp){
	if(localStorage.getItem(item_id_ + tmp) != null){

		//$('.text1').val(localStorage.getItem(item_id_ + tmp + '_text1'));
		//$('.text2').val(localStorage.getItem(item_id_ + tmp + '_text2'));
		//$('.text3').val(localStorage.getItem(item_id_ + tmp + '_text3'));
		//$('.text4').val(localStorage.getItem(item_id_ + tmp + '_text4'));
		//$('.text5').val(localStorage.getItem(item_id_ + tmp + '_text5'));
		//$('.text6').val(localStorage.getItem(item_id_ + tmp + '_text6'));
		jQuery('.image' + tmp).attr('src', localStorage.getItem(item_id_ + tmp));
		jQuery('.image' + tmp).show();
		jQuery('.image' + tmp).parent().show();
		if(tmp == '_2'){
			var id = localStorage.getItem(item_id_ + '_reverse_id');
			console.log(id,'oooo');
			//id=3;
			var obj = cards[id];
			jQuery('.add_edit_img').attr('src', base_url + obj.big_img);
		}
	}

}