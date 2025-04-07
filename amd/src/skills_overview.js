define(['jquery'], function ($) {
    return {
        init: function () {
            $('.skill-header').on('click', function () {
                var skill = $(this).closest('.skill');
                var skillContent = skill.find('.skill-content');

                if (skillContent.is(':visible')) {
                    skillContent.hide();
                    $('.skill').show();
                } else {
                    $('.skill-content').hide(); // Hide all subskills
                    $('.skill').not(skill).hide();
                    skillContent.show();
                }
            });
        }
    };
});