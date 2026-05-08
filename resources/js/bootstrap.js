const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');

if (csrfTokenMeta) {
    window.csrfToken = csrfTokenMeta.getAttribute('content');
}
