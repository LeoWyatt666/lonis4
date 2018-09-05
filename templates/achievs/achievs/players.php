<h1 class="ui header center aligned">
	<p><l>Achievs Players</l> ({total})</p>
</h1>

<div class="ui link five doubling cards pagination-feed">
	{players}
	<a class="card pagination-item" href="{url_player}">
		<div class="image">
			<img class="" src="{url_image}" title="{name}" oncontextmenu="return false;">
		</div>
		<div class="content">
			<span class="description">
				{name}
				<p><l>Total:</l> {achiev_total}
			</span>
		</div>
	</a>
	{/players}
</div>

{PAGINATION_LINKS}
