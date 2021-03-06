<? $this->load->view('head'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>
  <div class="session">
    <button id="login" class="dialog-opener logged-out">Login</button>
    <button id="signup" class="dialog-opener logged-out">Sign Up</button>
    <span class="logged-in">Logged In, <?= $this->session->userdata('email') ?></span>
    <?= anchor('/outfits', 'Outfits', 'class="logged-in"'); ?>
    <?= anchor('/users/logout', 'Log Out', 'class="logged-in logout"'); ?>
  </div>
</header>
<section id="container">
  <section id="content">
    <h1 class="blurb">Find the perfect outfit.</h1>
    <?= img(array(
        'src' => 'images/fashion.png',
        'class' => 'about'
      )); ?>
    <div id="action-buttons">   
      <?= anchor('outfits/create', 'Make a New Outfit', 'class="new-outfit"') ?>
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
      <div class="standardForm">
        <label>Email: <input name="email" class="email" type="text" /></label>
        <label>Password: <input name="password" class="password" type="password" /></label>
        <input class="submit" type="submit" />
      </div>
    </form>
    <button class="close">Close</button>
  </div>
  <div class="signup dialog">
    <? 
    $attributes = array('class' => 'signup');
    echo form_open('users/register', $attributes);
    ?>
      <h2>Sign Up</h2>
      <div class="standardForm">
        <label>Email: <input name="email" class="email" type="text" /></label>
        <label>Password: <input name="password" type="password" /></label>
        <label>Name: <input name="name" type="text" /></label>
        <input class="submit" type="submit" />
      </div>
    </form>
    <button class="close">Close</button>
  </div>
  <div class="disclaimer">The term 'Etsy' is a trademark of Etsy, Inc. This application uses the Etsy API but is not endorsed or certified by Etsy, Inc.</div>
  <? $this->load->view('tail'); ?>