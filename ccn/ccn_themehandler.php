<?php
/*
@ccnRef: @theme_edumy/layout
*/

defined('MOODLE_INTERNAL') || die();
global $USER, $CFG, $SESSION, $OUTPUT, $COURSE, $DB;
require_once($CFG->libdir . '/behat/lib.php');
include($CFG->dirroot . '/theme/edumy/ccn/ccn_loginform.php');
include($CFG->dirroot . '/theme/edumy/ccn/ccn_globalsearch.php');
include($CFG->dirroot . '/theme/edumy/ccn/ccn_globalsearch_navbar.php');
include($CFG->dirroot . '/theme/edumy/ccn/ccn_librarylist.php');
include($CFG->dirroot . '/theme/edumy/ccn/course_handler/ccn_activity_nav.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/user_handler/ccn_user_handler.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/page_handler/ccn_page_handler.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/mdl_handler/ccn_mdl_handler.php');

/* @ccnComm: Initialize */
$ccnUserHandler = new ccnUserHandler();
$ccnIsCourseCreator = $ccnUserHandler->ccnCheckRoleIsCourseCreatorAnywhere($USER->id);
$ccnIsManager = $ccnUserHandler->ccnCheckRoleIsManagerAnywhere($USER->id);
$ccnCurrentUserIsAuthenticated = $ccnUserHandler->ccnCurrentUserIsAuthenticated();

$ccnPageHandler = new ccnPageHandler();
$pageheading = $ccnPageHandler->ccnGetPageTitle();

$ccnMdlHandler = new ccnMdlHandler();
$ccnMdlVersion = $ccnMdlHandler->ccnGetCoreVersion();

/* @ccnComm: Visualize */
if (isset($_GET['bui_editid'])) {
  // Perform actions
}

/* @ccnBreak */
if (is_siteadmin()) {$user_status = 'role-supreme';} else {$user_status = 'role-standard';}
if(method_exists('theme_edumy\output\core_renderer', 'get_theme_image_headerlogo1') && method_exists('theme_edumy\output\core_renderer_maintenance', 'get_theme_image_headerlogo1') && !empty($OUTPUT->get_theme_image_headerlogo1())){
  $headerlogo1 = $OUTPUT->get_theme_image_headerlogo1(null, 100);
} else {
  $headerlogo1 = $CFG->wwwroot . '/theme/edumy/images/header-logo.png';
}
if(method_exists('theme_edumy\output\core_renderer', 'get_theme_image_headerlogo2') && method_exists('theme_edumy\output\core_renderer_maintenance', 'get_theme_image_headerlogo2') && !empty($OUTPUT->get_theme_image_headerlogo2())){
  $headerlogo2 = $OUTPUT->get_theme_image_headerlogo2(null, 100);
} else {
  $headerlogo2 = $CFG->wwwroot . '/theme/edumy/images/header-logo2.png';
}
if(method_exists('theme_edumy\output\core_renderer', 'get_theme_image_headerlogo3') && method_exists('theme_edumy\output\core_renderer_maintenance', 'get_theme_image_headerlogo3') && !empty($OUTPUT->get_theme_image_headerlogo3())){
  $headerlogo3 = $OUTPUT->get_theme_image_headerlogo3(null, 100);
} else {
  $headerlogo3 = $CFG->wwwroot . '/theme/edumy/images/header-logo4.png';
}
if(method_exists('theme_edumy\output\core_renderer', 'get_theme_image_headerlogo_mobile') && method_exists('theme_edumy\output\core_renderer_maintenance', 'get_theme_image_headerlogo_mobile') && !empty($OUTPUT->get_theme_image_headerlogo_mobile())){
  $headerlogo_mobile = $OUTPUT->get_theme_image_headerlogo_mobile(null, 100);
} else {
  $headerlogo_mobile = $CFG->wwwroot . '/theme/edumy/images/header-logo.png';
}
if(method_exists('theme_edumy\output\core_renderer', 'get_theme_image_footerlogo1') && method_exists('theme_edumy\output\core_renderer_maintenance', 'get_theme_image_footerlogo1') && !empty($OUTPUT->get_theme_image_footerlogo1())){
  $footerlogo1 = $OUTPUT->get_theme_image_footerlogo1(null, 100);
} else {
  $footerlogo1 = $CFG->wwwroot . '/theme/edumy/images/header-logo.png';
}
if(method_exists('theme_edumy\output\core_renderer', 'get_theme_image_heading_bg') && method_exists('theme_edumy\output\core_renderer_maintenance', 'get_theme_image_heading_bg') && !empty($OUTPUT->get_theme_image_heading_bg())){
  $heading_bg = $OUTPUT->get_theme_image_heading_bg(null, 100);
} else {
  $heading_bg = $CFG->wwwroot . '/theme/edumy/images/background/inner-pagebg.jpg';
}
if(method_exists('theme_edumy\output\core_renderer', 'get_theme_image_favicon') && method_exists('theme_edumy\output\core_renderer_maintenance', 'get_theme_image_favicon') && !empty($OUTPUT->get_theme_image_favicon())){
  $favicon = $OUTPUT->get_theme_image_favicon(null, 100);
} else {
  $favicon = $CFG->wwwroot . '/theme/edumy/pix/favicon.ico';
}
$headertype = get_config('theme_edumy', 'headertype');
$headertype_settings = get_config('theme_edumy', 'headertype_settings');
$header_search = get_config('theme_edumy', 'header_search');
$header_login = get_config('theme_edumy', 'header_login');
$footertype = get_config('theme_edumy', 'footertype');
$breadcrumb_style = get_config('theme_edumy', 'breadcrumb_style');
$preloader_duration = get_config('theme_edumy', 'preloader_duration');
$blogstyle = get_config('theme_edumy', 'blogstyle');
$courseliststyle = get_config('theme_edumy', 'courseliststyle');
$showCourseStartDate = get_config('theme_edumy', 'course_start_date');
$showCourseCategory = get_config('theme_edumy', 'course_category');
$back_to_top = get_config('theme_edumy', 'back_to_top');
$dashboard_scroll_header = get_config('theme_edumy', 'dashboard_sticky_header');
$dashboard_scroll_drawer = get_config('theme_edumy', 'dashboard_sticky_drawer');
$dashboard_left_drawer = get_config('theme_edumy', 'dashboard_left_drawer');
$ccnSettingLogoUrl = get_config('theme_edumy', 'logo_url');
$logo_image_width = preg_replace("/[^0-9]/", "", get_config('theme_edumy', 'logo_image_width'));
$logo_image_height = preg_replace("/[^0-9]/", "", get_config('theme_edumy', 'logo_image_height'));
$logo_image_width_footer = preg_replace("/[^0-9]/", "", get_config('theme_edumy', 'logo_image_width_footer'));
$logo_image_height_footer = preg_replace("/[^0-9]/", "", get_config('theme_edumy', 'logo_image_height_footer'));
$logo_styles = '';
if ($logo_image_width) {
  $logo_styles .= 'width:'.$logo_image_width.'px;max-width:none!important;';
}
if ($logo_image_height) {
  $logo_styles .= 'height:'.$logo_image_height.'px;max-height:none!important;';
}
$logo_styles_footer = '';
if ($logo_image_width_footer) {
  $logo_styles_footer .= 'width:'.$logo_image_width_footer.'px;max-width:none!important;';
}
if ($logo_image_height_footer) {
  $logo_styles_footer .= 'height:'.$logo_image_height_footer.'px;max-height:none!important;';
}
$ccnLogoUrl = $CFG->wwwroot;
if(!empty($ccnSettingLogoUrl) && $ccnSettingLogoUrl !== ''){
  $ccnLogoUrl = $ccnSettingLogoUrl;
}
$breadcrumb_clip_setting = get_config('theme_edumy', 'breadcrumb_clip');
$breadcrumb_caps_setting = get_config('theme_edumy', 'breadcrumb_caps');
$breadcrumb_title_setting = get_config('theme_edumy', 'breadcrumb_title');
$breadcrumb_trail_setting = get_config('theme_edumy', 'breadcrumb_trail');
$breadcrumb_classes = '';
if($breadcrumb_clip_setting == 1) { //Clip V Long
  $breadcrumb_classes .= ' ccn-clip-lx2 ';
} elseif($breadcrumb_clip_setting == 2) { // No Clip
  $breadcrumb_classes .= ' ccn-no-clip ';
} else { //Clip Default
  $breadcrumb_classes .= ' ccn-clip-l ';
}
if($breadcrumb_caps_setting == 1) { //Lowercase
  $breadcrumb_classes .= ' ccn-caps-lower ';
} elseif($breadcrumb_caps_setting == 2) { // Uppercase
  $breadcrumb_classes .= ' ccn-caps-upper ';
} elseif($breadcrumb_caps_setting == 3) { // None
  $breadcrumb_classes .= ' ccn-caps-none ';
} else { //Default capitalize
  $breadcrumb_classes .= ' ccn-caps-capitalize ';
}
if($breadcrumb_title_setting == 1) { // Hidden
  $breadcrumb_classes .= ' ccn-breadcrumb-title-h ';
} else { //Visible
  $breadcrumb_classes .= ' ccn-breadcrumb-title-v ';
}
if($breadcrumb_trail_setting == 1) { // Hidden
  $breadcrumb_classes .= ' ccn-breadcrumb-trail-h ';
} else { //Visible
  $breadcrumb_classes .= ' ccn-breadcrumb-trail-v ';
}
$dash_breadcrumb_clip_setting = get_config('theme_edumy', 'breadcrumb_clip_dash');
if($dash_breadcrumb_clip_setting == 1) { //Clip V Long
  $breadcrumb_clip_dash = 'ccn-clip-lx2';
} elseif($dash_breadcrumb_clip_setting == 2) { // No Clip
  $breadcrumb_clip_dash = 'ccn-no-clip';
} else { //Clip Default
  $breadcrumb_clip_dash = 'ccn-clip-l';
}
$social_target = get_config('theme_edumy', 'social_target');
if($social_target == 1) {
  $social_target_href = 'target="_blank"';
} else {
  $social_target_href = 'target="_self"';
}
if ($PAGE->pagetype == 'site-index') {
  $ccn_frontcheck = 'ccn-is-front';
} else {
  $ccn_frontcheck = 'ccn-not-front';
}
if(get_config('theme_edumy', 'page_settings_controls') == 1) {  //Hide Page Settings Controls if not an administrator
  if(is_siteadmin() || $ccnIsManager || $ccnIsCourseCreator){ //Show
    $ccn_page_settings_controls = 1;
  } else { //Hide
    $ccn_page_settings_controls = 0;
  }
} else { //Show
  $ccn_page_settings_controls = 1;
}
if(get_config('theme_edumy', 'headertype_settings') == 1) {
  $headertype_settings_class = 'ccn_header_applies-all';
} else {
  $headertype_settings_class = 'ccn_header_applies-front';
}
$dash_header_setting_class = '';
if(get_config('theme_edumy', 'dashboard_sticky_header') == 1) {
  $dash_header_setting_class .= ' ccn_dashboard_header_scroll ';
} else {
  $dash_header_setting_class .= ' ccn_dashboard_header_sticky ';
}
if(get_config('theme_edumy', 'dashboard_header') == 1) {
  $dash_header_setting_class .= ' ccn_dashboard_header_white ';
} else {
  $dash_header_setting_class .= ' ccn_dashboard_header_gradient ';
}
$course_single_style_class = '';
if(get_config('theme_edumy', 'course_single_style') == 1) { // v2
  $course_single_style_class .= ' ccn_course_single_v2 ';
} elseif(get_config('theme_edumy', 'course_single_style') == 2) { //v3
  $course_single_style_class .= ' ccn_course_single_v3 ';
} else {
  $course_single_style_class .= ' ccn_course_single_v1 ';
}
// if ($PAGE->bodyid == 'page-grade-report-overview-index') {
//   $PAGE->set_pagelayout('admin');
// }

$ccnHook_userNotifIcon = '';
$ccnHook_userMesseIcon = '';
$ccnHook_custMenAuth = '';
$ccnUserBodyClass = 'ccnUG';
if(get_config('theme_edumy', 'notification_icon_visibility') == '1'){
  $ccnHook_userNotifIcon = 'ccnHook_uni';
}
if(get_config('theme_edumy', 'messages_icon_visibility') == '1'){
  $ccnHook_userMesseIcon = 'ccnHook_umi';
}
if(get_config('theme_edumy', 'header_main_menu') == '1'){
  $ccnHook_custMenAuth = 'ccnHook_cma';
}
if($ccnCurrentUserIsAuthenticated == TRUE){
  $ccnUserBodyClass = 'ccnUA';
}

$extraclasses = array(
  'ccn_no_hero',
  'ccn_header_style_' . $headertype,
  'ccn_footer_style_' . $footertype,
  'ccn_blog_style_' . $blogstyle,
  'ccn_course_list_style_' . $courseliststyle,
  'ccn_breadcrumb_style_' . $breadcrumb_style,
  $user_status,
  $ccn_frontcheck,
  $headertype_settings_class,
  $dash_header_setting_class,
  $course_single_style_class,
  $ccnHook_userNotifIcon,
  $ccnHook_userMesseIcon,
  $ccnHook_custMenAuth,
  $ccnUserBodyClass
);
// $pageheading = $PAGE->heading;

$blockshtml = $OUTPUT->blocks('side-pre');
$leftblocks = $OUTPUT->blocks('left');
/* Deprecate these variables soon; copied & renamed immediately below */
$hasblocks = strpos($blockshtml, 'data-block=') !== false;
$hasleftblocks = strpos($leftblocks, 'data-block=') !== false;
/* End: Deprecate these variables soon; copied & renamed immediately below */
$sidebar_left = strpos($leftblocks, 'data-block=') !== false;
$sidebar_right = strpos($blockshtml, 'data-block=') !== false;

$regionmainsettingsmenu = $OUTPUT->region_main_settings_menu();
$hassideblocks = ($hasblocks || $hasleftblocks);
$sidebar_single = (($hasblocks && !$hasleftblocks) || (!$hasblocks && $hasleftblocks));
$sidebar_single_left = (!$hasblocks && $hasleftblocks);
$sidebar_single_right = ($hasblocks && !$hasleftblocks);
$sidebar_double = ($hasblocks && $hasleftblocks);
$sidebar_none = (!$hasblocks && !$hasleftblocks);



$blocks_user_notifications = $OUTPUT->blocks('user-notif');
$blocks_user_messages = $OUTPUT->blocks('user-messages');
$blocks_fullwidth_top = $OUTPUT->blocks('fullwidth-top');
$blocks_fullwidth_bottom = $OUTPUT->blocks('fullwidth-bottom');
$blocks_above_content = $OUTPUT->blocks('above-content');
$blocks_below_content = $OUTPUT->blocks('below-content');
$loginblocks = $OUTPUT->blocks('login');
$searchblocks = $OUTPUT->blocks('search');
$cocoon_facebook_url = get_config('theme_edumy', 'cocoon_facebook_url');
$cocoon_copyright = get_config('theme_edumy', 'cocoon_copyright');
$courseid = $PAGE->course->id;
$coursefullname = $PAGE->course->fullname;
$courseshortname = $PAGE->course->shortname;
if (!empty($PAGE->category->name)){$coursecategory = format_text($PAGE->category->name, FORMAT_HTML, array('filter' => true));}else{$coursecategory = '';}
$coursesummary = $PAGE->course->summary;
$courseformat = $PAGE->course->format;
$coursecreated = userdate($PAGE->course->timecreated, get_string('strftimedatefullshort', 'langconfig'), 0);
$coursemodified = userdate($PAGE->course->timemodified, get_string('strftimedatefullshort', 'langconfig'), 0);
$coursestartdate = userdate($PAGE->course->startdate, get_string('strftimedatefullshort', 'langconfig'), 0);
$courseenddate = userdate($PAGE->course->enddate, get_string('strftimedatefullshort', 'langconfig'), 0);
$context_site = context_course::instance(SITEID);
$context = context_course::instance($courseid);
if($context){
  $is_enrolled = is_enrolled($context, $USER, '', true);
}
$courseMainPage = strpos($_SERVER['REQUEST_URI'], "course/view.php") !== false && !isset($_GET["section"]);
$courseSectionPage = strpos($_SERVER['REQUEST_URI'], "course/view.php") !== false && isset($_GET["section"]);
$courseEnrolPage = strpos($_SERVER['REQUEST_URI'], "enrol/index.php") !== false && isset($_GET["id"]);

$incourse_layout_setting = get_config('theme_edumy', 'incourse_layout');
$course_mainpage_layout_setting = get_config('theme_edumy', 'coursemainpage_layout');

// if($incourse_layout_setting == 1 && $context->id == $context_site->id) {
//   $incourse_layout_dashboard = 0;
//   $incourse_layout_focus = 0;
// } elseif($incourse_layout_setting == 1 && $context->id != $context_site->id && !$courseMainPage && !$courseEnrolPage){
//   $incourse_layout_dashboard = 1;
//   $incourse_layout_focus = 0;
// } elseif($incourse_layout_setting == 2 && $context->id != $context_site->id && !$courseMainPage && !$courseEnrolPage){
//   $incourse_layout_dashboard = 0;
//   $incourse_layout_focus = 1;
// } else {
//   $incourse_layout_dashboard = 0;
//   $incourse_layout_focus = 0;
// }

$incourse_layout_dashboard = 0;
$incourse_layout_focus = 0;

if($incourse_layout_setting != 0 && $context->id != $context_site->id && !$courseMainPage && !$courseEnrolPage) {
  if($incourse_layout_setting == 1) { //Edumy Dash
    $incourse_layout_dashboard = 1;
    $incourse_layout_focus = 0;
  } elseif($incourse_layout_setting == 2) { //Edumy Focus
    $incourse_layout_dashboard = 0;
    $incourse_layout_focus = 1;
  }
}

// Temporarily Disabling; Future Theme Setting; Set all to 0 for now!
if($course_mainpage_layout_setting != 0 && $context->id == $context_site->id) {
  $course_mainpage_layout_dashboard = '0';
} elseif($course_mainpage_layout_setting == 1 && $context->id != $context_site->id && $is_enrolled){ //Edumy Dashboard for enrolled users only
  // $course_mainpage_layout_dashboard = 1;
  $course_mainpage_layout_dashboard = '1';
} elseif($course_mainpage_layout_setting == 2 && $context->id != $context_site->id){ //Edumy Dashboard for all users
  // $course_mainpage_layout_dashboard = 1;
  $course_mainpage_layout_dashboard = '1';
} elseif($course_mainpage_layout_setting == 3 && $context->id != $context_site->id && $is_enrolled){ //Edumy Focus for enrolled users only
  // $course_mainpage_layout_dashboard = 1;
  $course_mainpage_layout_dashboard = '2';
} elseif($course_mainpage_layout_setting == 4 && $context->id != $context_site->id){ //Edumy Focus for all users
  // $course_mainpage_layout_dashboard = 1;
  $course_mainpage_layout_dashboard = '2';
} else {
  $course_mainpage_layout_dashboard = '0';
}

if($context->id == $context_site->id) {
  $incourse = 0;
} elseif($context->id != $context_site->id){
  $incourse = 1;
} else {
  $incourse = 0;
}

$ccnDashLayoutSetting = get_config('theme_edumy', 'dashboard_layout');
$ccnDashLayout = 0;
if($ccnDashLayoutSetting == '1'){
  $ccnDashLayout = 1;
}


$singlecourse_blocks_setting = get_config('theme_edumy', 'singlecourse_blocks');
$userProfileFromCourseParticipants = strpos($_SERVER['REQUEST_URI'], "user/view.php") !== false && isset($_GET["course"]);

if ($singlecourse_blocks_setting == 1 && (strpos($_SERVER['REQUEST_URI'], "user/index.php") !== false || strpos($_SERVER['REQUEST_URI'], "course/edit.php") !== false || strpos($_SERVER['REQUEST_URI'], "course/completion.php") !== false || strpos($_SERVER['REQUEST_URI'], "course/admin.php") !== false || $courseSectionPage) || $userProfileFromCourseParticipants){
  // Disable ALL block regions, regardless of all other parameters and permission settings
  $sidebar_left = false;
  $sidebar_right = false;
  $blocks_above_content = false;
  $blocks_below_content = false;
  $blocks_fullwidth_top = false;
  $blocks_fullwidth_bottom = false;
  $sidebar_double = false;
  $sidebar_single_left = false;
  $sidebar_single_right = false;
  $sidebar_none = true;
}
$user_profile_layout_setting = get_config('theme_edumy', 'user_profile_layout');
if($user_profile_layout_setting == 1){
  $user_profile_layout_dashboard = 1;
} else {
  $user_profile_layout_dashboard = 0;
}
$course_content_enroled_only = get_config('theme_edumy', 'course_content_enroled_only');
if($course_content_enroled_only == 1 && ($is_enrolled == 1 || is_siteadmin() || $ccnIsManager || $ccnIsCourseCreator)){
  $display_course_content = 1;
} elseif($course_content_enroled_only == 1 && $is_enrolled !== 1){
  $display_course_content = 0;
} elseif($course_content_enroled_only == 0){
  $display_course_content = 1;
} else {
  $display_course_content = 1;
}

$numberofusers = count_enrolled_users($context);
if (function_exists('isguestuser') && isguestuser() == 1) {
  $isloggedin = 'FALSE';
} elseif (isloggedin()) {
  $isloggedin = 'TRUE';
  $messages_link = $CFG->wwwroot . '/message/index.php';
  $profile_link = $CFG->wwwroot . '/user/profile.php?id=' . $USER->id;
  $grades_link = $CFG->wwwroot . '/grade/report/overview/index.php';
  $preferences_link = $CFG->wwwroot . '/user/preferences.php';
} else {
  $isloggedin = 'FALSE';
  $messages_link = '';
  $profile_link = '';
  $grades_link = '';
  $preferences_link = '';
}
if (function_exists('signup_is_enabled') && signup_is_enabled()) {
  $signup_is_enabled = true;
} else {
  $signup_is_enabled = false;
}
if (get_config('theme_edumy', 'library_list') == 0){
  $display_library_list = false;
} else {
  $display_library_list = true;
}
if (get_config('theme_edumy', 'logotype') == 1){
  $logotype = false;
} else {
  $logotype = true;
}
if (get_config('theme_edumy', 'logo_image') == 1){
  $logo_image = false;
} else {
  $logo_image = true;
}
if (!$logotype && !$logo_image){
  $logo = false;
} else {
  $logo = true;
}
if (get_config('theme_edumy', 'logotype_footer') == 1){
  $logotype_footer = false;
} else {
  $logotype_footer = true;
}
if (get_config('theme_edumy', 'logo_image_footer') == 1){
  $logo_image_footer = false;
} else {
  $logo_image_footer = true;
}
if (!$logotype_footer && !$logo_image_footer){
  $logo_footer = false;
} else {
  $logo_footer = true;
}
if(get_config('theme_edumy', 'custom_css')){
  $custom_css = '<style>'.get_config('theme_edumy', 'custom_css').'</style>';
} else {
  $custom_css = '';
}
if(get_config('theme_edumy', 'custom_css_dashboard')){
  $custom_css_dashboard = '<style>'.get_config('theme_edumy', 'custom_css_dashboard').'</style>';
} else {
  $custom_css_dashboard = '';
}
if(get_config('theme_edumy', 'custom_js')){
  $custom_js = '<script>'.get_config('theme_edumy', 'custom_js').'</script>';
} else {
  $custom_js = '';
}
if(get_config('theme_edumy', 'custom_js_dashboard')){
  $custom_js_dashboard = '<script>'.get_config('theme_edumy', 'custom_js_dashboard').'</script>';
} else {
  $custom_js_dashboard = '';
}

$ccnProfileIconUsername = $USER->username;
if(get_config('theme_edumy', 'profile_icon_username') == '1'){
  $ccnProfileIconUsername = $USER->firstname . ' '. $USER->lastname;
}

// Dash tab 1
if(get_config('theme_edumy', 'dashboard_tablet_1_title')){
  $dash_tablet_1_title = get_config('theme_edumy', 'dashboard_tablet_1_title');
} else {
  $dash_tablet_1_title = get_string('messages_title', 'theme_edumy');
}
if(get_config('theme_edumy', 'dashboard_tablet_1_subtitle')){
  $dash_tablet_1_subtitle = get_config('theme_edumy', 'dashboard_tablet_1_subtitle');
} else {
  $dash_tablet_1_subtitle = get_string('messages_desc', 'theme_edumy');
}
if(get_config('theme_edumy', 'dashboard_tablet_1_url')){
  $dash_tablet_1_link = get_config('theme_edumy', 'dashboard_tablet_1_url');
} else {
  $dash_tablet_1_link = $messages_link;
}
$dash_tablet_1_icon = get_config('theme_edumy', 'dashboard_tablet_1_ccn_icon_class');

// Dash tab 2
if(get_config('theme_edumy', 'dashboard_tablet_2_title')){
  $dash_tablet_2_title = get_config('theme_edumy', 'dashboard_tablet_2_title');
} else {
  $dash_tablet_2_title = get_string('profile_title', 'theme_edumy');
}
if(get_config('theme_edumy', 'dashboard_tablet_2_subtitle')){
  $dash_tablet_2_subtitle = get_config('theme_edumy', 'dashboard_tablet_2_subtitle');
} else {
  $dash_tablet_2_subtitle = get_string('profile_desc', 'theme_edumy');
}
if(get_config('theme_edumy', 'dashboard_tablet_2_url')){
  $dash_tablet_2_link = get_config('theme_edumy', 'dashboard_tablet_2_url');
} else {
  $dash_tablet_2_link = $profile_link;
}
$dash_tablet_2_icon = get_config('theme_edumy', 'dashboard_tablet_2_ccn_icon_class');

// Dash tab 3
if(get_config('theme_edumy', 'dashboard_tablet_3_title')){
  $dash_tablet_3_title = get_config('theme_edumy', 'dashboard_tablet_3_title');
} else {
  $dash_tablet_3_title = get_string('preferences_title', 'theme_edumy');
}
if(get_config('theme_edumy', 'dashboard_tablet_3_subtitle')){
  $dash_tablet_3_subtitle = get_config('theme_edumy', 'dashboard_tablet_3_subtitle');
} else {
  $dash_tablet_3_subtitle = get_string('preferences_desc', 'theme_edumy');
}
if(get_config('theme_edumy', 'dashboard_tablet_3_url')){
  $dash_tablet_3_link = get_config('theme_edumy', 'dashboard_tablet_3_url');
} else {
  $dash_tablet_3_link = $preferences_link;
}
$dash_tablet_3_icon = get_config('theme_edumy', 'dashboard_tablet_3_ccn_icon_class');

// Dash tab 4
if(get_config('theme_edumy', 'dashboard_tablet_4_title')){
  $dash_tablet_4_title = get_config('theme_edumy', 'dashboard_tablet_4_title');
} else {
  $dash_tablet_4_title = get_string('grades_title', 'theme_edumy');
}
if(get_config('theme_edumy', 'dashboard_tablet_4_subtitle')){
  $dash_tablet_4_subtitle = get_config('theme_edumy', 'dashboard_tablet_4_subtitle');
} else {
  $dash_tablet_4_subtitle = get_string('grades_desc', 'theme_edumy');
}
if(get_config('theme_edumy', 'dashboard_tablet_4_url')){
  $dash_tablet_4_link = get_config('theme_edumy', 'dashboard_tablet_4_url');
} else {
  $dash_tablet_4_link = $grades_link;
}
$dash_tablet_4_icon = get_config('theme_edumy', 'dashboard_tablet_4_ccn_icon_class');

// Dash tab column classes & visibility
$dash_tablet_count = 0;
$dash_tablet_1 = false;
$dash_tablet_2 = false;
$dash_tablet_3 = false;
$dash_tablet_4 = false;
if(get_config('theme_edumy', 'dashboard_tablet_1_visibility') == 0){
  $dash_tablet_count++;
  $dash_tablet_1 = true;
}
if(get_config('theme_edumy', 'dashboard_tablet_2_visibility') == 0){
  $dash_tablet_count++;
  $dash_tablet_2 = true;
}
if(get_config('theme_edumy', 'dashboard_tablet_3_visibility') == 0){
  $dash_tablet_count++;
  $dash_tablet_3 = true;
}
if(get_config('theme_edumy', 'dashboard_tablet_4_visibility') == 0){
  $dash_tablet_count++;
  $dash_tablet_4 = true;
}
if($dash_tablet_count == 4) {
  $dash_tab_col_class = "col-sm-6 col-md-6 col-lg-6 col-xl-3";
} elseif($dash_tablet_count == 3) {
  $dash_tab_col_class = "col-sm-12 col-md-12 col-lg-4 col-xl-4";
} elseif($dash_tablet_count == 2) {
  $dash_tab_col_class = "col-sm-12 col-md-12 col-lg-6 col-xl-6";
} elseif($dash_tablet_count == 1) {
  $dash_tab_col_class = "col-sm-12";
} else {
  $dash_tab_col_class = "col-sm-6 col-md-6 col-lg-6 col-xl-3";
}

// Footer col classes & visibility
$footer_column_count = 0;
$footer_column_1 = false;
$footer_column_2 = false;
$footer_column_3 = false;
$footer_column_4 = false;
$footer_column_5 = false;
if(get_config('theme_edumy', 'footer_col_1_title') || get_config('theme_edumy', 'footer_col_1_body')){
  $footer_column_count++;
  $footer_column_1 = true;
}
if(get_config('theme_edumy', 'footer_col_2_title') || get_config('theme_edumy', 'footer_col_2_body')){
  $footer_column_count++;
  $footer_column_2 = true;
}
if(get_config('theme_edumy', 'footer_col_3_title') || get_config('theme_edumy', 'footer_col_3_body')){
  $footer_column_count++;
  $footer_column_3 = true;
}
if(get_config('theme_edumy', 'footer_col_4_title') || get_config('theme_edumy', 'footer_col_4_body')){
  $footer_column_count++;
  $footer_column_4 = true;
}
if(get_config('theme_edumy', 'footer_col_5_title') || get_config('theme_edumy', 'footer_col_5_body')){
  $footer_column_count++;
  $footer_column_5 = true;
}
if($footer_column_count == 4) {
  $footer_col_1_class = "col-sm-6 col-md-6 col-md-3 col-lg-3";
  $footer_col_2_class = "col-sm-6 col-md-6 col-md-3 col-lg-3";
  $footer_col_3_class = "col-sm-6 col-md-6 col-md-3 col-lg-3";
  $footer_col_4_class = "col-sm-6 col-md-6 col-md-3 col-lg-3";
  $footer_col_5_class = "";
} elseif($footer_column_count == 3) {
  $footer_col_1_class = "col-sm-12 col-md-4 col-md-4 col-lg-4";
  $footer_col_2_class = "col-sm-12 col-md-4 col-md-4 col-lg-4";
  $footer_col_3_class = "col-sm-12 col-md-4 col-md-4 col-lg-4";
  $footer_col_4_class = "";
  $footer_col_5_class = "";
} elseif($footer_column_count == 2) {
  $footer_col_1_class = "col-sm-6 col-md-6 col-md-6 col-lg-6";
  $footer_col_2_class = "col-sm-6 col-md-6 col-md-6 col-lg-6";
  $footer_col_3_class = "";
  $footer_col_4_class = "";
  $footer_col_5_class = "";
} elseif($footer_column_count == 1) {
  $footer_col_1_class = "col-sm-12 col-md-6 offset-md-3 text-center";
  $footer_col_2_class = "";
  $footer_col_3_class = "";
  $footer_col_4_class = "";
  $footer_col_5_class = "";
} else {
  $footer_col_1_class = "col-sm-6 col-md-4 col-md-3 col-lg-3";
  $footer_col_2_class = "col-sm-6 col-md-4 col-md-3 col-lg-2";
  $footer_col_3_class = "col-sm-6 col-md-4 col-md-3 col-lg-2";
  $footer_col_4_class = "col-sm-6 col-md-4 col-md-3 col-lg-2";
  $footer_col_5_class = "col-sm-6 col-md-4 col-md-3 col-lg-3";
}
if(!empty($USER->username)){$USER->username = $USER->username;}else{$USER->username = '';}
if(!empty($USER->firstname)){$USER->firstname = $USER->firstname;}else{$USER->firstname = '';}
if(!empty($USER->lastname)){$USER->lastname = $USER->lastname;}else{$USER->lastname = '';}
if(!empty($USER->email)){$USER->email = $USER->email;}else{$USER->email = '';}
if(!empty($USER->lang)){$USER->lang = $USER->lang;}else{$USER->lang = '';}
