$(document).ready(function() {
    //  Load file for voice tags
    $('.file-input input').change(function() {
        var fileInput = $(this);
        var fileLabel = fileInput.next('.file-label');
        var filename = fileInput.val().split('\\').pop();
        if(filename !== null && typeof filename != 'undefined') {
            fileLabel.text("File Loaded");
            fileLabel.attr('title', filename);
        }
    });

    // play audio and resize/animate audio widget
    $('.audioPlay').click(function() {
        var curr = $(this);
        var prev = curr.prev().get(0);
        console.log(curr.prev().attr('src'));
        curr.hide();
        prev.controls = true;
        prev.load();
        setTimeout(function() {
            curr.prev().removeClass('audio-player-min');
            curr.prev().addClass('audio-player-max');
        }, 100);
        $('.audio-file').parent('a').css('pointer-events', 'none');
        prev.play();
        prev.addEventListener('ended', (event) => {
            curr.prev().removeClass('audio-player-max');
            curr.prev().addClass('audio-player-min');
            setTimeout(function() {
                prev.controls = false;
                prev.load();
                curr.show();
                $('.audio-file').parent('a').css('pointer-events', 'all');
            }, 300);
        });
    });
    $('.dayOneAudioPlay').click(function() {
        var audio1 = $('.day-one:eq(0)').attr('src');
        var audio2 = $('.day-one:eq(1)').attr('src');
        var audio3 = $('.day-one:eq(2)').attr('src');
        var audio4 = $('.day-one:eq(3)').attr('src');
        var dayOneAudios = [audio1, audio2, audio3, audio4];
        playAudios(dayOneAudios);
    });
    $('.dayTwoAudioPlay').click(function() {
        var audio1 = $('.day-two:eq(0)').attr('src');
        var audio2 = $('.day-two:eq(1)').attr('src');
        var audio3 = $('.day-two:eq(2)').attr('src');
        var audio4 = $('.day-two:eq(3)').attr('src');
        var audio5 = $('.day-two:eq(4)').attr('src');
        var dayTwoAudios = [audio1, audio2, audio3, audio4, audio5];
        playAudios(dayTwoAudios);
    });
    $('.dayThreeAudioPlay').click(function() {
        var audio1 = $('.day-three:eq(0)').attr('src');
        var audio2 = $('.day-three:eq(1)').attr('src');
        var audio3 = $('.day-three:eq(2)').attr('src');
        var audio4 = $('.day-three:eq(3)').attr('src');
        var audio5 = $('.day-three:eq(4)').attr('src');
        var dayThreeAudios = [audio1, audio2, audio3, audio4, audio5];
        playAudios(dayThreeAudios);
    });

    function playAudios(allAudios) {
        $('.audio-file').parent('a').css('pointer-events', 'none');
        var audio = new Audio(allAudios[0]);
        audio.src = allAudios[0];
        audio.play();
        var index = 1;
        audio.onended = function() {
            if(index < allAudios.length) {
                audio.src = allAudios[index];
                audio.play();
                index++;
            } else {
                $('.audio-file').parent('a').css('pointer-events', 'all');
            }
        }
    }

    // populate textarea/input field for recordings
    $('.select2').on('change', function() {
        var currElement = $(this);
        var textarea = currElement.parent().next().find('textarea');
        var name = currElement.find(':selected').data('name');
        var userIdInput = currElement.parent().next().find('#user_audio_form_userId');
        var companyIdInput = currElement.parent().next().find('#insurance_audio_form_companyId');
        if(name !== null && typeof name != 'undefined') {
            textarea.val(textarea.val().replace('-------', name));
            if(typeof userIdInput != 'undefined') {
                userIdInput.val(currElement.find(':selected').val());
            }
            if(typeof companyIdInput != 'undefined') {
                companyIdInput.val(currElement.find(':selected').val());
            }
        } else {
            textarea.val(textarea.data('default'));
            if(typeof userIdInput != 'undefined') {
                userIdInput.val(0);
            }
            if(typeof companyIdInput != 'undefined') {
                companyIdInput.val(0);
            }
        }
        var file = currElement.find(':selected').data('file');
        var submitButton = currElement.parent().next().find('button').find('i');
        if(typeof file != 'undefined' && file !== '') {
            submitButton.removeClass('bg-outline-dark');
            submitButton.addClass('bg-outline-theme');
            submitButton.attr('title', 'Re-Upload');
        } else {
            submitButton.removeClass('bg-outline-theme');
            submitButton.addClass('bg-outline-dark');
            submitButton.attr('title', 'Upload');
        }
    });
})