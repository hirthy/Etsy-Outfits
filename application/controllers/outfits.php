<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Outfits extends CI_Controller {

  public function index() {
    if (! $this->session->userdata('logged_in')) {
      redirect(base_url());
      return;
    }

    //get logged in user and get all their outfits
    $email = $this->session->userdata('email');
    $user = new User();
    $user->email = $email;
    $user->validate()->get();

    $outfits = $user->outfits->get();

    $data['outfits'] = $outfits;

    $this->load->view('outfits', $data);
  }
  
  //list outfits for a user
  public function show($id) {
    $user = new User();
    $user->id = $id;
    $user->validate()->get();
    
    $outfits = $user->outfit->get();
    
    $data = array();
    $data['outfits'] = $outfits;
    
		$this->load->view('outfit', $data);
	}

  //create outfit and pass data to view
  public function create() {
    $data = array();
    $data['outfit'] = new Outfit();

    $session_data = array('current_outfit' => false);
    $this->session->set_userdata($session_data);    

    $this->load->view('outfit', $data);
  }
 
  //send current outfit it to view
  public function edit($id) {
    $outfit = new Outfit();

    $outfit->id = $id;
    $outfit->validate()->get();

    $session_data = array('current_outfit' => $id);
    $this->session->set_userdata($session_data);    

    $data = array();
    $data['outfit'] = $outfit;

    $this->load->view('outfit', $data);
  }

  //handles form input to upsert an outfit
  public function update() {
    
    $outfitId = $this->session->userdata('current_outfit');
    $isNew = $outfitId == false;

    //get data from view (hidden input fields that are populated thru jquery)
    $outfitTitle = $this->input->post('title', TRUE);
    $outfitDesc = $this->input->post('description', TRUE);
    $outfitHeadListingID = $this->input->post('head-piece');
    $outfitNeckListingID = $this->input->post('neck-piece');
    $outfitHandsListingID = $this->input->post('hands-piece');
    $outfitBodyListingID = $this->input->post('body-piece');
    $outfitLegsListingID = $this->input->post('legs-piece');
    $outfitFeetListingID = $this->input->post('feet-piece');

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

    //TODO handle errors and return

    redirect('/outfits');
  }

}
