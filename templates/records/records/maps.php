<h1 class="ui header">
	<p><l>Maps</l></p>
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
			<th><l>Difficulty</l></th>
			<th><l>Type</l></th>
			<th><l>Authors</l></th>
			<th><l>Date</l></th>
			<th></th>
			</tr>
		</thead>
		<tbody class="pagination-feed">
			{maps}
			<tr class="pagination-item">
				<td>
					<i class="icon icon-{icon} diff-dot" style="color: {dcolor};" title="{dname}"></i>
					<a href="{url_map}">{mapname}</a>
				</td>
				<td>{dname}</td>
				<td>{type}</td>
				<td>{authors}</td>
				<td>{date_old}</td>
				<td><a class="icon icon-download" href="{url_download}" alt="<l>Download</l> {mapname}"></a></td>
			</tr>
			{/maps}
		</tbody>
	</table>
</div>

{PAGINATION_LINKS}