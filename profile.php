<?php
include_once '10.10.168.100/includes/db_connect.php';
?>

<form>
  <div class="form-group">
    <label>Name</label>
    <label >Job Id</label>

  </div>
  <div class="form-group">
    <small id="emailHelp" class="form-text text-muted">You are only allowed to change the password</small>
    <label for="exampleInputEmail1">Old password</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">

  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">New password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>

  <button type="submit" class="btn btn-sm" style="background-color:#011627;color:white">Change password</button>
</form>
