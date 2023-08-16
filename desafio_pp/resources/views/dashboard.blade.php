<x-app-layout>
        <div class="min-h-screen p-6 bg-gray-100 flex items-center justify-center">
            <div class="container max-w-screen-lg mx-auto">
            <div>        
                <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                <div class="grid text-sm grid-cols-1">
                    @include('components.payment')
                </div>    

                <div class="grid text-sm grid-cols-1">
                
                    <form action="{{route('payment') }}" method="post" x-data="{ payment_method: '{{ old('payment_method', 'BOLETO') }}' }" >
                        @include('components.form')
                    </form>
                </div>
                </div>
            </div>
            </div>
        </div>
</x-app-layout>
