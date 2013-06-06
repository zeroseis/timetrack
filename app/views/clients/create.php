<h1>New client</h1>

<?= form_open("clients/create") ?>

<?= $this->load->view('clients/_form') ?>

<div class="buttons">
	<?= form_submit('submit', 'Create client') ?> or
	<?= anchor('clients', 'cancel', array('class' => 'cancel')) ?>
</div>

<?= form_close() ?>