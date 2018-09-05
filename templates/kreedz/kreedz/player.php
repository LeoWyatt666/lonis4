<h1 class="ui header">
	<p><l>Player</l> :: <i>{player_name}</i></p>
</h1>

<div class="ui top attached tabular menu">
	{types}
	<a href="{url}" class="item {active}">
		<l>{caption}</l> {if {totals}}<span class="ui label">{totals}</span>{/if}
	</a>
	{/types}
	<div class="right menu">
		{sortes}
		<div class="item {active}">
			<a href="{url}" class=""><l>{caption}</l></a>
		</div>
		{/sortes}
		<div class="item">
			<a href="{url_norec}"><l>Not jumped</l></a>
		</div>
	</div>
</div>

<div class="ui bottom attached segment">
	<table class="ui selectable celled table">
		<thead>
			<tr>
				<th><l>Map</l></th>
				<th><l>Time</l></th>
				<th><l>Checkpoints</l></th>
				<th><l>Teleports</l></th>
				<th><l>Weapon</l></th>
			</tr>
		</thead>
		<tbody class="pagination-feed">
			{maps}
			<tr class="pagination-item">
				<td>
					<i class="icon {icon} diff-dot" style="color: {dcolor}" title="{dname}"></i>
					<a href="{url_map}">{map}</a>
				</td>
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