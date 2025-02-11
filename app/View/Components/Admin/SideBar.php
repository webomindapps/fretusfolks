<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SideBar extends Component
{
    public $menus = [
        [
            'title' => 'Dashboard',
            'icon' => 'bx bx-grid-alt',
            'route' => 'admin.dashboard',
            'name' => 'dashboard',
            'isSubMenu' => false,
            'roles' => ['Admin', 'Finance', 'Hroperations', 'Compliance', 'Recruitment', 'Sales'],
        ],
        [
            'title' => 'FFI Masters',
            'name' => 'masters',
            'icon' => '  bx bxl-slack',
            'route' => 'admin.ffimasters',
            'isSubMenu' => true,
            'roles' => ['Admin', 'superadmin'],
            'subMenus' => [
                [
                    'title' => 'TDS code',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.tds_code',
                    'name' => 'tds_code',
                    'roles' => ['Admin'],

                ],
                [
                    'title' => 'Letter Content',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.letter_content',
                    'name' => 'letter_content',
                    'roles' => ['Admin'],

                ],
                [
                    'title' => 'User Masters',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.usermasters',
                    'name' => 'usermasters',
                    'roles' => ['Admin'],

                ],

            ],

        ],
        [
            'title' => 'CDMS',
            'name' => 'cdms',
            'icon' => '  bx bxl-slack',
            'route' => '',
            'roles' => ['Admin'],
            'isSubMenu' => true,
            'subMenus' => [
                [
                    'title' => 'Client Database System',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cdms',
                    'name' => 'cdms',
                    'roles' => ['Admin'],
                ],
                [
                    'title' => 'Client Report',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cdms_report',
                    'name' => 'cdms_report',
                    'roles' => ['Admin'],
                ],

            ],

        ],
        [
            'title' => 'ADMS',
            'name' => 'adms',
            'icon' => '  bx bxl-slack',
            'route' => '',
            'isSubMenu' => true,
            'roles' => ['Admin', 'Recruitment', 'Hroperations', 'Compliance'],
            'subMenus' => [
                [
                    'title' => 'Candidate Information ',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cfis',
                    'name' => 'cfis',
                    'roles' => ['Admin', 'Recruitment'],
                ],
                [
                    'title' => 'Approved Candidates',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.dcs_approval',
                    'name' => 'dcs_approval',
                    'roles' => ['Admin', 'Recruitment'],
                ],
                [
                    'title' => 'Rejected Candidates ',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.dcs_rejected',
                    'name' => 'dcs_rejected',
                    'roles' => ['Admin', 'Recruitment'],
                ],
                [
                    'title' => 'Hr Approved Candidates',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.hrindex',
                    'name' => 'hrindex',
                    'roles' => ['Admin', 'Hroperations'],
                ],
                [
                    'title' => 'Documents Rejected  ',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.doc_rejected',
                    'name' => 'doc_rejected',
                    'roles' => ['Admin', 'Recruitment'],
                ],
                [
                    'title' => 'Offer Letter  ',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.offer_letter',
                    'name' => 'offer_letter',
                    'roles' => ['Admin', 'Hroperations'],
                ],
                [
                    'title' => 'Increment Letter  ',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.increment_letter',
                    'name' => 'increment_letter',
                    'roles' => ['Admin', 'Hroperations'],
                ],
                [
                    'title' => 'Show Cause Letter  ',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.showcause_letter',
                    'name' => 'showcause_letter',
                    'roles' => ['Admin', 'Hroperations'],
                ],
                [
                    'title' => 'Warning Letter  ',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.warning_letter',
                    'name' => 'warning_letter',
                    'roles' => ['Admin', 'Hroperations'],
                ],
                [
                    'title' => 'Payslips  ',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.payslips',
                    'name' => 'payslips',
                    'roles' => ['Admin', 'Hroperations'],
                ],
                [
                    'title' => 'Candidates Master',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.candidatemaster',
                    'name' => 'candidatemaster',
                    'roles' => ['Admin', 'Compliance'],
                ],
                [
                    'title' => 'Candidates Lifecycle',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.candidatelifecycle',
                    'name' => 'candidatelifecycle',
                    'roles' => ['Admin', 'Hroperations'],
                ],
            ],

        ],
        [
            'title' => 'FHRMS',
            'name' => 'fhrms',
            'icon' => 'bx bxl-slack',
            'route' => '',
            'isSubMenu' => true,
            'roles' => ['Admin', 'superadmin'],
            'subMenus' => [
                [
                    'title' => 'FHRMS',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fhrms',
                    'name' => 'fhrms',
                    'roles' => ['Admin'],

                ],
                [
                    'title' => 'FHRMS Report',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fhrms_report',
                    'name' => 'fhrms_report',
                    'roles' => ['Admin'],

                ],
                [
                    'title' => 'FFI Offer Letter',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.ffi_offer_letter',
                    'name' => 'ffi_offer_letter',
                    'roles' => ['Admin'],

                ],
                [
                    'title' => 'FFI Increment Letter',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.ffi_increment_letter',
                    'name' => 'ffi_increment_letter',
                    'roles' => ['Admin'],

                ],
                [
                    'title' => 'FFI Payslips',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.ffi_payslips',
                    'name' => 'ffi_payslips',
                    'roles' => ['Admin'],
                ],
                [
                    'title' => 'FFI PIP Letter',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.ffi_pip_letter',
                    'name' => 'ffi_pip_letter',
                    'roles' => ['Admin'],
                ],
                [
                    'title' => 'FFI Termination Letter',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.ffi_termination',
                    'name' => 'ffi_termination',
                    'roles' => ['Admin'],
                ],
                [
                    'title' => 'FFI Show Cause Letter',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.ffi_show_cause',
                    'name' => 'ffi_show_cause',
                    'roles' => ['Admin'],
                ],
                [
                    'title' => 'FFI Warning Letter',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.ffi_warning',
                    'name' => 'ffi_warning',
                    'roles' => ['Admin'],
                ],
                [
                    'title' => 'Birthday Details',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fhrms.ffi_birthday',
                    'name' => 'ffi_birthday',
                    'roles' => ['Admin'],
                ],
            ],

        ],
        [
            'title' => 'CMS',
            'name' => 'cms',
            'icon' => 'bx bxl-slack',
            'route' => '',
            'isSubMenu' => true,
            'roles' => ['Admin', 'superadmin'],
            'subMenus' => [
                [
                    'title' => 'ESIC Challan',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cms.esic',
                    'name' => 'cfis',
                    'roles' => ['Admin'],
                ],
                [
                    'title' => 'PF Challan',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cms.pf',
                    'name' => 'cfis',
                    'roles' => ['Admin'],
                ],
                [
                    'title' => 'PT Challan',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cms.pt',
                    'name' => 'cfis',
                    'roles' => ['Admin'],
                ],
                [
                    'title' => 'LWF Challan',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cms.lwf',
                    'name' => 'lwf',
                    'roles' => ['Admin'],
                ],
                [
                    'title' => 'Form T Register',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cms.formt',
                    'name' => 'formt',
                    'roles' => ['Admin'],
                ],
                [
                    'title' => 'Labour Notice',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cms.labour',
                    'name' => 'labour',
                    'roles' => ['Admin'],
                ],
            ],
        ],
        [
            'title' => 'FCMS',
            'name' => 'fcms',
            'icon' => 'bx bxl-slack',
            'route' => '',
            'isSubMenu' => true,
            'roles' => ['Admin'],
            'subMenus' => [
                [
                    'title' => 'CIMS',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fcms.cims',
                    'name' => 'cims',
                    'roles' => ['Admin'],
                ],
                [
                    'title' => 'CIMS Reports',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fcms.cims.reports',
                    'name' => 'cimsreport',
                    'roles' => ['Admin'],
                ],
                [
                    'title' => 'Receivables',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fcms.receivables',
                    'name' => 'receivables',
                    'roles' => ['Admin'],
                ],
                [
                    'title' => 'Receivables Reports',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fcms.receivable.reports',
                    'name' => 'receivables_reports',
                    'roles' => ['Admin'],
                ],
                [
                    'title' => 'TDS Reports',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fcms.tds_report',
                    'name' => 'tds_report',
                    'roles' => ['Admin'],
                ],
                [
                    'title' => 'FFCM',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fcms.ffcm',
                    'name' => 'ffcm',
                    'roles' => ['Admin'],
                ],
                [
                    'title' => 'FFCM Reports',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fcms.ffcm_report',
                    'name' => 'ffcm_report',
                    'roles' => ['Admin'],
                ],
                [
                    'title' => 'FFI Assets',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fcms.ffi_assets',
                    'name' => 'ffi_assets',
                    'roles' => ['Admin'],
                ],
            ]
        ],
    ];


    public function __construct()
    {
        $this->menus = collect($this->menus);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.side-bar');
    }
}
