<?php
/*
@ccnRef: @
*/

defined('MOODLE_INTERNAL') || die();
include_once($CFG->dirroot . '/course/lib.php');

$_ccnCourseSectionNav = '';
$ccnCourseUrl = '';
if ($DB->record_exists('course', array('id' => $COURSE->id))) {

  $ccnCourseFormat = $COURSE->format;

  /* Begin ccnTktRef: 3083
   * if($ccnCourseFormat !== 'site'){
   * REPLACE WITH BELOW IF STATEMENT: */
  if (
    $ccnCourseFormat !== 'site' &&
    (
      ($PAGE->pagelayout == 'course' && $PAGE->theme->settings->coursemainpage_layout == ('3' || '4'))
      || ($PAGE->pagelayout == 'incourse' && $PAGE->theme->settings->incourse_layout == '2')
    )
  ){
  /* End ccnTktRef */
    $ccnCourseRecord = $DB->get_record('course', array('id' => $COURSE->id));

    try {
      $ccnCourseRenderer = $this->page->get_renderer('core', 'course');
      $ccnCourseFormatRenderer = $this->page->get_renderer('format_' . $ccnCourseFormat);
    } catch(Exception $e) {
      // print_object('Error');
    }

    $ccnFocusActivities = get_array_of_activities($COURSE->id);

    $ccnCourseUrl = course_get_url($COURSE->id);
    $ccnCourseSections = array();

    // $_ccnCourseSectionNav = '';

    foreach($ccnFocusActivities as $section){
      if(empty($section->deletioninprogress)){

        if(!isset($ccnCourseSections[$section->sectionid]['name'])){
          if(course_format_uses_sections($ccnCourseFormat)){
            $ccnCourseSections[$section->sectionid]['name'] = get_section_name($COURSE->id, $section);
          } else {
            $ccnCourseSections[$section->sectionid]['name'] = $COURSE->fullname;
          }
        }

        $ccnCourseSections[$section->sectionid][] = $section;

      }
    }

    foreach($ccnCourseSections as $key => $section){

      $_ccnCourseSectionNav .= '
      <div class="details">
        <div id="accordion-'.$key.'" class="panel-group cc_tab">
          <div class="panel">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a href="#panelBodyCourseStart-'.$key.'" class="accordion-toggle link dropbtn" data-toggle="collapse" data-parent="#accordion-'.$key.'">'.$section['name'].'</a>
              </h4>
            </div>
            <div id="panelBodyCourseStart-'.$key.'" class="panel-collapse collapse show">
              <div class="panel-body">';
                if ($DB->record_exists('course_sections', array('id' => $key))) {
                  $ccnSectionId = $key;
                } else {
                  $ccnSectionId = '0';
                }

                $ccnCourseSectionRecord = $DB->get_record('course_sections', array('id' => $ccnSectionId));
                $ccnCourseRecords = $DB->get_record('course', array('id' => $COURSE->id));

                $ccnRenderSectionAvailability = '';
                $ccnRenderCcnActivityNav = '';

                if($ccnCourseFormat !== 'site'){
                  try {
                    // $ccnRenderSectionAvailability = $ccnCourseFormatRenderer->section_availability($ccnCourseSectionRecord);
                    $ccnRenderCcnActivityNav = $ccnCourseRenderer->_ccnActivityNav_course_section_cm_list($ccnCourseRecords, $ccnCourseSectionRecord, null, array());
                  } catch(Exception $e) {
                    // print_object('Error');
                  }
                }

                $_ccnCourseSectionNav .= $ccnRenderCcnActivityNav;
                $_ccnCourseSectionNav .= $ccnRenderSectionAvailability;

                $_ccnCourseSectionNav .='
              </div>
            </div>
          </div>
        </div>
      </div>';
    }
  }
}
