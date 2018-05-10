$(document).ready(function(){
	
	$('#manage-images').hide();

	$('#show-images').on('click', function(){
		$('#manage-images').toggle('slow');		
	})


	$('.featured-content-delete .delete').on('click', function(){
            featuredOption  = $(this).attr('data-featured-option');
            optionId        = $(this).attr('data-option-id');
            optionText      = $(this).attr('data-option-text');
            postData        = { table:featuredOption, id: optionId  };
            $('#delete-featured-content .delete-header').text( 'Delete ' + optionText );
            $('#delete-featured-content').modal('open');
       
        });

        $('.delete-yes').on('click', function(){
            $.ajax({
                type: "POST",
                async: true,
                url: 'profile/deleteFetauredContent',
                data: postData,
                dataType: 'json',
                success: function (result) {
                    location.reload();
                }
            });
        })

	$("#upload").on('click',function(){
		galleryObj.startUpload();
	}); 

	var galleryObj = $("#multipleupload").uploadFile({
		url:"profile/handleUploadImageGallery",
		multiple:true,
		dragDrop:true,
		fileName:"featured-image",
		acceptFiles:"image/*",
		showPreview:true,
		previewHeight: "100px",
		previewWidth: "100px",
		maxFileSize:100*1024,
		maxFileCount:5,
		autoSubmit:false,
		onSuccess:function(files,data,xhr,pd){
			$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Success for: "+JSON.stringify(files));
		},
		afterUploadAll:function(obj){
			$("#eventsmessage").html($("#eventsmessage").html()+"<br/>All files are uploaded");
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
