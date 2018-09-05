<h1 class="ui header">
	<l>Player</l> {player} {player} <i class="flag {country}" title="{country}"></i>{/player} ({total})
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
				<th><l>Map</l></th>
				<th><l>Time</l></th>
			</tr>
		</thead>
		<tbody class="pagination-feed">
			{demos}
			<tr class="pagination-item">
				<td><a href="{url_map}">{map}{mappath}</a></td>
				<td>{timed}</td>
			</tr>
			{/demos}
		</tbody>
	</table>
</div>

{PAGINATION_LINKS}