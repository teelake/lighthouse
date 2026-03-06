<?php
namespace App\Controllers\Admin;

use App\Models\AcademyRegistration;

class AcademyRegistrationController extends BaseController
{
    private const PER_PAGE = 20;

    public function index()
    {
        $this->requireEditor();

        $page    = max(1, (int)($this->get('page', 1)));
        $academy = $this->get('academy', '') ?: null;
        $offset  = ($page - 1) * self::PER_PAGE;

        $result     = (new AcademyRegistration())->findPaginated('created_at DESC', self::PER_PAGE, $offset, $academy);
        $rows       = $result['rows'];
        $total      = $result['total'];
        $totalPages = max(1, (int)ceil($total / self::PER_PAGE));

        $this->render('admin/academy-registrations/index', [
            'pageHeading' => 'Academy Sign-Ups',
            'currentPage' => 'academy-registrations',
            'rows'        => $rows,
            'total'       => $total,
            'page'        => $page,
            'totalPages'  => $totalPages,
            'perPage'     => self::PER_PAGE,
            'academy'     => $academy,
        ]);
    }

    public function view()
    {
        $this->requireEditor();
        $id  = (int)($this->params['id'] ?? 0);
        $row = (new AcademyRegistration())->find($id);
        if (!$row) $this->redirectAdmin('academy-registrations');

        $this->render('admin/academy-registrations/view', [
            'pageHeading' => 'Registration Details',
            'currentPage' => 'academy-registrations',
            'row'         => $row,
        ]);
    }

    public function delete()
    {
        $this->requireEditor();
        if (!csrf_verify()) return $this->redirectAdmin('academy-registrations');
        $id = (int)($this->params['id'] ?? 0);
        if ($id) (new AcademyRegistration())->delete($id);
        $this->redirectAdmin('academy-registrations');
    }
}
