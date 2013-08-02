<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Etsy Outfits</title>
  <script type="text/javascript" src="<?= base_url() ?>scripts/jquery-1.6.4.min.js"></script>
  <script type="text/javascript" src="<?= base_url() ?>scripts/jquery-ui-1.8.16.custom.min.js"></script>
  <script type="text/javascript" src="<?= base_url() ?>scripts/dummy.js"></script>
  <script type="text/javascript" src="<?= base_url() ?>scripts/jquery.cookies.2.2.0.js"></script>
  <script>
  //show and hide for login/register
  $(document).ready(function(){
     $('.dialog-opener').click(function(event){
       var id=$(this).attr('id');
       $('.dialog.' + id).addClass('current');
     });
     $('.dialog .close').click(function(event){
       $(this).closest('.dialog').removeClass('current');
     });
     $('.switch-dialog').click(function(event){
       $(this).closest('.dialog').removeClass('current');
       $('.dialog.login').addClass('current');
       return false;
     });
     $('#outfit, .new-outfit').click(function(event){
       if(!$('body').hasClass('logged-in')) {

           $('.dialog.signup').addClass('current');
            // get all the inputs into an array.
             var $inputs = $('#outfit :input');

             var values = {};
             $inputs.each(function() {
                 values[this.name] = $(this).val();
             });
            $.cookies.set('outfitdata', values);
            return false;
          } else {
            return true;
          }
     });
   });
   </script>
  <?= link_tag(array(
                    'href' => 'stylesheets/screen.css',
                    'rel' => 'stylesheet',
                    'type' => 'text/css',
                    'media' => 'screen, projection'
              )); ?>

</head>
<body class="<?= $this->router->class . ' ' . ($this->session->userdata('logged_in') ? 'logged-in' : 'logged-out') ?>">