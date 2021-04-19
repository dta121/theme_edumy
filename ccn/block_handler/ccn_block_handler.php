<?php
/*
@ccnRef: @block_cocoon/block.php
*/

defined('MOODLE_INTERNAL') || die();

class ccnBlockHandler {

  public function ccnGetBlockApplicability($ccnBlockTypes) {
    global $PAGE;

    $ccnExposeBlocks = $PAGE->theme->settings->dev_expose_blocks;

    if($ccnExposeBlocks !== '1') {
      $ccnAssumeTrulyAll = array('trulyAll');
      if(
        $ccnBlockTypes === $ccnAssumeTrulyAll
      ) {
        return array(
          'all' => true,
          'my' => true,
          'admin' => true,
          'course-view' => true,
          'course' => true,
        );
      }

      $ccnAssumeAll = array('all');
      if(
        $ccnBlockTypes === $ccnAssumeAll
      ) {
        return array(
          'all' => true,
          'my' => false,
          'admin' => false,
          'course-view' => true,
          'course' => true,
        );
      }

      $ccnAssumeCourseView = array('course-view');
      if(
        $ccnBlockTypes === $ccnAssumeCourseView
      ) {
        return array(
          'all' => false,
          'my' => false,
          'admin' => false,
          'course' => false,
          'course-view' => true,
          'enrol' => true,
        );
      }

      $ccnAssumeCourse = array('course');
      if(
        $ccnBlockTypes === $ccnAssumeCourse
      ) {
        return array(
          'all' => false,
          'my' => false,
          'admin' => false,
          'course' => true,
          'course-view' => true,
          'enrol' => true,
        );
      }
    }

    /* @ccnComm: not assumed, so continue... */

    $ccnInventory = array(
      'all',
      'my',
      'course',
      'course-view',
      'course-index-category',
      'enrol',
      'admin',
    );
    $ccnTypes = array();

    foreach($ccnInventory as $k=>$ccnInvent){
      $ccnTypes[$ccnInvent] = new stdClass();
      $ccnTypes[$ccnInvent]->key = $ccnInvent;
      if($ccnExposeBlocks == '1'){
        $ccnTypes[$ccnInvent]->value = true;
      } else {
        $ccnTypes[$ccnInvent]->value = false;
      }
    }

    if($ccnExposeBlocks !== '1'){
      if(
        $ccnBlockTypes !== null
        && is_array($ccnBlockTypes)
      ){
        foreach($ccnBlockTypes as $k=>$ccnBlockType){
          if(array_key_exists($ccnBlockType, $ccnTypes)){
            $ccnTypes[$ccnBlockType]->value = true;
          }
        }
      }
    }

    $ccnReturn = array();
    foreach ($ccnTypes as $k=>$ccnType) {
      $ccnReturn[$ccnType->key] = $ccnType->value;
    }

    return $ccnReturn;

  }
}
