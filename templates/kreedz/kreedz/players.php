<h1 class="ui header">
	<p><l>Players</l></p>
</h1>

<div class="ui top attached tabular menu">
	{types}
	<a href="{url}" class="item {active}">
		<l>{caption}</l> {if {totals}}<span class="ui label">{totals}</span>{/if}
	</a>
	{/types}
	<div class="right menu">
		<div class="item">
			{form_open(kreedz/players,'class="ui form" method="get"')}
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
	<table class="ui selectable celled table">
		<thead>
			<tr>
				<th style="width: 30px; text-align: center">№</th>
				<th><l>{Player}</l></th>
				<th><a href="{url_all}"><l>Total</l></a></th>
				<th><a href="{url_top1}"><l>First</l></a></th>
			</tr>
		</thead>
		<tbody class="pagination-feed">
			{players}
			<tr class="pagination-item">
				<td scope="row" style="text-align: center">
					{cup_num}
				</td>
				<td><a href="{url_player}">{name}</a></td>
				<td>{all}</td>
				<td>{top1}</td>
			</tr>
			{/players}
		</tbody>
	</table>
</div>

{PAGINATION_LINKS}