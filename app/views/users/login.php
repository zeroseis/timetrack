<h1>Login</h1>

<?= form_open('users/login') ?>

<?= validation_errors() ?> 

<div class="field">
	<label for="user_email">E-mail</label>
	<?= form_input('email', set_value('email'), 'id="user_email" size="30"') ?> 
</div>

<div class="field">
	<label for="user_pass">Password</label>
	<?= form_password('pass', '', 'id="user_pass" size="10"') ?>
</div>

<div class="buttons">
	<?= form_submit('submit', 'Login') ?>
</div>

<?= form_close() ?>