<h1 class="ui header center aligned">
	<l>Achievs</l> ({total})
</h1>

<div class="ui divided items pagination-feed">
	{achievs}
	<div class="link item pagination-item">
		<div class="ui tiny image">
			<img src="{img_achiev}">
		</div>
		<div class="content">
			<a class="header" href="{url_achiev}">{name}</a>
			<div class="description">
				{desc}
			</div>
			<br>
			<div class="ui indicating demo progress active" data-percent="{completer}">
				<div class="bar" style="transition-duration: 300ms; width: {completer}%;"></div>
				<div class="label">{completer}% Done</div>
			</div>
		</div>
	</div>
	{/achievs}
</div>

{PAGINATION_LINKS}