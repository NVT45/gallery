$(document).ready(function(){
var user_href;
var user_href_splitted;
var user_id;
var image_src;
var image_href_splitted;
var image_id;
var photo_id;
$('.modal_thumbnails').click(function(){

	$('#set_user_image').prop('disabled',false);
	$(this).addClass('selected');
	user_href = $('#user_id').prop('href');
	user_href_splitted = user_href.split("=");
	user_id = user_href_splitted[user_href_splitted.length -1];// cách lấy chỉ mục lướn nhất mảng
	

	image_src = $(this).prop('src');
	image_href_splitted = image_src.split("/");
	image_id = image_href_splitted[image_href_splitted.length -1];// cách lấy chỉ mục lướn nhất mảng


	photo_id = $(this).attr("data");

	$.ajax({
			url: "includes/ajax_code.php",
			data:{photo_id: photo_id,},
			type: "POST",
			success:function(data){
				if(!data.error){
					
					$("#modal_sidebar").html(data);
				}
			}
		})

});

$('#set_user_image').click(function(){
		$.ajax({
			url: "includes/ajax_code.php",
			data:{image_id: image_id,user_id: user_id},
			type: "POST",
			success:function(data){
				if(!data.error){
					
					$('.user_image_box a img').prop('src',data);
					// location.reload(true);
				}
			}
		})
});

$('.delete_link').click(function(){
return confirm("Are you want to delete ???");
});
tinymce.init({selector:'textarea'});
});