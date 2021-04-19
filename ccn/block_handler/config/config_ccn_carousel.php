<?php
/*
@ccnRef: @block_cocoon
*/

defined('MOODLE_INTERNAL') || die();

if(!empty($this->config->ccn_carousel_autoplay)){
  $this->content->ccn_carousel_autoplay = $this->config->ccn_carousel_autoplay;
} else {
  $this->content->ccn_carousel_autoplay = '0';
}

if(!empty($this->config->ccn_carousel_autoplay_timeout)){
  $this->content->ccn_carousel_autoplay_timeout = $this->config->ccn_carousel_autoplay_timeout;
} else {
  $this->content->ccn_carousel_autoplay_timeout = '3000';
}

if(!empty($this->config->ccn_carousel_speed)){
  $this->content->ccn_carousel_speed = $this->config->ccn_carousel_speed;
} else {
  $this->content->ccn_carousel_speed = '1000';
}

if(!empty($this->config->ccn_carousel_autoplay_pause)){
  $this->content->ccn_carousel_autoplay_pause = $this->config->ccn_carousel_autoplay_pause;
} else {
  $this->content->ccn_carousel_autoplay_pause = '0';
}

if(!empty($this->config->ccn_carousel_loop)){
  $this->content->ccn_carousel_loop = $this->config->ccn_carousel_loop;
} else {
  $this->content->ccn_carousel_loop = '1';
}

if(!empty($this->config->ccn_carousel_lazyload)){
  $this->content->ccn_carousel_lazyload = $this->config->ccn_carousel_lazyload;
} else {
  $this->content->ccn_carousel_lazyload = '0';
}

if(!empty($this->config->ccn_carousel_animateout)){
  $this->content->ccn_carousel_animateout = $this->config->ccn_carousel_animateout;
} else {
  $this->content->ccn_carousel_animateout = 'fadeOut';
}

if(!empty($this->config->ccn_carousel_animatein)){
  $this->content->ccn_carousel_animatein = $this->config->ccn_carousel_animatein;
} else {
  $this->content->ccn_carousel_animatein = 'fadeIn';
}

$ccnConfigDataCarousel = '
   data-ccn-id="'.$this->instance->id.'"
   data-ccn-caro-ap="'.$this->content->ccn_carousel_autoplay.'"
   data-ccn-caro-ap-to="'.$this->content->ccn_carousel_autoplay_timeout.'"
   data-ccn-caro-ap-p="'.$this->content->ccn_carousel_autoplay_pause.'"
   data-ccn-caro-s="'.$this->content->ccn_carousel_speed.'"
   data-ccn-caro-l="'.$this->content->ccn_carousel_loop.'"
   data-ccn-caro-ll="'.$this->content->ccn_carousel_lazyload.'"
   data-ccn-caro-ao="'.$this->content->ccn_carousel_animateout.'"
   data-ccn-caro-ai="'.$this->content->ccn_carousel_animatein.'"
';
