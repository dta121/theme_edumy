<?php
/*
@ccnRef:
*/

defined('MOODLE_INTERNAL') || die();

class ccnLazy {
  public function ccnLazyImage($imageUrl) {
    global $CFG, $PAGE;

    $ccnReturn = ' src="'.$imageUrl.'" ';

    $ccnLazyLoad = TRUE;

    if(isset($PAGE->theme->settings->lazy_loading) && ($PAGE->theme->settings->lazy_loading === '1')) {
      $ccnLazyLoad = FALSE;
    }

    if($ccnLazyLoad == TRUE){
      $ccnReturn = ' data-ccn-lazy data-src="'.$imageUrl.'" ';
    }

    return $ccnReturn;

  }
}
