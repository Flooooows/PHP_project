<section id="main">

    <div class="container">
      <div class="row">
        <div class="col-lg-offset-3 col-lg-5 "><h2>Home page</h2>
          <p>Log yourself in.</p>
    			<?php echo $notification; ?>
    				<form action="?action=home" method="post">
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input type="text" class="form-control" name="userMail" placeholder="Put your mail here..." />
              </div>
               <p><input type="submit" name="form_login" value="Log in" class="btn btn-success" ></p>
    				</form>
        </div>
      </div>
    </div>

</section>
