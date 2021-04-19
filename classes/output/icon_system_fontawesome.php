<?php
namespace theme_edumy\output;

use renderer_base;
use pix_icon;

defined('MOODLE_INTERNAL') || die();

class icon_system_fontawesome extends \core\output\icon_system_fontawesome {
public function get_core_icon_map() {
    $iconmap = parent::get_core_icon_map();

    global $PAGE;
    $settings = $PAGE->theme->settings;

    $overrides = Array(
      'core:t/messages' => (($i = $settings->messages_icon_ccn_icon_class) ? $i : 'flaticon-speech-bubble'),
      'core:t/message' => (($i = $settings->messages_icon_ccn_icon_class) ? $i : 'flaticon-speech-bubble'),
      'core:i/notifications' => (($i = $settings->notification_icon_ccn_icon_class) ? $i : 'flaticon-alarm'),
      'core:i/course' => 'flaticon-graduation-cap',
      'core:i/courseevent' => 'flaticon-graduation-cap',
      'core:i/group' => 'ccn-flaticon-users-1',
      'core:i/users' => 'ccn-flaticon-users-1',
      'core:t/cohort' => 'ccn-flaticon-users-1',
      'core:i/badge' => 'flaticon-medal',
      'core:i/competencies' => 'ccn-flaticon-star',
      'core:i/grades' => 'flaticon-rating',
      'core:i/home' => 'ccn-flaticon-home',
      'core:i/dashboard' => 'flaticon-puzzle-1',
      'core:i/scheduled' => 'flaticon-calendar-1',
      'core:a/add_file' => 'ccn-flaticon-document',
      'core:b/document-new' => 'ccn-flaticon-document',
      'core:e/new_document' => 'ccn-flaticon-document',
      'theme:fp/add_file' => 'ccn-flaticon-document',
      'core:i/privatefiles' => 'ccn-flaticon-document',
      'core:t/preferences' => 'flaticon-settings',
      'core:i/addblock' => 'ccn-flaticon-app',
      'core:i/nosubcat' => 'ccn-flaticon-app',
      'core:i/withsubcat' => 'ccn-flaticon-app',
      'core:i/open' => 'ccn-flaticon-folder-11',
      'core:i/section' => 'ccn-flaticon-folder-11',
      'core:a/create_folder' => 'ccn-flaticon-folder-11',
      'theme:fp/create_folder' => 'ccn-flaticon-folder-11',
      'core:e/insert_date' => 'flaticon-calendar-1',
      'core:i/calendar' => 'flaticon-calendar-1',
      'core:i/scheduled' => 'flaticon-appointment',
      'core:b/edit-delete' => 'ccn-flaticon-trash',
      'core:i/delete' => 'ccn-flaticon-trash',
      'core:i/trash' => 'ccn-flaticon-trash',
      'core:t/delete' => 'ccn-flaticon-trash',
      'core:b/edit-delete' => 'ccn-flaticon-trash',
      'core:i/settings' => 'flaticon-settings',
      'core:t/contextmenu' => 'flaticon-settings',
      'core:t/dropdown' => 'flaticon-settings',
      'core:t/edit_menu' => 'flaticon-settings',
      'core:t/edit' => 'flaticon-settings',
      'core:i/contentbank' => 'flaticon-edit',
      'core:i/dragdrop' => 'la la-arrows',
      'core:i/move_2d' => 'la la-arrows',
      'theme:fp/help' => 'ccn-flaticon-info',
      'core:help' => 'ccn-flaticon-info text-info',
      'core:a/help' => 'ccn-flaticon-info text-info',
      'core:e/help' => 'ccn-flaticon-info',
      'core:req' => 'ccn-flaticon-warning text-danger',
      'core:e/prevent_autolink' => 'ccn-flaticon-warning',
      'core:i/caution' => 'ccn-flaticon-warning text-warning',
      'core:i/expired' => 'ccn-flaticon-warning text-warning',
      'core:i/incorrect' => 'ccn-flaticon-warning',
      'core:i/risk_config' => 'ccn-flaticon-warning text-muted',
      // 'core:i/risk_managetrust' => 'fa-exclamation-triangle text-warning',
      // 'core:i/risk_personal' => 'fa-exclamation-circle text-info',
      'core:i/risk_spam' => 'ccn-flaticon-warning text-primary',
      // 'core:i/risk_xss' => 'fa-exclamation-triangle text-danger',
      'core:i/warning' => 'ccn-flaticon-warning text-warning',
    );

    $merged = array_merge($iconmap, $overrides);

    return $merged;
}

}
