<h1 class="ui header">
	<p>
		<l>Compare</l>
		{if {total}}<span class="ui label">{total}</span>{/if}
	</p>
</h1>

<table class="ui selectable celled table">
	<thead>
		<tr>
			<th><l>Map</l></th>
			<th><l>World record</l></th>
			<th><l>Russian record</l></th>
			<th><l>Server Record</l></th>
		</tr>
	</thead>
	<tbody class="pagination-feed">
		{records}
		<tr class="pagination-item">
			<td><a href="{url_map}">{map}{mappath}</a></td>
			<td>{wr_timed} <i>{wr_player}</i></td>
			<td>{comm_timed} <i>{comm_player}</i></td>
			<td>{top_timed} <i>{top_player}</i></td>
		</tr>
		{/records}
	</tbody>
</table>

{PAGINATION_LINKS}