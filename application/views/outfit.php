<? $this->load->view('head'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>
  <?= anchor('/outfits', 'Back', 'class="back"'); ?>

  <div class="session">
    <?= anchor('/users/logout', 'Log Out', 'class="logged-in logout"'); ?>
  </div>
</header>
<section id="container">
  <section id="content">
  <?
    $attributes = array('id' => 'outfit');
    echo form_open_multipart('outfits/update', $attributes);
  ?>
    <h2>My Outfit</h2><input type="submit" name ="save" value="Save" class="dialog-opener"/>
    <label>Name:<input type="text" name="title" value="<?= $outfit->title ?>" /></label>
    <label>Description:<input type="text" name="description" value="<?= $outfit->description ?>" /></label>
    <input type="hidden" class="savedID" name="head-piece" value="<?= $outfit->head_listing_id ?>" />
    <input type="hidden" class="savedID" name="neck-piece" value="<?= $outfit->neck_listing_id ?>" />
    <input type="hidden" class="savedID" name="hands-piece" value="<?= $outfit->hands_listing_id ?>" />
    <input type="hidden" class="savedID" name="body-piece" value="<?= $outfit->body_listing_id ?>" />
    <input type="hidden" class="savedID" name="legs-piece" value="<?= $outfit->legs_listing_id ?>" />
    <input type="hidden" class ="savedID" name="feet-piece" value="<?= $outfit->feet_listing_id ?>" />
    </form>
    <form id="etsy-search">
        <label>Find a new piece:<input id="etsy-terms" size="32">
        <button>Search</button></label>
    </form>
    <h3>Drag a piece over to your outfit:</h3>
    <div id="results">
      <div id="etsy-images"></div>
    </div>
    <div id="outfit">
      <div id="head-piece" class="piece">Head</div>
      <div id="neck-piece" class="piece">Neck</div>
      <div id="hands-piece" class="piece">Hands</div>
      <div id="body-piece" class="piece">Body</div>
      <div id="legs-piece" class="piece">Legs</div>
      <div id="feet-piece" class="piece">Feet</div>
    </div>
  </section>
</section>
<div class="dialogs">
  <div class="login dialog">
    <? 
    $attributes = array('class' => 'login');
    echo form_open('users/login', $attributes);
    ?>
      <h2>Login</h2>

      <label>Email: <input name="email" class="email" type="text" /></label>
      <label>Password: <input name="password" class="password" type="password" /></label>
      <input class="submit" type="submit" />
    </form>
    <button class="close">Close</button>
  </div>
  <div class="signup dialog">
    <? 
    $attributes = array('class' => 'signup');
    echo form_open('users/register', $attributes);
    ?>
      <h2>Sign Up</h2>

      <label>Email: <input name="email" class="email" type="text" /></label>
      <label>Password: <input name="password" type="password" /></label>
      <label>Name: <input name="name" type="text" /></label>

      <input class="submit" type="submit" /><?= anchor('/', 'Already a user? Click here to login', 'class="switch-dialog"'); ?>
    </form>
    <button class="close">Close</button>
  </div>
<? $this->load->view('tail'); ?>