<?php
session_start();
if (isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];

$msg_title = "Time to Speak!";
$msg_sub = "Create your topic so that you can discuss with your peers.";

include 'connect.php';
include 'header.php';
include 'app.php';
?>

<form class="log-in-form" method="post" action="">
    <?php include ('errors.php') ?>
    <h3 class="text-center">Posting Time!</h3>
    <label>
        Subject
        <input type="text" placeholder="Subject for discussion" name="topic_subject" required>
    </label>
    <label>
        Category
        <select name="topic_cat">
            <?php
                $query ="SELECT cat_id,  cat_name, cat_description FROM categories";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)){
                    echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                }
            ?>
        </select>
    </label>
    <label>
        Message
    </label>
        <textarea rows="5" id="post_contents" placeholder="Start writing" name="post_content"> </textarea>

    <p>
        <input type="submit" name="topic_creation" class="button expanded" value="Create Topic">
    </p>
    <br>

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
        $("#post_contents").trumbowyg({
            btns: [
                ['undo', 'redo'], // Only supported in Blink browsers
                ['formatting'],
                ['strong', 'em', 'del'],
                ['superscript', 'subscript'],
                ['link'],
                ['insertImage'],
                ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                ['unorderedList', 'orderedList'],
                ['horizontalRule'],
                ['removeformat'],
                ['emoji'],
                ['giphy'],
                ['foreColor', 'backColor'],
                ['noembed'],
                ['upload'],
                ['specialChars'],
                ['preformatted'],
                ['highlight'],
                ['fullscreen']

            ],
            plugins: {
                upload: {
                    serverPath: 'https://api.imgur.com/3/image',
                    fileFieldName: 'image',
                    headers: {
                        'Authorization': 'Client-ID 4e800065cc4246f'
                    },
                    urlPropertyName: 'data.link'
                },
                giphy: {
                    apiKey: 'ZpHfcC99isz3tLrUeJgFbTs3Uzpj63RU'
                }

            }
        });
    </script>

<?php include ('footer.php');
