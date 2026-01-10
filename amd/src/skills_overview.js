// AMD module for block_compviz skills overview
// Follows Moodle AMD conventions. Exposes `init` which is called via js_call_amd.
define(['jquery'], function ($) {
    'use strict';

    var DEFAULT_SELECTOR = '.compviz-block';

    /**
     * Initialize the skills overview block.
     * @param {string} selector - jQuery selector for the root block element(s).
     * If not provided, DEFAULT_SELECTOR is used.
     * Sets up accordion behavior for details elements: only one can be open at a time.
     */
    function init(selector) {
        var rootSelector = selector || DEFAULT_SELECTOR;
        $(document).ready(function () {
            $(rootSelector).each(function () {
                var $block = $(this);

                // Handle accordion behavior for details elements
                $block.find('details').on('toggle.block_compviz', function () {
                    var $currentDetails = $(this);
                    // If this details element is being opened
                    if (this.open) {
                        // Close all other details elements in this block
                        $block.find('details').not($currentDetails).each(function () {
                            this.open = false;
                        });
                    }
                });
            });
        });
    }

    return {
        init: init
    };
});