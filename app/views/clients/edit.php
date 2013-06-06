<h1>Edit client</h1>

<?= form_open("clients/edit/{$client['id']}") ?>

<?= $this->load->view('clients/_form') ?>

<div class="buttons">
	<?= form_submit('submit', 'Update client') ?> or
	<?= anchor('clients', 'cancel', array('class' => 'cancel')) ?>
</div>

<?= form_close() ?>