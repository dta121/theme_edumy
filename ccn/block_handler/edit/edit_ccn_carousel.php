<?php
/*
@ccnRef: @block_cocoon/edit_form.php
*/

defined('MOODLE_INTERNAL') || die();
$mform->addElement('header', 'config_cocoon_carousel', get_string('cocoon_carousel_settings', 'theme_edumy'));

//#ccnComm autoplay
$options = array(
    '0' => 'False',
    '1' => 'True',
  );
$select = $mform->addElement('select', 'config_ccn_carousel_autoplay', get_string('config_ccn_carousel_autoplay', 'theme_edumy'), $options);
$select->setSelected('0');

//#ccnComm autoplayTimeout
$options = array(
    '100' => '100ms',
    '200' => '200ms',
    '300' => '300ms',
    '400' => '400ms',
    '500' => '500ms',
    '600' => '600ms',
    '700' => '700ms',
    '800' => '800ms',
    '900' => '900ms',
    '1000' => '1000ms',
    '1500' => '1500ms',
    '2000' => '2000ms',
    '2500' => '2500ms',
    '3000' => '3000ms',
    '3500' => '3500ms',
    '4000' => '4000ms',
    '4500' => '4500ms',
    '5000' => '5000ms',
    '5500' => '5500ms',
    '6000' => '6000ms',
    '6500' => '6500ms',
    '7000' => '7000ms',
    '7500' => '7500ms',
    '8000' => '8000ms',
    '8500' => '8500ms',
    '9000' => '9000ms',
    '9500' => '9500ms',
    '10000' => '10000ms',
    '11000' => '11000ms',
    '12000' => '12000ms',
    '13000' => '13000ms',
    '14000' => '14000ms',
    '15000' => '15000ms',
  );
$select = $mform->addElement('select', 'config_ccn_carousel_autoplay_timeout', get_string('config_ccn_carousel_autoplay_timeout', 'theme_edumy'), $options);
$select->setSelected('3000');

//#ccnComm smartSpeed
$options = array(
    '100' => '100ms',
    '200' => '200ms',
    '300' => '300ms',
    '400' => '400ms',
    '500' => '500ms',
    '600' => '600ms',
    '700' => '700ms',
    '800' => '800ms',
    '900' => '900ms',
    '1000' => '1000ms',
    '1500' => '1500ms',
    '2000' => '2000ms',
    '2500' => '2500ms',
    '3000' => '3000ms',
    '3500' => '3500ms',
    '4000' => '4000ms',
    '4500' => '4500ms',
    '5000' => '5000ms',
    '5500' => '5500ms',
    '6000' => '6000ms',
    '6500' => '6500ms',
    '7000' => '7000ms',
    '7500' => '7500ms',
    '8000' => '8000ms',
    '8500' => '8500ms',
    '9000' => '9000ms',
    '9500' => '9500ms',
    '10000' => '10000ms',
    '11000' => '11000ms',
    '12000' => '12000ms',
    '13000' => '13000ms',
    '14000' => '14000ms',
    '15000' => '15000ms',
  );
$select = $mform->addElement('select', 'config_ccn_carousel_speed', get_string('config_ccn_carousel_speed', 'theme_edumy'), $options);
$select->setSelected('1000');

//#ccnComm autoplayHoverPause
$options = array(
    '0' => 'No',
    '1' => 'Yes',
  );
$select = $mform->addElement('select', 'config_ccn_carousel_autoplay_pause', get_string('config_ccn_carousel_autoplay_pause', 'theme_edumy'), $options);
$select->setSelected('0');

//#ccnComm loop
$options = array(
    '0' => 'No',
    '1' => 'Yes',
  );
$select = $mform->addElement('select', 'config_ccn_carousel_loop', get_string('config_ccn_carousel_loop', 'theme_edumy'), $options);
$select->setSelected('1');

//#ccnComm lazyLoad
$options = array(
    '0' => 'No',
    '1' => 'Yes',
  );
$select = $mform->addElement('select', 'config_ccn_carousel_lazyload', get_string('config_ccn_carousel_lazyload', 'theme_edumy'), $options);
$select->setSelected('0');

//#ccnComm animateOut
$options = array(
    'fadeOut' => 'fadeOut',
    'backOutDown' => 'backOutDown',
    'backOutLeft' => 'backOutLeft',
    'backOutRight' => 'backOutRight',
    'backOutUp' => 'backOutUp',
    'bounceOut' => 'bounceOut',
    'bounceOutDown' => 'bounceOutDown',
    'bounceOutLeft' => 'bounceOutLeft',
    'bounceOutRight' => 'bounceOutRight',
    'bounceOutUp' => 'bounceOutUp',
    'fadeOutDown' => 'fadeOutDown',
    'fadeOutDownBig' => 'fadeOutDownBig',
    'fadeOutLeft' => 'fadeOutLeft',
    'fadeOutLeftBig' => 'fadeOutLeftBig',
    'fadeOutRight' => 'fadeOutRight',
    'fadeOutRightBig' => 'fadeOutRightBig',
    'fadeOutUp' => 'fadeOutUp',
    'fadeOutUpBig' => 'fadeOutUpBig',
    'fadeOutTopLeft' => 'fadeOutTopLeft',
    'fadeOutTopRight' => 'fadeOutTopRight',
    'fadeOutBottomRight' => 'fadeOutBottomRight',
    'fadeOutBottomLeft' => 'fadeOutBottomLeft',
    'flipOutX' => 'flipOutX',
    'flipOutY' => 'flipOutY',
    'lightSpeedOutRight' => 'lightSpeedOutRight',
    'rotateOut' => 'rotateOut',
    'rotateOutDownLeft' => 'rotateOutDownLeft',
    'rotateOutDownRight' => 'rotateOutDownRight',
    'rotateOutUpLeft' => 'rotateOutUpLeft',
    'rotateOutUpRight' => 'rotateOutUpRight',
    'rollOut' => 'rollOut',
    'zoomOut' => 'zoomOut',
    'zoomOutDown' => 'zoomOutDown',
    'zoomOutLeft' => 'zoomOutLeft',
    'zoomOutRight' => 'zoomOutRight',
    'zoomOutUp' => 'zoomOutUp',
    'slideOutDown' => 'slideOutDown',
    'slideOutLeft' => 'slideOutLeft',
    'slideOutRight' => 'slideOutRight',
    'slideOutUp' => 'slideOutUp',
  );
$select = $mform->addElement('select', 'config_ccn_carousel_animateout', get_string('config_ccn_carousel_animateout', 'theme_edumy'), $options);
$select->setSelected('fadeOut');

//#ccnComm animateIn
$options = array(
    'fadeIn' => 'fadeIn',
    'backInDown' => 'backInDown',
    'backInLeft' => 'backInLeft',
    'backInRight' => 'backInRight',
    'backInUp' => 'backInUp',
    'bounceIn' => 'bounceIn',
    'bounceInDown' => 'bounceInDown',
    'bounceInLeft' => 'bounceInLeft',
    'bounceInRight' => 'bounceInRight',
    'bounceInUp' => 'bounceInUp',
    'fadeInDown' => 'fadeInDown',
    'fadeInDownBig' => 'fadeInDownBig',
    'fadeInLeft' => 'fadeInLeft',
    'fadeInLeftBig' => 'fadeInLeftBig',
    'fadeInRight' => 'fadeInRight',
    'fadeInRightBig' => 'fadeInRightBig',
    'fadeInUp' => 'fadeInUp',
    'fadeInUpBig' => 'fadeInUpBig',
    'fadeInTopLeft' => 'fadeInTopLeft',
    'fadeInTopRight' => 'fadeInTopRight',
    'fadeInBottomRight' => 'fadeInBottomRight',
    'fadeInBottomLeft' => 'fadeInBottomLeft',
    'flipInX' => 'flipInX',
    'flipInY' => 'flipInY',
    'lightSpeedInRight' => 'lightSpeedInRight',
    'rotateIn' => 'rotateIn',
    'rotateInDownLeft' => 'rotateInDownLeft',
    'rotateInDownRight' => 'rotateInDownRight',
    'rotateInUpLeft' => 'rotateInUpLeft',
    'rotateInUpRight' => 'rotateInUpRight',
    'rollIn' => 'rollIn',
    'zoomIn' => 'zoomIn',
    'zoomInDown' => 'zoomInDown',
    'zoomInLeft' => 'zoomInLeft',
    'zoomInRight' => 'zoomInRight',
    'zoomInUp' => 'zoomInUp',
    'slideInDown' => 'slideInDown',
    'slideInLeft' => 'slideInLeft',
    'slideInRight' => 'slideInRight',
    'slideInUp' => 'slideInUp',
  );
$select = $mform->addElement('select', 'config_ccn_carousel_animatein', get_string('config_ccn_carousel_animatein', 'theme_edumy'), $options);
$select->setSelected('fadeIn');
