<?php
/*
@ccnRef: @block_cocoon/block.php
*/

defined('MOODLE_INTERNAL') || die();

// if (!($this->config)) {
//   if(!($this->content)){
//     $this->content = new \stdClass();
//   }
//     $this->content->text = '<h5 class="mb30">'.$this->title.'</h5>';
//     return $this->content->text;
// }

// print_object($this);
$ccnBlockType = $this->instance->blockname;

$ccnCollectionFullwidthTop =  array(
  "cocoon_about_1",
  "cocoon_about_2",
  "cocoon_accordion",
  "cocoon_action_panels",
  "cocoon_blog_recent_slider",
  "cocoon_boxes",
  "cocoon_event_list",
  "cocoon_event_list_2",
  "cocoon_faqs",
  "cocoon_features",
  "cocoon_gallery_video",
  "cocoon_parallax",
  "cocoon_parallax_apps",
  "cocoon_parallax_counters",
  "cocoon_parallax_features",
  "cocoon_parallax_testimonials",
  "cocoon_parallax_subscribe",
  "cocoon_parallax_subscribe_2",
  "cocoon_partners",
  "cocoon_parallax_white",
  "cocoon_pills",
  "cocoon_price_tables",
  "cocoon_price_tables_dark",
  "cocoon_services",
  "cocoon_services_dark",
  "cocoon_simple_counters",
  "cocoon_hero_1",
  "cocoon_hero_2",
  "cocoon_hero_3",
  "cocoon_hero_4",
  "cocoon_hero_5",
  "cocoon_hero_6",
  "cocoon_hero_7",
  "cocoon_slider_1",
  "cocoon_slider_1_v",
  "cocoon_slider_2",
  "cocoon_slider_3",
  "cocoon_slider_4",
  "cocoon_slider_5",
  "cocoon_slider_6",
  "cocoon_slider_7",
  "cocoon_slider_8",
  "cocoon_steps",
  "cocoon_steps_dark",
  "cocoon_subscribe",
  "cocoon_tablets",
  "cocoon_course_categories",
  "cocoon_course_categories_2",
  "cocoon_course_categories_3",
  "cocoon_course_categories_4",
  "cocoon_course_categories_5",
  "cocoon_course_grid",
  "cocoon_course_grid_2",
  "cocoon_course_grid_3",
  "cocoon_course_grid_4",
  "cocoon_course_grid_5",
  "cocoon_course_grid_6",
  "cocoon_course_grid_7",
  "cocoon_course_grid_8",
  "cocoon_featuredcourses",
  "cocoon_featured_posts",
  "cocoon_featured_video",
  "cocoon_featured_teacher",
  "cocoon_courses_slider",
  "cocoon_users_slider",
  "cocoon_users_slider_2",
  "cocoon_users_slider_2_dark",
  "cocoon_users_slider_round",
  "cocoon_tstmnls",
  "cocoon_tstmnls_2",
  "cocoon_tstmnls_3",
  "cocoon_tstmnls_4",
  "cocoon_tstmnls_5",
  "cocoon_tstmnls_6",
);

$ccnCollectionAboveContent =  array(
  "cocoon_contact_form",
  "cocoon_course_overview",
  "cocoon_tabs",
);

$ccnCollectionBelowContent =  array(
  "cocoon_course_rating",
  "cocoon_more_courses",
  "cocoon_course_instructor",
);

$ccnCollection = array_merge($ccnCollectionFullwidthTop, $ccnCollectionAboveContent, $ccnCollectionBelowContent);

if (empty($this->config)) {
  if(in_array($ccnBlockType, $ccnCollectionFullwidthTop)) {
    $this->instance->defaultregion = 'fullwidth-top';
    $this->instance->region = 'fullwidth-top';
    $DB->update_record('block_instances', $this->instance);
  }
  if(in_array($ccnBlockType, $ccnCollectionAboveContent)) {
    $this->instance->defaultregion = 'above-content';
    $this->instance->region = 'above-content';
    $DB->update_record('block_instances', $this->instance);
  }
  if(in_array($ccnBlockType, $ccnCollectionBelowContent)) {
    $this->instance->defaultregion = 'below-content';
    $this->instance->region = 'below-content';
    $DB->update_record('block_instances', $this->instance);
  }
  /* Begin Legacy */
  if(!in_array($ccnBlockType, $ccnCollection)) {
    if(!($this->content)){
       $this->content = new \stdClass();
    }
    $this->content->text = '<h5 class="mb30">'.$this->title.'</h5>';
    return $this->content->text;
  }
  /* End Legacy */
}
