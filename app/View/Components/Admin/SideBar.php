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
            'roles' => ['Admin', 'Finance', 'HR Operations', 'Compliance', 'Recruitment', 'Sales'],
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
            'roles' => ['Admin', 'Recruitment', 'HR Operations', 'Compliance'],
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
                    'roles' => ['Admin', 'Recruitment', 'HR Operations'],
                ],
                [
                    'title' => 'Rejected Candidates ',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.dcs_rejected',
                    'name' => 'dcs_rejected',
                    'roles' => ['Admin', 'Recruitment', 'HR Operations'],
                ],

                [
                    'title' => 'Candidates Master',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.candidatemaster',
                    'name' => 'candidatemaster',
                    'roles' => ['Admin', 'Compliance', 'HR Operations'],
                ],
                [
                    'title' => 'Bank Details',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.pendingbankapprovals',
                    'name' => 'pending-bank-approval',
                    'roles' => ['Admin', 'Compliance'],
                ],
                [
                    'title' => 'Candidates Lifecycle',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.candidatelifecycle',
                    'name' => 'candidatelifecycle',
                    'roles' => ['Admin', 'HR Operations'],
                ],

                [
                    'title' => 'Bulk Exit Update',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cfisbulk',
                    'name' => 'cfisbulk',
                    'roles' => ['Admin', 'HR Operations'],
                ],

                [
                    'title' => 'ADMS Trashed',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.dcs_approval.trashed',
                    'name' => 'adms trashed',
                    'roles' => ['Admin'],
                ],

            ],

        ],
        [
            'title' => 'HRADMS',
            'name' => 'hradms',
            'icon' => '  bx bxl-slack',
            'route' => '',
            'isSubMenu' => true,
            'roles' => ['Admin', 'Recruitment', 'HR Operations'],
            'subMenus' => [
                [
                    'title' => 'Hr Approved Candidates',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.hrindex',
                    'name' => 'hrindex',
                    'roles' => ['Admin', 'HR Operations'],
                ],
                [
                    'title' => 'Documents Rejected  ',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.doc_rejected',
                    'name' => 'doc_rejected',
                    'roles' => ['Admin', 'Recruitment', 'HR Operations'],
                ],
            ]
        ],
        [
            'title' => 'ADMS Letters',
            'name' => 'admsletters',
            'icon' => '  bx bxl-slack',
            'route' => '',
            'isSubMenu' => true,
            'roles' => ['Admin', 'HR Operations'],
            'subMenus' => [
                [
                    'title' => 'Offer/Appointment Letter  ',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.offer_letter',
                    'name' => 'offer_letter',
                    'roles' => ['Admin', 'HR Operations'],
                ],
                [
                    'title' => 'Increment Letter  ',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.increment_letter',
                    'name' => 'increment_letter',
                    'roles' => ['Admin', 'HR Operations'],
                ],
                [
                    'title' => 'PIP Letter  ',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.pip_letter',
                    'name' => 'pip_letter',
                    'roles' => ['Admin', 'HR Operations'],
                ],
                [
                    'title' => 'Show Cause Letter  ',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.showcause_letter',
                    'name' => 'showcause_letter',
                    'roles' => ['Admin', 'HR Operations'],
                ],
                [
                    'title' => 'Warning Letter  ',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.warning_letter',
                    'name' => 'warning_letter',
                    'roles' => ['Admin', 'HR Operations'],
                ],
                [
                    'title' => 'Termination Letter',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.termination_letter',
                    'name' => 'termination_letter',
                    'roles' => ['Admin', 'HR Operations'],
                ],

            ]
        ],
        [
            'title' => 'ADMS Payslip',
            'icon' => 'bx bx-grid-alt',
            'route' => 'admin.payslips',
            'name' => 'admspayslips',
            'isSubMenu' => false,
            'roles' => ['Admin', 'HR Operations'],
        ],
        [
            'title' => 'ADMS Manual Payslip',
            'icon' => 'bx bx-grid-alt',
            'route' => 'admin.other_payslips',
            'name' => 'admsotherpayslips',
            'isSubMenu' => false,
            'roles' => ['Admin', 'HR Operations'],
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
                [
                    'title' => 'FHRMS Trashed',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fhrms.trashed',
                    'name' => 'trashed',
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
            'roles' => ['Admin', 'superadmin', 'Compliance'],
            'subMenus' => [
                [
                    'title' => 'ESIC Challan',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cms.esic',
                    'name' => 'cfis',
                    'roles' => ['Admin', 'Compliance'],
                ],
                [
                    'title' => 'PF Challan',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cms.pf',
                    'name' => 'cfis',
                    'roles' => ['Admin', 'Compliance'],
                ],
                [
                    'title' => 'PT Challan',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cms.pt',
                    'name' => 'cfis',
                    'roles' => ['Admin', 'Compliance'],
                ],
                [
                    'title' => 'LWF Challan',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cms.lwf',
                    'name' => 'lwf',
                    'roles' => ['Admin', 'Compliance'],
                ],
                [
                    'title' => 'Form T Register',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cms.formt',
                    'name' => 'formt',
                    'roles' => ['Admin', 'Compliance'],
                ],
                [
                    'title' => 'Labour Notice',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cms.labour',
                    'name' => 'labour',
                    'roles' => ['Admin', 'Compliance'],
                ],
                [
                    'title' => 'CLRA',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cms.clra',
                    'name' => 'clra',
                    'roles' => ['Admin', 'Compliance'],
                ],
                [
                    'title' => 'Others',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cms.others',
                    'name' => 'others',
                    'roles' => ['Admin', 'Compliance'],
                ],
            ],
        ],
        [
            'title' => 'FCMS',
            'name' => 'fcms',
            'icon' => 'bx bxl-slack',
            'route' => '',
            'isSubMenu' => true,
            'roles' => ['Admin', 'Finance'],
            'subMenus' => [
                [
                    'title' => 'CIMS',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fcms.cims',
                    'name' => 'cims',
                    'roles' => ['Admin', 'Finance'],
                ],
                [
                    'title' => 'CIMS Reports',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fcms.cims.reports',
                    'name' => 'cimsreport',
                    'roles' => ['Admin', 'Finance'],
                ],
                [
                    'title' => 'Receivables',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fcms.receivables',
                    'name' => 'receivables',
                    'roles' => ['Admin', 'Finance'],
                ],
                [
                    'title' => 'Receivables Reports',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fcms.receivable.reports',
                    'name' => 'receivables_reports',
                    'roles' => ['Admin', 'Finance'],
                ],
                [
                    'title' => 'TDS Reports',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fcms.tds_report',
                    'name' => 'tds_report',
                    'roles' => ['Admin', 'Finance'],
                ],
                [
                    'title' => 'FFCM',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fcms.ffcm',
                    'name' => 'ffcm',
                    'roles' => ['Admin', 'Finance'],
                ],
                [
                    'title' => 'FFCM Reports',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fcms.ffcm_report',
                    'name' => 'ffcm_report',
                    'roles' => ['Admin', 'Finance'],
                ],
                [
                    'title' => 'FFI Assets',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fcms.ffi_assets',
                    'name' => 'ffi_assets',
                    'roles' => ['Admin', 'Finance'],
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
