<h1 class="page-header" align="center">
	<l>LJ Records</l>
</h1>

<center>
	<div class="ui compact secondary menu">
		{pages}
		<a class="item {active}" href="{url_page}">{fullname}</a>
		{/pages}
	</div>
</center>

{jumps}
	{if {head}}
	<h3 align="center">
		<p><i>{type_name}</i> <i class="ljs ljs-{type}" title="{type_name}"></i></p>
	</h3>

		<table class="ui selectable celled table">
			<thead>
				<tr>
					<th style="width:5%;">№</th>
					<th style="width:30%;"><l>Name</l></th>
					<th style="width:15%;"><l>Distance</l></th>
					<th style="width:15%;"><l>Block</l></th>
					<th style="width:15%;"><l>Prestrafe</l></th>
					<th style="width:15%;"><l>Speed</l></th>
				</tr>
			</thead>
		{/if}
			<tbody>
				<tr>
					<td style="width:5%;">{cup_num}</td>
					<td style="width:30%;">{plname}</td>
					<td style="width:15%;">{distance}</td>
					<td style="width:15%;">{block}</td>
					<td style="width:15%;">{prestrafe}</td>
					<td style="width:15%;">{speed}</td>
				</tr>
			</tbody>
		{if {foot}}
		</table>
		{/if}
{/jumps}