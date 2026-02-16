@hasSection('breadcrumb')
<div class="bg-white border-b border-gray-200 py-3 px-6">
    <div class="flex items-center text-sm">
        <a href="/admin" class="text-gray-500 hover:text-[#86662c] transition-colors">
            <i class="fa-solid fa-home"></i>
        </a>
        @yield('breadcrumb')
    </div>
</div>
@endif