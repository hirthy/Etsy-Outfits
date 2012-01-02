<? $this->load->view('head'); ?>
<header>
  <?= anchor('/', 'Home', 'class="home"'); ?>
  <div class="session">
    <?= anchor('/logout', 'Log Out', 'class="logged-in logout"'); ?>
  </div>
</header>
<section id="container">
  <section id="content">

    <h2>Pick an outfit below:</h2>
    <ul>
      <?
      $attributes = array('id' => 'unit', 'class="outfits"');
      foreach ($outfits as $outfit) {
        echo '<li class="outfit">' . anchor('/outfits/edit/' . $outfit->id , $outfit->title) . '</li>';
      }
      ?>
    </ul>
    <div id="action-menu">
      <?= anchor('outfits/create', 'Create New Outfit'); ?>
    </div>
  </section>
</section>
<? $this->load->view('tail'); ?>