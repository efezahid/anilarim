<?php
	require 'admin/config.php';
	$memoriesObject = new Memories($db);
	$memories = $memoriesObject->getMemories();
?>
<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href='https://fonts.googleapis.com/css?family=Playfair+Display:700,900|Fira+Sans:400,400italic' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
	<style media="screen">
	.cd-horizontal-timeline .events-content li p * {
		width:100%;
		max-width:100%;
	}
	</style>
	<script src="js/modernizr.js"></script> <!-- Modernizr -->

	<title>Anılarım - Mustafa Zahid Efe</title>
</head>
<body>
<section class="cd-horizontal-timeline">
	<div class="timeline">
		<div class="events-wrapper">
			<div class="events">
				<ol>
					<?php foreach ($memories as $memory) { ?>
					<li><a href="#0" data-date="<?php echo date_format(new DateTime($memory['date']), 'd/m/Y'); ?>"><?php echo date_format(new DateTime($memory['date']), 'd M'); ?></a></li>
					<?php } ?>
				</ol>

				<span class="filling-line" aria-hidden="true"></span>
			</div> <!-- .events -->
		</div> <!-- .events-wrapper -->

		<ul class="cd-timeline-navigation">
			<li><a href="#0" class="prev inactive">Geri</a></li>
			<li><a href="#0" class="next">Ileri</a></li>
		</ul> <!-- .cd-timeline-navigation -->
	</div> <!-- .timeline -->

	<div class="events-content">
		<ol>
			<?php foreach ($memories as $memory) { ?>
			<li data-date="<?php echo date_format(new DateTime($memory['date']), 'd/m/Y'); ?>">
				<h2><?php echo $memory['title'] ?></h2>
				<p>
					<?php echo $memory['content']; ?>
				</p>
				<div class="clearfix"></div>
				<br>
				<p>
					<?php if ($memory['image'] !== ''): ?><img src="<?php echo URL . $memory['image'] ?>"><?php endif; ?>
					<?php echo $memory['video']; ?>
				</p>
			</li>
			<?php } ?>
		</ol>
	</div> <!-- .events-content -->
</section>

<script src="js/jquery-2.1.4.js"></script>
<script src="js/jquery.mobile.custom.min.js"></script>
<script type="text/javascript">
	$(function() {
		$('.events ol li:first a').addClass('selected');
		$('.events-content ol li:first').addClass('selected');
	});
</script>
<script src="js/main.js"></script> <!-- Resource jQuery -->
</body>
</html>
