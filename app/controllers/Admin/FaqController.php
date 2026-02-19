<?php
namespace App\Controllers\Admin;

use App\Models\Faq;

class FaqController extends BaseController
{
    public function index()
    {
        $this->requireEditor();
        $items = (new Faq())->findAll([], 'sort_order ASC');
        $this->render('admin/faqs/index', ['faqs' => $items, 'pageHeading' => 'FAQs', 'currentPage' => 'faqs']);
    }

    public function create()
    {
        $this->requireEditor();
        $this->render('admin/faqs/form', ['faq' => null, 'pageHeading' => 'Add FAQ', 'currentPage' => 'faqs']);
    }

    public function store()
    {
        $this->requireEditor();
        $question = trim($this->post('question', ''));
        $answer = $this->post('answer', '');
        if ($question === '') {
            $this->render('admin/faqs/form', ['faq' => null, 'error' => 'Question is required.', 'pageHeading' => 'Add FAQ', 'currentPage' => 'faqs']);
            return;
        }
        (new Faq())->create([
            'question' => $question,
            'answer' => $answer,
            'sort_order' => (int) $this->post('sort_order', 0),
        ]);
        $this->redirectAdmin('faqs');
    }

    public function edit()
    {
        $this->requireEditor();
        $id = $this->params['id'] ?? 0;
        $item = (new Faq())->find($id);
        if (!$item) throw new \Exception('Not found', 404);
        $this->render('admin/faqs/form', ['faq' => $item, 'pageHeading' => 'Edit FAQ', 'currentPage' => 'faqs']);
    }

    public function update()
    {
        $this->requireEditor();
        $id = $this->params['id'] ?? 0;
        $item = (new Faq())->find($id);
        if (!$item) throw new \Exception('Not found', 404);
        $question = trim($this->post('question', ''));
        $answer = $this->post('answer', '');
        if ($question === '') {
            $this->render('admin/faqs/form', ['faq' => $item, 'error' => 'Question is required.', 'pageHeading' => 'Edit FAQ', 'currentPage' => 'faqs']);
            return;
        }
        (new Faq())->update($id, [
            'question' => $question,
            'answer' => $answer,
            'sort_order' => (int) $this->post('sort_order', 0),
        ]);
        $this->redirectAdmin('faqs');
    }

    public function delete()
    {
        $this->requireEditor();
        $id = $this->params['id'] ?? 0;
        (new Faq())->delete($id);
        $this->redirectAdmin('faqs');
    }
}
