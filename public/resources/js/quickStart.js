let callSid = '';
let voicemailAudio = '';
$(function () {
    $.getJSON('https://periwinkle-guppy-7174.twil.io/capability-token')
        //Paste URL HERE
        .done(function (data) {
            console.log('Token: ' + data.token);

            // Setup Twilio.Device
            Twilio.Device.setup(data.token);

            Twilio.Device.error(function (error) {
                console.log(error);
            });

            Twilio.Device.connect(function (conn) {
                callSid = conn.parameters.CallSid;
            });

            Twilio.Device.disconnect(function (conn) {
            });

            Twilio.Device.incoming(function (conn) {
                var archEnemyPhoneNumber = '+12099517118';

                if (conn.parameters.From === archEnemyPhoneNumber) {
                    conn.reject();
                } else {
                    // accept the incoming connection and start two-way audio
                    conn.accept();
                }
            });

            // Show audio selection UI if it is supported by the browser.
        })
        .fail(function () {
        });

    // Bind button to hangup call
    // document.getElementById('button-hangup').onclick = function () {
    //     log('Hanging up...');
    //     Twilio.Device.disconnectAll();
    // };

    document.getElementById('voicemail').onclick = function () {
        Twilio.Device.activeConnection().mute(true);
    };
});

$(document).ready(function () {
    $('#voicemail').click(function () {
        $.ajax({
            type: 'POST',
            url: $(this).data('url'),
            data: { callSid: callSid, voicemailAudio: voicemailAudio },
            success: function (data, status) {
                console.log(data);
            }
        });
    })
    $('#call').click(function () {
        $.ajax({
            type: 'POST',
            // Need to update this url.
            url: '/admin/audio/7/secondDayAudio',
            success: function (data, status) {
                voicemailAudio = data;
                // Need to update param dynamically
                var params = {
                    To: '+923034049689',
                    From: '+1 231 729 6887'
                };
                Twilio.Device.connect(params);
            },
            error: function (data, status) {
            //    Need to do the work to show error message if not all audios uploaded
            }
        });
    })
});
