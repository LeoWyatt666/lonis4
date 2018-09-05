<h1 class="ui header">
	<p><l>Duels</l> <span class="ui label">{total}</span></p>
</h1>

<table class="ui selectable celled table">
	<thead>
		<tr>
			<th><l>Map</l></th>
			<th><l>Winner</l></th>
			<th><l>Looser</l></th>
			<th><l>Winner Point</l></th>
			<th><l>Looser Point</l></th>
		</tr>
	</thead>
	<tbody class="pagination-feed">
	{duels}
		<tr class="pagination-item">
			<td scope="row">
				<a href="{url_map}">{map}</a>
			</td>
			<td>
				<a href="{url_winner}">{winnerName}</a>
			</td>
			<td>
				<a href="{url_looser}">{looserName}</a>
			</td>
			<td>{winnerPoints}</td>
			<td>{looserPoints}</td>
		</tr>
		{/duels}
	</tbody>
</table>

{PAGINATION_LINKS}