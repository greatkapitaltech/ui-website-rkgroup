<?php

namespace App\Controllers;

class Frontend extends BaseController
{
    public function index()
    {
        // Load data from database
        $companiesModel = model('CompaniesModel');
        $partnersModel = model('PartnersModel');
        $settingsModel = model('SiteSettingsModel');

        // Get site settings
        $settingsData = $settingsModel->where('is_active', 1)->findAll();
        $settings = [];
        foreach ($settingsData as $setting) {
            $settings[$setting['setting_key']] = $setting['setting_value'];
        }

        $data = [
            'title' => 'Home',
            'active_page' => 'home',
            'companies' => $companiesModel->where('is_active', 1)->orderBy('display_order', 'ASC')->findAll(),
            'partners' => $partnersModel->where('is_active', 1)->orderBy('display_order', 'ASC')->findAll(),
            'settings' => $settings
        ];

        return view('frontend/layouts/header', $data)
             . view('frontend/pages/home', $data)
             . view('frontend/layouts/footer');
    }

    public function about()
    {
        // Load data from database
        $timelineModel = model('TimelineModel');
        $boardMembersModel = model('BoardMembersModel');
        $settingsModel = model('SiteSettingsModel');

        // Get site settings
        $settingsData = $settingsModel->where('is_active', 1)->findAll();
        $settings = [];
        foreach ($settingsData as $setting) {
            $settings[$setting['setting_key']] = $setting['setting_value'];
        }

        $data = [
            'title' => 'About Us',
            'active_page' => 'about',
            'additional_css' => ['assets/css/about.css'],
            'timeline' => $timelineModel->where('is_active', 1)->orderBy('year', 'ASC')->findAll(),
            'board_members' => $boardMembersModel->where('member_type', 'board')->where('is_active', 1)->orderBy('display_order', 'ASC')->findAll(),
            'advisory_members' => $boardMembersModel->where('member_type', 'advisory')->where('is_active', 1)->orderBy('display_order', 'ASC')->findAll(),
            'settings' => $settings
        ];

        return view('frontend/layouts/header', $data)
             . view('frontend/pages/about', $data)
             . view('frontend/layouts/footer', ['additional_js' => ['assets/js/about.js']]);
    }

    public function careers()
    {
        // Load site settings for careers page
        $settingsModel = model('SiteSettingsModel');
        $settingsData = $settingsModel->where('is_active', 1)->findAll();
        $settings = [];
        foreach ($settingsData as $setting) {
            $settings[$setting['setting_key']] = $setting['setting_value'];
        }

        $data = [
            'title' => 'Careers',
            'active_page' => 'careers',
            'additional_css' => ['assets/css/careers.css'],
            'settings' => $settings
        ];

        return view('frontend/layouts/header', $data)
             . view('frontend/pages/careers', $data)
             . view('frontend/layouts/footer');
    }

    public function connect()
    {
        // Load site settings for connect page
        $settingsModel = model('SiteSettingsModel');
        $settingsData = $settingsModel->where('is_active', 1)->findAll();
        $settings = [];
        foreach ($settingsData as $setting) {
            $settings[$setting['setting_key']] = $setting['setting_value'];
        }

        $data = [
            'title' => 'Connect',
            'active_page' => 'connect',
            'settings' => $settings
        ];

        return view('frontend/layouts/header', $data)
             . view('frontend/pages/connect', $data)
             . view('frontend/layouts/footer', ['additional_js' => ['assets/js/connect.js']]);
    }
}
