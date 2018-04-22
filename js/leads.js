$('document').ready(function(){
	var entityId 		= '';
	var entityTypeId 	= '';
	$('a.entity').on('click', function(){
		$this = $(this);
		$this.siblings().removeClass('selected');
		$this.addClass('selected');
		entityId 		= $this.data('entity-id');
		entityTypeId 	= $this.data('entity-type-id');

		filter_data();
	});

	$("body").on("click", ".page-links", function(event){
        pageNo = parseInt($(this).attr('data-page-no'));
        if( $(this).hasClass('previous-page') ){
            pageNo = $('.page-links.active').attr('data-page-no') - 1;
        }else if( $(this).hasClass('next-page') ){
            pageNo = parseInt($('.page-links.active').attr('data-page-no')) + 1;
        } 
        
        filter_data( pageNo );
        $("html, body").animate({ scrollTop: 250 }, 800);
        
    });

	$('a.entity:first').trigger('click');

 	function filter_data(pageNo = 0){
 		$.ajax({
            url: 'leads/getInterestedLeadDetailsByEntityIdByEntityTypeId',
            data: {entityId:entityId, entityTypeId:entityTypeId, pageNo: pageNo},
            type: 'POST',
            dataType: 'json',
        }).done(function(response){
            $.ajax({
	            url: 'leads/displayInterestedLeads',
	            type: "POST",
	            dataType: "html",
	            contentType: "application/json; charset=utf-8",
	            data: JSON.stringify(response),
	            success: function(response1) {
	            	$('#leads_details').html(response1);
	            }	
        	});    
		})
 	}   
});		