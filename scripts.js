$(document).ready(function () {
  $("#logForm").submit(function (e) {
    e.preventDefault();
    var email = $("#email").val();
    var password = $("#password").val();
    var otp = $("#otp").val();
    var doaction = "login";
    if (otp.length > 0) {
      doaction = "verify2fa";
    }
    if (email === "" || password === "") {
      showErrorMessage("Please enter both email and password.");
    } else {
      $.ajax({
        url: "action.php",
        type: "POST",
        data: {
          action: doaction,
          email: email,
          password: password,
          two_fa_code: otp,
        },
        success: function (response) {
          if (response.status === "twofactor") {
            $("#two_fa_div").removeClass("d-none").hide().fadeIn();
            showSuccessMessage(response.message);
          } else if (response.status === "success") {
            showSuccessMessage(response.message);
            setTimeout(function () {
              window.location.replace("home.php");
            }, 2500);
          } else {
            showErrorMessage(response.message);
          }
        },
        error: function () {
          showErrorMessage("Registration failed. Please try again.");
        },
      });
    }
  });

  $("#regForm").submit(function (e) {
    e.preventDefault();
    var name = $("#name").val();
    var email = $("#email").val();
    var password = $("#password").val();
    var cpassword = $("#cpassword").val();
    if (name === "" || email === "" || password === "" || cpassword === "") {
      showErrorMessage("Please fill in all fields.");
    } else if (password !== cpassword) {
      showErrorMessage("Passwords do not match.");
    } else {
      $.ajax({
        url: "action.php",
        type: "POST",
        data: {
          action: "register",
          name: name,
          email: email,
          password: password,
          cpassword: cpassword,
        },
        success: function (response) {
          if (response.status === "success") {
            showSuccessMessage(response.message);
          } else {
            showErrorMessage(response.message);
          }
        },
        error: function () {
          showErrorMessage("Registration failed. Please try again.");
        },
      });
    }
  });

  function showErrorMessage(message) {
    removeAlerts();
    var alertDiv = $('<div class="alert alert-danger" role="alert"></div>');
    alertDiv.html(message);
    $("#alerts").prepend(alertDiv).hide().fadeIn();
  }

  function showSuccessMessage(message) {
    removeAlerts();
    var alertDiv = $('<div class="alert alert-success" role="alert"></div>');
    alertDiv.html(message);
    $("#alerts").prepend(alertDiv).hide().fadeIn();
  }

  function removeAlerts() {
    $(".alert").remove();
  }
});
