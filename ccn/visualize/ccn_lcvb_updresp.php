<?php
/*
@ccnRef: @
*/

require_once('../../../../config.php');
require_once('../../../../lib/blocklib.php');

global $CFG, $DB, $USER;

require_once($CFG->dirroot. '/theme/edumy/ccn/user_handler/ccn_user_handler.php');

/* @ccnComm: Initialize */
$ccnUserHandler = new ccnUserHandler();
$ccnIsCourseCreator = $ccnUserHandler->ccnCheckRoleIsCourseCreatorAnywhere($USER->id);
$ccnIsManager = $ccnUserHandler->ccnCheckRoleIsManagerAnywhere($USER->id);

$id = required_param('ccn_bid', PARAM_INT);

require_login();

header('Content-Type: application/json');

if(is_siteadmin() || $ccnIsManager || $ccnIsCourseCreator){
  if (isset($_GET['ccn_bid'])) {
    $ccnvbid = $_GET['ccn_bid'];
    function ccn_block_instance_by_id($blockinstanceid) {
        global $DB;
        $ccnBlockInstance = $DB->get_record('block_instances', ['id' => $blockinstanceid]);
        $ccnBlockName = $ccnBlockInstance->blockname;
        $ccnBlockFullName = 'block_'.$ccnBlockInstance->blockname;
        $ccnBlockTitle = ucwords(str_replace("_", " ", $ccnBlockName));
        $ccnInstance = block_instance($ccnBlockName, $ccnBlockInstance);
        // @ccnBreak
        $ccnReturn = new \stdClass();
        $ccnReturn->ccnBlockRender = '<div class="'.$ccnBlockFullName.'">'.$ccnInstance->get_content()->text.'</div>';
        return $ccnReturn;
    }
    $ccnBlock = ccn_block_instance_by_id($id);
    echo json_encode($ccnBlock);
  }
}
