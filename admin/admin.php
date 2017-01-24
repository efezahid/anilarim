<?php DEFINED('URL') ? null : die('Access Denied'); ?>
<div id="content" class="container">
	<a href="<?php echo URL ?>/admin/index.php?logout=true" class="btn btn-danger">Çıkış Yap</a>
	<?php
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($auth);
		echo "<br><div class=\"alert alert-info\">Oturumunuz Sonlandırıldı, Lütfen Bekleyin.</div>";
		header('Refresh:1; url=' .URL . '/admin');
	}

	if (!isset($_GET['memories'])) {
		require 'add.php';
	} else {
		require 'memories.php';
	}
	?>
</div>
<script src="https://cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({ selector:'.tinymce' });</script>
