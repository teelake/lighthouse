/**
 * Trix compose - mass email editor with inline image upload
 * Handles trix-attachment-add: uploads images, displays in editor, sends as CID in email
 */
(function() {
    var form = document.getElementById('mass-email-form');
    var editor = document.querySelector('trix-editor');
    if (!form || !editor) return;

    var uploadUrl = form.getAttribute('data-upload-url');
    if (!uploadUrl) uploadUrl = window.location.pathname.replace(/send-mass\/?$/, 'upload-attachment').replace(/\/?$/, '') + (window.location.pathname.indexOf('upload-attachment') >= 0 ? '' : '/upload-attachment');
    if (uploadUrl.indexOf('http') !== 0) uploadUrl = window.location.origin + (uploadUrl.indexOf('/') === 0 ? '' : '/') + uploadUrl;

    document.addEventListener('trix-attachment-add', function(event) {
        var attachment = event.attachment;
        if (!attachment.file) return;

        var file = attachment.file;
        var allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (allowed.indexOf(file.type) === -1) {
            attachment.remove();
            return;
        }
        if (file.size > 5 * 1024 * 1024) {
            attachment.remove();
            return;
        }

        event.preventDefault();

        var formData = new FormData();
        formData.append('attachment', file);
        var csrfInput = form.querySelector('input[name="csrf_token"]') || form.querySelector('input[type="hidden"][name]');
        if (csrfInput) formData.append(csrfInput.name, csrfInput.value);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', uploadUrl);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    var res = JSON.parse(xhr.responseText);
                    if (res.url) {
                        var fullUrl = res.url.indexOf('http') === 0 ? res.url : (window.location.origin + (res.url.indexOf('/') === 0 ? '' : '/') + res.url);
                        attachment.setAttributes({
                            url: fullUrl,
                            href: fullUrl
                        });
                        return;
                    }
                } catch (e) {}
            }
            attachment.remove();
        };
        xhr.onerror = function() { attachment.remove(); };
        xhr.send(formData);
    });
})();
