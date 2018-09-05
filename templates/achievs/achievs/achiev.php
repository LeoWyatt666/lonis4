<h1 class="ui header center aligned">
	<p><l>Achiev</l> ({total})</p>
</h1>

<div class="ui divided items">
	{achiev}
	<div class="link item">
		<div class="ui tiny image">
			<img src="{img_achiev}">
		</div>
		<div class="content">
			<div class="header">{name}</div>
			<div class="description">
				{desc}
			</div>		
		</div>
	</div>
	{/achiev}
</div>

<div class="ui divider"></div>

<div class="ui link five doubling cards pagination-feed">
	{players}
	<a class="card pagination-item" href="{url_player}" >
		<div class="image">
			<img class="" src="{img_player}" title="{plname}" oncontextmenu="return false;">
		</div>
		<div class="content">
			<span class="description">
				{plname}
				<p><l>Total:</l> {achiev_total}
			</span>
		</div>
	</a>
	{/players}
</div>

{PAGINATION_LINKS}
