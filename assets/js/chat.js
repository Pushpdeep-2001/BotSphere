$(function () {
    const textInput = $("#textInput");
    const botID = textInput.data('bot');

    textInput.keyup((event) => {
        if (event.target.value !== "") {
            if (event.which === 13) {
                //display posted message
                storeMessages(event.target.value, 'User', botID)
                displayUserMsg(event.target.value);
                textInput.val('');
                textInput.prop('disabled', true);
            }
        }
    });


    //function to send request
    function getMsgDiv(type, callback) {
        $.getJSON('core/ajax/getMsgDiv.php', { type: type })
            .done(function (data) {
                if (typeof callback === 'function') {
                    callback(data);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.error('error: ', errorThrown)
            })
    }

    //function to display posted message
    function displayUserMsg(value) {
        getMsgDiv('User', function (data) {
            let message = data.html.replace('[message]', value);
            $("#chat").append(message);
            scrollDown();
            getMessageFromAI(value);
        });
    }


    //function messages in database
    function storeMessages(message, type, botID) {
        $.post('core/ajax/storeMessage.php', { message: message, type: type, botID: botID });
    }


    //function to get message from AI
    function getMessageFromAI(prompt) {
        //display loader
        getLoader();

        //requst a send to get response from AI
        $.ajax({
            url: 'core/ajax/getResponse.php',
            method: 'POST',
            data: { prompt: prompt, botID: botID },
            datatype: 'json',
            success: function (msg) {
                getMsgDiv('AI', function (data) {
                    let message = data.html.replace('[message]', msg);
                    $("#space").remove();
                    $("#loader").remove();
                    $("#chat").append(message);
                    type(msg);
                    scrollDown();
                    textInput.prop('disabled', false);
                });

            }

        })

    }


    //function to display gif loder
    function getLoader() {
        $.getJSON('core/ajax/getMsgDiv.php', { type: 'loader' })
            .done(function (data) {
                $("#space").remove();
                $("#chat").append(data.html);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.error('error: ', errorThrown)
            })
    }

    //function to scroll down to new message
    function scrollDown(){
        let height = $("#scroll")[0].scrollHeight;
        $("#scroll").animate({scrollTop:height}, "slow");

    }

    //function to add typing effect

    function type(html){
        let i = 0;
        let currentMessage = $(".message:last").find("#text");

        function startTyping(){
            if(i<html.length){
                let char = html.charAt(i);
                if(char === '`' && html.substring(i, i+3) === '```'){
                    let codeSnippet = html.substring(i).match(/```([\s\S]*?)\n([\s\S]*?)\n```/s);
                    if(codeSnippet){
                        let language = codeSnippet[1] || "php";
                        let code     = codeSnippet[2];

                        currentMessage.append('<pre><code class="language-'+language+'"></code></pre>');
                        let codeElement = currentMessage.find('code').last();


                        let c = 0;
                        function typeCode(){
                            if(c < code.length){
                                let codeChar = code.charAt(c);
                                codeElement.append(codeChar);
                                Prism.highlightAll();
                                c++;
                                setTimeout(typeCode, 10);
                            }else{
                                Prism.highlightAll();
                                i +=codeSnippet[0].length - 2;
                                i +=3;
                                scrollDown();
                                setTimeout(startTyping, 10);
                            }
                        }
                        scrollDown();
                        typeCode();
                        return;
                    }
                }
                currentMessage.append(char);
                i++;
                setTimeout(startTyping, 10);
            }
        }
        setTimeout(startTyping, 0);

    }

    scrollDown();


});