<?php
/*
@ccnRef: @block_cocoon/block.php
*/

defined('MOODLE_INTERNAL') || die();

$ccn_mt = '';
$ccn_mb = '';
$ccn_pt = '';
$ccn_pb = '';
$ccn_css_class = '';

if(!empty($this->config->ccn_margin_top)){
  if($this->config->ccn_margin_top == '0') {
    $ccn_mt = '';
  } elseif($this->config->ccn_margin_top == 'zero') {
    $ccn_mt = 'margin-top:0px;';
  } else {
    $ccn_mt = 'margin-top:'.$this->config->ccn_margin_top.'px;';
  }
}
if(!empty($this->config->ccn_margin_bottom)){
  $ccn_mb = 'margin-bottom:'.$this->config->ccn_margin_bottom.'px;';
} else {
  $ccn_mb = '';
}
if(!empty($this->config->ccn_padding_top)){
  $ccn_pt = 'padding-top:'.$this->config->ccn_padding_top.'px;';
} else {
  $ccn_pt = '';
}
if(!empty($this->config->ccn_padding_bottom)){
  $ccn_pb = 'padding-bottom:'.$this->config->ccn_padding_bottom.'px;';
} else {
  $ccn_pb = '';
}
if(!empty($this->config->ccn_css_class)){
  $ccn_css_class = $this->config->ccn_css_class;
} else {
  $ccn_css_class = '';
}


$ccn_stylize = $ccn_mt . $ccn_mb . $ccn_pt . $ccn_pb;





$attributes['ccn_style'] = $ccn_stylize;
// $attributes['class'] .= ' block_'. $this->name();
$attributes['class'] .= ' '. $ccn_css_class;
