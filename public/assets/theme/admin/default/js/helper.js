
var $preloader = $('.preloader:first');
$preloader.css('background', 'rgba(0, 0, 0, 0.1)');

var $validationErrors = {
    required: 'The :attribute field is required.',
    url: 'The :attribute field must be a valid URL.',
    email: 'The :attribute must be a valid email address.',
    confirmed: 'The :attribute confirmation does not match.',
    image: 'The :attribute must be an image.',
    same: 'The :attribute and :attribute2 must match.',
    minLen: 'The :attribute must be at least :min characters.',
    numeric: 'The :attribute must be a number.',
    phone: 'The :attribute must be a valid phone number.',
    slug: 'The :attribute must be a valid slug format.',
};

var $validationRegexps = {
    url: /^(https?|ftp|torrent|image|irc):\/\/(-\.)?([^\s\/?\.#]+\.?)+(\/[^\s]*)?$/i,
    email: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
    numeric: /^[0-9]+$/,
    slug: /^[a-z0-9]+(?:-[a-z0-9]+)*$/,
};

function fnShowLoader() {
    $preloader.show();
    return true;
}

function fnHideLoader() {
    $preloader.hide();
    return true;
}

function fnAjax($config) {
    var $default = {
        url: '',
        method: 'GET',
        data: {}
    };

    var $settings = $.extend({}, $default, $config);
    $settings.beforeSend = function (xhr) {
        fnShowLoader();
        if (typeof $config.beforeSend === 'function') {
            $config.beforeSend(xhr);
        }
    }
    $settings.success = function (result, status, xhr) {
        fnHideLoader();
        if (typeof $config.success === 'function') {
            $config.success(result, status, xhr);
        }
    }
    $settings.error = function (xhr, status, error) {
        fnHideLoader();
        if (typeof $config.error === 'function') {
            $config.error(xhr, status, error);
        }
    }

    return $.ajax($settings);
}

function fnRedirect(url) {
    location.href = url;
}

function fnConfirm($textOrOpts, $successCb, $cancelCb)
{
    var $opts = {
        title: "",// "Are you sure?",
        text: "Are you sure you want to proceed?",
        type: "warning",
        showCancelButton: true,
        //confirmButtonClass: "btn-danger",
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "Cancel",
        closeOnConfirm: true,
        closeOnCancel: true
    };

    if ($textOrOpts === Object($textOrOpts)) {
        $opts = $.extend({}, $opts, $textOrOpts);
    } else {
        if ($textOrOpts != '') {
            $opts.text = $textOrOpts;
        }
    }

    return swal($opts,
    function (isConfirm) {
        if (isConfirm) {
            if (typeof $successCb === 'function') {
                return $successCb();
            }
            return true;
        } else {
            if (typeof $cancelCb === 'function') {
                return $cancelCb();
            }
            return false;
        }
    });
}

function fnAlert($msg, $cb) {
    swal({
        title: 'Alert!',
        text: $msg,
    },
    function() {
        if (typeof $cb === 'function') {
            $cb();
        }
    });
}

function fnFocus($idOrElem) {
    if (typeof $idOrElem == "string") {
        $idOrElem = $('#' + $idOrElem);
    }
    if (!$idOrElem.length) {
        return false;
    }
    $idOrElem.focus();
    return true;
}

function fnReplaceText($str, $replaceList = {}) {
    if (typeof $str === 'undefined' || $str === '') {
        return '';
    }
    if (!Object.keys($replaceList).length) {
        return $str;
    }
    for (var $i in $replaceList) {
        $str = $str.replace($i, $replaceList[$i]);
    }
    return $str;
}

function fnAddInputError($input, $message) {
    if (!$input.length) {
        return false;
    }
    var $start = '<small class="form-control-feedback text-danger">';
    var $end = '</small>';
    
    $input.after($start + $message + $end);
    var $container = $input.closest('.form-group');
    if ($container.length) {
        $container.addClass('has-danger');
    }
    return true;
}
function fnRemoveInputErrors($form) {
    if ($form.length) {
        $form.find('.form-group').removeClass('has-danger');
        $form.find('small.form-control-feedback.text-danger').remove();
        return true;
    }
    $('form .form-group').removeClass('has-danger');
    $('form small.form-control-feedback.text-danger').remove();
    return true;
}
function fnValidatePhoneNumber($phoneNumber) {
   
    if ($phoneNumber == '') {
        return false;
    }

    var $formats = [
        //10 digits with no comma, no spaces, no punctuation and there will be no + sign in front the number
        /^\d{10}$/,
        // XXX-XXX-XXXX
        // XXX.XXX.XXXX
        // XXX XXX XXXX
        /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/,
        // +XX-XXXX-XXXX
        // +XX.XXXX.XXXX
        // +XX XXXX XXXX
        /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/
    ];

    for(var $i in $formats) {
        if ($formats[$i].test($phoneNumber)) {
            return true;
        }
    }
    
    return false;
}

function fnCopyText($elm) {
    var $targets = $($elm.data('copy-text-target'));
    $elm.keyup(function () {
        var $elm = $(this);
        var $val = $elm.val();
        var $targets = $($elm.data('copy-text-target'));
        if ($targets.length) {
            $targets.each(function (index, elm) {
                var $target = $(this);
                var $changed = $target.data('copy-text-changed');
                if (typeof $changed === 'undefined') {
                    $target.val($val);
                }
            });
        }
    });
    $targets.keyup(function () {
        if ($(this).val() != '') {
            $(this).data('copy-text-changed', 1);
        } else {
            $(this).removeData('copy-text-changed');
        }
    });
}

$(function(){
    $(window).bind('beforeunload', function(){
        fnShowLoader();
        return;
    });

    // first load
    var $checkItems = $('.es.es-check-items');
    if ($checkItems.length) {
        $checkItems.each(function(){
            var $elm = $(this);
            var $items = $($elm.data('check-items-selector'));
            console.log($items);
            if ($items.length) {
                $items.on('change', function () {
                    if ($(this).is(':checked')) {
                        if ($items.length == $items.filter(":checked").length) {
                            $elm.prop('checked', true);
                        }
                    } else {
                        $elm.prop('checked', false);
                    }
                });
            }
        });
    }

    var $es = $('.es');
    $es.on('click', function(){
        var $elm = $(this);

        if ($elm.hasClass('es-alert')) {
            var $text = $elm.data('alert-text');
            if (typeof $text === 'undefined') {
                $text = '';
            }
            fnAlert($text);
            return false;
        }
        
        if ($elm.hasClass('es-check-items')) {
            var $selector = $elm.data('check-items-selector');
            
            if (typeof $selector !== 'undefined') {
                var $options = $($selector);
                if ($options.length) {
                    if ($elm.prop('checked') == true) { 
                        //$options.prop('checked', true);
                        $options.not(":checked").trigger('click');
                    } else {
                        //$options.prop('checked', false);
                        $options.filter(":checked").trigger('click');
                    }
                }
            }
        }

        if ($elm.hasClass('es-need-selected-items')) {
            var $selector = $elm.data('need-selected-items-selector');
            if (typeof $selector !== 'undefined') {
                if (!$($selector+':checked').length) {
                    fnAlert('No item(s) selected.');
                    return false;
                }
            }
        }

        if ($elm.hasClass('es-confirm')) {
            var $status = $elm.data('confirm-status');
            if (typeof $status === 'undefined') {
                event.preventDefault();
                var $title = $elm.data('confirm-title');
                var $text = $elm.data('confirm-text');
                var $type = $elm.data('confirm-type');
                var $opts = {};
                if (typeof $title !== 'undefined') {
                    $opts.title = $title;
                }
                if (typeof $text !== 'undefined') {
                    $opts.text = $text;
                }
                if (typeof $type !== 'undefined') {
                    $opts.type = $type;
                }

                fnConfirm($opts, function () {
                    $elm.data('confirm-status', true);
                    $elm[0].click();
                })
                return false;
            } else {
                $elm.removeData('confirm-status');
            }
        }

        if ($elm.hasClass('es-redirect')) {
            var $url = $(this).data('href');
            if (typeof $url !== 'undefined' && $url != '') {
                if ($elm.hasClass('es-loader')) {
                    fnShowLoader();
                }
                fnRedirect($url);
                return false;
            }
        }

        if ($elm.hasClass('es-focus')) {
            var $id = $(this).data('focus-id');
            if (typeof $id !== 'undefined' && $id != '') {
                setTimeout(function(){
                    fnFocus($id);
                },1);
                return true;
            }
        }

        if ($elm.hasClass('es-loader')) {
            fnShowLoader();
        }

        if ($elm.hasClass('es-submit')) {
            var $formId = $(this).data('form-id');
            if (typeof $formId !== 'undefined' && $formId != '') {
                var $form = $('#'+$formId);
                if ($form.length) {
                    var $formAction = $(this).data('form-action');
                    if (typeof $formAction !== 'undefined' & $formAction != '') {
                        $form.attr('action', $formAction);
                    }
                    $form.trigger('submit');
                }
            }
        }

        return true;
    });

    $es.on('submit', function(){
        var $form = $(this);

        fnRemoveInputErrors($form);
        if ($form.hasClass('es-validation')) {
            var $labels = $form.find('label[class*="es-"]');
            var $errors = [];
            if ($labels.length) {
                $labels.each(function () {
                    var $lbl = $(this);
                    var $inputLabel = $lbl.contents().get(0).nodeValue;
                    var $inputId = $lbl.attr('for');
                    if (typeof $inputId === 'undefined'
                        || $inputId === ''
                    ) {
                        return;
                    }
                    var $input = $form.find('#' + $inputId);
                    if (!$input.length) {
                        return;
                    }
                    // dont validate if input is disabled
                    if ($input.prop('disabled')) {
                        return;
                    }
                    var $inputValue = $input.val();

                    var $_input = $input;
                    var $isErrorAfterLabel = $lbl.data('error-after-label');
                    if (typeof $isErrorAfterLabel !== 'undefined' && $isErrorAfterLabel == true) {
                        $_input = $lbl;
                    }
                    var $nextNumber = $lbl.data('error-next-to');
                    if (typeof $nextNumber !== 'undefined') {
                        $nextNumber = parseInt($nextNumber);
                        var $next = $input.nextAll().eq($nextNumber);
                        if ($next.length) {
                            $_input = $next;
                        }
                    }

                    // required
                    if ($lbl.hasClass('es-required')
                        && ($inputValue == '' || $inputValue == null)
                    ) {
                        fnAddInputError($_input, fnReplaceText($validationErrors.required, {
                            ':attribute': $inputLabel
                        }));
                        $errors.push($_input);
                        return;
                    }

                    if ($inputValue != '') {
                        // regexp
                        for (var $regexp in $validationRegexps) {
                            if (!$lbl.hasClass('es-' + $regexp)) {
                                continue;
                            }
                            if (!$validationRegexps[$regexp].test($inputValue)) {
                                fnAddInputError($_input, fnReplaceText($validationErrors[$regexp], {
                                    ':attribute': $inputLabel
                                }));
                                $errors.push($_input);
                                return;
                            }
                        }

                        // phone number
                        if ($lbl.hasClass('es-phone') && !fnValidatePhoneNumber($inputValue)) {
                            fnAddInputError($_input, fnReplaceText($validationErrors.phone, {
                                ':attribute': $inputLabel
                            }));
                            $errors.push($_input);
                            return;
                        }

                        // image
                        if ($lbl.hasClass('es-image')) {
                            if (typeof $input[0].files !== 'undefined' 
                                && $input[0].files.length
                            ) {
                                var $file = $input[0].files[0];
                                var $fileType = $file['type'];
                                var $validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
                                if (!$validImageTypes.includes($fileType)) {
                                    fnAddInputError($_input, fnReplaceText($validationErrors.image, {
                                        ':attribute': $inputLabel
                                    }));
                                    $errors.push($_input);
                                    return;
                                }
                            }
                        }
                    }

                    var $inputLen = $inputValue != null ? $inputValue.length : 0;

                    if ($inputLen > 0) {
                        // min len
                        if ($lbl.hasClass('es-min-len')) {
                            var $minLen = $lbl.attr('data-min-len');
                            if (typeof $minLen != 'undefined' && $minLen > 0 && $inputLen < $minLen) {
                                fnAddInputError($_input, fnReplaceText($validationErrors.minLen, {
                                    ':attribute': $inputLabel,
                                    ':min':$minLen,
                                }));
                                $errors.push($_input);
                                return;
                            }
                        }
                    }

                    // confirmed
                    if ($lbl.hasClass('es-confirmed')) {
                        var $inputConfirmation = $('#' + $inputId + '_confirmation');
                        if (!$inputConfirmation.length || $inputConfirmation.val() != $inputValue) {
                            fnAddInputError($_input, fnReplaceText($validationErrors.confirmed, {
                                ':attribute': $inputLabel
                            }));
                            $errors.push($_input);
                            return;
                        }
                    }
                    // same
                    if ($lbl.hasClass('es-same')) {
                        var $targetId = $lbl.attr('data-same-target');
                        if (typeof $targetId !== 'undefined' && $targetId != '') {
                            var $target = $('#' + $targetId);
                            if ($target.length && $target.val() != $inputValue) {
                                var $targetLabel = $('label[for="' + $targetId+'"]');
                                if ($targetLabel.length) {
                                    $targetLabel = $targetLabel.contents().get(0).nodeValue;
                                } else {
                                    $targetLabel = $targetId;
                                }
                                fnAddInputError($_input, fnReplaceText($validationErrors.same, {
                                    ':attribute': $inputLabel,
                                    ':attribute2': $targetLabel,
                                }));
                                $errors.push($_input);
                                return;
                            }
                        }
                    }
                });
            }

            if ($errors.length) {
                // set focus to first input error
                setTimeout(function () {
                    $errors[0].focus();
                }, 100);
                return false;
            }
        }

        if ($form.hasClass('es-prevent')) {
            event.preventDefault();
            var $text = $form.data('prevent-text');
            if (typeof $text !== 'undefined' && $text != '') {
                fnAlert($text);
            }
            return false;
        }
        return true;
    })

    var $copyTextElems = $('.es.es-copy-text');
    if ($copyTextElems.length) {
        $copyTextElems.each(function(i, elm) {
            fnCopyText($(this));
        });
    }
});

function notify(type, message, timeout) {
    
    $.bootstrapGrowl(message, {
        offset : { from: 'bottom', amount: 10 },
        type: type,
        allow_dismiss: true
    })
}
