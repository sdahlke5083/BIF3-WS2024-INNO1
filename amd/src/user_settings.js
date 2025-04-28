define(['jquery', 'core/modal_factory', 'core/modal_events'], function ($, ModalSaveCancel, ModalEvents) {

    /**
     * Öffnet einen Modal-Dialog und lädt die Seite per Ajax hinein.
     * Funktioniert ab Moodle 3.9 aufwärts.
     *
     * @param {String} selector CSS-Selector für die Links.
     */
    const init = selector => {
        $(document).on('click', selector, e => {
            e.preventDefault();

            const $link = $(e.currentTarget);
            const title = $link.data('title') || '';
            const url = $link.attr('href');

            // Seite via Ajax holen.
            $.get(url).then(html => {

                // Modal bauen.
                return ModalSaveCancel.create({
                    title: title,
                    body: $(html),
                    large: true
                }).bind(this).then(modal => {
                    this.modal = modal;
                    this.modal.setLarge();
                    
                    $(this.modal.getRoot()).on(ModalEvents.hidden, function () {
                        this.modal.setBody(this.getBody());
                    }.bind(this));

                    $(this.modal.getRoot()).on(ModalEvents.show, function () {
                        this.modal.getRoot().append('<style>[data-fieldtype=submit] { display: none ! important; }</style>');
                    }.bind(this));

                    // Bei Redirect (Form gespeichert / abgebrochen) → Modal zu + Seite neu.
                    $(modal.getRoot()).on(ModalEvents.save, this.submitForm.bind(this));
                    $(modal.getRoot()).on(ModalEvents.cancel, () => modal.destroy());


                    modal.show();
                });

            }).fail(() => {
                // no Fallback
            });
        });
    };

    return { init };
});
