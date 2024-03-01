jQuery(document).ready(function ($) {
  $(document).ready(function () {
    const transcript = $("#fusebox-transcript #fbxt-wrap");
    const nav = $(
      "#fusebox-transcript #fbxt-wrap #fbxt-wrap--inner.fbxt-extra-class .fbxt-header"
    );
    const transcontainer = $(".fusebox-container");
    transcontainer.addClass("noaction");
    const buttonTranscript = $("#transcript-button");

    // Hide transcript and button when the button is clicked
    buttonTranscript.on("click", function () {
      transcontainer.addClass("withaction");
      buttonTranscript.hide();
    });
  });

  $(document).ready(function () {
    checkAndHideEmptyTranscript();
  });

  function checkAndHideEmptyTranscript() {
    const transcript = $("#fusebox-transcript .fbxt-content--inner");
    if (transcript.length > 0) {
      const isEmpty = $.trim(transcript.html()) === "";

      if (isEmpty) {
        // The transcript is empty, so hide it
        $("#fusebox-transcript").hide();
      }
    }
  }
});
