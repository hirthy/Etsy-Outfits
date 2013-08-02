<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

  public function index() {
    if (! $this->session->userdata('logged_in')) {
      redirect(base_url());
      return;
    } else {
      redirect('/outfits');
    }
  }

  public function logout() {
    $this->session->sess_destroy();
    redirect(base_url());
  }

  //verify credentials in DB
  public function login() {
    $email = $this->input->post('email', TRUE);
    $password = $this->input->post('password', TRUE);

    $u = new User();
    $u->email = $email;
    $u->password = $password;

    $success = $u->login();

    if ($success) {
      $this->_setSessionForUser($email);
      
      $this->saveOutfit();
      
      redirect('/outfits');
    } else {
      //TODO return errors
      redirect(base_url());
    }

  }
  
  public function saveOutfit() {
    $outfitdata = json_decode(get_cookie('outfitdata'), true);
    
    $outfitId = $this->session->userdata('current_outfit');
    $isNew = $outfitId == false;
    
    //get data from view (hidden input fields that are populated thru jquery)
    $outfitTitle = $outfitdata["title"];
    $outfitDesc =  $outfitdata["description"];
    $outfitHeadListingID =  $outfitdata["head-piece"];
    $outfitNeckListingID =  $outfitdata["neck-piece"];
    $outfitHandsListingID =  $outfitdata["hands-piece"];
    $outfitBodyListingID =  $outfitdata["body-piece"];
    $outfitLegsListingID =  $outfitdata["legs-piece"];
    $outfitFeetListingID =  $outfitdata["feet-piece"];

    $email = $this->session->userdata('email');

    $user = new User();
    $user->email = $email;
    $user->validate()->get();

    $outfit = new Outfit();
    if ($isNew) {
      //echo 'new';
      //
    } else {
      $outfit->id = $outfitId;
      $outfit->where('id', $outfitId)->get();
    }
    
    //save new to DB
    $outfit->title = $outfitTitle;
    $outfit->description = $outfitDesc;
    $outfit->head_listing_id = $outfitHeadListingID;
    $outfit->neck_listing_id = $outfitNeckListingID;
    $outfit->hands_listing_id = $outfitHandsListingID;
    $outfit->body_listing_id = $outfitBodyListingID;
    $outfit->legs_listing_id = $outfitLegsListingID;
    $outfit->feet_listing_id = $outfitFeetListingID;
    $outfit->save();
    
    if ($isNew)
      $user->save($outfit);
  }

  public function register() {
    $email = $this->input->post('email', TRUE);
    $password = $this->input->post('password', TRUE);
    $name = $this->input->post('name', TRUE);
 
    $u = new User();
    $u->email = $email;
    $u->password = $password;
    $u->name = $name;

    // This will attempt to upsert into the database.
    // It'll also check all the model's validation rules.
    // If it is successful, the user object will be updated (with a unique id)
    $u->save();

    if (! empty($u->id)) {
      $this->_setSessionForUser($email);
      redirect('/outfits/create');
    } else {
      //TODO return errors
      redirect(base_url());
    }
  }

  //set session so we know who is logged in
  private function _setSessionForUser($email) {
    $session_data = array(
                     'email'     => $email,
                     'logged_in' => TRUE
                    );
    $this->session->set_userdata($session_data);

  }
}
