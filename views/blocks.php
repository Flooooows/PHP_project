<section id="main">
      
<div id="managing" >
      <form enctype="multipart/form-data" action="index.php?action=blocks" method="post">
        <div class="btn-group btn-group">
          <input type="submit" class="btn btn-primary" name="block1" value="Managing block 1" />
          <input type="submit" class="btn btn-primary" name="block2" value="Managing block 2" />
          <input type="submit" class="btn btn-primary" name="block3" value="Managing block 3" />
          <input type="submit" class="btn btn-info" name="goteacher" value="Go as a teacher" />
        </div>
      </form>
    </div>
          <?php  if($seestud !== 'ok'){ ?>
         <h4><a href='index.php?action=blocks&amp;see=addstud'>Adding students</a></h4> <?php echo $notifadd ?>
        <?php } else{ ?>
			  <h4> <a href='index.php?action=blocks'>Hide it</a></h4>
  	     <form enctype="multipart/form-data" action="index.php?action=blocks" method="post">
              <p>Add an excel file here to put all the students</p>
              <p>File : <input type="file" name="csv" /></p>
              <p><input type="submit" name="form_add_students" class="btn btn-primary" value="Add Students"></p>
         </form>
        <?php   }  ?>

        <form enctype="multipart/form-data" action="index.php?action=blocks" method="post">
             <p><input type="submit" name="form_delete_all" class="btn btn-danger" value="DELETE YEAR'S DATA"></p>
        </form>
        <?php echo $ndelete ?>

</section>
