$(function(){
    $(document).on('click', '#postComment', function(){
        var comment  = $('#commentField').val();
        var tweet_id = $('#commentField').data('tweet');

        if (comment != "") {
            $.post('http://localhost/WebDeveloper/Twitter-Clone/core/ajax/comment.php', {comment:comment, tweet_id: tweet_id}, function(data){
                $('#comment').html(data);
                $('#commentField').val("");

            });
        }
    });
});