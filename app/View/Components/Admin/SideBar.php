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
        ],
        [
            'title' => 'FFI Masters',
            'name' => 'masters',
            'icon' => '  bx bxl-slack',
            'route' => 'admin.ffimasters',
            'isSubMenu' => true,
            'subMenus' => [
                [
                    'title' => 'User Masters',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.usermasters',
                    'name' => 'usermasters',
                ],
                [
                    'title' => 'TDS code',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.tds_code',
                    'name' => 'tds_code',
                ],
                [
                    'title' => 'Letter Content',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.letter_content',
                    'name' => 'letter_content',
                ],
            ],

        ],
        [
            'title' => 'CDMS',
            'name' => 'cdms',
            'icon' => '  bx bxl-slack',
            'route' => '',
            'isSubMenu' => true,
            'subMenus' => [
                [
                    'title' => 'CDMS',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cdms',
                    'name' => 'cdms',
                ],
                [
                    'title' => 'CDMS Report',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cdms_report',
                    'name' => 'cdms_report',
                ],

            ],

        ],
        [
            'title' => 'ADMS',
            'name' => 'adms',
            'icon' => '  bx bxl-slack',
            'route' => '',
            'isSubMenu' => true,
            'subMenus' => [
                [
                    'title' => 'CFIS',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cfis',
                    'name' => 'cfis',
                ],
                [
                    'title' => 'DCS Approval',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.dcs_approval',
                    'name' => 'dcs_approval',
                ],

            ],

        ],
        [
            'title' => 'FHRMS',
            'name' => 'fhrms',
            'icon' => 'bx bxl-slack',
            'route' => '',
            'isSubMenu' => true,
            'subMenus' => [
                [
                    'title' => 'FHRMS',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fhrms',
                    'name' => 'fhrms',
                ],
                [
                    'title' => 'FHRMS Report',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fhrms_report',
                    'name' => 'fhrms_report',
                ],
                [
                    'title' => 'FFI Offer Letter',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.ffi_offer_letter',
                    'name' => 'ffi_offer_letter',
                ],
                [
                    'title' => 'FFI Increment Letter',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.ffi_increment_letter',
                    'name' => 'ffi_increment_letter',
                ],
                [
                    'title' => 'FFI Termination Letter',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.ffi_termination',
                    'name' => 'ffi_termination',
                ],
                [
                    'title' => 'FFI Warning Letter',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.ffi_warning',
                    'name' => 'ffi_warning',
                ],
                [
                    'title' => 'FFI Show Cause Letter',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.ffi_show_cause',
                    'name' => 'ffi_show_cause',
                ],
                [
                    'title' => 'FFI PIP Letter',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.ffi_pip_letter',
                    'name' => 'ffi_pip_letter',
                ],
                [
                    'title' => 'FFI Payslips',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.ffi_payslips',
                    'name' => 'ffi_payslips',
                ],
                [
                    'title' => 'FFI Birthdays',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fhrms.ffi_birthday',
                    'name' => 'ffi_birthday',
                ],
            ],

        ],
        [
            'title' => 'CMS',
            'name' => 'cms',
            'icon' => 'bx bxl-slack',
            'route' => '',
            'isSubMenu' => true,
            'subMenus' => [
                [
                    'title' => 'ESIC Challan',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cms.esic',
                    'name' => 'cfis',
                ],
                [
                    'title' => 'PF Challan',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cms.pf',
                    'name' => 'cfis',
                ],
                [
                    'title' => 'PT Challan',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cms.pt',
                    'name' => 'cfis',
                ],
                [
                    'title' => 'LWF Challan',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cms.lwf',
                    'name' => 'lwf',
                ],
                [
                    'title' => 'Form T Register',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cms.formt',
                    'name' => 'formt',
                ],
                [
                    'title' => 'Labour Notice',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.cms.labour',
                    'name' => 'labour',
                ],
            ],
        ],
        [
            'title' => 'FCMS',
            'name' => 'fcms',
            'icon' => 'bx bxl-slack',
            'route' => '',
            'isSubMenu' => true,
            'subMenus' => [
                [
                    'title' => 'CIMS',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fcms.cims',
                    'name' => 'cims',
                ],
                [
                    'title' => 'CIMS Reports',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fcms.cims.reports',
                    'name' => 'cimsreport',
                ],
                [
                    'title' => 'TDS Reports',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fcms.tds_report',
                    'name' => 'tds_report',
                ],
                [
                    'title' => 'FFCM',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fcms.ffcm',
                    'name' => 'ffcm',
                ],
                [
                    'title' => 'FFCM Reports',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fcms.ffcm_report',
                    'name' => 'ffcm_report',
                ],
                [
                    'title' => 'FFI Assets',
                    'icon' => 'bx bx-chevron-right',
                    'route' => 'admin.fcms.ffi_assets',
                    'name' => 'ffi_assets',
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
