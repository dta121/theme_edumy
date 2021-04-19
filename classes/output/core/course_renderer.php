<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace theme_edumy\output\core;
defined('MOODLE_INTERNAL') || die();
use cm_info;
use coursecat_helper;
use core_course_category;
use single_select;
use lang_string;
use context_course;
use context_module;
use core_course_list_element;
use html_writer;
use moodle_url;
use coursecat;
use completion_info;
use pix_icon;
use stdClass;
use core_course_renderer;
use core_tag;
use core_text;
use context_system;

require_once($CFG->dirroot . '/course/renderer.php');
require_once($CFG->dirroot . '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
require_once($CFG->dirroot . '/theme/edumy/ccn/mdl_handler/ccn_mdl_handler.php');

use ccnCourseHandler;
use ccnMdlHandler;

class course_renderer extends \core_course_renderer {


  /**
   * Returns HTML to display a tree of subcategories and courses in the given category
   *
   * @param coursecat_helper $chelper various display options
   * @param core_course_category $coursecat top category (this category's name and description will NOT be added to the tree)
   * @return string
   */
  protected function coursecat_tree(coursecat_helper $chelper, $coursecat) {
      // Reset the category expanded flag for this course category tree first.
      $this->categoryexpandedonload = false;
      $categorycontent = $this->coursecat_category_content($chelper, $coursecat, 0);
      if (empty($categorycontent)) {
          return '';
      }

      // Start content generation
      $content = '';

      if ($coursecat->get_children_count()) {
          $content .= html_writer::link('#', $linkname, array('class' => implode(' ', $classes)));
      }

      $content .= $categorycontent;

      return $content;
  }



  /**
   * Returns HTML to display the subcategories and courses in the given category
   *
   * This method is re-used by AJAX to expand content of not loaded category
   *
   * @param coursecat_helper $chelper various display options
   * @param core_course_category $coursecat
   * @param int $depth depth of the category in the current tree
   * @return string
   */
  protected function coursecat_category_content(coursecat_helper $chelper, $coursecat, $depth) {
      $content = '';
      // Subcategories
      $content .= $this->coursecat_subcategories($chelper, $coursecat, $depth);

      // AUTO show courses: Courses will be shown expanded if this is not nested category,
      // and number of courses no bigger than $CFG->courseswithsummarieslimit.
      $showcoursesauto = $chelper->get_show_courses() == self::COURSECAT_SHOW_COURSES_AUTO;
      if ($showcoursesauto && $depth) {
          // this is definitely collapsed mode
          $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_COLLAPSED);
      }

      // Courses
      if ($chelper->get_show_courses() > core_course_renderer::COURSECAT_SHOW_COURSES_COUNT) {
          $courses = array();
          if (!$chelper->get_courses_display_option('nodisplay')) {
              $courses = $coursecat->get_courses($chelper->get_courses_display_options());


              /* ccnCOMM: Begin filter reqs */

              // $ccnCoursesCount = $coursecat->get_courses_count();

              if (isset($_GET['cocoon_filter'])) {
                $ccnCourseHandler = new ccnCourseHandler();
                $courses = $ccnCourseHandler->ccnFilterCourses($courses);
                if(empty($courses)){
                  $message = get_string('noresults', 'search');
                  return '
                    <span class="notifications" id="user-notifications">
                      <div class="alert alert-info alert-block fade in "  role="alert" data-aria-autofocus="true">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        '.$message.'
                      </div>
                    </span>';
                }
              }

            /* End ccnCOMM */


          }
          if ($viewmoreurl = $chelper->get_courses_display_option('viewmoreurl')) {
              // the option for 'View more' link was specified, display more link (if it is link to category view page, add category id)
              if ($viewmoreurl->compare(new moodle_url('/course/index.php'), URL_MATCH_BASE)) {
                  $chelper->set_courses_display_option('viewmoreurl', new moodle_url($viewmoreurl, array('categoryid' => $coursecat->id)));
              }
          }
          // $content .= $this->coursecat_courses($chelper, $courses, $coursecat->get_courses_count());
          $content .= $this->coursecat_courses($chelper, $courses, $coursecat->get_courses_count());
      }

      if ($showcoursesauto) {
          // restore the show_courses back to AUTO
          $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_AUTO);
      }

      return $content;
  }

  public function course_category($category) {
      global $CFG, $PAGE;
      $usertop = core_course_category::user_top();
      if (empty($category)) {
          $coursecat = $usertop;
      } else if (is_object($category) && $category instanceof core_course_category) {
          $coursecat = $category;
      } else {
          $coursecat = core_course_category::get(is_object($category) ? $category->id : $category);
      }


      $ccnCourseHandler = new ccnCourseHandler();
      $ccnCourseCount = $ccnCourseHandler->ccnGetCourseCategoryFilterCount($coursecat);

      $site = get_site();
      $output = '';

      if (isset($PAGE->theme->settings->courseliststyle) && ($PAGE->theme->settings->courseliststyle == 2)) {
        $output .='<div class="row"><div class="col-md-12 col-lg-12 col-xl-12 shadow_box">';
      }

      // if ($coursecat->can_create_course() || $coursecat->has_manage_capability()) {
      //   // Add 'Manage' button if user has permissions to edit this category.
      //   $managebutton = $this->single_button(new moodle_url('/course/management.php', array('categoryid' => $coursecat->id)), get_string('managecourses'), 'get');
      //   $this->page->set_button($managebutton);
      // }
      if (!$coursecat->id || !$coursecat->is_uservisible()) {
          $categorieslist = core_course_category::make_categories_list();
          $strcategories = get_string('categories');
          $this->page->set_title("$site->shortname: $strcategories");
      } else {

          $strfulllistofcourses = get_string('fulllistofcourses');
          $this->page->set_title("$site->shortname: $strfulllistofcourses");

          // Print the category selector
          $categorieslist = core_course_category::make_categories_list();
          // if (count($categorieslist) > 1) {
          $select = new single_select(new moodle_url('/course/index.php'), 'categoryid', core_course_category::make_categories_list(), $coursecat->id, null, 'switchcategory');
          // }
        }

        // 202003031234 - check that the user is within a course category and not just on the /courses/index.php page, because below demands a category ID
        if ($coursecat->id && $coursecat->is_uservisible()) {
          if (isset($PAGE->theme->settings->courseliststyle) && ($PAGE->theme->settings->courseliststyle == 2)) {
            // single category view
            $output .= '<div class="row courses_list_heading">
    						<div class="col-xl-3 p0">
    							<div class="instructor_search_result style2">
    								<p class="mt10 fz15"><span class="color-dark pr5">'.$ccnCourseCount.' </span> '.get_string('courses').'</p>
    							</div>
    						</div>
    						<div class="col-xl-9 p0">
    							<div class="candidate_revew_select style2 text-right">
    								<ul class="mb0">
    									<li class="list-inline-item">'. $this->render($select).'</li>
    									<li class="list-inline-item">'.$this->course_search_form().'</li>
    								</ul>
    							</div>
    						</div>
    					</div>';
          } else {
            $output .= '<div class="row">
    						<div class="col-xl-4">
    							<div class="instructor_search_result style2">
    								<p class="mt10 fz15"><span class="color-dark pr5">'.$ccnCourseCount.' </span> '.get_string('courses').'</p>
    							</div>
    						</div>
    						<div class="col-xl-8">
    							<div class="candidate_revew_select style2 text-right mb25">
    								<ul>
    									<li class="list-inline-item">'. $this->render($select).'</li>
    									<li class="list-inline-item">'.$this->course_search_form().'</li>
    								</ul>
    							</div>
    						</div>
    					</div>
            ';
          }
        } else {
          if (isset($PAGE->theme->settings->courseliststyle) && ($PAGE->theme->settings->courseliststyle == 2)) {
            //top level course categories
            $output .= '<div class="row courses_list_heading">
                <div class="col-xl-4 p0">
                  <div class="instructor_search_result style2">
                    <p class="mt10 fz15"><span class="color-dark pr5">'.count($categorieslist).' </span> '.get_string('categories').'</p>
                  </div>
                </div>
                <div class="col-xl-8 p0">
                  <div class="candidate_revew_select style2 text-right">
                    <ul class="mb0">

                      <li class="list-inline-item">'.$this->course_search_form().'</li>
                    </ul>
                  </div>
                </div>
              </div>';
          } else {
            $output .= '<div class="row">
                <div class="col-xl-4">
                  <div class="instructor_search_result style2">
                    <p class="mt10 fz15"><span class="color-dark pr5">'.count($categorieslist).' </span> '.get_string('categories').'</p>
                  </div>
                </div>
                <div class="col-xl-8">
                  <div class="candidate_revew_select style2 text-right mb25">
                    <ul>

                      <li class="list-inline-item">'.$this->course_search_form().'</li>
                    </ul>
                  </div>
                </div>
              </div>
            ';
          }

        }//End 202003031234

      // Print current category description
      $chelper = new coursecat_helper();
      if ($description = $chelper->get_category_formatted_description($coursecat)) {
         // $output .= $this->box($description, array('class' => 'generalbox info'));
      }

      // Prepare parameters for courses and categories lists in the tree
      if (isset($PAGE->theme->settings->courseliststyle) && ($PAGE->theme->settings->courseliststyle == 2)) {
        $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_AUTO)->set_attributes(array('class' => 'row courses_container category-browse-'.$coursecat->id));
      } else {
        $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_AUTO)->set_attributes(array('class' => 'row category-browse-'.$coursecat->id));
      }
      $coursedisplayoptions = array();
      $catdisplayoptions = array();
      $browse = optional_param('browse', null, PARAM_ALPHA);
      $perpage = optional_param('perpage', $CFG->coursesperpage, PARAM_INT);
      $page = optional_param('page', 0, PARAM_INT);
      $baseurl = new moodle_url('/course/index.php');
      if ($coursecat->id) {
          $baseurl->param('categoryid', $coursecat->id);
      }
      if ($perpage != $CFG->coursesperpage) {
          $baseurl->param('perpage', $perpage);
      }
      $coursedisplayoptions['limit'] = $perpage;
      $catdisplayoptions['limit'] = $perpage;
      if ($browse === 'courses' || !$coursecat->get_children_count()) {
          $coursedisplayoptions['offset'] = $page * $perpage;
          $coursedisplayoptions['paginationurl'] = new moodle_url($baseurl, array('browse' => 'courses'));
          $catdisplayoptions['nodisplay'] = true;
          $catdisplayoptions['viewmoreurl'] = new moodle_url($baseurl, array('browse' => 'categories'));
          $catdisplayoptions['viewmoretext'] = new lang_string('viewallsubcategories');
      } else if ($browse === 'categories' || !$coursecat->get_courses_count()) {
          $coursedisplayoptions['nodisplay'] = true;
          $catdisplayoptions['offset'] = $page * $perpage;
          $catdisplayoptions['paginationurl'] = new moodle_url($baseurl, array('browse' => 'categories'));
          $coursedisplayoptions['viewmoreurl'] = new moodle_url($baseurl, array('browse' => 'courses'));
          $coursedisplayoptions['viewmoretext'] = new lang_string('viewallcourses');
      } else {
          // we have a category that has both subcategories and courses, display pagination separately
          $coursedisplayoptions['viewmoreurl'] = new moodle_url($baseurl, array('browse' => 'courses', 'page' => 1));
          $catdisplayoptions['viewmoreurl'] = new moodle_url($baseurl, array('browse' => 'categories', 'page' => 1));
      }

      if (!isset($_GET['cocoon_filter'])) {
        /***  ccnComm 2020081400.48, todo:
              disabling core pagination, should
              implement alternate pagination
              MDL core pagination is poorly built,
              counts from DB rather than from array ***/

        $chelper->set_courses_display_options($coursedisplayoptions)->set_categories_display_options($catdisplayoptions);
      }

      if (isset($PAGE->theme->settings->courseliststyle) && ($PAGE->theme->settings->courseliststyle == 2)) {
        $output .= $this->coursecat_tree($chelper, $coursecat);
      } else {
        $output .= $this->coursecat_tree($chelper, $coursecat);
      }

      // Add action buttons
      $output .= '<div class="ccn_coursecat_action_btns">';
      if ($coursecat->can_create_course() || $coursecat->has_manage_capability()) {
        // Add 'Manage' button if user has permissions to edit this category.
        $managebutton = $this->single_button(new moodle_url('/course/management.php', array('categoryid' => $coursecat->id)), get_string('managecourses'), 'get');
        $output .= $managebutton;
      }
      if ($coursecat->is_uservisible()) {
        $context = get_category_or_system_context($coursecat->id);
        if (has_capability('moodle/course:create', $context)) {
          // Print link to create a new course, for the 1st available category.
          if ($coursecat->id) {
              $url = new moodle_url('/course/edit.php', array('category' => $coursecat->id, 'returnto' => 'category'));
          } else {
              $url = new moodle_url('/course/edit.php',
                  array('category' => $CFG->defaultrequestcategory, 'returnto' => 'topcat'));
          }
          $output .= $this->single_button($url, get_string('addnewcourse'), 'get');
        }
        ob_start();
        print_course_request_buttons($context);
        $output .= ob_get_contents();
        ob_end_clean();
      }
      $output .= '</div><!-- /.ccn_coursecat_action_btns -->';

      if (isset($PAGE->theme->settings->courseliststyle) && ($PAGE->theme->settings->courseliststyle == 2)) {
        $output .='
            </div>
          </div>';
      }

      return $output;
  }

  protected function coursecat_category(coursecat_helper $chelper, $coursecat, $depth) {

    global $CFG, $PAGE;

    $categoryname = $coursecat->get_formatted_name();
    $ccn_category_link = new moodle_url('/course/index.php', array('categoryid' => $coursecat->id));

    // if ($chelper->get_show_courses() == self::COURSECAT_SHOW_COURSES_COUNT && ($coursescount = $coursecat->get_courses_count())) {
    //   // $categoryname .= html_writer::tag('span', ' ('. $coursescount.')', array('title' => get_string('numberofcourses'), 'class' => 'numberofcourse'));
    // }

    $ccn_cat = $coursecat->id;
    $ccn_cat_summary_unclean = $chelper->get_category_formatted_description($coursecat);
    $ccn_cat_summary = preg_replace("/<img[^>]+\>/i", " ", $ccn_cat_summary_unclean);
    $children_courses = $coursecat->get_courses();
    $ccn_items_count = '';
    if ($coursecat->get_children_count() > 0) {
      $ccn_items_count .= $coursecat->get_children_count() . ' ' . get_string('categories');
    } else {
      $ccn_items_count .= count($coursecat->get_courses()) . ' ' . get_string('courses');
    }
    $ccn_cat_updated = get_string('modified') . ' ' . userdate($coursecat->timemodified, '%d %B %Y', 0);

    $contentimages = '';
    if ($description = $chelper->get_category_formatted_description($coursecat)) {
      $dom = new \DOMDocument();
      $dom->loadHTML($description);
      $xpath = new \DOMXPath($dom);
      $src = $xpath->evaluate("string(//img/@src)");
    }
    if ($src){
      $contentimages .= '<img class="img-whp" src="'.$src.'" alt="'.$categoryname.'">';
    } else {
      foreach($children_courses as $child_course) {
        if ($child_course === reset($children_courses)) {
          foreach ($child_course->get_course_overviewfiles() as $file) {
            $isimage = $file->is_valid_image();
            $url = file_encode_url("$CFG->wwwroot/pluginfile.php", '/'. $file->get_contextid(). '/'. $file->get_component(). '/'. $file->get_filearea(). $file->get_filepath(). $file->get_filename(), !$isimage);
            if ($isimage) {
              $contentimages .= '<img class="img-whp" src="'.$url.'" alt="'.$coursename.'">';
            }
          }
        }
      }
    }
    if (isset($PAGE->theme->settings->courseliststyle) && ($PAGE->theme->settings->courseliststyle == 2)) {
      $content .= '
        <div class="col-lg-12 p0"><div class="courses_list_content">
         <div class="top_courses list ccnWithFoot">
           <div class="thumb">
             '.$contentimages.'
             <div class="overlay">
               <div class="tag">'.$ccn_items_count.'</div>
               <a class="tc_preview_course" href="'.$ccn_category_link.'">'.get_string('viewallcourses').'</a>
             </div>
           </div>
           <div class="details">
             <div class="tc_content">';
               if(isset($PAGE->theme->settings->coursecat_modified) && ($PAGE->theme->settings->coursecat_modified !== '1')){
                $content .='<p>'.$ccn_cat_updated.'</p>';
               }
               $content .='
               <a href="'.$ccn_category_link.'"><h5>'.$categoryname.'</h5></a>
               '.$ccn_cat_summary.'

             </div>
             <div class="tc_footer">
               <ul class="tc_meta float-left fn-414">
                 <li class="list-inline-item"><i class="flaticon-book"></i></li>
                 <li class="list-inline-item">'.$ccn_items_count.'</li>
               </ul>
             </div>
           </div>
         </div>
        </div></div>';
      } else {
        $content .= '
          <div class="col-lg-6 col-xl-4">
             <div class="top_courses ccnWithFoot">';
             if($contentimages){
               $content .= '<div class="thumb">
                 '.$contentimages.'
                 <div class="overlay">
                   <div class="tag">'.$ccn_items_count.'</div>
                   <a class="tc_preview_course" href="'.$ccn_category_link.'">'.get_string('viewallcourses').'</a>
                 </div>
               </div>';
             }
             $content .='
               <div class="details">
                         <div class="tc_content">';
                         if(isset($PAGE->theme->settings->coursecat_modified) && ($PAGE->theme->settings->coursecat_modified !== '1')){
                          $content .='<p>'.$ccn_cat_updated.'</p>';
                         }
                         $content .='
                           <h5><a href="'. $ccn_category_link .'">'. $categoryname .'</a></h5>
                           '.$ccn_cat_summary.'

                         </div>
                         </div>
                         <div class="tc_footer">
                           <ul class="tc_meta float-left">
                             <li class="list-inline-item"><i class="flaticon-book"></i></li>
                             <li class="list-inline-item">'.$ccn_items_count.'</li>
                           </ul>
                         </div>

             </div>
           </div>';
         }
      return $content;
    }
  protected function coursecat_subcategories(coursecat_helper $chelper, $coursecat, $depth) {
      global $CFG;
      $subcategories = array();
      if (!$chelper->get_categories_display_option('nodisplay')) {
          $subcategories = $coursecat->get_children($chelper->get_categories_display_options());
      }
      $totalcount = $coursecat->get_children_count();
      if (!$totalcount) {
          // Note that we call core_course_category::get_children_count() AFTER core_course_category::get_children()
          // to avoid extra DB requests.
          // Categories count is cached during children categories retrieval.
          return '';
      }


      if (isset($PAGE->theme->settings->courseliststyle) && ($PAGE->theme->settings->courseliststyle == 2)) {
        $content .= '<div class="courses row category-browse-3">';
      } else {
        $content .= '<div class="courses row courses_container">';
      }

      // prepare content of paging bar or more link if it is needed
      $paginationurl = $chelper->get_categories_display_option('paginationurl');
      $paginationallowall = $chelper->get_categories_display_option('paginationallowall');
      if ($totalcount > count($subcategories)) {
          if ($paginationurl) {
              // the option 'paginationurl was specified, display pagingbar
              $perpage = $chelper->get_categories_display_option('limit', $CFG->coursesperpage);
              $page = $chelper->get_categories_display_option('offset') / $perpage;
              $pagingbar = $this->paging_bar($totalcount, $page, $perpage,
                      $paginationurl->out(false, array('perpage' => $perpage)));
              if ($paginationallowall) {
                  $pagingbar .= html_writer::tag('div', html_writer::link($paginationurl->out(false, array('perpage' => 'all')),
                          get_string('showall', '', $totalcount)), array('class' => 'paging paging-showall'));
              }
          } else if ($viewmoreurl = $chelper->get_categories_display_option('viewmoreurl')) {
              // the option 'viewmoreurl' was specified, display more link (if it is link to category view page, add category id)
              if ($viewmoreurl->compare(new moodle_url('/course/index.php'), URL_MATCH_BASE)) {
                  $viewmoreurl->param('categoryid', $coursecat->id);
              }
              $viewmoretext = $chelper->get_categories_display_option('viewmoretext', new lang_string('viewmore'));
              $morelink = ' <div class="col-12 paging paging-morelink">
                              <div class="courses_all_btn text-center">
                                <a class="btn btn-transparent mt-3 mb-3" href="'.$viewmoreurl.'">'.$viewmoretext.'</a>
                              </div>
                            </div>';
              // $morelink = html_writer::tag('div', html_writer::link($viewmoreurl, $viewmoretext),
              //         array('class' => 'paging paging-morelink'));
          }
      } else if (($totalcount > $CFG->coursesperpage) && $paginationurl && $paginationallowall) {
          // there are more than one page of results and we are in 'view all' mode, suggest to go back to paginated view mode
          $pagingbar = html_writer::tag('div', html_writer::link($paginationurl->out(false, array('perpage' => $CFG->coursesperpage)),
              get_string('showperpage', '', $CFG->coursesperpage)), array('class' => 'paging paging-showperpage'));
      }

      // display list of subcategories
      // $content = html_writer::start_tag('div', array('class' => ''));

      // if (!empty($pagingbar)) {
      //     $content .= $pagingbar;
      // }

      foreach ($subcategories as $subcategory) {
          $content .= $this->coursecat_category($chelper, $subcategory, $depth + 1);
      }

      if (!empty($pagingbar)) {
          $content .= $pagingbar;
      }
      if (!empty($morelink)) {
          $content .= $morelink;
      }

      // $content .= html_writer::end_tag('div');
      $content .= '</div>';
      return $content;
  }

  protected function coursecat_coursebox(coursecat_helper $chelper, $course, $additionalclasses = '') {

      global $PAGE;

      // if (!isset($this->strings->summary)) {
      //     $this->strings->summary = get_string('summary');
      // }
      // if ($chelper->get_show_courses() <= self::COURSECAT_SHOW_COURSES_COUNT) {
      //     return '';
      // }
      if ($course instanceof stdClass) {
          $course = new core_course_list_element($course);
      }
      $content = '';

      // if ($chelper->get_show_courses() >= self::COURSECAT_SHOW_COURSES_EXPANDED) {
          $nametag = 'h3';
      // } else {
      //     $classes .= ' collapsed';
      //     $nametag = 'div';
      // }

      global $ccn_info_box;

      $ccn_info_box = html_writer::start_tag('div', array('class' => 'info'));


      // If we display course in collapsed form but the course has summary or course contacts, display the link to the info page.
      $ccn_info_box .= html_writer::start_tag('div', array('class' => 'moreinfo'));
      // if ($chelper->get_show_courses() < self::COURSECAT_SHOW_COURSES_EXPANDED) {
          // if ($course->has_summary() || $course->has_course_contacts() || $course->has_course_overviewfiles()
          //         || $course->has_custom_fields()) {
              // $url = new moodle_url('/course/info.php', array('id' => $course->id));
              // $image = $this->output->pix_icon('i/info', $this->strings->summary);
              // $ccn_info_box .= html_writer::link($url, $image, array('title' => $this->strings->summary));
              // Make sure JS file to expand course content is included.
              // $this->coursecat_include_js();
          // }
      // }
      $ccn_info_box .= html_writer::end_tag('div'); // .moreinfo

      // print enrolmenticons
      if ($icons = enrol_get_course_info_icons($course)) {
          $ccn_info_box .= html_writer::start_tag('div', array('class' => 'enrolmenticons'));
          foreach ($icons as $pix_icon) {
              $ccn_info_box .= $this->render($pix_icon);
          }
          $ccn_info_box .= html_writer::end_tag('div'); // .enrolmenticons
      }

      $ccn_info_box .= html_writer::end_tag('div'); // .info

      $content .= $this->coursecat_coursebox_content($chelper, $course);

      return $content;
  }

  protected function coursecat_coursebox_content(coursecat_helper $chelper, $course) {
      global $CFG, $PAGE, $ccn_info_box;
      // if ($chelper->get_show_courses() < self::COURSECAT_SHOW_COURSES_EXPANDED) {
      //     return '';
      // }
      if ($course instanceof stdClass) {
          $course = new core_course_list_element($course);
      }
      $content = '';
      $courseid = $course->id;

      $ccnCourseHandler = new ccnCourseHandler();
      $ccnCourse = $ccnCourseHandler->ccnGetCourseDetails($courseid);


      $contentimages = $contentfiles = '';
      $coursesummary = ($course->has_summary()) ? $chelper->get_course_formatted_summary($course) : '';
      $coursename = $chelper->get_course_formatted_name($course);
      $coursenamelink = new moodle_url('/course/view.php', array('id' => $course->id));
      $ccn_context = context_course::instance($course->id);
      $numberofusers = count_enrolled_users($ccn_context);
      $category = format_text($PAGE->category->name, FORMAT_HTML, array('filter' => true));

      // Display course contacts. See core_course_list_element::get_course_contacts().
      if ($course->has_course_contacts()) {
          $ccn_course_contacts = '';
          foreach ($course->get_course_contacts() as $coursecontact) {
              $rolenames = array_map(function ($role) {
                  return $role->displayname;
              }, $coursecontact['roles']);
              $name = implode(", ", $rolenames).': '.
                      html_writer::link(new moodle_url('/user/view.php',
                              array('id' => $coursecontact['user']->id, 'course' => SITEID)),
                          $coursecontact['username']);
              $ccn_course_contacts .= '<span class="ccn_course_meta_item mr10">'.$name.'</span>';
          }
      }
      $ccn_course_meta = !empty($ccn_course_contacts) ? $ccn_course_contacts : $category;
      $contenttext = '';
      if((
        isset($PAGE->theme->settings->coursecat_enrolments)
        && $PAGE->theme->settings->coursecat_enrolments != 1
      )||(
        isset($PAGE->theme->settings->coursecat_announcements)
        && $PAGE->theme->settings->coursecat_announcements != 1
      )||(
        isset($PAGE->theme->settings->coursecat_prices)
        && $PAGE->theme->settings->coursecat_prices != 1
      )){
        $topCoursesClass = 'ccnWithFoot';
        $ccnBlockShowBottomBar = 1;
      } else {
        $ccnBlockShowBottomBar = 0;
        $topCoursesClass = '';
      }

      if(
        isset($PAGE->theme->settings->coursecat_prices)
        && $PAGE->theme->settings->coursecat_prices != 1
      ){
        $ccnBlockShowPrice = 1;
      } else {
        $ccnBlockShowPrice = 0;
      }

      foreach ($course->get_course_overviewfiles() as $file) {
          $isimage = $file->is_valid_image();
          $url = file_encode_url("$CFG->wwwroot/pluginfile.php",
                  '/'. $file->get_contextid(). '/'. $file->get_component(). '/'.
                  $file->get_filearea(). $file->get_filepath(). $file->get_filename(), !$isimage);
          if ($isimage) {
              $contentimages .= '<img class="img-whp" src="'.$url.'" alt="'.$coursename.'">';
          }
       }
       if (isset($PAGE->theme->settings->courseliststyle) && ($PAGE->theme->settings->courseliststyle == 2)) {
          $contenttext .= '
							<div class="col-lg-12 p0"><div class="courses_list_content">
								<div class="top_courses list '.$topCoursesClass.'">
									<div class="thumb">
										'.$contentimages.'
										<div class="overlay">
                      <div class="tag">'.$ccnCourse->categoryName.'</div>
											<a class="tc_preview_course" href="'.$coursenamelink.'">'.get_string('preview_course', 'theme_edumy').'</a>
										</div>
									</div>
									<div class="details">
										<div class="tc_content">
											<p>'.$ccn_course_meta.'</p>
											'.$ccnCourse->ccnRender->title.'
											<p>'.$coursesummary.'</p>';
                      $contenttext .= $ccnCourse->ccnRender->starRating;
                      $contenttext .= $ccn_info_box.'
										</div>';
                    if($ccnBlockShowBottomBar == 1){
                      $contenttext .='
  										<div class="tc_footer">
                      <ul class="tc_meta float-left fn-414">'.$ccnCourse->ccnRender->enrolmentIcon . $ccnCourse->ccnRender->announcementsIcon.'</ul>';
                      if($ccnBlockShowPrice == 1){
                        $contenttext .= '<div class="tc_price float-right">'.$ccnCourse->price.'</div>';
                      }
                      $contenttext .='
                      </div>';
                    }
                    $contenttext .='
									</div>
								</div>
							</div></div>';
       } else {
          $contenttext .= '
          <div class="col-lg-6 col-xl-4">
							<div class="top_courses '.$topCoursesClass.'">';
              if($contentimages){
                $contenttext .='
								<div class="thumb">
									'.$contentimages.'
									<div class="overlay">
                    <div class="tag">'.$ccnCourse->categoryName.'</div>
										<a class="tc_preview_course" href="'.$coursenamelink.'">'.get_string('preview_course', 'theme_edumy').'</a>
									</div>
								</div>';
              }
              $contenttext .='
                <div class="details">
                          <div class="tc_content">
                            <p>'.$ccn_course_meta.'</p>
                            '.$ccnCourse->ccnRender->title.'
                            <p>'. $coursesummary .'</p>';
                            $contenttext .= $ccnCourse->ccnRender->starRating;
                            $contenttext .= $ccn_info_box.'
                          </div>
                          </div>';
                          if($ccnBlockShowBottomBar == 1){
                            $contenttext .='
        										<div class="tc_footer">
                            <ul class="tc_meta float-left fn-414">'.$ccnCourse->ccnRender->enrolmentIcon . $ccnCourse->ccnRender->announcementsIcon.'</ul>';
                            if($ccnBlockShowPrice == 1){
                              $contenttext .= '<div class="tc_price float-right">'.$ccnCourse->price.'</div>';
                            }
                            $contenttext .='
                            </div>';
                          }
                        $contenttext .= '

							</div>
						</div>';
      }

      $content .= $contenttext. $contentfiles;

      return $content;
  }

  /**
   * Renders HTML to display a list of course modules in a course section
   * Also displays "move here" controls in Javascript-disabled mode
   *
   * This function calls {@link core_course_renderer::course_section_cm()}
   *
   * @param stdClass $course course object
   * @param int|stdClass|section_info $section relative section number or section object
   * @param int $sectionreturn section number to return to
   * @param int $displayoptions
   * @return void
   */
  public function course_section_cm_list($course, $section, $sectionreturn = null, $displayoptions = array()) {
      global $USER;

      $output = '';
      $modinfo = get_fast_modinfo($course);
      if (is_object($section)) {
          $section = $modinfo->get_section_info($section->section);
      } else {
          $section = $modinfo->get_section_info($section);
      }
      $completioninfo = new completion_info($course);

      // check if we are currently in the process of moving a module with JavaScript disabled
      $ismoving = $this->page->user_is_editing() && ismoving($course->id);
      if ($ismoving) {
          $movingpix = new pix_icon('movehere', get_string('movehere'), 'moodle', array('class' => 'movetarget'));
          $strmovefull = strip_tags(get_string("movefull", "", "'$USER->activitycopyname'"));
      }

      // Get the list of modules visible to user (excluding the module being moved if there is one)
      $moduleshtml = array();
      if (!empty($modinfo->sections[$section->section])) {
          foreach ($modinfo->sections[$section->section] as $modnumber) {
              $mod = $modinfo->cms[$modnumber];

              if ($ismoving and $mod->id == $USER->activitycopy) {
                  // do not display moving mod
                  continue;
              }

              if ($modulehtml = $this->course_section_cm_list_item($course,
                      $completioninfo, $mod, $sectionreturn, $displayoptions)) {
                  $moduleshtml[$modnumber] = $modulehtml;
              }
          }
      }

      $sectionoutput = '';
      if (!empty($moduleshtml) || $ismoving) {
          foreach ($moduleshtml as $modnumber => $modulehtml) {
              if ($ismoving) {
                  $movingurl = new moodle_url('/course/mod.php', array('moveto' => $modnumber, 'sesskey' => sesskey()));
                  $sectionoutput .= html_writer::tag('li',
                          html_writer::link($movingurl, $this->output->render($movingpix), array('title' => $strmovefull)),
                          array('class' => 'movehere'));
              }

              $sectionoutput .= $modulehtml;
          }

          if ($ismoving) {
              $movingurl = new moodle_url('/course/mod.php', array('movetosection' => $section->id, 'sesskey' => sesskey()));
              $sectionoutput .= html_writer::tag('li',
                      html_writer::link($movingurl, $this->output->render($movingpix), array('title' => $strmovefull)),
                      array('class' => 'movehere'));
          }
      }

      // Always output the section module list.
      $output .= html_writer::tag('ul', $sectionoutput, array('class' => 'section img-text cs_list mb0'));

      return $output;
  }

  /**
   * ccnComm: BEGIN COCOON OVERRIDES FOR FOCUS ACTIVITYNAV
   * Renders HTML to display a list of course modules in a course section
   * Also displays "move here" controls in Javascript-disabled mode
   *
   * This function calls {@link core_course_renderer::course_section_cm()}
   *
   * @param stdClass $course course object
   * @param int|stdClass|section_info $section relative section number or section object
   * @param int $sectionreturn section number to return to
   * @param int $displayoptions
   * @return void
   */
  public function _ccnActivityNav_course_section_cm_list($course, $section, $sectionreturn = null, $displayoptions = array()) {
      global $USER;

      $output = '';
      $modinfo = get_fast_modinfo($course);
      if (is_object($section)) {
          $section = $modinfo->get_section_info($section->section);
      } else {
          $section = $modinfo->get_section_info($section);
      }
      $completioninfo = new completion_info($course);

      // check if we are currently in the process of moving a module with JavaScript disabled
      $ismoving = $this->page->user_is_editing() && ismoving($course->id);
      if ($ismoving) {
          $movingpix = new pix_icon('movehere', get_string('movehere'), 'moodle', array('class' => 'movetarget'));
          $strmovefull = strip_tags(get_string("movefull", "", "'$USER->activitycopyname'"));
      }

      // Get the list of modules visible to user (excluding the module being moved if there is one)
      $moduleshtml = array();
      if (!empty($modinfo->sections[$section->section])) {
          foreach ($modinfo->sections[$section->section] as $modnumber) {
              $mod = $modinfo->cms[$modnumber];

              if ($ismoving and $mod->id == $USER->activitycopy) {
                  // do not display moving mod
                  continue;
              }

              if ($modulehtml = $this->_ccnActivityNav_course_section_cm_list_item($course,
                      $completioninfo, $mod, $sectionreturn, $displayoptions)) {
                  $moduleshtml[$modnumber] = $modulehtml;
              }
          }
      }

      $sectionoutput = '';
      if (!empty($moduleshtml) || $ismoving) {
          foreach ($moduleshtml as $modnumber => $modulehtml) {
              if ($ismoving) {
                  $movingurl = new moodle_url('/course/mod.php', array('moveto' => $modnumber, 'sesskey' => sesskey()));
                  $sectionoutput .= html_writer::tag('li',
                          html_writer::link($movingurl, $this->output->render($movingpix), array('title' => $strmovefull)),
                          array('class' => 'movehere'));
              }

              $sectionoutput .= $modulehtml;
          }

          if ($ismoving) {
              $movingurl = new moodle_url('/course/mod.php', array('movetosection' => $section->id, 'sesskey' => sesskey()));
              $sectionoutput .= html_writer::tag('li',
                      html_writer::link($movingurl, $this->output->render($movingpix), array('title' => $strmovefull)),
                      array('class' => 'movehere'));
          }
      }

      // Always output the section module list.
      $output .= html_writer::tag('ul', $sectionoutput, array('class' => 'section img-text cs_list mb0'));

      return $output;
  }


  /**
   * Renders HTML to display one course module for display within a section.
   *
   * This function calls:
   * {@link core_course_renderer::course_section_cm()}
   *
   * @param stdClass $course
   * @param completion_info $completioninfo
   * @param cm_info $mod
   * @param int|null $sectionreturn
   * @param array $displayoptions
   * @return String
   */
  public function _ccnActivityNav_course_section_cm_list_item($course, &$completioninfo, cm_info $mod, $sectionreturn, $displayoptions = array()) {
      $ccnUriForCourseFocus = $_SERVER['REQUEST_URI'];

      $output = '';
      if ($modulehtml = $this->_ccnActivityNav_course_section_cm($course, $completioninfo, $mod, $sectionreturn, $displayoptions)) {

          $ccnUri = '/mod/'.$mod->modname.'/view.php?id='.$mod->id;

          $modclasses = 'activity ' . $mod->modname . ' modtype_' . $mod->modname . ' ' . $mod->extraclasses;

          if(strpos($ccnUriForCourseFocus, $ccnUri) || $ccnUriForCourseFocus == $ccnUri) {
            $modclasses .= ' active';
          }
          $output .= html_writer::tag('li', $modulehtml, array('class' => $modclasses, 'id' => 'module-' . $mod->id));
      }
      return $output;
  }


  /**
   * Renders HTML to display one course module in a course section
   *
   * This includes link, content, availability, completion info and additional information
   * that module type wants to display (i.e. number of unread forum posts)
   *
   * This function calls:
   * {@link core_course_renderer::course_section_cm_name()}
   * {@link core_course_renderer::course_section_cm_text()}
   * {@link core_course_renderer::course_section_cm_availability()}
   * {@link core_course_renderer::course_section_cm_completion()}
   * {@link course_get_cm_edit_actions()}
   * {@link core_course_renderer::course_section_cm_edit_actions()}
   *
   * @param stdClass $course
   * @param completion_info $completioninfo
   * @param cm_info $mod
   * @param int|null $sectionreturn
   * @param array $displayoptions
   * @return string
   */
  public function _ccnActivityNav_course_section_cm($course, &$completioninfo, cm_info $mod, $sectionreturn, $displayoptions = array()) {
      $output = '';
      // We return empty string (because course module will not be displayed at all)
      // if:
      // 1) The activity is not visible to users
      // and
      // 2) The 'availableinfo' is empty, i.e. the activity was
      //     hidden in a way that leaves no info, such as using the
      //     eye icon.
      if (!$mod->is_visible_on_course_page()) {
          return $output;
      }

      $indentclasses = 'mod-indent';
      if (!empty($mod->indent)) {
          $indentclasses .= ' mod-indent-'.$mod->indent;
          if ($mod->indent > 15) {
              $indentclasses .= ' mod-indent-huge';
          }
      }

      $output .= html_writer::start_tag('div');

      // if ($this->page->user_is_editing()) {
      //     $output .= course_get_cm_move($mod, $sectionreturn);
      // }

      $output .= html_writer::start_tag('div', array('class' => 'mod-indent-outer'));

      // This div is used to indent the content.
      $output .= html_writer::div('', $indentclasses);

      // Start a wrapper for the actual content to keep the indentation consistent
      $output .= html_writer::start_tag('div');

      // Display the link to the module (or do nothing if module has no url)
      $cmname = $this->course_section_cm_name($mod, $displayoptions);

      if (!empty($cmname)) {
          // Start the div for the activity title, excluding the edit icons.
          $output .= html_writer::start_tag('div', array('class' => 'activityinstance'));
          $output .= $cmname;


          // Module can put text after the link (e.g. forum unread)
          $output .= $mod->afterlink;

          // Closing the tag which contains everything but edit icons. Content part of the module should not be part of this.
          $output .= html_writer::end_tag('div'); // .activityinstance
      }

      // If there is content but NO link (eg label), then display the
      // content here (BEFORE any icons). In this case cons must be
      // displayed after the content so that it makes more sense visually
      // and for accessibility reasons, e.g. if you have a one-line label
      // it should work similarly (at least in terms of ordering) to an
      // activity.
      $contentpart = $this->course_section_cm_text($mod, $displayoptions);
      $url = $mod->url;
      if (empty($url)) {
          $output .= $contentpart;
      }

      $modicons = '';
      // if ($this->page->user_is_editing()) {
      //     $editactions = course_get_cm_edit_actions($mod, $mod->indent, $sectionreturn);
      //     $modicons .= ' '. $this->course_section_cm_edit_actions($editactions, $mod, $displayoptions);
      //     $modicons .= $mod->afterediticons;
      // }

      $modicons .= $this->course_section_cm_completion($course, $completioninfo, $mod, $displayoptions);

      if (!empty($modicons)) {
          $output .= html_writer::span($modicons, 'actions');
      }

      // Show availability info (if module is not available).
      $output .= $this->course_section_cm_availability($mod, $displayoptions);

      // If there is content AND a link, then display the content here
      // (AFTER any icons). Otherwise it was displayed before
      if (!empty($url)) {
          $output .= $contentpart;
      }

      $output .= html_writer::end_tag('div'); // $indentclasses

      // End of indentation div.
      $output .= html_writer::end_tag('div');

      $output .= html_writer::end_tag('div');
      return $output;
  }


  protected function coursecat_courses(coursecat_helper $chelper, $courses, $totalcount = null) {
      global $CFG;
      if ($totalcount === null) {
          $totalcount = count($courses);
      }
      if (!$totalcount) {
          // Courses count is cached during courses retrieval.
          return '';
      }

      if ($chelper->get_show_courses() == self::COURSECAT_SHOW_COURSES_AUTO) {
          // In 'auto' course display mode we analyse if number of courses is more or less than $CFG->courseswithsummarieslimit
          if ($totalcount <= $CFG->courseswithsummarieslimit) {
              $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_EXPANDED);
          } else {
              $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_COLLAPSED);
          }
      }

      // prepare content of paging bar if it is needed
      $paginationurl = $chelper->get_courses_display_option('paginationurl');
      $paginationallowall = $chelper->get_courses_display_option('paginationallowall');
      if ($totalcount > count($courses)) {
          // there are more results that can fit on one page
          if ($paginationurl) {
              // the option paginationurl was specified, display pagingbar
              $perpage = $chelper->get_courses_display_option('limit', $CFG->coursesperpage);
              $page = $chelper->get_courses_display_option('offset') / $perpage;
              $pagingbar = $this->paging_bar($totalcount, $page, $perpage,
                      $paginationurl->out(false, array('perpage' => $perpage)));
              if ($paginationallowall) {
                  $pagingbar .= html_writer::tag('div', html_writer::link($paginationurl->out(false, array('perpage' => 'all')),
                          get_string('showall', '', $totalcount)), array('class' => 'paging paging-showall'));
              }
          } else if ($viewmoreurl = $chelper->get_courses_display_option('viewmoreurl')) {
              // the option for 'View more' link was specified, display more link
              $viewmoretext = $chelper->get_courses_display_option('viewmoretext', new lang_string('viewmore'));
              // $morelink = html_writer::tag('div', html_writer::link($viewmoreurl, $viewmoretext),
              //         array('class' => 'paging paging-morelink'));

              $morelink = ' <div class="col-12 paging paging-morelink">
                              <div class="courses_all_btn text-center">
                                <a class="btn btn-transparent mt-3 mb-3" href="'.$viewmoreurl.'">'.$viewmoretext.'</a>
                              </div>
                            </div>';

          }
      } else if (($totalcount > $CFG->coursesperpage) && $paginationurl && $paginationallowall) {
          // there are more than one page of results and we are in 'view all' mode, suggest to go back to paginated view mode
          $pagingbar = html_writer::tag('div', html_writer::link($paginationurl->out(false, array('perpage' => $CFG->coursesperpage)),
              get_string('showperpage', '', $CFG->coursesperpage)), array('class' => 'paging paging-showperpage'));
      }

      // display list of courses
      $attributes = $chelper->get_and_erase_attributes('courses');
      $content = html_writer::start_tag('div', $attributes);

      // if (!empty($pagingbar)) {
      //     $content .= '<div class="col-lg-12 mt30 mb30">'.$pagingbar.'</div>';
      // }

      $coursecount = 0;
      foreach ($courses as $course) {
          $coursecount ++;
          $classes = ($coursecount%2) ? 'odd' : 'even';
          if ($coursecount == 1) {
              $classes .= ' first';
          }
          if ($coursecount >= count($courses)) {
              $classes .= ' last';
          }
          $content .= $this->coursecat_coursebox($chelper, $course, $classes);
      }

      if (!empty($pagingbar)) {
          $content .= '<div class="col-lg-12 mt30 mb30">'.$pagingbar.'</div>';
      }
      if (!empty($morelink)) {
          $content .= $morelink;
      }

      $content .= html_writer::end_tag('div'); // .courses
      return $content;
  }

  /**
   * Renders html to print list of courses tagged with particular tag
   *
   * @param int $tagid id of the tag
   * @param bool $exclusivemode if set to true it means that no other entities tagged with this tag
   *             are displayed on the page and the per-page limit may be bigger
   * @param int $fromctx context id where the link was displayed, may be used by callbacks
   *            to display items in the same context first
   * @param int $ctx context id where to search for records
   * @param bool $rec search in subcontexts as well
   * @param array $displayoptions
   * @return string empty string if no courses are marked with this tag or rendered list of courses
   */
  public function tagged_courses($tagid, $exclusivemode = true, $ctx = 0, $rec = true, $displayoptions = null) {
      global $CFG;
      if (empty($displayoptions)) {
          $displayoptions = array();
      }
      $showcategories = !core_course_category::is_simple_site();
      $displayoptions += array('limit' => $CFG->coursesperpage, 'offset' => 0);
      $chelper = new coursecat_helper();
      $searchcriteria = array('tagid' => $tagid, 'ctx' => $ctx, 'rec' => $rec);
      $chelper->set_show_courses($showcategories ? self::COURSECAT_SHOW_COURSES_EXPANDED_WITH_CAT :
                  self::COURSECAT_SHOW_COURSES_EXPANDED)->
              set_search_criteria($searchcriteria)->
              set_courses_display_options($displayoptions)->
              set_attributes(array('class' => ' course-search-result course-search-result-tagid
                                                row'));
              // (we set the same css class as in search results by tagid)
      if ($totalcount = core_course_category::search_courses_count($searchcriteria)) {
          $courses = core_course_category::search_courses($searchcriteria, $chelper->get_courses_display_options());
          if ($exclusivemode) {
              return $this->coursecat_courses($chelper, $courses, $totalcount);
          } else {
              $tagfeed = new core_tag\output\tagfeed();
              $img = $this->output->pix_icon('i/course', '');
              foreach ($courses as $course) {
                  $url = course_get_url($course);
                  $imgwithlink = html_writer::link($url, $img);
                  $coursename = html_writer::link($url, $course->get_formatted_name());
                  $details = '';
                  if ($showcategories && ($cat = core_course_category::get($course->category, IGNORE_MISSING))) {
                      $details = get_string('category').': '.
                              html_writer::link(new moodle_url('/course/index.php', array('categoryid' => $cat->id)),
                                      $cat->get_formatted_name(), array('class' => $cat->visible ? '' : 'dimmed'));
                  }
                  $tagfeed->add($imgwithlink, $coursename, $details);
              }
              return $this->output->render_from_template('core_tag/tagfeed', $tagfeed->export_for_template($this->output));
          }
      }
      return '';
  }

  /**
   * Returns HTML to print list of available courses for the frontpage
   *
   * @return string
   */
  public function frontpage_available_courses() {
      global $CFG, $PAGE;

      $chelper = new coursecat_helper();
      $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_EXPANDED)->
              set_courses_display_options(array(
                  'recursive' => true,
                  'limit' => $CFG->frontpagecourselimit,
                  'viewmoreurl' => new moodle_url('/course/index.php'),
                  'viewmoretext' => new lang_string('fulllistofcourses')));

      // $chelper->set_attributes(array('class' => ' frontpage-course-list-all
      //                                             row '));

      if (isset($PAGE->theme->settings->courseliststyle) && ($PAGE->theme->settings->courseliststyle == 2)) {
        $chelper->set_attributes(array('class' => ' frontpage-course-list-all
                                                    courses row courses_container'));
      } else {
        $chelper->set_attributes(array('class' => ' frontpage-course-list-all
                                                    row'));
      }

      $courses = core_course_category::top()->get_courses($chelper->get_courses_display_options());
      $totalcount = core_course_category::top()->get_courses_count($chelper->get_courses_display_options());
      if (!$totalcount && !$this->page->user_is_editing() && has_capability('moodle/course:create', context_system::instance())) {
          // Print link to create a new course, for the 1st available category.
          return $this->add_new_course_button();
      }
      return $this->coursecat_courses($chelper, $courses, $totalcount);
  }

  /**
   * Returns HTML to print list of courses user is enrolled to for the frontpage
   *
   * Also lists remote courses or remote hosts if MNET authorisation is used
   *
   * @return string
   */
  public function frontpage_my_courses() {
      global $USER, $CFG, $DB, $PAGE;

      if (!isloggedin() or isguestuser()) {
          return '';
      }

      $output = '';
      $courses  = enrol_get_my_courses('summary, summaryformat');
      $rhosts   = array();
      $rcourses = array();
      if (!empty($CFG->mnet_dispatcher_mode) && $CFG->mnet_dispatcher_mode==='strict') {
          $rcourses = get_my_remotecourses($USER->id);
          $rhosts   = get_my_remotehosts();
      }

      if (!empty($courses) || !empty($rcourses) || !empty($rhosts)) {

          $chelper = new coursecat_helper();
          $totalcount = count($courses);
          if (count($courses) > $CFG->frontpagecourselimit) {
              // There are more enrolled courses than we can display, display link to 'My courses'.
              $courses = array_slice($courses, 0, $CFG->frontpagecourselimit, true);
              $chelper->set_courses_display_options(array(
                      'viewmoreurl' => new moodle_url('/my/'),
                      'viewmoretext' => new lang_string('mycourses')
                  ));
          } else if (core_course_category::top()->is_uservisible()) {
              // All enrolled courses are displayed, display link to 'All courses' if there are more courses in system.
              $chelper->set_courses_display_options(array(
                      'viewmoreurl' => new moodle_url('/course/index.php'),
                      'viewmoretext' => new lang_string('fulllistofcourses')
                  ));
              $totalcount = $DB->count_records('course') - 1;
          }

          $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_EXPANDED);

          if (isset($PAGE->theme->settings->courseliststyle) && ($PAGE->theme->settings->courseliststyle == 2)) {
            $chelper->set_attributes(array('class' => ' frontpage-course-list-enrolled
                                                      courses row courses_container'));
          } else {
            $chelper->set_attributes(array('class' => ' frontpage-course-list-enrolled
                                                      row'));
          }

          $output .= $this->coursecat_courses($chelper, $courses, $totalcount);

          // MNET
          if (!empty($rcourses)) {
              // at the IDP, we know of all the remote courses
              $output .= html_writer::start_tag('div', array('class' => 'courses'));
              foreach ($rcourses as $course) {
                  $output .= $this->frontpage_remote_course($course);
              }
              $output .= html_writer::end_tag('div'); // .courses
          } elseif (!empty($rhosts)) {
              // non-IDP, we know of all the remote servers, but not courses
              $output .= html_writer::start_tag('div', array('class' => 'courses'));
              foreach ($rhosts as $host) {
                  $output .= $this->frontpage_remote_host($host);
              }
              $output .= html_writer::end_tag('div'); // .courses
          }
      }
      return $output;
  }

  /**
   * Renders part of frontpage with a skip link (i.e. "My courses", "Site news", etc.)
   *
   * @param string $skipdivid
   * @param string $contentsdivid
   * @param string $header Header of the part
   * @param string $contents Contents of the part
   * @return string
   */
  protected function frontpage_part($skipdivid, $contentsdivid, $header, $contents) {
      if (strval($contents) === '') {
          return '';
      }
      $output = html_writer::link('#' . $skipdivid,
          get_string('skipa', 'access', core_text::strtolower(strip_tags($header))),
          array('class' => 'skip-block skip aabtn'));

      // Wrap frontpage part in div container.
      $output .= html_writer::start_tag('div', array( 'id' => $contentsdivid,
                                                      'class'=> 'ccnPseudoFrontpageBlock mb60'));
      // $output .= $this->heading($header);

      $output .= '<div class="row">
                    <div class="col-lg-6 offset-lg-3">
                      <div class="main-title text-center">
                        <h3 class="mb0 mt0">'.$header.'</h3>
                      </div>
                    </div>
                  </div>';

      $output .= $contents;

      // End frontpage part div container.
      $output .= html_writer::end_tag('div');

      $output .= html_writer::tag('span', '', array('class' => 'skip-block-to', 'id' => $skipdivid));
      return $output;
  }

  // /**
  //  * Renders html to display a course search form
  //  *
  //  * @param string $value default value to populate the search field
  //  * @return string
  //  */
  // public function course_search_form($value = '') {
  //
  //     $data = [
  //         'action' => \core_search\manager::get_course_search_url(),
  //         'btnclass' => 'btn-primary',
  //         'inputname' => 'q',
  //         'searchstring' => get_string('searchcourses'),
  //         'hiddenfields' => (object) ['name' => 'areaids', 'value' => 'core_course-course'],
  //         'query' => $value
  //     ];
  //     return $this->render_from_template('theme_edumy/ccn_mdl_310/ccn_course_search_form', $data);
  // }


  /**
   * Renders html to display a course search form
   *
   * @param string $value default value to populate the search field
   * @return string
   */
  public function course_search_form($value = '', $format = 'plain') {

    $ccnMdlHandler = new ccnMdlHandler();
    $ccnGetCoreVersion = $ccnMdlHandler->ccnGetCoreVersion();

    if($ccnGetCoreVersion == '310'){
      $data = [
          'action' => \core_search\manager::get_course_search_url(),
          'btnclass' => 'btn-primary',
          'inputname' => 'q',
          'searchstring' => get_string('searchcourses'),
          'hiddenfields' => (object) ['name' => 'areaids', 'value' => 'core_course-course'],
          'query' => $value
      ];
      return $this->render_from_template('theme_edumy/ccn_mdl_310/ccn_course_search_form', $data);
    } else {
      static $count = 0;
      $formid = 'coursesearch';
      if ((++$count) > 1) {
          $formid .= $count;
      }

      switch ($format) {
          case 'navbar' :
              $formid = 'coursesearchnavbar';
              $inputid = 'navsearchbox';
              $inputsize = 20;
              break;
          case 'short' :
              $inputid = 'shortsearchbox';
              $inputsize = 12;
              break;
          default :
              $inputid = 'coursesearchbox';
              $inputsize = 30;
      }

      $data = (object) [
              'searchurl' => (new moodle_url('/course/search.php'))->out(false),
              'id' => $formid,
              'inputid' => $inputid,
              'inputsize' => $inputsize,
              'value' => $value
      ];
      if ($format != 'navbar') {
          $helpicon = new \help_icon('coursesearch', 'core');
          $data->helpicon = $helpicon->export_for_template($this);
      }

      return $this->render_from_template('core_course/course_search_form', $data);
    }
  }

}
