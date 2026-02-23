<?php
namespace App\Controllers\Admin;

use App\Models\Donation;

class DonationController extends BaseController
{
    public function index()
    {
        $this->requireEditor();
        $donations = (new Donation())->findAll([], 'created_at DESC', 100);
        $totalCents = 0;
        foreach ($donations as $d) {
            $totalCents += (int) ($d['amount_cents'] ?? 0);
        }
        $this->render('admin/donations/index', [
            'donations' => $donations,
            'totalAmount' => $totalCents / 100,
            'pageHeading' => 'Donations',
            'currentPage' => 'donations',
        ]);
    }
}
