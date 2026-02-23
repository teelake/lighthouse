<?php
namespace App\Controllers\Admin;

use App\Models\Donation;

class DonationController extends BaseController
{
    private const PER_PAGE = 20;

    public function index()
    {
        $this->requireEditor();
        $donationModel = new Donation();

        $filters = [
            'date_from' => trim($this->get('date_from', '')),
            'date_to' => trim($this->get('date_to', '')),
            'designation' => trim($this->get('designation', '')),
            'search' => trim($this->get('search', '')),
        ];
        $page = max(1, (int) $this->get('page', 1));
        $offset = ($page - 1) * self::PER_PAGE;

        $result = $donationModel->findAllFiltered($filters, 'created_at DESC', self::PER_PAGE, $offset);
        $donations = $result['rows'];
        $total = $result['total'];
        $totalPages = max(1, (int) ceil($total / self::PER_PAGE));
        $totalAmount = $donationModel->getTotalAmountCents($filters) / 100;

        $this->render('admin/donations/index', [
            'donations' => $donations,
            'totalAmount' => $totalAmount,
            'filters' => $filters,
            'page' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
            'perPage' => self::PER_PAGE,
            'designations' => $this->getDesignations(),
            'pageHeading' => 'Donations',
            'currentPage' => 'donations',
        ]);
    }

    private function get(string $key, string $default = ''): string
    {
        return $_GET[$key] ?? $default;
    }

    private function getDesignations(): array
    {
        return [
            'General' => 'General Fund',
            'Teaching' => 'Teaching & Discipleship',
            'Leadership' => 'Leadership Development',
            'Missions' => 'Outreach & Missions',
            'Operations' => 'Ministry Operations',
        ];
    }
}
