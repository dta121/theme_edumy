<?php
/*
@ccnRef: @template block_globalsearch
*/
defined('MOODLE_INTERNAL') || die();

$_ccnglobalsearch_navbar = '';

if (\core_search\manager::is_global_search_enabled() === false) {
    $_ccnglobalsearch_navbar .= get_string('globalsearchdisabled', 'search');
}

$url = new moodle_url('/search/index.php');

$_ccnglobalsearch_navbar .= html_writer::start_tag('form', array('class' => 'form-inline mailchimp_form','action' => $url->out()));
$_ccnglobalsearch_navbar .= html_writer::start_tag('fieldset');

// Input.
$inputoptions = array('id' => 'searchform_search', 'name' => 'q', 'class' => 'form-control mb-2 mr-sm-2', 'placeholder' => get_string('search_string', 'theme_edumy'), 'type' => 'text', 'size' => '15');
$_ccnglobalsearch_navbar .= html_writer::empty_tag('input', $inputoptions);

// Context id.
if ($this->page->context && $this->page->context->contextlevel !== CONTEXT_SYSTEM) {
    $_ccnglobalsearch_navbar .= html_writer::empty_tag('input', ['type' => 'hidden', 'name' => 'context', 'value' => $this->page->context->id]);
}

// Search button.
// $_ccnglobalsearch_navbar .= '<button type="submit" class="btn btn-primary mb-2"><span class="flaticon-magnifying-glass"></span></button>';
$_ccnglobalsearch_navbar .= '<button type="submit" class="btn mb-2"><span class="flaticon-magnifying-glass"></span></button>';
$_ccnglobalsearch_navbar .= html_writer::end_tag('fieldset');
$_ccnglobalsearch_navbar .= html_writer::end_tag('form');
