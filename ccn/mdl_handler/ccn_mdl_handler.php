<?php
/*
@ccnRef: @ MDL HANDLER
*/

defined('MOODLE_INTERNAL') || die();

class ccnMdlHandler {

  public function ccnGetCoreVersion() {
    // Should be returning 37, 38, 39, etc.
    global $CFG;

    $ccnMdlBranch = $CFG->branch;
    $ccnReturn = $ccnMdlBranch;

    return $ccnReturn;
  }
}
