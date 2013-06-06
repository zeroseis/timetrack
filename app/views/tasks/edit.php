<h1>Edit task</h1>

<?= form_open("tasks/edit/{$task['id']}") ?>

<? $this->load->view('tasks/_form') ?>

<div class="buttons">
	<?= form_submit('submit', 'Update task') ?> or 
	<?= anchor('tasks', 'cancel', array('class' => 'cancel')) ?>
</div>

<?= form_close() ?>