<?= validation_errors() ?>

<div class="field">
	<label for="project_name">Name</label>
	<?= form_input('name', set_value('name', $project['name']), 'id="project_name" size="50"') ?>
</div>

<div class="field">
	<label for="client_id">Client</label>
	<?= form_dropdown('client_id', $clients, set_value('client_id', $project['client_id'])) ?>
</div>

<ul>
	<li><label><?= form_checkbox('billable', '1', set_value('billable', $project['billable'])) ?> Billable</label></li>
	<li><label><?= form_checkbox('active', '1', set_value('active', $project['active'])) ?> Active</label></li>
</ul>

