<?php
defined('MOODLE_INTERNAL') || die();
include($CFG->dirroot . '/theme/edumy/ccn/ccn_themehandler.php');

if ($ccnDashLayout == 1) {
  array_push($extraclasses, "ccn_context_frontend ccn_pseudoContext__my");
  $bodyclasses = implode(" ",$extraclasses);
  $bodyattributes = $OUTPUT->body_attributes($bodyclasses);
  include($CFG->dirroot . '/theme/edumy/ccn/ccn_themehandler_context.php');
  echo $OUTPUT->render_from_template('theme_boost/columns2', $templatecontext);
} else {
  array_push($extraclasses, "ccn_context_dashboard");
  $bodyclasses = implode(" ",$extraclasses);
  $bodyattributes = $OUTPUT->body_attributes($bodyclasses);
  include($CFG->dirroot . '/theme/edumy/ccn/ccn_themehandler_context.php');
  echo $OUTPUT->render_from_template('theme_edumy/ccn_my', $templatecontext);
}
