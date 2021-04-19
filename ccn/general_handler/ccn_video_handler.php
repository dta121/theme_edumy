<?php
/*
@ccnRef: @ VIDEO HANDLER
*/

defined('MOODLE_INTERNAL') || die();

class ccnVideoHandler {
  public function ccnVideoEmbedHandler($videoUrl) {
    global $CFG, $COURSE, $USER, $DB, $SESSION, $SITE, $PAGE, $OUTPUT;

    if(!empty($videoUrl)){
      if (strpos($videoUrl, 'youtube.com/watch?v=') !== false) {
        $vidID = substr($videoUrl, strpos($videoUrl, 'watch?v=') + strlen('watch?v='));
        $vidID = strtok($vidID, '&');
        $vidURL = 'https://www.youtube.com/embed/'.$vidID;
      } elseif (strpos($videoUrl, 'youtu.be') !== false) {
        $vidID = substr($videoUrl, strpos($videoUrl, '.be/') + strlen('.be/'));
        $vidID = strtok($vidID, '&');
        $vidURL = 'https://www.youtube.com/embed/'.$vidID;
      } elseif (strpos($videoUrl, 'youtube.com/embed') !== false) {
        $vidID = substr($videoUrl, strpos($videoUrl, 'embed/') + strlen('embed/'));
        $vidID = strtok($vidID, '/');
        $vidURL = 'https://www.youtube.com/embed/'.$vidID;
      } elseif (strpos($videoUrl, 'vimeo.com/') !== false) {
        $vidID = substr($videoUrl, strpos($videoUrl, '.com/') + strlen('.com/'));
        $vidID = strtok($vidID, '?');
        $vidURL = 'https://player.vimeo.com/video/'.$vidID.'?autoplay=1&loop=0&title=0&color=fff';
      } else {
        $vidURL = null;
      }
      return $vidURL;
    }
    return null;
  }
}
