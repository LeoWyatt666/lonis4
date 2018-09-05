<h1 class="ui header">
	<p><l>Map</l> :: {map}</p>
</h1>

<div class="ui stackable three column grid">
	<div class="column">
		{maprec}
		<div>
			{if {part}}
			<b><a href="{url}" target="_blank">{uname}</a></b>:
			{/if}
			<b>{mappath}</b> {timed} <i>{player}</i>&nbsp;
			<span class="flag-icon flag-icon-{country}" title="{country}">&nbsp;</span>
		</div>
		{/maprec}
	</div>
	<div class="column">
		{mapinfo}
		<div>
			<b><l>Challenge</l></b>: <span class="mapinfo">{dname}</span>
			<i class="icon icon-{icon}" style="color: {dcolor};"></i>
		</div>
		<div>
			<b><l>Type</l></b>: {mtype}
		</div>
		{/mapinfo}
	</div>
	<div class="column right aligned">
		<img  class="map_image" src="{img_map}">
	</div>
</div>

<div class="ui top attached tabular menu">
	{types}
	<a href="{url}" class="item {active}">
		<l>{caption}</l> {if {totals}}<span class="ui label">{totals}</span>{/if}
	</a>
	{/types}
</div>

<div class="ui bottom attached segment">
	<table class="ui selectable celled table">
		<thead>
			<tr>
				<th width="30" align="center">№</th>
				<th><l>Player</l></th>
				<th><l>Time</l></th>
				<th><l>Checkpoints</l></th>
				<th><l>Teleports</l></th>
				<th><l>Weapon</l></th>
			</tr>
		</thead>
		<tbody class="pagination-feed">
			{players}
			<tr class="pagination-item">
				<td>{cup_num}</td>
				<td><a href="{url_player}">{name}</a></td>
				<td>{timed}</td>
				<td><div class="ui {color_nogc} horizontal label">{cp}</div></td>
				<td><div class="ui {color_nogc} horizontal label">{go_cp}</div></td>
				<td class="{color_wpn}"><div class="wpn wpn-{weapon}">&nbsp;</div></td>
			</tr>
			{/players}
		</tbody>
	</table>
</div>

{PAGINATION_LINKS}