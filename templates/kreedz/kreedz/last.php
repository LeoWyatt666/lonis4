<h1 class="ui header">
	<p><l>Last Records</l></p>
</h1>

<div class="ui top attached tabular menu">
	{types}
	<a href="{url}" class="item {active}"><l>{caption}</l></a>
	{/types}
</div>

<div class="ui bottom attached segment">
	<table class="ui selectable celled table">
		<thead>
			<tr>
				<th><l>Map</l></th>
				<th><l>Player</l></th>
				<th><l>Time</l></th>
				<th><l>Checkpoints</l></th>
				<th><l>Teleports</l></th>
				<th><l>Weapon</l></th>
			</tr>
		</thead>
		<tbody class="pagination-feed">
			{maps}
			{if {head}}<tr><td colspan="6" align="center">{date_add}</td></tr>{/if}
			<tr class="pagination-item">
				<td>
					<i class="icon icon-{icon} diff-dot" style="color: {dcolor}" title="{dname}"></i>
					<a href="{url_map}">{map}</a>
				</td>
				<td><a href="{url_player}">{name}</a></td>
				<td>{timed}</td>
				<td><div class="ui {color_nogc} horizontal label">{cp}</div></td>
				<td><div class="ui {color_nogc} horizontal label">{go_cp}</div></td>
				<td class="{color_wpn}"><div class="wpn wpn-{weapon}">&nbsp;</div></td>
			</tr>
			{/maps}
		</tbody>
	</table>
</div>

{PAGINATION_LINKS}