<div class="line">
	<div class="unit size3of4">
		<h1>Tasks</h1>
	</div>
	<div class="unit size1of4 lastUnit">
		<p class="tr"><?= anchor('tasks/create', 'New task', array('class' => 'button add')) ?></p>
	</div>
</div>

<?= form_open('tasks/filter', array('class' => 'module')) ?> 
<p>
Filter tasks from date <?= form_input('from', $from, 'size="10"'); ?> 
to date <?= form_input('to', $to, 'size="10"') ?> 
for project
<?= form_dropdown('proj', $projects, $proj, 'style="width:200px"') ?> <? if (strripos($this->session->userdata('email'), '@latitude14.com.br') !== false) : ?>
by user <?= form_dropdown('user', $users, $user) ?>
<? endif ?>
<?= form_submit('submit', 'Go!') ?>
</p>
<?= form_close() ?> 

<div class="datagrid">
<table>

	<tbody>
		<? foreach ($tasks as $t) : ?> 
		<tr<? if (! $t->end) : ?> class="pending"<? endif ?>>
			<td><?= display_date('d/m', $t->start) ?></td>
			<td><abbr title="<?= h($t->user_name) ?>" class="tag"><?= h(substr($t->user_name, 0, 1)) ?></abbr></td>
			<td><strong><?= h($t->client_name . ' – ' . $t->project_name) ?></strong>
				| <?= display_date('H:i', $t->start) . ' &ndash; ' . 
				display_date('H:i', $t->end) ?>
				(<?= round(($t->end - $t->start) / 60 / 60, 1) ?>h)<br>
				<?= h($t->description) ?></td>
			<td style="width:60px">
				<?= anchor("tasks/duplicate/{$t->id}", img(array('src'=>'img/page_white_copy.png', 'alt' => 'Duplicate', 'style' => 'vertical-align:bottom')), array('title' => 'Duplicate task')) ?>
				<?= anchor("tasks/edit/{$t->id}", img(array('src'=>'img/page_edit.png', 'alt' => 'Edit', 'style' => 'vertical-align:bottom')), array('title' => 'Edit task')) ?> 
				<?= anchor("tasks/delete/{$t->id}", img(array('src'=>'img/cross.png', 'alt' => 'Delete', 'style' => 'vertical-align:bottom')), array('onclick' => "return confirm('Delete task?')", 'title' => 'Delete task')) ?></td>
		</tr>
		<? endforeach ?> 
	</tbody>
</table>
</div>

<p>Total time: <strong><?= round($total/60/60, 1) ?> hours</strong></p>
