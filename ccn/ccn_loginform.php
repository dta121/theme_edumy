<?php
/*
@ccnRef: @template block_login
*/

defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/authlib.php');

if (signup_is_enabled()) {
    $signup = $CFG->wwwroot . '/login/signup.php';
}
$forgot = $CFG->wwwroot . '/login/forgot_password.php';
$username = get_moodle_cookie();
$_ccnlogin = '';
if (!isloggedin() or isguestuser()) {   // Show the block
    if (empty($CFG->authloginviaemail)) {
        $strusername = get_string('username');
    } else {
        $strusername = get_string('usernameemail');
    }
    $_ccnlogin .= "\n".'<form class="loginform" id="login" method="post" action="'.get_login_url().'">';

    $_ccnlogin .= '<div class="form-group">';
    $_ccnlogin .= '<input type="text" name="username" placeholder="'.get_string('username', 'theme_edumy').'" id="login_username" ';
    $_ccnlogin .= ' class="form-control" value="'.s($username).'" autocomplete="username"/></div>';

    $_ccnlogin .= '<div class="form-group">';

    $_ccnlogin .= '<input type="password" name="password" id="login_password" placeholder="'.get_string('password', 'theme_edumy').'" ';
    $_ccnlogin .= ' class="form-control" value="" autocomplete="current-password"/>';
    $_ccnlogin .= '</div>';

    if (isset($CFG->rememberusername) and $CFG->rememberusername == 2) {
        $checked = $username ? 'checked="checked"' : '';

        $_ccnlogin .='
                              <div class="form-group custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="rememberusername" id="rememberusername">
                                <label class="custom-control-label" for="rememberusername">'.get_string('rememberusername', 'admin').'</label>
                                <a class="tdu btn-fpswd float-right" href="'.$forgot.'">'.get_string('forgotaccount').'</a>
                              </div>';

        /*$_ccnlogin .= '<div class="form-check">';
        $_ccnlogin .= '<label class="form-check-label">';
        $_ccnlogin .= '<input type="checkbox" name="rememberusername" id="rememberusername"
                class="form-check-input" value="1" '.$checked.'/> ';
        $_ccnlogin .= get_string('rememberusername', 'admin').'</label>';
        $_ccnlogin .= '</div>'; */
    }

    $_ccnlogin .= '<button type="submit" class="btn btn-log btn-block btn-thm2">'.get_string('login').'</button>';
    $_ccnlogin .= '<input type="hidden" name="logintoken" value="'.s(\core\session\manager::get_login_token()).'" />';

    $_ccnlogin .= "</form>\n";

    /* if (!empty($signup)) {
        $_ccnlogin .= '<div><a href="'.$signup.'">'.get_string('startsignup').'</a></div>';
    } */
   /* if (!empty($forgot)) {
        $_ccnlogin .= '<div><a href="'.$forgot.'">'.get_string('forgotaccount').'</a></div>';
    } */

    $authsequence = get_enabled_auth_plugins(true); // Get all auths, in sequence.
    $potentialidps = array();
    foreach ($authsequence as $authname) {
        $authplugin = get_auth_plugin($authname);
        $potentialidps = array_merge($potentialidps, $authplugin->loginpage_idp_list($this->page->url->out(false)));
    }

    if (!empty($potentialidps)) {
        $_ccnlogin .= '<div class="potentialidps">';
        $_ccnlogin .= '<h6>' . get_string('potentialidps', 'auth') . '</h6>';
        $_ccnlogin .= '<div class="potentialidplist">';
        foreach ($potentialidps as $idp) {
            $_ccnlogin .= '<div class="potentialidp">';
            $_ccnlogin .= '<a class="btn btn-secondary btn-block" ';
            $_ccnlogin .= 'href="' . $idp['url']->out() . '" title="' . s($idp['name']) . '">';
            if (!empty($idp['iconurl'])) {
                $_ccnlogin .= '<img src="' . s($idp['iconurl']) . '" width="24" height="24" class="mr-1"/>';
            }
            $_ccnlogin .= s($idp['name']) . '</a></div>';
        }
        $_ccnlogin .= '</div>';
        $_ccnlogin .= '</div>';
    }
}
/* Login */
