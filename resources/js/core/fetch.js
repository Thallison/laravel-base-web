App.fetch = function(options){

    const defaults = {
        method: "POST",
        data: {},
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content")
        },
        responseType: "json"
    };

    options = {...defaults, ...options};

    let url = options.url;
    let fetchOptions = {
        method: options.method,
        headers: {
            "Content-Type": "application/json",
            ...options.headers
        }
    };

    // se for GET adiciona na URL
    if(options.method.toUpperCase() === "GET"){

        const params = new URLSearchParams(options.data).toString();

        if(params){
            url += (url.includes("?") ? "&" : "?") + params;
        }

    }else
    {
        fetchOptions.body = JSON.stringify(options.data);
    }

    fetch(url, fetchOptions)
        .then(res =>
            options.responseType === "json" ? res.json() : res.text()
        )
        .then(data => {
            if(options.success){
                options.success(data);
            }
        })
        .catch(err => {

            console.error(err);

            if(options.error){
                options.error(err);
            }

        });

};