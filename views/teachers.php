
<section id="main">
  <?php echo $notifPre ?>
  <?php if(!empty($tableSessions) &&  !empty($tableTeachers) && !empty($tableWeeks)){ ?>
  <form enctype="multipart/form-data" action="index.php?action=teachers" method="post">
    <div>
      <select name="selSessions">
        <?php for ($i=0;$i<count($tableSessions);$i++) { ?>
        <option value="<?php echo $tableSessions[$i]->id() ?>"><?php echo $tableSessions[$i]->code().' '.$tableSessions[$i]->sessionName() ?></option>
        <?php } ?>
      </select>

      <select name="selTeachers">
        <?php for ($i=0;$i<count($tableTeachers);$i++) {
                if($tableTeachers[$i]->email() != $admin){?>
        <option value="<?php echo $tableTeachers[$i]->email() ?>"><?php echo $tableTeachers[$i]->firstName().' '.$tableTeachers[$i]->name() ?></option>
                <?php }
              } ?>
      </select>

      <select name="selWeeks">
        <?php for ($i=0;$i<count($tableWeeks);$i++) { ?>
        <option value="<?php echo $tableWeeks[$i]->id() ?>"><?php echo 'Week '.$tableWeeks[$i]->id().' : '.$tableWeeks[$i]->startdate() ?></option>
        <?php } ?>
      </select>
    </div>

    <input type="submit" class="btn btn-primary" name="add_presence_sheet" value="Add presence sheet" />
  </form>

    <?php } else { ?>
        <span class="alert alert-warning"> Must add weeks, teachers and create sessions before ! </span>
    <?php }  ?>

</section>
