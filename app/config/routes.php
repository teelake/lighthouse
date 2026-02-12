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

// === ADMIN ROUTES ===
$router->add('GET', 'admin/login', ['controller' => 'Admin\Auth', 'action' => 'login']);
$router->add('POST', 'admin/login', ['controller' => 'Admin\Auth', 'action' => 'login']);
$router->add('GET', 'admin/logout', ['controller' => 'Admin\Auth', 'action' => 'logout']);
$router->add('GET', 'admin', ['controller' => 'Admin\Dashboard', 'action' => 'index']);
$router->add('GET', 'admin/dashboard', ['controller' => 'Admin\Dashboard', 'action' => 'index']);

// Admin - Content sections
$router->add('GET', 'admin/sections', ['controller' => 'Admin\Section', 'action' => 'index']);
$router->add('GET', 'admin/sections/{key}/edit', ['controller' => 'Admin\Section', 'action' => 'edit']);
$router->add('POST', 'admin/sections/{key}', ['controller' => 'Admin\Section', 'action' => 'update']);

// Admin - Events
$router->add('GET', 'admin/events', ['controller' => 'Admin\Event', 'action' => 'index']);
$router->add('GET', 'admin/events/create', ['controller' => 'Admin\Event', 'action' => 'create']);
$router->add('POST', 'admin/events', ['controller' => 'Admin\Event', 'action' => 'store']);
$router->add('GET', 'admin/events/{id}/edit', ['controller' => 'Admin\Event', 'action' => 'edit']);
$router->add('POST', 'admin/events/{id}', ['controller' => 'Admin\Event', 'action' => 'update']);
$router->add('POST', 'admin/events/{id}/delete', ['controller' => 'Admin\Event', 'action' => 'delete']);

// Admin - Ministries
$router->add('GET', 'admin/ministries', ['controller' => 'Admin\Ministry', 'action' => 'index']);
$router->add('GET', 'admin/ministries/create', ['controller' => 'Admin\Ministry', 'action' => 'create']);
$router->add('POST', 'admin/ministries', ['controller' => 'Admin\Ministry', 'action' => 'store']);
$router->add('GET', 'admin/ministries/{id}/edit', ['controller' => 'Admin\Ministry', 'action' => 'edit']);
$router->add('POST', 'admin/ministries/{id}', ['controller' => 'Admin\Ministry', 'action' => 'update']);
$router->add('POST', 'admin/ministries/{id}/delete', ['controller' => 'Admin\Ministry', 'action' => 'delete']);

// Admin - Small groups
$router->add('GET', 'admin/small-groups', ['controller' => 'Admin\SmallGroup', 'action' => 'index']);
$router->add('GET', 'admin/small-groups/create', ['controller' => 'Admin\SmallGroup', 'action' => 'create']);
$router->add('POST', 'admin/small-groups', ['controller' => 'Admin\SmallGroup', 'action' => 'store']);
$router->add('GET', 'admin/small-groups/{id}/edit', ['controller' => 'Admin\SmallGroup', 'action' => 'edit']);
$router->add('POST', 'admin/small-groups/{id}', ['controller' => 'Admin\SmallGroup', 'action' => 'update']);
$router->add('POST', 'admin/small-groups/{id}/delete', ['controller' => 'Admin\SmallGroup', 'action' => 'delete']);

// Admin - Media
$router->add('GET', 'admin/media', ['controller' => 'Admin\Media', 'action' => 'index']);
$router->add('GET', 'admin/media/create', ['controller' => 'Admin\Media', 'action' => 'create']);
$router->add('POST', 'admin/media', ['controller' => 'Admin\Media', 'action' => 'store']);
$router->add('GET', 'admin/media/{id}/edit', ['controller' => 'Admin\Media', 'action' => 'edit']);
$router->add('POST', 'admin/media/{id}', ['controller' => 'Admin\Media', 'action' => 'update']);
$router->add('POST', 'admin/media/{id}/delete', ['controller' => 'Admin\Media', 'action' => 'delete']);

// Admin - Jobs
$router->add('GET', 'admin/jobs', ['controller' => 'Admin\Job', 'action' => 'index']);
$router->add('GET', 'admin/jobs/create', ['controller' => 'Admin\Job', 'action' => 'create']);
$router->add('POST', 'admin/jobs', ['controller' => 'Admin\Job', 'action' => 'store']);
$router->add('GET', 'admin/jobs/{id}/edit', ['controller' => 'Admin\Job', 'action' => 'edit']);
$router->add('POST', 'admin/jobs/{id}', ['controller' => 'Admin\Job', 'action' => 'update']);
$router->add('POST', 'admin/jobs/{id}/delete', ['controller' => 'Admin\Job', 'action' => 'delete']);
$router->add('GET', 'admin/job-applications', ['controller' => 'Admin\JobApplication', 'action' => 'index']);

// Admin - Settings
$router->add('GET', 'admin/settings', ['controller' => 'Admin\Setting', 'action' => 'index']);
$router->add('GET', 'admin/settings/general', ['controller' => 'Admin\Setting', 'action' => 'general']);
$router->add('POST', 'admin/settings/general', ['controller' => 'Admin\Setting', 'action' => 'updateGeneral']);
$router->add('GET', 'admin/settings/payment', ['controller' => 'Admin\Setting', 'action' => 'payment']);
$router->add('POST', 'admin/settings/payment', ['controller' => 'Admin\Setting', 'action' => 'updatePayment']);
