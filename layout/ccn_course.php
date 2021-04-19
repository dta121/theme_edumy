<?php
defined('MOODLE_INTERNAL') || die();
include($CFG->dirroot . '/theme/edumy/ccn/ccn_themehandler.php');
if ($course_mainpage_layout_dashboard == '1') {
  array_push($extraclasses, "ccn_context_dashboard");
  $bodyclasses = implode(" ",$extraclasses);
  $bodyattributes = $OUTPUT->body_attributes($bodyclasses);
  include($CFG->dirroot . '/theme/edumy/ccn/ccn_themehandler_context.php');
  echo $OUTPUT->render_from_template('theme_edumy/ccn_dashboard', $templatecontext);
} elseif ($course_mainpage_layout_dashboard == '2') {
  array_push($extraclasses, "ccn_context_dashboard ccn_context_focus");
  $bodyclasses = implode(" ",$extraclasses);
  $bodyattributes = $OUTPUT->body_attributes($bodyclasses);
  include($CFG->dirroot . '/theme/edumy/ccn/ccn_themehandler_context.php');
  echo $OUTPUT->render_from_template('theme_edumy/ccn_focus', $templatecontext);
// } elseif ($incourse_layout_focus == 1) {
//   array_push($extraclasses, "ccn_context_dashboard ccn_context_focus");
//   $bodyclasses = implode(" ",$extraclasses);
//   $bodyattributes = $OUTPUT->body_attributes($bodyclasses);
//   include($CFG->dirroot . '/theme/edumy/ccn/ccn_themehandler_context.php');
//   echo $OUTPUT->render_from_template('theme_edumy/ccn_focus', $templatecontext);
} else {
  array_push($extraclasses, "ccn_context_frontend");
  $bodyclasses = implode(" ",$extraclasses);
  $bodyattributes = $OUTPUT->body_attributes($bodyclasses);
  include($CFG->dirroot . '/theme/edumy/ccn/ccn_themehandler_context.php');
  echo $OUTPUT->render_from_template('theme_boost/columns2', $templatecontext);
}
