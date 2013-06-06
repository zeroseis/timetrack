<h1>New task</h1>

<?= form_open("tasks/create") ?>

<? $this->load->view('tasks/_form') ?>

<div class="buttons">
	<?= form_submit('submit', 'Create task') ?> or <?= anchor('tasks', 'cancel', array('class' => 'cancel')) ?>
</div>

<?= form_close() ?>