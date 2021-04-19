<?php
defined('MOODLE_INTERNAL') || die();
include($CFG->dirroot . '/theme/edumy/ccn/ccn_themehandler.php');
array_push($extraclasses, "ccn_context_frontend");
$bodyclasses = implode(" ",$extraclasses);
$bodyattributes = $OUTPUT->body_attributes($bodyclasses);
include($CFG->dirroot . '/theme/edumy/ccn/ccn_themehandler_context.php');

$ccnLoginLayout = get_config('theme_edumy', 'login_layout');

if (!empty($ccnLoginLayout) && $ccnLoginLayout == '1') {
  echo $OUTPUT->render_from_template('theme_edumy/ccn_login_1', $templatecontext);
} elseif (!empty($ccnLoginLayout) && $ccnLoginLayout == '2') {
  echo $OUTPUT->render_from_template('theme_edumy/ccn_login_2', $templatecontext);
} elseif (!empty($ccnLoginLayout) && $ccnLoginLayout == '3') {
  echo $OUTPUT->render_from_template('theme_edumy/ccn_login_3', $templatecontext);
} else {
  echo $OUTPUT->render_from_template('theme_edumy/ccn_login', $templatecontext);
}
