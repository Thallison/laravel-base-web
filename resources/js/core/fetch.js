App.fetch = function(options){

    const defaults = {
        method: "POST",
        data: {},
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content"),
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest"
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
        if(options.data instanceof FormData){
            delete fetchOptions.headers["Content-Type"];
            fetchOptions.body = options.data;
        }else{
            fetchOptions.body = JSON.stringify(options.data);
        }
    }

    fetch(url, fetchOptions)
        .then(res => {
            if(options.responseType === "json"){
                return res.text().then(text => {
                    const data = text ? JSON.parse(text) : {};

                    if(!res.ok){
                        return Promise.reject({status: res.status, data});
                    }

                    return data;
                });
            }

            if(!res.ok){
                return res.text().then(text => Promise.reject({status: res.status, data: text}));
            }

            return res.text();
        })
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