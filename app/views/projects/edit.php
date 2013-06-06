<h1>Edit project</h1>

<?= form_open('projects/edit/'.$project['id']) ?> 

<? $this->load->view('projects/_form') ?> 

<div class="buttons">
	<?= form_submit('submit', 'Update project') ?> or
	<?= anchor('projects', 'cancel', array('class' => 'cancel')) ?>
</div>

<?= form_close() ?>