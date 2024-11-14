// Get toast element
const toastElement = $('#adminToast');
const toast = new bootstrap.Toast(toastElement);

// Custom pipeline function to reduce server requests by caching pages
$.fn.dataTable.pipeline = function (opts) {
    // Configuration options
    var conf = $.extend(
        {
            pages: 5,        // Number of pages to cache
            url: '',         // Script URL
            data: null,      // Function or object with parameters to send to the server
            method: 'GET'    // HTTP method
        },
        opts
    );

    // Private variables for storing the cache
    var cacheLower = -1;
    var cacheUpper = null;
    var cacheLastRequest = null;
    var cacheLastJson = null;

    return function (request, drawCallback, settings) {
        var ajax = false;
        var requestStart = request.start;
        var drawStart = request.start;
        var requestLength = request.length;
        var requestEnd = requestStart + requestLength;

        if (settings.clearCache) {
            ajax = true;
            settings.clearCache = false;
        }
        else if (
            cacheLower < 0 ||
            requestStart < cacheLower ||
            requestEnd > cacheUpper
        ) {
            ajax = true;
        }
        else if (
            JSON.stringify(request.order) !== JSON.stringify(cacheLastRequest.order) ||
            JSON.stringify(request.columns) !== JSON.stringify(cacheLastRequest.columns) ||
            JSON.stringify(request.search) !== JSON.stringify(cacheLastRequest.search)
        ) {
            ajax = true;
        }

        cacheLastRequest = $.extend(true, {}, request);

        if (ajax) {
            if (requestStart < cacheLower) {
                requestStart = requestStart - requestLength * (conf.pages - 1);

                if (requestStart < 0) {
                    requestStart = 0;
                }
            }

            cacheLower = requestStart;
            cacheUpper = requestStart + requestLength * conf.pages;

            request.start = requestStart;
            request.length = requestLength * conf.pages;

            if ($.isFunction(conf.data)) {
                var d = conf.data(request);
                if (d) {
                    $.extend(request, d);
                }
            }
            else if ($.isPlainObject(conf.data)) {
                $.extend(request, conf.data);
            }

            return $.ajax({
                type: conf.method,
                url: conf.url,
                data: request,
                dataType: 'json',
                cache: false,
                success: function (json) {
                    cacheLastJson = $.extend(true, {}, json);

                    if (cacheLower != drawStart) {
                        json.data.splice(0, drawStart - cacheLower);
                    }
                    if (requestLength >= -1) {
                        json.data.splice(requestLength, json.data.length);
                    }

                    drawCallback(json);
                }
            });
        }
        else {
            json = $.extend(true, {}, cacheLastJson);
            json.draw = request.draw; // Update the draw parameter for each response
            json.data.splice(0, requestStart - cacheLower);
            json.data.splice(requestLength, json.data.length);

            drawCallback(json);
        }
    };
};

// API method to clear the pipeline cache
$.fn.dataTable.Api.register('clearPipeline()', function () {
    return this.iterator('table', function (settings) {
        settings.clearCache = true;
    });
});


function dataTableInit(url, columns) {
    $('#data_table').DataTable({
        pagingType: "simple",
        // pagingType: "simple_numbers",
        processing: true,
        serverSide: true,
        ajax: $.fn.dataTable.pipeline({
            url, // Data endpoint
            pages: 5 // Cache 5 pages of data
        }),
        columns,
        pageLength: 10,
        language: {
            oPaginate: {
                sNext: '<i class="bi bi-chevron-right"></i>',
                sPrevious: '<i class="bi bi-chevron-left"></i>',
                sFirst: '<i class="bi bi-chevron-double-left"></i>',
                sLast: '<i class="bi bi-chevron-double-right"></i>'
            }
        },
        order: [], // Disable initial sort
    });
}

tippy('[data-tippy-content]');