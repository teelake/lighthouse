<?php
namespace App\Controllers\Admin;

use App\Models\ContentSection;
use App\Services\ImageUpload;

class SectionController extends BaseController
{
    private const CONFIG_KEYS = ['hero_config', 'gather_config', 'lights_config', 'prayer_wall_config', 'newsletter_config', 'whats_on_config', 'scriptural_foundation_config', 'core_values_config'];

    /** Section keys that have been removed and must not appear in admin */
    private const OBSOLETE_SECTION_KEYS = [
        'im_new_expect',
        'im_new_arrive_summary',
        'im_new_service_summary',
        'im_new_after_summary',
        'im_new_watch_online',
        'im_new_connect',
    ];

    public function index()
    {
        $this->requireEditor();
        $sections = (new ContentSection())->findAll([], 'section_key ASC');
        $sections = array_values(array_filter($sections, function ($s) {
            return !in_array($s['section_key'] ?? '', self::OBSOLETE_SECTION_KEYS, true);
        }));
        $this->render('admin/sections/index', ['sections' => $sections, 'pageHeading' => 'Content Sections', 'currentPage' => 'sections']);
    }

    public function edit()
    {
        $this->requireEditor();
        $key = $this->params['key'] ?? '';
        $section = (new ContentSection())->getByKey($key);
        if (!$section) throw new \Exception('Section not found', 404);
        $common = ['pageHeading' => 'Edit ' . $key, 'currentPage' => 'sections'];
        if (in_array($key, self::CONFIG_KEYS)) {
            $data = !empty($section['extra_data'])
                ? (is_string($section['extra_data']) ? json_decode($section['extra_data'], true) : $section['extra_data'])
                : [];
            $this->render('admin/sections/edit_config', array_merge($common, ['section' => $section, 'data' => $data ?: []]));
        } else {
            $this->render('admin/sections/edit', array_merge($common, ['section' => $section]));
        }
    }

    public function update()
    {
        $this->requireEditor();
        $key = $this->params['key'] ?? '';
        $section = (new ContentSection())->getByKey($key);
        if (!$section) throw new \Exception('Section not found', 404);

        if (in_array($key, self::CONFIG_KEYS)) {
            try {
                $existing = !empty($section['extra_data'])
                    ? (is_string($section['extra_data']) ? json_decode($section['extra_data'], true) : $section['extra_data'])
                    : [];
                $existing = is_array($existing) ? $existing : [];
                $extra = $this->buildExtraData($key, $existing);
                (new ContentSection())->update($section['id'], ['extra_data' => json_encode($extra)]);
            } catch (\Throwable $e) {
                $data = !empty($section['extra_data']) ? (is_string($section['extra_data']) ? json_decode($section['extra_data'], true) : $section['extra_data']) : [];
                $this->render('admin/sections/edit_config', array_merge([
                    'section' => $section,
                    'data' => $data ?: [],
                    'error' => $e->getMessage(),
                ], ['pageHeading' => 'Edit ' . $key, 'currentPage' => 'sections']));
                return;
            }
        } else {
            $content = $this->post('content', '');
            (new ContentSection())->update($section['id'], ['content' => $content]);
        }
        $this->redirectAdmin('sections');
    }

    private function buildExtraData(string $key, array $existing = []): array
    {
        $map = [
            'hero_config' => ['tagline', 'pillars', 'bg_image', 'cta_watch_url', 'cta_visit_url'],
            'gather_config' => ['section_title', 'section_sub', 'sunday_title', 'sunday_desc', 'thursday_title', 'thursday_desc'],
            'lights_config' => ['headline', 'image'],
            'prayer_wall_config' => ['eyebrow', 'headline', 'description'],
            'newsletter_config' => ['eyebrow', 'title', 'note'],
            'whats_on_config' => ['sunday_title', 'sunday_desc', 'thursday_title', 'thursday_desc'],
            'scriptural_foundation_config' => ['scripture_1_ref', 'scripture_1_desc', 'scripture_2_ref', 'scripture_2_desc', 'scripture_3_ref', 'scripture_3_desc'],
            'core_values_config' => ['value_1_title', 'value_1_desc', 'value_2_title', 'value_2_desc', 'value_3_title', 'value_3_desc', 'value_4_title', 'value_4_desc', 'value_5_title', 'value_5_desc'],
        ];
        $fields = $map[$key] ?? [];
        $out = [];
        $imageFields = ['bg_image', 'image'];
        foreach ($fields as $f) {
            if ($f === 'pillars') {
                $raw = $this->post('pillars', '');
                $out[$f] = array_values(array_filter(array_map('trim', explode("\n", $raw))));
            } elseif (in_array($f, $imageFields, true)) {
                $uploader = new ImageUpload();
                $url = $uploader->upload($f, 'sections');
                if ($url !== null) {
                    $out[$f] = $url;
                } elseif ($uploader->getLastError()) {
                    throw new \RuntimeException($uploader->getLastError());
                } else {
                    $out[$f] = $existing[$f] ?? '';
                }
            } else {
                $out[$f] = trim($this->post($f, ''));
            }
        }
        return $out;
    }
}
