jQuery(document).ready(function($) {
	$('.img_tip').each(function() {
		$(this).qtip({
			content: $(this).attr('data-desc'),
			position: {
				my: 'center left',
				at: 'center right',
				viewport: $(window)
			},
			show: {
				event: 'mouseover',
				solo: true,
			},
			hide: {
				inactive: 60000,
				fixed: true
			},
			style: {
				classes: 'qtip-dark qtip-shadow qtip-rounded qtip-dc-css'
			}
		});
	});
	
	if($('.cloud_type').length > 0) {
	  var cloud_type = $('.cloud_type:checked').val();
	  proccessCloudType(cloud_type);
	  $('.cloud_type').change(function () { 
	    cloud_type = $('.cloud_type:checked').val();
	    proccessCloudType(cloud_type);
	  });
	}
});

function proccessCloudType(cloud_type) {
  if(cloud_type == 'static') {
    jQuery('.nid, #nid').show();
    jQuery('.use_comments, #use_comments').hide();
  } else if(cloud_type = 'dynamic') {
    jQuery('.nid, #nid').hide();
    jQuery('.use_comments, #use_comments').show();
  }
}
