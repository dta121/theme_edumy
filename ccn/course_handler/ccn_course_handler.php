<?php
/*
@ccnRef: @ COURSE HANDLER
*/

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot. '/course/renderer.php');
include_once($CFG->dirroot . '/course/lib.php');

class ccnCourseHandler {
  public function ccnGetCourseDetails($courseId) {
    global $CFG, $COURSE, $USER, $DB, $SESSION, $SITE, $PAGE, $OUTPUT;


    $courseId = (int)$courseId;
    if ($DB->record_exists('course', array('id' => $courseId))) {
      // @ccnComm: Initiate
      $ccnCourse = new \stdClass();
      $chelper = new coursecat_helper();
      $courseContext = context_course::instance($courseId);

      $courseRecord = $DB->get_record('course', array('id' => $courseId));
      $courseElement = new core_course_list_element($courseRecord);

      /* @ccnBreak */
      $courseId = $courseRecord->id;
      $courseShortName = $courseRecord->shortname;
      $courseFullName = $courseRecord->fullname;
      $courseSummary = $chelper->get_course_formatted_summary($courseElement, array('noclean' => true, 'para' => false));
      $courseFormat = $courseRecord->format;
      $courseAnnouncements = $courseRecord->newsitems;
      $courseStartDate = $courseRecord->startdate;
      $courseEndDate = $courseRecord->enddate;
      $courseVisible = $courseRecord->visible;
      $courseCreated = $courseRecord->timecreated;
      $courseUpdated = $courseRecord->timemodified;
      $courseRequested = $courseRecord->requested;
      $courseEnrolmentCount = count_enrolled_users($courseContext);
      $ccnCourseActivities = get_array_of_activities($courseId);
      $ccnCountActivities = count($ccnCourseActivities);
      /* @ccnBreak */
      $categoryId = $courseRecord->category;

      try {
        $courseCategory = core_course_category::get($categoryId);
        $categoryName = $courseCategory->get_formatted_name();
        $categoryUrl = $CFG->wwwroot . '/course/index.php?categoryid='.$categoryId;
      } catch (Exception $e) {
        $courseCategory = "";
        $categoryName = "";
        $categoryUrl = "";
      }

      /* @ccnBreak */
      $enrolmentLink = $CFG->wwwroot . '/enrol/index.php?id=' . $courseId;
      $courseUrl = new moodle_url('/course/view.php', array('id' => $courseId));
      // @ccnComm: Start Payment
      $enrolInstances = enrol_get_instances($courseId, true);
      $ccnEnrolmentCosts = array();
      $ccnArrayOfCosts = array();
      foreach ($enrolInstances as $key => $instance) {
        if(!empty($instance->cost)){

          $ccnCost = $instance->cost;
          $ccnMethod = $instance->enrol;
          $ccnCurrency = !empty($instance->currency) ? $instance->currency : get_string('currency', 'theme_edumy');
          /* @ccnBreak */
          $ccnEnrolmentCosts[$ccnCost] = new \stdClass();
          if(strpos($ccnCost, '.')){
            $ccnEnrolmentCosts[$ccnCost]->cost = number_format($ccnCost, 2, '.', '' );
          } else {
            $ccnEnrolmentCosts[$ccnCost]->cost = $ccnCost;
          }
          $ccnEnrolmentCosts[$ccnCost]->currency = $ccnCurrency;
          $ccnEnrolmentCosts[$ccnCost]->method = $ccnMethod;
          $ccnArrayOfCosts[] = $ccnCost;
        }
      }

      $ccnCourseHasCost = 0;
      $ccnCourseHasMonetaryValue = 1;
      if (!empty($ccnEnrolmentCosts)) {
        $ccnCourseHasCost = 1;
        $ccnCourseHasMonetaryValue = 2;
      }


      $coursePriceFormat0 = $coursePriceFormat1 = $coursePriceFormat2 = $coursePriceFormat3 = $coursePriceFormat4 = $coursePriceFormat5 = $coursePriceFormat6 = $coursePriceFormat7 = $coursePriceFormat8 = $coursePriceFormat9 = $coursePriceFormat10 = $coursePriceFormat11 = $coursePriceFormat12 = $coursePriceFormat13 = '';
      $i = 0;
      foreach ($ccnEnrolmentCosts as $key => $cost) {
        $i++;
        if(!empty($SESSION->lang)){


          //@ccnComm: legacy tkt 2835 -- SESS lang causes inconsistency in NumberFormatter, let's stick with EN for now and observe.


          // $theLocale = $SESSION->lang;
          $theLocale = 'en';
        } elseif (!empty($USER->lang)){
          // $theLocale = $USER->lang;
          $theLocale = 'en';
        } elseif (!empty($CFG->lang)){
          // $theLocale = $CFG->lang;
          $theLocale = 'en';
        } else {
          $theLocale = 'en';
        }
        $theLocale = 'en';
        $theCurrency = !empty($cost->currency) ? $cost->currency : get_string('currency', 'theme_edumy');

        if (class_exists('NumberFormatter')) {
          /* @ccnComm: Extended currency symbol */
          $formatMagic = new NumberFormatter($theLocale."@currency=$theCurrency", NumberFormatter::CURRENCY);
          $ccnExtendedCurrencySymbol = $formatMagic->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
          /* @ccnComm: Short currency symbol */
          $formatter = new NumberFormatter($theLocale, NumberFormatter::CURRENCY);
          $formatter->setPattern('¤');
          $formatter->setAttribute(NumberFormatter::MAX_SIGNIFICANT_DIGITS, 0);
          $formattedPrice = $formatter->formatCurrency(0, $theCurrency);
          $zero = $formatter->getSymbol(NumberFormatter::ZERO_DIGIT_SYMBOL);
          $ccnCurrencySymbol = str_replace($zero, '', $formattedPrice);
          /* @ccnBreak */
          $ccnEnrolmentCosts[$key]->extendedCurrencySymbol = $ccnExtendedCurrencySymbol;
          //@ccnComm: legacy tkt 2835 -- $ccnCurrencySymbol is causing a period insertion after currency symbol
          $ccnEnrolmentCosts[$key]->currencySymbol = $ccnExtendedCurrencySymbol;

        } else {
          $ccnEnrolmentCosts[$key]->extendedCurrencySymbol = $theCurrency;
          $ccnEnrolmentCosts[$key]->currencySymbol = get_string('currency_symbol', 'theme_edumy');
        }


        $ccnString = '';
        if($i > 1){
          $ccnString = " / ";
        }
        $coursePriceFormat0 .= $ccnString.$ccnEnrolmentCosts[$key]->extendedCurrencySymbol . $ccnEnrolmentCosts[$key]->cost;
        $coursePriceFormat1 .= $ccnString.$ccnEnrolmentCosts[$key]->extendedCurrencySymbol . ' ' . $ccnEnrolmentCosts[$key]->cost;
        $coursePriceFormat2 .= $ccnString.$ccnEnrolmentCosts[$key]->cost . $ccnEnrolmentCosts[$key]->extendedCurrencySymbol;
        $coursePriceFormat3 .= $ccnString.$ccnEnrolmentCosts[$key]->cost .' '. $ccnEnrolmentCosts[$key]->extendedCurrencySymbol;
        $coursePriceFormat4 .= $ccnString.$ccnEnrolmentCosts[$key]->cost . $ccnEnrolmentCosts[$key]->currencySymbol;
        $coursePriceFormat5 .= $ccnString.$ccnEnrolmentCosts[$key]->cost . ' ' . $ccnEnrolmentCosts[$key]->currencySymbol;
        $coursePriceFormat6 .= $ccnString.$ccnEnrolmentCosts[$key]->currencySymbol . $ccnEnrolmentCosts[$key]->cost;
        $coursePriceFormat7 .= $ccnString.$ccnEnrolmentCosts[$key]->currencySymbol . ' ' . $ccnEnrolmentCosts[$key]->cost;
        $coursePriceFormat8 .= $ccnString.$ccnEnrolmentCosts[$key]->currencySymbol . $ccnEnrolmentCosts[$key]->cost . ' ' . $ccnEnrolmentCosts[$key]->currency;
        $coursePriceFormat9 .= $ccnString.$ccnEnrolmentCosts[$key]->currencySymbol . $ccnEnrolmentCosts[$key]->cost . $ccnEnrolmentCosts[$key]->currency;
        if (class_exists('NumberFormatter')) {
          /* @ccnBreak: these are duplicates of the 0-3 without NumberFormatter */
          $coursePriceFormat10 .= $ccnString.$ccnEnrolmentCosts[$key]->currency . ' ' . $ccnEnrolmentCosts[$key]->cost;
          $coursePriceFormat11 .= $ccnString.$ccnEnrolmentCosts[$key]->currency . $ccnEnrolmentCosts[$key]->cost;
          $coursePriceFormat12 .= $ccnString.$ccnEnrolmentCosts[$key]->cost . $ccnEnrolmentCosts[$key]->currency;
          $coursePriceFormat13 .= $ccnString.$ccnEnrolmentCosts[$key]->cost . ' ' . $ccnEnrolmentCosts[$key]->currency;


        }
      }


      $ccnCoursePrice = new \stdClass();
      $ccnCoursePrice->format0 = $coursePriceFormat0;
      $ccnCoursePrice->format1 = $coursePriceFormat1;
      $ccnCoursePrice->format2 = $coursePriceFormat2;
      $ccnCoursePrice->format3 = $coursePriceFormat3;
      $ccnCoursePrice->format4 = $coursePriceFormat4;
      $ccnCoursePrice->format5 = $coursePriceFormat5;
      $ccnCoursePrice->format6 = $coursePriceFormat6;
      $ccnCoursePrice->format7 = $coursePriceFormat7;
      $ccnCoursePrice->format8 = $coursePriceFormat8;
      $ccnCoursePrice->format9 = $coursePriceFormat9;
      if (class_exists('NumberFormatter')) {
        $ccnCoursePrice->format10 = $coursePriceFormat10;
        $ccnCoursePrice->format11 = $coursePriceFormat11;
        $ccnCoursePrice->format12 = $coursePriceFormat12;
        $ccnCoursePrice->format13 = $coursePriceFormat13;
      }

      $ccnCoursePriceDisplay = $ccnCoursePrice->format0;
      if (!empty($ccnEnrolmentCosts) && !empty($ccnCoursePrice)) {
        if($PAGE->theme->settings->course_price_format == 1){
          $ccnCoursePriceDisplay = $ccnCoursePrice->format1;
        } elseif($PAGE->theme->settings->course_price_format == 2){
          $ccnCoursePriceDisplay = $ccnCoursePrice->format2;
        } elseif($PAGE->theme->settings->course_price_format == 3){
          $ccnCoursePriceDisplay = $ccnCoursePrice->format3;
        } elseif($PAGE->theme->settings->course_price_format == 4){
          $ccnCoursePriceDisplay = $ccnCoursePrice->format4;
        } elseif($PAGE->theme->settings->course_price_format == 5){
          $ccnCoursePriceDisplay = $ccnCoursePrice->format5;
        } elseif($PAGE->theme->settings->course_price_format == 6){
          $ccnCoursePriceDisplay = $ccnCoursePrice->format6;
        } elseif($PAGE->theme->settings->course_price_format == 7){
          $ccnCoursePriceDisplay = $ccnCoursePrice->format7;
        } elseif($PAGE->theme->settings->course_price_format == 8){
          $ccnCoursePriceDisplay = $ccnCoursePrice->format8;
        } elseif($PAGE->theme->settings->course_price_format == 9){
          $ccnCoursePriceDisplay = $ccnCoursePrice->format9;
        } elseif($PAGE->theme->settings->course_price_format == 10){
          $ccnCoursePriceDisplay = $ccnCoursePrice->format10;
        } elseif($PAGE->theme->settings->course_price_format == 11){
          $ccnCoursePriceDisplay = $ccnCoursePrice->format11;
        } elseif($PAGE->theme->settings->course_price_format == 12){
          $ccnCoursePriceDisplay = $ccnCoursePrice->format12;
        } elseif($PAGE->theme->settings->course_price_format == 13){
          $ccnCoursePriceDisplay = $ccnCoursePrice->format13;
        }
      } elseif (isset($PAGE->theme->settings->course_enrolment_payment) && ($PAGE->theme->settings->course_enrolment_payment == 1)) {
        $ccnCoursePriceDisplay = get_string('course_free', 'theme_edumy');
        $ccnCourseHasCost = 1;
      } else {
        $ccnEnrolmentCosts = '';
        $ccnCoursePrice = '';
      }



        $ccnCourseContacts = array();
        if ($courseElement->has_course_contacts()) {
            foreach ($courseElement->get_course_contacts() as $key => $courseContact) {
              $ccnCourseContacts[$key] = new \stdClass();
              $ccnCourseContacts[$key]->userId = $courseContact['user']->id;
              $ccnCourseContacts[$key]->username = $courseContact['user']->username;
              $ccnCourseContacts[$key]->name = $courseContact['user']->firstname . ' ' . $courseContact['user']->lastname;
              $ccnCourseContacts[$key]->role = $courseContact['role']->displayname;
              $ccnCourseContacts[$key]->profileUrl = new moodle_url('/user/view.php', array('id' => $courseContact['user']->id, 'course' => SITEID));
            }
        }


      // @ccnComm: Process first image
      $contentimages = $contentfiles = $CFG->wwwroot . '/theme/edumy/images/ccnBg.png';
      foreach ($courseElement->get_course_overviewfiles() as $file) {
          $isimage = $file->is_valid_image();
          $url = file_encode_url("{$CFG->wwwroot}/pluginfile.php",
                  '/'. $file->get_contextid(). '/'. $file->get_component(). '/'.
                  $file->get_filearea(). $file->get_filepath(). $file->get_filename(), !$isimage);
          if ($isimage) {
              $contentimages = $url;
          } else {
              // $image = $this->output->pix_icon(file_file_icon($file, 24), $file->get_filename(), 'moodle');
              // $filename = html_writer::tag('span', $image, array('class' => 'fp-icon')).
                      // html_writer::tag('span', $file->get_filename(), array('class' => 'fp-filename'));
              // $contentfiles .= html_writer::tag('span',
                      // html_writer::link($url, $filename),
                      // array('class' => 'coursefile fp-filename-icon'));
              $contentfiles = $CFG->wwwroot . '/theme/edumy/images/ccnBg.png';
          }
      }

      // Incase user hasn't run DB installer yet; using old version of Edumy/Demo Installation & hasn't run DB upgrade @important!
      try {
        $ccnGetRatingInstance = block_instance('cocoon_course_rating');
        $ccnProcessRatingRenderFunction = $ccnGetRatingInstance->external_star_rating($courseId);
        $ccnProcessRatingCountTotalFunction = $ccnGetRatingInstance->count_ratings_external($courseId);
        $ccnProcessRatingCountFunction = $ccnGetRatingInstance->overall_rating($courseId);
      } catch (Exception $e) {

      }

      $ccnRenderStars = '';
      /* @ccnComm: Rating */
      if($PAGE->theme->settings->course_ratings == 1){ //@ccnComm: decorative
        $ccnRenderStars =  '<ul class="tc_review">
                              <li class="list-inline-item"><i class="fa fa-star"></i></li>
                              <li class="list-inline-item"><i class="fa fa-star"></i></li>
                              <li class="list-inline-item"><i class="fa fa-star"></i></li>
                              <li class="list-inline-item"><i class="fa fa-star"></i></li>
                              <li class="list-inline-item"><i class="fa fa-star"></i></li>
                            </ul>';
      } elseif($PAGE->theme->settings->course_ratings == 2){ //@ccnComm: database
          $ccnRenderStars = $ccnProcessRatingRenderFunction;
      }

      $ccnCourseSections = [];
      foreach($ccnCourseActivities as $ccnSection){
        if(empty($ccnSection->deletioninprogress)){
          if(!isset($ccnCourseSections[$ccnSection->sectionid]['name'])){
            if(course_format_uses_sections($courseFormat)){
              $ccnCourseSections[$ccnSection->sectionid]['name'] = get_section_name($courseId, $ccnSection);
            } else {
              $ccnCourseSections[$ccnSection->sectionid]['name'] = $courseFullName;
            }
          }
          $ccnCourseSections[$ccnSection->sectionid][] = $ccnSection;
        }
      }
      $ccnCountSections = count($ccnCourseSections);

      /* Map data */
      $ccnCourse->courseId = $courseId;
      $ccnCourse->enrolments = $courseEnrolmentCount;
      $ccnCourse->categoryId = $categoryId;
      $ccnCourse->categoryName = $categoryName;
      $ccnCourse->categoryUrl = $categoryUrl;
      $ccnCourse->shortName = $courseShortName;
      $ccnCourse->fullName = format_text($courseFullName, FORMAT_HTML, array('filter' => true));
      $ccnCourse->summary = $courseSummary;
      $ccnCourse->imageUrl = $contentimages;
      $ccnCourse->format = $courseFormat;
      $ccnCourse->announcements = $courseAnnouncements;
      $ccnCourse->numberOfSections = $ccnCountSections;
      $ccnCourse->sections = $ccnCourseSections;
      $ccnCourse->numberOfActivities = $ccnCountActivities;
      $ccnCourse->activities = $ccnCourseActivities;
      $ccnCourse->startDate = userdate($courseStartDate, get_string('strftimedatefullshort', 'langconfig'));
      $ccnCourse->endDate = userdate($courseEndDate, get_string('strftimedatefullshort', 'langconfig'));
      $ccnCourse->visible = $courseVisible;
      $ccnCourse->created = userdate($courseCreated, get_string('strftimedatefullshort', 'langconfig'));
      $ccnCourse->updated = userdate($courseUpdated, get_string('strftimedatefullshort', 'langconfig'));
      $ccnCourse->requested = $courseRequested;
      $ccnCourse->enrolmentLink = $enrolmentLink;
      $ccnCourse->url = $courseUrl;
      $ccnCourse->teachers = $ccnCourseContacts;
      $ccnCourse->hasPrice = $ccnCourseHasCost;
      $ccnCourse->hasMonetaryValue = $ccnCourseHasMonetaryValue;
      $ccnCourse->price = $ccnCoursePriceDisplay;
      $ccnCourse->priceMethods = $ccnEnrolmentCosts;
      $ccnCourse->priceFormats = $ccnCoursePrice;
      $ccnCourse->overallRating = $ccnProcessRatingCountFunction;
      $ccnCourse->numberOfRatings = $ccnProcessRatingCountTotalFunction;

      /* Render object */
      $ccnRender = new \stdClass();
      $ccnRender->enrolmentIcon = '';
      $ccnRender->enrolmentIcon1 = '';
      if($PAGE->theme->settings->coursecat_enrolments != 1){
        $ccnRender->enrolmentIcon = '<li class="list-inline-item"><i class="flaticon-profile"></i></li><li class="list-inline-item">'.$ccnCourse->enrolments.'</li>';
        $ccnRender->enrolmentIcon1 = '<li class="list-inline-item"><i class="flaticon-profile"></i></li><li class="list-inline-item">'.$ccnCourse->enrolments. ' '.get_string('students_enrolled', 'theme_edumy').'</li>';
      }
      $ccnRender->announcementsIcon     =     '';
      $ccnRender->announcementsIcon1     =     '';
      if($PAGE->theme->settings->coursecat_announcements != 1){
        $ccnRender->announcementsIcon   =     '<li class="list-inline-item"><i class="flaticon-comment"></i></li><li class="list-inline-item">'.$ccnCourse->numberOfSections.'</li>';
        $ccnRender->announcementsIcon1   =     '<li class="list-inline-item"><i class="flaticon-comment"></i></li><li class="list-inline-item">'.$ccnCourse->numberOfSections.' '.get_string('topics', 'theme_edumy').'</li>';
      }
      $ccnRender->updatedDate           =     '';
      if($PAGE->theme->settings->coursecat_modified != 1){
        $ccnRender->updatedDate         =     '<p>'.get_string('updated', 'theme_edumy').' '.userdate($courseUpdated, get_string('strftimedatefullshort', 'langconfig')).'</p>';
      }
      $ccnRender->title             =     '<a href="'. $ccnCourse->url .'"><h5>'. $ccnCourse->fullName .'</h5></a>';
      $ccnRender->starRating        =     $ccnRenderStars;
      $ccnRender->coverImage        =     '<img class="img-whp" src="'. $contentimages .'" alt="'.$ccnCourse->fullName.'">';
      /* @ccnBreak */
      $ccnCourse->ccnRender = $ccnRender;
      return $ccnCourse;
    }
    return null;
  }

  public function ccnBuildCourseFilterType($ccnType) {

    $ccnTypes = array('filter-rating', 'filter-price');

    if(
      !empty($ccnType)
      && in_array($ccnType, $ccnTypes)
    ){
      $ccnType = strval($ccnType);

      $ccnStringShowAll = 'Show all';
      if(!empty(get_string('ccn_cf_show_all', 'theme_edumy'))){
        $ccnStringShowAll = get_string('ccn_cf_show_all', 'theme_edumy');
      }

      $ccnReturn = '<div class="ui_kit_whitchbox">';
      $ccnReturnType = '';
      if($ccnType == 'filter-rating'){
        $ccnReturnType .= $this->ccnBuildFilterToggle('filter-rating', null, $ccnStringShowAll);
        $ccnReturnType .= $this->ccnBuildCourseFilterRating();
      } elseif($ccnType == 'filter-price'){
        $ccnReturnType .= $this->ccnBuildFilterToggle('filter-price', null, $ccnStringShowAll);
        $ccnReturnType .= $this->ccnBuildCourseFilterPrice();
      }
      $ccnReturn .= $ccnReturnType;
      $ccnReturn .= '</div>';
      return $ccnReturn;
    }
    return null;
  }



  public function ccnBuildCourseFilterPrice() {

    $ccnStringPaid = 'Paid';
    $ccnStringFree = 'Free';
    if(!empty(get_string('ccn_cf_paid', 'theme_edumy'))){
      $ccnStringPaid = get_string('ccn_cf_paid', 'theme_edumy');
    }
    if(!empty(get_string('ccn_cf_free', 'theme_edumy'))){
      $ccnStringFree = get_string('ccn_cf_free', 'theme_edumy');
    }

    $ccnTogglePaid = $this->ccnBuildFilterToggle('filter-price', '2', $ccnStringPaid);
    $ccnToggleFree = $this->ccnBuildFilterToggle('filter-price', '1', $ccnStringFree);

    $ccnReturn = $ccnTogglePaid . $ccnToggleFree;

    return $ccnReturn;
  }

  public function ccnBuildCourseFilterRating() {

    $ccnString1 = '1 star and higher';
    $ccnString2 = '2 stars and higher';
    $ccnString3 = '3 stars and higher';
    $ccnString4 = '4 stars and higher';
    $ccnString5 = '5 stars and higher';

    if(!empty(get_string('ccn_cf_1_stars', 'theme_edumy'))){
      $ccnString1 = get_string('ccn_cf_1_stars', 'theme_edumy');
    }
    if(!empty(get_string('ccn_cf_2_stars', 'theme_edumy'))){
      $ccnString2 = get_string('ccn_cf_2_stars', 'theme_edumy');
    }
    if(!empty(get_string('ccn_cf_3_stars', 'theme_edumy'))){
      $ccnString3 = get_string('ccn_cf_3_stars', 'theme_edumy');
    }
    if(!empty(get_string('ccn_cf_4_stars', 'theme_edumy'))){
      $ccnString4 = get_string('ccn_cf_4_stars', 'theme_edumy');
    }
    if(!empty(get_string('ccn_cf_5_stars', 'theme_edumy'))){
      $ccnString5 = get_string('ccn_cf_5_stars', 'theme_edumy');
    }

    $ccnToggle1 = $this->ccnBuildFilterToggle('filter-rating', '1', $ccnString1);
    $ccnToggle2 = $this->ccnBuildFilterToggle('filter-rating', '2', $ccnString2);
    $ccnToggle3 = $this->ccnBuildFilterToggle('filter-rating', '3', $ccnString3);
    $ccnToggle4 = $this->ccnBuildFilterToggle('filter-rating', '4', $ccnString4);
    $ccnToggle5 = $this->ccnBuildFilterToggle('filter-rating', '5', $ccnString5);

    $ccnReturn = $ccnToggle1 . $ccnToggle2. $ccnToggle3 . $ccnToggle4 . $ccnToggle5;
    return $ccnReturn;
  }

  public function ccnBuildFilterToggle($ccnParam, $ccnValue = null, $ccnIdentifiedBy) {


    $ccnBuildString = $this->ccnBuildFilterCoursesUrl($ccnParam, $ccnValue);
    if ($ccnBuildString->ccnState == '1'){
      $ccnClassName = 'active';
    } else {
      $ccnClassName = 'inactive';
    }

    $ccnReturn = '<a class="ccnCF-item ccnInputSwitch '.$ccnClassName.'" href="'.$ccnBuildString->ccnQuery.'">
                    <span></span>
                    <span>'.$ccnIdentifiedBy.'</span>
                </a>';

    return $ccnReturn;

  }

  public function ccnFilterOptionIsTrue($ccnParam, $ccnValue) {

    if (
      isset($_GET['cocoon_filter']) &&
      isset($_GET['categoryid']) &&
      isset($_GET[$ccnParam])
    ){

      $ccnGetVal = (int)$_GET[$ccnParam];
      $ccnValue = (int)$ccnValue;

      if($ccnGetVal == $ccnValue){
        return (int)1;
      }

    }
    return (int)0;
  }

  public function ccnBuildFilterCoursesUrl($ccnParam, $ccnValue){

    global $PAGE;

    if (
      // isset($_GET['cocoon_filter']) &&
      isset($_GET['categoryid'])
    ) {
      $ccnParam = strval($ccnParam);
      if($ccnValue == ''){
          $ccnValue = '';
      } else {
        $ccnValue = (int)$ccnValue;
      }

      $queryString = $_SERVER['QUERY_STRING'];
      parse_str($queryString, $params);

      $urlArray = array();

      foreach ($params as $key => $term){
        if($ccnParam != $key && $key){
          $urlArray[$key] = $term;
        }
        if(!isset($_GET['cocoon_filter'])){
          $urlArray['cocoon_filter'] = '';
        }
      }
      $urlArray[$ccnParam] = $ccnValue;

      $ccnCompareToQuery = $this->ccnFilterOptionIsTrue($ccnParam, $ccnValue);

      $ccnReturn = new stdClass();
      $ccnReturn->ccnState = $ccnCompareToQuery;
      $ccnReturn->ccnQuery = new moodle_url('/course/index.php', $urlArray);

      return $ccnReturn;
    }

    return null;
  }

  public function ccnFilterCourses($courses){

    if($courses) {

      if (isset($_GET['cocoon_filter'])) {

        $ccnFilter = false;
        $ccnFilter_Price = $ccnFilter_Rating = null;
        $_ccnFilterPrice = new stdClass();
        $_ccnFilterRating = new stdClass();

        $_ccnFilterPrice->name = 'filter-price';
        $_ccnFilterPrice->ccnHandler = 'hasMonetaryValue';
        $_ccnFilterPrice->ccnRefineBy = '=';
        $_ccnFilterPrice->ccnPermitted = array(
          '1',
          '2'
        );
        $_ccnFilterRating->name = 'filter-rating';
        $_ccnFilterRating->ccnHandler = 'overallRating';
        $_ccnFilterRating->ccnRefineBy = '>';
        $_ccnFilterRating->ccnPermitted = array(
          '1',
          '2',
          '3',
          '4',
          '5'
        );

        $ccnFilters = array();

        $ccnFilterObjs = array(
          'filter-price' => $_ccnFilterPrice,
          'filter-rating' => $_ccnFilterRating,
        );

        $ccnCourses = $courses;
        // $ccnResult = array();

        foreach($ccnFilterObjs as $key=>$ccnFilterObj){
          if (
            isset($_GET[$ccnFilterObj->name])
            && !($_GET[$ccnFilterObj->name] == '')
            && in_array($_GET[$ccnFilterObj->name], $ccnFilterObj->ccnPermitted)
          ) {
            $ccnFilterProperty = $ccnFilterObj->ccnHandler;
            $ccnFilterBy = $ccnFilterObj->ccnRefineBy;
            $ccnFilterObj = (int)$_GET[$ccnFilterObj->name];


            foreach($ccnCourses as $i=>$ccnCourse){
              $ccnCourseId = is_integer($i) ? (int)$i : print_object("An error occured.");
              $ccnCcnCourse = $this->ccnGetCourseDetails($ccnCourseId);

              if($ccnFilterBy == '='){
                if(
                  $ccnCcnCourse->$ccnFilterProperty != $ccnFilterObj
                ){
                  unset($ccnCourses[$i]);
                }
              } else if($ccnFilterBy == '>'){
                if(
                  $ccnCcnCourse->$ccnFilterProperty < $ccnFilterObj
                ){
                  unset($ccnCourses[$i]);
                }
              }

            }
          }
        }
        return $ccnCourses;
      }
    }
    return null;
  }

  public function ccnGetCourseCategoryFilterCount($coursecat) {
    if($coursecat){
        $ccnCatCourseCount = $coursecat->get_courses_count();
        if(isset($_GET['cocoon_filter'])){
          $ccnCatCourseCount = get_string('ccn_cf_all_matching', 'theme_edumy');
        }
        return $ccnCatCourseCount;
    }
    return null;
  }

  public function ccnListCategories(){

    global $DB, $CFG;

    $topcategory = core_course_category::top();
    $topcategorykids = $topcategory->get_children();
    $areanames = array();
    foreach ($topcategorykids as $areaid => $topcategorykids) {
      $areanames[$areaid] = $topcategorykids->get_formatted_name();
      foreach($topcategorykids->get_children() as $k=>$child){
        $areanames[$k] = $child->get_formatted_name();
      }
    }

    return $areanames;
  }

  public function ccnGetCategoryDetails($categoryId){
    global $CFG, $COURSE, $USER, $DB, $SESSION, $SITE, $PAGE, $OUTPUT;

    if ($DB->record_exists('course_categories', array('id' => $categoryId))) {

      $categoryRecord = $DB->get_record('course_categories', array('id' => $categoryId));

      $chelper = new coursecat_helper();
      $categoryObject = core_course_category::get($categoryId);

      $ccnCategory = new \stdClass();

      $categoryId = $categoryRecord->id;
      $categoryName = format_text($categoryRecord->name, FORMAT_HTML, array('filter' => true));
      $categoryDescription = $chelper->get_category_formatted_description($categoryObject);

      // $categoryDescription = format_text($categoryRecord->description, FORMAT_HTML, array('filter' => true));
      $categorySummary = format_string($categoryRecord->description, $striplinks = true,$options = null);
      $isVisible = $categoryRecord->visible;
      $categoryUrl = $CFG->wwwroot . '/course/index.php?categoryid=' . $categoryId;
      $categoryCourses = $categoryObject->get_courses();
      $categoryCoursesCount = count($categoryCourses);

      /* Do image */
      $outputimage = '';
      //ccnComm: Fetching the image manually added to the coursecat description via the editor.
      $description = $chelper->get_category_formatted_description($categoryObject);
      if ($description) {
        $dom = new DOMDocument();
        $dom->loadHTML($description);
        $xpath = new DOMXPath($dom);
        $src = $xpath->evaluate("string(//img/@src)");
      }
      if ($src && $description){
        $outputimage = $src;
      } else {
        // if($categoryCourses >= 1){
        //   $countNoOfCourses = '<p>'.get_string('number_of_courses', 'theme_edumy', count($categoryCourses)).'</p>';
        // } else {
        //   $countNoOfCourses = '';
        // }
        foreach($categoryCourses as $child_course) {
          if ($child_course === reset($categoryCourses)) {
            foreach ($child_course->get_course_overviewfiles() as $file) {
              if ($file->is_valid_image()) {
                $imagepath = '/' . $file->get_contextid() . '/' . $file->get_component() . '/' . $file->get_filearea() . $file->get_filepath() . $file->get_filename();
                $imageurl = file_encode_url($CFG->wwwroot . '/pluginfile.php', $imagepath, false);
                $outputimage  =  $imageurl;
                // Use the first image found.
                break;
              }
            }
          }
        }
      }

      /* Map data */
      $ccnCategory->categoryId = $categoryId;
      $ccnCategory->categoryName = $categoryName;
      $ccnCategory->categoryDescription = $categoryDescription;
      $ccnCategory->categorySummary = $categorySummary;
      $ccnCategory->isVisible = $isVisible;
      $ccnCategory->categoryUrl = $categoryUrl;
      $ccnCategory->coverImage = $outputimage;
      $ccnCategory->courses = $categoryCourses;
      $ccnCategory->coursesCount = $categoryCoursesCount;

      return $ccnCategory;

    }
  }

  public function ccnGetCourseDescription($courseId, $maxLength){
    global $CFG, $COURSE, $USER, $DB, $SESSION, $SITE, $PAGE, $OUTPUT;

    if ($DB->record_exists('course', array('id' => $courseId))) {
      $chelper = new coursecat_helper();
      $courseContext = context_course::instance($courseId);

      $courseRecord = $DB->get_record('course', array('id' => $courseId));
      $courseElement = new core_course_list_element($courseRecord);

      if ($courseElement->has_summary()) {
        $courseSummary = $chelper->get_course_formatted_summary($courseElement, array('noclean' => false, 'para' => false));
        if($maxLength != null) {
          if (strlen($courseSummary) > $maxLength) {
            $courseSummary = wordwrap($courseSummary, $maxLength);
            $courseSummary = substr($courseSummary, 0, strpos($courseSummary, "\n")) . '...';
          }
        }
        return $courseSummary;
      }

    }
    return null;
  }

  public function ccnGetExampleCourses($maxNum) {
    global $CFG, $DB;

    // todo: we DONT want site context, so we're avoiding it with limitfrom1.
    $ccnCourses = $DB->get_records('course', array(), $sort='', $fields='*', $limitfrom=1, $limitnum=$maxNum);

    $ccnReturn = array();
    foreach ($ccnCourses as $ccnCourse) {
      $ccnReturn[] = $this->ccnGetCourseDetails($ccnCourse->id);
    }
    return $ccnReturn;
  }

  public function ccnGetExampleCoursesIds($maxNum) {
    global $CFG, $DB;

    $ccnCourses = $this->ccnGetExampleCourses($maxNum);

    $ccnReturn = array();
    foreach ($ccnCourses as $key => $ccnCourse) {
      $ccnReturn[] = $ccnCourse->courseId;
    }
    return $ccnReturn;
  }

  public function ccnGetExampleCategories($maxNum) {
    global $CFG, $DB;

    $ccnCategories = $DB->get_records('course_categories', array(), $sort='', $fields='*', $limitfrom=0, $limitnum=$maxNum);

    $ccnReturn = array();
    foreach ($ccnCategories as $ccnCategory) {
      $ccnReturn[] = $this->ccnGetCategoryDetails($ccnCategory->id);
    }
    return $ccnReturn;
  }

  public function ccnGetExampleCategoriesIds($maxNum) {
    global $CFG, $DB;

    $ccnCategories = $this->ccnGetExampleCategories($maxNum);

    $ccnReturn = array();
    foreach ($ccnCategories as $key => $ccnCategory) {
      $ccnReturn[] = $ccnCategory->categoryId;
    }
    return $ccnReturn;
  }
}
