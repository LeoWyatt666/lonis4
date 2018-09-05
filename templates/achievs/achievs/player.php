<h1 class="ui header">
	<p><l>Player achievs</l> :: <i>{plname}</i></p>
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
			{if {width}}
			<div class="ui indicating demo progress active" data-percent="{width}">
				<div class="bar" style="transition-duration: 300ms; width: {width}%;"></div>
				<div class="label">{progress}/{count} Done</div>
			</div>
			{/if}
			{if {unlocked}}
			<div class="unlocked_time">
				<l>Unlocked</l>{unlocked}
			</div>
			{/if}			
		</div>
	</div>
	{/achievs}
</div>

{PAGINATION_LINKS}