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

namespace theme_edumy\output\core_user\myprofile;

defined('MOODLE_INTERNAL') || die;

use \core_user\output\myprofile\category;
use core_user\output\myprofile\tree;
use core_user\output\myprofile\node;
use core_user\output\myprofile;
use context_course;
use core_course_list_element;
use DateTime;
use core_date;
use ccnUserHandler;

class renderer extends \core_user\output\myprofile\renderer {

  public function render_tree(tree $tree) {
      global $CFG, $USER, $DB, $SESSION, $SITE, $PAGE, $OUTPUT;

      $ccn_user_id = optional_param('id', 0, PARAM_INT);
      $ccn_user_id = $ccn_user_id ? $ccn_user_id : $USER->id;       // Owner of the page.

      $ccn_page = new \stdClass();
      $ccn_page->id = $ccn_user_id;


      $ccnUserHandler = new ccnUserHandler();
      $ccnUser = $ccnUserHandler->ccnGetUserDetails($ccn_user_id);

      // print_object($ccnUser);

      if(!($ccn_page->id == $USER->id)) {
        if (!isset($SESSION->theme_edumy_counter)) {
          $SESSION->theme_edumy_counter = array();
        }
        if (!isset($SESSION->theme_edumy_counter[$ccn_page->id])) {
          $SESSION->theme_edumy_counter[$ccn_page->id] = array();
        }

        $ccn_ip = getremoteaddr();
        $ccn_ip = bin2hex($ccn_ip);
        $ccn_ip = substr($ccn_ip, 0, 15); //char15 limit
        $ccn_time_difference = 0;

        if (!isset($SESSION->theme_edumy_counter[$ccn_page->id]['time'])) {
          $sql = "SELECT MAX(time) AS mintime FROM {$CFG->prefix}theme_edumy_counter
              WHERE course = {$ccn_page->id}
              AND ip = '$ccn_ip'";

          $time = $DB->get_record_sql($sql);

          $SESSION->theme_edumy_counter[$ccn_page->id]['time'] = $time && $time->mintime ? $time->mintime : 0;
        }

        $ccn_increase = false;

        if ($SESSION->theme_edumy_counter[$ccn_page->id]['time'] < (time() - $ccn_time_difference)) {
          $dataobject = new \stdClass();
          $dataobject->ip = $ccn_ip;
          $dataobject->course = $ccn_page->id;
          $dataobject->time = time();
          $DB->insert_record('theme_edumy_counter', $dataobject, false);
          $SESSION->theme_edumy_counter[$ccn_page->id]['time'] = time();
          $ccn_increase = true;
        }

      }

      // need return first
      $return = '';

      if($PAGE->theme->settings->user_profile_layout != 1){ //Edumy Frontend
        $ccn_col_main = 'col-md-12 col-lg-8 col-xl-9';
        $ccn_col_side = 'col-lg-4 col-xl-3';
        $ccn_col_side_block = 'selected_filter_widget siderbar_contact_widget style2 mb30';
        $ccn_col_block_title = '';
        $ccn_col_side_block_content = '';
        $ccn_col_main_block = 'b0p0';
      } else { //Edumy Dashboard
        $ccn_col_main = 'col-md-12 col-lg-8 col-xl-8';
        $ccn_col_side = 'col-lg-4 col-xl-4';
        $ccn_col_side_block = 'ccnDashBl mb30 p0';
        $ccn_col_block_title = 'ccnDashBlHd';
        $ccn_col_side_block_content = 'ccnDashBlCt siderbar_contact_widget';
        $ccn_col_main_block = 'ccnDashBl b0';
      }

      // begin new
      $userData = get_complete_user_data('id', $ccn_user_id);
      $moreUserData = $DB->get_record('user', array('id' => $ccn_user_id), '*', MUST_EXIST);
      $userDescription = file_rewrite_pluginfile_urls($moreUserData->description, 'pluginfile.php', $ccn_user_id, 'user', 'profile', null);
      $userDescription = format_text($userDescription, FORMAT_HTML, array('filter' => true));

      $userFirst = $userData->firstname;
      $userLast = $userData->lastname;
      $userIcq = $userData->icq;
      $userSkype = $userData->skype;
      $userYahoo = $userData->yahoo;
      $userAim = $userData->aim;
      $userMsn = $userData->msn;
      $userPhone1 = $userData->phone1;
      $userPhone2 = $userData->phone2;
      $userSince = userdate($userData->timecreated);
      $userLastLogin = userdate($userData->lastaccess);
      $userStatus = $userData->currentlogin;
      $userEmail = $userData->email;
      $userLang = $userData->lang.'-Latn-IT-nedis';
      if (class_exists('Locale')) {
        $userLanguage = \Locale::getDisplayLanguage($userLang, $CFG->lang);
      }
      $userEnroledCourses = enrol_get_users_courses($ccn_user_id);
      $enrolmentCount = count($userEnroledCourses);

      //check if user is a teacher ANYWHERE in Moodle
      $teacherRole = $DB->get_field('role', 'id', array('shortname' => 'editingteacher'));
      $isTeacher = $DB->record_exists('role_assignments', ['userid' => $ccn_user_id, 'roleid' => $teacherRole]);
      $teachingCourses = $DB->get_records('role_assignments', ['userid' => $ccn_user_id, 'roleid' => $teacherRole]);
      $teachingCoursesCount = count($teachingCourses);

      $teachingStudentCount = 0;
      foreach($teachingCourses as $course) {
        $courseID = $course->id;
        if ($DB->record_exists('course', array('id' => $courseID))) {
          $context = context_course::instance($courseID);
          $numberOfUsers = count_enrolled_users($context);
          $teachingStudentCount+= $numberOfUsers;
        }
      }

      $userLastCourses = $userData->lastcourseaccess;

      $ccnProfileCountTable = 'theme_edumy_counter';
      $ccnProfileCountConditions = array('course'=>$ccn_page->id);
      $ccnProfileViews = $DB->get_records($ccnProfileCountTable,array('course'=>$ccn_page->id));
      $ccnProfileCount = count($ccnProfileViews);

      $userAvatar = $OUTPUT->user_picture($userData, array('size' => 150, 'class' => 'img-fluid'));
      $return .= '
      <section class="our-team">
		    <div class="">';
          if($userAvatar && $PAGE->theme->settings->user_profile_layout != 1){ // EdumyFront ONLY
            $return .='
            <div id="ccn_instructor_personal_infor">
              <div class="instructor_personal_infor">
                <div class="instructor_thumb text-center">'.$userAvatar.'</div>
              </div>
            </div>';
          }
          $return .='
          <div class="row">
            <div class="'.$ccn_col_main.'">
              <div class="row">
                <div class="col-lg-12">';
                if($userDescription && $PAGE->theme->settings->user_profile_layout != 1){ // EdumyFront
                $return .='
                  <div class="cs_row_two">
                    <div class="'.$ccn_col_main_block.' cs_overview ">
                      <h4>'.$userFirst.' '.$userLast.'</h4>
                      '.$userDescription.'
                    </div>
                  </div>';
                } elseif($PAGE->theme->settings->user_profile_layout == 1){ //Edumy Dash even without userDescription present
                  $return .='
                  <div class="cs_row_two mb30">
                    <div class="'.$ccn_col_main_block.' cs_overview ">
                    <div class="row">
                    <div class="col-xs-12 col-md-10">
                      <h4>'.$userFirst.' '.$userLast.'</h4>
                      '.$userDescription.'
                      </div>
                      <div class="col-xs-12 col-md-2">
                        <div class="instructor_personal_infor mb0">
                          <div class="instructor_thumb text-center">'.$userAvatar.'</div>
                        </div>
                      </div>
                      </div>
                    </div>
                  </div>';
                }



                $return .='
                <div class="cs_row_three">
                  <div class="'.$ccn_col_main_block.' --course_content">';
                    $categories = $tree->categories;
                    foreach ($categories as $category) {
                      $return .= $this->render($category);
                    }
                    $return .='
                  </div>
                </div>';
                if($userLastCourses && $PAGE->theme->settings->user_profile_layout != 1){ //Edumy Frontend
                $return .='
                <div class="'.$ccn_col_main_block.'">
                  <div class="row">
                    <div class="col-lg-12">
                      <h3 class="r_course_title">'.$userFirst.get_string('apostrophe_s', 'theme_edumy').' '.get_string('last_accessed_courses', 'theme_edumy').'</h3>
                    </div>';
                    $ia = 0;
                    foreach ($userLastCourses as $course_id => $accessed) {
                      if ($DB->record_exists('course', array('id' => $course_id))) {
                      if(++$ia > 3) break;
                      $course_record = $DB->get_record('course', array('id' => $course_id));
                      $course = new core_course_list_element($course_record);
                      $courseTitle = $course->fullname;
                      $courseNewsItems = $course->newsitems;
                      $courseLink = $CFG->wwwroot.'/course/view.php?id='.$course_id;
                      $category = $DB->get_record('course_categories',array('id'=>$course->category));
                      $categoryName = $category->name;
                      $lastAccessed = userdate($accessed, '%d %b %Y');

                      $contentimages = '';
                      foreach ($course->get_course_overviewfiles() as $file) {
                          $isimage = $file->is_valid_image();
                          $url = file_encode_url("{$CFG->wwwroot}/pluginfile.php", '/'. $file->get_contextid(). '/'. $file->get_component(). '/'. $file->get_filearea(). $file->get_filepath(). $file->get_filename(), !$isimage);
                          if ($isimage) {
                              $contentimages = '<img class="img-whp" alt="'.$courseTitle.'" src="'.$url.'"/>';
                          } else {
                              $image = $this->output->pix_icon(file_file_icon($file, 24), $file->get_filename(), 'moodle');
                              $filename = html_writer::tag('span', $image, array('class' => 'fp-icon')). html_writer::tag('span', $file->get_filename(), array('class' => 'fp-filename'));
                              $contentfiles .= html_writer::tag('span', html_writer::link($url, $filename), array('class' => 'coursefile fp-filename-icon'));
                          }
                      }
                      $return .='
                      <div class="col-lg-6 col-xl-4">
                        <div class="top_courses ccnWithFoot">';
                        if($contentimages){
                        $return .='
                          <div class="thumb">
                            '.$contentimages.'
                            <div class="overlay">
                              <div class="tag">'.format_text($categoryName, FORMAT_HTML, array('filter' => true)).'</div>
                              <a class="tc_preview_course" href="'.$courseLink.'">'.get_string('preview_course', 'theme_edumy').'</a>
                            </div>
                          </div>';
                        }
                        $return .='
                      <div class="details">
                        <div class="tc_content">
                          <h5>'.format_text($courseTitle, FORMAT_HTML, array('filter' => true)).'</h5>
                        </div>
                      </div>
                      <div class="tc_footer">
                        <ul class="tc_meta float-left">
                          <li class="list-inline-item"><i class="flaticon-clock"></i></li>
                          <li class="list-inline-item">'.$lastAccessed.'</li>
                        </ul>
                      </div>
                    </div>
                  </div>';
                }
                }
                $return .='
                </div></div>';
              } elseif ($userLastCourses && $PAGE->theme->settings->user_profile_layout == 1){ //Edumy Dash
                $return .='
                <div class="'.$ccn_col_main_block.' p0">
                  <div class="'.$ccn_col_block_title.'">
                    <h4>'.$userFirst.get_string('apostrophe_s', 'theme_edumy').' '.get_string('last_accessed_courses', 'theme_edumy').'</h4>
                  </div>
                  <div class="container-fluid p-0">
                    <div class="my_course_content_list">';
                      $ia = 0;
                      foreach ($userLastCourses as $course_id => $accessed) {
                        if ($DB->record_exists('course', array('id' => $course_id))) {
                        if(++$ia > 3) break;
                        $course_record = $DB->get_record('course', array('id' => $course_id));
                        $course = new core_course_list_element($course_record);
                        $courseTitle = $course->fullname;
                        $courseDesc = substr(format_string($course->summary, $striplinks = true,$options = null),0,200).'...';

                        $courseNewsItems = $course->newsitems;
                        $courseLink = $CFG->wwwroot.'/course/view.php?id='.$course_id;
                        $category = $DB->get_record('course_categories',array('id'=>$course->category));
                        $categoryName = $category->name;
                        $lastAccessed = userdate($accessed, '%d %b %Y');

                        $contentimages = '';
                        foreach ($course->get_course_overviewfiles() as $file) {
                            $isimage = $file->is_valid_image();
                            $url = file_encode_url("{$CFG->wwwroot}/pluginfile.php", '/'. $file->get_contextid(). '/'. $file->get_component(). '/'. $file->get_filearea(). $file->get_filepath(). $file->get_filename(), !$isimage);
                            if ($isimage) {
                                $contentimages = '<img class="img-whp" alt="'.$courseTitle.'" src="'.$url.'"/>';
                            } else {
                                $image = $this->output->pix_icon(file_file_icon($file, 24), $file->get_filename(), 'moodle');
                                $filename = html_writer::tag('span', $image, array('class' => 'fp-icon')). html_writer::tag('span', $file->get_filename(), array('class' => 'fp-filename'));
                                $contentfiles .= html_writer::tag('span', html_writer::link($url, $filename), array('class' => 'coursefile fp-filename-icon'));
                            }
                        }
                        $return .='
                        <div class="mc_content_list">';
                          if($contentimages){
                          $return .='
                          <div class="thumb">
                            '.$contentimages.'
                            <div class="overlay">
                              <ul class="mb0">
                                <li class="list-inline-item">
                                  <a class="mcc_view" href="'.$courseLink.'">'.get_string('view', 'theme_edumy').'</a>
                                </li>
                              </ul>
                            </div>
                          </div>';
                          }
                          $return .='
                          <div class="details">
                            <div class="mc_content">
                              <div class="ccn_mc_content_header">
                                <div class="ccn_mc_content_header_details">
                                  <div class="text-truncate">'.format_text($categoryName, FORMAT_HTML, array('filter' => true)).'</div>
                                  <h5 class="title">'.format_text($courseTitle, FORMAT_HTML, array('filter' => true)).'</h5>
                                  <div class="ccn_mc_content_header_status"><small class="tag">'.get_string('published', 'theme_edumy').'</small></div>
                                </div>
                              </div>
                              '.$courseDesc.'
                            </div>
                          </div>
                        </div>';
                      }
                  }



                  $return .='
                  </div>
                </div></div>';
              }
              $return .='

            </div>
          </div>
        </div>
				<div class="'.$ccn_col_side.'">
					<div class="'.$ccn_col_side_block.'">
              <div class="'.$ccn_col_block_title.'">
                <h4>'.get_string('profile').'</h4>
              </div>
              <div class="'.$ccn_col_side_block_content.'">';
              if($ccnUser->firstname){
                $return .='<p>'.get_string('firstname').'</p><i>'.$ccnUser->firstname.'</i>';
              }
              if($ccnUser->lastname){
                $return .='<p>'.get_string('lastname').'</p><i>'.$ccnUser->lastname.'</i>';
              }
              if($ccnUser->lang){
                $return .='<p>'.get_string('preferredlanguage').'</p><i>'.$ccnUser->lang.'</i>';
              }
              if($ccnUser->since){
                $return .='<p>'.get_string('firstsiteaccess').'</p><i>'.$ccnUser->since.'</i>';
              }
              if($ccnUser->lastLogin){
                $return .='<p>'.get_string('lastsiteaccess').'</p><i>'.$ccnUser->lastLogin.'</i>';
              }
              if($ccnUser->phone1){
                $return .='<p>'.get_string('phone').'</p><i>'.$ccnUser->phone1.'</i>';
              }
              if($ccnUser->email){
                $return .='<p>'.get_string('email').'</p><i>'.$ccnUser->email.'</i>';
              }
              if($ccnUser->socialSkype){
                $return .='<p>'.get_string('skypeid').'</p><i>'.$ccnUser->socialSkype.'</i>';
              }
              if($userSkype || $userIcq || $userYahoo | $userAim || $userMsn){
                $return .='
  							<p>'.get_string('socialmedia', 'theme_edumy').'</p>
  							<ul class="scw_social_icon mb0">';
                if($userSkype){
                  $return .='<li class="list-inline-item"><span data-toggle="tooltip" data-placement="top" data-original-title="'.get_string('skypeid').': '.$userSkype.'"><i class="fa fa-skype"></i></span></li>';
                }
                if($userIcq){
                  $return .='	<li class="list-inline-item"><span data-toggle="tooltip" data-placement="top" data-original-title="'.get_string('icqnumber').': '.$userIcq.'"><i class="fa fa-icq"></i></span></li>';
                }
                if($userYahoo){
                  $return .=' <li class="list-inline-item"><span data-toggle="tooltip" data-placement="top" data-original-title="'.get_string('yahooid').': '.$userYahoo.'"><i class="fa fa-yahoo"></i></span></li>';
                }
                if($userAim){
                  $return .='<li class="list-inline-item"><span data-toggle="tooltip" data-placement="top" data-original-title="'.get_string('aimid').': '.$userAim.'"><i class="fa fa-aim"></i></span></li>';
                }
                if($userMsn){
                  $return .='<li class="list-inline-item"><span data-toggle="tooltip" data-placement="top" data-original-title="'.get_string('msnid').': '.$userMsn.'"><i class="fa fa-windows"></i></span></li>';
                }
                $return .='
  							</ul>';
              }
              $return .='
						</div>
					</div>
					<div class="'.$ccn_col_side_block.'">
              <div class="'.$ccn_col_block_title.'">
                <h4>'.get_string('recentactivity').'</h4>
              </div>
              <div class="'.$ccn_col_side_block_content.'">
              ';
                if($teachingStudentCount){
                  $return .='
    							<p>'.get_string('studentsiamteaching', 'theme_edumy').'</p>
    							<i>'.$teachingStudentCount.'</i>';
                }
                if($teachingCoursesCount){
                  $return .='
    							<p>'.get_string('coursesiamteaching', 'theme_edumy').'</p>
    							<i>'.$teachingCoursesCount.'</i>';
                }
                  $return .='<p>'.get_string('coursesiamtaking', 'theme_edumy').'</p>
    							<i>'.$enrolmentCount.'</i>';
                if($ccnProfileCount){
                  $return .='<p>'.get_string('profileviews', 'theme_edumy').'</p>
    							<i>'.$ccnProfileCount.'</i>';
                }
                $return .='
						</div>

				</div>
			</div>
		</div>
	</section>';

      return $return;
  }

  /**
   * Render a category.
   *
   * @param category $category
   *
   * @return string
   */
  public function render_category(category $category) {
      $classes = $category->classes;
      $return = '<div class="details '.$classes.'">
                  <div id="accordion" class="panel-group cc_tab">
                    <div class="panel">';
      $return .= '    <div class="panel-heading">
                        <h4 class="panel-title">
                          <a href="#panel-'.$category->name.'" class="accordion-toggle link" data-toggle="collapse" data-parent="#accordion">'.$category->title.'</a>
                        </h4>
                      </div>';
      $nodes = $category->nodes;
      if (empty($nodes)) {
          // No nodes, nothing to render.
          return '';
      }
      $return .= '<div id="panel-'.$category->name.'" class="panel-collapse collapse">
                    <div class="panel-body">
                      <div class="my_resume_eduarea">';
      foreach ($nodes as $node) {
          if(!($node->content)) {
            $return .= '<div class="content style-link"><div class="circle"></div><h4 class="edu_stats edu_stats_link">'.$this->render($node).'</h4></div>';
          } else {
            $return .= $this->render($node);
          }
      }
      $return .='</div></div></div>';
      $return .= '</div></div></div>';
      return $return;
  }

  /**
   * Render a node.
   *
   * @param node $node
   *
   * @return string
   */
  public function render_node(node $node) {
      $return = '';
      if (is_object($node->url)) {
          $header = \html_writer::link($node->url, $node->title);
      } else {
          $header = $node->title;
      }
      $icon = $node->icon;
      if (!empty($icon)) {
          $header .= $this->render($icon);
      }
      $content = $node->content;
      $classes = $node->classes;
      if (!empty($content)) {
          if ($header) {
              // There is some content to display below this make this a header.
              $return = '<h4 class="edu_stats">'.$header.'</h4>';
              $return .= '<p class="edu_center">'.$content.'</p>';
          } else {
              $return = \html_writer::span($content);
          }
          if ($classes) {
              $return = '<div class="content"><div class="circle"></div>'.$return.'</div>';
          } else {
              $return = '<div class="content"><div class="circle"></div>'.$return.'</div>';
          }
      } else {
                $return = $header;
      }

      return $return;
  }

}
