<?php

defined('MOODLE_INTERNAL') || die();

// require_once($CFG->dirroot. '/course/renderer.php');

class ccnEventHandler {
  public function ccnEventList() {

    global $DB;

    $ccnEvents = $DB->get_records('event', array(), $sort='', $fields='*', $limitfrom=1, $limitnum=$maxNum);

    $ccnReturn = [];

    foreach($ccnEvents as $k=>$ccnEvent){
      $ccnReturn[$ccnEvent->id] = $ccnEvent;
    }

    // print_object($ccnReturn);

    return $ccnReturn;

  }

  public function ccnGetEvent($eventId){
    global $DB;

    if ($DB->record_exists('event', array('id' => $eventId))) {

      $event = $DB->get_record('event', array('id' => $eventId));

      $ccnReturn = new \stdClass();
      $ccnReturn->id = $event->id;
      $ccnReturn->name = $event->name;
      $ccnReturn->timestart = userdate($event->timestart, get_string('strftimedaydatetime', 'langconfig'));
      $ccnReturn->dateYear = userdate($event->timestart, '%Y', 0);
      $ccnReturn->dateMonth = userdate($event->timestart, '%b', 0);
      $ccnReturn->dateDay = userdate($event->timestart, '%d', 0);
      $ccnReturn->location = $event->location;
      $ccnReturn->description = $event->description;
      $ccnReturn->eventtype = $event->eventtype;
      $ccnReturn->timeduration = $event->timeduration;

      return $ccnReturn;

    }

    return NULL;

  }

  public function ccnGetExampleEventIds($maxNum) {
    global $CFG, $DB;

    $ccnEvents = $DB->get_records('event', array(), $sort='', $fields='*', $limitfrom=1, $limitnum=$maxNum);

    $ccnReturn = array();
    foreach ($ccnEvents as $k=>$ccnEvent) {
      $ccnReturn[] = $ccnEvent->id;
    }
    return $ccnReturn;
  }

}
