<?php DEFINED('URL') ? null : die('Access Denied'); ?>
<a href="<?php echo URL ?>/admin/index.php?memories=true" class="btn btn-warning">Anıları Göster</a>
<div class="clearfix"></div>
<br>
<div class="panel panel-default">
  <div class="panel-heading">
    Anı Kaydet
  </div>
  <div class="panel-body">
    <?php
    $id = 0;
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
      $memoryObject = new Memory($db, $_GET['id']);
      $memory = $memoryObject->getMemory();
    }

    if (isset($_POST['deleteForm'])) {
      $delete = $memoryObject->deleteMemory($id);
      if ($delete === true) {
        if ($memory['image'] !== '')
          unlink(realpath('..') . $memory['image']);
        echo "<div class=\"alert alert-info\">Anı Başarılı Bir Şekilde Silindi, Lütfen Bekleyin</div>";
        header('Refresh:1; url=' . URL . '/admin/index.php');
      }
    }

    if (isset($_POST['new_memory'])) {
      // Upload File
      $image = $_FILES['image'];
      $imagePath = '';
      if (isset($memory)) {
        $imagePath = $memory['image'];
      }

      if (isset($_POST['delete']) && $_POST['delete'] === 'on') {
        unlink(realpath('..') . $imagePath);
        $imagePath = '';
      }

      if (!empty($image['name'])) {
        if (is_uploaded_file($image['tmp_name'])) {
          $imagePath = '/uploads/' . uniqid() . str_replace(' ', '-', $image['name']);
          $move = move_uploaded_file($image['tmp_name'], realpath('..') . $imagePath);
          if (!$move) {
            echo "<div class=\"alert alert-danger\">Resim Yüklenemiyor</div>";
            goto form;
          }
        } else {
          echo "<div class=\"alert alert-danger\">Resim Yüklenemiyor</div>";
          goto form;
        }
      }

      $memory = new Memory($db, $id);
      $update = $id === 0 ? false : true;
      $newMemory = $memory->saveMemory(
        $_POST['title'],
        $_POST['content'],
        $_POST['date'],
        $imagePath,
        $_POST['video'],
        $update
      );
      if ($newMemory !== false) {
        echo "<div class=\"alert alert-success\">Anı Başarılı Bir Şekilde Kaydedildi, Lütfen Bekleyin.</div>";
        header('Refresh: 1; url=' . URL . '/admin/index.php?id=' . $newMemory);
      } else {
        echo "<div class=\"alert alert-danger\">Anı Veritabanı Hatası Nedeniyle Kaydedilemedi.</div>";
      }

      form:
    }
    ?>
    <form action="" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="title">Başlık</label>
        <input type="text" class="form-control" id="title" value="<?php echo isset($memory) ? $memory['title'] : null; ?>" name="title" placeholder="Başlık" />
      </div>
      <div class="form-group">
        <label for="content">İçerik</label>
        <textarea class="form-control tinymce" name="content" id="content"><?php echo isset($memory) ? $memory['content'] : null; ?></textarea>
      </div>
      <div class="form-group">
        <label for="date">Tarih</label>
        <input type="text" name="date" id="date" class="form-control datepicker" value="<?php echo isset($memory) ? date_format(new DateTime($memory['date']), 'm/d/Y') : null; ?>" />
      </div>
      <div class="form-group">
        <label for="resim">Resim</label>
        <input type="file" name="image" id="resim" class="form-control">
      </div>
      <?php if (isset($memory) && $memory['image'] !== '') { ?>
      <div class="form-group">
        <input type="checkbox" name="delete" id="delete">
        <label for="delete">Resmi Silmek İçin Seçin</label>
      </div>
      <?php if (isset($memory)) { ?>
        <img src="<?php echo URL . $memory['image']; ?>" style="width:50%; height:auto; border:5px solid #f1f1f1; border-radius:5px;">
      <?php } ?>
      <div class="clearfix"></div>
      <br>
      <?php } ?>
      <div class="form-group">
        <label for="video">Iframe Kodu</label>
        <textarea name="video" id="video" class="form-control" style="resize:none;"><?php echo isset($memory) ? $memory['video'] : null; ?></textarea>
      </div>
      <?php
      if (isset($memory)) {
        echo $memory['video'];
      }
      ?>
      <div class="clearfix"></div>
      <br>
      <div class="form-group">
        <input type="submit" class="btn btn-success" name="new_memory" value="Kaydet">
      </div>
    </form>
    <?php if (isset($memory)) { ?>
    <form action="" method="POST">
      <input type="submit" class="btn btn-danger" name="deleteForm" value="Anıyı Sil">
    </form>
    <?php } ?>
  </div>
</div>
