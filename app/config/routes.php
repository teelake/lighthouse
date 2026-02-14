<?php
/**
 * Lighthouse Global Church - Routes
 */
$router = $router ?? ($GLOBALS['router'] ?? null);
if (!$router instanceof App\Core\Router) throw new Exception('Router not available');

// === PUBLIC ROUTES ===

// Home
$router->add('GET', '', ['controller' => 'Home', 'action' => 'index']);
$router->add('GET', 'home', ['controller' => 'Home', 'action' => 'index']);

// Main pages
$router->add('GET', 'about', ['controller' => 'Page', 'action' => 'about']);
$router->add('GET', 'leadership', ['controller' => 'Page', 'action' => 'leadership']);
$router->add('GET', 'services', ['controller' => 'Page', 'action' => 'services']);
$router->add('GET', 'events', ['controller' => 'Event', 'action' => 'index']);
$router->add('GET', 'events/{slug}', ['controller' => 'Event', 'action' => 'view']);
$router->add('GET', 'media', ['controller' => 'Media', 'action' => 'index']);
$router->add('GET', 'media/{slug}', ['controller' => 'Media', 'action' => 'view']);
$router->add('GET', 'membership', ['controller' => 'Page', 'action' => 'membership']);
$router->add('GET', 'ministries', ['controller' => 'Ministry', 'action' => 'index']);
$router->add('GET', 'ministries/{slug}', ['controller' => 'Ministry', 'action' => 'view']);
$router->add('GET', 'small-groups', ['controller' => 'SmallGroup', 'action' => 'index']);
$router->add('GET', 'small-groups/{slug}', ['controller' => 'SmallGroup', 'action' => 'view']);
$router->add('GET', 'giving', ['controller' => 'Giving', 'action' => 'index']);
$router->add('GET', 'contact', ['controller' => 'Page', 'action' => 'contact']);
$router->add('GET', 'faq', ['controller' => 'Page', 'action' => 'faq']);
$router->add('GET', 'im-new', ['controller' => 'Page', 'action' => 'imNew']);
$router->add('GET', 'prayer', ['controller' => 'Prayer', 'action' => 'index']);
$router->add('GET', 'jobs', ['controller' => 'Job', 'action' => 'index']);
$router->add('GET', 'jobs/{slug}', ['controller' => 'Job', 'action' => 'view']);

// Forms - POST
$router->add('POST', 'prayer/submit', ['controller' => 'Prayer', 'action' => 'submit']);
$router->add('POST', 'prayer-wall/post', ['controller' => 'Prayer', 'action' => 'wallPost']);
$router->add('POST', 'visitor/register', ['controller' => 'Visitor', 'action' => 'register']);
$router->add('POST', 'newsletter/subscribe', ['controller' => 'Newsletter', 'action' => 'subscribe']);
$router->add('POST', 'jobs/{slug}/apply', ['controller' => 'Job', 'action' => 'apply']);

// === GIVING - prominent ===
$router->add('GET', 'give', ['controller' => 'Giving', 'action' => 'index']);

// === ADMIN ROUTES (custom path - see ADMIN_PATH in config) ===
$adm = defined('ADMIN_PATH') ? ADMIN_PATH : 'admin';

$router->add('GET', $adm . '/login', ['controller' => 'Admin\Auth', 'action' => 'login']);
$router->add('POST', $adm . '/login', ['controller' => 'Admin\Auth', 'action' => 'login']);
$router->add('GET', $adm . '/logout', ['controller' => 'Admin\Auth', 'action' => 'logout']);
$router->add('GET', $adm . '/2fa', ['controller' => 'Admin\Auth', 'action' => 'twoFactor']);
$router->add('POST', $adm . '/2fa', ['controller' => 'Admin\Auth', 'action' => 'verifyTwoFactor']);
$router->add('GET', $adm, ['controller' => 'Admin\Dashboard', 'action' => 'index']);
$router->add('GET', $adm . '/dashboard', ['controller' => 'Admin\Dashboard', 'action' => 'index']);

$router->add('GET', $adm . '/sections', ['controller' => 'Admin\Section', 'action' => 'index']);
$router->add('GET', $adm . '/sections/{key}/edit', ['controller' => 'Admin\Section', 'action' => 'edit']);
$router->add('POST', $adm . '/sections/{key}', ['controller' => 'Admin\Section', 'action' => 'update']);

$router->add('GET', $adm . '/glimpse', ['controller' => 'Admin\Glimpse', 'action' => 'index']);
$router->add('GET', $adm . '/glimpse/create', ['controller' => 'Admin\Glimpse', 'action' => 'create']);
$router->add('POST', $adm . '/glimpse', ['controller' => 'Admin\Glimpse', 'action' => 'store']);
$router->add('GET', $adm . '/glimpse/{id}/edit', ['controller' => 'Admin\Glimpse', 'action' => 'edit']);
$router->add('POST', $adm . '/glimpse/{id}', ['controller' => 'Admin\Glimpse', 'action' => 'update']);
$router->add('POST', $adm . '/glimpse/{id}/delete', ['controller' => 'Admin\Glimpse', 'action' => 'delete']);

$router->add('GET', $adm . '/moments', ['controller' => 'Admin\Moments', 'action' => 'index']);
$router->add('GET', $adm . '/moments/create', ['controller' => 'Admin\Moments', 'action' => 'create']);
$router->add('POST', $adm . '/moments', ['controller' => 'Admin\Moments', 'action' => 'store']);
$router->add('GET', $adm . '/moments/{id}/edit', ['controller' => 'Admin\Moments', 'action' => 'edit']);
$router->add('POST', $adm . '/moments/{id}', ['controller' => 'Admin\Moments', 'action' => 'update']);
$router->add('POST', $adm . '/moments/{id}/delete', ['controller' => 'Admin\Moments', 'action' => 'delete']);

$router->add('GET', $adm . '/leaders', ['controller' => 'Admin\Leader', 'action' => 'index']);
$router->add('GET', $adm . '/leaders/create', ['controller' => 'Admin\Leader', 'action' => 'create']);
$router->add('POST', $adm . '/leaders', ['controller' => 'Admin\Leader', 'action' => 'store']);
$router->add('GET', $adm . '/leaders/{id}/edit', ['controller' => 'Admin\Leader', 'action' => 'edit']);
$router->add('POST', $adm . '/leaders/{id}', ['controller' => 'Admin\Leader', 'action' => 'update']);
$router->add('POST', $adm . '/leaders/{id}/delete', ['controller' => 'Admin\Leader', 'action' => 'delete']);

$router->add('GET', $adm . '/testimonials', ['controller' => 'Admin\Testimonial', 'action' => 'index']);
$router->add('GET', $adm . '/testimonials/create', ['controller' => 'Admin\Testimonial', 'action' => 'create']);
$router->add('POST', $adm . '/testimonials', ['controller' => 'Admin\Testimonial', 'action' => 'store']);
$router->add('GET', $adm . '/testimonials/{id}/edit', ['controller' => 'Admin\Testimonial', 'action' => 'edit']);
$router->add('POST', $adm . '/testimonials/{id}', ['controller' => 'Admin\Testimonial', 'action' => 'update']);
$router->add('POST', $adm . '/testimonials/{id}/delete', ['controller' => 'Admin\Testimonial', 'action' => 'delete']);

$router->add('GET', $adm . '/events', ['controller' => 'Admin\Event', 'action' => 'index']);
$router->add('GET', $adm . '/events/create', ['controller' => 'Admin\Event', 'action' => 'create']);
$router->add('POST', $adm . '/events', ['controller' => 'Admin\Event', 'action' => 'store']);
$router->add('GET', $adm . '/events/{id}/edit', ['controller' => 'Admin\Event', 'action' => 'edit']);
$router->add('POST', $adm . '/events/{id}', ['controller' => 'Admin\Event', 'action' => 'update']);
$router->add('POST', $adm . '/events/{id}/delete', ['controller' => 'Admin\Event', 'action' => 'delete']);

$router->add('GET', $adm . '/ministries', ['controller' => 'Admin\Ministry', 'action' => 'index']);
$router->add('GET', $adm . '/ministries/create', ['controller' => 'Admin\Ministry', 'action' => 'create']);
$router->add('POST', $adm . '/ministries', ['controller' => 'Admin\Ministry', 'action' => 'store']);
$router->add('GET', $adm . '/ministries/{id}/edit', ['controller' => 'Admin\Ministry', 'action' => 'edit']);
$router->add('POST', $adm . '/ministries/{id}', ['controller' => 'Admin\Ministry', 'action' => 'update']);
$router->add('POST', $adm . '/ministries/{id}/delete', ['controller' => 'Admin\Ministry', 'action' => 'delete']);

$router->add('GET', $adm . '/small-groups', ['controller' => 'Admin\SmallGroup', 'action' => 'index']);
$router->add('GET', $adm . '/small-groups/create', ['controller' => 'Admin\SmallGroup', 'action' => 'create']);
$router->add('POST', $adm . '/small-groups', ['controller' => 'Admin\SmallGroup', 'action' => 'store']);
$router->add('GET', $adm . '/small-groups/{id}/edit', ['controller' => 'Admin\SmallGroup', 'action' => 'edit']);
$router->add('POST', $adm . '/small-groups/{id}', ['controller' => 'Admin\SmallGroup', 'action' => 'update']);
$router->add('POST', $adm . '/small-groups/{id}/delete', ['controller' => 'Admin\SmallGroup', 'action' => 'delete']);

$router->add('GET', $adm . '/media', ['controller' => 'Admin\Media', 'action' => 'index']);
$router->add('GET', $adm . '/media/create', ['controller' => 'Admin\Media', 'action' => 'create']);
$router->add('POST', $adm . '/media', ['controller' => 'Admin\Media', 'action' => 'store']);
$router->add('GET', $adm . '/media/{id}/edit', ['controller' => 'Admin\Media', 'action' => 'edit']);
$router->add('POST', $adm . '/media/{id}', ['controller' => 'Admin\Media', 'action' => 'update']);
$router->add('POST', $adm . '/media/{id}/delete', ['controller' => 'Admin\Media', 'action' => 'delete']);

$router->add('GET', $adm . '/jobs', ['controller' => 'Admin\Job', 'action' => 'index']);
$router->add('GET', $adm . '/jobs/create', ['controller' => 'Admin\Job', 'action' => 'create']);
$router->add('POST', $adm . '/jobs', ['controller' => 'Admin\Job', 'action' => 'store']);
$router->add('GET', $adm . '/jobs/{id}/edit', ['controller' => 'Admin\Job', 'action' => 'edit']);
$router->add('POST', $adm . '/jobs/{id}', ['controller' => 'Admin\Job', 'action' => 'update']);
$router->add('POST', $adm . '/jobs/{id}/delete', ['controller' => 'Admin\Job', 'action' => 'delete']);
$router->add('GET', $adm . '/job-applications', ['controller' => 'Admin\JobApplication', 'action' => 'index']);

$router->add('GET', $adm . '/settings', ['controller' => 'Admin\Setting', 'action' => 'index']);
$router->add('GET', $adm . '/settings/general', ['controller' => 'Admin\Setting', 'action' => 'general']);
$router->add('POST', $adm . '/settings/general', ['controller' => 'Admin\Setting', 'action' => 'updateGeneral']);
$router->add('GET', $adm . '/settings/homepage', ['controller' => 'Admin\Setting', 'action' => 'homepage']);
$router->add('POST', $adm . '/settings/homepage', ['controller' => 'Admin\Setting', 'action' => 'updateHomepage']);
$router->add('GET', $adm . '/settings/payment', ['controller' => 'Admin\Setting', 'action' => 'payment']);
$router->add('POST', $adm . '/settings/payment', ['controller' => 'Admin\Setting', 'action' => 'updatePayment']);

// Admin - Users (admin role only)
$router->add('GET', $adm . '/users', ['controller' => 'Admin\User', 'action' => 'index']);
$router->add('GET', $adm . '/users/create', ['controller' => 'Admin\User', 'action' => 'create']);
$router->add('POST', $adm . '/users', ['controller' => 'Admin\User', 'action' => 'store']);
$router->add('GET', $adm . '/users/{id}/edit', ['controller' => 'Admin\User', 'action' => 'edit']);
$router->add('POST', $adm . '/users/{id}', ['controller' => 'Admin\User', 'action' => 'update']);
$router->add('POST', $adm . '/users/{id}/delete', ['controller' => 'Admin\User', 'action' => 'delete']);
$router->add('GET', $adm . '/profile', ['controller' => 'Admin\Profile', 'action' => 'index']);
$router->add('POST', $adm . '/profile/2fa', ['controller' => 'Admin\Profile', 'action' => 'toggle2fa']);
$router->add('POST', $adm . '/profile/password', ['controller' => 'Admin\Profile', 'action' => 'changePassword']);
