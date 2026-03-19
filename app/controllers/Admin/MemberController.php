<?php
namespace App\Controllers\Admin;

use App\Models\User;
use App\Services\MailService;

class MemberController extends BaseController
{
    private const PER_PAGE = 20;

    public function export()
    {
        $this->requireAdmin();
        $filters = [
            'search' => trim($this->get('search', '')),
            'status' => $this->get('status', 'all'),
        ];
        $result = (new User())->findMembersFiltered($filters, 'name ASC', 10000, 0);
        $members = $result['rows'];
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="members-' . date('Y-m-d') . '.csv"');
        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($out, ['Name', 'Email', 'Active', 'Created At']);
        foreach ($members as $u) {
            fputcsv($out, [
                $u['name'] ?? '',
                $u['email'] ?? '',
                !empty($u['is_active']) ? 'Yes' : 'No',
                $u['created_at'] ?? '',
            ]);
        }
        fclose($out);
        exit;
    }

    public function index()
    {
        $this->requireAdmin();
        $flash = $_SESSION['member_create_flash'] ?? null;
        unset($_SESSION['member_create_flash']);
        $page = max(1, (int)($this->get('page', 1)));
        $offset = ($page - 1) * self::PER_PAGE;
        $search = trim($this->get('search', ''));
        $status = in_array($this->get('status', 'all'), ['all', 'active', 'inactive']) ? $this->get('status', 'all') : 'all';

        $filters = ['search' => $search, 'status' => $status];
        $result = (new User())->findMembersFiltered($filters, 'name ASC', self::PER_PAGE, $offset);
        $members = $result['rows'];
        $total = $result['total'];
        $totalPages = max(1, (int)ceil($total / self::PER_PAGE));

        $this->render('admin/members/index', [
            'members' => $members,
            'flash' => $flash,
            'pageHeading' => 'Members',
            'currentPage' => 'members',
            'search' => $search,
            'status' => $status,
            'page' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
            'perPage' => self::PER_PAGE,
        ]);
    }

    public function create()
    {
        $this->requireAdmin();
        $this->render('admin/members/form', [
            'member' => null,
            'pageHeading' => 'Add Member',
            'currentPage' => 'members',
        ]);
    }

    public function store()
    {
        $this->requireAdmin();
        if (!csrf_verify()) {
            $this->redirectAdmin('members/create');
            return;
        }
        $email = trim($this->post('email', ''));
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->render('admin/members/form', [
                'member' => ['name' => trim($this->post('name', '')), 'email' => $email, 'is_active' => $this->post('is_active') ? 1 : 0],
                'error' => 'Valid email is required.',
                'pageHeading' => 'Add Member',
                'currentPage' => 'members',
            ]);
            return;
        }
        $existing = (new User())->findAll(['email' => $email])[0] ?? null;
        if ($existing) {
            $this->render('admin/members/form', [
                'member' => ['name' => trim($this->post('name', '')), 'email' => $email, 'is_active' => $this->post('is_active') ? 1 : 0],
                'error' => 'Email already in use.',
                'pageHeading' => 'Add Member',
                'currentPage' => 'members',
            ]);
            return;
        }
        $plainPassword = $this->generatePassword();
        (new User())->create([
            'email' => $email,
            'password' => password_hash($plainPassword, PASSWORD_DEFAULT),
            'name' => trim($this->post('name', '')),
            'role' => 'member',
            'is_active' => $this->post('is_active') ? 1 : 0,
        ]);
        $name = trim($this->post('name', '')) ?: $email;
        $loginUrl = admin_url('login');
        $this->sendWelcomeEmail($email, $name, $plainPassword, $loginUrl);
        $_SESSION['member_create_flash'] = "Member added. Welcome email with login credentials has been sent to {$email}.";
        $this->redirectAdmin('members');
    }

    private function generatePassword(): string
    {
        $chars = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789';
        $len = strlen($chars);
        $password = '';
        for ($i = 0; $i < 12; $i++) {
            $password .= $chars[random_int(0, $len - 1)];
        }
        return $password;
    }

    private function sendWelcomeEmail(string $to, string $name, string $password, string $loginUrl): bool
    {
        $subject = 'Your Lighthouse Global Church Member Account';
        $body = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="font-family: sans-serif; line-height: 1.6; color: #333;">';
        $body .= '<h2>Welcome to Lighthouse Global Church</h2>';
        $body .= '<p>Hi ' . htmlspecialchars($name) . ',</p>';
        $body .= '<p>A member account has been created for you. Here are your login credentials:</p>';
        $body .= '<p><strong>Login URL:</strong> <a href="' . htmlspecialchars($loginUrl) . '">' . htmlspecialchars($loginUrl) . '</a></p>';
        $body .= '<p><strong>Email:</strong> ' . htmlspecialchars($to) . '</p>';
        $body .= '<p><strong>Temporary password:</strong> <code style="background:#f0f0f0; padding:2px 6px; border-radius:4px;">' . htmlspecialchars($password) . '</code></p>';
        $body .= '<p>Please sign in and change your password in your profile settings. You can access the Prayer Wall and your member dashboard.</p>';
        $body .= '<p>— Lighthouse Global Church</p>';
        $body .= '</body></html>';
        $mail = new MailService();
        return $mail->send($to, $name, $subject, $body);
    }
}
