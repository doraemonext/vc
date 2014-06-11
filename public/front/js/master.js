$(document).ready(function(){
  $(".search_input").focus(function() {

  });
  $(".search_input").focusout(function() {

  });
  $(".comment_text").focus(function() {

  });
  $(".comment_text").focusout(function() {

  });
  $(".post_title_text").focus(function() {

  });
  $(".post_title_text").focusout(function() {

  });


  $(".close").click(function() {
    this.parentNode.remove();
  });


  $(".stars_item label").mouseover(function() {
    $(this.parentNode.lastChild).css("width", $(this).children()[0].value * 30);
    $(this.parentNode.parentNode).find(".score_value")[0].innerHTML = $(this).children()[0].value;
  });
  $(".stars_item label").mouseout(function() {
    if($(this.parentNode).find("input:checked")[0]) {
      $(this.parentNode.lastChild).css("width", $(this.parentNode).find("input:checked")[0].value * 30);
      $(this.parentNode.parentNode).find(".score_value")[0].innerHTML = $(this.parentNode).find("input:checked")[0].value;
    } else {
      $(this.parentNode.lastChild).css("width", "0");
      $(this.parentNode.parentNode).find(".score_value")[0].innerHTML = "";
    }
  });
  $(".stars_item label").click(function() {
    console.log($(this).children()[0].value)
  });


  $(".tabs").children().click(function() {
    $(".tabs").children().attr("class", "");
    $(this).attr("class", "active");
    $(".tabanchor").hide();
    $("." + this.id).show();
  })


  $(".login").click(function() {
    $(".login_box").show();
    $("#popbox").fadeIn("slow");
    return false;
  })
  $(".register").click(function() {
    $(".regist_box").show();
    $("#popbox").fadeIn("slow");
    return false;
  })
  $(".popbox_bg").click(function() {
    $(".login_box").hide();
    $(".regist_box").hide();
    $("#popbox").fadeOut("slow");
  })
  $(".regist_link").click(function() {
    $(".login_box").fadeOut("fast", function() {
      $(".regist_box").fadeIn("fast");
    });
    return false;
  });
  $(".login_link").click(function() {
    $(".regist_box").fadeOut("fast", function() {
      $(".login_box").fadeIn("fast");
    });
    return false;
  });
});
