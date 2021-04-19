$(function() {
  $("#menu nav > a").unwrap();
  $("#menu .no-action").each(function() {
    $(this).remove();
  });
  $("#menu ul > a, #menu nav > a").each(function() {
    $(this).wrap("<li class='mm-listitem'></li>");
    $(this).removeClass("dropdown-item").addClass("mm-listitem__text");
  });
  if ($(".block_cocoon_slider_1").length) {
    $slider = $(".block_cocoon_slider_1");
    $(".inner_page_breadcrumb").replaceWith($slider);
    $("body").addClass("ccn_hero").addClass("ccn_slider_1").removeClass("ccn_no_hero");
    $slider.addClass("ccn_morphed");
  }
  if ($(".block_cocoon_slider_1_v").length) {
    $slider = $(".block_cocoon_slider_1_v");
    $(".inner_page_breadcrumb").replaceWith($slider);
    $("body").addClass("ccn_hero").addClass("ccn_slider_1_v").removeClass("ccn_no_hero");
    $slider.addClass("ccn_morphed");
  }
  if ($(".block_cocoon_slider_2").length) {
    $slider = $(".block_cocoon_slider_2");
    $(".inner_page_breadcrumb").replaceWith($slider);
    $("body").addClass("ccn_hero").addClass("ccn_slider_2").removeClass("ccn_no_hero");
    $slider.addClass("ccn_morphed");
  }
  if ($(".block_cocoon_slider_3").length) {
    $slider = $(".block_cocoon_slider_3");
    $(".inner_page_breadcrumb").replaceWith($slider);
    $("body").addClass("ccn_hero").addClass("ccn_slider_3").removeClass("ccn_no_hero");
    $slider.addClass("ccn_morphed");
  }
  if ($(".block_cocoon_slider_4").length) {
    $slider = $(".block_cocoon_slider_4");
    $(".inner_page_breadcrumb").replaceWith($slider);
    $("body").addClass("ccn_hero").addClass("ccn_slider_4").removeClass("ccn_no_hero");
    $slider.addClass("ccn_morphed");
  }
  if ($(".block_cocoon_slider_5").length) {
    $slider = $(".block_cocoon_slider_5");
    $(".inner_page_breadcrumb").replaceWith($slider);
    $("body").addClass("ccn_hero").addClass("ccn_slider_5").removeClass("ccn_no_hero");
    $slider.addClass("ccn_morphed");
  }
  if ($(".block_cocoon_slider_6").length) {
    $slider = $(".block_cocoon_slider_6");
    $(".inner_page_breadcrumb").replaceWith($slider);
    $("body").addClass("ccn_hero").addClass("ccn_slider_6").removeClass("ccn_no_hero");
    $slider.addClass("ccn_morphed");
  }
  if ($(".block_cocoon_slider_7").length) {
    $slider = $(".block_cocoon_slider_7");
    $(".inner_page_breadcrumb").replaceWith($slider);
    $("body").addClass("ccn_hero").addClass("ccn_slider_7").removeClass("ccn_no_hero");
    $slider.addClass("ccn_morphed");
  }
  if ($(".block_cocoon_slider_8").length) {
    $slider = $(".block_cocoon_slider_8");
    $(".inner_page_breadcrumb").replaceWith($slider);
    $("body").addClass("ccn_hero").removeClass("ccn_no_hero");
    $slider.addClass("ccn_morphed");
  }
  if ($(".block_cocoon_hero_1").length) {
    $slider = $(".block_cocoon_hero_1");
    $(".inner_page_breadcrumb").replaceWith($slider);
    $("body").addClass("ccn_hero").addClass("ccn_hero_1").removeClass("ccn_no_hero");
    $slider.addClass("ccn_morphed");
  }
  if ($(".block_cocoon_hero_2").length) {
    $slider = $(".block_cocoon_hero_2");
    $(".inner_page_breadcrumb").replaceWith($slider);
    $("body").addClass("ccn_hero").addClass("ccn_hero_2").removeClass("ccn_no_hero");
    $slider.addClass("ccn_morphed");
  }
  if ($(".block_cocoon_hero_3").length) {
    $slider = $(".block_cocoon_hero_3");
    $(".inner_page_breadcrumb").replaceWith($slider);
    $("body").addClass("ccn_hero").addClass("ccn_hero_3").removeClass("ccn_no_hero");
    $slider.addClass("ccn_morphed");
  }
  if ($(".block_cocoon_hero_4").length) {
    $slider = $(".block_cocoon_hero_4");
    $(".inner_page_breadcrumb").replaceWith($slider);
    $("body").addClass("ccn_hero").addClass("ccn_hero_4").removeClass("ccn_no_hero");
    $slider.addClass("ccn_morphed");
  }
  if ($(".block_cocoon_hero_5").length) {
    $slider = $(".block_cocoon_hero_5");
    $(".inner_page_breadcrumb").replaceWith($slider);
    $("body").addClass("ccn_hero").addClass("ccn_hero_5").removeClass("ccn_no_hero");
    $slider.addClass("ccn_morphed");
  }
  if ($(".block_cocoon_hero_6").length) {
    $slider = $(".block_cocoon_hero_6");
    $(".inner_page_breadcrumb").replaceWith($slider);
    $("body").addClass("ccn_hero").addClass("ccn_hero_6").removeClass("ccn_no_hero");
    $slider.addClass("ccn_morphed");
  }
  if ($(".block_cocoon_hero_7").length) {
    $slider = $(".block_cocoon_hero_7");
    $(".inner_page_breadcrumb").replaceWith($slider);
    $("body").addClass("ccn_hero").addClass("ccn_hero_7").removeClass("ccn_no_hero");
    $slider.addClass("ccn_morphed");
  }
  if ($("#ccn_prohibit_course_content").length) {
    $("#ccn-main").remove();
  }
  $(document).ready(function() {
    if ($("#quiz-timer").length) {
      $("#quiz-timer").wrap("<div id='ccnControlQuizTimer' style='display:none'></div>");
    }
    $(".ccn-drops").each(function() {
      var ccnDropsFirst = $(this).find("a:first-child");
      var ccnDropsHandle = $(this).find("span");
      $(ccnDropsHandle).html(ccnDropsFirst.text());

      $(this).find("a").on('click', function() {
        var ccnDropsClickValue = $(this).text();
        if (ccnDropsClickValue) {
          $(ccnDropsHandle).html(ccnDropsClickValue);
        }
      });
    });
    $(".footer_menu_widget > ul > div").each(function() {
      $(this).wrap("<li class='list-inline-item'></li>");
    });
    $(".activity-navigation .btn").each(function() {
      $(this).addClass("btn-secondary").removeClass("btn-link");
    });
    if ($("#ccn_instructor_personal_infor").length) {
      $("#ccn_instructor_personal_infor").insertBefore(".ccn_breadcrumb_widgets");
    }
    $(".ccn_blog-row > #maincontent,.ccn_blog-row > h2,.ccn_blog-row > .addbloglink").prependTo("#ccn-main .container");
    $(".ccn-faq_according #accordion .panel:first-child .panel-collapse").addClass("show");
    $(".dashbord_nav_list > a:first-child").prepend("<span class='flaticon-puzzle-1'></span>");
    $(".dashbord_nav_list > a:nth-child(2)").prepend("<span class='flaticon-student'></span>");
    $(".dashbord_nav_list > a:nth-child(3)").prepend("<span class='flaticon-rating'></span>");
    $(".dashbord_nav_list > a:nth-child(4)").prepend("<span class='flaticon-speech-bubble'></span>");
    $(".dashbord_nav_list > a:nth-child(5)").prepend("<span class='flaticon-settings'></span>");
    $(".dashbord_nav_list > a:nth-child(6)").prepend("<span class='flaticon-logout'></span>");
    $(".dashbord_nav_list > a:nth-child(7)").prepend("<span class='flaticon-add-contact'></span>");
    $(".dashbord_nav_list > a").each(function() {
      $(this).removeClass("dropdown-item").wrap("<li></li>");
    });
    $(".dashbord_nav_list > li").wrapAll("<ul></ul>");
    $(".ccn-blog-list-entry").wrapAll("<div class='row'></div>");
    if (document.body.classList.contains('ccn_blog_style_6') && document.body.classList.contains('path-blog')) {
      $("#ccn-main-region .ccn-blog-masonry-entry").wrapAll("<div class='ccn-masonry-grid-1'><div class='row ccn-masonry-grid'></div></div>");
    }
    $(".addbloglink").each(function() {
      $(this).find("a").addClass("btn dbxshad btn-primary btn-thm");
    });
    $("body.role-standard #ccn-main-region").each(function() {
      if (!$(this).find(".block").length && !$(this).find("#ccn-main").text().trim().length) {
        $("#ccn-main-region").css({
          'padding-top': '0',
          'padding-bottom': '0',
        });
        $("#ccn-main").remove();
      }
    });
    // $("body#page-site-index.ccn_header_style_7,body#page-site-index.ccn_header_style_3,body#page-site-index.ccn_header_style_4,body#page-site-index.ccn_header_style_5,body#page-site-index.ccn_header_style_6,body#page-site-index.ccn_header_style_8").each(function() {
    //   var list = $('ul#respMenu');
    //   var listItems = list.children('li');
    //   list.append(listItems.get().reverse());
    // });
    $("body.ccn_header_style_7:not(.ccn_context_dashboard),body.ccn_header_style_3:not(.ccn_context_dashboard) .menu_style_home_three,body.ccn_header_style_4:not(.ccn_context_dashboard),body.ccn_header_style_5:not(.ccn_context_dashboard) .menu_style_home_five,body.ccn_header_style_6:not(.ccn_context_dashboard) .menu_style_home_six,body.ccn_header_style_8:not(.ccn_context_dashboard),body.ccn_header_style_13:not(.ccn_context_dashboard),body.ccn_header_style_14:not(.ccn_context_dashboard)").each(function() {
      var list = $('ul#respMenu');
      var listItems = list.children('li');
      list.append(listItems.get().reverse());
    });
    $(".header_top.home2 .block_cocoon_globalsearch_n, .header-nav.menu_style_home_three .block_cocoon_globalsearch_n, header .block_cocoon_library_list").addClass("ccn-alt-blk-actm");
    $("body#page-enrol-index.ccn_course_list_style_1 .generalbox.info").each(function() {
      $(this).find(".col-lg-6.col-xl-4").addClass("col-lg-12 p0 courses_list_content").removeClass("col-lg-6 col-xl-4");
      $(this).find(".top_courses").addClass("list");
    });
    if ($("body#page-enrol-index .generalbox").length > 0) {
      $("body#page-enrol-index .generalbox:not(:first-of-type)").addClass("ccn-enrol-cta-box");
    }
    /* Message Drawer Handler */
    $("#ccn-messagedrawer-close").click(function() {
      $(".drawer").attr("aria-expanded", "false").attr("aria-hidden", "true").addClass("hidden");
    });
    /* Fixing Moodle's bad fake blocks*/
    if ($("#block-region-fullwidth-top .block_fake").length) {
      $("#block-region-fullwidth-top .block_fake").each(function() {
        $(this).addClass("mb40");
        $(this).appendTo("#block-region-above-content");
      });
    }
    /* User edit form: Other fields */
    // $("#page-user-editadvanced #id_category_1 .form-group").each(function(){
    //   $(this).insertAfter("form.mform #id_moodle .fcontainer #fitem_id_email");
    // });
    // darkMode
    $("#ccnToggleDarkMode").click(function() {
      $("#ccnToggleDarkMode").toggleClass("active");
      $("body").toggleClass("ccnDarkMode").css("transition", "none");
      // $.cookie("toggle", $("#ccnToggleDarkMode").hasClass('active'));
      document.cookie = 'theme=' + ($("#ccnToggleDarkMode").hasClass("active") ? 'dark' : 'light') + '; path=/;';
    });
    //     function isDarkThemeSelected() {
    //   return document.cookie.match(/theme=dark/i) != null
    // }
    if (document.cookie.match(/theme=dark/i) != null) {
      $("#ccnToggleDarkMode").addClass("active");
      $("body").addClass("ccnDarkMode");
    }
  });
  $(window).on('load', function() {
    $(".ccn_course_content > li.section:first-child > .ccnTopicFirstExp .panel-collapse").addClass("show");
    if ($("#ccnSettingsMenu").length) {
      $("#ccnSettingsMenu").appendTo("#ccnSettingsMenuContainer");
    }
    if ($(".gradereport-grader-table").length) {
      $(".mm-page>.wrapper").css({
        'overflow': 'unset',
      });
      $("body").css({
        'overflow': 'auto',
      });
      $(".dashboard_sidebar").css({
        'padding': '0',
      });
    }
    /* Begin Legacy Course Single handlers */
    $(".cs_row_one.ccn-pullto-breadcrumb").each(function() {
      $(".inner_page_breadcrumb").replaceWith("<section class='inner_page_breadcrumb csv2'><div class='container'><div class='row'><div class='col-xl-9'><div class='breadcrumb_content'><div class='cs_row_one csv2'><div class='cs_ins_container'></div></div></div></div></div></div></section>");
      $(this).find(".ccn-identify-course-intro").appendTo(".breadcrumb_content .cs_ins_container");
      if ($(window).width() > 1000) {
        $("#block-region-side-pre").css("margin-top", "-300px");
      }
      $(window).resize(function() {
        if ($(window).width() > 1000) {
          $("#block-region-side-pre").css("margin-top", "-300px");
        }
      });
      $(".instructor_pricing_widget").addClass("csv2");
      $(".feature_course_widget,.blog_tag_widget").addClass("csv1");
      $(".selected_filter_widget,.cs_overview,.course_content,.about_ins_container,.block_comments,.sfeedbacks").addClass("ccn-csv2");
    });
    $(".cs_row_one.ccn-pullto-breadcrumb-fullwidth").each(function() {
      $(".inner_page_breadcrumb").replaceWith("<section class='inner_page_breadcrumb csv3'><div class='container'><div class='row'><div class='col-xl-12'><div class='breadcrumb_content'><div class='cs_row_one csv3'><div class='cs_ins_container'></div></div></div></div></div></div></section>");
      $(this).find(".cs_watch_list").insertAfter($(this).find(".cs_review_enroll"));
      $(this).find(".ccn-identify-course-intro").appendTo(".breadcrumb_content .cs_ins_container");
    });
    /* End Legacy Course Single handlers */
    /* Begin New Course Single handlers */
    $(".ccn_course_single_v3 .block_cocoon_course_intro").each(function() {
      /* V3 */
      $(".inner_page_breadcrumb").replaceWith("<section class='inner_page_breadcrumb csv3'><div class='container'><div class='row'><div class='col-xl-12'><div class='breadcrumb_content'><div class='cs_row_one csv3'><div class='cs_ins_container'></div></div></div></div></div></div></section>");
      $(this).find(".cs_watch_list").insertAfter($(this).find(".cs_review_enroll"));
      $(this).find(".block-controls").appendTo(".breadcrumb_content .cs_ins_container");
      $(this).find(".ccn-identify-course-intro").appendTo(".breadcrumb_content .cs_ins_container");
    });
    $(".ccn_course_single_v2 .block_cocoon_course_intro").each(function() {
      /* V2 */
      $(".inner_page_breadcrumb").replaceWith("<section class='inner_page_breadcrumb csv2'><div class='container'><div class='row'><div class='col-xl-9'><div class='breadcrumb_content'><div class='cs_row_one csv2'><div class='cs_ins_container'></div></div></div></div></div></div></section>");
      $(this).find(".block-controls").appendTo(".breadcrumb_content .cs_ins_container");
      $(this).find(".ccn-identify-course-intro").appendTo(".breadcrumb_content .cs_ins_container");
      // if ($(window).width() > 1000) {
      //   $("#block-region-side-pre").css("margin-top", "-300px");
      // }
      // $(window).resize(function() {
      //   if ($(window).width() > 1000) {
      //     $("#block-region-side-pre").css("margin-top", "-300px");
      //   }
      // });
    });
    /* End New Course Single handlers */
    if ($(".ccn_course_list_style_2.pagelayout-coursecategory .shadow_box").length) {
      $("#ccn-main-region").addClass("courses-list");
      $(".selected_filter_widget").each(function() {
        $(this).removeClass("style2").addClass("style3");
      });
      $(".blog_tag_widget").each(function() {
        $(this).addClass("style3 selected_filter_widget");
      });
    }
    var elem = $(".inbox_chatting_box > .body-container");
    var elemContainer = $(".inbox_chatting_box");
    $(document).ajaxComplete(function() {
      // @ccnRef: FORMAT TILES
      $("#window-overlay").appendTo(".mm-page");
      // @ccnRef: End FORMAT TILES
      var currentHeight = $(".inbox_chatting_box").prop("scrollHeight");
      setTimeout(function() {
        elem.attr('data-ccnheight', currentHeight);
      }, 3000);

      function scrollMsg() {
        $(".inbox_chatting_box > .body-container").animate({
          scrollTop: $(".inbox_chatting_box > .body-container").prop("scrollHeight")
        }, 1000);
      }

      function scrollMsgContainer() {
        $(".inbox_chatting_box").animate({
          scrollTop: $(".inbox_chatting_box").prop("scrollHeight")
        }, 1000);
      }
      if (elem.length) {
        if ($(".inbox_chatting_box").scrollTop() <= 0) {
          scrollMsgContainer();
          scrollMsg();
        }
        if (elem.attr('data-ccnheight') != currentHeight) {
          scrollMsgContainer();
          scrollMsg();
        }
      }
    });
    if ($("#quiz-time-left").length) {
      if (!$('#quiz-time-left').is(':empty')) {
        $("#ccnControlQuizTimer").css("display", "block");
        $("#quiz-timer").css({
          'visibility': 'visible',
          'opacity': '1',
          'height': 'auto',
        });
      }
    };
  });
  /* end windowOnLoad */
  $(".user_setting > .dropdown > a").click(function() {
    $(".popover-region-notifications").addClass("collapsed");
    $(".popover-region-container").attr("aria-expanded", "false").attr("aria-hidden", "true");
  });
  /* end wrapper function */
});

function ccnCommentHandler(opts, langString1) {
  $(window).on('load', function() {
    $(".comment-message").each(function() {
      var $comment = $(this);
      $(this).addClass("media csv1");
      $(this).find(".userpicture").addClass("align-self-start mr-3 ccn_userpicture").removeClass("userpicture");
      $(this).find(".time").each(function() {
        $(this).prependTo($comment.find(".text")).replaceWith("<span class='sspd_postdate fz14'>" + $(this).text() + "</span>");
      });
      $(this).find(".user").each(function() {
        $(this).prependTo($comment.find(".text")).replaceWith("<h4 class='sub_title mt-0 mb0'>" + $(this).text() + "</h4>");
      });
      $(this).find(".text_to_html").addClass("fz15 mt20");
      $(this).find(".text").addClass("media-body");
      $("<div class='custom_hr'></div>").insertAfter($comment);
    });
    $(".block_comments").each(function() {
      var $commentarea = $(this).find(".comment-area");
      $commentarea.insertAfter($(this)).addClass("comments_form");
      $commentarea.prepend("<h4>" + langString1 + "</h4>").wrap("<div class='cs_row_seven'><div class='sfeedbacks'><div class='mbp_comment_form style2 pb0'></div></div></div>");
      $commentarea.find(".db").wrap("<div class='form-group'></div>");
      $commentarea.find(".fd a").append("<span class='flaticon-right-arrow-1'></span>");
    });
  });
}

function ccnControl(opts, ccnCntrlUri, ccnCntrlUriT, ccnCntrlLcVbCollection, ccnMdlVersion) {

  const ccnOpts = opts;
  const ccnCntrlUriThumb = ccnCntrlUriT;
  const ccnCntrlUriImg = ccnCntrlUri;
  const ccnCntrlMdlVer = ccnMdlVersion;

  const waitUntilElementExists = (selector, callback) => {
    const el = document.querySelector(selector);
    if (el) {
      return callback(el);
    }
    setTimeout(() => waitUntilElementExists(selector, callback), 500);
  }
  $("a[data-key='addblock']").on('click', function() {
    waitUntilElementExists('.ccn-control-visualize-block-img', (el) => ccnControlBlockList());
  });

  /*@ccnComm: Start Block list */
  function ccnControlBlockList() {
    function ccnClosePreviewContainer(delay) {
      $("#ccn-visualize-preview-container").fadeOut(delay);
    }
    $("#ccnClosePreviewContainer").on('click', function() {
      ccnClosePreviewContainer(200);
    });
    if (ccnCntrlMdlVer === '310') {
      $("#ccn-visualize-search-blocks").addClass('ccnMdl310').appendTo($("#ccn-visualize-search-blocks").closest(".modal-content"));
    }
    $(".ccn-control-visualize-block--col[data-ccn-name^='cocoon']").each(function() {
      var ccnThis = $(this).index();
      $(this).find(".ccn-control-visualize-block").each(function() {
        var ccnLcVbTag = document.createElement('div');
        ccnLcVbTag.setAttribute('class', 'ccnDecorativeLiveCustomizerTag');
        ccnLcVbTag.textContent = 'Live Customizer';
        var ccnBlockN = $(this).attr("data-ccn-name");
        var ccnBlockT = $(this).attr("data-ccn-title");
        var ccnBlockL = $(this).attr("data-ccn-href");
        var ccnBlockThumb = ccnCntrlUriThumb + $(this).attr("data-ccn-name") + '.jpeg';
        var ccnBlockImage = ccnCntrlUriImg + $(this).attr("data-ccn-name") + '.jpeg';
        var ccnBlockD = "Add a " + ccnBlockT + " block to this page.";

        if (ccnCntrlLcVbCollection.includes(ccnBlockN) && this.querySelector(".ccnDecorativeLiveCustomizerTag") == null) {
          this.querySelector(".ccn-control-visualize-block-inner").appendChild(ccnLcVbTag);
        }

        function ccnVisualizeUpdate(ccnT, ccnL, ccnI, ccnD) {
          document.getElementById("ccn-visualize-preview-container-title").textContent = ccnT;
          document.getElementById("ccn-visualize-preview-container-detail").textContent = ccnD;
          document.getElementById('ccn-visualize-preview-container-img').innerHTML = "<img src=" + ccnI + " />";
          document.getElementById("ccn-visualize-preview-container-href").href = ccnL;
          $("#ccn-visualize-preview-container-title:contains('[Cocoon]')").html(function(_, html) {
            return html.split('[Cocoon]').join("<span class='ccn-control-visualize-block-title-tag'>Cocoon</span>");
          });
        }

        function ccnVisualizeNavigate(ccnEl) {
          var ccnControlNextEl = $(".ccn-control-visualize-block--col[data-ccn-name^='cocoon']")[ccnEl];
          var ccnBlockT = ccnControlNextEl.querySelector('.ccn-control-visualize-block').getAttribute("data-ccn-title");
          var ccnBlockL = ccnControlNextEl.querySelector('.ccn-control-visualize-block').getAttribute("data-ccn-href");
          var ccnBlockN = ccnControlNextEl.querySelector('.ccn-control-visualize-block').getAttribute("data-ccn-name");
          var ccnBlockD = "Add a " + ccnBlockT + " block to this page.";
          var ccnBlockImage = ccnCntrlUriImg + ccnBlockN + '.jpeg';
          ccnControlNextEl.querySelector('.ccn-control-visualize-block').getAttribute("data-ccn-href")
          ccnVisualizeUpdate(ccnBlockT, ccnBlockL, ccnBlockImage, ccnBlockD);
        }
        $(this).on('click', function(e) {
          e.preventDefault();
          $("#ccnNextPreviewContainer").on('click', function() {
            var ccnControlCount = document.querySelectorAll(".ccn-visualize-block-group .ccn-control-visualize-block--col[data-ccn-name^='cocoon']").length;
            var ccnNext = ccnThis < ccnControlCount ? ccnThis + 1 : ccnControlCount;
            var ccnNext1 = ccnThis < ccnControlCount ? ccnThis++ : ccnControlCount;
            ccnVisualizeNavigate(ccnNext);
          });
          $("#ccnPrevPreviewContainer").on('click', function() {
            var ccnPrev = ccnThis > 0 ? ccnThis - 1 : ccnThis;
            var ccnPrev1 = ccnThis > 0 ? ccnThis-- : ccnThis;
            ccnVisualizeNavigate(ccnPrev);
          });
          $("#ccn-visualize-preview-container").fadeIn(200);
          document.getElementById("ccn-visualize-preview-container-title").textContent = ccnBlockT;
          document.getElementById("ccn-visualize-preview-container-detail").textContent = ccnBlockD;
          $("#ccn-visualize-preview-container-title:contains('[Cocoon]')").html(function(_, html) {
            return html.split('[Cocoon]').join("<span class='ccn-control-visualize-block-title-tag'>Cocoon</span>");
          });
          document.getElementById('ccn-visualize-preview-container-img').innerHTML = "<img src=" + ccnBlockImage + " />";
          $("#ccn-visualize-preview-container-href").attr("href", ccnBlockL);
        });
        $(this).find(".ccn-control-visualize-block-title").each(function() {
          if ($(this).is(":contains('[Cocoon]')")) {
            $(this).html(function(_, html) {
              return html.split('[Cocoon]').join("<span class='ccn-control-visualize-block-title-tag'>Cocoon</span>");
            });
          }
        });
        $(this).find(".ccn-control-visualize-block-img").css({
          'background-image': 'url(' + ccnBlockThumb + ')'
        });
      });
    });
    $('#ccn-visualize-search-blocks input').bind('keyup', function() {
      var searchString = $(this).val();
      $(".ccn-control-visualize-block--col").each(function(index, value) {
        currentName = $(value).text()
        if (currentName.toUpperCase().indexOf(searchString.toUpperCase()) > -1) {
          $(value).show();
        } else {
          $(value).hide();
        }
      });
    });
  }
  /*@ccnComm: End Block list */
}
