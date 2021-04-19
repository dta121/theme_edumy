<?php
/*
@ccnRef: @ newRatingHandler
*/

// require_once($CFG->dirroot.'/repository/lib.php');

defined('MOODLE_INTERNAL') || die();

// use \core_user\output\myprofile\category;
// use core_user\output\myprofile\tree;
// use core_user\output\myprofile\node;
// use core_user\output\myprofile;
// use context_course;
// use core_course_list_element;
// use DateTime;
// use core_date;

class ccnNewRatingHandler {
  public function ccnCreateLogiclessStars($integer, $amount = null) {

    if($integer){
      $ccnRating    = (int)$integer;

      $ccnStar      = '<li class="list-inline-item"><i class="fa fa-star"></i></li>';
      $ccnStarHalf  = '<li class="list-inline-item"><i class="fa fa-star-half-o"></i></li>';
      $ccnStarVoid  = '<li class="list-inline-item"><i class="fa fa-star-o"></i></li>';

      if($ccnRating == 5) {
        $ccnStars = str_repeat($ccnStar, 5);
      } elseif($ccnRating == 4.5) {
        $ccnStars = str_repeat($ccnStar, 4) . str_repeat($ccnStarHalf, 1);
      } elseif($ccnRating == 4) {
        $ccnStars = str_repeat($ccnStar, 4) . str_repeat($ccnStarVoid, 1);
      } elseif($ccnRating == 3.5) {
        $ccnStars = str_repeat($ccnStar, 3) . str_repeat($ccnStarHalf, 1) . str_repeat($ccnStarVoid, 1);
      } elseif($ccnRating == 3) {
        $ccnStars = str_repeat($ccnStar, 3) . str_repeat($ccnStarVoid, 2);
      } elseif($ccnRating == 2.5) {
        $ccnStars = str_repeat($ccnStar, 2) . str_repeat($ccnStarHalf, 1)  . str_repeat($ccnStarVoid, 2);
      } elseif($ccnRating == 2) {
        $ccnStars = str_repeat($ccnStar, 2) . str_repeat($ccnStarVoid, 3);
      } elseif($ccnRating == 1.5) {
        $ccnStars = str_repeat($ccnStar, 1) . str_repeat($ccnStarHalf, 1)  . str_repeat($ccnStarVoid, 3);
      } elseif($ccnRating == 0.5) {
        $ccnStars = str_repeat($ccnStarHalf, 1) . str_repeat($ccnStarVoid, 4);
      } else {
        $ccnStars = str_repeat($ccnStarVoid, 5);
      }

      $ccnAmount = '';
      if($amount !== null) {
        $ccnAmount = '<li class="list-inline-item"><span>('.$amount.')</span></li>';
      }
      $return = '<div class="ccn-external-stars">'. $ccnStars . $ccnAmount .'</div>';

      return $return;
    }
  return null;

  }

}
