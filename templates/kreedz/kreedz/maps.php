<h1 class="ui header">
	<p><l>Maps</l></p>
</h1>

<div class="ui top attached tabular menu">
	{types}
	<a href="{url}" class="item {active}">
		<l>{caption}</l> {if {totals}}<span class="ui label">{totals}</span>{/if}
	</a>
	{/types}
	<div class="right menu">
		<div class="item">
		{form_open(kreedz/maps,'class="ui form" method="get"')}
		<div class="ui search">
			<div class="ui left icon input">
				<i class="search icon"></i>
				<input type="search" class="prompt" placeholder="Search..." 
					name="q" value="{set_value(q)}" autocomplete="off">
			</div>
		</div>
		{form_close()}
		</div>
	</div>
</div>

<div class="ui bottom attached segment">
	<table id="adaptive" class="ui selectable celled table">
		<thead>
			<tr>
				<th><l>Map</l></th>
				<th><l>player</l></th>
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
				<td><a href="{url_player}">{name}</a></td>
				<td>{timed}</td>
				<td><div class="ui {color_nogc} horizontal label">{cp}</div></td>
				<td><div class="ui {color_nogc} horizontal label">{go_cp}</div></td>
				<td class="{color_wpn}"><span class="wpn wpn-{weapon}">&nbsp;</span></td>
			</tr>
			{/maps}
		</tbody>
	</table>
</div>

{PAGINATION_LINKS}