@if (session('success'))
    <div class="mb-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-300 flex items-start gap-3 shadow-lg shadow-emerald-500/5 animate-fade-in">
        <div class="w-8 h-8 rounded-xl bg-emerald-500/20 flex items-center justify-center shrink-0 text-emerald-400">
            <i class="fa-solid fa-circle-check text-base"></i>
        </div>
        <div class="flex-1 text-sm font-medium pt-1">
            {{ session('success') }}
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-400/60 hover:text-emerald-300 p-1">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
@endif

@if (session('error'))
    <div class="mb-6 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-300 flex items-start gap-3 shadow-lg shadow-rose-500/5 animate-fade-in">
        <div class="w-8 h-8 rounded-xl bg-rose-500/20 flex items-center justify-center shrink-0 text-rose-400">
            <i class="fa-solid fa-triangle-exclamation text-base"></i>
        </div>
        <div class="flex-1 text-sm font-medium pt-1">
            {{ session('error') }}
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-rose-400/60 hover:text-rose-300 p-1">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-300 shadow-lg shadow-rose-500/5 animate-fade-in">
        <div class="flex items-center gap-3 mb-2 font-semibold text-sm">
            <i class="fa-solid fa-circle-exclamation text-rose-400"></i>
            <span>Vui lòng kiểm tra lại thông tin gửi lên:</span>
        </div>
        <ul class="text-xs space-y-1 pl-6 list-disc text-rose-300/80">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
