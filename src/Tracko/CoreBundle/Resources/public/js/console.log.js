/**
 * This is a fix for IE
 * Since console.log is not supported in IE I want to make sure our JS does not break
 * if we forget a console.log and ship it out to production
 */
if (typeof console === "undefined" || typeof console.log === "undefined") {
    console = {};
    console.log = function () {
    };
}