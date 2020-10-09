<section id="main">

  <div id="managing">
    <form enctype="multipart/form-data" action="index.php?action=block" method="post">
      <div class="btn-group btn-group">
        <?php if($_SESSION['allowed'] == 'blocks'){ ?>
        <input type="submit" class="btn btn-warning" name="blocks" value="Return to blocks" />
        <input type="submit" class="btn btn-primary" name="block1" value="Managing block 1" />
        <input type="submit" class="btn btn-primary" name="block2" value="Managing block 2" />
        <input type="submit" class="btn btn-primary" name="block3" value="Managing block 3" />
        <input type="submit" class="btn btn-info" name="goteacher" value="Go as a teacher" />
        <?php } else {  ?>
        <input type="submit" class="btn btn-info" name="goteacher" value="Go as a teacher" />
        <?php } ?>
      </div>
    </form>
  </div>

		<p><strong><?php  echo $_SESSION['block'] ?></strong>&nbsp;<span class="glyphicon glyphicon-education"></span></p>
        <?php if(empty($testCourses)){
                if($seecourses !== 'ok'){ ?>
         <h4><a href='index.php?action=block&amp;see=addcourses'>Adding courses</a></h4><?php echo $notifadd ?>
        <?php } else{ ?>
         <h4><a href='index.php?action=block'>Hide it</a></p></h4>
         <form enctype="multipart/form-data" action="index.php?action=block" method="post">
              <p>Add an excel file here to put all the courses.</p>
              <p><input type="file" name="csv" /></p>
              <p><input type="submit" name="form_add_courses" class="btn btn-primary" value="Add Courses"></p>
         </form>
      <?php   }
            } else { ?>
              <span  class="alert alert-info" >The courses of this block have already been uploaded this year ! </span>
      <?php } ?>

         <h4><a href='index.php?action=series'>Manage series</a></h4>
		 <h4><a href='index.php?action=sessions'>Create sessions</a></h4>
</section>
