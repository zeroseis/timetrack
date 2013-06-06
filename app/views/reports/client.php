<h1>Time report &mdash; <?= h($client->name) ?></h1>

<div class="datagrid">
<table>
	<thead>
		<tr>
			<th>Project name</th>
			<th>Time worked</th>
			<th>Last activity</th>
			<th style="width:40px" class="tc">Details</th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($projects as $p) : ?>
		<tr>
			<td><?= anchor("reports/project/{$client->key}/{$p->id}", h($p->name), 'title="View tasks"') ?></td>
			<td><?= round($p->time / 60 / 60, 1) ?> h</td>
			<td><?= date('d/m/Y', $p->last_activity) ?></td>
			<td class="tc"><?= anchor("reports/project/{$client->key}/{$p->id}", img(array('src' => 'img/magnifier.png', 'alt' => 'View tasks'))) ?></td>
		</tr>
		<? endforeach ?>
	</tbody>
</table>
</div>

<p><strong>Total time worked:</strong> <?= round($total / 60 / 60, 1) ?> hours</p>
