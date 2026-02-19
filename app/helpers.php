<?php
/**
 * Global helper functions
 */
if (!function_exists('admin_url')) {
    function admin_url(string $path = ''): string
    {
        $base = rtrim(BASE_URL, '/') . '/' . (defined('ADMIN_PATH') ? ADMIN_PATH : 'admin');
        $path = ltrim($path, '/');
        return $path ? $base . '/' . $path : $base;
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        $name = defined('CSRF_TOKEN_NAME') ? CSRF_TOKEN_NAME : 'csrf_token';
        $token = $_SESSION[$name] ?? bin2hex(random_bytes(32));
        $_SESSION[$name] = $token;
        return '<input type="hidden" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($token) . '">';
    }
}

if (!function_exists('csrf_verify')) {
    function csrf_verify(): bool
    {
        $name = defined('CSRF_TOKEN_NAME') ? CSRF_TOKEN_NAME : 'csrf_token';
        $post = $_POST[$name] ?? '';
        $session = $_SESSION[$name] ?? '';
        return $post !== '' && hash_equals($session, $post);
    }
}

/**
 * Output trusted HTML from CMS/rich-editor content. Strips dangerous tags, allows formatting.
 * Use for: testimonials, section content, media/job/event descriptions from admin.
 */
if (!function_exists('rich_content')) {
    function rich_content(?string $html): string
    {
        if ($html === null || $html === '') return '';
        $allowed = '<p><br><strong><b><em><i><u><h1><h2><h3><h4><ul><ol><li><a><span><blockquote>';
        $cleaned = strip_tags($html, $allowed);
        // Remove script, javascript: and other dangerous protocols from links
        $cleaned = preg_replace('/<a\s+([^>]*?)href\s*=\s*["\']?\s*javascript:[^"\']*["\']?/i', '<a href="#"', $cleaned);
        return $cleaned;
    }
}

/**
 * Strip HTML tags and return plain text. Use for headings/short fields where
 * backend content might include HTML (e.g. pasted from editor) but we want plain text.
 */
if (!function_exists('content_text')) {
    function content_text(?string $html): string
    {
        if ($html === null || $html === '') return '';
        return htmlspecialchars(strip_tags($html), ENT_QUOTES, 'UTF-8');
    }
}

/**
 * Plain-text preview from HTML (for card descriptions, list summaries).
 */
if (!function_exists('rich_preview')) {
    function rich_preview(?string $html, int $len = 120): string
    {
        if ($html === null || $html === '') return '';
        $text = strip_tags($html);
        return htmlspecialchars(mb_strimwidth($text, 0, $len, '…'));
    }
}

if (!function_exists('job_type_label')) {
    function job_type_label(?string $type): string
    {
        $labels = [
            'full-time' => 'Full-Time',
            'part-time' => 'Part-Time',
            'full-time-part-time' => 'Full-Time / Part-Time',
            'internship' => 'Internship',
            'volunteer' => 'Volunteer',
        ];
        return $labels[$type ?? ''] ?? ucfirst(str_replace('-', ' ', $type ?? ''));
    }
}

/**
 * Get hero background image URL for an inner page.
 * About uses about_hero_image; other pages use page_hero_image.
 */
if (!function_exists('page_hero_image')) {
    function page_hero_image(string $page): string
    {
        $s = new \App\Models\Setting();
        if ($page === 'about') return $s->get('about_hero_image', '');
        return $s->get('page_hero_image', '');
    }
}

/**
 * Return class and style attributes for page hero with optional background image.
 * Use: <div class="page-hero page-hero--contact<?= page_hero_classes($img) ?>"<?= page_hero_style($img) ?>>
 */
if (!function_exists('page_hero_classes')) {
    function page_hero_classes(string $img): string { return !empty($img) ? ' page-hero--has-image' : ''; }
}
if (!function_exists('page_hero_style')) {
    function page_hero_style(string $img): string {
        if (empty($img)) return '';
        return ' style="background-image: linear-gradient(to bottom, rgba(26,26,26,0.75) 0%, rgba(26,26,26,0.6) 100%), url(' . htmlspecialchars($img) . ');"';
    }
}

if (!function_exists('svg_icon')) {
    function svg_icon(string $name, int $size = 20): string
    {
        $icons = [
            'calendar' => '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
            'heart' => '<path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>',
            'users' => '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>',
            'play' => '<polygon points="5 3 19 12 5 21 5 3"/>',
            'briefcase' => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/>',
            'mail' => '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><path d="M22 6l-10 7L2 6"/>',
            'file-text' => '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6"/><path d="M16 13H8"/><path d="M16 17H8"/><path d="M10 9H8"/>',
            'image' => '<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/>',
            'layers' => '<path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>',
            'message-circle' => '<path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/>',
            'user-check' => '<path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="8.5" cy="7" r="4"/><path d="M17 11l2 2 4-4"/>',
            'settings' => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/>',
        ];
        $path = $icons[$name] ?? '<circle cx="12" cy="12" r="2"/>';
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $path . '</svg>';
    }
}
