function sws_slider_add_image(obj) {
	var mediaUploader;
	if (mediaUploader) {
	  mediaUploader.open();
	  return;
	}
	mediaUploader = wp.media.frames.file_frame = wp.media({
	  title: 'Choose Image',
	  button: {
	  text: 'Choose Image'
	}, multiple: false });
	mediaUploader.on('select', function() {
	  attachment = mediaUploader.state().get('selection').first().toJSON();
	  jQuery(obj).parents('.field_row').find('.meta_image_url').val(attachment.url);
	});
	mediaUploader.open();
}  
		
function sws_slider_remove_field(obj) {
	var parent=jQuery(obj).parent().parent();
	parent.remove();
}   
		
jQuery(document).ready(function(){
	jQuery('#add_field_row1').on('click', function() {
		var row = jQuery('#master-row').html();
		jQuery(row).appendTo('#field_wrap');
	});
 });