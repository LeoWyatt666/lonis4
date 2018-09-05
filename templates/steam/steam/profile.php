<h1 class="ui dividing header centered">
    Steam Profile
</h1>

{if {steam_id_64} != ""}
<div class="ui centered card">
	<div class="image">
    <a href="{profileurl}" target="_blank">
      <img src="{avatarfull}" class="ui centered circular image">
    </a>
	</div>
	<div class="content">
		<a class="header">{name}</a>
		<div class="meta">
		<span class="date">
			<i class="flag {loccountrycode}"></i> {country_name}
		</span>
		</div>
		<div class="description">
			<p><l>SteamID</l>: <a href="{profileurl}" target="_blank">{steamid}</a>
			<p><l>Persona Name</l>: {personaname}
			<p><l>Real Name</l>: {realname}
			<p><l>Lact Active</l>: {lastactive}
		</div>
	</div>
  
	<div class="extra content">
    <div class="ui two buttons">
        <div id="act_update" class="ui basic green button">Update</div>
        <div id="act_delete" class="ui basic red button">Delete</div>
    </div>
	</div>
</div>
{else}
<div align="center">
  <a align="center" href="hauth/window/Steam" class="ui button center">Attach</a>
  <div style="color: red; padding-top: 10px;">{message}</div>
</div>
{/if}

<div class="ui horizontal divider">Or back</div>
<center>
  <a href="cstrike/profile" class="ui button">Profile</a>
</center>

<div id="modal_update" class="ui mini modal">
  <div class="header">
    Update steam?
  </div>
  <div class="actions">
    {form_open()}
      <div class="ui negative button">Cancel</div>
      <button name="act" value="update" class="ui positive button">OK</button>
    {form_close()} 
  </div>
</div>

<div id="modal_delete" class="ui mini modal">
  <div class="header">
    Delete steam?
  </div>
  <div class="actions">
    {form_open()}
      <div class="ui negative button">Cancel</div>
      <button name="act" value="delete" class="ui positive button">OK</button>
    {form_close()} 
  </div>
</div>

<script>
$('#act_update').click(function(){ $('#modal_update').modal('show'); });
$('#act_delete').click(function(){ $('#modal_delete').modal('show'); });
</script>