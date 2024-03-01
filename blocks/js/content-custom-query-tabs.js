jQuery(document).ready(function ($) {
  $(document).ready(function () {
    // Function to scroll the container and center the tab
    function scrollContainerToTab(tab) {
      const container = $(".custom-query-tabs .tabs");
      const offset =
        tab.offset().left -
        container.offset().left -
        container.width() / 2 +
        tab.width() / 2;

      container.animate(
        {
          scrollLeft: "+=" + offset,
        },
        "slow"
      );
    }

    // Check if there is a stored active tab and scroll to it
    var storedActiveTab = localStorage.getItem("activeTab");
    if (storedActiveTab) {
      var activeTab = $(
        ".custom-query-tabs .tabs .tab[href='" + storedActiveTab + "']"
      );
      if (activeTab.length) {
        scrollContainerToTab(activeTab);
      }
    }

    // Handle tab click
    $(".custom-query-tabs .tabs .tab").click(function () {
      // Scroll the container to center the clicked tab
      scrollContainerToTab($(this));

      // Update active tab in localStorage
      localStorage.setItem("activeTab", $(this).attr("href"));
    });
  });
});
