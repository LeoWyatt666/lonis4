<h1 class="ui dividing header">
    <div align="center">CS Profile</div>
</h1>

<div class="ui grid">
  <div class="four wide column" align="center">
    <img src="{img_avatar}" class="image_c">
  </div>
  <div class="eight wide column">
    {form_open(, class="ui form")}
      <div class="field">
        <label>Name</label>
        <input type="text" name="name" value="{name}" placeholder="">
        <p><div>{form_error(name)} </div>
      </div>

      <div class="field">
        <label>Password</label>
        <input type="password" name="password" placeholder="">
      </div>

      <div class="field">
        <label>IP</label>
        <input type="text" name="ip" value="{ip}" placeholder="">
      </div>

      <div class="fields">
        <div class="twelve wide field">
          <label>SteamId</label>
          <input type="text" value="{steam_id_64}" readonly="" placeholder="">
        </div>

        <div class="four wide field">
          <label>&nbsp;</label>
            <a href="hauth/steam/profile" class="ui basic green button">Edit</a>
        </div>
      </div>

      <div class="field">
        <label>ICQ</label>
        <input type="text" name="icq" value="{icq}" placeholder="">
      </div>

      <div class="fields">
        <div class="twelve wide field">
          <button class="ui button">Update</button>
        </div>
      </div>

      {form_close()}
  </div>
</div>