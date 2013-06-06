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

<div id="content">

<? $this->load->view($view) ?> 

</div>

<div id="footer">
	<p>TimeTrack <?= date('Y') ?></p>
</div>

</div> <!-- /#container -->
</body>
</html>
