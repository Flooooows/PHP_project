<section id="main" >
  <div id="managing">
    <form enctype="multipart/form-data" action="index.php?action=sessions" method="post">
      <div class="btn-group btn-group">
        <?php if($_SESSION['allowed'] == 'blocks'){ ?>
        <input type="submit" class="btn btn-warning" name="blocks" value="Return to blocks" />
        <input type="submit" class="btn btn-primary" name="block1" value="Managing block 1" />
        <input type="submit" class="btn btn-primary" name="block2" value="Managing block 2" />
        <input type="submit" class="btn btn-primary" name="block3" value="Managing block 3" />
        <?php } elseif($_SESSION['block'] == 'bloc1'){ ?>
        <input type="submit" class="btn btn-primary" name="block1" value="Managing block 1" />
        <?php } elseif($_SESSION['block'] == 'bloc2'){ ?>
        <input type="submit" class="btn btn-primary" name="block2" value="Managing block 2" />
        <?php } elseif($_SESSION['block'] == 'bloc3'){ ?>
        <input type="submit" class="btn btn-primary" name="block3" value="Managing block 3" />
        <?php } ?>
      </div>
    </form>
  </div>
  <p><strong><?php  echo $_SESSION['block'] ?></strong>&nbsp;<span class="glyphicon glyphicon-education"></span></p>
  <?php if(!empty($tableSeries) && !empty($tableCourses)){   echo $notif1; ?>
  <form enctype="multipart/form-data" action="index.php?action=sessions" method="post">
	<div>
		<select name="selCourses">
		<?php for ($i=0;$i<count($tableCourses);$i++) { ?>
			<option value="<?php echo $tableCourses[$i]->code() ?>"><?php echo $tableCourses[$i]->code().' '.$tableCourses[$i]->name() ?></option>
		<?php } ?>
		</select>
		<input type="text" name="sessionName" placeholder="Name for the session" />
	</div>
	<div class="vertical-align">
	<?php for ($s=0;$s<count($tableSeries);$s++) { ?>
				<span>Serie <?php echo $tableSeries[$s]->serieNum() ?>
					<input type="checkbox" name="serie[]" value="<?php echo $tableSeries[$s]->serieNum() ?>"></span>
	<?php } ?>
	</div>
	</br>
	<div>
	<p> Type :
	<select name="selType">
		<option value="x"> X </option>
		<option value="xo"> XO </option>
		<option value="note"> Note </option>
	</select> </p>
	<input type="submit" class="btn btn-primary" name="add_session" value="Add Session" />
	</div>
  </form>
  <?php }  else { ?>
    <span class="alert alert-warning"><strong> Wait ! </strong>Please add series and courses before creating sessions</span>
  <?php } ?>
</section>
