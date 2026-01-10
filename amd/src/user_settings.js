define([
    'core_form/modalform',
    'core/str',
    'core/notification',
], function (ModalForm, Str, Notification) {

    /**
     * Öffnet Modal mit dynamic_form.
     * @param {String} selector  CSS-Selector für den Link
     */
    const init = selector => {

        document.addEventListener('click', e => {
            const link = e.target.closest(selector);
            if (!link) {
                return;
            }
            e.preventDefault();

            // ModalForm erzeugen
            const modalForm = new ModalForm({
                formClass: 'block_compviz\\form\\user_form',
                // keine zusätzlichen args nötig – könnten hier übergeben werden
                modalConfig: { title: link.dataset.title, className: 'block_compviz_user_form' },
                returnFocus: link
            });

            // nach Submit: Seite neu laden + Success-Toast
            modalForm.addEventListener(modalForm.events.FORM_SUBMITTED, e => {
                const detail = e.detail;                   // {message: '…'}
                Notification.addNotification({
                    message: detail.message,
                    type: 'success'
                });
                window.location.reload();
            });

            modalForm.addEventListener(modalForm.events.SUBMITTING, () => {
                modalForm.getRoot().addClass('loading');
            });
            modalForm.addEventListener(modalForm.events.FORM_SUBMITTED, () => {
                modalForm.getRoot().removeClass('loading');
            });


            modalForm.show();
        });
    };

    return { init };
});
