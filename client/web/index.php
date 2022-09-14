<?php

$WEBSOCKET_ADDRESS = "wss://chat.goghost.xyz/socket/";

$user_id = file_get_contents("https://api.goghost.xyz/server.php?call=getid");

session_start();
if(isset($_GET['delete'])){
    session_abort();
}
?>
<!DOCTYPE html>
<html lang="en" height="100%">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <Title>Ghost chat</Title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/litera/bootstrap.min.css"> <!-- #TODO localy deliver stylesheet to be compliant with GDPR -->
        <link rel="stylesheet" href="/style/main.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <script
			  src="https://code.jquery.com/jquery-3.6.1.min.js"
			  integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
			  crossorigin="anonymous"></script>
              <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
		<!-- #TODO localy deliver jquery and boostrapjs to be compliant with GDPR -->


        <script>
            function showMessage(messageHTML) {
                    $('#chat-box').append(messageHTML);
            }

                $(document).ready(function(){
                var websocket = new WebSocket("<?php echo $WEBSOCKET_ADDRESS; ?>");
                    websocket.onopen = function(event) {
                            showMessage("<div class='chat-connection-ack'>Connection is established!</div>");
                    };
                    websocket.onmessage = function(event) {
                            var Data = JSON.parse(event.data);
                            // showMessage("<div class='"+Data.message_type+"'>"+Data.message+"</div>");
                            showMessage("<div class=\'incoming_msg\' id='" + Data.message_type + "'><div class=\'incoming_msg_img\'> <img src=\'https://qph.fs.quoracdn.net/main-qimg-7ca600a4562ef6a81f4dc2bd5c99fee9-c\' alt=\'anon\'> </div><div class='received_msg'><div class='received_withd_msg'><p> " + Data.message + " </p></div>");
                            $('#chat-message').val('');
                    };

                    websocket.onerror = function(event){
                            showMessage("<div class='error'>Problem due to some Error</div>");
                    };
                    websocket.onclose = function(event){
                            showMessage("<div class='chat-connection-ack'>Connection Closed</div>");
                    };

                    $('#frmChat').on("submit",function(event){
                            event.preventDefault();
                            $('#chat-user').attr("type","hidden");
                            var messageJSON = {
                                    chat_user: $('#chat-user').val(),
                                    chat_message: $('#chat-message').val()
                            };
                            websocket.send(JSON.stringify(messageJSON));
                    });
            });
        </script>
    </head>
    <body>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Encrochat</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">-</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?delete">Destroy session</a>
            </li>
            </ul>
            <span class="navbar-text">
            Navbar text with an inline element
            </span>
        </div>
    </nav>
    <div class="container">
    <div class="messaging">
        <div class="inbox_msg">
            <div class="inbox_people">
            <div class="headind_srch">
                <div class="recent_heading">
                <h4>Recent</h4>
                </div>
                <div class="srch_bar">
                <div class="stylish-input-group">
                    <input type="text" class="search-bar"  placeholder="Search" >
                    <span class="input-group-addon">
                    <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                    </span> </div>
                </div>
            </div>
            <div class="inbox_chat">
                <div class="chat_list active_chat">
                <div class="chat_people">
                    <div class="chat_img">  </div>
                    <div class="chat_ib">
                    <h5>Multi chat <span class="chat_date">Dec 25</span></h5>
                    <p>Group chat with Ghost users</p>
                    </div>
                </div>
                </div>

                <!--<div class="chat_list">
                <div class="chat_people">
                    <div class="chat_img"> <img src="https://qph.fs.quoracdn.net/main-qimg-7ca600a4562ef6a81f4dc2bd5c99fee9-c" alt="anon"> </div>
                    <div class="chat_ib">
                    <h5>Anonymous <span class="chat_date">Dec 25</span></h5>
                    <p>Lorem ipsum, dolor sit amet</p>
                    </div>
                </div>
                </div>-->
            </div>
            </div>
            <div class="mesgs">
            <div class="headind_srch">
                <div class="recent_heading">
                <h4>Group chat</h4>
                </div>
            </div><br>
            <form name="frmChat" id="frmChat">
                <div id="chat-box"></div>
                <input type="text" name="chat-user" id="chat-user" placeholder="Name" class="chat-input" value="<?php echo $user_id; ?>" style="display:none;" required />
                
                <br>
                <div class="type_msg">
                    <div class="input_msg_write">
                    <input type="text" class="write_msg" placeholder="Type a message" name="chat-message" id="chat-message"  required />
                    <button class="msg_send_btn" type="submit"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                    </div>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>

    </body>
</html>