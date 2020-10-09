
<section id="main">
  <?php if(!empty($tablePrecenses)){ ?>
  <div class="table-responsive">

    <table class="table-bordered">
      <thead>
        <tr>
          <th>Course name </th>
          <th>Session name </th>
          <th>Type </th>
          <th>Presence </th>
          <th>Week </th>
        </tr>
      </thead>
      <tbody>
        <?php for ($i=0;$i<count($tablePrecenses);$i++) { ?>
          <tr>
          <td><?php echo $tablePrecenses[$i]->courseName() ?> </td>
          <td><?php echo $tablePrecenses[$i]->sessionName() ?> </td>
          <td><?php echo $tablePrecenses[$i]->type() ?> </td>
          <td><?php echo $tablePrecenses[$i]->presence() ?></td>
          <td><?php echo $tablePrecenses[$i]->startDate() ?> </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

  </div>
  <?php } else { ?>
      <span class="alert alert-info">There is no presence</span>
      <?php } ?>
</section>
