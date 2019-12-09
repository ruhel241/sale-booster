(function($) {

    // corner ad position inline
    $("._sale_booster_corner_ad_position").parents("li").css({"display": "inline-block", "margin-right": "10px"});
   
    /**
     * Added class into custom box
    */
    var customPopUp = $("#home_page_exit_custom_popup").parent();
    var customPopUpParent = customPopUp.parent().addClass("home_page_exit_custom_popup");

   /**
    * home custom popup execute
    */
    function checkCustomPopUp(value){
        if(value === "custom_html"){
            customPopUpParent.show();
        } else {
            customPopUpParent.hide();
        }
    }
   /**
    * initail check
    */
    var popUp = $("#home_page_exit_popup").val();
    checkCustomPopUp(popUp);
    /**
     * change custom popup
    */
    $("#home_page_exit_popup").change(function(e){
        value = e.target.value;
        checkCustomPopUp(value);
    })


/**
 * Media upload on setting page
*/ 
    var mediaUploader;
    var  inputValue = "";
    $('.upload_image').click(function(e) {
        if(e.target.id === 'upload_image_banner_below'){
           inputValue = $("#upload_image_banner_below").closest("span").siblings('#home_page_banner_below');
        }
        else if(e.target.id === 'upload_image_above_footer') {
            inputValue = $("#upload_image_above_footer").closest("span").siblings('#home_page_banner_above_footer');
        } 
        else {
           inputValue = $("#upload_image_corner_ad").closest("span").siblings('#home_page_corner_ad');
        } 
        e.preventDefault();
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
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $(inputValue).val(attachment.url);
        });
        mediaUploader.open();
    });
})( jQuery );
