<h1><?= h($project->client_name) ?> – <?= h($project->name) ?></h1>

<p><?= anchor('reports/client/'.$project->client_key, '&laquo; Back to projects') ?></p>

<div class="datagrid">
<table>

	<tbody>
		<? foreach ($tasks as $t) : ?> 
		<tr<? if (! $t->end) : ?> class="pending"<? endif ?>>
			<td><?= display_date('d/m/Y', $t->start) ?></td>
			<td><abbr title="<?= h($t->user_name) ?>" class="tag"><?= h(substr($t->user_name, 0, 1)) ?></abbr></td>
			<td><?= h($t->description) ?></td>
			<td style="width:100px"><?= display_date('H:i', $t->start) . '&mdash;' . display_date('H:i', $t->end) ?></td>
			<td style="width:50px"><?= round(($t->end - $t->start) / 60 / 60, 1) ?> h</td>
		</tr>
		<? endforeach ?> 
	</tbody>
</table>
</div>

<p><strong>Total time worked:</strong> <?= round($total / 60 / 60, 1) ?> hours</p>

<p>
	<? foreach ($users as $u) : ?>
	<span class="tag"><?= h(substr($u->name, 0, 1)) ?></span> = <?= h($u->name) ?>;
	<? endforeach ?>
</p>