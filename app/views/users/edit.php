<h1>My Info</h1>

<?= form_open("users/edit/{$user->id}") ?>

<?= validation_errors() ?>

<div class="field">
	<label for="user_name">Name</label>
	<?= form_input('name', set_value('name', $user->name), 'size="40" class="wide" id="user_name"') ?>
</div>
<? if (strripos($this->session->userdata('email'), '@latitude14.com.br') !== false) : ?> 
<div class="field">
	<label for="user_email">Email</label>
	<?= form_input('email', set_value('email', $user->email), 'size="40" class="wide" id="user_email"') ?>
</div>
<? endif ?>
<div class="field">
	<label for="user_password">Password</label>
	<?= form_password('password', set_value('password'), 'size="12" id="user_password"') ?> 
</div>

<div class="field">
	<label for="user_confirm">Password again</label>
	<?= form_password('confirm', set_value('confirm'), 'size="12" id="user_confirm"') ?> 
</div>


<div class="buttons">
	<?= form_submit('submit', 'Update my info') ?> or 
	<?= anchor('tasks', 'cancel', array('class' => 'cancel')) ?>
</div>

<?= form_close() ?>