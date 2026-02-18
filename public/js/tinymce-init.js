/**
 * TinyMCE init for admin backend
 * Targets textarea.rich-editor
 */
(function() {
    if (typeof tinymce === 'undefined') return;
    var textareas = document.querySelectorAll('textarea.rich-editor');
    if (textareas.length === 0) return;

    tinymce.init({
        selector: 'textarea.rich-editor',
        height: 280,
        menubar: false,
        plugins: 'lists link code',
        toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | link | blockquote | removeformat | code',
        content_style: 'body { font-family: Inter, -apple-system, sans-serif; font-size: 14px; line-height: 1.5; }',
        branding: false,
        promotion: false,
        resize: true
    });
})();
