<div class="col-lg-10 left-area my-auto" style="position: sticky;top:0; z-index: 3;">
    <div class="row align-items-center">
        <div class="col-lg-12">
            {{-- @if (!request()->is('admin/dashboard'))
                <div class="sopt back-button" onclick="history.back()"
                    style="display: inline-flex; align-items: center; padding: 8px 12px; cursor: pointer; font-size: 16px; color: #333; border: 1px solid #ccc; border-radius: 4px; width: fit-content;">
                    <i class='bx bx-arrow-back' style="font-size: 20px; margin-right: 6px;"></i> Back
                </div>
            @endif --}}


        </div>
    </div>
</div>
<div class="col-lg-2 right-area">
    <h6 class="me-3 pt-2">{{ auth()->user()->name }}</h6>
    <div class="profile-icon">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTscz0eljIO4sQ0qkfpLJrgtl6Kvryp-DA-Hw&usqp=CAU"
            alt="">
    </div>
    <ul class="profile-drop" style="display: none;">
        <li>
            <form action="{{ route('admin.logout') }}" id="logoutForm" method="POST">
                @csrf
                <a onclick="document.getElementById('logoutForm').submit()">Logout</a>
            </form>
        </li>
    </ul>
</div>
