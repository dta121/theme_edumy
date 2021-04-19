<?php
/*
@ccnRef: @
*/

defined('MOODLE_INTERNAL') || die();
include_once($CFG->dirroot . '/course/lib.php');

class ccnPageHandler {
  public function ccnGetPageTitle() {
    global $PAGE, $COURSE, $DB, $CFG;

    $ccnReturn = $PAGE->heading;

    if(
      $DB->record_exists('course', array('id' => $COURSE->id))
      && $COURSE->format == 'site'
      && $PAGE->cm
      && $PAGE->cm->name !== NULL
    ){
      $ccnReturn = $PAGE->cm->name;
    } elseif($PAGE->pagetype == 'blog-index') {
      $ccnReturn = get_string("blog", "blog");
    }

    return $ccnReturn;
  }
}
