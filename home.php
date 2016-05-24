<?php
      include('main_header.php');
      include('session_check.php');
?>
  <body>
    <!-- Navbar -->
    <ul class="w3-navbar w3-theme w3-top w3-left-align w3-large" style="z-index:4;">
      <li class="w3-opennav w3-right w3-hide-large">
        <a class="w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
      </li>
      <li><a href="#" class="w3-theme-l1">Logo</a></li>
      <li class="w3-hide-small"><a href="#" class="w3-hover-white">About</a></li>
      <li class="w3-hide-small"><a href="#" class="w3-hover-white">News</a></li>
    </ul>

    <!-- Sidenav -->
    <nav class="w3-sidenav w3-collapse w3-theme-l5 w3-animate-left" style="z-index:3;width:250px;margin-top:51px;">
      <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="close menu">
        <i class="fa fa-remove"></i>
      </a>
      <h4><b>Menu</b></h4>
      <a href="#" class="w3-hover-black">Link</a>
      <a href="http://localhost/thesis/logout.php" class="w3-hover-black">Logout</a>
    </nav>

    <!-- Overlay effect when opening sidenav on small screens -->
    <div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu"></div>

    <!-- Main content: shift it to the right by 250 pixels when the sidenav is visible -->
    <div class="w3-main" style="margin-left:250px">
      <div class="w3-row  w3-padding-jumbo w3-theme-l2">

      </div>
      <div class="w3-row  w3-padding-jumbo w3-theme-l2">

            <div id="chatbox" class="w3-container w3-white"  style="height:600px;">
              <?php
                if(file_exists("log.html") && filesize("log.html") > 0){
                    $handle = fopen("log.html", "r");
                    $contents = fread($handle, filesize("log.html"));
                    fclose($handle);

                    echo $contents;
                }
              ?>
            </div>
            <form id="message">
              <input name="usermsg" type="text" id="usermsg" class="w3-input w3-border" style="float:left;" />
              <input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
            </form>

      </div>
      <script type="text/javascript">
        // jQuery Document
        $(document).ready(function(){

          $('#message').submit(function(event) {
            event.preventDefault(); // Prevent the form from submitting via the browser
            var form = $(this);
            $.ajax({
              type: "POST",
              url: "ajax/post.php",
              data: form.serialize(),
            }).done(function(data) {
              $("#usermsg").val('');
            }).fail(function(data) {
              alert(data);
            });
          });

          //Load the file containing the chat log
          function loadLog(){
        		var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request
        		$.ajax({
        			url: "log.html",
        			cache: false,
        			success: function(html){
        				$("#chatbox").html(html); //Insert chat log into the #chatbox div

        				//Auto-scroll
        				var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height after the request
        				if(newscrollHeight > oldscrollHeight){
        					$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
        				}
        		  	},
        		});
      	   }

           setInterval (loadLog, 2500);

        });
      </script>

      <footer id="myFooter">
        <div class="w3-container w3-theme-l2 w3-padding-32">
          <h4>Footer</h4>
        </div>

        <div class="w3-container w3-theme-l1">
          <p>Powered by <a href="http://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
        </div>
      </footer>
    <!-- END MAIN -->
    </div>

    <script>
    // Script to open and close the sidenav
    function w3_open() {
        document.getElementsByClassName("w3-sidenav")[0].style.display = "block";
        document.getElementsByClassName("w3-overlay")[0].style.display = "block";
    }

    function w3_close() {
        document.getElementsByClassName("w3-sidenav")[0].style.display = "none";
        document.getElementsByClassName("w3-overlay")[0].style.display = "none";
    }
    </script>

  </body>
</html>