<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/bar.css">
    <link rel="stylesheet" href="assets/css/message.css">
    <link rel="stylesheet" href="assets/css/emoji/emoji.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<body>

    <?php include_once('navigation/header.php'); ?>
    <?php include_once('navigation/sidebar.php'); ?>
    
    <!--Chat Container-->
    <div class="message-container">
        <section class="users-content">
            <header>
                <?php
                $user_id = isset($_GET['user_id']) ? mysqli_real_escape_string($conn, $_GET['user_id']) : null;

                if ($user_id) {
                    $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = '$user_id'");
                    if (mysqli_num_rows($sql) > 0) {
                        $row = mysqli_fetch_assoc($sql);
                    } else {
                        // Handle case where user is not found
                        echo "<p>User not found.</p>";
                        exit;
                    }
                } else {
                    echo "<p>User ID is not set.</p>";
                    exit;
                }
                ?>
                <a href="message.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <div class="content">
                    <img src="assets/images/profile/<?php echo $row['img'] ?>" alt="">
                    <div class="details">
                        <span><?php echo $row['fname'] . " " .$row['lname'] ?></span>
                        <p><?php echo $row['status'] ?></p>
                    </div>
                </div> 
            </header>
            <div class="chat-box">
            <!--Compare this snippet from server/get_chat.php-->
            </div>
            <form action="db_connection/send_chat.php" method="POST" class="typing-area" autocomplete="off" enctype="multipart/form-data">
                <button type="button" class="attach-button">
                    <i class="fas fa-paperclip"></i>
                    <input type="file" name="attachment" class="attach-input" style="display: none;">
                </button>
                <input type="text" name="outgoing_id" value="<?php echo $_SESSION['unique_id']?>" hidden>
                <input type="text" name="incoming_id" value="<?php echo $user_id?>" hidden>
                <div class="input-container" style="position: relative;">
                    <input type="text" name="message" class="input-field" placeholder="Type a message here..." data-emojiable="true">
                </div>
                <button type="submit" class="send-button">
                    <i class="fab fa-telegram-plane"></i>
                </button>
            </form>
            <!-- Modal for displaying enlarged images -->
            <div id="imageModal" class="modal" onclick="closeModal()">
                <span class="close" onclick="closeModal()">&times;</span>
                <img class="modal-content" id="modalImage" alt="Enlarged Image">
            </div>
        </section>
    </div>
   
</body>
    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
    <script src="assets/js/chat.js"></script>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <!-- Begin emoji-picker JavaScript -->
    <script src="assets/js/emoji/config.js"></script>
    <script src="assets/js/emoji/util.js"></script>
    <script src="assets/js/emoji/jquery.emojiarea.js"></script>
    <script src="assets/js/emoji/emoji-picker.js"></script>
    <!-- End emoji-picker JavaScript -->

    <script>
        $(function() {
            // Initializes and creates emoji set from sprite sheet
            window.emojiPicker = new EmojiPicker({
                emojiable_selector: '[data-emojiable=true]',
                assetsPath: 'assets/images/emoji',
                popupButtonClasses: 'far fa-smile-beam',
                position: 'top-start',
            });
            // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
            // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
            // It can be called as many times as necessary; previously converted input fields will not be converted again
            window.emojiPicker.discover();
        });
    </script>
</html>
