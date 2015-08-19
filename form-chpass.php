  <div class='module'>
    <form method="post" enctype="multipart/form-data">
      <fieldset><legend><?php echo msg('authentication');?></legend>
        <div class='required'>
          <label for='username'><?php echo msg('username');?></label>
          <input type='text' name='username' id='username' value="<?php echo $_GET['username'] ?>" />
	</div>
	<div class='required'>
          <label for='password'><?php echo msg('old_password');?></label>
          <input type='password' name='password' id='password'/>
	</div>
	<div class='required'>
          <label for='np1'><?php echo msg('new_password1');?></label>
          <input type='password' name='np1' id='np1'/>
	</div>
	<div class='required'>
          <label for='np2'><?php echo msg('new_password2');?></label>
          <input type='password' name='np2' id='np2'/>
	</div>
      </fieldset>
      <fieldset>
        <div class="submit">
	  <div>
	    <input type="submit" class="inputSubmit" value="<?php echo msg('ok');?>" />
	    <input type="submit" class="inputSubmit" value="<?php echo msg('cancel');?>" />
	  </div>
	</div>
      </fieldset>
    </form>
  </div>
