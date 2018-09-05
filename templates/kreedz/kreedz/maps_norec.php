<h1 class="ui header">
	<p><l>Maps</l> <l>Not jumped</l> ({total}) </p>
</h1>

<div class="ui link five doubling cards pagination-feed">
	{maps}
	<span class="card pagination-item">
		<div class="image">
			<img class="" src="{img_map}" title="{mapname}" oncontextmenu="return false;">
		</div>
		<div class="content">
			<a class="description">{mapname}</a>
		</div>
	</span>
	{/maps}
</div>

{PAGINATION_LINKS}