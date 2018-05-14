$(document).ready(function(){
	
	$('#manage-images').hide();

	$('#show-images').on('click', function(){
		$('#manage-images').toggle('slow');		
	})


		$('body').on('click','.featured-content-delete .delete' , function(e){
            e.preventDefault();
            $answer = confirm('Are you sure you want to delete?');
            $this = $(this);
            if($answer){
            	var $imageId = $(this).attr('data-option-id');
	            $.ajax({
	                type: "POST",
	                async: true,
	                url: 'deleteImage',
	                data: {imageId: $imageId},
	                dataType: 'json',
	                success: function (result) {
	                    $this.parents('.left').remove();
	                    //location.reload();
	                }
	            });
            }
            /*featuredOption  = $(this).attr('data-featured-option');
            optionId        = $(this).attr('data-option-id');
            optionText      = $(this).attr('data-option-text');
            postData        = { table:featuredOption, id: optionId  };
            $('#delete-featured-content .delete-header').text( 'Delete ' + optionText );
            $('#delete-featured-content').modal('open');*/
       
        });

		$('#branch-id').on('change',function(){
			
			if($(this).val() > 0 ) {
				$('#upload-wrapper').removeClass('hide');
			} else{
				$('#upload-wrapper').addClass('hide');
			}	

			$.ajax({
                type: "POST",
                async: true,
                url: 'getGalleryImagesByBranchId',
                data: {branchId: $(this).val()},
                dataType: 'json',
                success: function (result) {
                	$.ajax({
                        url: 'displayGalleryImages',
                        type: "POST",
                        dataType: "html",
                        contentType: "application/json; charset=utf-8",
                        data: JSON.stringify(result),
                        success: function(response) {
                        	$('#branch-images').html(response);	
                        }
                    });    	
                }
            });
		})

        
	$("#upload").on('click',function(){
		galleryObj.startUpload();
	}); 

	var galleryObj = $("#multipleupload").uploadFile({
		url:"save-image-gallery",
		multiple:true,
		dragDrop:true,
		fileName:"gallery-image",
		dynamicFormData: function(){
			var data ={ branchId:$('#branch-id').val() }
			return data;
		},
		acceptFiles:"image/*",
		showPreview:true,
		previewHeight: "100px",
		previewWidth: "100px",
		maxFileSize:400*1024,
		maxFileCount:5,
		autoSubmit:false,
		onSuccess:function(files,data,xhr,pd){
			$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Success for: "+JSON.stringify(files));
		},
		afterUploadAll:function(obj){
			$("#eventsmessage").html($("#eventsmessage").html()+"<br/>All files are uploaded");
			
			$.ajax({
                type: "POST",
                async: true,
                url: 'getGalleryImagesByBranchId',
                data: {branchId: $('#branch-id').val()},
                dataType: 'json',
                success: function (result) {
                	$.ajax({
                        url: 'displayGalleryImages',
                        type: "POST",
                        dataType: "html",
                        contentType: "application/json; charset=utf-8",
                        data: JSON.stringify(result),
                        success: function(response) {
                        	$('#branch-images').html(response);	
                        }
                    });    	
                }
            });

		},
		onError: function(files,status,errMsg,pd){
			$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Error for: "+JSON.stringify(files));
		},
		onCancel:function(files,pd){
			$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Cancelled  files: "+JSON.stringify(files));
		}

		/*
		onLoad:function(obj)
		   {
		   	$.ajax({
			    	cache: false,
				    url: "load.php",
			    	dataType: "json",
				    success: function(data) 
				    {
					    for(var i=0;i<data.length;i++)
		   	    	{ 
		       			obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
		       		}
			        }
				});
		  },
		showDelete: true,
		deleteCallback: function (data, pd) {
		    for (var i = 0; i < data.length; i++) {
		        $.post("delete.php", {op: "delete",name: data[i]},
		            function (resp,textStatus, jqXHR) {
		                //Show Message	
		                alert("File Deleted");
		            });
		    }
		    pd.statusbar.hide(); //You choice.

		},
		*/
	}); 
});
