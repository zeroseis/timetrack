<div class="line">
	<div class="unit size3of4">
		<h1>Clients</h1>
	</div>
	<div class="unit size1of4 lastUnit">
		<p class="tr"><?= anchor('clients/create', 'New client', 'class="button add"') ?></p>
	</div>
</div>

<div class="datagrid">
<table>
	<thead>
		<tr>
			<th>Client name</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($clients as $c) : ?>
		<tr>
			<td><?= h($c->name) ?></td>
			<td>
				<?= anchor("clients/edit/{$c->id}", 'Edit') ?>
				<?= anchor("clients/delete/{$c->id}", 'Delete', array('onclick' => "return confirm('Delete the client?');")) ?>
				<?= anchor("reports/client/{$c->key}", 'View report') ?>
			</td>
		</tr>
		<? endforeach ?>
	</tbody>
</table>
</div>