<?php
namespace App\Controllers\Admin;

use App\Models\ContentSection;

class SectionController extends BaseController
{
    private const CONFIG_KEYS = ['hero_config', 'gather_config', 'lights_config', 'prayer_wall_config', 'newsletter_config', 'whats_on_config'];

    public function index()
    {
        $this->requireEditor();
        $sections = (new ContentSection())->findAll([], 'sort_order ASC');
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
            $extra = $this->buildExtraData($key);
            (new ContentSection())->update($section['id'], ['extra_data' => json_encode($extra)]);
        } else {
            $content = $this->post('content', '');
            (new ContentSection())->update($section['id'], ['content' => $content]);
        }
        $this->redirectAdmin('sections');
    }

    private function buildExtraData(string $key): array
    {
        $map = [
            'hero_config' => ['tagline', 'pillars', 'bg_image', 'cta_watch_url', 'cta_visit_url'],
            'gather_config' => ['section_title', 'section_sub', 'sunday_title', 'sunday_desc', 'thursday_title', 'thursday_desc'],
            'lights_config' => ['headline', 'image'],
            'prayer_wall_config' => ['eyebrow', 'headline', 'description'],
            'newsletter_config' => ['eyebrow', 'title', 'note'],
            'whats_on_config' => ['sunday_title', 'sunday_desc', 'thursday_title', 'thursday_desc'],
        ];
        $fields = $map[$key] ?? [];
        $out = [];
        foreach ($fields as $f) {
            if ($f === 'pillars') {
                $raw = $this->post('pillars', '');
                $out[$f] = array_values(array_filter(array_map('trim', explode("\n", $raw))));
            } else {
                $out[$f] = trim($this->post($f, ''));
            }
        }
        return $out;
    }
}
