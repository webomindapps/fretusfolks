<x-applayout>
    <x-admin.breadcrumb title=" Client Database Management System" />
    <div class="col-lg-12 mt-4">
        <div class="form-card">
            <div class="row mb-2">
                <div class="col-lg-5 my-auto text-end ms-auto">
                    </a>
                    <a href="{{ route('admin.cdms.create') }}" class="add-btn bg-success text-white">
                        New Client
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            @php
            $columns = [
                ['label' => 'Id', 'column' => 'id', 'sort' => true],
                ['label' => 'Client Name', 'column' => 'client_name', 'sort' => true],
                ['label' => 'Contact Person', 'column' => 'contact_person', 'sort' => true],
                ['label' => 'Contact Person Phone', 'column' => 'contact_person_phone', 'sort' => true],
                ['label' => 'Contact Person Email', 'column' => 'contact_person_email', 'sort' => true],
                ['label' => 'Actions', 'column' => 'action', 'sort' => false],
            ];
        @endphp     
        </div>
    </div>
</x-applayout>
