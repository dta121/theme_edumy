<?php
/*
@ccnRef: @ COURSE HANDLER
*/

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot .'/blog/lib.php');
require_once($CFG->dirroot .'/blog/locallib.php');

class ccnBlogHandler {
  public function ccnGetPostDetails($postId) {
    global $CFG, $COURSE, $USER, $DB, $SESSION, $SITE, $PAGE, $OUTPUT;

    $postId = (int)$postId;
    if ($DB->record_exists('post', array('id' => $postId, 'module' => 'blog'))) {

      $blogPost = new blog_entry($postId);

      $blogPostCreated = userdate($blogPost->created, get_string('strftimedatefullshort', 'langconfig'));
      $blogPostCreatedYear = userdate($blogPost->created,'%Y', 0);
      $blogPostCreatedMonth = userdate($blogPost->created, '%B', 0);
      $blogPostCreatedMonthShort = userdate($blogPost->created, '%b', 0);
      $blogPostCreatedDay = userdate($blogPost->created, '%d', 0);
      $blogPostUpdated = userdate($blogPost->lastmodified, get_string('strftimedatefullshort', 'langconfig'));
      $blogPostTitle = format_text($blogPost->subject, FORMAT_HTML, array('filter' => true));
      $blogPostBody = format_text($blogPost->summary, FORMAT_HTML, array('filter' => true));
      $blogPostSummary = substr(format_string($blogPost->summary, $striplinks = true,$options = null),0,100).'...';
      $blogPostUrl = new moodle_url('/blog/index.php', array('entryid' => $postId));

      $ccnPost = new stdClass();
      /* Map data */
      $ccnPost->postId = $postId;
      $ccnPost->title = $blogPostTitle;
      $ccnPost->body = $blogPostBody;
      $ccnPost->summary = $blogPostSummary;
      $ccnPost->rating = $blogPost->rating;
      $ccnPost->hasImage = $blogPost->attachment;
      $ccnPost->state = $blogPost->publishstate;
      $ccnPost->tags = $blogPost->tags;
      $ccnPost->tagCount = count($blogPost->tags);
      $ccnPost->created = $blogPostCreated;
      $ccnPost->createdYear = $blogPostCreatedYear;
      $ccnPost->createdMonth = $blogPostCreatedMonth;
      $ccnPost->createdMonthShort = $blogPostCreatedMonthShort;
      $ccnPost->createdDay = $blogPostCreatedDay;
      $ccnPost->lastUpdated = $blogPostUpdated;
      $ccnPost->category = isset($blogPost->tags[0]) ? $blogPost->tags[0] : get_string('uncategorized', 'theme_edumy');
      $ccnPost->url = $blogPostUrl;

      $ccnRender = new \stdClass();
      $ccnRender->tags = '';
      foreach($ccnPost->tags as $k=>$ccnTag){
        if($k == $ccnPost->tagCount){
          $ccnRender->tags .= $ccnTag;
        } else {
          $ccnRender->tags .= $ccnTag . ', ';
        }
      }
      $ccnPost->ccnRender = $ccnRender;
      return $ccnPost;
    }
    return null;
  }

}
