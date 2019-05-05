jQuery(function($) {
    var avt_size = (ami_tweet.twitter_avt_size == 'false')? false : true;
    //TWITTER FEED-----------------------------------------------
    $(".tweet").tweet({
        // join_text: false,
        username: ami_tweet.twitter_user_name, // Change username here
        modpath: ami_tweet.url, // Twitter files path
        avatar_size: avt_size, // you can active avatar
        count: ami_tweet.twitter_post_number, // number of tweets
        loading_text: ami_tweet.twitter_loading_text
    });
});