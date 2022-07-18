<?php
//echo "<pre>";
//print_r($data);
?>
<div class="table-responsive">
  <table class="table">
  <caption>List of users</caption>
  <thead>
    <tr>
      <th scope="col">Start Time</th>
      <th scope="col">Meeting Name</th>
      <th scope="col">Meeting Token</th>
      <th scope="col">Password</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row"><?php echo $data->start_time?></th>
      <td><?php echo $data->topic?></td>
      <td><?php echo $data->uuid?></td>
      <td><?php echo $data->password?></td>
      <td>
        <button>Edit</button>
        <button>Delete</button>
      </td>
    </tr>
  </tbody>
</table>
</div>
