<?php
$msg_title = "Topic Page";
$msg_sub = "Thanks for helping!";
include 'reply.php';
include 'connect.php';
include 'header.php';
include 'errors.php';


    if (!isset($_GET['id']))
        echo 'No topic selected for display. Go back to <a href="index.php"> Post Page. </a>';
    else{

    // Initial Topic Query
    $top_query = "SELECT topic_subject FROM topics WHERE topic_id = " . $_GET['id'];
    $top_result = mysqli_query($conn, $top_query);

    $row = mysqli_fetch_row($top_result);

    echo '<h3 class="text-center"> <a href="topic_view.php?id=' . $_GET['id'] . '">  ' . $row[0] . ' </a></h3>';

    // Getting posts
    $post_query = "SELECT post_topic, post_content, post_date, post_by,
                    users.user_id, users.user_name FROM posts LEFT JOIN users
                    ON posts.post_by = users.user_id WHERE post_topic = " . $_GET['id'] ;

    $post_result = mysqli_query($conn, $post_query);
    while ($row = mysqli_fetch_assoc($post_result)){
        $user_name_query = "SELECT user_name FROM users WHERE user_id = ". $row['post_by'];
        $user_name_query = mysqli_query($conn, $user_name_query);
        $user_name = mysqli_fetch_row($user_name_query);
        $date = strtotime($row['post_date']);
        $s_date = date("h:i a", $date);
        $d_date = date("m-d-Y", $date);

        // Picture Query
        $p_query = "SELECT image FROM image WHERE image_for=". $row['post_by'];
        $p_query = mysqli_query($conn, $p_query);
        $p_result = mysqli_fetch_assoc($p_query);

        echo '
            <div class="response"> <p>'. $row['post_content'] .' </p> <div class="text-right">
            <a href="user_view.php?id='.$row['post_by'] .'#profileP">
            <img id="avatar" src="assets/img/profile/'. $p_result['image'] . '" alt="profile">
            </a>
            Posted 
            by  <a href="user_view.php?id='.$row['post_by'] .'"> '.  $user_name[0] .'</a> on
             '. $d_date .' at ' . $s_date . ' 
              </div></div><hr>
        ';
    }


    // REPLY
    echo '
    <form method="post" action=""> 
        <input name="id" value="'.$_GET['id'].'" hidden>
        <textarea rows="3"  id="reply_content" name="reply_content" placeholder="Write a reply"></textarea>
        <input type="submit" class="button expanded" value="Submit reply" name="submit_reply" />
    </form>

    
    <!-- TEXTAREA PLUGIN -->
      
    <!-- Highlight Stylesheet -->
    <link rel="stylesheet" href="assets/js/vendor/Trumbowyg-master/dist/plugins/highlight/ui/trumbowyg.highlight.min.css">
    
    <!-- Import prismjs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/prism.min.js"></script>
    
    <!-- Import Trumbowyg -->
    <script src="assets/js/vendor/Trumbowyg-master/dist/trumbowyg.min.js"></script>
    
    <!-- Import Trumbowyg plugins... -->
    <link rel="stylesheet" href="assets/js/vendor/Trumbowyg-master/dist/plugins/emoji/ui/trumbowyg.emoji.min.css">
    <link rel="stylesheet" href="assets/js/vendor/Trumbowyg-master/dist/plugins/giphy/ui/trumbowyg.giphy.min.css">
    <link rel="stylesheet" href="assets/js/vendor/Trumbowyg-master/dist/plugins/colors/ui/trumbowyg.colors.min.css">
    <link rel="stylesheet" href="assets/js/vendor/Trumbowyg-master/dist/plugins/specialchars/ui/trumbowyg.specialchars.min.css">
    <script src="assets/js/vendor/Trumbowyg-master/dist/plugins/emoji/trumbowyg.emoji.min.js"></script>
    <script src="assets/js/vendor/Trumbowyg-master/dist/plugins/giphy/trumbowyg.giphy.min.js"></script>
    <script src="assets/js/vendor/Trumbowyg-master/dist/plugins/colors/trumbowyg.colors.min.js"></script>
    <script src="assets/js/vendor/Trumbowyg-master/dist/plugins/noembed/trumbowyg.noembed.min.js"></script>
    <script src="assets/js/vendor/Trumbowyg-master/dist/plugins/highlight/trumbowyg.highlight.min.js"></script>
    <script src="assets/js/vendor/Trumbowyg-master/dist/plugins/pasteembed/trumbowyg.pasteembed.min.js"></script>
    <script src="assets/js/vendor/Trumbowyg-master/dist/plugins/preformatted/trumbowyg.preformatted.min.js"></script>
    <script src="assets/js/vendor/Trumbowyg-master/dist/plugins/specialchars/trumbowyg.specialchars.min.js"></script>
    <script src="assets/js/vendor/Trumbowyg-master/dist/plugins/upload/trumbowyg.upload.min.js"></script>
    
    <!-- Init Trumbowyg -->
    <script>
        $("#reply_content").trumbowyg({
    btns: [
        [\'undo\', \'redo\'], // Only supported in Blink browsers
        [\'formatting\'],
        [\'strong\', \'em\', \'del\'],
        [\'superscript\', \'subscript\'],
        [\'link\'],
        [\'insertImage\'],
        [\'justifyLeft\', \'justifyCenter\', \'justifyRight\', \'justifyFull\'],
        [\'unorderedList\', \'orderedList\'],
        [\'horizontalRule\'],
        [\'removeformat\'],
        [\'emoji\'],
        [\'giphy\'],
        [\'foreColor\', \'backColor\'],
        [\'noembed\'],
        [\'upload\'],
        [\'specialChars\'],
        [\'preformatted\'],
        [\'highlight\'],
        [\'fullscreen\']
        
    ],
    plugins: {
         upload: {
            serverPath: \'https://api.imgur.com/3/image\',
            fileFieldName: \'image\',
            headers: {
                \'Authorization\': \'Client-ID 4e800065cc4246f\'
            },
            urlPropertyName: \'data.link\'
        },
        giphy: {
            apiKey: \'ZpHfcC99isz3tLrUeJgFbTs3Uzpj63RU\'
        }
        
    }
});
    </script>
   
    ';
    }
include 'footer.php';