lightbox(".lightbox", {
    // Display captions, if available.
    captions: true,

    // Set the element where the caption is. Set it to "self" for the a-tag itself
    captionsSelector: "self",

    // Get the caption from given attribute.
    captionAttribute: "title",

    // Display navigation buttons. "auto" hides buttons on touch-enabled devices.
    nav: "auto",

    // Text or HTML for the navigation buttons.
    navText: ["&#10094;<br>Previous", "&#10095;<br>Next "],

    // Display close button.
    close: true,

    // Text or HTML for the close button.
    closeText: "&times;",

    // Display current image index
    counter: true,

    // Allow keyboard navigation.
    keyboard: true,

    // Display zoom icon.
    zoom: true,

    // Text or HTML for the zoom icon
    zoomText: "&plus;",

    // Closes the lightbox when clicking outside
    docClose: true,

    // Swipe up to close lightbox
    swipeClose: true,

    // Hide scrollbars if lightbox is displayed.
    scroll: false
});
