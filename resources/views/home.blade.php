<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laptop Chatbot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="{{ asset('public/assets/css/chat_style.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card mx-0 my-3 mx-md-3" style="height: 90vh;">
                    <div class="chat">
                        <div class="chat-header clearfix">
                            <div class="row">
                                <div class="col-lg-6">
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                        <img src="{{ asset('public/assets/image/chatbot.png') }}" alt="avatar">
                                    </a>
                                    <div class="chat-about">
                                        <h6 class="m-b-0">Laptop Chatbot</h6>
                                        <small class="my-auto" id="bot-online">Online</small>
                                        <div id="bot-typing">
                                            <div class="d-flex flex-row">
                                                <div class="d-flex flex-column">
                                                    <img src="{{ asset('public/assets/image/typing.gif') }}">
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <small class="my-auto">Bot is Typing</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chat-history pre-scrollable" id="chat-history-scroll" style="height: 80vh;">
                            <ul class="m-b-0" id="chat-history">
                            </ul>
                        </div>
                        <div class="chat-message clearfix">
                            <div class="input-group mb-0">
                                <input type="text" class="form-control" placeholder="Enter message here..." id="chat-msg">
                                <div class="input-group-prepend">
                                    <button class="input-group-text" id="chat-send" autocomplete="off"><i class="fa fa-send"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        let rootUrl = "{{ env('APP_URL') }}";
        var sesi = 1;
        var subsesi = 1;
        var jenis = -1;
        var datasesipert = [];
        var datasesijaw = [];

        $(document).ready(function() {
            let searchRef = @json(config('chat_commands.rekomendasi'));
            $('#chat-msg').autoComplete({
                minLength: 1,
                events: {
                    search: function(qry, callback) {
                        var finalSearch = searchRef.filter(item => item.toLowerCase().includes(qry) && sesi == 1);
                        callback(finalSearch);
                    }
                }
            });

            $("#bot-online").toggle();
            var dt = getDateAndTime();
            let chat1 = `<li class="clearfix">
            <div class="message-data">
                <span class="message-data-time">` + dt[1] + `, ` + dt[0] + `</span>
            </div>
            <div class="message my-message">{{ config('chat_commands.intro') }}</div>
        </li>`;

            scrollChatToBottom();

            setTimeout(function() {
                $('#chat-history').append(chat1);

                $("#bot-online").toggle();
                $("#bot-typing").toggle();
                setTimeout(function() {
                    $("#bot-online").toggle();
                    $("#bot-typing").toggle();

                    dt = getDateAndTime();

                    let chat2 = `<li class="clearfix">
                    <div class="message-data">
                        <span class="message-data-time">` + dt[1] + `, ` + dt[0] + `</span>
                    </div>
                    <div class="message my-message">
                        {!! config('chat_commands.replies')[0] !!}
                    </div>
                </li>`;

                    setTimeout(function() {
                        $("#bot-online").toggle();
                        $("#bot-typing").toggle();
                        $('#chat-history').append(chat2);
                        scrollChatToBottom();
                    }, 2000);
                }, 1000);
            }, 2000);
        });
        $('#chat-msg').keypress(function(e) {
            if (e.which == 13) {
                sendChat();
            }
        });
        $("#chat-send").click(function() {
            sendChat();
        });

        function getDateAndTime() {
            let today = new Date();
            var appendH = '';
            var appendM = '';
            var appendMonth = '';
            var appendDate = '';
            if (today.getHours() < 10)
                appendH = '0';
            if (today.getMinutes() < 10)
                appendM = '0';
            if (today.getSeconds() < 10)
                appendS = '0';
            if (today.getMonth() + 1 < 10)
                appendMonth = '0';
            if (today.getDate() < 10)
                appendDate = '0';
            let time = appendH + today.getHours() + ":" + appendM + today.getMinutes();
            let date = today.getFullYear() + '-' + appendMonth + (today.getMonth() + 1) + '-' + appendDate + today.getDate();

            return [date, time];
        }

        function sendChat() {
            let msg = $('#chat-msg').val().replace(/</g, "&lt;").replace(/>/g, "&gt;");
            var dt = getDateAndTime();
            if (msg.length > 0) {
                $('#chat-msg').blur();

                var i = msg.length;
                var msgDisplay = msg;
                while (i < 40) {
                    msgDisplay += '&nbsp;';
                    i++;
                }

                $("#bot-online").toggle();
                $("#bot-typing").toggle();

                setTimeout(function() {
                    if (sesi == 3) {
                        datasesijaw.push(msg);
                        subsesi++;
                        if (subsesi <= datasesipert.length) {
                            let chat1 = `<li class="clearfix">
                            <div class="message-data">
                                <span class="message-data-time">` + dt[1] + `, ` + dt[0] + `</span>
                            </div>
                            <div class="message my-message">` + datasesipert[subsesi - 1] + `</div>
                        </li>`;
                            $('#chat-history').append(chat1);
                            $("#bot-online").toggle();
                            $("#bot-typing").toggle();
                            scrollChatToBottom();
                        } else {
                            let command;
                            if (jenis == 0) {
                                command = 'Rekomendasi laptop dari harga ' + datasesijaw[0] + ' sampai harga ' + datasesijaw[1];
                            } else if (jenis == 1) {
                                command = 'Rekomendasi laptop dengan merek ' + datasesijaw[0];
                            } else if (jenis == 2) {
                                command = 'Rekomendasi laptop dengan nama ' + datasesijaw[0];
                            } else if (jenis == 3) {
                                command = 'Rekomendasi laptop dengan prosesor ' + datasesijaw[0];
                            } else if (jenis == 4) {
                                command = 'Rekomendasi laptop dengan rincian ' + datasesijaw[0];
                            } else if (jenis == 5) {
                                command = 'Rekomendasi laptop dengan ukuran ' + datasesijaw[0];
                            }
                            $.ajax({
                                url: "{{ route('rekomendasi.post') }}",
                                type: "POST",
                                contentType: "application/json; charset=utf-8",
                                data: JSON.stringify({
                                    'sesi': sesi,
                                    'chat': command
                                })
                            }).done(function(response) {
                                onChatResponse(response);
                            });
                        }
                    } else {
                        $.ajax({
                            url: "{{ route('rekomendasi.post') }}",
                            type: "POST",
                            contentType: "application/json; charset=utf-8",
                            data: JSON.stringify({
                                'sesi': sesi,
                                'chat': msg
                            })
                        }).done(function(response) {
                            onChatResponse(response);
                        });
                    }
                }, 2000);

                let chat = `<li class="clearfix">
                            <div class="message-data text-right">
                                <span class="message-data-time">` + dt[1] + `, ` + dt[0] + `</span><span class="font-weight-bold message-data-time">Anda</span>
                            </div>
                            <div class="message other-message float-right">` + msgDisplay + `</div>
                        </li>`;
                $('#chat-history').append(chat);

                $('#chat-msg').val('');
                $("#chat-send").blur();
                scrollChatToBottom();
            }
        }

        function onChatResponse(response) {
            sesi = response.sesi;
            let dt = getDateAndTime();
            if (sesi != 3) {
                for (var i = 0; i < response.reply.length; i++) {
                    if (response.reply[i] == "#data") {
                        for (var j = 0; j < response.data.length; j++) {
                            let chat1;
                            if (response.data[j].constructor != ({}).constructor) {
                                chat1 = `<li class="clearfix">
                                <div class="message-data">
                                    <span class="message-data-time">` + dt[1] + `, ` + dt[0] + `</span>
                                </div>
                                <div class="message my-message">` + response.data[j] + `</div>
                            </li>`;
                            } else {
                                response.data[j].gambar = rootUrl + '/public/assets/image/laptop/' + response.data[j].gambar;
                                response.data[j].nama = '<b>' + response.data[j].nama + '</b>';
                                response.data[j].rincian = response.data[j].rincian.replace(/(?:\r\n|\r|\n)/g, '<br/>');
                                let internalmsg = `
                                ` + response.data[j].nama + `<br/>
                                <img class="my-2" src="` + response.data[j].gambar + `">
                                <br/>Merek: ` + response.data[j].merk + `<br/>
                                Prosesor: ` + response.data[j].cpu + `<br/>
                                Ukuran: ` + response.data[j].ukuran + ` Inch<br/>
                                Harga: Rp ` + response.data[j].harga.toLocaleString('de-DE') + `<br/>
                                <br/>Rincian:<br/><br/>` + response.data[j].rincian + `
                            `;
                                chat1 = `<li class="clearfix">
                                <div class="message-data">
                                    <span class="message-data-time">` + dt[1] + `, ` + dt[0] + `</span>
                                </div>
                                <div class="message my-message">` + internalmsg + `</div>
                            </li>`;
                            }
                            $('#chat-history').append(chat1);
                        }
                    } else {
                        let chat1 = `<li class="clearfix">
                        <div class="message-data">
                            <span class="message-data-time">` + dt[1] + `, ` + dt[0] + `</span>
                        </div>
                        <div class="message my-message">` + response.reply[i] + `</div>
                    </li>`;
                        $('#chat-history').append(chat1);
                    }
                }
            } else {
                subsesi = 1;
                jenis = response.jenis;
                datasesipert = response.reply;
                datasesijaw.splice(0, datasesijaw.length);
                let chat1 = `<li class="clearfix">
                <div class="message-data">
                    <span class="message-data-time">` + dt[1] + `, ` + dt[0] + `</span>
                </div>
                <div class="message my-message">` + response.reply[subsesi - 1] + `</div>
            </li>`;
                $('#chat-history').append(chat1);
            }
            setTimeout(function() {
                $("#bot-online").toggle();
                $("#bot-typing").toggle();
                scrollChatToBottom();
            }, 300);
        }

        function scrollChatToBottom() {
            $("#chat-history-scroll").animate({
                scrollTop: $('#chat-history-scroll').prop('scrollHeight')
            }, "slow", "swing");
        }
    </script>
    <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>

</body>

</html>