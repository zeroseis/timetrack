<div class="line">
	<div class="unit size3of4">
		<h1>Inactive projects</h1>
	</div>
	<div class="unit size1of4 lastUnit">
		<p class="tr"><?= anchor('projects', '&laquo; Back to active projects', 'class="button"') ?></p>
	</div>
</div>

<div class="datagrid">
<table>
	<thead>
		<tr>
			<th>Client</th>
			<th>Project name</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($projects as $p) : ?>
		<tr>
			<td><?= h($p->client_name) ?></td>
			<td><?= h($p->name) ?></td>
			<td>
				<?= anchor("projects/edit/{$p->id}", 'Edit') ?>
				<?= anchor("projects/delete/{$p->id}", 'Delete', array('onclick' => "return confirm('Delete the project?');")) ?>
			</td>
		</tr>
		<? endforeach ?>
	</tbody>
</table>
</div>