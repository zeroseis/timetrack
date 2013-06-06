<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="pt">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>TimeTrack</title>
	<?= link_tag('css/master.css') ?>
</head>
<body>
<div id="container">

<div id="header">
	<div class="line">
		<div class="unit size3of4">
			<p id="nav" class="inverse">
				<?= anchor('tasks', 'Tasks') ?> |
				<?= anchor('projects', 'Projects') ?> |
				<?= anchor('clients', 'Clients') ?>
			</p>
		</div>
		<div class="unit size1of4 lastUnit">
			<p class="tr inverse"><?= anchor('users/edit', 'My Info') ?> | <?= anchor('users/logout', 'Logout', 'class="exit"') ?></p>
		</div>
	</div>
</div>

<div id="content">

<? if ($this->session->flashdata('ok')) : ?>
<p class="msg ok"><?= $this->session->flashdata('ok') ?></p>
<? endif ?>

<? $this->load->view($view) ?> 

</div>

<div id="footer">
	<p>TimeTrack <?= date('Y') ?></p>
</div>

</div> <!-- /#container -->
</body>
</html>
