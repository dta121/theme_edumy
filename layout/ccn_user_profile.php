<?php
defined('MOODLE_INTERNAL') || die();
include($CFG->dirroot . '/theme/edumy/ccn/ccn_themehandler.php');
if ($user_profile_layout_dashboard == 1) {
  array_push($extraclasses, "ccn_context_dashboard");
  $bodyclasses = implode(" ",$extraclasses);
  $bodyattributes = $OUTPUT->body_attributes($bodyclasses);
  include($CFG->dirroot . '/theme/edumy/ccn/ccn_themehandler_context.php');
  echo $OUTPUT->render_from_template('theme_edumy/ccn_dashboard', $templatecontext);
} else {
  array_push($extraclasses, "ccn_context_frontend");
  $bodyclasses = implode(" ",$extraclasses);
  $bodyattributes = $OUTPUT->body_attributes($bodyclasses);
  include($CFG->dirroot . '/theme/edumy/ccn/ccn_themehandler_context.php');
  echo $OUTPUT->render_from_template('theme_boost/columns2', $templatecontext);
}
