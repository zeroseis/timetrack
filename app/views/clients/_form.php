<?= validation_errors() ?>

<div class="field">
	<label for="client_name">Name</label>
	<?= form_input('name', set_value('name', $client['name']), 'id="client_name" size="30"') ?>
</div>