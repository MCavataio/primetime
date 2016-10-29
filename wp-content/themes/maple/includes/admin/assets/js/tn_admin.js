jQuery(document).ready(function ($) {
    "use strict";
    //post filter
    var select = $('#post-formats-select').find('[type="radio"]');
    select.live('change',function () {
        var val = $(this).val();
        var tn_gallery_post = $('#tn_gallery_post');
        var tn_video_post = $('#tn_video_post');
        var tn_audio_post = $('#tn_audio_post');

        tn_gallery_post.hide();
        tn_video_post.hide();
        tn_audio_post.hide();
        if ('gallery' == val) {
            tn_gallery_post.show();
        } else if ('video' == val) {
            tn_video_post.show();
        } else if ('audio' == val) {
            tn_audio_post.show();
        }
    }).filter(':checked').trigger('change');
});
