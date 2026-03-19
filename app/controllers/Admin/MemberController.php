<?php
namespace App\Controllers\Admin;

use App\Models\User;

class MemberController extends BaseController
{
    public function export()
    {
        $this->requireAdmin();
        $members = (new User())->findMembers('name ASC', 10000);
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
        $members = (new User())->findMembers('name ASC');
        $this->render('admin/members/index', [
            'members' => $members,
            'pageHeading' => 'Members',
            'currentPage' => 'members',
        ]);
    }
}
