@include('cpanel.parts.auth-page-controls', [
    'navigations' => [
        ['link' => '/department/payroll/'.$department['ID'], 'label' => 'Payroll', 'permission' => 'VIEW_PAYROLL'],
        ['link' => '/department/attendance/'.$department['ID'], 'label' => 'Attendance', 'permission' => 'VIEW_ATTENDANCE'],
        ['link' => '/department/documents/'.$department['ID'], 'label' => 'Documents', 'permission' => 'VIEW_DOCUMENTS'],
        ['link' => '/department/debug/'.$department['ID'], 'label' => 'Debug', 'permission' => 'DEBUG_ATTENDANCE']
    ] 
])