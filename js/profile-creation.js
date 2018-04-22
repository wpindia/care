$(document).ready(function () {
    if(window.location.href.indexOf("edit-blog") > -1 || window.location.href.indexOf("edit-event") > -1 ) {
        $('#other_details').removeClass('hide');
    }

    if($(".featured_carousel").length > 0 ){
        var demo_new = $(".featured_carousel");
            demo_new.owlCarousel({
                items: 1,
                itemsDesktop: [1000, 1],
                itemsDesktopSmall: [900, 1],
                itemsTablet: [600, 1],
                itemsMobile: false,
            });
    }    

    
    if($("#partner-gallery").length > 0 ){
        var demo_new = $("#partner-gallery");
            demo_new.owlCarousel({
                lazyLoad: true,
                loop:true,
                margin:10,
                autoplay: true,
                responsiveClass:true,
                dotsEach: false,
                navText: [
                    "<i class='icon-chevron-left icon-white'><</i>",
                    "<i class='icon-chevron-right icon-white'>></i>"
                ],
                responsive:{
                    0:{
                        items:1,
                        dots: true,
                        nav: false,
                        autoplayHoverPause: false
                    },
                    700:{
                        items:2,
                        dots: true,
                        nav: true,
                        autoplayHoverPause: false
                    },
                    993:{
                        items:3,
                        dots: false,
                        nav: true,
                        autoplayHoverPause: true
                    }
                }
            });
    }        

        $('.featured-content-delete .delete').on('click', function(){
            featuredOption  = $(this).attr('data-featured-option');
            optionId        = $(this).attr('data-option-id');
            optionText      = $(this).attr('data-option-text');
            postData        = { table:featuredOption, id: optionId  };
            $('#delete-featured-content .modal-title').text( 'Delete ' + optionText );
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
    
    if($('.dropify').length>0){    
        var drEvent = $('.dropify').dropify({
            error: {
                'fileSize': 'The file size is too big ({{ value }} max).',
                'minWidth': 'The image width is too small ({{ value }}}px min).',
                'maxWidth': 'The image width is too big ({{ value }}}px max).',
                'minHeight': 'The image height is too small ({{ value }}}px min).',
                'maxHeight': 'The image height is too big ({{ value }}px max).',
                'imageFormat': 'The image format is not allowed ({{ value }} only).'
            }
        });
        drEvent.on('dropify.beforeClear', function(event, element){
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });
        drEvent.on('dropify.errors', function(event, element){
            $('#post_image').val('');
        });
        drEvent.on('change', function(event, element){
            $('#post_image').val($.trim($(this).val()));
        });
    }

    if($('textarea.tinymce-editor').length>0){
        tinymce.init({
            selector: '.tinymce-editor',
            branding:false,
            menubar: false,
            statusbar: true,
            toolbar_items_size: 'small',
            plugins: ["autolink anchor charmap textcolor textpattern visualblocks visualchars colorpicker directionality fullscreen hr link code image imagetools insertdatetime lists media paste searchreplace tabfocus table wordcount"],
            textcolor_cols: "10",
            toolbar1: "undo redo | styleselect formatselect | charmap anchor | insertdatetime searchreplace table | code",
            toolbar2: "cut copy paste | bullist numlist outdent indent | blockquote | undo redo | removeformat subscript superscript | ltr rtl visualblocks visualchars",
            toolbar3: "fontselect fontsizeselect | alignleft aligncenter alignright alignjustify alignnone | bold italic underline strikethrough | forecolor backcolor | link unlink | media image | fullscreen",
            height: 200,
            end_container_on_empty_block: true,
            browser_spellcheck: true,
            keep_styles: false,
            relative_urls: false,
            formats: {
                alignleft: [
                    {selector: "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li", styles: {textAlign:"left"}},
                    {selector: "img,table", classes: "alignleft"}
                ],
                aligncenter: [
                    {selector: "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li", styles: {textAlign:"center"}},
                    {selector: "img,table", classes: "aligncenter"}
                ],
                alignright: [
                    {selector: "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li", styles: {textAlign:"right"}},
                    {selector: "img,table", classes: "alignright"}
                ],
                strikethrough: {inline: "del"}
            },
            content_css: ['/plugin/font/desktop/museo-sans/include-fonts.css','/plugin/css/materialize-v-0.9.min.css','/css/candidate/style.css','/css/candidate/post.css','/css/admin/admin-tinymce.css'],
            body_class:'post-content-section post-body-section',
            paste_data_images: true,
            convert_urls:false,
            font_formats: 'Arial=arial,helvetica,sans-serif;Museo300=museo_sans300;Museo500=museo_sans500',
            fontsize_formats: '10px 12px 14px 15px 16px 18px 20px 24px 28px 32px',
            default_link_target: "_blank",
            resize:true,
            image_caption: true,
            image_advtab: true,
            image_description: true,
            image_title: true,
            file_picker_types: 'image',
            images_upload_url: 'admin/events/uploadImagesFromEditor',
            file_picker_callback: function(cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                $('#errorTinymce').remove();
                // Note: In modern browsers input[type="file"] is functional without 
                // even adding it to the DOM, but that might not be the case in some older
                // or quirky browsers like IE, so you might want to add it to the DOM
                // just in case, and visually hide it. And do not forget do remove it
                // once you do not need it anymore.
                input.onchange = function() {
                    var file = this.files[0];
                    if( file.size <= 1000000) {
                        var ValidImageTypes = ["image/gif", "image/jpeg", "image/png"];
                        if ($.inArray(file.type, ValidImageTypes) < 0) {
                            $('.mce-window.mce-in .mce-window-head').after('<div id="errorTinymce" class="tinymceError">File is not an image</div>');
                        }else {
                            var reader = new FileReader();
                            reader.readAsDataURL(file);
                            reader.onload = function () {
                                var id = 'blobid' + (new Date()).getTime();
                                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                                var blobInfo = blobCache.create(id, file, reader.result);
                                blobCache.add(blobInfo);
                                $('#errorTinymce').remove();
                                cb(blobInfo.blobUri(), { title: file.name });
                            }
                        }
                    }else {
                        $('.mce-window.mce-in .mce-window-head').after('<div id="errorTinymce" class="tinymceError">File size sholud be less than 1 MB</div>');
                    }
                };
                input.click();
            }
        });
    }

    $('form#frm_addEditProfile').validate({
        ignore: [],
        rules: {
            aboutus:{
                required: true
                //minlength: 50
            },
            "vendor-types[]":{
                vendor_types_req:true
            },
            "facebook-id":{
                url: true
            },
            "twitter-id":{
                url: true   
            },
            "linkedin-id":{
                url: true   
            },
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).parent().prepend(error);
            } else {
                error.insertBefore(element);
                
            }
        }
    });

    $("#blog-link").bind("paste", function (e) { // access the clipboard using the api
        var self = this;
        setTimeout(function (e) {
            var _linkbuffer = '';
            var msg = $(self).val().trim();
            if (_linkbuffer == $.trim($(self).val())) {
                return false;
            }
            _linkbuffer = $.trim($(self).val());
            var theLink = _linkbuffer; //link_arr[_linkindex];
            var youarehell = /(^|\s)((https?:\/\/)?[\w-]+(\.[\w-]+)+\.?(:\d+)?(\/\S*)?)/gi;
            var match = theLink.match(youarehell);

            if (!match) {
                $('.errorb').html('Please provide valid blog link');
                
                return false;
            } else {
                $.ajax({
                    url: "../employer/company/fetch_blog_data",
                    async: true,
                    type: "POST",
                    data: "url=" + encodeURI(msg), //The type which you want to use: GET/POST  //The variables which are being passed.
                    dataType: "json",
                    success: function (response) {
                        $('#other_details').removeClass('hide');
                        $('#blog-title').val(response.title);
                        console.log(response.description);
                        $('#blog-description').html(response.description);
                        
                        tinyMCE.activeEditor.setContent(response.description);
                        /*tinymce.remove();
                        tinymce.init({selector:'textarea'});*/
                        //tinymce.triggerSave();
                        
                        if( response.thumbnail_url == undefined || response.thumbnail_url == "") {
                            $('.thumbnail-image').attr('src', "images/blog-default.jpg");
                            $('#blog-image').val('images/blog-default.jpg')
                        } else {
                            $('.thumbnail-image').attr('src', response.thumbnail_url);
                            $('#blog-image').val(response.thumbnail_url);
                        }

                        Materialize.updateTextFields();
                    }
                });
            }
        }, 100);
    });

    $("#event-url").bind("paste", function (e) { // access the clipboard using the api
        var self = this;
        setTimeout(function (e) {
            var _linkbuffer = '';
            var msg = $(self).val().trim();
            if (_linkbuffer == $.trim($(self).val())) {
                return false;
            }
            _linkbuffer = $.trim($(self).val());
            var theLink = _linkbuffer; //link_arr[_linkindex];
            var youarehell = /(^|\s)((https?:\/\/)?[\w-]+(\.[\w-]+)+\.?(:\d+)?(\/\S*)?)/gi;
            var match = theLink.match(youarehell);

            if (!match) {
                $('.errorb').html('Please provide valid event link');
                
                return false;
            } else {
                $.ajax({
                    url: "../employer/company/fetch_blog_data",
                    async: true,
                    type: "POST",
                    data: "url=" + encodeURI(msg), //The type which you want to use: GET/POST  //The variables which are being passed.
                    dataType: "json",
                    success: function (response) {
                        $('#other_details').removeClass('hide');
                        $('#event-title').val(response.title);
                        $('#event-description').val(response.description);
                        
                        tinymce.remove();
                        tinymce.init({selector:'textarea'});
                        //tinymce.triggerSave();
                        
                        if( response.thumbnail_url == undefined || response.thumbnail_url == "") {
                            $('.thumbnail-image').attr('src', "images/blog-default.jpg");
                            $('#event-image').val('images/blog-default.jpg')
                        } else {
                            $('.thumbnail-image').attr('src', response.thumbnail_url);
                            $('#event-image').val(response.thumbnail_url);
                        }

                        Materialize.updateTextFields();
                    }
                });
            }
        }, 100);
    });
});    