define(['jquery'], function ($) {
    $(document).ready(function () {
        $('details summary').each(function () {
            $(this).on('click', function (event) {
                var parentDetails = $(this).parent();
                var isOpen = parentDetails.prop('open');

                // Collapse all other dropdowns on the same level
                parentDetails.siblings('details').removeAttr('open');
                parentDetails.siblings('details').find('summary span[style*="cursor: pointer;"]').text('▶');

                // Prevent event from propagating to parent details elements
                event.stopPropagation();

                // Toggle the arrow for the clicked summary
                var arrow = $(this).find('span[style*="cursor: pointer;"]');
                if (arrow.length) {
                    arrow.text(isOpen ? '▶' : '▼');
                }
            });
        });
    });
});