<div class="ui grid">
  <div class="four wide column" align="center">
  </div>
  <div class="eight wide column">
    <h1 class="ui dividing header">
      Create Profile
    </h1>

    {form_open(, class="ui form")}
      <div class="field">
        <label>Name</label>
        <input type="text" name="name" value="{name}" placeholder="">
        <p><div>{set_value(name)} {form_error(name)} </div>
      </div>

      {form_submit(submit, Create, class="ui button")}

      {form_close()}
  </div>
</div>