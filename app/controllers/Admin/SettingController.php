<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Models\Setting;
use App\Services\ImageUpload;

class SettingController extends BaseController
{
    public function index() { $this->requireAdmin(); $this->redirectAdmin('settings/general'); }
    public function general()
    {
        $this->requireAdmin();
        $s = new Setting();
        $this->render('admin/settings/general', [
            'site_logo' => $s->get('site_logo', ''),
            'address' => $s->get('site_address'),
            'phone' => $s->get('site_phone'),
            'email' => $s->get('site_email'),
            'watch_online_url' => $s->get('watch_online_url', ''),
            'pageHeading' => 'General Settings',
            'currentPage' => 'settings',
        ]);
    }
    public function updateGeneral()
    {
        $this->requireAdmin();
        $s = new Setting();
        $siteLogo = $s->get('site_logo', '');
        $uploader = new \App\Services\ImageUpload();
        $uploaded = $uploader->upload('site_logo', 'logo');
        if ($uploaded !== null) {
            $siteLogo = $uploaded;
        } elseif ($uploader->getLastError()) {
            $this->render('admin/settings/general', [
                'site_logo' => $siteLogo,
                'address' => $this->post('site_address'),
                'phone' => $this->post('site_phone'),
                'email' => $this->post('site_email'),
                'watch_online_url' => $this->post('watch_online_url', ''),
                'error' => $uploader->getLastError(),
                'pageHeading' => 'General Settings',
                'currentPage' => 'settings',
            ]);
            return;
        }
        $s->set('site_logo', $siteLogo);
        $s->set('site_address', $this->post('site_address'));
        $s->set('site_phone', $this->post('site_phone'));
        $s->set('site_email', $this->post('site_email'));
        $s->set('watch_online_url', trim($this->post('watch_online_url', '')));
        $this->redirectAdmin('settings/general');
    }

    public function social()
    {
        $this->requireAdmin();
        $s = new Setting();
        $this->render('admin/settings/social', [
            'social_facebook' => $s->get('social_facebook', ''),
            'social_tiktok' => $s->get('social_tiktok', ''),
            'social_youtube' => $s->get('social_youtube', ''),
            'social_twitter' => $s->get('social_twitter', ''),
            'pageHeading' => 'Social Media Links',
            'currentPage' => 'settings',
        ]);
    }

    public function updateSocial()
    {
        $this->requireAdmin();
        $s = new Setting();
        $s->set('social_facebook', trim($this->post('social_facebook', '')));
        $s->set('social_tiktok', trim($this->post('social_tiktok', '')));
        $s->set('social_youtube', trim($this->post('social_youtube', '')));
        $s->set('social_twitter', trim($this->post('social_twitter', '')));
        $this->redirectAdmin('settings/social');
    }

    public function footer()
    {
        $this->requireAdmin();
        $s = new Setting();
        $json = $s->get('footer_config', '');
        $data = $json ? json_decode($json, true) : null;
        $tagline = $data['tagline'] ?? 'Join us. Grow with us. Shine with us.';
        $cols = $data['columns'] ?? [
            ['title' => 'ABOUT', 'links' => [
                ['label' => 'About Us', 'url' => '/about'],
                ['label' => 'Leadership', 'url' => '/leadership'],
                ['label' => 'FAQ', 'url' => '/faq'],
            ]],
            ['title' => 'GATHERINGS', 'links' => [
                ['label' => 'Services', 'url' => '/services'],
                ['label' => 'Events', 'url' => '/events'],
                ['label' => 'Ministries', 'url' => '/ministries'],
                ['label' => 'Media', 'url' => '/media'],
            ]],
            ['title' => 'GET INVOLVED', 'links' => [
                ['label' => "I'm New", 'url' => '/im-new'],
                ['label' => 'Small Groups', 'url' => '/small-groups'],
                ['label' => 'Membership & Training', 'url' => '/membership'],
                ['label' => 'Join the Team', 'url' => '/jobs'],
                ['label' => 'Prayer', 'url' => '/prayer'],
            ]],
            ['title' => 'CONTACT', 'links' => [
                ['label' => 'Contact Us', 'url' => '/contact'],
                ['label' => 'Giving', 'url' => '/giving'],
            ]],
        ];
        $this->render('admin/settings/footer', [
            'footer_tagline' => $tagline,
            'footer_columns' => $cols,
            'pageHeading' => 'Footer Configuration',
            'currentPage' => 'settings',
        ]);
    }

    public function updateFooter()
    {
        $this->requireAdmin();
        $s = new Setting();
        $tagline = trim($this->post('footer_tagline', 'Join us. Grow with us. Shine with us.'));
        $cols = [];
        for ($i = 0; $i < 4; $i++) {
            $title = trim($this->post("footer_col_{$i}_title", ''));
            $raw = $this->post("footer_col_{$i}_links", '');
            $links = [];
            foreach (array_filter(explode("\n", $raw)) as $line) {
                $line = trim($line);
                if ($line === '') continue;
                $parts = explode('|', $line, 2);
                $links[] = ['label' => trim($parts[0] ?? ''), 'url' => trim($parts[1] ?? '')];
            }
            $cols[] = ['title' => $title, 'links' => $links];
        }
        $config = json_encode(['tagline' => $tagline, 'columns' => $cols]);
        $s->set('footer_config', $config);
        $this->redirectAdmin('settings/footer');
    }
    public function payment() {
        $this->requireAdmin();
        $s = new Setting();
        $this->render('admin/settings/payment', [
            'paypal_email' => $s->get('paypal_email', 'give@thelighthouseglobal.org'),
            'paypal_donate_url' => $s->get('paypal_donate_url', ''),
            'stripe_public' => $s->get('stripe_public_key'),
            'stripe_secret_is_set' => $s->get('stripe_secret_key', '') !== '',
            'pageHeading' => 'Payment Settings',
            'currentPage' => 'settings',
        ]);
    }
    public function updatePayment() {
        $this->requireAdmin();
        $s = new Setting();
        $s->set('paypal_email', $this->post('paypal_email'));
        $s->set('paypal_donate_url', trim($this->post('paypal_donate_url', '')));
        $s->set('stripe_public_key', $this->post('stripe_public_key'));
        if ($this->post('stripe_secret_key') !== '') $s->set('stripe_secret_key', $this->post('stripe_secret_key'));
        $this->redirectAdmin('settings/payment');
    }

    public function homepage()
    {
        $this->requireAdmin();
        $s = new Setting();
        $this->render('admin/settings/homepage', [
            'map_embed_url' => $s->get('map_embed_url', ''),
            'hero_background_image' => $s->get('hero_background_image', ''),
            'prayer_wall_image' => $s->get('prayer_wall_image', ''),
            'newsletter_device_image' => $s->get('newsletter_device_image', ''),
            'service_sunday' => $s->get('service_sunday', '10:00 AM'),
            'service_thursday' => $s->get('service_thursday', '6:00 PM'),
            'pageHeading' => 'Homepage Settings',
            'currentPage' => 'settings',
        ]);
    }

    public function updateHomepage()
    {
        $this->requireAdmin();
        $s = new Setting();
        $heroBg = $s->get('hero_background_image', '');
        $prayerImg = $s->get('prayer_wall_image', '');
        $newsletterImg = $s->get('newsletter_device_image', '');
        $u = new ImageUpload();
        $uploadedHero = $u->upload('hero_background_image', 'homepage');
        if ($uploadedHero !== null) $heroBg = $uploadedHero;
        elseif ($u->getLastError()) {
            $this->render('admin/settings/homepage', ['error' => $u->getLastError(), 'map_embed_url' => $this->post('map_embed_url'), 'hero_background_image' => $heroBg, 'prayer_wall_image' => $prayerImg, 'newsletter_device_image' => $newsletterImg, 'service_sunday' => $this->post('service_sunday', '10:00 AM'), 'service_thursday' => $this->post('service_thursday', '6:00 PM'), 'pageHeading' => 'Homepage Settings', 'currentPage' => 'settings']);
            return;
        }
        $uploader = new ImageUpload();
        $uploaded = $uploader->upload('prayer_wall_image', 'homepage');
        if ($uploaded !== null) $prayerImg = $uploaded;
        elseif ($uploader->getLastError()) {
            $this->render('admin/settings/homepage', ['error' => $uploader->getLastError(), 'map_embed_url' => $this->post('map_embed_url'), 'hero_background_image' => $heroBg, 'prayer_wall_image' => $prayerImg, 'newsletter_device_image' => $newsletterImg, 'service_sunday' => $this->post('service_sunday', '10:00 AM'), 'service_thursday' => $this->post('service_thursday', '6:00 PM'), 'pageHeading' => 'Homepage Settings', 'currentPage' => 'settings']);
            return;
        }
        $uploader2 = new ImageUpload();
        $uploaded2 = $uploader2->upload('newsletter_device_image', 'homepage');
        if ($uploaded2 !== null) $newsletterImg = $uploaded2;
        elseif ($uploader2->getLastError()) {
            $this->render('admin/settings/homepage', ['error' => $uploader2->getLastError(), 'map_embed_url' => $this->post('map_embed_url'), 'hero_background_image' => $heroBg, 'prayer_wall_image' => $prayerImg, 'newsletter_device_image' => $newsletterImg, 'service_sunday' => $this->post('service_sunday', '10:00 AM'), 'service_thursday' => $this->post('service_thursday', '6:00 PM'), 'pageHeading' => 'Homepage Settings', 'currentPage' => 'settings']);
            return;
        }
        $s->set('map_embed_url', $this->post('map_embed_url', ''));
        $s->set('hero_background_image', $heroBg);
        $s->set('prayer_wall_image', $prayerImg);
        $s->set('newsletter_device_image', $newsletterImg);
        $s->set('service_sunday', $this->post('service_sunday', '10:00 AM'));
        $s->set('service_thursday', $this->post('service_thursday', '6:00 PM'));
        $this->redirectAdmin('settings/homepage');
    }

    public function pageImages()
    {
        $this->requireAdmin();
        $s = new Setting();
        $this->render('admin/settings/page-images', [
            'about_hero_image' => $s->get('about_hero_image', ''),
            'about_story_image' => $s->get('about_story_image', ''),
            'im_new_intro_image' => $s->get('im_new_intro_image', ''),
            'page_hero_image' => $s->get('page_hero_image', ''),
            'pageHeading' => 'Page Images',
            'currentPage' => 'settings',
        ]);
    }

    public function updatePageImages()
    {
        $this->requireAdmin();
        $s = new Setting();
        $uploader = new ImageUpload();
        $imgs = [
            'about_hero_image' => $s->get('about_hero_image', ''),
            'about_story_image' => $s->get('about_story_image', ''),
            'im_new_intro_image' => $s->get('im_new_intro_image', ''),
            'page_hero_image' => $s->get('page_hero_image', ''),
        ];
        foreach (['about_hero_image', 'about_story_image', 'im_new_intro_image', 'page_hero_image'] as $key) {
            $u = new ImageUpload();
            $uploaded = $u->upload($key, 'pages');
            if ($uploaded !== null) $imgs[$key] = $uploaded;
            elseif ($u->getLastError()) {
                $this->render('admin/settings/page-images', array_merge($imgs, ['error' => $u->getLastError(), 'pageHeading' => 'Page Images', 'currentPage' => 'settings']));
                return;
            }
        }
        foreach ($imgs as $k => $v) $s->set($k, $v);
        $this->redirectAdmin('settings/page-images');
    }

    public function email()
    {
        $this->requireAdmin();
        $s = new Setting();
        $this->render('admin/settings/email', [
            'mail_from_email' => $s->get('mail_from_email', ''),
            'mail_from_name' => $s->get('mail_from_name', 'Lighthouse Global Church'),
            'smtp_host' => $s->get('smtp_host', ''),
            'smtp_port' => $s->get('smtp_port', '587'),
            'smtp_encryption' => $s->get('smtp_encryption', 'tls'),
            'smtp_user' => $s->get('smtp_user', ''),
            'smtp_pass_is_set' => $s->get('smtp_pass', '') !== '',
            'pageHeading' => 'Email Settings',
            'currentPage' => 'settings',
        ]);
    }

    public function updateEmail()
    {
        $this->requireAdmin();
        $s = new Setting();
        $s->set('mail_from_email', $this->post('mail_from_email', ''));
        $s->set('mail_from_name', $this->post('mail_from_name', 'Lighthouse Global Church'));
        $s->set('smtp_host', $this->post('smtp_host', ''));
        $s->set('smtp_port', $this->post('smtp_port', '587'));
        $s->set('smtp_encryption', $this->post('smtp_encryption', 'tls'));
        $s->set('smtp_user', $this->post('smtp_user', ''));
        if ($this->post('smtp_pass') !== '') {
            $s->set('smtp_pass', $this->post('smtp_pass'));
        }
        $this->redirectAdmin('settings/email');
    }
}
