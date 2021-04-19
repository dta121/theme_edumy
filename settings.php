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

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

$ccnFontList = include($CFG->dirroot . '/theme/edumy/ccn/font_handler/ccn_font_select.php');

// This is used for performance, we don't need to know about these settings on every page in Moodle, only when
// we are looking at the admin settings pages.
if ($ADMIN->fulltree) {

    // Boost provides a nice setting page which splits settings onto separate tabs. We want to use it here.
    $settings = new theme_boost_admin_settingspage_tabs('themesettingedumy', get_string('configtitle', 'theme_edumy'));

    // CCN General settings
    $page = new admin_settingpage('theme_edumy_general', get_string('general_settings', 'theme_edumy'));

    // Blog style
    $setting = new admin_setting_configselect('theme_edumy/blogstyle',
        get_string('blogstyle', 'theme_edumy'),
        get_string('blogstyle_desc', 'theme_edumy'), null,
                array('1' => 'Blog style 1',
                      '2' => 'Blog style 2',
                      '3' => 'Blog style 3',
                      '4' => 'Blog style 4',
                      '5' => 'Blog style 5',
                      '6' => 'Blog style 6',
                    ));
    $page->add($setting);

    // Back to Top
    $setting = new admin_setting_configselect('theme_edumy/back_to_top',
        get_string('back_to_top', 'theme_edumy'),
        get_string('back_to_top_desc', 'theme_edumy'), null,
                array('0' => 'Visible',
                      '1' => 'Hidden'
                    ));
    $page->add($setting);


    // Favicon
    $name='theme_edumy/favicon';
    $title = get_string('favicon', 'theme_edumy');
    $description = get_string('favicon_desc', 'theme_edumy');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'favicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);

    // CCN Logo settings
    $page = new admin_settingpage('theme_edumy_logo', get_string('logo_settings', 'theme_edumy'));

    // Header logos
    $page->add(new admin_setting_heading('theme_edumy/header_logos', get_string('header_logos', 'theme_edumy'), NULL));

    // Logotype
    $setting = new admin_setting_configselect('theme_edumy/logotype',
        get_string('logotype', 'theme_edumy'),
        get_string('logotype_desc', 'theme_edumy'), null,
                array('0' => 'Visible',
                      '1' => 'Hidden'
                    ));
    $page->add($setting);

    // Logo image
    $setting = new admin_setting_configselect('theme_edumy/logo_image',
        get_string('logo_image', 'theme_edumy'),
        get_string('logo_image_desc', 'theme_edumy'), null,
                array('0' => 'Visible',
                      '1' => 'Hidden'
                    ));
    $page->add($setting);

    // Logo Image Width
    $setting = new admin_setting_configtext('theme_edumy/logo_image_width', get_string('logo_image_width','theme_edumy'), get_string('logo_image_width_desc', 'theme_edumy'), '', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Logo Image Height
    $setting = new admin_setting_configtext('theme_edumy/logo_image_height', get_string('logo_image_height','theme_edumy'), get_string('logo_image_height_desc', 'theme_edumy'), '', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Header logo 1
    $name='theme_edumy/headerlogo1';
    $title = get_string('headerlogo1', 'theme_edumy');
    $description = get_string('headerlogo1_desc', 'theme_edumy');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'headerlogo1');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Header logo 2
    $name='theme_edumy/headerlogo2';
    $title = get_string('headerlogo2', 'theme_edumy');
    $description = get_string('headerlogo2_desc', 'theme_edumy');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'headerlogo2');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Header logo 3
    $name='theme_edumy/headerlogo3';
    $title = get_string('headerlogo3', 'theme_edumy');
    $description = get_string('headerlogo3_desc', 'theme_edumy');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'headerlogo3');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Header logo mobile
    $name='theme_edumy/headerlogo_mobile';
    $title = get_string('headerlogo_mobile', 'theme_edumy');
    $description = get_string('headerlogo_mobile_desc', 'theme_edumy');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'headerlogo_mobile');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Footer logos
    $page->add(new admin_setting_heading('theme_edumy/footer_logos', get_string('footer_logos', 'theme_edumy'), NULL));

    // Logotype Footer
    $setting = new admin_setting_configselect('theme_edumy/logotype_footer',
        get_string('logotype_footer', 'theme_edumy'),
        get_string('logotype_footer_desc', 'theme_edumy'), null,
                array('0' => 'Visible',
                      '1' => 'Hidden'
                    ));
    $page->add($setting);

    // Logo image Footer
    $setting = new admin_setting_configselect('theme_edumy/logo_image_footer',
        get_string('logo_image_footer', 'theme_edumy'),
        get_string('logo_image_footer_desc', 'theme_edumy'), null,
                array('0' => 'Visible',
                      '1' => 'Hidden'
                    ));
    $page->add($setting);

    // Logo Image Width footer
    $setting = new admin_setting_configtext('theme_edumy/logo_image_width_footer', get_string('logo_image_width_footer','theme_edumy'), get_string('logo_image_width_footer_desc', 'theme_edumy'), '', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Logo Image Height footer
    $setting = new admin_setting_configtext('theme_edumy/logo_image_height_footer', get_string('logo_image_height_footer','theme_edumy'), get_string('logo_image_height_footer_desc', 'theme_edumy'), '', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Footer logo 1
    $name='theme_edumy/footerlogo1';
    $title = get_string('footerlogo1', 'theme_edumy');
    $description = get_string('footerlogo1_desc', 'theme_edumy');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'footerlogo1');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);

    // CCN Header settings
    $page = new admin_settingpage('theme_edumy_header', get_string('header_settings', 'theme_edumy'));

    // Library list
    $setting = new admin_setting_configselect('theme_edumy/library_list',
        get_string('library_list', 'theme_edumy'),
        get_string('library_list_desc', 'theme_edumy'), null,
                array('0' => 'Hidden',
                      '1' => 'Visible'
                    ));
    $page->add($setting);

    // Search
    $setting = new admin_setting_configselect('theme_edumy/header_search',
        get_string('header_search', 'theme_edumy'),
        get_string('header_search_desc', 'theme_edumy'), null,
                array('0' => 'Show icon',
                      '1' => 'Show searchbar',
                      '2' => 'Hide'
                    ));
    $page->add($setting);

    // Login
    $setting = new admin_setting_configselect('theme_edumy/header_login',
        get_string('header_login', 'theme_edumy'),
        get_string('header_login_desc', 'theme_edumy'), null,
                array('0' => 'Login popup',
                      '1' => 'Login link',
                      '2' => 'Hide'
                    ));
    $page->add($setting);

    // Menu
    $setting = new admin_setting_configselect('theme_edumy/header_main_menu',
        get_string('header_main_menu', 'theme_edumy'),
        get_string('header_main_menu_desc', 'theme_edumy'), '0',
                array('0' => 'Visible to all users',
                      '1' => 'Visible only to authenticated users'
                    ));
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Header type
    $setting = new admin_setting_configselect('theme_edumy/headertype',
        get_string('headertype', 'theme_edumy'),
        get_string('headertype_desc', 'theme_edumy'), null,
                array('1' => 'Header 1',
                      '2' => 'Header 2',
                      '3' => 'Header 3',
                      '4' => 'Header 4',
                      '5' => 'Header 5',
                      '6' => 'Header 6',
                      '7' => 'Header 7',
                      '8' => 'Header 8',
                      '9' => 'Header 9',
                      '10' => 'Header 10',
                      '11' => 'Header 11',
                      '12' => 'Header 12',
                      '13' => 'Header 13',
                      '14' => 'Header 14',
                    ));
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Header type settings
    // $setting = new admin_setting_configselect('theme_edumy/headertype_settings',
    //     get_string('headertype_settings', 'theme_edumy'),
    //     get_string('headertype_settings_desc', 'theme_edumy'), '1',
    //             array('1' => 'All pages (recommended)'
    //                 ));
    // $setting->set_updatedcallback('theme_reset_all_caches');
    // $page->add($setting);

    // Header email address
    $setting = new admin_setting_configtext('theme_edumy/email_address', get_string('email_address','theme_edumy'), get_string('email_address_desc', 'theme_edumy'), 'hello@edumy.com', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Header phone
    $setting = new admin_setting_configtext('theme_edumy/phone', get_string('phone','theme_edumy'), get_string('phone_desc', 'theme_edumy'), '(56) 123 456 789', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Call to Action Text
    $setting = new admin_setting_configtext('theme_edumy/cta_text', get_string('cta_text','theme_edumy'), get_string('cta_text_desc', 'theme_edumy'), 'Become an Instructor', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Call to Action Link
    $setting = new admin_setting_configtext('theme_edumy/cta_link', get_string('cta_link','theme_edumy'), get_string('cta_link_desc', 'theme_edumy'), '#', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Call to Action icon
    $setting = new admin_setting_configselect('theme_edumy/cta_icon_ccn_icon_class',
        get_string('cta_icon', 'theme_edumy'),
        get_string('cta_icon_desc', 'theme_edumy'), 'flaticon-megaphone', $ccnFontList);
    $page->add($setting);

    $settings->add($page);

    // CCN Breadcrumb settings
    $page = new admin_settingpage('breadcrumb_settings', get_string('breadcrumb_settings', 'theme_edumy'));
    // Breadcrumb settings
    $page->add(new admin_setting_heading('theme_edumy/breadcrumb_settings', get_string('breadcrumb_settings', 'theme_edumy'), NULL));

    // Breadcrumb background
    $name='theme_edumy/heading_bg';
    $title = get_string('heading_bg', 'theme_edumy');
    $description = get_string('heading_bg_desc', 'theme_edumy');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'heading_bg');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Breadcrumb style
    $setting = new admin_setting_configselect('theme_edumy/breadcrumb_style',
        get_string('breadcrumb_style', 'theme_edumy'),
        get_string('breadcrumb_style_desc', 'theme_edumy'), 0,
                array('0' => 'Default (large)',
                      '1' => 'Medium',
                      '2' => 'Small',
                      '3' => 'Extra small',
                      '4' => 'Hidden'
                    ));
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Breadcrumb title
    $setting = new admin_setting_configselect('theme_edumy/breadcrumb_title',
        get_string('breadcrumb_title', 'theme_edumy'),
        get_string('breadcrumb_title_desc', 'theme_edumy'), 0,
                array('0' => 'Visible',
                      '1' => 'Hidden',
                    ));
    $page->add($setting);

    // Breadcrumb trail
    $setting = new admin_setting_configselect('theme_edumy/breadcrumb_trail',
        get_string('breadcrumb_trail', 'theme_edumy'),
        get_string('breadcrumb_trail_desc', 'theme_edumy'), 0,
                array('0' => 'Visible',
                      '1' => 'Hidden',
                    ));
    $page->add($setting);

    // Breadcrumb clip text
    $setting = new admin_setting_configselect('theme_edumy/breadcrumb_clip',
        get_string('breadcrumb_clip', 'theme_edumy'),
        get_string('breadcrumb_clip_desc', 'theme_edumy'), 0,
                array('0' => 'Clip long text',
                      '1' => 'Clip very long text only',
                      '2' => 'Do not clip text',
                    ));
    $page->add($setting);

    // Breadcrumb clip text
    $setting = new admin_setting_configselect('theme_edumy/breadcrumb_clip',
        get_string('breadcrumb_clip', 'theme_edumy'),
        get_string('breadcrumb_clip_desc', 'theme_edumy'), 0,
                array('0' => 'Clip long text',
                      '1' => 'Clip very long text only',
                      '2' => 'Do not clip text',
                    ));
    $page->add($setting);

    // Breadcrumb capitalization
    $setting = new admin_setting_configselect('theme_edumy/breadcrumb_caps',
        get_string('breadcrumb_caps', 'theme_edumy'),
        get_string('breadcrumb_caps_desc', 'theme_edumy'), 0,
                array('0' => 'Capitalized',
                      '1' => 'Lowercase',
                      '2' => 'Uppercase',
                      '3' => 'None (inherit from page title)',
                    ));
    $page->add($setting);

    $settings->add($page);

    // CCN Preloader settings
    $page = new admin_settingpage('preloader_settings', get_string('preloader_settings', 'theme_edumy'));
    // Preloader settings
    $page->add(new admin_setting_heading('theme_edumy/preloader_settings', get_string('preloader_settings', 'theme_edumy'), NULL));

    // Preloader image
    $name='theme_edumy/preloader_image';
    $title = get_string('preloader_image', 'theme_edumy');
    $description = get_string('preloader_image_desc', 'theme_edumy');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'preloader_image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Preloader duration
    $setting = new admin_setting_configselect('theme_edumy/preloader_duration',
        get_string('preloader_duration', 'theme_edumy'),
        get_string('preloader_duration_desc', 'theme_edumy'), 0,
                array('0' => 'Wait for page to fully load (highly recommended)',
                      '1' => 'Wait for core elements to load',
                      '2' => 'Wait for page to fully load, but no longer than 5 seconds',
                      '3' => 'Wait for page to fully load, but no longer than 4 seconds',
                      '4' => 'Wait for page to fully load, but no longer than 3 seconds',
                      '5' => 'Wait for page to fully load, but no longer than 2 seconds',
                      '6' => 'Disable preloader (not recommended)'
                    ));
    $page->add($setting);

    $settings->add($page);

    // CCN Footer settings
    $page = new admin_settingpage('theme_edumy_footer', get_string('footer_settings', 'theme_edumy'));
    // Footer settings
    $page->add(new admin_setting_heading('theme_edumy/footer_settings', get_string('footer_settings', 'theme_edumy'), NULL));


    // Footer copyright
    $setting = new admin_setting_configtext('theme_edumy/cocoon_copyright', get_string('cocoon_copyright','theme_edumy'), get_string('cocoon_copyright_desc', 'theme_edumy'), 'Copyright © 2020 Edumy Moodle Theme by Cocoon. All Rights Reserved.', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Footer style
    $setting = new admin_setting_configselect('theme_edumy/footertype',
        get_string('footertype', 'theme_edumy'),
        get_string('footertype_desc', 'theme_edumy'), null,
                array('1' => 'Footer 1',
                      '2' => 'Footer 2',
                      '3' => 'Footer 3',
                      '4' => 'Footer 4',
                      '5' => 'Footer 5',
                      '6' => 'Footer 6',
                      '7' => 'Footer 7',
                      '8' => 'Footer 8',
                      '9' => 'Footer 9',
                    ));
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Footer column 1
    $page->add(new admin_setting_heading('theme_edumy/footer_col_1', get_string('footer_col_1', 'theme_edumy'), NULL));
    // Footer column title
    $setting = new admin_setting_configtext('theme_edumy/footer_col_1_title', get_string('footer_col_title','theme_edumy'), get_string('footer_col_title_desc', 'theme_edumy'), 'Contact', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Footer column body
    $setting = new admin_setting_configtextarea('theme_edumy/footer_col_1_body', get_string('footer_col_body','theme_edumy'), get_string('footer_col_body_desc', 'theme_edumy'), 'Body text for the first column.', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Footer column 2
    $page->add(new admin_setting_heading('theme_edumy/footer_col_2', get_string('footer_col_2', 'theme_edumy'), NULL));
    // Footer column title
    $setting = new admin_setting_configtext('theme_edumy/footer_col_2_title', get_string('footer_col_title','theme_edumy'), get_string('footer_col_title_desc', 'theme_edumy'), 'Company', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Footer column body
    $setting = new admin_setting_configtextarea('theme_edumy/footer_col_2_body', get_string('footer_col_body','theme_edumy'), get_string('footer_col_body_desc', 'theme_edumy'), 'Body text for the second column.', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Footer column 3
    $page->add(new admin_setting_heading('theme_edumy/footer_col_3', get_string('footer_col_3', 'theme_edumy'), NULL));
    // Footer column title
    $setting = new admin_setting_configtext('theme_edumy/footer_col_3_title', get_string('footer_col_title','theme_edumy'), get_string('footer_col_title_desc', 'theme_edumy'), 'Programs', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Footer column body
    $setting = new admin_setting_configtextarea('theme_edumy/footer_col_3_body', get_string('footer_col_body','theme_edumy'), get_string('footer_col_body_desc', 'theme_edumy'), 'Body text for the third column.', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Footer column 4
    $page->add(new admin_setting_heading('theme_edumy/footer_col_4', get_string('footer_col_4', 'theme_edumy'), NULL));
    // Footer column title
    $setting = new admin_setting_configtext('theme_edumy/footer_col_4_title', get_string('footer_col_title','theme_edumy'), get_string('footer_col_title_desc', 'theme_edumy'), 'Support', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Footer column body
    $setting = new admin_setting_configtextarea('theme_edumy/footer_col_4_body', get_string('footer_col_body','theme_edumy'), get_string('footer_col_body_desc', 'theme_edumy'), 'Body text for the fourth column.', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Footer column 5
    $page->add(new admin_setting_heading('theme_edumy/footer_col_5', get_string('footer_col_5', 'theme_edumy'), NULL));
    // Footer column title
    $setting = new admin_setting_configtext('theme_edumy/footer_col_5_title', get_string('footer_col_title','theme_edumy'), get_string('footer_col_title_desc', 'theme_edumy'), 'Mobile', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Footer column body
    $setting = new admin_setting_configtextarea('theme_edumy/footer_col_5_body', get_string('footer_col_body','theme_edumy'), get_string('footer_col_body_desc', 'theme_edumy'), 'Body text for the fifth column.', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Footer menu
    $page->add(new admin_setting_heading('theme_edumy/footer_menu_heading', get_string('footer_menu', 'theme_edumy'), NULL));
    // Footer menu
    $setting = new admin_setting_configtextarea('theme_edumy/footer_menu', get_string('footer_menu','theme_edumy'), get_string('footer_menu_desc', 'theme_edumy'), 'Body text for the footer menu.', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);

    // CCN Course settings
    $page = new admin_settingpage('theme_edumy_course_settings', get_string('course_settings', 'theme_edumy'));

    // General course settings
    $page->add(new admin_setting_heading('theme_edumy/general_course_settings', get_string('general_course_settings', 'theme_edumy'), NULL));

    if (class_exists('NumberFormatter')) {
      // Course price format
      $setting = new admin_setting_configselect('theme_edumy/course_price_format',
          get_string('course_price_format', 'theme_edumy'),
          get_string('course_price_format_desc', 'theme_edumy'), '6',
                  array(
                        // '0' => 'US$49',
                        // '1' => 'US$ 49',
                        // '2' => '49US$',
                        // '3' => '49 US$',
                        '4' => '49$',
                        '5' => '49 $',
                        '6' => '$49',
                        '7' => '$ 49',
                        '8' => '$49 USD',
                        '9' => '$49USD',
                        /* @ccnBreak: these are duplicates of the 0-3 without NumberFormatter */
                        '10' => 'USD 49',
                        '11' => 'USD49',
                        '12' => '49USD',
                        '13' => '49 USD',
                      ));
      $page->add($setting);
    } else {
      // Course price format
      $setting = new admin_setting_configselect('theme_edumy/course_price_format',
          get_string('course_price_format', 'theme_edumy'),
          get_string('course_price_format_desc', 'theme_edumy'), null,
                  array('0' => 'US$49',
                        '1' => 'US$ 49',
                        '2' => '49US$',
                        '3' => '49 US$',
                        '4' => '49$',
                        '5' => '49 $',
                        '6' => '$49',
                        '7' => '$ 49',
                        '8' => '$49 USD',
                        '9' => '$49USD',
                      ));
      $page->add($setting);
    }

    // Course ratings
    $setting = new admin_setting_configselect('theme_edumy/course_ratings',
        get_string('course_ratings', 'theme_edumy'),
        get_string('course_ratings_desc', 'theme_edumy'), null,
                array('0' => 'Hide all ratings',
                      '1' => 'Show decorative ratings (always 5 stars)',
                      '2' => 'Show real ratings (enable the [Cocoon] Course Ratings block on course pages)',
                    ));
    $page->add($setting);

    // Modified on courses & course categories
    $setting = new admin_setting_configselect('theme_edumy/coursecat_modified',
        get_string('coursecat_modified', 'theme_edumy'),
        get_string('coursecat_modified_desc', 'theme_edumy'), 0,
                array('0' => 'Visible',
                      '1' => 'Hidden',
                    ));
    $page->add($setting);

    // Enrolements on Courses & course categories
    $setting = new admin_setting_configselect('theme_edumy/coursecat_enrolments',
        get_string('coursecat_enrolments', 'theme_edumy'),
        get_string('coursecat_enrolments_desc', 'theme_edumy'), 0,
                array('0' => 'Visible',
                      '1' => 'Hidden',
                    ));
    $page->add($setting);

    // Announcements on Course categories
    $setting = new admin_setting_configselect('theme_edumy/coursecat_announcements',
        get_string('coursecat_announcements', 'theme_edumy'),
        get_string('coursecat_announcements_desc', 'theme_edumy'), 0,
                array('0' => 'Visible',
                      '1' => 'Hidden',
                    ));
    $page->add($setting);

    // Prices on Course categories
    $setting = new admin_setting_configselect('theme_edumy/coursecat_prices',
        get_string('coursecat_prices', 'theme_edumy'),
        get_string('coursecat_prices_desc', 'theme_edumy'), 0,
                array('0' => 'Visible',
                      '1' => 'Hidden',
                    ));
    $page->add($setting);

    // Category settings
    $page->add(new admin_setting_heading('theme_edumy/coursecat_settings', get_string('coursecat_settings', 'theme_edumy'), NULL));

    // Course list style
    $setting = new admin_setting_configselect('theme_edumy/courseliststyle',
        get_string('courseliststyle', 'theme_edumy'),
        get_string('courseliststyle_desc', 'theme_edumy'), null,
                array('1' => 'Grid',
                      '2' => 'List'
                    ));
    $page->add($setting);

    // Single Course settings
    $page->add(new admin_setting_heading('theme_edumy/course_settings', get_string('single_course_settings', 'theme_edumy'), NULL));

    // Single Course Style
    $setting = new admin_setting_configselect('theme_edumy/course_single_style',
        get_string('course_single_style', 'theme_edumy'),
        get_string('course_single_style_desc', 'theme_edumy'), 0,
                array('0' => 'Course v1',
                      '1' => 'Course v2',
                      '2' => 'Course v3',
                    ));
    $page->add($setting);

    // Course Enrolment Settings
    $setting = new admin_setting_configselect('theme_edumy/course_enrolment_payment',
        get_string('course_enrolment_payment', 'theme_edumy'),
        get_string('course_enrolment_payment_desc', 'theme_edumy'), 0,
                array('0' => 'All courses require payment',
                      '1' => 'Some courses are free',
                    ));
    $page->add($setting);

    // Single Course Block Settings
    $setting = new admin_setting_configselect('theme_edumy/singlecourse_blocks',
        get_string('singlecourse_blocks', 'theme_edumy'),
        get_string('singlecourse_blocks_desc', 'theme_edumy'), 0,
                array('0' => 'Show on all pages of the course (Moodle default)',
                      '1' => 'Show only on the main course page'
                    ));
    $page->add($setting);

    // Course Start Date
    $setting = new admin_setting_configselect('theme_edumy/course_start_date',
        get_string('course_start_date', 'theme_edumy'),
        get_string('course_start_date_desc', 'theme_edumy'), 0,
                array('0' => 'Visible',
                      '1' => 'Hidden'
                    ));
    $page->add($setting);

    // Course Category
    $setting = new admin_setting_configselect('theme_edumy/course_category',
        get_string('course_category', 'theme_edumy'),
        get_string('course_category_desc', 'theme_edumy'), 0,
                array('0' => 'Visible',
                      '1' => 'Hidden'
                    ));
    $page->add($setting);

     // Enroled access to course content only
    $setting = new admin_setting_configselect('theme_edumy/course_content_enroled_only',
        get_string('course_content_enroled_only', 'theme_edumy'),
        get_string('course_content_enroled_only_desc', 'theme_edumy'), 0,
                array('0' => 'Display course content to anyone with viewing access to the course',
                      '1' => 'Display course content only to enroled users, course creators, managers and administrators',
                    ));
    $page->add($setting);

    // Topics format settings
    $page->add(new admin_setting_heading('theme_edumy/course_settings_topics_format', get_string('course_settings_topics_format', 'theme_edumy'), NULL));

    // Collapsible settings
    $setting = new admin_setting_configselect('theme_edumy/topics_format_collapsible',
        get_string('topics_format_collapsible', 'theme_edumy'),
        get_string('topics_format_collapsible_desc', 'theme_edumy'), null,
                array('0' => 'All collapsed by default',
                      '1' => 'All collapsed, first expanded',
                      '2' => 'All expanded by default',
                      '3' => 'All expanded and not collapsible',
                    ));
    $page->add($setting);

    // Activity module settings
    $page->add(new admin_setting_heading('theme_edumy/course_settings_activities', get_string('course_settings_activities', 'theme_edumy'), NULL));

  // Quiz layout
    $setting = new admin_setting_configselect('theme_edumy/quiz_layout',
        get_string('quiz_layout', 'theme_edumy'),
        get_string('quiz_layout_desc', 'theme_edumy'), null,
                array('0' => 'Quiz navigation: Top',
                      '1' => 'Quiz navigation: Right',
                    ));
    $page->add($setting);

    $settings->add($page);

    // CCN Social settings
    $page = new admin_settingpage('theme_edumy_social_settings', get_string('social_settings', 'theme_edumy'));

    // New Window
    $setting = new admin_setting_configselect('theme_edumy/social_target',
        get_string('social_target', 'theme_edumy'),
        get_string('social_target_desc', 'theme_edumy'), null,
                array('0' => 'Open URLs in the same page',
                      '1' => 'Open URLs in a new window'
                    ));
    $page->add($setting);

    // Facebook URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_facebook_url', get_string('cocoon_facebook_url','theme_edumy'), get_string('cocoon_facebook_url_desc', 'theme_edumy'), '#', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Twitter URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_twitter_url', get_string('cocoon_twitter_url','theme_edumy'), get_string('cocoon_twitter_url_desc', 'theme_edumy'), '#', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Instagram URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_instagram_url', get_string('cocoon_instagram_url','theme_edumy'), get_string('cocoon_instagram_url_desc', 'theme_edumy'), '#', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Pinterest URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_pinterest_url', get_string('cocoon_pinterest_url','theme_edumy'), get_string('cocoon_pinterest_url_desc', 'theme_edumy'), '#', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Dribbble URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_dribbble_url', get_string('cocoon_dribbble_url','theme_edumy'), get_string('cocoon_dribbble_url_desc', 'theme_edumy'), '#', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Google URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_google_url', get_string('cocoon_google_url','theme_edumy'), get_string('cocoon_google_url_desc', 'theme_edumy'), '#', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // YouTube URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_youtube_url', get_string('cocoon_youtube_url','theme_edumy'), get_string('cocoon_youtube_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // VK URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_vk_url', get_string('cocoon_vk_url','theme_edumy'), get_string('cocoon_vk_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // 500px URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_500px_url', get_string('cocoon_500px_url','theme_edumy'), get_string('cocoon_500px_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Behance URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_behance_url', get_string('cocoon_behance_url','theme_edumy'), get_string('cocoon_behance_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Digg URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_digg_url', get_string('cocoon_digg_url','theme_edumy'), get_string('cocoon_digg_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Flickr URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_flickr_url', get_string('cocoon_flickr_url','theme_edumy'), get_string('cocoon_flickr_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Foursquare URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_foursquare_url', get_string('cocoon_foursquare_url','theme_edumy'), get_string('cocoon_foursquare_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // LinkedIn URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_linkedin_url', get_string('cocoon_linkedin_url','theme_edumy'), get_string('cocoon_linkedin_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Medium URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_medium_url', get_string('cocoon_medium_url','theme_edumy'), get_string('cocoon_medium_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Meetup URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_meetup_url', get_string('cocoon_meetup_url','theme_edumy'), get_string('cocoon_meetup_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Snapchat URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_snapchat_url', get_string('cocoon_snapchat_url','theme_edumy'), get_string('cocoon_snapchat_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Tumblr URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_tumblr_url', get_string('cocoon_tumblr_url','theme_edumy'), get_string('cocoon_tumblr_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Vimeo URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_vimeo_url', get_string('cocoon_vimeo_url','theme_edumy'), get_string('cocoon_vimeo_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // WeChat URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_wechat_url', get_string('cocoon_wechat_url','theme_edumy'), get_string('cocoon_wechat_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // WhatsApp URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_whatsapp_url', get_string('cocoon_whatsapp_url','theme_edumy'), get_string('cocoon_whatsapp_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // WordPress URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_wordpress_url', get_string('cocoon_wordpress_url','theme_edumy'), get_string('cocoon_wordpress_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Weibo URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_weibo_url', get_string('cocoon_weibo_url','theme_edumy'), get_string('cocoon_weibo_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Telegram URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_telegram_url', get_string('cocoon_telegram_url','theme_edumy'), get_string('cocoon_telegram_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Moodle URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_moodle_url', get_string('cocoon_moodle_url','theme_edumy'), get_string('cocoon_moodle_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Amazon URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_amazon_url', get_string('cocoon_amazon_url','theme_edumy'), get_string('cocoon_amazon_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Slideshare URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_slideshare_url', get_string('cocoon_slideshare_url','theme_edumy'), get_string('cocoon_slideshare_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // SoundCloud URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_soundcloud_url', get_string('cocoon_soundcloud_url','theme_edumy'), get_string('cocoon_soundcloud_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // LeanPub URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_leanpub_url', get_string('cocoon_leanpub_url','theme_edumy'), get_string('cocoon_leanpub_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Xing URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_xing_url', get_string('cocoon_xing_url','theme_edumy'), get_string('cocoon_xing_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Bitcoin URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_bitcoin_url', get_string('cocoon_bitcoin_url','theme_edumy'), get_string('cocoon_bitcoin_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Twitch URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_twitch_url', get_string('cocoon_twitch_url','theme_edumy'), get_string('cocoon_twitch_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Github URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_github_url', get_string('cocoon_github_url','theme_edumy'), get_string('cocoon_github_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Gitlab URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_gitlab_url', get_string('cocoon_gitlab_url','theme_edumy'), get_string('cocoon_gitlab_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Forumbee URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_forumbee_url', get_string('cocoon_forumbee_url','theme_edumy'), get_string('cocoon_forumbee_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Trello URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_trello_url', get_string('cocoon_trello_url','theme_edumy'), get_string('cocoon_trello_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Weixin URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_weixin_url', get_string('cocoon_weixin_url','theme_edumy'), get_string('cocoon_weixin_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Slack URL
    $setting = new admin_setting_configtext('theme_edumy/cocoon_slack_url', get_string('cocoon_slack_url','theme_edumy'), get_string('cocoon_slack_url_desc', 'theme_edumy'), null, PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);


    $settings->add($page);

    // CCN Color settings
    $page = new admin_settingpage('theme_edumy_color', get_string('color_settings', 'theme_edumy'));

    // Title: Gradients
    $page->add(new admin_setting_heading('theme_edumy/color_settings_gradient', get_string('color_settings_gradient', 'theme_edumy'), NULL));

    // Gradient Start
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_gradient_start', get_string('color_gradient_start','theme_edumy'), get_string('color_gradient_start_desc', 'theme_edumy'), '#ff1053');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Gradient End
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_gradient_end', get_string('color_gradient_end','theme_edumy'), get_string('color_gradient_end_desc', 'theme_edumy'), '#3452ff');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Title: Main colors
    $page->add(new admin_setting_heading('theme_edumy/color_settings_main', get_string('color_settings_main', 'theme_edumy'), NULL));

    // Primary Color
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_primary', get_string('color_primary','theme_edumy'), get_string('color_primary_desc', 'theme_edumy'), '#2441e7');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Primary Color Alternate
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_primary_alternate', get_string('color_primary_alternate','theme_edumy'), get_string('color_primary_alternate_desc', 'theme_edumy'), '#192675');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Secondary Color
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_secondary', get_string('color_secondary','theme_edumy'), get_string('color_secondary_desc', 'theme_edumy'), '#ff1053');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Tertiary Color
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_tertiary', get_string('color_tertiary','theme_edumy'), get_string('color_tertiary_desc', 'theme_edumy'), '#6c757d');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Accent Color
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_accent', get_string('color_accent','theme_edumy'), get_string('color_accent_desc', 'theme_edumy'), '#e35a9a');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Accent Color 2
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_accent_2', get_string('color_accent_2','theme_edumy'), get_string('color_accent_2_desc', 'theme_edumy'), '#c75533');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Accent Color 3
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_accent_3', get_string('color_accent_3','theme_edumy'), get_string('color_accent_3_desc', 'theme_edumy'), '#192675');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Accent Color 4
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_accent_4', get_string('color_accent_4','theme_edumy'), get_string('color_accent_4_desc', 'theme_edumy'), '#f0d078');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Parallax Color
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_parallax', get_string('color_parallax','theme_edumy'), get_string('color_parallax_desc', 'theme_edumy'), '#2441e7');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Title: Header Style 2
    $page->add(new admin_setting_heading('theme_edumy/color_settings_header_style_2', get_string('color_settings_header_style_2', 'theme_edumy'), NULL));

    // Header Style 2: Header Top
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_header_style_2_top', get_string('color_header_color_top','theme_edumy'), get_string('color_header_color_top_desc', 'theme_edumy'), '#000');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Header Style 2: Header Bottom
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_header_style_2_bottom', get_string('color_header_color_bottom','theme_edumy'), get_string('color_header_color_bottom_desc', 'theme_edumy'), '#141414');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Title: Header Style 3
    $page->add(new admin_setting_heading('theme_edumy/color_settings_header_style_3', get_string('color_settings_header_style_3', 'theme_edumy'), NULL));

    // Header Style 3: Header Top
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_header_style_3_top', get_string('color_header_color_top','theme_edumy'), get_string('color_header_color_top_desc', 'theme_edumy'), '#051925');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Title: Header Style 4
    $page->add(new admin_setting_heading('theme_edumy/color_settings_header_style_4', get_string('color_settings_header_style_4', 'theme_edumy'), NULL));

    // Header Style 4: Header Top
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_header_style_4_top', get_string('color_header_color_top','theme_edumy'), get_string('color_header_color_top_desc', 'theme_edumy'), '#3452ff');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Title: Header Style 5
    $page->add(new admin_setting_heading('theme_edumy/color_settings_header_style_5', get_string('color_settings_header_style_5', 'theme_edumy'), NULL));

    // Header Style 5
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_header_style_5', get_string('color_header_color','theme_edumy'), get_string('color_header_color_desc', 'theme_edumy'), '#ffffff');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Title: Header Style 6
    $page->add(new admin_setting_heading('theme_edumy/color_settings_header_style_6', get_string('color_settings_header_style_6', 'theme_edumy'), NULL));

    // Header Style 6: Header Top
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_header_style_6_top', get_string('color_header_color_top','theme_edumy'), get_string('color_header_color_top_desc', 'theme_edumy'), '#3452ff');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);


    // Title: Footer Style 1
    $page->add(new admin_setting_heading('theme_edumy/color_settings_footer_style_1', get_string('color_settings_footer_style_1', 'theme_edumy'), NULL));

    // Footer Style 1: Footer Top
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_footer_style_1_top', get_string('color_footer_color_top','theme_edumy'), get_string('color_footer_color_top_desc', 'theme_edumy'), '#151515');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Footer Style 1: Footer Bottom
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_footer_style_1_bottom', get_string('color_footer_color_bottom','theme_edumy'), get_string('color_footer_color_bottom_desc', 'theme_edumy'), '#0a0a0a');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Title: Footer Style 2
    $page->add(new admin_setting_heading('theme_edumy/color_settings_footer_style_2', get_string('color_settings_footer_style_2', 'theme_edumy'), NULL));

    // Footer Style 2: Footer Top
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_footer_style_2_top', get_string('color_footer_color_top','theme_edumy'), get_string('color_footer_color_top_desc', 'theme_edumy'), '#f9fafc');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Footer Style 2: Footer Bottom
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_footer_style_2_bottom', get_string('color_footer_color_bottom','theme_edumy'), get_string('color_footer_color_bottom_desc', 'theme_edumy'), '#ebeef4');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Title: Footer Style 3
    $page->add(new admin_setting_heading('theme_edumy/color_settings_footer_style_3', get_string('color_settings_footer_style_3', 'theme_edumy'), NULL));

    // Footer Style 3: Footer Top
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_footer_style_3_top', get_string('color_footer_color_top','theme_edumy'), get_string('color_footer_color_top_desc', 'theme_edumy'), '#f9fafc');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Footer Style 3: Footer Middle
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_footer_style_3_middle', get_string('color_footer_color_middle','theme_edumy'), get_string('color_footer_color_middle_desc', 'theme_edumy'), '#ffffff');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Footer Style 3: Footer Bottom
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_footer_style_3_bottom', get_string('color_footer_color_bottom','theme_edumy'), get_string('color_footer_color_bottom_desc', 'theme_edumy'), '#fafafa');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Title: Footer Style 5
    $page->add(new admin_setting_heading('theme_edumy/color_settings_footer_style_5', get_string('color_settings_footer_style_5', 'theme_edumy'), NULL));

    // Footer Style 5: Footer Top
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_footer_style_5_top', get_string('color_footer_color_top','theme_edumy'), get_string('color_footer_color_top_desc', 'theme_edumy'), '#0d2f81');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Footer Style 5: Footer Bottom
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_footer_style_5_bottom', get_string('color_footer_color_bottom','theme_edumy'), get_string('color_footer_color_bottom_desc', 'theme_edumy'), '#072670');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Title: Footer Style 6
    $page->add(new admin_setting_heading('theme_edumy/color_settings_footer_style_6', get_string('color_settings_footer_style_6', 'theme_edumy'), NULL));

    // Footer Style 6: Footer All
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_footer_style_6_all', get_string('color_footer_color','theme_edumy'), get_string('color_footer_color_desc', 'theme_edumy'), '#3f4449');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Title: Footer Style 7
    $page->add(new admin_setting_heading('theme_edumy/color_settings_footer_style_7', get_string('color_settings_footer_style_7', 'theme_edumy'), NULL));

    // Footer Style 7: Footer Top
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_footer_style_7_top', get_string('color_footer_color_top','theme_edumy'), get_string('color_footer_color_top_desc', 'theme_edumy'), '#ffffff');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Footer Style 7: Footer Bottom
    $setting = new admin_setting_configcolourpicker('theme_edumy/color_footer_style_7_bottom', get_string('color_footer_color_bottom','theme_edumy'), get_string('color_footer_color_bottom_desc', 'theme_edumy'), '#ffffff');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);



    $settings->add($page);

    // CCN Dashboard settings
    $page = new admin_settingpage('theme_edumy_dashboard', get_string('dashboard_settings', 'theme_edumy'));

    // Title: Dashboard settings
    $page->add(new admin_setting_heading('theme_edumy/dashboard_settings', get_string('dashboard_settings_long', 'theme_edumy'), NULL));

    // Dashboard header
    $setting = new admin_setting_configselect('theme_edumy/dashboard_header',
        get_string('dashboard_header', 'theme_edumy'),
        get_string('dashboard_header_desc', 'theme_edumy'), 0,
                array('0' => 'Gradient',
                      '1' => 'White'
                    ));
    $page->add($setting);

    // Sticky header
    $setting = new admin_setting_configselect('theme_edumy/dashboard_sticky_header',
        get_string('dashboard_sticky_header', 'theme_edumy'),
        get_string('dashboard_sticky_header_desc', 'theme_edumy'), 0,
                array('0' => 'Stick to top',
                      '1' => 'Scroll with page'
                    ));
    $page->add($setting);

    // Sticky left drawer
    $setting = new admin_setting_configselect('theme_edumy/dashboard_sticky_drawer',
        get_string('dashboard_sticky_drawer', 'theme_edumy'),
        get_string('dashboard_sticky_drawer_desc', 'theme_edumy'), 0,
                array('0' => 'Stick to side',
                      '1' => 'Scroll with page'
                    ));
    $page->add($setting);

    // Dashboard left drawer
    $setting = new admin_setting_configselect('theme_edumy/dashboard_left_drawer',
        get_string('dashboard_left_drawer', 'theme_edumy'),
        get_string('dashboard_left_drawer_desc', 'theme_edumy'), 0,
                array('0' => 'User menu (default)',
                      '3' => 'Moodle drawer navigation',
                      '1' => 'Only show blocks from "Sidebar Left" region',
                      '2' => 'Disable left drawer'
                    ));
    $page->add($setting);

    // Dashboard Breadcrumb clip text
    $setting = new admin_setting_configselect('theme_edumy/breadcrumb_clip_dash',
        get_string('breadcrumb_clip', 'theme_edumy'),
        get_string('breadcrumb_clip_desc', 'theme_edumy'), 0,
                array('0' => 'Clip long text',
                      '1' => 'Clip very long text only',
                      '2' => 'Do not clip text',
                    ));
    $page->add($setting);

    // Title: Dashboard tablet 1
    $page->add(new admin_setting_heading('theme_edumy/dashboard_tablet_1', get_string('dashboard_tablet_1', 'theme_edumy'), NULL));

    // Dashboard tablet visibility
    $setting = new admin_setting_configselect('theme_edumy/dashboard_tablet_1_visibility',
        get_string('config_visibility', 'theme_edumy'),
        get_string('config_visibility_desc', 'theme_edumy'), 0,
                array('0' => 'Show tablet',
                      '1' => 'Hide tablet'
                    ));
    $page->add($setting);

    // Dashboard tablet title
    $setting = new admin_setting_configtext('theme_edumy/dashboard_tablet_1_title', get_string('config_title','theme_edumy'), get_string('config_title_desc', 'theme_edumy'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Dashboard tablet subtitle
    $setting = new admin_setting_configtext('theme_edumy/dashboard_tablet_1_subtitle', get_string('config_subtitle','theme_edumy'), get_string('config_subtitle_desc', 'theme_edumy'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Dashboard tablet URL
    $setting = new admin_setting_configtext('theme_edumy/dashboard_tablet_1_url', get_string('config_link','theme_edumy'), get_string('config_link_desc', 'theme_edumy'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Dashboard tablet color
    $setting = new admin_setting_configcolourpicker('theme_edumy/dashboard_tablet_1_color', get_string('config_color','theme_edumy'), get_string('config_color_desc', 'theme_edumy'), '#2441e7');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Dashboard tablet icon
    $setting = new admin_setting_configselect('theme_edumy/dashboard_tablet_1_ccn_icon_class',
        get_string('config_icon_class', 'theme_edumy'),
        get_string('config_icon_class_desc', 'theme_edumy'), 'flaticon-speech-bubble', $ccnFontList);
    $page->add($setting);

    // Title: Dashboard tablet 2
    $page->add(new admin_setting_heading('theme_edumy/dashboard_tablet_2', get_string('dashboard_tablet_2', 'theme_edumy'), NULL));

    // Dashboard tablet visibility
    $setting = new admin_setting_configselect('theme_edumy/dashboard_tablet_2_visibility',
        get_string('config_visibility', 'theme_edumy'),
        get_string('config_visibility_desc', 'theme_edumy'), 0,
                array('0' => 'Show tablet',
                      '1' => 'Hide tablet'
                    ));
    $page->add($setting);

    // Dashboard tablet title
    $setting = new admin_setting_configtext('theme_edumy/dashboard_tablet_2_title', get_string('config_title','theme_edumy'), get_string('config_title_desc', 'theme_edumy'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Dashboard tablet subtitle
    $setting = new admin_setting_configtext('theme_edumy/dashboard_tablet_2_subtitle', get_string('config_subtitle','theme_edumy'), get_string('config_subtitle_desc', 'theme_edumy'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Dashboard tablet URL
    $setting = new admin_setting_configtext('theme_edumy/dashboard_tablet_2_url', get_string('config_link','theme_edumy'), get_string('config_link_desc', 'theme_edumy'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Dashboard tablet color
    $setting = new admin_setting_configcolourpicker('theme_edumy/dashboard_tablet_2_color', get_string('config_color','theme_edumy'), get_string('config_color_desc', 'theme_edumy'), '#ff1053');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Dashboard tablet icon
    $setting = new admin_setting_configselect('theme_edumy/dashboard_tablet_2_ccn_icon_class',
        get_string('config_icon_class', 'theme_edumy'),
        get_string('config_icon_class_desc', 'theme_edumy'), 'flaticon-cap', $ccnFontList);
    $page->add($setting);

    // Title: Dashboard tablet 3
    $page->add(new admin_setting_heading('theme_edumy/dashboard_tablet_3', get_string('dashboard_tablet_3', 'theme_edumy'), NULL));

    // Dashboard tablet visibility
    $setting = new admin_setting_configselect('theme_edumy/dashboard_tablet_3_visibility',
        get_string('config_visibility', 'theme_edumy'),
        get_string('config_visibility_desc', 'theme_edumy'), 0,
                array('0' => 'Show tablet',
                      '1' => 'Hide tablet'
                    ));
    $page->add($setting);

    // Dashboard tablet title
    $setting = new admin_setting_configtext('theme_edumy/dashboard_tablet_3_title', get_string('config_title','theme_edumy'), get_string('config_title_desc', 'theme_edumy'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Dashboard tablet subtitle
    $setting = new admin_setting_configtext('theme_edumy/dashboard_tablet_3_subtitle', get_string('config_subtitle','theme_edumy'), get_string('config_subtitle_desc', 'theme_edumy'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Dashboard tablet URL
    $setting = new admin_setting_configtext('theme_edumy/dashboard_tablet_3_url', get_string('config_link','theme_edumy'), get_string('config_link_desc', 'theme_edumy'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Dashboard tablet color
    $setting = new admin_setting_configcolourpicker('theme_edumy/dashboard_tablet_3_color', get_string('config_color','theme_edumy'), get_string('config_color_desc', 'theme_edumy'), '#00a78e');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Dashboard tablet icon
    $setting = new admin_setting_configselect('theme_edumy/dashboard_tablet_3_ccn_icon_class',
        get_string('config_icon_class', 'theme_edumy'),
        get_string('config_icon_class_desc', 'theme_edumy'), 'flaticon-settings', $ccnFontList);
    $page->add($setting);

    // Title: Dashboard tablet 4
    $page->add(new admin_setting_heading('theme_edumy/dashboard_tablet_4', get_string('dashboard_tablet_4', 'theme_edumy'), NULL));

    // Dashboard tablet visibility
    $setting = new admin_setting_configselect('theme_edumy/dashboard_tablet_4_visibility',
        get_string('config_visibility', 'theme_edumy'),
        get_string('config_visibility_desc', 'theme_edumy'), 0,
                array('0' => 'Show tablet',
                      '1' => 'Hide tablet'
                    ));
    $page->add($setting);

    // Dashboard tablet title
    $setting = new admin_setting_configtext('theme_edumy/dashboard_tablet_4_title', get_string('config_title','theme_edumy'), get_string('config_title_desc', 'theme_edumy'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Dashboard tablet subtitle
    $setting = new admin_setting_configtext('theme_edumy/dashboard_tablet_4_subtitle', get_string('config_subtitle','theme_edumy'), get_string('config_subtitle_desc', 'theme_edumy'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Dashboard tablet URL
    $setting = new admin_setting_configtext('theme_edumy/dashboard_tablet_4_url', get_string('config_link','theme_edumy'), get_string('config_link_desc', 'theme_edumy'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Dashboard tablet color
    $setting = new admin_setting_configcolourpicker('theme_edumy/dashboard_tablet_4_color', get_string('config_color','theme_edumy'), get_string('config_color_desc', 'theme_edumy'), '#ecd06f');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Dashboard tablet icon
    $setting = new admin_setting_configselect('theme_edumy/dashboard_tablet_4_ccn_icon_class',
        get_string('config_icon_class', 'theme_edumy'),
        get_string('config_icon_class_desc', 'theme_edumy'), 'flaticon-rating', $ccnFontList);
    $page->add($setting);



    $settings->add($page);

    // CCN User settings
    $page = new admin_settingpage('theme_edumy_user_settings', get_string('user_settings', 'theme_edumy'));

    // Login pages

    // Login Layout
    $setting = new admin_setting_configselect('theme_edumy/login_layout',
        get_string('login_layout', 'theme_edumy'),
        get_string('login_layout_desc', 'theme_edumy'), 0,
                array('0' => 'Style 1 (default)',
                      '1' => 'Style 2',
                      '2' => 'Style 3',
                      '3' => 'Style 4',
                    ));
    $page->add($setting);

    // Breadcrumb background
    $name='theme_edumy/login_bg';
    $title = get_string('login_bg', 'theme_edumy');
    $description = get_string('login_bg_desc', 'theme_edumy');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'login_bg');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Navigation icon
    $page->add(new admin_setting_heading('theme_edumy/navigation_icon', get_string('navigation_icon', 'theme_edumy'), NULL));

    $setting = new admin_setting_configselect('theme_edumy/navigation_icon_visibility',
        get_string('config_visibility', 'theme_edumy'),
        get_string('config_visibility_desc', 'theme_edumy'), 0,
                array('0' => 'Visible',
                      '1' => 'Hidden'
                    ));
    $page->add($setting);

    $setting = new admin_setting_configselect('theme_edumy/navigation_icon_ccn_icon_class',
        get_string('config_icon_class', 'theme_edumy'),
        get_string('config_icon_class_desc', 'theme_edumy'), 'flaticon-settings', $ccnFontList);
    $page->add($setting);

    // Notification icon
    $page->add(new admin_setting_heading('theme_edumy/notification_icon', get_string('notification_icon', 'theme_edumy'), NULL));

    $setting = new admin_setting_configselect('theme_edumy/notification_icon_visibility',
        get_string('config_visibility', 'theme_edumy'),
        get_string('config_visibility_desc', 'theme_edumy'), 0,
                array('0' => 'Visible',
                      '1' => 'Hidden'
                    ));
    $page->add($setting);

    $setting = new admin_setting_configselect('theme_edumy/notification_icon_ccn_icon_class',
        get_string('config_icon_class', 'theme_edumy'),
        get_string('config_icon_class_desc', 'theme_edumy'), 'flaticon-alarm', $ccnFontList);
    $page->add($setting);

    // Messages icon
    $page->add(new admin_setting_heading('theme_edumy/messages_icon', get_string('messages_icon', 'theme_edumy'), NULL));

    $setting = new admin_setting_configselect('theme_edumy/messages_icon_visibility',
        get_string('config_visibility', 'theme_edumy'),
        get_string('config_visibility_desc', 'theme_edumy'), 0,
                array('0' => 'Visible',
                      '1' => 'Hidden'
                    ));
    $page->add($setting);

    $setting = new admin_setting_configselect('theme_edumy/messages_icon_ccn_icon_class',
        get_string('config_icon_class', 'theme_edumy'),
        get_string('config_icon_class_desc', 'theme_edumy'), 'flaticon-speech-bubble', $ccnFontList);
    $page->add($setting);

    // Navigation icon
    $page->add(new admin_setting_heading('theme_edumy/dark_mode_icon', get_string('dark_mode_icon', 'theme_edumy'), NULL));

    $setting = new admin_setting_configselect('theme_edumy/dark_mode_icon_visibility',
        get_string('config_visibility', 'theme_edumy'),
        get_string('config_visibility_desc', 'theme_edumy'), 0,
                array('0' => 'Visible',
                      '1' => 'Hidden'
                    ));
    $page->add($setting);

    $setting = new admin_setting_configselect('theme_edumy/dark_mode_icon_ccn_icon_class',
        get_string('config_icon_class', 'theme_edumy'),
        get_string('config_icon_class_desc', 'theme_edumy'), 'ccn-flaticon-hide', $ccnFontList);
    $page->add($setting);


    // Profile icon
    $page->add(new admin_setting_heading('theme_edumy/profile_icon', get_string('profile_icon', 'theme_edumy'), NULL));

    $setting = new admin_setting_configselect('theme_edumy/profile_icon_username',
        get_string('profile_icon_username', 'theme_edumy'),
        get_string('profile_icon_username_desc', 'theme_edumy'), 0,
                array('0' => 'Username',
                      '1' => 'Full name'
                    ));
    $page->add($setting);

    // Order receipts
    $page->add(new admin_setting_heading('theme_edumy/order_receipts', get_string('order_receipts', 'theme_edumy'), NULL));

    $setting = new admin_setting_configtext('theme_edumy/order_receipt_address_line_1', get_string('address_line_1','theme_edumy'), get_string('address_line_1_desc', 'theme_edumy'), '1 Trafalgar Square', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $setting = new admin_setting_configtext('theme_edumy/order_receipt_address_line_2', get_string('address_line_2','theme_edumy'), get_string('address_line_2_desc', 'theme_edumy'), 'Westminster', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $setting = new admin_setting_configtext('theme_edumy/order_receipt_address_line_3', get_string('address_line_3','theme_edumy'), get_string('address_line_3_desc', 'theme_edumy'), 'Central London', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $setting = new admin_setting_configtext('theme_edumy/order_receipt_zip', get_string('zip_code','theme_edumy'), get_string('zip_code_desc', 'theme_edumy'), 'SW1 3EJ', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $setting = new admin_setting_configtext('theme_edumy/order_receipt_phone', get_string('phone','theme_edumy'), get_string('phone_desc', 'theme_edumy'), '+133-424-481-500', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $setting = new admin_setting_configtext('theme_edumy/order_receipt_email', get_string('email_address','theme_edumy'), get_string('email_address_desc', 'theme_edumy'), 'orders@edumylearning.edu', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Display Custom Fields in General Section
    // $setting = new admin_setting_configselect('theme_edumy/user_custf_other',
    //     get_string('user_custf_other', 'theme_edumy'),
    //     get_string('user_custf_other_desc', 'theme_edumy'), 0,
    //             array('0' => 'Default (Moodle default)',
    //                   '1' => 'In "General" section'
    //                 ));
    // $page->add($setting);

    $settings->add($page);

    // Fonts
    $page = new admin_settingpage('theme_edumy_fonts', get_string('font_settings', 'theme_edumy'));

    // Google Fonts
    $page->add(new admin_setting_heading('theme_edumy/google_fonts', get_string('google_fonts', 'theme_edumy'), NULL));

    // Primary Font
    $setting = new admin_setting_configselect('theme_edumy/primary_font',
        get_string('primary_font', 'theme_edumy'),
        get_string('primary_font_desc', 'theme_edumy'), null,
                array('0' => 'Nunito',
                      '1' => 'Dosis',
                      '2' => 'Lato',
                      '3' => 'Maven Pro',
                      '4' => 'Montserrat',
                      '5' => 'Open Sans',
                      '6' => 'Playfair Display',
                      '7' => 'Poppins',
                      '8' => 'Raleway',
                      '9' => 'Roboto',
                      '10' => 'Lora',
                      '11' => 'Oxygen',
                    ));
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Secondary Font
    $setting = new admin_setting_configselect('theme_edumy/secondary_font',
        get_string('secondary_font', 'theme_edumy'),
        get_string('secondary_font_desc', 'theme_edumy'), 5,
                array('0' => 'Nunito',
                      '1' => 'Dosis',
                      '2' => 'Lato',
                      '3' => 'Maven Pro',
                      '4' => 'Montserrat',
                      '5' => 'Open Sans',
                      '6' => 'Playfair Display',
                      '7' => 'Poppins',
                      '8' => 'Raleway',
                      '9' => 'Roboto',
                      '10' => 'Lora',
                      '11' => 'Oxygen',
                    ));
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Custom Primary Fonts
    $page->add(new admin_setting_heading('theme_edumy/custom_font_primary', get_string('custom_font_primary', 'theme_edumy'), NULL));

    // Upload font EOT
    $name='theme_edumy/upload_font_eot';
    $title = get_string('upload_font_eot', 'theme_edumy');
    $description = get_string('upload_font_eot_desc', 'theme_edumy');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'upload_font_eot', 0, array('maxfiles' => 1, 'accepted_types' => array('.eot')) );
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Upload font WOFF2
    $name='theme_edumy/upload_font_woff2';
    $title = get_string('upload_font_woff2', 'theme_edumy');
    $description = get_string('upload_font_woff2_desc', 'theme_edumy');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'upload_font_woff2', 0, array('maxfiles' => 1, 'accepted_types' => array('.woff2')) );
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Upload font WOFF
    $name='theme_edumy/upload_font_woff';
    $title = get_string('upload_font_woff', 'theme_edumy');
    $description = get_string('upload_font_woff_desc', 'theme_edumy');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'upload_font_woff', 0, array('maxfiles' => 1, 'accepted_types' => array('.woff')) );
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Upload font TTF
    $name='theme_edumy/upload_font_ttf';
    $title = get_string('upload_font_ttf', 'theme_edumy');
    $description = get_string('upload_font_ttf_desc', 'theme_edumy');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'upload_font_ttf', 0, array('maxfiles' => 1, 'accepted_types' => array('.ttf')) );
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Upload font SVG
    $name='theme_edumy/upload_font_svg';
    $title = get_string('upload_font_svg', 'theme_edumy');
    $description = get_string('upload_font_svg_desc', 'theme_edumy');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'upload_font_svg', 0, array('maxfiles' => 1, 'accepted_types' => array('.svg')) );
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Custom Secondary Fonts
    $page->add(new admin_setting_heading('theme_edumy/custom_font_secondary', get_string('custom_font_secondary', 'theme_edumy'), NULL));

    // Upload font EOT
    $name='theme_edumy/upload_font_secondary_eot';
    $title = get_string('upload_font_eot', 'theme_edumy');
    $description = get_string('upload_font_eot_desc', 'theme_edumy');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'upload_font_secondary_eot', 0, array('maxfiles' => 1, 'accepted_types' => array('.eot')) );
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Upload font WOFF2
    $name='theme_edumy/upload_font_secondary_woff2';
    $title = get_string('upload_font_woff2', 'theme_edumy');
    $description = get_string('upload_font_woff2_desc', 'theme_edumy');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'upload_font_secondary_woff2', 0, array('maxfiles' => 1, 'accepted_types' => array('.woff2')) );
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Upload font WOFF
    $name='theme_edumy/upload_font_secondary_woff';
    $title = get_string('upload_font_woff', 'theme_edumy');
    $description = get_string('upload_font_woff_desc', 'theme_edumy');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'upload_font_secondary_woff', 0, array('maxfiles' => 1, 'accepted_types' => array('.woff')) );
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Upload font TTF
    $name='theme_edumy/upload_font_secondary_ttf';
    $title = get_string('upload_font_ttf', 'theme_edumy');
    $description = get_string('upload_font_ttf_desc', 'theme_edumy');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'upload_font_secondary_ttf', 0, array('maxfiles' => 1, 'accepted_types' => array('.ttf')) );
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Upload font SVG
    $name='theme_edumy/upload_font_secondary_svg';
    $title = get_string('upload_font_svg', 'theme_edumy');
    $description = get_string('upload_font_svg_desc', 'theme_edumy');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'upload_font_secondary_svg', 0, array('maxfiles' => 1, 'accepted_types' => array('.svg')) );
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);



    // CCN Layout settings
    $page = new admin_settingpage('theme_edumy_layout', get_string('layout_settings', 'theme_edumy'));

    // Dashboard Layout
    $setting = new admin_setting_configselect('theme_edumy/dashboard_layout',
        get_string('dashboard_layout', 'theme_edumy'),
        get_string('dashboard_layout_desc', 'theme_edumy'), 0,
                array('0' => 'Edumy Dashboard (default)',
                      '1' => 'Edumy',
                    ));
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Course Main Page Layout
    $setting = new admin_setting_configselect('theme_edumy/coursemainpage_layout',
        get_string('coursemainpage_layout', 'theme_edumy'),
        get_string('coursemainpage_layout_desc', 'theme_edumy'), 0,
                array('0' => 'Edumy (default) - recommended',
                      '1' => 'Edumy Dashboard for enrolled users only',
                      '2' => 'Edumy Dashboard for all users',
                      '3' => 'Edumy Focus for enrolled users only',
                      '4' => 'Edumy Focus for all users',
                    ));
    $page->add($setting);

    // Inner Course Page Layout
    $setting = new admin_setting_configselect('theme_edumy/incourse_layout',
        get_string('incourse_layout', 'theme_edumy'),
        get_string('incourse_layout_desc', 'theme_edumy'), 0,
                array('0' => 'Edumy (default)',
                      '1' => 'Edumy Dashboard',
                      '2' => 'Edumy Focus'
                    ));
    $page->add($setting);

    // Profile Page Layout
    $setting = new admin_setting_configselect('theme_edumy/user_profile_layout',
        get_string('user_profile_layout', 'theme_edumy'),
        get_string('user_profile_layout_desc', 'theme_edumy'), 0,
                array('0' => 'Edumy (default)',
                      '1' => 'Edumy Dashboard'
                    ));
    $page->add($setting);


    $settings->add($page);

    // CCN Optimization
    $page = new admin_settingpage('theme_edumy_optimization', get_string('optimization_settings', 'theme_edumy'));

    // Lazy Loading
    $setting = new admin_setting_configselect('theme_edumy/lazy_loading',
        get_string('lazy_loading', 'theme_edumy'),
        get_string('lazy_loading_desc', 'theme_edumy'), 0,
                array('0' => 'Yes (default)',
                      '1' => 'No',
                    ));
    $page->add($setting);

    $settings->add($page);

    // CCN Advanced settings
    $page = new admin_settingpage('theme_edumy_advanced', get_string('advanced_settings', 'theme_edumy'));
    // Google Maps API Key
    $setting = new admin_setting_configtext('theme_edumy/gmaps_key', get_string('gmaps_key','theme_edumy'), get_string('gmaps_key_desc', 'theme_edumy'), '', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Custom CSS
    $setting = new admin_setting_configtextarea('theme_edumy/custom_css', get_string('custom_css','theme_edumy'), get_string('custom_css_desc', 'theme_edumy'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Custom CSS Dashboard
    $setting = new admin_setting_configtextarea('theme_edumy/custom_css_dashboard', get_string('custom_css_dashboard','theme_edumy'), get_string('custom_css_dashboard_desc', 'theme_edumy'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Custom JavaScript
    $setting = new admin_setting_configtextarea('theme_edumy/custom_js', get_string('custom_js','theme_edumy'), get_string('custom_js_desc', 'theme_edumy'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Custom JavaScript Dashboard
    $setting = new admin_setting_configtextarea('theme_edumy/custom_js_dashboard', get_string('custom_js_dashboard','theme_edumy'), get_string('custom_js_dashboard_desc', 'theme_edumy'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Blog Post Author
    $setting = new admin_setting_configselect('theme_edumy/blog_post_author',
        get_string('blog_post_author', 'theme_edumy'),
        get_string('blog_post_author_desc', 'theme_edumy'), null,
                array('0' => 'Visible',
                      '1' => 'Hidden'
                    ));
    $page->add($setting);

    // Blog Post Date
    $setting = new admin_setting_configselect('theme_edumy/blog_post_date',
        get_string('blog_post_date', 'theme_edumy'),
        get_string('blog_post_date_desc', 'theme_edumy'), null,
                array('0' => 'Visible',
                      '1' => 'Hidden'
                    ));
    $page->add($setting);

    // Page Settings button
    $setting = new admin_setting_configselect('theme_edumy/page_settings_controls',
        get_string('page_settings_controls', 'theme_edumy'),
        get_string('page_settings_controls_desc', 'theme_edumy'), null,
                array('0' => 'Moodle default (visible based on permissions)',
                      '1' => 'Visible only to course creators, managers and administrators'
                    ));
    $page->add($setting);

    // Google Maps API Key
    $setting = new admin_setting_configtext('theme_edumy/logo_url', get_string('logo_url','theme_edumy'), get_string('logo_url_desc', 'theme_edumy'), '', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);


    // Title: Icons
    $page->add(new admin_setting_heading('theme_edumy/icons', get_string('icons', 'theme_edumy'), get_string('icons_desc', 'theme_edumy')));

    $setting = new admin_setting_configcheckbox('theme_edumy/iconset_edumy',
        get_string('iconset_edumy', 'theme_edumy'),
        '', 1);
    $page->add($setting);

    $setting = new admin_setting_configcheckbox('theme_edumy/iconset_cocoon',
        get_string('iconset_cocoon', 'theme_edumy'),
        '', 1);
    $page->add($setting);

    $setting = new admin_setting_configcheckbox('theme_edumy/iconset_fontawesome',
        get_string('iconset_fontawesome', 'theme_edumy'),
        '', 1);
    $page->add($setting);

    $setting = new admin_setting_configcheckbox('theme_edumy/iconset_lineawesome',
        get_string('iconset_lineawesome', 'theme_edumy'),
        '', 1);
    $page->add($setting);




    // // Reduced Icon set
    // $setting = new admin_setting_configselect('theme_edumy/reduced_iconset',
    //     get_string('reduced_iconset', 'theme_edumy'),
    //     get_string('reduced_iconset_desc', 'theme_edumy'), '0',
    //             array('0' => 'Provide all Edumy icons (Default)',
    //                   '1' => 'Provide a reduced set of Edumy icons'
    //                 ));
    // $page->add($setting);


    // Title: SEO
    $page->add(new admin_setting_heading('theme_edumy/seo', get_string('seo', 'theme_edumy'), NULL));

    // Meta Description
    $setting = new admin_setting_configtextarea('theme_edumy/meta_description', get_string('meta_description','theme_edumy'), get_string('meta_description_desc', 'theme_edumy'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Meta Abstract
    $setting = new admin_setting_configtextarea('theme_edumy/meta_abstract', get_string('meta_abstract','theme_edumy'), get_string('meta_abstract_desc', 'theme_edumy'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Meta Keywords
    $setting = new admin_setting_configtext('theme_edumy/meta_keywords', get_string('meta_keywords','theme_edumy'), get_string('meta_keywords_desc', 'theme_edumy'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);


    // Title: For Developers
    $page->add(new admin_setting_heading('theme_edumy/for_developers', get_string('for_developers', 'theme_edumy'), get_string('for_developers_desc', 'theme_edumy')));

    // Expose blocks to all pages
    $setting = new admin_setting_configselect('theme_edumy/dev_expose_blocks',
        get_string('dev_expose_blocks', 'theme_edumy'),
        get_string('dev_expose_blocks_desc', 'theme_edumy'), '0',
                array('0' => 'No (default & highly recommended)',
                      '1' => 'Yes (for developer use only)'
                    ));
    $page->add($setting);

    $settings->add($page);

}
