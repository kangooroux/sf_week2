<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("", name="dashboard")
     */
    public function index()
    {
        return $this->render('admin/dashboard.html.twig', [
            'admin_dashboard' => 'DashboardController',
        ]);
    }
}
