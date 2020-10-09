<section id="main">
  <div id="managing">
    <form enctype="multipart/form-data" action="index.php?action=series" method="post">
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
<p> Want to add a serie ? </p> <?php echo $notif1 ?>
<form enctype="multipart/form-data" action="index.php?action=series" method="post">
  <p> Num serie : <input type="text" name="num"/>
  <input type="submit" name="add_serie" value="Add serie"/></p>
</form>

<p> Want to delete a serie ? </p> <?php echo $notif2 ?>
<form enctype="multipart/form-data" action="index.php?action=series" method="post">
  <p> Num serie : <input type="text" name="num"/>
  <input type="submit" name="delete_serie" value="Delete serie"/></p>
</form>

<?php echo $notif3 ?>

<form enctype="multipart/form-data" action="index.php?action=series" method="post">
<input type="submit" name="save_series" value="Save series"/>
<div class="table-responsive">
<table class="table-bordered">
<thead>
  <tr>
    <th>Email </th>
    <th>Name </th>
    <th>First Name </th>
    <th>Block </th>
    <?php for ($s=0;$s<count($tableseries);$s++) { ?>
      <th> Serie <?php echo $tableseries[$s]->serieNum() ?> </th>
      <?php } ?>
  </tr>
</thead>
  <tbody>
    <?php for ($i=0;$i<count($tableStudents);$i++) { ?>
      <tr>
      <td><?php echo $tableStudents[$i]->email() ?> </td>
      <td><?php echo $tableStudents[$i]->name() ?> </td>
      <td><?php echo $tableStudents[$i]->firstName() ?></td>
      <td><?php echo $tableStudents[$i]->block() ?> </td>
      <?php for ($j=0;$j<count($tableseries);$j++) { ?>
      <td><input type="radio" name="<?php echo 'line'.$i ?>" value="<?php echo $tableseries[$j]->serieNum() ?>"
          <?php if($tableStudents[$i]->serieNum() == $tableseries[$j]->serieNum()){
                echo 'checked';
              } ?> /></td>
      <?php	} ?>
      </tr>
    <?php } ?>

  </tbody>
</table>
</div>
<input type="submit" name="save_series" value="Save series"/>

</form>

</section>
