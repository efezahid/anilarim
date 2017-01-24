<?php DEFINED('URL') ? null : die('Access Denied'); ?>
<a href="<?php echo URL ?>/admin/index.php" class="btn btn-success">Yeni Anı Ekle</a>
<div class="clearfix"></div>
<br>
<?php
$memoriesObject = new Memories($db);
$memories = $memoriesObject->getMemories();
if (count($memories) > 0) {
  foreach ($memories as $memory) {
?>
<div class="panel panel-default">
  <div class="panel-heading toggle-panel">
    <?php echo substr($memory['date'], 0, 10); ?> - <?php echo $memory['title']; ?>
  </div>
  <div class="panel-body">
      <div class="form-group">
        <label for="title">Başlık</label>
        <p><?php echo $memory['title']; ?></p>
      </div>
      <div class="form-group">
        <label for="content">İçerik</label>
        <p><?php echo $memory['content']; ?></p>
      </div>
      <div class="form-group">
        <label for="date">Tarih</label>
        <p><?php echo date_format(new DateTime($memory['date']), 'm/d/Y'); ?></p>
      </div>
      <?php if ($memory['image'] !== '') { ?>
      <div class="form-group">
        <label>Resim</label><br>
        <img src="<?php echo URL . $memory['image']; ?>" style="width:50%; height:auto; border:5px solid #f1f1f1; border-radius:5px;">
      </div>
      <?php } ?>
      <div class="clearfix"></div>
      <br>
      <div class="form-group">
        <label for="video">Iframe Kodu</label><br>
        <?php echo $memory['video']; ?>
      </div>
      <div class="clearfix"></div>
      <br>
      <a href="<?php echo URL; ?>/admin/index.php?id=<?php echo $memory['id']; ?>" class="btn btn-warning">Düzenle</a>
  </div>
</div>
<?php
    }
  } else {
    echo "<div class=\"alert alert-info\">Hiç Anı Bulunamadı</div>";
  }
?>
