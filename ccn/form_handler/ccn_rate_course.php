<?php
/*
@ccnRef: @
*/

require_once('../../../../config.php');

defined('MOODLE_INTERNAL') || die();

global $CFG, $DB;

$id        = required_param('id', PARAM_INT);                 // Course Module ID.
$rating     = required_param('rating', PARAM_INT);          // User selection.

if (! $course = $DB->get_record("course", array("id"=>$id))) {
    print_error("Course ID not found");
}

require_login($course, false);
if (!$context = get_context_instance(CONTEXT_COURSE, $course->id)) {
    print_error('nocontext');
}

    require_capability('block/cocoon_course_rating:rate', $context);
    global $USER;

if ($form = data_submitted()) {
    if ($DB->count_records('theme_edumy_courserate', array('course'=>$COURSE->id, 'user'=>$USER->id))) {
        $test = $DB->get_record('theme_edumy_courserate', array('course'=>$COURSE->id, 'user'=>$USER->id));
        $DB->update_record('theme_edumy_courserate', array('id'=>$test->id, 'rating'=>$rating));
    } else {

    $DB->insert_record( 'theme_edumy_courserate', array('course'=>$COURSE->id, 'user'=>$USER->id, 'rating'=>$rating));
    }
    redirect($CFG->wwwroot.'/course/view.php?id='.$COURSE->id, get_string('rating_success', 'theme_edumy'), null, \core\output\notification::NOTIFY_SUCCESS);

}
