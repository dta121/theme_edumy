<?php

require_once($CFG->dirroot . "/blog/renderer.php");
require_once($CFG->dirroot . "/theme/edumy/ccn/blog_handler/ccn_blog_handler.php");

class theme_edumy_core_blog_renderer extends core_blog_renderer {

  /**
   * Renders a blog entry
   *
   * @param blog_entry $entry
   * @return string The table HTML
   */
  public function render_blog_entry(blog_entry $entry) {

      global $CFG, $PAGE;

      $ccnBlogHandler = new ccnBlogHandler();
      $ccnGetPostDetails = $ccnBlogHandler->ccnGetPostDetails($entry->id);

      $syscontext = context_system::instance();

      $stredit = get_string('edit');
      $strdelete = get_string('delete');

      // Header.
      $mainclass = 'ccn_post';
      if ($entry->renderable->unassociatedentry) {
        $mainclass .= 'draft';
      } else {
        $mainclass .= $entry->publishstate;
      }

      $titlelink = html_writer::link(new moodle_url('/blog/index.php',
                                                     array('entryid' => $entry->id)),
                                                     format_string($entry->subject));

      // Post by.
      $by = new stdClass();
      $fullname = fullname($entry->renderable->user, has_capability('moodle/site:viewfullnames', $syscontext));
      $userurlparams = array('id' => $entry->renderable->user->id, 'course' => $this->page->course->id);
      $by->name = html_writer::link(new moodle_url('/user/view.php', $userurlparams), $fullname);

      $by->date = userdate($entry->created);
      // $o .= $this->output->container(get_string('bynameondate', 'forum', $by), 'author');



      $day = userdate($entry->created, '%d', 0);
      $month = userdate($entry->created, '%B', 0);
      $year = userdate($entry->created);

      // Adding external blog link.
      if (!empty($entry->renderable->externalblogtext)) {
          // $o .= $this->output->container($entry->renderable->externalblogtext, 'externalblog');
      }

      // Determine text for publish state.
      switch ($entry->publishstate) {
          case 'draft':
              $blogtype = get_string('publishtonoone', 'blog');
              break;
          case 'site':
              $blogtype = get_string('publishtosite', 'blog');
              break;
          case 'public':
              $blogtype = get_string('publishtoworld', 'blog');
              break;
          default:
              $blogtype = '';
              break;

      }
     // $o .= $this->output->container($blogtype, 'audience');

      // Attachments.
     /* $attachmentsoutputs = array();
      if ($entry->renderable->attachments) {
          foreach ($entry->renderable->attachments as $attachment) {
              $o .= $this->render($attachment, false);
          }
      } */


      // CCN Attachments
      $image = $CFG->wwwroot .'/theme/edumy/images/ccnBgMd.png';
      if ($entry->renderable->attachments) {
        foreach($entry->renderable->attachments as $attachment) {
          $image = $attachment->url;
        }
      }

      // Body.

      if (!empty($entry->uniquehash)) {
          // Uniquehash is used as a link to an external blog.
          $url = clean_param($entry->uniquehash, PARAM_URL);
          if (!empty($url)) {
      //        $o .= $this->output->container_start('externalblog');
      //        $o .= html_writer::link($url, get_string('linktooriginalentry', 'blog'));
      //        $o .= $this->output->container_end();
          }
      }

      // Links to tags.
     // $o .= $this->output->tag_list(core_tag_tag::get_item_tags('core', 'post', $entry->id));

      // Add associations.
      if (!empty($CFG->useblogassociations) && !empty($entry->renderable->blogassociations)) {

          // First find and show the associated course.
          $assocstr = '';
          $coursesarray = array();
          foreach ($entry->renderable->blogassociations as $assocrec) {
              if ($assocrec->contextlevel == CONTEXT_COURSE) {
                  $coursesarray[] = $this->output->action_icon($assocrec->url, $assocrec->icon, null, array(), true);
              }
          }
          if (!empty($coursesarray)) {
              $assocstr .= get_string('associated', 'blog', get_string('course')) . ': ' . implode(', ', $coursesarray);
          }

          // Now show mod association.
          $modulesarray = array();
          foreach ($entry->renderable->blogassociations as $assocrec) {
              if ($assocrec->contextlevel == CONTEXT_MODULE) {
                  $str = get_string('associated', 'blog', $assocrec->type) . ': ';
                  $str .= $this->output->action_icon($assocrec->url, $assocrec->icon, null, array(), true);
                  $modulesarray[] = $str;
              }
          }
          if (!empty($modulesarray)) {
              if (!empty($coursesarray)) {
                  $assocstr .= '<br/>';
              }
              $assocstr .= implode('<br/>', $modulesarray);
          }

          // Adding the asociations to the output.
        //  $o .= $this->output->container($assocstr, 'tags');
      }

      if ($entry->renderable->unassociatedentry) {
         // $o .= $this->output->container(get_string('associationunviewable', 'blog'), 'noticebox');
      }

      // Commands.
      //$o .= $this->output->container_start('commands');
      if ($entry->renderable->usercanedit) {
        $ccn_commands = '';
        if (empty($entry->uniquehash)) {
            $ccn_commands .= '<a class="btn btn-secondary" href="'.new moodle_url('/blog/edit.php', array('action' => 'edit', 'entryid' => $entry->id)).'">'.$stredit.'</a>';
        }
        $ccn_commands .= '<a class="btn btn-secondary" href="'.new moodle_url('/blog/edit.php', array('action' => 'delete', 'entryid' => $entry->id)).'">'.$strdelete.'</a>';
      }

      $entryurl = new moodle_url('/blog/index.php', array('entryid' => $entry->id));

      // Last modification.
      if ($entry->created != $entry->lastmodified) {
          // $o .= $this->output->container(' [ '.get_string('modified').': '.userdate($entry->lastmodified).' ]');
      }

      // Comments.
      if (!empty($entry->renderable->comment)) {
        global $DB, $CFG, $PAGE, $USER, $COURSE;

        $cmt = new stdClass();
        $cmt->context = context_user::instance($entry->userid);
        $cmt->courseid = $PAGE->course->id;
        $cmt->area = 'format_blog';
        $cmt->itemid = $entry->id;
        $cmt->notoggle  = true;
        $cmt->showcount = $CFG->blogshowcommentscount;
        $cmt->component = 'blog';
        $cmt->autostart = true;
        $cmt->displaycancel = false;
        $ccn_comments = new comment($cmt);
        $ccn_comments->set_view_permission(true);
        $ccn_comments->set_fullwidth();
      }

      $tags =  $this->output->tag_list(core_tag_tag::get_item_tags('core', 'post', $entry->id));
      if (!empty($blogheaders['filters']['entry'])) {
        $blogheaders = blog_get_headers()['filters']['entry'];
      }
      $cocoon_share_fb = 'https://www.facebook.com/sharer/sharer.php?u='. $entryurl;
      $cocoon_share_tw = 'https://twitter.com/intent/tweet?url='. $entryurl;
      $cocoon_share_li = 'https://www.linkedin.com/shareArticle?mini=true&url='. $entryurl;
      $cocoon_share_pi = 'http://pinterest.com/pin/create/button/?url='. $entryurl;
      $cocoon_share_vk = 'http://vk.com/share.php?url='. $entryurl;
      $cocoon_share_em = 'mailto:?&body='. $entryurl;
      $o = '';

      $ccnRenderEntryStyle4 = '
        <div class="col-12 col-md-6 col-xl-4 ccn-blog-list-entry">
          <div class="ccn_blog_post_4 blog_post mb30">
            <div class="thumb">
              <img class="img-fluid w100" src="'.$image.'" alt="">
              <a class="post_date" href="'.$ccnGetPostDetails->url.'">'.$ccnGetPostDetails->created.'</a>
            </div>
            <div class="details">
              <h5><a class="color-white" href="'.$ccnGetPostDetails->url.'">'.$ccnGetPostDetails->ccnRender->tags.'</a></h5>
              <h4><a class="color-white" href="'.$ccnGetPostDetails->url.'">'.$ccnGetPostDetails->title.'</a></h4>
            </div>
          </div>
        </div>';

      $ccnRenderEntryStyle5 = '
        <div class="col-md-6 col-lg-4 col-xl-4 ccn-blog-list-entry">
          <div class="ccn_blog_post_5 blog_post_home6 mb30">
            <div class="thumb">
              <a href="'.$ccnGetPostDetails->url.'"><img class="img-fluid img-rounded" src="'.$image.'" alt=""></a>
              <h5 class="mt20">'.$ccnGetPostDetails->ccnRender->tags.'</h5>
              <a href="'.$ccnGetPostDetails->url.'"><h4 class="mt0">'.$ccnGetPostDetails->title.'</h4></a>
              <span class="post_date">'.$ccnGetPostDetails->created.'</span>
            </div>
            <div class="details"></div>
          </div>
        </div>';

      $ccnRenderEntryStyle6 = '
        <div class="col-md-6 col-lg-6 col-xl-4 ccn-blog-masonry-entry">
          <div class="ccn_blog_post_6 blog_post_home6 style2 mb30">
            <div class="thumb">
              <a href="'.$ccnGetPostDetails->url.'">
                <img class="w100 img-rounded" src="'.$image.'" alt="">
                <div class="overlay"></div>
              </a>
            </div>
            <div class="details">
              <h5 class="mt20">'.$ccnGetPostDetails->ccnRender->tags.'</h5>
              <h4 class="mt0"><a href="'.$ccnGetPostDetails->url.'">'.$ccnGetPostDetails->title.'</a></h4>
              <span class="post_date">'.$ccnGetPostDetails->created.'</span>
            </div>
          </div>
        </div>';

      if(isset($_GET['entryid'])){
        // If it's a single blog entry
        $o .= '
        <div class="main_blog_post_content">
          <div class="mbp_thumb_post">
						<div class="thumb">
							<img class="img-fluid" src="'. $image .'" alt="'.$entry->subject.'">
							<div class="tag ccn-white">'. $tags .'</div>';
              if($PAGE->theme->settings->blog_post_date != 1){
				        $o .='<div class="post_date"><h2>'. $day .'</h2> <span>'. $month .'</span></div>';
              }
              $o .='
						</div>
						<div class="details">
              <h3>'. $entry->subject .'</h3>';
                if ($entry->renderable->usercanedit) {
                  $o .= '<div class="ccn-commands">'.$ccn_commands.'</div>';
                }
                $o .= '
								<ul class="post_meta">';
                if($PAGE->theme->settings->blog_post_author != 1){
                  $o .='<li><span class="flaticon-profile"></span></li>
									      <li><span>'. $fullname .'</span></li>';
                }
                if (!empty($entry->renderable->comment)) {
									$o .='
									<li><span class="flaticon-comment"></span></li>
									<li><span>'. $entry->renderable->comment->count() .' '.get_string('comments', 'theme_edumy').'</span></li>';
                }
                $o .='
								</ul>
                <div class="ccn-blog-post-content-surround">
                  <p>'. format_text($entry->summary) .'</p>
                </div>
              </div>
							<ul class="blog_post_share">
								<li><p>'.get_string('share', 'theme_edumy').'</p></li>
								<li><a href="'. $cocoon_share_fb .'"><i class="fa fa-facebook"></i></a></li>
								<li><a href="'. $cocoon_share_tw .'"><i class="fa fa-twitter"></i></a></li>
								<li><a href="'. $cocoon_share_li .'"><i class="fa fa-linkedin"></i></a></li>
                <li><a href="'. $cocoon_share_pi .'"><i class="fa fa-pinterest"></i></a></li>
								<li><a href="'. $cocoon_share_vk .'"><i class="fa fa-vk"></i></a></li>
								<li><a href="'. $cocoon_share_em .'"><i class="fa fa-envelope"></i></a></li>
							</ul>
						</div>';
            if($ccn_comments) {
              $o .='
              <div class="style2 mb30">
                <div class="block_comments">
                  <h4 class="aii_title">'.get_string('reviews', 'theme_edumy').'</h4>'. $ccn_comments->output(true) .'
                </div>
              </div>';
            }
					$o .='</div>';
        } else {
          // If it's a blog listing
          if (isset($PAGE->theme->settings->blogstyle) && ($PAGE->theme->settings->blogstyle == 1)) {
            $o .= '
            <div class="ccn-blog-list-entry col-12 main_blog_post_content mb30">
              <div class="mbp_thumb_post">';
                if(!empty($image)){
                $o .= '
                <div class="thumb">
                  <a href="'.$entryurl.'">
                    <img class="img-fluid" src="'. $image .'" alt="'.$entry->subject.'">
                  </a>
                  <div class="tag">'. $tags .'</div>';
                  if($PAGE->theme->settings->blog_post_date != 1){
                    $o .='<a href="'.$entryurl.'"><div class="post_date"><h2>'. $day .'</h2> <span>'. $month .'</span></div></a>';
                  }
                  $o .='
                </div>';
                }
                $o .= '
                 <div class="details">
                   <a href="'.$entryurl.'"><h3>'. format_text($entry->subject, FORMAT_HTML, array('filter' => true)) .'</h3></a>';
                   if ($entry->renderable->usercanedit) {
                     $o .= '<div class="ccn-commands">'.$ccn_commands.'</div>';
                   }
                   $o .= '
                   <ul class="post_meta">';
                   if($PAGE->theme->settings->blog_post_author != 1){
                     $o .='<li><span class="flaticon-profile"></span></li>
   									      <li><span>'. $fullname .'</span></li>';
                   }
                   if (!empty($entry->renderable->comment)) {
   									$o .='
                     <li><span class="flaticon-comment"></span></li>
                     <li><span>'. $entry->renderable->comment->count() .' comments</span></li>';
                   }
                   $o .='
                   </ul>
                   <p>'. substr(format_string($entry->summary, $striplinks = true,$options = null),0,300).'...</p>
                 </div></a>
               </div>
             </div>';
           } elseif(isset($PAGE->theme->settings->blogstyle) && ($PAGE->theme->settings->blogstyle == 2)) {
             $o .= '
             <div class="ccn-blog-list-entry col-sm-6 col-lg-6 col-xl-6">
               <div class="blog_grid_post mb30">';
               if(!empty($image)){
                 $o .= '
                 <div class="thumb">
                   <img class="img-fluid" src="'.$image.'" alt="'.$entry->subject.'">
									 <div class="tag">'.$tags.'</div>';
                   if($PAGE->theme->settings->blog_post_date != 1){
                     $o .='<div class="post_date"><h2>'. $day .'</h2> <span>'.$month.'</span></div>';
                   }
                   $o .='
								 </div>';
               }
               $o .= '
								 <div class="details">
                   <a href="'.$entryurl.'"><h3>'. $entry->subject .'</h3></a>';
                   if ($entry->renderable->usercanedit) {
                     $o .= '<div class="ccn-commands">'.$ccn_commands.'</div>';
                   }
                   $o .='
                   <ul class="post_meta">';
                   if($PAGE->theme->settings->blog_post_author != 1){
                     $o .='<li><span class="flaticon-profile"></span></li>
   									      <li><span>'. $fullname .'</span></li>';
                   }
                   if (!empty($entry->renderable->comment)) {
   									$o .='
                     <li><span class="flaticon-comment"></span></li>
                     <li><span>'. $entry->renderable->comment->count() .' '.get_string('comments', 'theme_edumy').'©</span></li>';
                   }
                   $o .='
								   </ul>
								   <p>'. substr(format_string($entry->summary, $striplinks = true,$options = null),0,300).'...</p>
                 </div>
               </div>
             </div>';

       }elseif(isset($PAGE->theme->settings->blogstyle) && ($PAGE->theme->settings->blogstyle == 3)) {
         if(!empty($image)){
         $o .= ' <div class="ccn-blog-list-entry col-xl-5 pr15-xl pr0">
								<div class="blog_grid_post mb35">
									<div class="thumb">
										<img class="img-fluid w100" src="'.$image.'" alt="'.$entry->subject.'">
										<div class="tag">'.$tags.'</div>';
                    if($PAGE->theme->settings->blog_post_date != 1){
                      $o .='<div class="post_date"><h2>'.$day.'</h2> <span>'.$month.'</span></div>';
                    }
                    $o .='
									</div>
								</div>
							</div>
              <div class="ccn-blog-list-entry col-xl-7 pl15-xl pl0">
								<div class="blog_grid_post style2 mb35">
									<div class="details">
										<a href="'.$entryurl.'"><h3>'.$entry->subject.'</h3></a>
										<ul class="post_meta">';
                    if($PAGE->theme->settings->blog_post_author != 1){
                      $o .='<li><span class="flaticon-profile"></span></li>
    									      <li><span>'. $fullname .'</span></li>';
                    }
                    if (!empty($entry->renderable->comment)) {
    									$o .='
                    <li><span class="flaticon-comment"></span></li>
                    <li><span>'. $entry->renderable->comment->count() .' '.get_string('comments', 'theme_edumy').'</span></li>';
                  }
                  $o .='
										</ul>
										<p>'. substr(format_string($entry->summary, $striplinks = true,$options = null),0,400).'...</p>
									</div>
								</div>
							</div>';
            } else {
              $o .= '
                   <div class="ccn-blog-list-entry col-xl-12 pl15-xl pl0">
     								<div class="blog_grid_post style2 mb35">
     									<div class="details">
     										<a href="'.$entryurl.'"><h3>'.$entry->subject.'</h3></a>
     										<ul class="post_meta">';
                         if($PAGE->theme->settings->blog_post_author != 1){
                           $o .='<li><span class="flaticon-profile"></span></li>
         									      <li><span>'. $fullname .'</span></li>';
                         }
                         if (!empty($entry->renderable->comment)) {
         									$o .='
                         <li><span class="flaticon-comment"></span></li>
                         <li><span>'. $entry->renderable->comment->count() .' '.get_string('comments', 'theme_edumy').'</span></li>';
                       }
                       $o .='
     										</ul>
     										<p>'. substr(format_string($entry->summary, $striplinks = true,$options = null),0,400).'...</p>
     									</div>
     								</div>
     							</div>';
            }
          } elseif(isset($PAGE->theme->settings->blogstyle) && ($PAGE->theme->settings->blogstyle == 4)) {
            $o .= $ccnRenderEntryStyle4;
          } elseif(isset($PAGE->theme->settings->blogstyle) && ($PAGE->theme->settings->blogstyle == 5)) {
            $o .= $ccnRenderEntryStyle5;
          } elseif(isset($PAGE->theme->settings->blogstyle) && ($PAGE->theme->settings->blogstyle == 6)) {
            $o .= $ccnRenderEntryStyle6;
          }
}


      return $o;
  }



}
