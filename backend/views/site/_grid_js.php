<?php
/* @var \yii\web\View $this */

$actionUrl = \yii\helpers\Url::to(['site/apple-action']);

$this->registerJs(<<<JS

let sendAction = function (data) {
    $.ajax({
        url: '$actionUrl',
        method: 'post',
        data: data,
        success: function () {
            $.pjax.reload({container: '#listPjax'});
        },
        error: function (data) {
            let modal = $('#error-modal');
            modal.find('.modal-body').html(data.responseJSON.join('<br>'));
            $('#error-modal').modal('show');
        }
    });
}

$(document).on('click', '.btn-delete', function (e) {
    sendAction({action: 'delete', id: e.target.dataset.id});
});

$(document).on('click', '.btn-eat', function (e) {
    sendAction(
        {
            action: 'eat',
            id: e.target.dataset.id,
            percent: $(e.target).parents('.item').find('.eat_percent').val()
        });
});

$(document).on('click', '.btn-fall', function (e) {
    sendAction({action: 'fall', id: e.target.dataset.id});
});

JS, \yii\web\View::POS_READY);
