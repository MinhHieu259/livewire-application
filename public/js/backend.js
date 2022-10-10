/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************!*\
  !*** ./resources/js/backend.js ***!
  \*********************************/
window.addEventListener('show-form', function (event) {
  $('#form').modal('show');
});
window.addEventListener('show-delete-modal', function (event) {
  $('#confirmationModal').modal('show');
});
window.addEventListener('hide-delete-modal', function (event) {
  $('#confirmationModal').modal('show');
  toastr.success(event.detail.message, 'Success!');
});
window.addEventListener('alert', function (event) {
  $('#confirmationModal').modal('show');
  toastr.success(event.detail.message, 'Success!');
});
window.addEventListener('updated', function (event) {
  toastr.success(event.detail.message, 'Success!');
});
$('[x-ref="profileLink"]').on('click', function () {
  localStorage.setItem('_x_currentTab', '"profile"');
});
$('[x-ref="changePasswordLink"]').on('click', function () {
  localStorage.setItem('_x_currentTab', '"changePassword"');
});
$(document).ready(function () {
  toastr.options = {
    "positionClass": "toast-bottom-right",
    "progressBar": true
  };
  window.addEventListener('hide-form', function (event) {
    $('#form').modal('hide');
    toastr.success(event.detail.message, 'Success!');
  });
});
/******/ })()
;