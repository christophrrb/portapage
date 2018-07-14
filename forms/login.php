<?php
  $page_title = "Login";
  include_once $_SERVER['DOCUMENT_ROOT'] . '/portapage/web-assets/tpl/app_header.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/portapage/web-assets/tpl/app_nav.php';
?>

<div class="col-md-2"></div>
<div class="col-md-8">
  <div class="card">
    <div class="card-header">Login</div>
    <div class="card-body">
      <form action="/portapage/index.php?action=login" method="post">
        <!-- Email -->
        <div class="form-group row">
          <label for="email" class="col-md-2">Email</label>
          <input type="email" name="email_id" id="email" class="col-md-10">
        </div>
        <!-- Password -->
        <div class="form-group row">
          <label for="pw" class="col-md-2">Password</label>
          <input type="password" name="pw" id="pw" class="col-md-10">
        </div>
        <!-- Submit -->
        <div class="form-group row">
          <button type="submit" name="email" class="btn btn-primary" style="float: right;">Submit</button>  <!--TODO Make button float right.-->
        </div>
      </form>
    </div>
  </div>
</div>
<div class="col-md-2"></div>
