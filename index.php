<?php include('main_header.php') ?>
  <body class="w3-theme-l4">
    <div class="w3-card-8 w3-grey" style="width:25%; text-align:center; top:50%; left:50%; transform:translate(-50%, -50%); position:absolute;">
      <div class="w3-container w3-black">
        <h2>Login</h2>
      </div>
      <form class="w3-container" method="post" action="login.php">
        <p>
          <label>Usuario</label>
          <input class="w3-input" type="text" name="username" required>
        </p>
        <p>
          <label>contrase&ntilde;a</label>
          <input class="w3-input" type="password" name="password" required>
        </p>
        <p>
          <input class="w3-btn" type="submit" name="entrar" value="Entrar">
        </p>
      </form>
<?php if(isset($_GET['login'])){
        if($_GET['login'] == 'blocked'){?>
        <footer class="w3-container w3-black">
          <h5>Ha sido bloqueado, espere [inserta tiempo aqui] para volver a intentar.</h5>
        </footer>
        <script>
          $(document).ready(function(){
            $(".w3-input").prop("value","");
            $(".w3-input").prop("disabled",true);
          });
        </script>
<?php  }elseif ($_GET['login'] == 'wrongPass') {   ?>
        <footer class="w3-container w3-black">
          <h5>Contrase&ntilde;a incorrecta.</h5>
        </footer>
<?php  }elseif ($_GET['login'] == 'noUser') {   ?>
        <footer class="w3-container w3-black">
          <h5>Usuario inexistente.</h5>
        </footer>
<?php   }
      } ?>
    </div>
  </body>
</html>
<!--

<div class="w3-half w3-teal w3-container" style="height:600px">
    <div class="w3-padding-64 w3-padding-xlarge w3-center">
      <h1>Contact</h1>
      <p class="w3-opacity">GET IN TOUCH</p>
      <form class="w3-container w3-card-2 w3-padding-32 w3-white">
        <div class="w3-group">
          <label>Name</label>
          <input class="w3-input" style="width:100%;" type="text" required>
        </div>
        <div class="w3-group">
          <label>Name</label>
          <input class="w3-input" style="width:100%;" type="text" required>
        </div>
        <div class="w3-group">
          <label>Subject</label>
          <input class="w3-input" style="width:100%;" type="text" required>
        </div>
        <button type="button" class="w3-btn">Send</button>
      </form>
    </div>
  </div>

-->
