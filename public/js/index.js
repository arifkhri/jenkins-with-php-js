$(document).ready(function () {
    let branches = {};

    // set error criteria
    const errorServers = [{
        criteria: 'no space left',
        message:'Error Server: response: no space left on device'
    }, {
        criteria: 'Error from server (AlreadyExists)',
        message: 'Error from server (AlreadyExists): namespaces'
    }, {
        criteria: '504 Gateway Time-out',
        message: 'Error Server:: 504 Gateway Time-out'
    }, {
        criteria: `/app/engine main.go' returned a non-zero code: 2`,
        message: `Error Golang Report:  The command '/bin/sh -c go build -o /app/engine main.go' returned a non-zero code: 2`
    }, {
        criteria: 'Error: context deadline exceeded',
        message: 'Kubernetes Error Server: context deadline exceeded'
    }];

    const errorLines = [/ERROR\sin+(.|\n)+?(?=npm)/g, /Failed\sto\scompile+(.|\n)+?(?=npm)/g, /Build\serror\soccurred+(.|\n)+?(?=npm)/g]

    loadApps();
    
    async function loadApps() {
        refreshPage();
        const response = await request('home', 'get_apps', '');
        if (response) {
            data = JSON.parse(response);
            for (var key in data) {
                branches = {
                    ...branches,
                    ...data[key]
                };
                createOptions('#web_app', key, Object.keys(data[key])[0]);
            }
            $("#spinner").addClass("hidden");
            $(".empty").removeClass("hidden");
        }
    }

    function refreshPage(withoutSpinner) {
        if(!withoutSpinner) {
            $("#spinner").removeClass( "hidden" );
        }
        $('.output').css("background-color", "#fff");
        $(".output").css('min-height', '360px');
        $("pre").addClass("hidden");
    }


    async function getLog(params) {
        refreshPage();
        $("#redeploy").addClass("hidden");
        $(".empty").addClass("hidden");
        const response = await request('home', 'get_log', {
            webApp: params[0].value,
            branch: params[1].value,
        });
        await generateConsole(response);
        $(".output").css('min-height', '0');
        $("pre").removeClass("hidden");
        $("#redeploy").removeClass("hidden");
        $("#spinner").addClass("hidden");
    }

    async function buildApp(params) {
        refreshPage();
        const response = await request('home', 'build_app', {
            webApp: params[0].value,
            branch: params[1].value,
        });
        if(response.includes('success')) {
            $('.message').removeClass('hidden');
            setTimeout(() => {
                $('.message').addClass('hidden');
            }, 4000);
        }
        $(".empty").removeClass("hidden");
        $("#spinner").addClass("hidden");
    }

    function createOptions(idElement, labelData, valueData) {
        const option = new Option(labelData, valueData);
        $(idElement).append(option);
    }

    async function generateConsole(value) {
        $("code").remove();
        value = await normalizeConsole(value);
        $(`<code class="bash">${value.log}</code>`).appendTo('pre');

        $('.output').css("background-color", "#011627");
        if(value.status === 'FailServer') {
            $("code").css("color", "#c50c0c");
        } else if(value.status === 'success') {
            $("code").css("color", "#1C9116");
        }
        
        $('pre code').each(function(i, e) {hljs.highlightElement(e)});
    }

    function normalizeConsole(log) {
        let status = 'success';
        if(log.includes("Finished: FAILURE")) {
            for (let index = 0; index < errorServers.length; index++) {
                if(log.includes(errorServers[index].criteria)) {
                    log = errorServers[index].message + ' (；☉_☉) Azzz..';
                    status = 'FailServer';
                    break;
                }
            }

            if(status === 'success') {
                if(log.includes('next')) {

                }
                for (let index = 0; index < errorLines.length; index++) {
                    const lineError = log.match(errorLines[index]);
                    if(lineError) {
                        log = lineError;
                        status = 'Fail';
                        break;
                    }
                    
                }
                // console.log(log.match(/ERROR\sin+(.|\n)+?(?=npm)/g))
                // switch (true) {
                //     const regex1 = /ERROR\sin+(.|\n)+?(?=npm)/g;
                //     case ().test(log):
                //         log = log.match(/ERROR\sin+(.|\n)+?(?=npm)/g);
                //         status = 'Fail';
                        
                //         break;
                // }
                // const command = "nx run main-web:build:development "
                // log = log.match(/ERROR\sin+(.|\n)+/g);
                // log = errorLine;
                // status = 'Fail';
            }
            
        } else {
            log = 'Deploy Success (ᵒ̤̑ ₀̑ ᵒ̤̑)wow!*✰';
        }

        return {log,status};
    }

    async function request(className, methodName, params) {
        let data = null;
        $("#web_app").prop('disabled', true);
        $("#branch").prop('disabled', true);

        await $.ajax({
            type: "POST",
            url: "/php/Ajax_Handler.php",
            data: {
                class: className,
                method: methodName,
                params
            },
            success: function (result) {
                data = result;
            }
        });

        $("#web_app").prop('disabled', false);
        $("#branch").prop('disabled', false);
        return data;
    }

    $('#redeploy').on('click', function () {
        buildApp($("form").serializeArray());
    });

    $('#branch').on('change', function () {
        getLog($("form").serializeArray());
    });

    $('#web_app').on('change', function () {
        $("#redeploy").addClass("hidden");
        $(".empty").removeClass("hidden");
        $('#branch').find('option').remove();
        refreshPage(true);

        const selectWebApp = $("form").serializeArray()[0];
        createOptions('#branch', 'Select Branch', null);
        for (var branchKey in branches[selectWebApp.value]) {
            createOptions('#branch', branchKey, branches[selectWebApp.value][branchKey]);
        }
        $("#branch option:selected").attr('disabled','disabled')
    });
});