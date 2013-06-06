<h1>New project</h1>

<?= form_open('projects/create') ?> 

<? $this->load->view('projects/_form') ?> 

<div class="buttons">
	<?= form_submit('submit', 'Create project') ?> or
	<?= anchor('projects', 'cancel', array('class' => 'cancel')) ?>
</div>

<?= form_close() ?> 