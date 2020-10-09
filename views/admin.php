
<section id="main">
      <?php  if($seeteach !== 'ok'){ ?>
        <h4><a href='index.php?action=admin&amp;see=addteachers'>Adding teachers</a></h4> <?php echo $notifteacher ?>
      <?php } else{ ?>
      <h4><a href='index.php?action=admin'>Hide it</a></h4>
      <form enctype="multipart/form-data" action="index.php?action=admin" method="post">
        <p>Add an excel file to add the teachers here.</p>
        <p><input type="file" name="csv"  /></p>
        <p><input type="submit" name="form_add_csv" class="btn btn-primary" value="Add teachers"></p>
      </form>
      <?php   }  ?>

      <?php if($testweeks != null){ ?>
            <h4 class="alert alert-info"> Agenda has already been uploaded this year ! </h4>
      <?php } else {
          if($seeweeks !== 'ok'){ ?>
          <h4><a href='index.php?action=admin&amp;see=addweeks'>Adding weeks</a></h4> <?php echo $notif ?>
        <?php } else{ ?>
        <h4><a href='index.php?action=admin'>Hide it</a></h4>
        <form enctype="multipart/form-data" action="index.php?action=admin" method="post">
          <p>Add an excel file to add the agenda here.</p>
          <p><input type="file" name="agenda" /></p>
          <p><input type="submit" name="form_add_agenda" class="btn btn-primary" value="Add weeks"></p>
        </form>
      <?php  }
          } ?>

          <form enctype="multipart/form-data" action="index.php?action=admin" method="post">
               <p><input type="submit" name="form_delete_all" class="btn btn-danger" value="DELETE YEAR'S DATA"></p>
          </form>
          <?php echo $ndelete ?>
</section>
