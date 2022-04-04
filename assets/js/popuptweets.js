$(function(){
    $(document).on('click', '.t-show-popup', function(){
        var tweet_id = $(this).data('tweet');
        $.post('http://localhost/WebDeveloper/Twitter-Clone/core/ajax/popuptweets.php', {showpopup:tweet_id}, function(data){
            $('.popupTweet').html(data);
            $('.twweet-show-popup-box-cut').click(function(){
                $('.twweet-show-popup-wrap').hide();
            });
        });        
    });

    $(document).on('click', '.imagePopup', function(e){
        e.stopPropagation();
        var tweet_id = $(this).data('tweet');

        $.post('http://localhost/WebDeveloper/Twitter-Clone/core/ajax/imagePopup.php', {showImage: tweet_id}, function(data){
            $('.popupTweet').html(data);
            $('.close-imagePopup').click(function(){
                $('.img-popup') .hide();
            });
        });
    });
});