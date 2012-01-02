<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Outfit extends DataMapper {
  
  //one to many relationship
  var $has_one = array('user');
  
}
