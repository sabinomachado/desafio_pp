<div class="text-gray-600 text-center">
    <p class="font-medium text-lg">Detalhes do Pagamento</p>
        @if(session('message'))          
            <div role="alert">
                <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                Não foi possível realizar o pagamento
                </div>
                <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                <p>{{ session('message') }}</p>
                </div>
            </div>
        @endif
</div>