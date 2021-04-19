<?php
defined('MOODLE_INTERNAL') || die();
include($CFG->dirroot . '/theme/edumy/ccn/ccn_themehandler.php');
array_push($extraclasses, "ccn_context_dashboard ccn_context_visualize");
$bodyclasses = implode(" ",$extraclasses);
$bodyattributes = $OUTPUT->body_attributes($bodyclasses);
include($CFG->dirroot . '/theme/edumy/ccn/ccn_themehandler_context.php');

$PAGE->requires->css('/theme/edumy/style/ccn-visualize.css');
$PAGE->requires->js('/theme/edumy/javascript/cocoon.lcvb.preprocess.min.js', true);


if (isset($_GET['bui_editid'])) {
  $ccnvbid = $_GET['bui_editid'];
  $ccnLcVbUpdCall = $CFG->wwwroot . '/theme/edumy/ccn/visualize/ccn_lcvb_updresp.php?ccn_bid=' . $ccnvbid;
  $PAGE->requires->js_init_call('ccnLcVbMainProcessor', array($ccnLcVbCollection, $ccnLcVbUpdCall));

  function ccn_block_instance_by_id($blockinstanceid) {
      global $DB;
      $ccnBlockInstance = $DB->get_record('block_instances', ['id' => $blockinstanceid]);
      $ccnBlockName = $ccnBlockInstance->blockname;
      $ccnBlockFullName = 'block_'.$ccnBlockInstance->blockname;
      $ccnBlockTitle = ucwords(str_replace("_", " ", $ccnBlockName));
      $ccnInstance = block_instance($ccnBlockName, $ccnBlockInstance);
      // @ccnBreak
      $ccnReturn = new \stdClass();
      $ccnReturn->ccnBlockName = $ccnBlockName;
      $ccnReturn->ccnBlockFullName = $ccnBlockFullName;
      $ccnReturn->ccnBlockTitle = $ccnBlockTitle;
      $ccnReturn->ccnBlockRender = '<div class="'.$ccnBlockFullName.'">'.$ccnInstance->get_content()->text.'</div>';
      return $ccnReturn;
  }

  $ccnBlock = ccn_block_instance_by_id($ccnvbid);
  $templatecontext['ccn_lc_vb'] = $ccnBlock->ccnBlockRender;
  // $templatecontext['ccn_lc_vb_repitem'] = $ccnBlock->ccnRepItem;
  $templatecontext['ccn_lc_vb_title'] = $ccnBlock->ccnBlockTitle;
}

echo $OUTPUT->render_from_template('theme_edumy/ccn_lc_vb', $templatecontext);
