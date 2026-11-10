window.tableSearch = function (url, target) {
    return {
        url: url,
        target: target,

        timeout: null,
        controller: null,

        search(event) {
            clearTimeout(this.timeout);

            this.timeout = setTimeout(() => {
                this.fetchResults(event.target.value);
            }, 400);
        },

        async fetchResults(search) {
            this.controller?.abort();
            this.controller = new AbortController();

            try {
                const requestUrl = new URL(this.url, window.location.origin);
                requestUrl.searchParams.set('search', search);

                const response = await fetch(requestUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    signal: this.controller.signal,
                });

                if (!response.ok) {
                    throw new Error('Search request failed');
                }

                const html = await response.text();

                document.querySelector(this.target).innerHTML = html;

            } catch (error) {
                if (error.name !== 'AbortError') {
                    console.error(error);
                }
            }
        },
    };
};