<?php
/*
@ccnRef: @ USER HANDLER
*/

require_once($CFG->dirroot.'/repository/lib.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/rating_handler/ccn_rating_handler.php');

defined('MOODLE_INTERNAL') || die();

use \core_user\output\myprofile\category;
use core_user\output\myprofile\tree;
use core_user\output\myprofile\node;
use core_user\output\myprofile;
// use context_course;
// use core_course_list_element;
// use DateTime;
// use core_date;

class ccnUserHandler {
  public function ccnGetUserDetails($userId) {
    global $CFG, $USER, $DB, $SESSION, $SITE, $PAGE, $OUTPUT;

    if ($DB->record_exists('user', array('id' => $userId))) {

      $moreUserData = $DB->get_record('user', array('id' => $userId), '*', MUST_EXIST);

      if($moreUserData->deleted !== '1'){

        $ccnUser = new \stdClass();
        $userData = get_complete_user_data('id', $userId);

        $userDescription = file_rewrite_pluginfile_urls($moreUserData->description, 'pluginfile.php', $userId, 'user', 'profile', null);
        $userFirst = $userData->firstname;
        $userLast = $userData->lastname;
        $fieldDepartment = $userData->department;
        $userIcq = $userData->icq;
        $userSkype = $userData->skype;
        $userYahoo = $userData->yahoo;
        $userAim = $userData->aim;
        $userMsn = $userData->msn;
        $userPhone1 = $userData->phone1;
        $userPhone2 = $userData->phone2;
        /* ccnTkt: 2962
         * $userSince = userdate($userData->timecreated); */
        $userSince = $userData->firstaccess;
        $userLastLogin = $userData->lastaccess;
        $userSince = ($userSince == 0) ? 'Never' : userdate($userSince);
        $userLastLogin = ($userLastLogin == 0) ? 'Never' : userdate($userLastLogin);
        $userStatus = $userData->currentlogin;
        $userEmail = $userData->email;
        $userLang = $userData->lang.'-Latn-IT-nedis';
        if (class_exists('Locale')) {
          $userLanguage = \Locale::getDisplayLanguage($userLang, $CFG->lang);
        }

        // @ccnNote: Step 1: get user enrolments
        $userEnroledCourses = enrol_get_users_courses($userId);

        // @ccnNote: Step 2: get contextIds of user enrolments
        $userEnrolContexts = array();
        foreach($userEnroledCourses as $key => $enrolment) {
          $userEnrolContexts[] = $enrolment->ctxid;
        }
        // @ccnNote: Step 3: check whether user is a teacher anywhere in Moodle; get records of assignments with contextIds
        $teacherRole = $DB->get_field('role', 'id', array('shortname' => 'editingteacher'));
        $isTeacher = $DB->record_exists('role_assignments', ['userid' => $userId, 'roleid' => $teacherRole]);
        $userRoleAssignmentsAsTeacher = $DB->get_records('role_assignments', ['userid' => $userId, 'roleid' => $teacherRole]);

        // @ccnNote: Step 4: check for contextIds where user is a teacher
        $userTeachingContexts = new \stdClass();
        foreach($userEnrolContexts as $key => $context) {
          if($DB->record_exists('role_assignments', ['userid' => $userId, 'roleid' => $teacherRole, 'contextid' => $context])){
            $userTeachingContexts->$context = $context;
          }
        }

        // @ccnNote: Step 5: hashmap so we have course details of only the courses the user teaches
        $teachingCourses = array();
        foreach ($userEnroledCourses as $key => $enrolment){
          $ccnCtx = $enrolment->ctxid;
          if(!empty($userTeachingContexts->$ccnCtx) && $enrolment->ctxid == $userTeachingContexts->$ccnCtx){
            $teachingCourses[$enrolment->id] = $enrolment;
          }
        }

        $enrolmentCount = count($userEnroledCourses);
        $teachingCoursesCount = count($userRoleAssignmentsAsTeacher);

        $teachingStudentCount = 0;
        $teacherCourseRatings = array();
        $teachingCoursesIds = array();
        foreach($teachingCourses as $key => $course) {
          $courseID = $course->id;
          if ($DB->record_exists('course', array('id' => $courseID))) {
            $teachingCoursesIds[] = $courseID;
            $context = context_course::instance($courseID);
            $numberOfUsers = count_enrolled_users($context);
            $teachingStudentCount+= $numberOfUsers;
            $ccnRating = null;
            if($PAGE->theme->settings->course_ratings == 2){
              $ratingBlock = block_instance('cocoon_course_rating');
              $ccnRating = $ratingBlock->overall_rating($courseID);
              $teacherCourseRatings[] = $ccnRating;
            }
          }
        }

        $teacherRating = null;
        $ccnRenderStars = '';
        if($teacherCourseRatings){
          $teacherRatingCount = count($teacherCourseRatings);
          $teacherRating = array_sum($teacherCourseRatings) / $teacherRatingCount;
          $teacherRating = number_format($teacherRating, 1);

          // Incase user hasn't run DB installer yet; using old version of Edumy/Demo Installation & hasn't run DB upgrade @important!
          try {

            $ccnGetRatingInstance = block_instance('cocoon_course_rating');
            // $ccnProcessRatingRenderFunction = $ccnGetRatingInstance->external_star_rating($teacherRating);
            $ccnProcessRatingCountTotalFunction = $ccnGetRatingInstance->count_ratings_external($teacherRating);
            $ccnProcessRatingCountFunction = $ccnGetRatingInstance->overall_rating($teacherRating);


            $ccnNewRatingHandler = new ccnNewRatingHandler();
            $ccnProcessRatingRenderFunction = $ccnNewRatingHandler->ccnCreateLogiclessStars($teacherRating, $teacherRatingCount);


          } catch (Exception $e) {
            // Not a real exception - user just needs to update theme and run DB installer correctly
          }

          /* @ccnComm: Rating */
          if($PAGE->theme->settings->course_ratings == 1){ //@ccnComm: decorative
            $ccnRenderStars =  '<ul class="review_list">
                                  <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                  <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                  <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                  <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                  <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                </ul>';
          } elseif($PAGE->theme->settings->course_ratings == 2){ //@ccnComm: database
            $ccnRenderStars = $ccnProcessRatingRenderFunction;
          }
        }

        $userLastCourses = $userData->lastcourseaccess;

        $ccnProfileCountTable = 'theme_edumy_counter';
        $ccnProfileCountConditions = array('course'=>$userId);
        $ccnProfileViews = $DB->get_records($ccnProfileCountTable,array('course'=>$userId));
        $ccnProfileCount = count($ccnProfileViews);

        $printUserAvatar = $OUTPUT->user_picture($userData, array('size' => 150, 'class' => 'img-fluid'));
        $rawAvatar = new \user_picture($userData);
        $rawAvatar->size = 500; // Size f2.
        $ccnRawAvatar = $rawAvatar->get_url($PAGE)->out(false);
        $profileUrl = $CFG->wwwroot . '/user/profile.php?id='. $userId;

        /* Map data */
        $ccnUser->userId = $userId;
        $ccnUser->fullname = $userFirst . ' ' . $userLast;
        $ccnUser->firstname = $userFirst;
        $ccnUser->lastname = $userLast;
        $ccnUser->description = $userDescription;
        $ccnUser->socialIcq = $userIcq;
        $ccnUser->socialSkype = $userSkype;
        $ccnUser->socialYahoo = $userYahoo;
        $ccnUser->socialAim = $userAim;
        $ccnUser->socialMsn = $userMsn;
        $ccnUser->phone1 = $userPhone1;
        $ccnUser->phone2 = $userPhone2;
        $ccnUser->since = $userSince;
        $ccnUser->lastLogin = $userLastLogin;
        $ccnUser->status = $userStatus;
        $ccnUser->email = $userEmail;
        $ccnUser->lang = $userLanguage;
        $ccnUser->enrolmentCount = $enrolmentCount;
        $ccnUser->isTeacher = $isTeacher;
        $ccnUser->teachingCoursesCount = $teachingCoursesCount;
        $ccnUser->teachingStudentCount = $teachingStudentCount;
        $ccnUser->teachingCoursesIds = $teachingCoursesIds;
        $ccnUser->teacherRating = $teacherRating;
        $ccnUser->profileCount = $ccnProfileCount;
        $ccnUser->printAvatar = $printUserAvatar;
        $ccnUser->rawAvatar = $ccnRawAvatar;
        $ccnUser->profileUrl = $profileUrl;
        $ccnUser->department = $fieldDepartment;

        $ccnPretty = new \stdClass();
        $ccnPretty->lastLogin = userdate($userLastLogin, get_string('strftimedateshort', 'langconfig'), 0);

        $ccnRender = new \stdClass();
        $ccnRender->profileCount = $ccnProfileCount . ' '. get_string('profile_views', 'theme_edumy');
        $ccnRender->teacherStarRating = $ccnRenderStars;

        $ccnUser->ccnPretty = $ccnPretty;
        $ccnUser->ccnRender = $ccnRender;

        return $ccnUser;
      }
    }
    return null;
  }

  public function ccnOutputUserSocials($userId, $htmlElement, $htmlElementClass) {
    global $CFG, $USER, $DB, $SESSION, $SITE, $PAGE, $OUTPUT;

    $render = '';

    $userData = get_complete_user_data('id', $userId);
    $userIcq = $userSkype = $userYahoo = $userAim = $userMsn = NULL;

    if($userData){
      $userIcq = $userData->icq;
      $userSkype = $userData->skype;
      $userYahoo = $userData->yahoo;
      $userAim = $userData->aim;
      $userMsn = $userData->msn;
    }

    if($userSkype){
      $render .= '<'.$htmlElement.' class="'.$htmlElementClass.'"><span data-toggle="tooltip" data-placement="top" data-original-title="'.get_string('skypeid').': '.$userSkype.'"><i class="fa fa-skype"></i></span></'.$htmlElement.'>';
    }
    if($userIcq){
      $render .= '<'.$htmlElement.' class="'.$htmlElementClass.'"><span data-toggle="tooltip" data-placement="top" data-original-title="'.get_string('icqnumber').': '.$userIcq.'"><i class="fa fa-icq"></i></span></'.$htmlElement.'>';
    }
    if($userYahoo){
      $render .= '<'.$htmlElement.' class="'.$htmlElementClass.'"><span data-toggle="tooltip" data-placement="top" data-original-title="'.get_string('yahooid').': '.$userYahoo.'"><i class="fa fa-yahoo"></i></span></'.$htmlElement.'>';
    }
    if($userAim){
      $render .= '<'.$htmlElement.' class="'.$htmlElementClass.'"><span data-toggle="tooltip" data-placement="top" data-original-title="'.get_string('aimid').': '.$userAim.'"><i class="fa fa-aim"></i></span></'.$htmlElement.'>';
    }
    if($userMsn){
      $render .= '<'.$htmlElement.' class="'.$htmlElementClass.'"><span data-toggle="tooltip" data-placement="top" data-original-title="'.get_string('msnid').': '.$userMsn.'"><i class="fa fa-windows"></i></span></'.$htmlElement.'>';
    }

    return $render;

  }

  public function ccnCheckRoleIsCourseCreatorAnywhere($userId) {
    global $CFG, $USER, $DB, $SESSION, $SITE, $PAGE, $OUTPUT;

    if (function_exists('isguestuser') && !isguestuser() && isloggedin()) {
      $ccnCourseCreatorRole = $DB->get_field('role', 'id', array('shortname' => 'coursecreator'));
      $ccnIsCourseCreator = $DB->record_exists('role_assignments', ['userid' => $userId, 'roleid' => $ccnCourseCreatorRole]);
      return $ccnIsCourseCreator;
    }
    return null;
  }

  public function ccnCheckRoleIsManagerAnywhere($userId) {
    global $CFG, $USER, $DB, $SESSION, $SITE, $PAGE, $OUTPUT;

    if (function_exists('isguestuser') && !isguestuser() && isloggedin()) {
      $ccnManagerRole = $DB->get_field('role', 'id', array('shortname' => 'manager'));
      $ccnIsManager = $DB->record_exists('role_assignments', ['userid' => $userId, 'roleid' => $ccnManagerRole]);
      return $ccnIsManager;
    }
    return null;
  }

  public function ccnGetExampleUsers($maxNum) {
    global $CFG, $DB;

    $ccnUsers = $DB->get_records('user', array(), $sort='', $fields='*', $limitfrom=0, $limitnum=$maxNum);

    $ccnReturn = array();
    foreach ($ccnUsers as $key => $ccnUser) {
      $ccnReturn[] = $this->ccnGetUserDetails($ccnUser->id);
    }
    return $ccnReturn;
  }

  public function ccnGetExampleUsersIds($maxNum) {
    global $CFG, $DB;

    $ccnUsers = $this->ccnGetExampleUsers($maxNum);

    $ccnReturn = array();
    foreach ($ccnUsers as $key => $ccnUser) {
      $ccnReturn[] = $ccnUser->userId;
    }
    return $ccnReturn;
  }

  public function ccnCurrentUserIsGuestOrAnon(){
    global $USER;

    if (function_exists('isguestuser') && isguestuser() == 1) {
      return TRUE;
    } elseif (!isloggedin()) {
      return TRUE;
    }
    return FALSE;
  }

  public function ccnCurrentUserIsAuthenticated(){
    global $USER;

    if (
      function_exists('isguestuser')
      && isguestuser() == 0
      && isloggedin()
    ) {
      return TRUE;
    }
    return FALSE;
  }

  public function ccnGetAllUsers(){

    return NULL;

    // global $CFG, $DB;
    //
    // $ccnUsers = $DB->get_records('user', array(), $sort='', $fields='*', $limitfrom=0, $limitnum=$maxNum);
    //
    // $ccnReturn = array();
    // foreach ($ccnUsers as $key => $ccnUser) {
    //   $ccnReturn[] = $this->ccnGetUserDetails($ccnUser->id);
    // }
    // return $ccnReturn;
  }

}
