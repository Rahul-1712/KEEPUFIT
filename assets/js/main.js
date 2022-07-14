/*------------------------------------    
    01. Scroll Up
--------------------------------------*/

var rootElement = document.documentElement;

$(window).scroll(function () {
  // total pixels available to scroll
  var scrollTotal = rootElement.scrollHeight + rootElement.clientHeight;
  if (scrollTotal > 2 * window.innerHeight) {
    // dividing scrolltop position by total pixels available to scroll to et the ratio between 0 to 1
    // and set it as opacity of button
    $(".scrollUp").css("opacity", rootElement.scrollTop / scrollTotal);
  }
});

$(".scrollUp").on("click", function () {
  // on click scroll to top of document
  rootElement.scrollTo({
    top: 0,
    behavior: "smooth",
  });
});

/*------------------------------------    
    02. Search Bar
--------------------------------------*/

$(".search_open").on("click", function (e) {
  e.preventDefault();
  //  console.log('search_open');
  $(".search_icon").addClass("icon_selected");
  $(".search_area").slideDown(300);
  // $('body').toggleClass('search_show_hide');
  $(".body_overlay").addClass("is_visible");
  return false;
});

$(".search_close_btn").on("click", function (e) {
  e.preventDefault();
  //  console.log('search_close');
  $(".search_icon").removeClass("icon_selected");
  $(".search_area").slideUp(100);
  // $('body').toggleClass('search_show_hide');

  $(".body_overlay").removeClass("is_visible");

  return false;
});

/*------------------------------------    
    03. Body overlay
--------------------------------------*/

$(".body_overlay").on("click", function () {
  $(this).removeClass("is_visible");
  $(".search_icon").removeClass("icon_selected");
  $(".search_area").slideUp(100);
});

/*------------------------------------    
    04. User account icon hover
--------------------------------------*/

$(".header_user_account").hover(
  function () {
    $(".user_icon").addClass("icon_selected");
    $(".user_icon_dropdown_area").addClass("is_visible");
    $(".body_overlay").addClass("is_visible");
  },
  function () {
    $(".user_icon").removeClass("icon_selected");
    //  $('.user_icon_dropdown_area').stop();
    $(".user_icon_dropdown_area").removeClass("is_visible");
    $(".body_overlay").removeClass("is_visible");
  }
);

/*------------------------------------    
    05. Cart icon hover
--------------------------------------*/

$(".header_cart").hover(
  function () {
    $(".cart_icon").addClass("icon_selected");
    $(".cart_icon_dropdown_area").addClass("is_visible");
    $(".body_overlay").addClass("is_visible");
  },
  function () {
    $(".cart_icon").removeClass("icon_selected");
    $(".cart_icon_dropdown_area").removeClass("is_visible");
    $(".body_overlay").removeClass("is_visible");
  }
);

/*------------------------------------    
    06. Category dropdown on hover
--------------------------------------*/

$(".cat_menu_main_category").hover(
  function () {
    var cat_dropdown = $(this).find(".category_dropdown");
    // console.log(cat_dropdown);
    if (cat_dropdown.length > 0) {
      cat_dropdown.addClass("show_dropdown");
      $(".partial_overlay").addClass("is_visible");
    }
  },
  function () {
    var cat_dropdown = $(this).find(".category_dropdown");
    cat_dropdown.removeClass("show_dropdown");
    $(".partial_overlay").removeClass("is_visible");
  }
);

/*-------------------------------------------
    07. Sticky Header
--------------------------------------------- */

var win = $(window);
var sticky_id = $("#sticky_header");
win.on("scroll", function () {
  var scroll = win.scrollTop();
  if (scroll < 160) {
    sticky_id.removeClass("sticky_header");
  } else {
    sticky_id.addClass("sticky_header");
  }
});

/*-------------------------------------------
    08. Manual Image Slider
--------------------------------------------- */

var slideindex = 1;
showSlides(slideindex);

// Next/previous controls
function plusSlides(n) {
  showSlides((slideindex += n));
}

// control images from dots

function currentSlide(n) {
  showSlides((slideindex = n));
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("slides");
  var dots = document.getElementsByClassName("dot");

  if (n > slides.length) {
    slideindex = 1;
  }
  if (n < 1) {
    slideindex = slides.length;
  }
  // set display of all slides to none
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  // remove active class from all dots
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace("active", "");
  }

  // show active slide by subtraacting 1 from siledindex to match the array index
  try {
    slides[slideindex - 1].style.display = "block";
    dots[slideindex - 1].className += " active";
  } catch (error) {}
}

/*-------------------------------------------
    09. sorting products
--------------------------------------------- */

function sortOrder(sortId, sort_cat) {
  var sortby = $("#sortOrder").val();
  console.log(sort_cat);
  if (sort_cat == "cat") {
    window.location.href =
      "products.php?cat_id=" + sortId + "&sortOrder=" + sortby;
    console.log("products.php?cat_id=" + sortId + "&sortOrder=" + sortby);
  } else if (sort_cat == "sub") {
    window.location.href =
      "products.php?sub_id=" + sortId + "&sortOrder=" + sortby;
    console.log("products.php?sub_id=" + sortId + "&sortOrder=" + sortby);
  }
}

/*-------------------------------------------
    10. change quantity on click
--------------------------------------------- */

$(".decrease_btn").on("click", function () {
  changeQuantity(-1);
});

$(".increase_btn").click(function (e) {
  changeQuantity(1);
});

$(".quantity_input").keyup(function (e) {
  e.preventDefault();
  var quantity_input = document.getElementById("quantity_input");

  var maxValue = quantity_input.getAttribute("max");

  var value = parseInt($(this).val());
  console.log(maxValue);
  console.log(value);

  if (value > maxValue) {
    console.log(maxValue);
    $(this).val(maxValue);
  } else if (value < 0) {
    $(this).val(1);
  }
});

function changeQuantity(changeBy) {
  var quantity_input = document.getElementById("quantity_input");

  var minValue = quantity_input.getAttribute("min");
  var maxValue = quantity_input.getAttribute("max");

  var oldnumber = parseInt($(".quantity_input").val());
  if (oldnumber >= minValue && oldnumber <= maxValue) {
    var newnumber = parseInt(oldnumber) + changeBy;

    if (newnumber < minValue) {
      $(".decrease_btn").addClass("disabled");
      document.getElementById("decrease_btn").disabled = true;
    } else if (newnumber > maxValue) {
      $(".increase_btn").addClass("disabled");
      document.getElementById("increase_btn").disabled = true;
    } else {
      $(".quantity_input").val(newnumber);
      $(".decrease_btn").removeClass("disabled");
      document.getElementById("decrease_btn").disabled = false;
      $(".increase_btn").removeClass("disabled");
      document.getElementById("increase_btn").disabled = false;
    }
  }
}

/*-------------------------------------------
    11. change cart quantity on click
--------------------------------------------- */

function changeCartQuantity(changeBy, p_id, max) {
  var p_id = parseInt(p_id);
  var minValue = 1;
  var maxValue = max;

  var oldnumber = parseInt($("#cart_quantity_" + p_id).text());
  if (isNaN(oldnumber)) {
    oldnumber = 1;
  }
  if (oldnumber >= minValue && oldnumber <= maxValue) {
    var newnumber = parseInt(oldnumber) + changeBy;

    if (newnumber < minValue) {
      console.log("min");
      $("#cart_decrease_btn_" + p_id).addClass("disabled");
      document.getElementById("cart_decrease_btn_" + p_id).disabled = true;
    } else if (newnumber > maxValue) {
      $("#cart_increase_btn_" + p_id).addClass("disabled");
      document.getElementById("cart_increase_btn_" + p_id).disabled = true;
    } else {
      // update qty on page

      $("#cart_quantity_" + p_id).text(newnumber);

      // update qty in session
      manageCart(p_id, "update");

      $("#cart_decrease_btn_" + p_id).removeClass("disabled");
      document.getElementById("cart_decrease_btn_" + p_id).disabled = false;
      $("#cart_increase_btn_" + p_id).removeClass("disabled");
      document.getElementById("cart_increase_btn_" + p_id).disabled = false;
      // window.location.reload();
    }
  }
}

/*-------------------------------------------
    12. manage Cart
--------------------------------------------- */

function manageCart(p_id, type) {
  if (type == "update") {
    var qty = parseInt($("#cart_quantity_" + p_id).text());
    console.log("update" + qty);
  } else {
    var qty = parseInt($("#quantity_input").val());
    console.log("add" + qty);
    if (isNaN(qty)) {
      qty = 1;
      console.log("add" + qty);
    }
  }
  $.ajax({
    url: "partials/_manage_cart.php",
    type: "post",
    data: "p_id=" + p_id + "&qty=" + qty + "&type=" + type,
    success: function (result) {
      if (type == "update" || type == "remove") {
        window.location.reload();
      } else {
        $(".cart_item_count span").html(result);
        // console.log('add'+result);

        window.location.href = window.location.href;
      }
    },
  });
}

/*-------------------------------------------
    13. email verification
--------------------------------------------- */

function email_send_otp() {
  $("#signup_email_error").html("");
  var email = $("#signup_email").val();

  if (email == "") {
    $("#signup_email_error").html("Please enter your Email Id.");
  } else {
    $("#email_otp").html("Please wait...");
    $("#email_otp").attr("disabled", true);
    $.ajax({
      url: "send_otp.php",
      type: "post",
      data: "email=" + email + "&type=email",
      success: function (result) {
        if (result == "sent") {
          $("#signup_email").attr("disabled", true);
          $("#signup_email_otp").show();
          $("#email_verify").show();
          $("#email_otp").hide();
          $("#email_otp").attr("disabled", false);
        } else if (result == "exists") {
          $("#signup_email_error").html("Email Id already registerd.");
          $("#email_otp").html("Send OTP");
          $("#email_otp").attr("disabled", false);
        } else {
          $("#signup_email_error").html("Please try again later.");
          $("#email_otp").html("Send OTP");
          $("#email_otp").attr("disabled", false);
        }
      },
    });
  }
}

function email_verify_otp() {
  $("#signup_email_error").html("");
  var otp = $("#signup_email_otp").val();

  if (otp == "") {
    $("#signup_email_error").html("Please enter OTP.");
  } else {
    $.ajax({
      url: "verify_otp.php",
      type: "post",
      data: "otp=" + otp + "&type=email",
      success: function (result) {
        if (result == "verified") {
          $("#signup_email").attr("disabled", true);
          $("#signup_email_otp").hide();
          $("#email_verify").hide();
          $("#email_otp").hide();
          $("#signup_email_verified").html("Email verified.");
          $("#email_verified").val("1");
          if ($("#mobile_verified").val() == 1) {
            $("#signup_btn").attr("disabled", false);
          }
        } else {
          $("#signup_email_error").html("Incorrect OTP.");
        }
      },
    });
  }
}

/*-------------------------------------------
    14. Phone number verification
--------------------------------------------- */

function mobile_send_otp() {
  $("#signup_mobile_error").html("");
  var mobile = $("#signup_mobile").val();

  if (mobile == "") {
    $("#signup_mobile_error").html("Please enter your mobile no.");
  } else {
    $("#mobile_otp").html("Please wait...");
    $("#mobile_otp").attr("disabled", true);
    $.ajax({
      url: "send_otp.php",
      type: "post",
      data: "mobile=" + mobile + "&type=mobile",
      success: function (result) {
        if (result == "sent") {
          $("#signup_mobile").attr("disabled", true);
          $("#signup_mobile_otp").show();
          $("#mobile_verify").show();
          $("#mobile_otp").hide();
          $("#mobile_otp").attr("disabled", false);
        } else if (result == "exists") {
          $("#signup_mobile_error").html("Mobile no. already registerd.");
          $("#mobile_otp").html("Send OTP");
          $("#mobile_otp").attr("disabled", false);
        } else {
          $("#signup_mobile_error").html("Please try again later.");
          $("#mobile_otp").html("Send OTP");
          $("#mobile_otp").attr("disabled", false);
        }
      },
    });
  }
}

function mobile_verify_otp() {
  $("#signup_mobile_error").html("");
  var otp = $("#signup_mobile_otp").val();
  console.log(otp);

  if (otp == "") {
    $("#signup_mobile_error").html("Please enter OTP.");
  } else {
    $.ajax({
      url: "verify_otp.php",
      type: "post",
      data: "otp=" + otp + "&type=mobile",
      success: function (result) {
        if (result == "verified") {
          console.log(result);
          $("#signup_mobile").attr("disabled", true);
          $("#signup_mobile_otp").hide();
          $("#mobile_verify").hide();
          $("#mobile_otp").hide();
          $("#signup_mobile_verified").html("Mobile no. verified.");
          $("#mobile_verified").val("1");

          if ($("#email_verified").val() == 1) {
            $("#signup_btn").attr("disabled", false);
          }
        } else {
          $("#signup_mobile_error").html("Incorrect OTP.");
        }
      },
    });
  }
}

/*-------------------------------------------
    15. User Sign up
--------------------------------------------- */

function signup() {
  jQuery(".error_message").html("");
  var name = jQuery("#signup_name").val();
  var email = jQuery("#signup_email").val();
  var mobile = jQuery("#signup_mobile").val();
  var password = jQuery("#signup_password").val();
  var is_error = "";

  if (name == "") {
    jQuery("#signup_name_error").html("Please enter your name");
    is_error = true;
  }
  if (email == "") {
    jQuery("#signup_email_error").html("Please enter your name");
    is_error = true;
  }
  if (mobile == "") {
    jQuery("#signup_mobile_error").html("Please enter your mobile no.");
    is_error = true;
  }
  if (password == "") {
    jQuery("#signup_password_error").html("Please enter password");
    is_error = true;
  }

  if (!is_error) {
    jQuery.ajax({
      url: "partials/_signup.php",
      type: "post",
      data:
        "name=" +
        name +
        "&email=" +
        email +
        "&mobile=" +
        mobile +
        "&password=" +
        password,
      success: function (result) {
        if (result == "insert") {
          window.location.href = "login.php";
        }
        if (result == "exists") {
          jQuery("#signup_email_error").html("Email already registerd");
        }
      },
    });
  }
}

/*-------------------------------------------
    16. user login
--------------------------------------------- */

function login() {
  jQuery(".error_message").html("");
  var email = jQuery("#login_email").val();
  var password = jQuery("#login_password").val();
  var is_error = "";

  if (email == "") {
    jQuery("#login_email_error").html("Please enter your email address");
    is_error = true;
  }
  if (password == "") {
    jQuery("#login_password_error").html("Please enter password");
    is_error = true;
  }
  if (!is_error) {
    jQuery.ajax({
      url: "partials/_login.php",
      type: "post",
      data: "&email=" + email + "&password=" + password,
      success: function (result) {
        t_res = result.trim();
        if (t_res == "nouser") {
          jQuery("#login_email_error").html("User is not registered.");
        }
        if (t_res == "wrong") {
          jQuery("#login_password_error").html("Incorrect Password");
        }
        if (t_res == "logged") {
          window.location.href = window.location.href;
        }
      },
    });
  }
}

/*-------------------------------------------
    17. forgot password OTP
--------------------------------------------- */

function forgot_send_otp() {
  $("#forgot_email_error").html("");
  var email = $("#forgot_email").val();

  if (email == "") {
    $("#forgot_email_error").html("Please enter your registered email id.");
  } else {
    $("#forgot_otp").html("Please wait...");
    $("#forgot_otp").attr("disabled", true);
    $.ajax({
      url: "send_otp.php",
      type: "post",
      data: "email=" + email + "&type=forgot",
      success: function (result) {
        if (result == "sent") {
          $("#forgot_email").attr("disabled", true);
          $("#forgot_email_otp").show();
          $("#forgot_verify").show();
          $("#forgot_otp").hide();
          $("#forgot_otp").attr("disabled", false);
        } else if (result == "notexists") {
          $("#forgot_email_error").html("Email id is not registerd.");
          $("#forgot_otp").html("Send OTP");
          $("#forgot_otp").attr("disabled", false);
        } else {
          $("#signup_mobile_error").html("Please try again later.");
          $("#forgot_otp").html("Send OTP");
          $("#forgot_otp").attr("disabled", false);
        }
      },
    });
  }
}

function forgot_verify_otp() {
  $("#forgot_email_error").html("");
  var otp = $("#forgot_email_otp").val();
  var email = $("#forgot_email").val();

  console.log(otp);
  console.log(email);

  if (otp == "") {
    $("#forgot_email_error").html("Please enter OTP.");
  } else {
    $.ajax({
      url: "verify_otp.php",
      type: "post",
      data: "otp=" + otp + "&email=" + email + "&type=forgot",
      success: function (result) {
        console.log(result);
        if (result == "verified") {
          window.location.href = "change_password.php";
        } else {
          $("#forgot_email_error").html("Incorrect OTP.");
        }
      },
    });
  }
}

/*-------------------------------------------
    18. manage Wishlist
--------------------------------------------- */

function manageWishlist(p_id, type) {
  $.ajax({
    url: "partials/_manage_wishlist.php",
    type: "post",
    data: "p_id=" + p_id + "&type=" + type,
    success: function (result) {
      console.log(result);
      if (result == "remove") {
        window.location.reload();
      } else if (result == "not_login") {
        window.location.href = "login.php";
      } else {
        $(".wishlist_item_count span").html(result);

        // window.location.href = window.location.href;
      }
    },
  });
}
