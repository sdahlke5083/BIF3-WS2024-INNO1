// AMD module for block_compviz skills overview
// Follows Moodle AMD conventions. Exposes `init` which is called via js_call_amd.
define(['jquery'], function ($) {
    'use strict';

    var DEFAULT_SELECTOR = '.compviz-blo
   /**      Initialize the skills overview block.       @param {string} selector - jQuery selector for the root block element(s).       If not provided, DEFAULT_SELECTOR is used.       Sets up click and keyboard handlers for skill group headers to toggle visibility.       Implements accordion behavior: only one group can be open at a time.
    */  ck';

    function init(selector) {
        var rootSelector = selector || DEFAULT_SELECTOR;
        $(document).ready(function () {
            $(rootSelector).each(function () {
                var $block = $(this);

                $block.find('.skill-header').each(function () {
                    var $header = $(this);
                    $header.attr('role', 'button');
                    $header.attr('tabindex', '0');
                    $header.attr('aria-expanded', 'false');

                    // click handler
                    $header.off('click.block_compviz').on('click.block_compviz', function (e) {
                        // ignore clicks on interactive elements inside header
                        if ($(e.target).closest('a, button, input, select, textarea').length) {
                            return;
                        }
                        var $group = $header.closest('.skill-group');
                        if (!$group.length) {
                            return;
                        }
                        var isOpen = $group.hasClass('open');
                        if (!isOpen) {
                            // close other open groups (accordion behaviour)
                            $block.find('.skill-group.open').not($group).each(function () {
                                var $g = $(this);
                                $g.removeClass('open');
                                $g.find('.skill-header').attr('aria-expanded', 'false');
                            });
                            $group.addClass('open');
                            $header.attr('aria-expanded', 'true');
                        } else {
                            $group.removeClass('open');
                            $header.attr('aria-expanded', 'false');
                        }
                    });

                    // keyboard handler (Enter / Space)
                    $header.off('keydown.block_compviz').on('keydown.block_compviz', function (e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            $header.trigger('click');
                        }
                    });
                });

                // ensure only one open: keep first
                var $opens = $block.find('.skill-group.open');
                if ($opens.length > 1) {
                    $opens.slice(1).removeClass('open').find('.skill-header').attr('aria-expanded', 'false');
                }
            });
        });
    }

    return {
        init: init
    };
});