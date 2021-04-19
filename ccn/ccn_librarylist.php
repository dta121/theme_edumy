<?php
/*
@ccnRef: @template block_cocoon_library_list
*/

defined('MOODLE_INTERNAL') || die();
include_once($CFG->dirroot . '/course/lib.php');

$_ccnlibrarylist = '';

$_ccnlibrarylist  .= '


  <ul id="vertical-menu" class="mega-vertical-menu nav navbar-nav">';
$topcategory = core_course_category::top();
if ($topcategory->is_uservisible() && ($categories = $topcategory->get_children())) { // Check we have categories.
    if (count($categories) > 1 || (count($categories) == 1 && $DB->count_records('course') > 200)) {     // Just print top level category links
        foreach ($categories as $category) {
          $children_courses = $category->get_courses();
        //  print_object($children_courses);

          foreach($children_courses as $child_course) {
            if ($child_course === reset($children_courses)) {
            foreach ($child_course->get_course_overviewfiles() as $file) {
if ($file->is_valid_image()) {
$imagepath = '/' . $file->get_contextid() .
      '/' . $file->get_component() .
      '/' . $file->get_filearea() .
      $file->get_filepath() .
      $file->get_filename();
$imageurl = file_encode_url($CFG->wwwroot . '/pluginfile.php', $imagepath,
      false);
$outputimage  =  $imageurl;
// Use the first image found.
break;
}
}
}
          }
            $categoryname = $category->get_formatted_name();
            $linkcss = $category->visible ? "" : " class=\"dimmed\" ";
            $_ccnlibrarylist .= '
            <li><a href="'.$CFG->wwwroot .'/course/index.php?categoryid='.$category->id.'">'. $categoryname .'</a></li>';

        }
}

}

// } else {                          // Just print course names of single category
// $category = array_shift($categories);
// $courses = $category->get_courses();
//
// if ($courses) {
// foreach ($courses as $course) {
//   $coursecontext = context_course::instance($course->id);
//   $linkcss = $course->visible ? "" : " class=\"dimmed\" ";
//
//   $_ccnlibrarylist .= '
//   <li><a href="'.$CFG->wwwroot .'/course/view.php?id='.$course->id.'">'. $course->get_formatted_name() .' <span class="float-right">()</span></a></li>
//
//   ';
// }
// }
// }

$_ccnlibrarylist .='
</ul>
';
