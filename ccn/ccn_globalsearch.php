<?php
/*
@ccnRef: @template block_globalsearch
*/
defined('MOODLE_INTERNAL') || die();

$_ccnglobalsearch = '';

if (\core_search\manager::is_global_search_enabled() === false) {
    $_ccnglobalsearch .= get_string('globalsearchdisabled', 'search');
}

$url = new moodle_url('/search/index.php');

$_ccnglobalsearch .= html_writer::start_tag('form', array('class' => 'ccn-mk-fullscreen-searchform','action' => $url->out()));
$_ccnglobalsearch .= html_writer::start_tag('fieldset');

// Input.
$inputoptions = array('id' => 'searchform_search', 'name' => 'q', 'class' => 'ccn-mk-fullscreen-search-input', 'placeholder' => get_string('search_courses', 'theme_edumy'),
    'type' => 'text', 'size' => '15');
$_ccnglobalsearch .= html_writer::empty_tag('input', $inputoptions);

// Context id.
if ($this->page->context && $this->page->context->contextlevel !== CONTEXT_SYSTEM) {
    $_ccnglobalsearch .= html_writer::empty_tag('input', ['type' => 'hidden',
            'name' => 'context', 'value' => $this->page->context->id]);
}

// Search button.
$_ccnglobalsearch .= '<i class="flaticon-magnifying-glass fullscreen-search-icon"><input value="" type="submit" id="searchform_button"></i>';
$_ccnglobalsearch .= html_writer::end_tag('fieldset');
$_ccnglobalsearch .= html_writer::end_tag('form');
