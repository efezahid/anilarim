<?php DEFINED('URL') ? null : die('Access Denied'); ?>
<div class="panel panel-default">
      <div class="panel-heading">
        Lütfen Giris Yapin
      </div>
      <div class="panel-body">
      <?php
	if (@$_POST) {
          $auth = new Auth($db);
          $login = $auth->login($_POST['email'], $_POST['password']);
          if ($login) {
            echo "<div class=\"alert alert-success\">Giris Basarili, Lutfen Bekleyin</div>";
            header('Refresh:1; url=' . URL . '/admin/index.php');
          } else {
            echo "<div class=\"alert alert-danger\">Kullanici adi veya sifre yanlis</div>";
          }
	}
	?>
	<form action="" method="POST">
          <div class="form-group">
            <label for="email">Email Adresi</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Email Adresi" />
          </div>
          <div class="form-group">
            <label for="password">Sifre</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Sifre" />
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-success" value="Giris Yap">
          </div>
        </form>
      </div>
    </div>
