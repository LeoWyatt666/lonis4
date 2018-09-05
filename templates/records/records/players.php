<h1 class="ui header">
	<p><l>Records - Players</l></p>
</h1>

<div class="ui top attached tabular menu">
	{comm_list}
	<a href="{url_comm}" class="item {active}">
		{fullname}
		{if {totals}}<span class="ui label">{totals}</span>{/if}
	</a>
	{/comm_list}
</div>

<div class="ui bottom attached segment">
	<table class="ui selectable celled table">
		<thead>
			<tr>
				<th width="15px">№</th>
				<th><l>player</l></th>
				<th><l>All</l></th>
			</tr>
		</thead>
		<tbody class="pagination-feed">
			{players}
			<tr class="pagination-item">
				<td>{cup_num}</td>
				<td><a href="{url_player}">{player}</a></td>
				<td>{count}</td>
			</tr>
			{/players}
		</tbody>
	</table>
</div>

{PAGINATION_LINKS}